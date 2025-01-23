<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    //
    //  protected $connection = 'mysql2'; // Use the 'mysql2' connection
     protected $table = 'stores';

      protected static function boot()
    {
        parent::boot();

        
        Config::set('database.connections.mysql.database', 'ecfy_store');
        DB::purge('mysql'); 
    }
}
