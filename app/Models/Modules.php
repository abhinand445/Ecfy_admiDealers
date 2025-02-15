<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class Modules extends Model
{
    //
         use HasFactory;

    

    protected $table = 'modules';

      protected $fillable = [
        'module_name',
        'module_type',
        'thumbnail',
        'status',
        'stores_count',
        'icon',
        'theme_id',
        'description',
        'all_zone_service',
    ];

   
}
