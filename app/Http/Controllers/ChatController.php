<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
class ChatController extends Controller
{
    // Display a chat conversation
    public function showConversation($recipientId)

    {
        $user_id = auth()->user()->id;
        $messages = Message::where(function ($query) use ($user_id , $recipientId) {
            $query->where('sender', $user_id )->where('receiver', $recipientId);
        })->orWhere(function ($query) use ($user_id , $recipientId) {
            $query->where('sender', $recipientId)->where('receiver', $user_id );
        })->orderBy('created_at', 'asc')->get();
    
       
        return view('chats', [ 'recipientId' => $recipientId,'messages'=>$messages]);
        
    }

    // Send a message

    
    public function sendMessage(Request $request, $recipient)
    {
        $user = auth()->user();
        $message = new Message([
            'sender' => $user->id,
            'receiver' => $recipient,
            'content' => $request->input('content')
        ]);
    
        $message->save();
        event(new MessageSent($message));

        // You might want to broadcast this message to the recipient in real-time.
        // Implement websockets or broadcasting for real-time chat updates.
    
        return redirect()->back();
    }

}
