<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'user_id', 
        'product_id',
        'quantity',
        'total_price',
        'total_tax_amount',
        'coupon_discount_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'order_type',
        'delivery_address',
        'delivery_man_id',
        'order_date',
    ];

    // Define relationships with User and Product models
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
