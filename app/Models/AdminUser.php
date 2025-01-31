<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;


class AdminUser extends Authenticatable
{


    use HasApiTokens, HasApiTokens,  Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role'];

 

    
}