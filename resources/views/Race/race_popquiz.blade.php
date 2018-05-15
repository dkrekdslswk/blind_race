
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
        var quiz_numbar = 0;
        var quiz_member = 0;
        var quiz_continue = true;
        var quiz_answer_list = [1,2,3,4];
        var rightAnswer;

        var real_A;

        var answer_count = 0;
        window.onload = function() {
            {{--var quiz_answer_list = [1,2,3,4];--}}
            {{--var rightAnswer;--}}
            {{--var quiz_member = 0;--}}

            {{--var real_A = new Array();--}}

            {{--var answer_count = 0;--}}
            {{--var roomPin ='<?php echo $response['roomPin']; ?>';--}}
            {{--var t_sessionId = '<?php echo $response['sessionId']; ?>';--}}
            {{--var quiz_JSON = JSON.parse('<?php echo json_encode($response['quizs']['quiz']); ?>');--}}

            {{--var listName = '<?php echo $response['list']['listName']; ?>';--}}
            {{--var quizCount = '<?php echo $response['list']['quizCount']; echo "문제"; ?>';--}}
            {{--var groupName = '<?php echo $response['group']['groupName']; ?>';--}}
            {{--var groupStudentCount = '<?php echo "총원: "; echo $response['group']['groupStudentCount']; echo "명"; ?>';--}}

            var socket = io(':8890');

            // $('#race_name').html(listName);
            // $('#race_count').html(quizCount);
            // $('#group_name').html(groupName);
            // $('#group_student_count').html(groupStudentCount);

            $('#room_Pin').html("PIN:"+roomPin);
            socket.emit('join', roomPin);

            socket.on('android_join',function(roomPin,sessionId){

                $.ajax({
                    type: 'POST',
                    url: "{{url('/raceController/studentIn')}}",
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:"roomPin="+roomPin+"&sessionId="+sessionId,
                    success: function (result) {
                        if(result['check'] == true)
                            socket.emit('android_join_check',true , sessionId);
                        else
                            socket.emit('android_join_check',false, sessionId);
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
                            $('<li class="user_in_room" id="'+ sessionId +'"><h4 style="text-align:center; color:white; background-color:black;">' + nick + '</h4></li>').appendTo('body');

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
            })
        };
        // var quiz_JSON = [
        //     {"quizCount":"1", "question":"1번문제",　"right":"あ", "example1":"い",	"example2":"い","example3":"お","quizId":"5","quizType":"vocabulary","makeType":"sub","hint":""},
        //     {"quizCount":"2", "question":"2번문제",　"right":"か", "example1":"き",	"example2":"く","example3":"け","quizId":"4","quizType":"word","makeType":"obj","hint":""},
        //     {"quizCount":"3", "question":"3번문제","right":"さ", "example1":"し",	"example2":"す","example3":"せ","quizId":"3","quizType":"grammar","makeType":"sub","hint":""},
        //     {"quizCount":"4", "question":"4번문제","right":"た", "example1":"ち",	"example2":"つ","example3":"て","quizId":"2","quizType":"vocabulary","makeType":"obj","hint":""},
        //     {"quizCount":"5", "question":"5번문제","right":"はい", "example1":"いいえ",	"example2":"分からない","example3":"分かる","quizId":"1","quizType":"word","makeType":"obj","hint":""}
        // ];


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

        function btn_click(){

            var socket = io(':8890'); //14
            socket.emit('join', roomPin);
            $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');
            socket.emit('android_game_start',roomPin, quiz_JSON[0].quizId , quiz_JSON[0].makeType);

            //대기방에 입장된 캐릭터와 닉네임이 없어짐
            $('.user_in_room').remove();

            $('#playing_contents').show();

            socket.on('answer-sum', function(answer ,sessionId , quizId){

                if(answer == 1 || answer == 2||answer == 3 || answer == 4)
                {
                    if( answer == rightAnswer)
                        answer = real_A[rightAnswer];
                    else{
                        answer = real_A[answer];
                    }
                }

                $.ajax({
                    type: 'POST',
                    url: "{{url('/raceController/answerIn')}}",
                    dataType: 'json',
                    async:false,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:"roomPin="+roomPin+"&answer="+answer+"&sessionId="+sessionId+"&quizId="+quizId,
                    //+quiz_JSON[quiz_numbar-1].quizId
                    success: function (result) {
                        answer_count++;
                        document.getElementById('answer_c').innerText= answer_count;
                    },
                    error: function(request, status, error) {
                        alert("AJAX 에러입니다. ");
                    }
                });

                console.log('답변자수 ' , answer_count);
                console.log('입장플레이어수 ', quiz_member);
            });





            socket.on('timer', function (data) {

                var counting = data/1000;
                document.getElementById('counter').innerText= counting;

                document.getElementById("progressBar")
                    .value = 30 - counting;
                if (timeleft == 0)
                    timeleft = 30;

                if(counting == 0 ){
                    if( quiz_numbar == quiz_JSON.length )
                        socket.emit('count_off',quiz_numbar , roomPin , quiz_JSON[quiz_numbar-1].makeType);
                    else
                        socket.emit('count_off',quiz_numbar , roomPin , quiz_JSON[quiz_numbar].makeType);

                }
            });

        };
    </script>
</head>
<body>

<div id="wait_room_nav" class="inline-class">
    <img  class="inline-class" src="/img/race_student/exam.png" width="100" height="100">
    <span>Race</span>
    <span  id="race_name"  style="position: absolute;  left:40%; top:2%;">레이스 제목 </span>
    <span  id="race_count" style="position: absolute;  right:20%; top:4%; font-size:20px;" > 문제수 </span>
    <span  id="group_name" style="position: absolute;  right:10%; top:4%; font-size:20px;"> groovyroom </span>
    <span id="group_student_count" style="font-size:20px; position: absolute;  right: 2%; top:4%;">학생 총 수</span>
</div>

<div id="wait_room">
    <div class="student">

        <button onclick="btn_click();" id="start_btn" class="btn btn-lg btn-primary" style="">시험시작</button>

        <div id="room_Pin" class="counting">
        </div>

        <div id="counting_student">
            <span id="student_count" > 학생 수</span>
        </div>

    </div>


    <ul id="messages"></ul>


    <div class="waitingTable">
        <table class="table table-bordered" id="characterTable" style="text-align: center;">

        </table>
    </div>

    <div id="guide_footer" style="position:absolute; bottom:0; background-color:lightgreen; width:100%; height:10%; color:white; font-size:40px; line-height:100px;">
        <img src="/img/info.png" style="width:50px; height:50px;" alt="">학생들이 다 들어오면 시험시작을 클릭해주세요
    </div>
</div>

</body>
</html>