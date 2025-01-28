<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealers extends Model
{
    use HasFactory;

     protected $fillable = [
        'f_name',
        'l_name',
        'address',
        'phone',
        'email',
        'logo',
        'store_name',
        'module_id',
        'zone_id',
        'status',
        'latitude',
        'longitude',
    ];

    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}

