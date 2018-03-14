<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!--부트스틑랩이나 css부분을 퍼오는 링크 -->
  <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet" type="text/css">
  <title>Document</title>
</head>
<body>
  <!--밑에 두줄이 있어야지만 vue를 불러 쓸 수 있음-->
  <div id="app"></div>
  
  
       <script src="<?php echo e(asset('js/app.js')); ?>"></script> 
</body>
</html>