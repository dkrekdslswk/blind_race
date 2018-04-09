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
            var group_student_count = 0;

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
                            group_student_count = value;
                            break;
                        case 'sessionId' :
                            user_id = value;
                            break;
                    }
                });
            }


            //group_student_count(그룹 총 학생수)를 사용하여 숫자 0부터 group_student_count 까지의 숫자중에 랜덤으로 학생들에게 부여
            //하지만 이미지가 4개 밖에 없으므로 4로 지정
            group_student_count = 4;

            var socket = io(':8890');
            var table_row_count = 0;
            var char_ran = Math.floor(Math.random() * group_student_count) + 1;

            var joinData = {"userID" : user_id , "raceName" : race_name , "groupStudentCount" : group_student_count};

            socket.emit('join to raceroom',joinData);

            //유저 입장
            socket.on('user connected',function(user){
                $('#messages').append($('<li>').text(user+"님이 입장했습니다.")).fadeOut(1000);
            });

            //유저 퇴장
            socket.on('user disconnected',function(user){
                $('#messages').append($('<li>').text(user+"님이 퇴장하였습니다.")).fadeOut(1000);
            });

            //현재 유저수 받기
            socket.on('now all user',function(std_count){

                $('#student_count').html("현재 접속자 수 : " + std_count);

                table_row_count = Math.floor(std_count / 10) + 1;
                for (var i = 0 ; i < table_row_count ; i++){
                    $('#characterTable').append($('<tr id="characterTr' + (table_row_count - 1) + '">'));
                }

                for( var i = 0 ; i < std_count ; i++){
                    $('#characterTr'+ i).append($('<td>').
                    html('<img style="width: 80px;height: 80px;" class="nav-icon" src="/img/character/char'+char_ran+'.png"><br/>'+user_id));
                }

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
