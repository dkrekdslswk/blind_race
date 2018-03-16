<template>
    <div>
        <Minsu></Minsu>
    </div>
</template>
<script>
 import Footer from './Footer.vue';
    import Minsu from './Minsu.vue';
    import Modal from './Modal.vue';
    export default {
       components:{
            Footer  ,  Minsu , Modal
       }
    }
    // import Vue from 'vue';
    // import VueSocketio from 'vue-socket.io';
    // import socketio from 'socket.io-client';
    // Vue.use(VueSocketio, socketio(':8890'));
    //     var socket = socketio(':8890'); //1
    //   $('#chat').on('submit', function(e){ //2
    //     socket.emit('send message', $('#name').val(), $('#message').val());
    //     $('#message').val('');
    //     $('#message').focus();
    //     e.preventDefault();
    //   });
    //   socket.on('receive message', function(msg){ //3
    //     $('#chatLog').append(msg+'\n');
    //     $('#chatLog').scrollTop($('#chatLog')[0].scrollHeight);
    //   });
    //   socket.on('change name', function(name){ //4
    //     $('#name').val(name);
    //   });

</script>