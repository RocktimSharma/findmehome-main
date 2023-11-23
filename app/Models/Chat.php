<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chats';
    protected $primaryKey = 'chat_id';
    protected $fillable = [
        'room_id', // Add 'name' to the $fillable array
        'sender_id',
        'receiver_id',
        
    ];
  /*  public function messages() {
        return $this->hasMany(Message::class, 'chat_id', 'chat_id');
    }*/
}
