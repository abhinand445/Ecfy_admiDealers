<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';

       protected $fillable = [
        'name',
        'quantity',
        'qty_type',
        'description',
        'price',
        'category_id',
        'sub_category',
        'image', 
    ];

}
