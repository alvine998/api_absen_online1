<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSales extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'store_name',
        'store_code',
        'user_id',
        'user_name'
    ];
}
