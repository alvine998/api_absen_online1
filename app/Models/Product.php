<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'qty',
        'min_price',
        'price',
        'note'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
