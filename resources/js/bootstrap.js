//import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from "pusher-js"

window.Pusher = Pusher;
console.log('Access Token:', accessToken);
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '0acd81df3e327c16d64f',
    cluster: 'ap2',
    forceTLS: true,
    auth:{
        headers: {
            Accept: 'application/json',
            Authorization: 'Bearer ' + accessToken,
            
        },
    },
    authEndpoint: '/broadcasting/auth',  // Correct authEndpoint
          // Correct authHost
});


// This function is responsible for updating the chat interface with a new message
function updateChatInterface(message) {
    // Append the received message to the chat interface
    // You can customize this part based on your chat interface structure
    let messagesList = document.getElementById('messagesList');

    // Create a new div element for the message
    let messageDiv = document.createElement('div');
console.log()
       if(message.receiver_id==senderId && message.sender_id==receiverId){
       
        messageDiv.className = 'd-flex col-12 ' + (message.receiver_id === receiverId ? 'justify-content-end' : 'justify-content-start');
    
        // Create a nested div for the message content
        let contentDiv = document.createElement('div');
        contentDiv.className = 'message '+ (message.receiver_id === receiverId ? 'sent' : 'received');
        contentDiv.textContent = message.content;
    
        // Append the content div to the message div
        messageDiv.appendChild(contentDiv);
    
        // Append the message div to the messages list
        messagesList.appendChild(messageDiv);
       
       }
   
}

console.log('chat.'+senderId+'.'+receiverId)
window.Echo.channel('chat').listen('MessageSent', (e) => {
    console.log('Private channel listener called');
    console.log('New message:', e.message);
    // Call the function to update the chat interface
     updateChatInterface(e.message);
});


window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
