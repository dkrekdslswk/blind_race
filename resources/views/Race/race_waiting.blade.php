<?php
/**
 * Created by PhpStorm.
 * User: kimseungmok
 * Date: 2018-03-30
 * Time: 오후 12:11
 */

/*isset($json) ? $getJsonData = json_decode(json_encode($json)) : $getJsonData ='default';*/

/*foreach ($getJsonData as $key => $value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

foreach ($getJsonData as $key => $value){
    echo '<pre>';
    echo $key;
    echo '</pre>';
}
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

        $(function () {

            var getData = '{{isset($json) ? true : false}}';
            var user_id = null;
            var race_name = null;

            if(getData){

                var getJsonData = JSON.parse('@json($json)',function(key, value){
                    switch (key){
                        case 'raceName' :
                            $('#race_name').html(value);
                            race_name = value;
                            break;
                        case 'examCount' :
                            $('#race_count').html(value);
                            break;
                        case 'groupName' :
                            $('#group_name').html(value);
                            break;
                        case 'groupStudentCount' :
                            $('#group_student_count').html(value);
                            break;
                        case 'sessionId' :
                            user_id = value;
                            break;
                    }
                });
            }


            var socket = io(':8891');
            var table_row_count = 0;
            var char_ran = Math.floor(Math.random() * 4) + 1;

            var joinData = {"userID" : user_id , "raceName" : race_name };

            socket.emit('join',joinData);

            socket.on('user connected',function(user){
                $('#messages').append($('<li>').text(user+"님이 입장했습니다.")).fadeOut(1000);
            });

            socket.on('user disconnected',function(user){
                $('#messages').append($('<li>').text(user+"님이 퇴장하였습니다.")).fadeOut(1000);
            });

            socket.on('now all user',function(std){

                $('#student_count').html("접속자 : " + std);

                table_row_count = Math.floor(std / 10) + 1;

                for (var i = 0 ; i < table_row_count ; i++){
                    $('#characterTable').append($('<tr id="characterTr' + table_row_count + '">'));
                }

                $('#characterTr'+table_row_count).
                append($('<td>').
                html('<img style="width: 80px;height: 80px;" class="nav-icon " src="/img/character/char'+char_ran+'.png"><br/>'));
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
