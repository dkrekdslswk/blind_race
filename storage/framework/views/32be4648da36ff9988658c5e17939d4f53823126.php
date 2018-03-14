<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chatroom</title>
    <style>
      .chat_log{ width: 95%; height: 200px; }
      .name{ width: 10%; }
      .message{ width: 70%; }
      .chat{ width: 10%; }
    </style>
     <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet" type="text/css">
</head>
<body>
     <div id="app">
        
    </div>
    <div>
      <textarea id="chatLog" class="chat_log" readonly></textarea>
    </div>
    <form id="chat">
      <input id="name" class="name" type="text" readonly>
      <input id="message" class="message" type="text">
      <input type="submit" class="chat" value="chat"/>
    </form>
    <div id="box" class="box">
    <!--<script src="socket.js"></script> <!-- 1 -->-->
    <script src="//code.jquery.com/jquery-1.11.1.js"></script>

     <script>
           window.Laravel = <?php echo json_encode([
               'csrfToken' => csrf_token(),
                    ]); ?>
          </script>
      <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>