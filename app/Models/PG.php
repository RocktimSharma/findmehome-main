<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PG extends Model
{
    use HasFactory;
    protected $table = 'pgs';
    protected $primaryKey = 'pg_id';
    protected $fillable = [
        'name', // Add 'name' to the $fillable array
        'latitude',
        'longitude',
        'owner_id',
        'contact_details',
        'rules_restrictions',
        'description',
       
      
    ];
    public function rooms() {
        return $this->hasMany(Room::class, 'pg_id', 'pg_id');
    }
}
