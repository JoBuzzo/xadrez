import './bootstrap';

import Pusher from 'pusher-js';

window.pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER
});


var channel = pusher.subscribe('new-move');
channel.bind('moved-piece', function(data) {
     Livewire.dispatch('movedPieceReceived', {
        data: data
    });
});
