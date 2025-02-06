<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'name',
        'coordinates',
        'status',
        'store_wise_topic',
        'customer_wise_topic',
        'deliveryman_wise_topic',
        'cash_on_delivery',
        'digital_payment',
        'increased_delivery_fee',
        'increased_delivery_fee_status',
        'increase_delivery_charge_message',
        'offline_payment'
    ];
}
