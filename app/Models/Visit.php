<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'store_name',
        'store_code',
        'so_code',
        'image',
        'in_date',
        'in_time',
        'in_lat',
        'in_long',
        'out_date',
        'out_time',
        'out_lat',
        'out_long',
        'user_login',
        'user_id',
        'note'
    ];

    protected $casts = [
        'user_login' => 'array'
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'visit_id', 'id');
    }
}
