<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
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
