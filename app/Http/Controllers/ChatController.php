<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Chat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
class ChatController extends Controller
{
    // Display a chat conversation





    public function showConversation($receiverId,$roomId)

    {
        $user_id = auth()->user()->id;


      /*  $allChats = Message::select(
            'messages.room_id',
            DB::raw('ANY_VALUE(pgs.name) as pg_name'),
            DB::raw('LEAST(messages.sender, messages.receiver) AS user1'),
            DB::raw('GREATEST(messages.sender, messages.receiver) AS user2'),
            DB::raw('ANY_VALUE(room.room_id) as room_id'),
            DB::raw('ANY_VALUE(usersSender.name) as sender_name'),
            DB::raw('ANY_VALUE(usersReceiver.name) as receiver_name'),
            DB::raw('ANY_VALUE(room.image1) as image1')
        )
        ->join('room', 'room.room_id', '=', 'messages.room_id')
        ->join('pgs', 'pgs.pg_id', '=', 'room.pg_id')
        ->join('users as usersSender', 'usersSender.id', '=', 'messages.sender')
        ->join('users as usersReceiver', 'usersReceiver.id', '=', 'messages.receiver')
        ->where(function ($query) use ($user_id) {
            $query->where('messages.sender', $user_id)
                  ->orWhere('messages.receiver', $user_id);
        })
        ->groupBy('messages.room_id', 'user1', 'user2')
        ->get();*/

        $allChats = Message::select(
            'messages.room_id',
            DB::raw('MAX(pgs.name) as pg_name'),
            DB::raw('LEAST(messages.sender, messages.receiver) AS user1'),
            DB::raw('GREATEST(messages.sender, messages.receiver) AS user2'),
            'room.room_id',
            DB::raw('MAX(usersSender.name) as sender_name'),
            DB::raw('MAX(usersReceiver.name) as receiver_name'),
            DB::raw('MAX(room.image1) as image1'),
            DB::raw('MAX(messages.sender) as sender'),
            DB::raw('MAX(messages.receiver) as receiver'),
            DB::raw('MAX(usersSender.id) as senderId'),
            DB::raw('MAX(usersReceiver.id) as receiverId')
        )
        ->join('room', 'room.room_id', '=', 'messages.room_id')
        ->join('pgs', 'pgs.pg_id', '=', 'room.pg_id')
        ->join('users as usersSender', function ($join) {
            $join->on('usersSender.id', '=', DB::raw('CASE WHEN messages.sender < messages.receiver THEN messages.sender ELSE messages.receiver END'));
        })
        ->join('users as usersReceiver', function ($join) {
            $join->on('usersReceiver.id', '=', DB::raw('CASE WHEN messages.sender > messages.receiver THEN messages.sender ELSE messages.receiver END'));
        })
        ->where(function ($query) use ($user_id) {
            $query->where('messages.sender', $user_id)
                ->orWhere('messages.receiver', $user_id);
        })
        ->groupBy('messages.room_id', 'user1', 'user2', 'room.room_id')
        ->get();
        
        
        
        
        
    
    
      
    
      
        if(!empty(trim($receiverId)) || !empty(trim($roomId))) {
  
            $chatInfo = Message::select(
                'messages.msg_id',
                'pgs.name as pg_name',
                'sender.name as sender_name',
                'receiver.name as receiver_name',
                'room.image1 as img',
                'room.room_id'
            )
            ->leftJoin('room', 'room.room_id', '=', 'messages.room_id')
            ->leftJoin('pgs', 'room.pg_id', '=', 'pgs.pg_id')
            ->leftJoin('users as sender', 'sender.id', '=', 'messages.sender')
            ->leftJoin('users as receiver', 'receiver.id', '=', 'messages.receiver')
            ->where(function ($query) use ($user_id, $receiverId, $roomId) {
                $query->where(function ($query) use ($user_id, $receiverId, $roomId) {
                    $query->where('messages.sender', $user_id)
                          ->where('messages.receiver', $receiverId)
                          ->where('messages.room_id', $roomId);
                })
                ->orWhere(function ($query) use ($user_id, $receiverId, $roomId) {
                    $query->where('messages.sender', $receiverId)
                          ->where('messages.receiver', $user_id)
                          ->where('messages.room_id', $roomId);
                });
            })
            ->first();
    
            
            $messages = Message::where(function ($query) use ($user_id, $receiverId, $roomId) {
                $query->where(function ($query) use ($user_id, $receiverId, $roomId) {
                    $query->where('messages.sender', $user_id)
                          ->where('messages.receiver', $receiverId)
                          ->where('messages.room_id', $roomId);
                })
                ->orWhere(function ($query) use ($user_id, $receiverId, $roomId) {
                    $query->where('messages.sender', $receiverId)
                          ->where('messages.receiver', $user_id)
                          ->where('messages.room_id', $roomId);
                });
            })->orderBy('created_at', 'asc')->get();
    
    
            
    

        }else{
     
    $chatInfo=[];
    $messages=[];

        }

      


    
   
  
       $user = Auth::user();
       $token = $user->createToken('Token Name')->accessToken;
       
        return view('chats', ['allChats'=>$allChats, 'receiverId' => $receiverId,'chatInfo'=>$chatInfo,'senderId'=>$user_id,'roomId'=>$roomId,'messages'=>$messages, 'token'=>json_encode($token)]);
        
    }

    // Send a message

    
    public function sendMessage(Request $request, $recipient,$roomId)
    {
     
        $user = Auth::user();

        $msg="Hey I am Interested";

        if(!empty($request->input('content'))){
            $msg=$request->input('content');
        }

        
     
        $message = new Message([
            'sender' => $user->id,
            'receiver' => $recipient,
            'room_id'=>$roomId,
            'content' => $msg,
        ]);
    
        $message->save();

      
        $messageData = [
            'msg_id'=> $message->msg_id,
            'sender_id' => $message->sender,
            'receiver_id' => $message->receiver,
            'pg_id'=> $message->room_id,
            'content' => $message->content,
        ];
    
        broadcast(new MessageSent($messageData));

      //  event(new MessageSent($message));

        // You might want to broadcast this message to the recipient in real-time.
        // Implement websockets or broadcasting for real-time chat updates.
    
        return redirect("/conversations/{$recipient}/{$roomId}");



    }

}
