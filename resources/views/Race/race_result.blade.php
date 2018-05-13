<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>레이스 결과 </title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" integrity="sha256-HEtF7HLJZSC3Le1HcsWbz1hDYFPZCqDhZa9QsCgVUdw=" crossorigin="anonymous" />

    <script>
        var r_result="";

        window.onload = function() {

            var changehtml ="" ;

            var roomPin = "<?php echo $_GET['roomPin']; ?>" ;
            var socket = io(':8890');

            socket.emit('join',roomPin);
            socket.emit('race_ending',roomPin);

            $.ajax({
                type: 'POST',
                url: "{{url('/raceController/raceEnd')}}",
                dataType: 'json',
                async:false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },

                success: function (result) {
                    // //var r_result = JSON.parse(data);
                    r_result = result['students'];
                    for(var i=0;  i <r_result.length; i++){
                        // changehtml+='<h3>' + r_result[i].user_num + " 번 학생" + r_result[i].point + "개 맞춤" + '</h3><br>';
                        $('#'+i+'_nick').text(r_result[i].nick);
                        $('#'+i+'_point').text(r_result[i].rightCount*100+"point");
                        $('#'+i+'_character').attr("src", "/img/character/char"+r_result[i].characterId+".png");

                    }

                },
                error: function(request, status, error) {
                    alert("AJAX 에러입니다. ");
                }
            });
            socket.emit('race_result',roomPin ,JSON.stringify(r_result) );
        };

    </script>

</head>
<body>

<div> @include('Navigation.main_nav')</div>

<div id="app">


</div>
<div id="race_result" >

</div>

<audio autoplay><source src="/bgm/race_result.mp3"></audio>

<script src="{{asset('js/app.js')}}"></script>
<a href="/"><button class="btn btn-primary" style="margin-left:50%;">돌아가기</button></a>
</body>
</html>