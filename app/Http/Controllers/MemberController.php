<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'father_name' => 'required',
            'voter_id'    => 'required|unique:members,voter_id',
            'gender'      => 'required',
            'village'     => 'required',
            'post'        => 'required',
            'panchayath'  => 'required',
            'mandal'      => 'required',
            'state'       => 'required',
            'voter_card'  => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('voter_card')) {
            $filename = time().'_'.$request->file('voter_card')->getClientOriginalName();
            $request->file('voter_card')->move(public_path('images/voter_cards'), $filename);
            $filePath = 'images/voter_cards/' . $filename;
        }

        Member::create([
            'name'        => $request->name,
            'father_name' => $request->father_name,
            'voter_id'    => $request->voter_id,
            'gender'      => $request->gender,
            'village'     => $request->village,
            'post'        => $request->post,
            'panchayath'  => $request->panchayath,
            'mandal'      => $request->mandal,
            'state'       => $request->state,
            'voter_card'  => $filePath ?? 'N/A', // default if missing
        ]);

        return redirect()->route('members.index')->with('success', 'Member added successfully.');
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'name'        => 'required',
            'father_name' => 'required',
            'voter_id'    => "required|unique:members,voter_id,{$id}",
            'gender'      => 'required',
            'village'     => 'required',
            'post'        => 'required',
            'panchayath'  => 'required',
            'mandal'      => 'required',
            'state'       => 'required',
            'voter_card'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $updatedData = $request->only([
            'name', 'father_name', 'voter_id', 'gender', 'village',
            'post', 'panchayath', 'mandal', 'state'
        ]);

        if ($request->hasFile('voter_card')) {
            $filename = time().'_'.$request->file('voter_card')->getClientOriginalName();
            $request->file('voter_card')->move(public_path('images/voter_cards'), $filename);
            $updatedData['voter_card'] = 'images/voter_cards/' . $filename;

            if ($member->voter_card && file_exists(public_path($member->voter_card)) && $member->voter_card !== 'N/A') {
                @unlink(public_path($member->voter_card));
            }
        }

        $member->update($updatedData);

        return response()->json([
            'success' => true,
            'message' => 'Member updated successfully.'
        ]);
    }

    public function destroy($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found'], 404);
        }

        if ($member->voter_card && file_exists(public_path($member->voter_card)) && $member->voter_card !== 'N/A') {
            unlink(public_path($member->voter_card));
        }

        $member->delete();
        return response()->json(['success' => true]);
    }

    public function bulkUpsert(Request $request)
    {
        $data = $request->input('members', []);
        if (empty($data)) {
            return response()->json(['success' => false, 'message' => 'No members provided'], 422);
        }

        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                'id'          => $item['id'] ?? null,
                'name'        => $item['name'] ?? null,
                'father_name' => $item['father_name'] ?? null,
                'voter_id'    => $item['voter_id'] ?? null,
                'gender'      => $item['gender'] ?? null,
                'village'     => $item['village'] ?? null,
                'post'        => $item['post'] ?? null,
                'panchayath'  => $item['panchayath'] ?? null,
                'mandal'      => $item['mandal'] ?? null,
                'state'       => $item['state'] ?? null,
                'voter_card'  => $item['voter_card'] ?? 'N/A',
            ];
        }

        foreach ($rows as $idx => $r) {
            if (empty($r['voter_id']) || empty($r['name'])) {
                return response()->json([
                    'success' => false,
                    'message' => "Row " . ($idx+1) . " missing required fields."
                ], 422);
            }
        }

        $updateColumns = ['name','father_name','gender','village','post','panchayath','mandal','state','voter_card'];

        $upsertRows = array_map(function($r){
            if (empty($r['id'])) unset($r['id']);
            return $r;
        }, $rows);

        $chunks = array_chunk($upsertRows, 500);
        DB::beginTransaction();
        try {
            foreach ($chunks as $chunk) {
                Member::upsert($chunk, ['voter_id'], $updateColumns);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Bulk upsert failed: '.$e->getMessage()], 500);
        }

        return response()->json(['success' => true, 'message' => 'Bulk upsert completed.']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:51200',
        ]);

        $file = $request->file('file');
        $ext = strtolower($file->getClientOriginalExtension());
        $rows = [];

       if (in_array($ext, ['xls','xlsx'])) {
    try {
        $array = Excel::toArray(null, $file);
        $sheet = $array[0] ?? [];
        $header = array_map('strtolower', $sheet[0] ?? []);
        foreach (array_slice($sheet, 1) as $line) {
            // Match column count
            if (count($header) !== count($line)) {
                continue; // skip invalid rows
            }
            $rows[] = array_combine($header, $line);
        }
    } catch (\Throwable $e) {
        return back()->with('error', 'Excel import failed: '.$e->getMessage());
    }
} else {
    if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
        $header = null;
        while (($data = fgetcsv($handle, 0, ",")) !== false) {
            if (!$header) {
                $header = array_map('strtolower', $data);
                continue;
            }
            if (count($header) !== count($data)) {
                continue; // skip invalid rows
            }
            $rows[] = array_combine($header, $data);
        }
        fclose($handle);
    }
}


        $normalized = [];
        foreach ($rows as $r) {
            $map = array_change_key_case($r, CASE_LOWER);
            $normalized[] = [
                'name'        => $map['name'] ?? null,
                'father_name' => $map['father_name'] ?? null,
                'voter_id'    => $map['voter_id'] ?? null,
                'gender'      => $map['gender'] ?? null,
                'village'     => $map['village'] ?? null,
                'post'        => $map['post'] ?? null,
                'panchayath'  => $map['panchayath'] ?? null,
                'mandal'      => $map['mandal'] ?? null,
                'state'       => $map['state'] ?? null,
                'voter_card'  => 'N/A',
            ];
        }

        if (empty($normalized)) {
            return back()->with('error', 'No rows to import or invalid file headers.');
        }

        $chunks = array_chunk($normalized, 500);
        DB::beginTransaction();
        try {
            foreach ($chunks as $chunk) {
                Member::upsert($chunk, ['voter_id'], ['name','father_name','gender','village','post','panchayath','mandal','state','voter_card']);
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Import failed: '.$e->getMessage());
        }

        return back()->with('success', 'File imported successfully.');
    }

    public function uploadCard(Request $request, Member $member)
    {
        $request->validate([
            'voter_card' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('voter_card')) {
            $filename = time().'_'.$request->file('voter_card')->getClientOriginalName();
            $request->file('voter_card')->move(public_path('images/voter_cards'), $filename);
            $path = 'images/voter_cards/' . $filename;

            if ($member->voter_card && file_exists(public_path($member->voter_card)) && $member->voter_card !== 'N/A') {
                @unlink(public_path($member->voter_card));
            }

            $member->voter_card = $path;
            $member->save();

            return response()->json(['success' => true, 'path' => asset($path)]);
        }

        return response()->json(['success' => false, 'message' => 'No file uploaded'], 422);
    }
}

function is_associative_array($arr) {
    if (!is_array($arr)) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}
