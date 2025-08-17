<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

//for download
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Barryvdh\DomPDF\Facade\Pdf;


class MemberController extends Controller
{
    public function index()
    {
        $members = Member::latest()->get();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    // -------------------------------
    // Manual add voter
    // -------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'voter_id'    => 'required|string|unique:members,voter_id',
            'gender'      => 'required|string',
            'village'     => 'required|string|max:255',
            'post'        => 'required|string|max:255',
            'panchayath'  => 'required|string|max:255',
            'mandal'      => 'required|string|max:255',
            'state'       => 'required|string|max:255',
            'voter_card'  => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $filename = null;
        if ($request->hasFile('voter_card')) {
            $file = $request->file('voter_card');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/voter_card'), $filename);
        }

        $member = new Member();
        $member->name        = $request->name;
        $member->father_name = $request->father_name;
        $member->voter_id    = $request->voter_id;
        $member->gender      = $request->gender;
        $member->village     = $request->village;
        $member->post        = $request->post;
        $member->panchayath  = $request->panchayath;
        $member->mandal      = $request->mandal;
        $member->state       = $request->state;
        $member->voter_card  = 'images/voter_card/'.$filename;
        $member->save();

        return redirect()->back()->with('success', 'Voter added successfully!');
    }

    // -------------------------------
    // Update voter
    // -------------------------------
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'father_name'=>'required',
            'voter_id'=>"required|unique:members,voter_id,{$id}",
            'gender'=>'required',
            'village'=>'required',
            'post'=>'required',
            'panchayath'=>'required',
            'mandal'=>'required',
            'state'=>'required',
            'voter_card'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('voter_card');

        if ($request->hasFile('voter_card')) {
            $file = $request->file('voter_card');

            // Ensure the folder exists
            if (!File::exists(public_path('images/voter_card'))) {
                File::makeDirectory(public_path('images/voter_card'), 0755, true);
            }

            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/voter_card'), $filename);

            // Delete old file if exists
            if ($member->voter_card && File::exists(public_path($member->voter_card))) {
                File::delete(public_path($member->voter_card));
            }

            $data['voter_card'] = 'images/voter_card/'.$filename;
        }

        $member->update($data);
        return response()->json(['success'=>true,'message'=>'Member updated successfully.']);
    }


    // -------------------------------
    // Delete voter
    // -------------------------------
    public function destroy($id)
    {
        $member = Member::find($id);
        if (!$member) return response()->json(['success'=>false,'message'=>'Member not found'],404);

        if ($member->voter_card && File::exists(public_path($member->voter_card))) {
            File::delete(public_path($member->voter_card));
        }

        $member->delete();
        return response()->json(['success'=>true]);
    }

    // -------------------------------
    // Delete all members + images
    // -------------------------------
    public function deleteAllMembers()
    {
        $members = Member::all();
        foreach ($members as $member) {
            if ($member->voter_card && File::exists(public_path($member->voter_card))) {
                File::delete(public_path($member->voter_card));
            }
        }

        Member::truncate();
        return back()->with('success','All members and their images have been deleted.');
    }

    // -------------------------------
    // Excel import with images
    // -------------------------------
    public function import(Request $request)
    {
        $request->validate([
            'file'=>'required|file|max:51200',
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());

        if (!in_array($ext,['xls','xlsx'])) {
            return back()->with('error','Only .xls or .xlsx files are allowed.');
        }

        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = [];
        $images = [];

        // Extract images from Excel
        foreach ($sheet->getDrawingCollection() as $drawing) {
            $coordinates = $drawing->getCoordinates();
            if ($drawing instanceof MemoryDrawing) {
                ob_start();
                call_user_func($drawing->getRenderingFunction(), $drawing->getImageResource());
                $imageContents = ob_get_clean();
                $images[$coordinates] = $imageContents;
            } elseif (method_exists($drawing,'getPath')) {
                $path = $drawing->getPath();
                $images[$coordinates] = file_get_contents($path);
            }
        }

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $headerRow = $sheet->rangeToArray('A1:'.$highestColumn.'1',NULL,TRUE,FALSE)[0];
        $headerRow = array_map('strtolower',$headerRow);

        for ($row=2;$row<=$highestRow;$row++) {
            $line = $sheet->rangeToArray('A'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE)[0];
            $rowData = array_combine($headerRow,$line);

            if (empty($rowData['name']) || empty($rowData['father_name']) || empty($rowData['voter_id'])) continue;

            $cell = 'J'.$row; // assuming image column is J
            if (isset($images[$cell])) {
                $filename = 'voter_card_'.time().'_'.$row.'.png';
                file_put_contents(public_path('images/voter_card/'.$filename), $images[$cell]);
                $rowData['voter_card'] = 'images/voter_card/'.$filename;
            } else {
                $rowData['voter_card'] = 'N/A';
            }

            $rows[] = $rowData;
        }

        if (empty($rows)) return back()->with('error','No valid rows found in Excel.');

        $updateColumns = ['name','father_name','gender','village','post','panchayath','mandal','state','voter_card'];

        DB::beginTransaction();
        try {
            $chunks = array_chunk($rows,500);
            foreach ($chunks as $chunk) {
                Member::upsert($chunk,['voter_id'],$updateColumns);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error','Import failed: '.$e->getMessage());
        }

        return back()->with('success','File upload successfully.');
    }

    // -------------------------------
    // AJAX upload voter card
    // -------------------------------
    public function uploadCard(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'voter_card' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $file = $request->file('voter_card');

        // Ensure folder exists
        if (!File::exists(public_path('images/voter_card'))) {
            File::makeDirectory(public_path('images/voter_card'), 0755, true);
        }

        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('images/voter_card'), $filename);

        // Delete old file
        if ($member->voter_card && File::exists(public_path($member->voter_card))) {
            File::delete(public_path($member->voter_card));
        }

        $member->voter_card = 'images/voter_card/'.$filename;
        $member->save();

        return response()->json(['success' => true, 'path' => asset($member->voter_card)]);
    }

    // -------------------------------
    // Download members
    // -------------------------------
    public function download(Request $request)
    {
        $request->validate([
            'fileType' => 'required|in:excel,csv,pdf',
            'imageOption' => 'nullable|in:with,without,url',
            'searchQuery' => 'nullable|string'
        ]);

        $fileType = $request->fileType;
        $imageOption = $request->imageOption ?? 'without';
        $searchQuery = $request->searchQuery ?? '';

        $members = Member::query();

        if ($searchQuery) {
            $members = $members->where(function($q) use ($searchQuery) {
                $q->where('name','like','%'.$searchQuery.'%')
                ->orWhere('father_name','like','%'.$searchQuery.'%')
                ->orWhere('voter_id','like','%'.$searchQuery.'%')
                ->orWhere('gender','like','%'.$searchQuery.'%')
                ->orWhere('village','like','%'.$searchQuery.'%')
                ->orWhere('post','like','%'.$searchQuery.'%')
                ->orWhere('panchayath','like','%'.$searchQuery.'%')
                ->orWhere('mandal','like','%'.$searchQuery.'%')
                ->orWhere('state','like','%'.$searchQuery.'%');
            });
        }

        $members = $members->get();

        // Excel / CSV
        if ($fileType === 'excel' || $fileType === 'csv') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Members');

            $headers = ['#','Name','Father Name','Voter ID','Gender','Village','Post','Panchayath','Mandal','State','Voter Card'];
            $sheet->fromArray($headers, NULL, 'A1');

            $rowIndex = 2;
            foreach ($members as $i => $m) {
                $sheet->setCellValue("A{$rowIndex}", $i+1);
                $sheet->setCellValue("B{$rowIndex}", $m->name);
                $sheet->setCellValue("C{$rowIndex}", $m->father_name);
                $sheet->setCellValue("D{$rowIndex}", $m->voter_id);
                $sheet->setCellValue("E{$rowIndex}", $m->gender);
                $sheet->setCellValue("F{$rowIndex}", $m->village);
                $sheet->setCellValue("G{$rowIndex}", $m->post);
                $sheet->setCellValue("H{$rowIndex}", $m->panchayath);
                $sheet->setCellValue("I{$rowIndex}", $m->mandal);
                $sheet->setCellValue("J{$rowIndex}", $m->state);

                if ($imageOption === 'with' && $m->voter_card && File::exists(public_path($m->voter_card))) {
                    $drawing = new Drawing();
                    $drawing->setPath(public_path($m->voter_card));
                    $drawing->setHeight(60);
                    $drawing->setCoordinates("K{$rowIndex}");
                    $drawing->setWorksheet($sheet);
                } elseif ($imageOption === 'url') {
                    $sheet->setCellValue("K{$rowIndex}", asset($m->voter_card));
                } else {
                    $sheet->setCellValue("K{$rowIndex}", 'N/A');
                }

                $rowIndex++;
            }

            if ($fileType === 'excel') {
                $writer = new Xlsx($spreadsheet);
                $fileName = 'members.xlsx';
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            } else {
                $writer = new Csv($spreadsheet);
                $fileName = 'members.csv';
                header('Content-Type: text/csv');
            }

            header("Content-Disposition: attachment; filename=\"{$fileName}\"");
            $writer->save('php://output');
            exit;
        }

        // PDF
        if ($fileType === 'pdf') {
            return Pdf::loadView('members.download_pdf', [
                    'pdfData' => $members,
                    'imageOption' => $imageOption
                ])->download('members.pdf');
        }
    }



}
