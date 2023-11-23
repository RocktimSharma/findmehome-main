<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $table = 'wishlist';
    protected $primaryKey = 'w_id';
    protected $fillable = [
        'user_id', // Add 'name' to the $fillable array
        'room_id',
       
      
    ];
}
