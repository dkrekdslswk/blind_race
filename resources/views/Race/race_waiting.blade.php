<?php
/**
 * Created by PhpStorm.
 * User: kimseungmok
 * Date: 2018-03-30
 * Time: 오후 12:11
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Waiting Room</title>

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>

    <script type="text/javascript">

    var getJsonDate_nav = '';
    var getJsonDate_user = '';

    $(function () {
        var socket = io(':8891');
        var table_row_count = 0;

        var char_ran = Math.floor(Math.random() * 4) + 1;

        socket.on('now user counting',function(std){

            $('#student_count').html("접속자 : " + std);

            table_row_count = Math.floor(std / 10) + 1;

            for (var i = 0 ; i < table_row_count ; i++){
                $('#characterTable').append($('<tr id="characterTr' + table_row_count + '">'));
            }

            $('#characterTr'+table_row_count).
            append($('<td>').
            html('<img style="width: 80px;height: 80px;" class="nav-icon " src="img/character/char'+char_ran+'.png"><br/>'));
        });

        socket.on('user data',function(conn){
            getJsonDate_user = JSON.parse(conn);
            var nick = getJsonDate_user.student[0].studentNick;

            $('#messages').append($('<li>').text(nick+"님이 입장했습니다.")).fadeOut(1000);

/*            $('#characterTr'+table_row_count)
                    .append('<td>')
                    .html('<img src="img/character/char'+char_ran+'.png" style="width: 80px;height: 80px;"><br>' + nick))
            .fadeOut(1000)*/
        });

        socket.on('disc user',function(disc){
            getJsonDate_user = JSON.parse(disc);
            var nick = getJsonDate_user.student[0].studentNick;

            $('#messages').append($('<li>').text(nick+"님이 퇴장했습니다."));
        });

    });

    </script>

    <style>
        .student {
            margin-top: 3%;
            display: block;
            text-align: right;
        }

        .student form{
            display: inline;
            background-color: white;
            margin-right: 1%;
        }

        .counting{
            text-align: center;
        }

        .counting span {
            padding: 10px 20px 10px 20px;
            background-color: white;
        }

        .waitingTable {
            margin-top: 20px;
            margin-left: 2%;
            margin-right: 2%;
        }

        #messages { list-style-type: none; }
        #messages li { padding: 5px 10px; }

    </style>

</head>
<body>

{{--레이스 네비게이션--}}
<racenav>
    @include('Navigation.racenav')
</racenav>

<div class="student">

    <form action="">
        <button class="btn btn-lg btn-primary" style="">시작하기</button>
    </form>

    <div class="counting">
        <span id="student_count" > 학생 수</span>
    </div>

</div>


<ul id="messages"></ul>


<div class="waitingTable">
    <table class="table table-bordered" id="characterTable" style="text-align: center;">

    </table>
</div>


</body>
</html>
