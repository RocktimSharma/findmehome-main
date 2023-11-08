<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'room';

    protected $primaryKey = 'room_id';
    protected $fillable = ['image1', 'image2', 'image3', 'image4', 'room_type', 'amenities', 'room_price', 'availability_status', 'pg_id'];

}
