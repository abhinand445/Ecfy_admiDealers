<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class zone extends Model
{
    //
         use HasFactory;

       protected $table = 'zones'; 


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
