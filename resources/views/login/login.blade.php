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
  
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
  width:100%;
}
</style>
</head>
<body>
    <nav>
        @include('nav.mainnav')
    </nav>
      <ul>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
      </ul>
      <div>
          @include('play_list.race_list')
      </div>
    <!-- <div id="app" class="barStyle">-->
    <!--</div>-->
      <!--<script src="{{asset('js/app.js')}}"></script>-->
    <script>
           window.Laravel = <?php echo json_encode([
               'csrfToken' => csrf_token(),
                    ]); ?>
          </script>
</body>
</html>