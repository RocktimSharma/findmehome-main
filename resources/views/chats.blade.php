@extends('layouts.app')

@section('content')



    
            <div class="convo card border-0">
                <div class="card-header primary-bg">
                    <!-- Header with user's name -->
                    <p class='fs-5 mb-0'>Rocktim Sharma</p>
                </div>
                <div class="card-body msg-body">
                    <!-- Chat messages -->
                    <div id="messagesList">


@foreach($messages as $message)
                    <div class="d-flex col-12 @if($message->receiver == $recipientId) justify-content-end @else justify-content-start @endif">
                    <div class="message">
        {{ $message->content }}
   
</div>
</div>
@endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <!-- Message input and send button -->
                    <form id="chat-form" method="POST" action="/conversations/{{$recipientId}}">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="messageInput" class="form-control" name="content" placeholder="Type a message...">
                        <div class="input-group-append">
                            <button type="submit" id="sendMessageButton" class="btn btn-primary">Send</button>
                        </div>
                    </div>
</form>
                </div>
            </div>
    



@endsection