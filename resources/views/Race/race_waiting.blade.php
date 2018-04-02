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

        socket.on('now user counting',function(std){

            $('#student_count').html(std);
        });

        socket.on('user data',function(user){
            getJsonDate_user = JSON.parse(user);

            $('#user_nick').html(getJsonDate_user.student[0].studentNick);
        });

        socket.on('disc user',function(disc){
            getJsonDate_user = JSON.parse(disc);
            var nick = getJsonDate_user.student[0].studentNick;

            $('#user_out').append($('<li>').text(nick));
        });

    });

    </script>

</head>
<body>

{{--레이스 네비게이션--}}
<racenav>
    @include('Navigation.racenav')
</racenav>

<span id="student_count" style="top: 30%;"> 현재 유저 수</span>

<ul id="user_nick" style="top: 30%;"></ul>

<ul id="user_out" style="top: 30%;"></ul>
<ul id="user_out2" style="top: 30%;">123</ul>

<div id="waiting">
    <table id="student">
        <tr>
            <td>
                zxczxczxc
            </td>
        </tr>
    </table>

</div>


</body>
</html>
