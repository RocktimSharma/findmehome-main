<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PG extends Model
{
    use HasFactory;
    protected $table = 'pgs';
    protected $fillable = [
        'name', // Add 'name' to the $fillable array
        'latitude',
        'longitude',
        'owner_id',
        'contact_details',
        'amenities',
        'rules_restrictions',
        'description',
        'other_details',
    ];
}
