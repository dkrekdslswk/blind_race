
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Waiting Room</title>

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">


    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>

    <script type="text/javascript"></script>

    <style>
        body{
            background: #9370db; !important;
        }
        #wait_room_nav{
            box-shadow:  60px 60px 100px -90px #000000, 60px 0px 100px -70px #000000;
            /*background-color: rgba(255,255,255,.84);*/
            background-color:white;
            width: 100%;
            height: 100px;
            border-radius: 10px;
            font-weight:bold;
            font-size:50px;
        }

        .user_in_room{
            display:inline-block;

            margin-right:50px;
            border-radius: 15px 50px 30px;
        }
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
        #counting_student{
            text-align:center;
            font-size:30px;
            position:absolute;
            left:5%;
        }

        .counting{
            text-align: center;
        }

        .counting span {
            padding: 10px 20px 10px 20px;
            background-color: white;
            position:absolute;
            left: 10%;
        }

        .waitingTable {
            margin-top: 20px;
            margin-left: 2%;
            margin-right: 2%;
        }
        #room_Pin{
            background-color:white;
            width: 35%;
            height: 100px;
            font-size:70px;
            margin:auto;
        }

        #messages { list-style-type: none; }
        #messages li { padding: 5px 10px; }

    </style>
    <script>
        var quiz_member = 0;
        var submit_count=0;
        var quiz_answer_list = [1,2,3,4];
        var rightAnswer;
        var real_A;
        var roomPin ='<?php echo $response['roomPin']; ?>';
        var t_sessionId = '<?php echo $response['sessionId']; ?>';
        var quiz_JSON = JSON.parse('<?php echo json_encode($response['quizs']['quiz']); ?>');

        var listName = '<?php echo $response['list']['listName']; ?>';
        var quizCount = '<?php echo $response['list']['quizCount']; echo "문제"; ?>';
        var groupName = '<?php echo $response['group']['groupName']; ?>';
        var groupStudentCount = '<?php echo "총원: "; echo $response['group']['groupStudentCount']; echo "명"; ?>';

        var start_check = false;
        var answer_count = 0;
        window.onload = function() {


            //정답뒤섞기
            function shuffle(a) {
                var j, x, i;
                for (i = a.length; i; i -= 1) {
                    j = Math.floor(Math.random() * i);
                    x = a[i - 1];
                    a[i - 1] = a[j];
                    a[j] = x;
                }
            }
            function Create2DArray(rows) {
                var arr = [];

                for (var i=0;i<rows;i++) {
                    arr[i] = [];
                }

                return arr;
            }
            real_A = Create2DArray(quiz_JSON.length);

            for(var i = 0; i <quiz_JSON.length; i++){
                if( quiz_JSON[i].makeType == "obj"){
                    shuffle(quiz_answer_list);

                    real_A[i][quiz_answer_list[0]] = quiz_JSON[i].right;
                    real_A[i][quiz_answer_list[1]] = quiz_JSON[i].example1;
                    real_A[i][quiz_answer_list[2]] = quiz_JSON[i].example2;
                    real_A[i][quiz_answer_list[3]] = quiz_JSON[i].example3;

                    for(var j = 0; j<=3; j++){
                        switch(quiz_answer_list[j]){
                            case 1: quiz_JSON[i].right = real_A[i][quiz_answer_list[j]];
                                break;
                            case 2: quiz_JSON[i].example1 = real_A[i][quiz_answer_list[j]];
                                break;
                            case 3: quiz_JSON[i].example2 = real_A[i][quiz_answer_list[j]];
                                break;
                            case 4: quiz_JSON[i].example3 = real_A[i][quiz_answer_list[j]];
                                break;
                        }
                    }
                }
            }

            console.log(JSON.stringify(quiz_JSON));

            var socket = io(':8890');

            $('#race_name').html(listName);
            $('#race_count').html(quizCount);
            $('#group_name').html(groupName);
            $('#group_student_count').html(groupStudentCount);

            $('#room_Pin').html("PIN:"+roomPin);
            socket.emit('join', roomPin);

            socket.on('android_join',function(roomPin,sessionId){

                $.ajax({
                    type: 'POST',
                    url: "{{url('/raceController/studentIn')}}",
                    dataType: 'json',
                    async: false ,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:"roomPin="+roomPin+"&sessionId="+sessionId,
                    success: function (result) {
                        if(result['check'] == true) {
                            socket.emit('android_join_check', true, sessionId, "popQuiz");
                            quiz_member++;
                            $('#member_count').text(quiz_member);

                            if(start_check){
                                quiz_JSON = json_encode(result['quizs']['quiz']);
                                socket.emit('re_join_pop_quiz',roomPin,JSON.stringify(quiz_JSON), listName, sessionId);
                            }

                        }
                        else
                            socket.emit('android_join_check',false, sessionId ,"popQuiz");
                    },
                    error: function(request, status, error) {
                        console.log("안드로이드 join 실패"+roomPin);
                    }
                });

            });

            socket.on('web_test_enter',function(roomPin){
                quiz_member++;
                $('#member_count').text(quiz_member);
            });
        };

        function pop_end(){
            // window.loaction.href="/race_result?roomPin="+roomPin;
            $(location).attr('href', "/race_result?roomPin="+roomPin);
        }
        function btn_click(){
            start_check = true;

            var h1 = document.getElementsByTagName('h1')[0],
                seconds = 0, minutes = 0, hours = 0,
                t;

            function add() {
                seconds++;
                if (seconds >= 60) {
                    seconds = 0;
                    minutes++;
                    if (minutes >= 60) {
                        minutes = 0;
                        hours++;
                    }
                }

                h1.textContent = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);

                timer();
            }
            function timer() {
                t = setTimeout(add, 1000);
            }
            timer();


            var socket = io(':8890'); //14
            socket.emit('join', roomPin);

            //socket.emit('web_enter_room',roomPin,listName,quizCount,groupName,groupStudentCount, sessionId,true);
            socket.emit('pop_quiz_start',roomPin,JSON.stringify(quiz_JSON),listName);

            // $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');

            //대기방에 입장된 캐릭터와 닉네임이 없어짐
            socket.on('answer-sum', function(answer ,sessionId , quizId){


                $.ajax({
                    type: 'POST',
                    url: "{{url('/raceController/answerIn')}}",
                    dataType: 'json',
                    async:false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:"roomPin="+roomPin+"&answer="+answer+"&sessionId="+sessionId+"&quizId="+quizId,
                    success: function (result) {

                    },
                    error: function(request, status, error) {
                        alert("AJAX 에러입니다. ");
                    }
                });

                console.log('답변자수 ' , answer_count);
                console.log('입장플레이어수 ', quiz_member);
            });

            socket.on('pop_quiz_status',function(roomPin){
                submit_count++;
                $('#submit_count').text(submit_count);
            });

            socket.on('leaveRoom', function(user_num) {
                quiz_member--;

                $('#member_count').text(quiz_member);
                if(quiz_member < 1){
                    $('#member_count').text("Player");
                }
                $.ajax({
                    type: 'POST',
                    url: "{{url('/raceController/studentOut')}}",
                    dataType: 'json',
                    async: false ,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:"roomPin="+roomPin+"&sessionId="+user_num,
                    success: function (result) {
                        console.log("학생퇴장"+user_num);

                        if( result['characters'] != 'false'){
                            socket.emit('enable_character',roomPin,result['characters']);
                        }
                    },
                    error: function(request, status, error) {
                        alert("AJAX 에러입니다. ");
                    }
                });

            });

        };
    </script>
</head>
<body>

<div id="wait_room_nav" class="inline-class">
    <img  class="inline-class" src="/img/race_student/exam.png" width="100" height="100">
    <span>PopQuiz</span>
    <span  id="race_name"  style="position: absolute;  left:40%; top:2%;">레이스 제목 </span>
    <span  id="race_count" style="position: absolute;  right:20%; top:4%; font-size:20px;" > 문제수 </span>
    <span  id="group_name" style="position: absolute;  right:10%; top:4%; font-size:20px;"> groovyroom </span>
    <span id="group_student_count" style="font-size:20px; position: absolute;  right: 2%; top:4%;">학생 총 수</span>
</div>

<div id="wait_room">
    <div class="student">

        <button onclick="btn_click();" id="start_btn" class="btn btn-lg btn-primary" style="">시험시작</button>
        <button onclick="pop_end();" class="btn btn-lg btn-danger">시험 종료 </button>
        <div id="room_Pin" class="counting">
        </div>

        <div id="counting_student">
            <span id="member_count" > 학생 수</span>
        </div>

    </div>


    <ul id="messages"></ul>


    <div class="waitingTable">
        <table class="table table-bordered" id="characterTable" style="text-align: center;">

        </table>
    </div>

    <div id="guide_footer" style="position:absolute; bottom:0; background-color:lightgreen; width:100%; height:10%; color:white; font-size:40px; line-height:100px;">
        <img src="/img/Info.png" style="width:50px; height:50px;" alt="">학생들이 다 들어오면 시험시작을 클릭해주세요
    </div>
</div>

<div>
    <style>
        * {margin: 0; padding: 0;}

        .container {
            padding: 10px;
            text-align: center;
        }

        .timer {
            padding: 10px;
            background: linear-gradient(top, #222, #444);
            overflow: hidden;
            display: inline-block;
            border: 7px solid #efefef;
            border-radius: 5px;
            position: relative;

            box-shadow:
                    inset 0 -2px 10px 1px rgba(0, 0, 0, 0.75),
                    0 5px 20px -10px rgba(0, 0, 0, 1);
        }

        .cell {
            /*Should only display 1 digit. Hence height = line height of .numbers
            and width = width of .numbers*/
            width: 0.60em;
            height: 40px;
            font-size: 50px;
            overflow: hidden;
            position: relative;
            float: left;
        }

        .numbers {
            width: 0.6em;
            line-height: 40px;
            font-family: digital, arial, verdana;
            text-align: center;
            color: #fff;

            position: absolute;
            top: 0;
            left: 0;

            /*Glow to the text*/
            text-shadow: 0 0 5px rgba(255, 255, 255, 1);
        }

        /*Styles for the controls*/
        #timer_controls {
            margin-top: -5px;
        }
        #timer_controls label {
            cursor: pointer;
            padding: 5px 10px;
            background: #efefef;
            font-family: arial, verdana, tahoma;
            font-size: 11px;
            border-radius: 0 0 3px 3px;
        }
        input[name="controls"] {display: none;}

        /*Control code*/
        #stop:checked~.timer .numbers {animation-play-state: paused;}
        #start:checked~.timer .numbers {animation-play-state: running;}
        #reset:checked~.timer .numbers {animation: none;}

        .moveten {
            /*The digits move but dont look good. We will use steps now
            10 digits = 10 steps. You can now see the digits swapping instead of
            moving pixel-by-pixel*/
            animation: moveten 1s steps(10, end) infinite;
            /*By default animation should be paused*/
            animation-play-state: paused;
        }
        .movesix {
            animation: movesix 1s steps(6, end) infinite;
            animation-play-state: paused;
        }

        /*Now we need to sync the animation speed with time speed*/
        /*One second per digit. 10 digits. Hence 10s*/
        .second {animation-duration: 10s;}
        .tensecond {animation-duration: 60s;} /*60 times .second*/

        .milisecond {animation-duration: 1s;} /*1/10th of .second*/
        .tenmilisecond {animation-duration: 0.1s;}
        .hundredmilisecond {animation-duration: 0.01s;}

        .minute {animation-duration: 600s;} /*60 times .second*/
        .tenminute {animation-duration: 3600s;} /*60 times .minute*/

        .hour {animation-duration: 36000s;} /*60 times .minute*/
        .tenhour {animation-duration: 360000s;} /*10 times .hour*/

        @keyframes moveten {
            0% {top: 0;}
            100% {top: -400px;}
            /*height = 40. digits = 10. hence -400 to move it completely to the top*/
        }

        @keyframes movesix {
            0% {top: 0;}
            100% {top: -240px;}
            /*height = 40. digits = 6. hence -240 to move it completely to the top*/
        }

    </style>
    <div class="container">
        <h1><time>00:00:00</time></h1>
        <div>시험 제출자 수<span id="submit_count"></span> </div>
    </div>
</div>

</body>
</html>