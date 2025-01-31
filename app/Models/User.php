<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    // Define which fields can be mass-assigned
    protected $fillable = [
        'name', 'email', 'password', 'role', 'dealer_id',
    ];

    // Method to check if the user is a superAdmin
    public function isSuperAdmin()
    {
        return $this->role === 'superAdmin';
    }

    // Method to check if the user is an admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Method to check if the user is a seller
    public function isSeller()
    {
        return $this->role === 'seller';
    }

    // Method to generate a token for the user
    public function generateToken()
    {
        return $this->createToken('YourAppNameToken')->plainTextToken;
    }

    // Relationship: User (dealer) has many sellers
    public function sellers()
    {
        return $this->hasMany(Seller::class, 'dealer_id');
    }

    // Relationship: Seller belongs to a dealer (another user)
    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }
}
