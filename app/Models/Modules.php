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
    protected $connection = 'ecfy_store'; // Explicitly specify the database connection

//    protected $table = 'modules';

//      protected static function boot()
//     {
//         parent::boot();

        
//         Config::set('database.connections.mysql.database', 'ecfy_store');
//         DB::purge('mysql'); 
//     }

        //   protected $connection = 'mysql2'; // Use the 'mysql2' connection
        //   protected $table = 'modules';

    //  protected $fillable = [
    //     'module_name',
    //     'module_type',
    //     'thumbnail',
    //     'status',
    //     'stores_count',
    //     'icon',
    //     'theme_id',
    //     'description',
    //     'all_zone_service',
    // ];
}
