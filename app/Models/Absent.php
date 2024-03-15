<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'store_name',
        'date',
        'time',
        'type',
        'image',
        'latt',
        'long',
        'user_login'
    ];
}
