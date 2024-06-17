<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref_no',
        'visit_id',
        'user_id',
        'user_name',
        'store_id',
        'store_name',
        'store_code',
        'products',
        'total_price',
        'total_qty'
    ];

    protected $casts = [
        'products' => 'array',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
