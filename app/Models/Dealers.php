<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Dealers extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable; 

    protected $fillable = [
        'f_name',
        'l_name',
        'address',
        'phone',
        'email',
        'password',
        'module_id',
        'zone_id',
        'status',
        'latitude',
        'longitude',
    ];

    protected $hidden = [
        'password', 'remember_token',
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
