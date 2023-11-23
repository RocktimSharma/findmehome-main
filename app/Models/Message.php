<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'messages';

    protected $primaryKey = 'msg_id';
    protected $fillable = ['msg_id', 'sender','receiver','room_id', 'content'];

}
