<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    //
     use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'parent_id',
        'position',
        'status',
        'priority',
        'module_id',
        'slug',
        'featured',
    ];

    // You can add relationships here, if needed, such as a parent-child relationship
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
