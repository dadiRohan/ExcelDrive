<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'emp_id',
        'name',
        'email',
        'phone',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public $timestamps = true;        
}
