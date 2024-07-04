<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'so_code',
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

    public function visits()
    {
        return $this->belongsTo(Visit::class, 'visit_id', 'id');
    }

    public function generateSoCode()
    {
        $datePart = date('ymd');
        $lastOrder = static::where('so_code', 'like', "SO{$datePart}-%")->orderBy('so_code', 'desc')->first();

        if (!$lastOrder) {
            $number = 1;
        } else {
            $lastNumber = (int)substr($lastOrder->so_code, 9);
            $number = $lastNumber + 1;
        }

        return sprintf("SO%s-%04d", $datePart, $number);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->so_code = $model->generateSoCode();
        });
    }
}
