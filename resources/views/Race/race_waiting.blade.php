
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
        html{
            width:100%;
            height:100%;
        }
        body{
            background-image: url("/img/race_waiting/wait_bg.png");
            min-height: 100%;
            background-position: center;
            background-size: cover;
        }

        .shadow {
            box-shadow: -60px 0px 100px -90px #000000, 70px 60px 100px -90px #000000;
        }

        #start_btn {

            background: #75459f;
            display: inline-block;
            position: absolute;
            width: 220px;
            border-radius: 20px;
            height: 80px;
            text-align: left;
            top: 12%;
            right: 15%;
            border:none;
        }

        #waiting_area {
            width: 90%;
            height: 100%;
            margin-left: 5%;
            border-radius: 30px;
            background-color: #ebfaff;
            padding:100px;
        }

        #race_name{
            position: absolute;
            left: 33%;
            top: 2%;
            width: 33%;
            height: 90px;
            z-index:2;
            border-radius: 100px;
            background-color: #033981;
            color: white;
            background: linear-gradient(to right, #033981 , #2571b7);
            font-size: 35px;
            text-align: center;
            line-height: 70px;
        }
        #wait_room{
            position: absolute;
            width: 100%;
            height: 70%;
            top: 10%;
        }

        .nick_content{
            text-align: center;
            color: black;
            font-size: 10px;
        }

        #wait_room_nav {
            background-image: url("/img/race_waiting/race_waiting_nav.png");
            width: 100%;
            height: 125px;
            border-radius: 0px 0px 70px 70px;
            font-weight: bold;
            font-size: 50px;
        }
        .user_in_room{
            display:inline-block;
            border-radius: 15px 50px 30px;
        }
        .student {
            display: block;
            text-align: right;
            padding-top: 50px;
        }

        .student form{
            display: inline;
            background-color: white;
            margin-right: 1%;
        }

        #student_count{
            color:red;
        }

        .nav_info {
            width: 10%;
            height: 60px;
            background-color: #54ace2;
            border-radius: 40px;
            text-align: center;
            color: black;
            border-bottom: 6px solid #3c98c6;
            line-height: 60px;
        }

        #counting_student {
            text-align: center;
            font-size: 25px;
            width: 220px;
            height: 80px;
            background: linear-gradient(to right, #683792, #5a3182);
            border-bottom: 5px solid #4A148C;
            display: inline-block;
            color: white;
            border-radius: 10px;
            line-height: 80px;
            position: absolute;
            top: 12%;
            left: 15%;
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
        #room_Pin {
            width: 467px;
            height: 200px;
            z-index: 0;
            font-size: 40px;
            color: white;
            position: absolute;
            top: -5%;
            left: 35%;
            display: table-cell;
            line-height: 280px;
            background-image: url("/img/race_waiting/pin_case.png");
            background-position: center;
            background-size: cover;
        }

        .user_character {
            width: 50px;
            height: 50px;
            margin-left: 30px;
            vertical-align: middle;
            border-radius: 50px;
            background: white;
            border: 3px solid yellow;
        }
        .nick_space {
            display: inline-block;
            min-width: 100px;
            height: 35px;
            border: 3px solid yellow;
            vertical-align: middle;
            border-radius: 30px;
            background-color: white;
            text-align:center;
        }
        #messages { list-style-type: none; }
        #messages li { padding: 5px 10px; }

    </style>
    <script>
        var quiz_numbar = 0;

        var quiz_continue = true;
        var quiz_answer_list = [1,2,3,4];
        var rightAnswer;
        var quiz_member = 0;

        var real_A = new Array();

        var A_count=0;
        var B_count=0;
        var C_count=0;
        var D_count=0;

        var opinion_counting=4;

        var answer_count = 0;
        var roomPin ='<?php echo $response['roomPin']; ?>';
        var t_sessionId = '<?php echo $response['sessionId']; ?>';
        var quiz_JSON = JSON.parse('<?php echo json_encode($response['quizs']['quiz']); ?>');

        var listName = '<?php echo $response['list']['listName']; ?>';
        var quizCount = '<?php echo $response['list']['quizCount']; echo "문제"; ?>';
        var groupName = '<?php echo $response['group']['groupName']; ?>';
        var groupStudentCount = '<?php echo $response['group']['groupStudentCount']; echo "명"; ?>';

        window.onload = function() {

            var socket = io(':8890');

            $('#race_name').html(listName);
            $('#race_count').html(quizCount);
            $('#group_name').html(groupName);
            $('#group_student_count').html(groupStudentCount);


            $('#mid_all_quiz').text('<?php echo $response['list']['quizCount']; ?>');


            $('#room_Pin').html(roomPin);
            socket.emit('join', roomPin);

            socket.on('android_join',function(roomPin,sessionId){

                $.ajax({
                    type: 'POST',
                    url: "{{url('/raceController/studentIn')}}",
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:"roomPin="+roomPin+"&sessionId="+sessionId,
                    success: function (result) {

                        var character_info = result['characters'].toString();
                        if(result['check'] == true)
                            socket.emit('android_join_check',true , sessionId ,"race",character_info);
                        else
                            socket.emit('android_join_check',false, sessionId ,"race");
                    },
                    error: function(request, status, error) {
                        console.log("안드로이드 join 실패"+roomPin);
                    }
                });

            });



            socket.on('user_in',function(roomPin,nick,sessionId,characterId){
                //유저정보를 DB세션에 추가함
                $.ajax({
                    type: 'POST',
                    url: "{{url('/raceController/studentSet')}}",
                    dataType: 'json',
                    async: false ,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:"nick="+nick+"&sessionId="+sessionId+"&characterId="+characterId,
                    success: function (result) {
                        console.log(result['nickCheck']);
                        if( result['nickCheck'] && result['characterCheck'] )
                        {

                            //정상작동
                            $('<li class="user_in_room" id="'+ sessionId +'">'
                                +'<img class="user_character" src="/img/character/char'+characterId+'.png">'
                                +'<div class="nick_space">'
                                +'<span class="nick_content">'
                                + nick
                                +'</span>'
                                +'</div>'
                                +'</li>').appendTo('#waiting_area');

                            quiz_member++;
                            $('#student_count').html(quiz_member);
                            //유저한테 다시보내줌 result['characterId'];

                            socket.emit('web_enter_room',roomPin,listName,quizCount,groupName,groupStudentCount, sessionId,true);
                            socket.emit('android_enter_room',roomPin, result['characterId'], sessionId);
                        }
                        else{
                            socket.emit('web_enter_room',roomPin,nick,sessionId,characterId,false);
                            //닉네임이나 캐릭터가 문제있음
                            socket.emit('android_enter_room',roomPin, false, sessionId);
                        }

                    },
                    error: function(request, status, error) {
                        alert("AJAX 에러입니다. ");
                    }
                });
            });

            socket.on('leaveRoom', function(user_num){
                $('#'+user_num).remove();
                quiz_member--;
                $('#student_count').text(quiz_member);
                $('#all_member').text("/"+quiz_member);

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

        // function quiz_skip(){
        //     var socket = io(':8890'); //14
        //
        //     if( quiz_numbar == quiz_JSON.length )
        //         socket.emit('count_off',quiz_numbar , roomPin , quiz_JSON[quiz_numbar-1].makeType);
        //     else
        //         socket.emit('count_off',quiz_numbar , roomPin , quiz_JSON[quiz_numbar].makeType);
        // }

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


        //순위 변동 함수 정의
        function ranking_process(ranking_j){
            var ranking_JSON = ranking_j;
            // JSON.parse(ranking_j)

            var changehtml = "";

            for(var i=0;  i <ranking_JSON.length; i++){

                var rank = i+1;

                changehtml +='<tr class="rank_hr"><td  style="width:50px; height:50px; text-align:center;">';
                changehtml +='<div style="width:30px; height:30px; background-color:white;">'+rank+'</div></td>';

                switch(i){
                    case 0: changehtml += '<td style="width:50px; height: 50px; background-color:skyblue;">'; break;
                    case 1: changehtml += '<td style="width:50px; height: 50px; background-color:yellow;">'; break;
                    case 2: changehtml += '<td style="width:50px; height: 50px; background-color:#e75480;">'; break;
                    default : changehtml += '<td style="width:50px; height: 50px; background-color:silver;">'; break;
                }
                changehtml+='<img src="/img/character/char'+ranking_JSON[i].characterId+'.png" style="width:50px; height: 50px;"  alt="">'
                    + '</td>'
                    + '<td style="width:350px; background-color:white;">'+ranking_JSON[i].nick+'</td>'
                    + '<td  style="width:150px; text-align:center; background-color:white;">'+ranking_JSON[i].rightCount*100+' Point</td>'
                    + '<td style=" background-color:white;">';


                switch(ranking_JSON[i].answerCheck){
                    case "O":
                        changehtml+='<img src="/img/right_circle.png" style="width:50px; height: 50px;"  alt=""></td></tr>';
                        break;
                    case "X" :
                        changehtml+='<img src="/img/wrong.png" style="width:50px; height: 50px;"  alt=""></td></tr>';
                        break;

                }
            }
            $('#student_rank').html(changehtml);
        }

        function btn_click(){
            if(quiz_member == 0 ){
                alert("참여한 인원이 없습니다.");
            }else {

                $("body").css('background-image', 'url("/img/race_play/play_bg.png")', 'important');
                $('#all_member').text("/"+quiz_member);

                var Mid_result_Timer;

                var socket = io(':8890'); //14
                socket.emit('join', roomPin);
                $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');
                socket.emit('android_game_start', roomPin, quiz_JSON[0].quizId, quiz_JSON[0].makeType);

                //대기방에 입장된 캐릭터와 닉네임이 없어짐
                $('.user_in_room').remove();

                $('#wait_room').hide();
                $('#playing_contents').show();
                //아아아
                var timeleft = 20;

                socket.emit('count', '1', roomPin, quiz_JSON[0].makeType);


                socket.on('answer-sum', function (answer, sessionId, quizId) {
                    if (answer == 1 || answer == 2 || answer == 3 || answer == 4) {
                        switch (answer) {
                            case '1':
                                A_count++;
                                break;
                            case '2':
                                B_count++;
                                break;
                            case '3':
                                C_count++;
                                break;
                            case '4':
                                D_count++;
                                break;
                        }
                        if (answer == rightAnswer)
                            answer = real_A[rightAnswer];
                        else {
                            answer = real_A[answer];
                        }
                    }else{
                        if(opinion_counting != 0){
                            $('<p class="opinion" style="color:navy">'+answer+'</p>').appendTo('#opinion_box');
                            opinion_counting--;
                        }
                    }

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/raceController/answerIn')}}",
                        dataType: 'json',
                        async: false,
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: "roomPin=" + roomPin + "&answer=" + answer + "&sessionId=" + sessionId + "&quizId=" + quizId,
                        //+quiz_JSON[quiz_numbar-1].quizId
                        success: function (result) {
                            answer_count++;
                            document.getElementById('answer_c').innerText = answer_count;
                        },
                        error: function (request, status, error) {
                            alert("AJAX 에러입니다. ");
                        }
                    });

                    console.log('답변자수 ', answer_count);
                    console.log('입장플레이어수 ', quiz_member);

                    if (answer_count == quiz_member) {
                        if (quiz_numbar == quiz_JSON.length)
                            socket.emit('count_off', quiz_numbar, roomPin, quiz_JSON[quiz_numbar - 1].makeType);
                        else
                            socket.emit('count_off', quiz_numbar, roomPin, quiz_JSON[quiz_numbar].makeType);


                        document.getElementById('answer_c').innerText = "0";
                    }
                });


                socket.on('mid_ranking', function (quizId) {

                    document.getElementById('counter').innerText = " ";
                    $("#content").hide();
                    document.getElementById('answer_c').innerText = "0";
                    $('#play_bgm').remove();
                    $('<audio id="mid_result_bgm" autoplay><source src="/bgm/mid_result.mp3"></audio>').appendTo('body');
                    $("body").css('background-image', 'url("/img/race_play/mid_bg.png")', 'important');
                    // ranking_process(ranking_j);
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/raceController/result')}}",
                        dataType: 'json',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: "quizId=" + quiz_JSON[quizId - 1].quizId + "&sessionId=" + t_sessionId,
                        success: function (result) {
                            if (result['check'] == true) {

                                switch (quiz_JSON[quizId - 1].makeType) {
                                    case 'sub':
                                        $('#sub_opinion').show();
                                        $('#obj_opinion').hide();
                                        break;
                                    case 'obj':
                                        $('#sub_opinion').hide();
                                        $('#obj_opinion').show();
                                        break;
                                }


                                console.log("성공" + t_sessionId + "," + quiz_JSON[quizId - 1].quizId);

                                //학생들에게 정답이 뭐였었는지 전달
                                socket.emit('race_mid_correct', roomPin, quiz_JSON[quizId - 1].right);

                                var correct_count = result['rightAnswer'];
                                var incorrect_count = result['wrongAnswer'];

                                // if(correct_count == 0)
                                //     incorrect_count = 1 ;

                                $("#quiz_number").text(quizId);

                                var correct_percentage = Math.floor(correct_count / (correct_count + incorrect_count) * 100);

                                // correct_percentage
                                $("#Mid_Q_Name").text(quiz_JSON[quizId - 1].question);
                                $("#Mid_A_Right").text(quiz_JSON[quizId - 1].right);

                                $('#mid_percent').text(correct_percentage + "%");
                                $('#mid_circle').attr('class', 'c100 p' + correct_percentage + ' green');


                                //통계 부분
                                $('#A_count').text(A_count);
                                $('#B_count').text(B_count);
                                $('#C_count').text(C_count);
                                $('#D_count').text(D_count);


                                A_count = 0;
                                B_count = 0;
                                C_count = 0;
                                D_count = 0;

                                ranking_process(result['studentResults']);

                                if (quiz_numbar > quiz_JSON.length) {
                                    quiz_numbar--;
                                    quiz_continue = false;
                                }


                                socket.emit('android_mid_result', roomPin, quiz_JSON[quiz_numbar - 1].quizId, quiz_JSON[quiz_numbar - 1].makeType, JSON.stringify(result['studentResults']));
                            }
                        },
                        error: function (request, status, error) {
                            console.log("ajax실패" + t_sessionId + "," + quiz_JSON[quizId - 1].quizId);
                        }
                    });

                    $("#mid_result").show();
                    $("#wait_room_nav").hide();
                    $("#play_frame").hide();

                });


                $("#Mid_skip_btn").click(function () {

                    // clearTimeout(Mid_result_Timer);

                    $('#mid_result_bgm').remove();
                    socket.emit('count', 'time on', roomPin);

                    $("body").css('background-image', 'url("/img/race_play/play_bg.png")', 'important');
                    $("#play_frame").show();
                    $("#wait_room_nav").show();
                    $("#content").show();
                    $("#opinion_box").empty();
                    opinion_counting=5;

                    $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');

                    $("#mid_result").hide();

                    if (quiz_continue == true)
                        socket.emit('android_next_quiz', roomPin);
                });


                socket.on('timer', function (data) {

                    var counting = data / 1000;
                    document.getElementById('counter').innerText = counting;

                    document.getElementById("progressBar")
                        .value = 30 - counting;
                    if (timeleft == 0)
                        timeleft = 30;

                    if (counting == 0) {
                        if (quiz_numbar == quiz_JSON.length)
                            socket.emit('count_off', quiz_numbar, roomPin, quiz_JSON[quiz_numbar - 1].makeType);
                        else
                            socket.emit('count_off', quiz_numbar, roomPin, quiz_JSON[quiz_numbar].makeType);

                    }
                });

                //상탄 타임 게이지 바


                var x = document.getElementById("mondai-content");

                var A = new Array();

                A[1] = document.getElementById("answer1");
                A[2] = document.getElementById("answer2");
                A[3] = document.getElementById("answer3");
                A[4] = document.getElementById("answer4");

                socket.on('nextok', function (data, makeType) {
                    answer_count = 0;
                    quiz_numbar++;

                    console.log("넥스트" + data);

                    if (quiz_JSON.length == data) {
                        $("#content").remove();
                        $('#Mid_skip_btn').attr("href", "/race_result?roomPin=" + roomPin);
                    }
                    else {

                        x.innerText = quiz_JSON[data].question;

                        switch (makeType) {

                            case "obj" :
                                shuffle(quiz_answer_list);

                                A[quiz_answer_list[0]].innerText = quiz_JSON[data].right;
                                A[quiz_answer_list[1]].innerText = quiz_JSON[data].example1;
                                A[quiz_answer_list[2]].innerText = quiz_JSON[data].example2;
                                A[quiz_answer_list[3]].innerText = quiz_JSON[data].example3;

                                $('#B' + quiz_answer_list[0]).html(quiz_JSON[data].right + '<img src="/img/right_circle.png" style="display:inline-block; width:10%; height:100%;" >');
                                $('#B' + quiz_answer_list[1]).html(quiz_JSON[data].example1);
                                $('#B' + quiz_answer_list[2]).html(quiz_JSON[data].example2);
                                $('#B' + quiz_answer_list[3]).html(quiz_JSON[data].example3);

                                real_A[quiz_answer_list[0]] = quiz_JSON[data].right;
                                real_A[quiz_answer_list[1]] = quiz_JSON[data].example1;
                                real_A[quiz_answer_list[2]] = quiz_JSON[data].example2;
                                real_A[quiz_answer_list[3]] = quiz_JSON[data].example3;


                                rightAnswer = quiz_answer_list[0];

                                $("#sub").hide();
                                $(".obj").show();
                                break;

                            case "sub" :

                                if (quiz_JSON[data].hint == null)
                                    quiz_JSON[data].hint = "ありません。";

                                $('#hint').text(quiz_JSON[data].hint);

                                $(".obj").hide();
                                $("#sub").show();
                                break;
                        }
                    }

                });
            }
        };
    </script>
</head>
<body>

<div id="wait_room_nav" class="inline-class shadow">

    <img  class="inline-class" src="/img/blind_race.png" style="width:100px; height:100px; z-index:2;">

    <span  class="nav_info" id="group_name" style="position: absolute; width:15%; left:10%; top:4%; font-size:20px;"> groovyroom </span>
    <img src="/img/race_waiting/small_tob.png" style="position: absolute;  left: 24%; top: 6%; z-index: 3; " alt="">


    <img src="/img/race_waiting/left_tob.png" style="position: absolute;  left: 25%; top: 7%; z-index: 0; width: 250px; height: 10px;" alt="">
    <img src="/img/race_waiting/big_tob.png" style="position: absolute; left: 32%; top: 4%;  z-index: 3;" alt="">
    <span  class="nav_info" id="race_name">레이스 제목 </span>
    <img src="/img/race_waiting/big_tob.png" style="position: absolute; left: 64%; top: 4%;  z-index: 3;" alt="">
    <img src="/img/race_waiting/right_tob.png" style="position: absolute;  left: 64%; top: 7%; z-index: 0; width: 250px; height: 10px;" alt="">

    <img src="/img/race_waiting/small_tob.png" style="position: absolute;  left: 72.5%; top: 6%; z-index: 3; " alt="">
    <span  class="nav_info" id="race_count" style="position: absolute;  right:17%; top:4%; font-size:20px;" > 문제수 </span>
    <img src="/img/race_waiting/small_tob.png" style="position: absolute;  left: 82%; top: 6%; z-index: 3; " alt="">

    <img src="/img/race_waiting/small_tob_line.png" style="position: absolute;  left: 82%; top: 7%; z-index: 0; width: 100px; height: 10px;" alt="">

    <span  class="nav_info" id="group_student_count" style="font-size:20px; position: absolute;  right: 2%; top:4%;">학생 총 수</span>
    <img src="/img/race_waiting/small_tob.png" style="position: absolute;  left: 87.5%; top: 6%; z-index: 3; " alt="">
</div>

<div id="wait_room">
    <div class="student">

        <div id="room_Pin" class="counting">
        </div>

    </div>




    <div class="waitingTable">
        <table class="table table-bordered" id="characterTable" style="text-align: center;">

        </table>
    </div>

    <div id="counting_student">
        <span>PLAYER:</span>
        <span id="student_count"></span>
    </div>

    <button onclick="btn_click();" id="start_btn" style="">
        <img style="display:inline-block; width:220px; height:80px;" src="/img/race_waiting/start_btn.png" alt="">
    </button>

    <div id="waiting_area" class="shadow">

    </div>

    <div id="guide_footer" style="position:fixed; bottom:0; background-color:#f27281; width:100%; height:6%; color:white; font-size:25px; ">
        <img src="/img/Info.png" style="width:30px; height:30px;" alt="">학생들이 다 들어오면 시작하기를 눌러주세요
    </div>
</div>



<div id="playing_contents" style="display:none;">
    @include('Race.race_content')
</div>
</body>
</html>