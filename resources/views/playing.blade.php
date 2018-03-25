<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body id="client">
<script src="//code.jquery.com/jquery-1.11.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
<div id="app">
</div>
<script src="{{asset('js/app.js')}}"></script>

<div>
    <div>
        <textarea id="chatLog" class="chat_log" readonly></textarea>
    </div>
    <form id="chat">
        <input id="name" class="name" type="text" readonly>
        <input id="message" class="message" type="text">
        <input type="submit" class="chat" value="chat"/>
    </form>
    <div id="box" class="box"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
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
</script>

<h1>Please Vote:</h1>
<button class="btn" data-index="0" >Option A</button>
<button class="btn" data-index="1">Option B</button>
<button class="btn" data-index="2">Option C</button>
<button class="btn" data-index="3">Option D</button>
</body>
</html>
