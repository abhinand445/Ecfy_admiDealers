<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'tax_amount',
        'discount_amount',
        'total_price',
    ];

    // Order relationship
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Product relationship
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
