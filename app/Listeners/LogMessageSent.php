<?php 

// App\Listeners\LogMessageSent.php

namespace App\Listeners;


use App\Events\MessageSent;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogMessageSent implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        // Log the message content or any other relevant information
        Log::info('New message sent:', ['message' => $event->message]);
    }
}
