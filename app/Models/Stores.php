<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    use HasFactory;

    protected $table = 'stores'; // Explicitly defining the table name

    protected $fillable = [
        'store_name',
        'address',
        'logo',
        'f_name',
        'l_name',
        'phone',
        'email',
        'password',
        'latitude',
        'longitude',
        'module_id',
        'zone_id',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Relationship: A store can have multiple images.
     */
    // public function images()
    // {
    //     return $this->hasMany(StoreImage::class, 'store_id');
    // }

    /**
     * Relationship: A store belongs to a module.
     */
    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    /**
     * Relationship: A store belongs to a zone.
     */
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
}
