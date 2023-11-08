import 'bootstrap';

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
});

// This function is responsible for updating the chat interface with a new message
function updateChatInterface(message) {
    // Append the received message to the chat interface
    // You can customize this part based on your chat interface structure
    const chatMessages = document.getElementById('chatMessages'); // Replace with your chat messages container element
    const newMessageElement = document.createElement('div');
    newMessageElement.textContent = message.content; // Adjust this based on your message content structure
    chatMessages.appendChild(newMessageElement);

    // Scroll to the bottom of the chat container to show the new message
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

console.log('Before listening to private channel');
window.Echo.private('findmehome').listen('MessageSent', (e) => {
    console.log('Private channel listener called');
    console.log('New message:', e.message);

    // Call the function to update the chat interface
    updateChatInterface(e.message);
});
console.log('After listening to private channel');


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
