<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Dealers extends Model
{
    //

     use HasFactory;

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

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

      public function modules()
    {
        return $this->belongsTo(Modules::class);
    }
}
