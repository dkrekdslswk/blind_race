<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Example Component</div>

                    <div class="panel-body">
                        I'm an example component!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueSocketio from 'vue-socket.io';
    import socketio from 'socket.io-client';
    Vue.use(VueSocketio, socketio(':8890'));

        var socket = socketio(':8890'); //1
      $('#chat').on('submit', function(e){ //2
        socket.emit('send message', $('#name').val(), $('#message').val());
        $('#message').val('');
        $('#message').focus();
        e.preventDefault();
      });
      socket.on('receive message', function(msg){ //3
        $('#chatLog').append(msg+'\n');
        $('#chatLog').scrollTop($('#chatLog')[0].scrollHeight);
      });
      socket.on('change name', function(name){ //4
        $('#name').val(name);
      });
    export default {
        
    }
</script>