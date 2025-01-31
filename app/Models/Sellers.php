<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Sellers extends Model
{
    //

     use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'dealer_id',
    ];

    // Relationship: A seller belongs to a dealer (User)
    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    // Relationship: A seller is also a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
