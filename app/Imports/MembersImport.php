<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;

class MembersImport implements ToModel
{
    public function model(array $row)
    {
        return new Member([
            'name'        => $row[0],
            'father_name' => $row[1],
            'voter_id'    => $row[2],
            'gender'      => $row[3],
            'village'     => $row[4],
            'post'        => $row[5],
            'panchayath'  => $row[6],
            'mandal'      => $row[7],
            'state'       => $row[8],
            'voter_card'  => $row[9],
        ]);
    }
}
