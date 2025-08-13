<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'father_name',
        'voter_id',
        'gender',
        'village',
        'post',
        'panchayath',
        'mandal',
        'state',
        'voter_card'
    ];
}
