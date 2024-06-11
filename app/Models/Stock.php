<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'ref_no',
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
