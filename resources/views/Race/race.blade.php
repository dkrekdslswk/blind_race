<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
     <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
     <link href="js/bootstrap.min.js" rel="stylesheet">
     <style>

</style>
</head>
<body>
    <nav>
        @include('Navigation.mainnav')
    </nav>
    <!--aside 자리-->
      <aside style="display:inline-block; vertical-align:top;">
          @include('play_list.mode_select')
      </aside>
      <div style="margin-left:200px; display:inline-block; width:50%;">
         @include('play_list.race_list')
      </div>
      

</body>
</html>