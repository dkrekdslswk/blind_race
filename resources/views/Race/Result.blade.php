<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>이까지는 가는데 밑에서 못받는구나</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>

    <script>
        window.onload = function() {

            var changehtml ="" ;
            var socket = io(':8890');

            socket.emit('race_ending','group1');

            socket.on('race_ending',function(data){

                var r_result = JSON.parse(data);

                for(var i=0;  i <r_result.length; i++){
                    changehtml+='<h3>' + r_result[i].user_num + " 번 학생" + r_result[i].point + "개 맞춤" + '</h3><br>';
                }
                $('#race_result').html(changehtml);

            });
        };

    </script>

</head>
<body>
<div id="app">


</div>

<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
    ]); ?>
</script>

<div id="race_result" >

</div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>