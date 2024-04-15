<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memberspv extends Model
{
    use HasFactory;

    protected $fillable = [
        'spv_id',
        'spv_name',
        'user_id',
        'user_name'
    ];
}
