<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'contact',
        'role',
        'password'
    ];

    protected $hidden = [
        'password',
    ];
}


