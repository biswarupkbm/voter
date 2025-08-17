<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactQuery extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'message'];

    // Specify the table name (if it differs from the default plural model name)
    protected $table = 'contacts';
}
