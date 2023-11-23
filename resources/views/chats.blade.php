@extends('layouts.app')

@section('content')

<div class="container-fluid">

  <div class="row">
  <div class='col-md-2 px-0 all-chat-container'>

                           
  <div class="chat-header primary-bg">
    <p class="fs-5 mb-0">All Chats</p>
  </div>
  <ul class="list-group list-group-flush pb-3 mt-3">
    @if(!empty($allChats))
    @foreach($allChats as $chat)
    <li class="list-group-item px-0 mx-3">
    <a href="/conversations/{{$chat->sender}}/{{$chat->room_id}}">
        <div class="d-flex align-items-center">
            <div>
    <img src="/storage/{{$chat->image1}}" class="circle" width="40"  height="40">
</div>
<div class="ps-1 ms-1 text-container">
{{$chat->pg_name}}
            <small>{{$chat->room_id}}</small>
            <br>
            @if(Auth::user()->id==$chat->sender)
            <small>{{$chat->receiver_name}}</small>
            @else
            <small>{{$chat->sender_name}}</small>
            @endif
</div>


            
          
        </div>
    </a>
</li>       
                                   @endforeach
                                   @else
No Chats to Show
                                   @endIf
  </ul>

</div>


    <div class='col-md-10 px-0'>
@if(!empty($chatInfo))

            <div class="convo card border-0">
                <div class="card-header primary-bg">
                    <!-- Header with user's name -->

                    
                    <div class="d-flex align-items-center">
            <div>
    <img src="/storage/{{$chatInfo->img}}" class="circle" width="40"  height="40">
</div>
<div class="ps-1 ms-1 text-container">

<small class='fs-5 mb-0'>{{$chatInfo->pg_name}}</small>
<small>{{$chatInfo->room_id}}</small><br>
                    <small class='sender-name'>{{$chatInfo->sender_name}}</small>
</div>


            
          
        </div>
                </div>
                <div class="card-body msg-body">
                    <!-- Chat messages -->
                    <div id="messagesList">


                            @foreach($messages as $message)
                                                <div class="d-flex col-12 @if($message->receiver == $receiverId) justify-content-end @else justify-content-start @endif">
                                                <div class="message @if($message->receiver == $receiverId) sent @else received @endif">
                                    {{ $message->content }}

                            </div>
                            </div>
                            @endforeach
                    </div>
                </div>
                <div class="card-footer px-5 py-3">
                    <!-- Message input and send button -->
                    <form id="chat-form" method="POST" action="/send/{{$receiverId}}/{{$roomId}}">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="messageInput" class="form-control" name="content" placeholder="Type a message...">
                        <div class="input-group-append">
                            <button type="submit" id="sendMessageButton" class="btn primary-btn">Send</button>
                        </div>
                    </div>
</form>
                </div>
            </div>

@else
 <div class="fill-y d-flex justify-content-center align-items-center">
    <div class="text-center">
    <p class="fs-1 fw-bold mb-0">Start a Chat</p>
    <small>Have a chat with the PG owner</small>
</div>
    
</div>

 @endIf

</div>
</div>
</div>
            <script>
    var accessToken = '{!! $token !!}';
  
        // Now you can use the accessToken in your Bootstrap.js or other JavaScript files
        
    var senderId = {{ $senderId }};
    var receiverId = {{ $receiverId }};
</script>

@endsection