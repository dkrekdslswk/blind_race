<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chatroom</title>
     <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet" type="text/css">
</head>
<body>
     <div id="app">
        <h1>Chatroom</h1>
       
    </div>
    <div>
        왜안되 ㅜㅠㅜㅜㅠㅜ
    </div>
     <script>
           window.Laravel = <?php echo json_encode([
               'csrfToken' => csrf_token(),
                    ]); ?>
          </script>
      <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>