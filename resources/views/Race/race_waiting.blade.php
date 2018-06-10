
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
            background-color:#4ac3d5 !important;

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
            display: block;
            text-align: right;
            background-color: #6ecfdd;
            padding-top: 50px;
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

        .user_character{
            width:50px;
            height:50px;
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


        var answer_count = 0;
        var roomPin ='<?php echo $response['roomPin']; ?>';
        var t_sessionId = '<?php echo $response['sessionId']; ?>';
        var quiz_JSON = JSON.parse('<?php echo json_encode($response['quizs']['quiz']); ?>');

        var listName = '<?php echo $response['list']['listName']; ?>';
        var quizCount = '<?php echo $response['list']['quizCount']; echo "문제"; ?>';
        var groupName = '<?php echo $response['group']['groupName']; ?>';
        var groupStudentCount = '<?php echo "총원: "; echo $response['group']['groupStudentCount']; echo "명"; ?>';
        window.onload = function() {



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
                            $('<li class="user_in_room" id="'+ sessionId +'"><img class="user_character" src="/img/character/char'+characterId+'.png"><span style="text-align:center; color:white; background-color:black;">' + nick
                                + '</span></li>').appendTo('body');

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

            (function($) {
                if ($.fn.style) {
                    return;
                }

                // Escape regex chars with \
                var escape = function(text) {
                    return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
                };

                // For those who need them (< IE 9), add support for CSS functions
                var isStyleFuncSupported = !!CSSStyleDeclaration.prototype.getPropertyValue;
                if (!isStyleFuncSupported) {
                    CSSStyleDeclaration.prototype.getPropertyValue = function(a) {
                        return this.getAttribute(a);
                    };
                    CSSStyleDeclaration.prototype.setProperty = function(styleName, value, priority) {
                        this.setAttribute(styleName, value);
                        var priority = typeof priority != 'undefined' ? priority : '';
                        if (priority != '') {
                            // Add priority manually
                            var rule = new RegExp(escape(styleName) + '\\s*:\\s*' + escape(value) +
                                '(\\s*;)?', 'gmi');
                            this.cssText =
                                this.cssText.replace(rule, styleName + ': ' + value + ' !' + priority + ';');
                        }
                    };
                    CSSStyleDeclaration.prototype.removeProperty = function(a) {
                        return this.removeAttribute(a);
                    };
                    CSSStyleDeclaration.prototype.getPropertyPriority = function(styleName) {
                        var rule = new RegExp(escape(styleName) + '\\s*:\\s*[^\\s]*\\s*!important(\\s*;)?',
                            'gmi');
                        return rule.test(this.cssText) ? 'important' : '';
                    }
                }

                // The style function
                $.fn.style = function(styleName, value, priority) {
                    // DOM node
                    var node = this.get(0);
                    // Ensure we have a DOM node
                    if (typeof node == 'undefined') {
                        return this;
                    }
                    // CSSStyleDeclaration
                    var style = this.get(0).style;
                    // Getter/Setter
                    if (typeof styleName != 'undefined') {
                        if (typeof value != 'undefined') {
                            // Set style property
                            priority = typeof priority != 'undefined' ? priority : '';
                            style.setProperty(styleName, value, priority);
                            return this;
                        } else {
                            // Get style property
                            return style.getPropertyValue(styleName);
                        }
                    } else {
                        // Get CSSStyleDeclaration
                        return style;
                    }
                };
            })(jQuery);


            var body = $("body");
            body.style('background-color', 'whitesmoke', 'important');


            var Mid_result_Timer;

            var socket = io(':8890'); //14
            socket.emit('join', roomPin);
            $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');
            socket.emit('android_game_start',roomPin, quiz_JSON[0].quizId , quiz_JSON[0].makeType);

            //대기방에 입장된 캐릭터와 닉네임이 없어짐
            $('.user_in_room').remove();

            $('#wait_room').hide();
            $('#playing_contents').show();
            //아아아
            var timeleft = 20;

            socket.emit('count','1',roomPin , quiz_JSON[0].makeType);


            socket.on('answer-sum', function(answer ,sessionId , quizId){
                if(answer == 1 || answer == 2||answer == 3 || answer == 4)
                {
                    switch(answer){
                        case '1': A_count++;
                            break;
                        case '2': B_count++;
                            break;
                        case '3': C_count++;
                            break;
                        case '4': D_count++;
                            break;
                    }
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

                if(answer_count == quiz_member)
                {
                    if( quiz_numbar == quiz_JSON.length )
                        socket.emit('count_off',quiz_numbar , roomPin , quiz_JSON[quiz_numbar-1].makeType);
                    else
                        socket.emit('count_off',quiz_numbar , roomPin , quiz_JSON[quiz_numbar].makeType);



                    document.getElementById('answer_c').innerText="Answers";
                }
            });


            socket.on('mid_ranking',function(quizId){

                document.getElementById('counter').innerText= " ";
                $("#content").hide();
                document.getElementById('answer_c').innerText= "Answers";
                $('#play_bgm').remove();
                $('<audio id="mid_result_bgm" autoplay><source src="/bgm/mid_result.mp3"></audio>').appendTo('body');

                // ranking_process(ranking_j);
                $.ajax({
                    type: 'POST',
                    url: "{{url('/raceController/result')}}",
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data:"quizId="+quiz_JSON[quizId-1].quizId+"&sessionId="+t_sessionId,
                    success: function (result) {
                        if(result['check'] == true) {
                            console.log("성공" + t_sessionId + "," + quiz_JSON[quizId - 1].quizId);

                            //학생들에게 정답이 뭐였었는지 전달
                            socket.emit('race_mid_correct',roomPin,quiz_JSON[quizId-1].right);

                            var correct_count = result['rightAnswer'];
                            var incorrect_count =result['wrongAnswer'];

                            // if(correct_count == 0)
                            //     incorrect_count = 1 ;

                            $("#quiz_number").text(quizId);

                            var correct_percentage =Math.floor(correct_count / (correct_count + incorrect_count) * 100);

                            // correct_percentage
                            $("#Mid_Q_Name").text(quiz_JSON[quizId-1].question);
                            $("#Mid_A_Right").text(quiz_JSON[quizId-1].right);

                            $('#mid_percent').text(correct_percentage+"%");
                            $('#mid_circle').attr('class','c100 p'+correct_percentage+' green');



                            //통계 부분
                            $('#A_count').text(A_count);
                            $('#B_count').text(B_count);
                            $('#C_count').text(C_count);
                            $('#D_count').text(D_count);

                            var sum_count = A_count+B_count+C_count+D_count;
                            var A_mark = Math.floor(A_count / sum_count * 100 / 5 * 9 );
                            var B_mark = Math.floor(B_count / sum_count * 100 / 5 * 9 );
                            var C_mark = Math.floor(C_count / sum_count * 100 / 5 * 9 );
                            var D_mark = Math.floor(D_count / sum_count * 100 / 5 * 9 );

                            $('#A_mark').css('height',A_mark+"px");
                            $('#B_mark').css('height',B_mark+"px");
                            $('#C_mark').css('height',C_mark+"px");
                            $('#D_mark').css('height',D_mark+"px");

                            A_count = 0;
                            B_count = 0;
                            C_count = 0;
                            D_count = 0;

                            ranking_process(result['studentResults']);

                            if( quiz_numbar >quiz_JSON.length){
                                quiz_numbar--;
                                quiz_continue = false;
                            }

                            socket.emit('android_mid_result', roomPin, quiz_JSON[quiz_numbar-1].quizId ,quiz_JSON[quiz_numbar-1].makeType , JSON.stringify(result['studentResults']) );
                        }
                    },
                    error: function(request, status, error) {
                        console.log("ajax실패"+t_sessionId+","+quiz_JSON[quizId-1].quizId);
                    }
                });

                $("#mid_result").show();

                Mid_result_Timer = setTimeout(function(){
                    $('#mid_result_bgm').remove();
                    socket.emit('count','time on',roomPin);

                    $("#content").show();
                    $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');
                    $("#mid_result").hide();

                    if(quiz_continue == true)
                        socket.emit('android_next_quiz',roomPin);
                }, 99999999999);
            });


            $("#Mid_skip_btn").click(function(){

                clearTimeout(Mid_result_Timer);

                $('#mid_result_bgm').remove();
                socket.emit('count','time on',roomPin);


                $("#content").show();
                $('<audio id="play_bgm" autoplay><source src="/bgm/sound.mp3"></audio>').appendTo('body');

                $("#mid_result").hide();

                if(quiz_continue == true )
                    socket.emit('android_next_quiz',roomPin);
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

            //상탄 타임 게이지 바


            var x = document.getElementById("mondai-content");

            var A = new Array();

            A[1] = document.getElementById("answer1");
            A[2] = document.getElementById("answer2");
            A[3] = document.getElementById("answer3");
            A[4] = document.getElementById("answer4");

            socket.on('nextok',function(data, makeType){
                answer_count = 0 ;
                quiz_numbar++;

                console.log("넥스트"+data);

                if(quiz_JSON.length == data){
                    $("#content").remove();
                    $('#Mid_skip_btn').attr("href", "/race_result?roomPin="+roomPin);
                }
                else{

                    x.innerText  = quiz_JSON[data].question ;

                    switch(makeType){

                        case "obj" :
                            shuffle(quiz_answer_list);

                            A[ quiz_answer_list[0] ].innerText = quiz_JSON[data].right;
                            A[ quiz_answer_list[1] ].innerText = quiz_JSON[data].example1;
                            A[ quiz_answer_list[2] ].innerText = quiz_JSON[data].example2;
                            A[ quiz_answer_list[3] ].innerText = quiz_JSON[data].example3;

                            real_A[quiz_answer_list[0]] = quiz_JSON[data].right;
                            real_A[quiz_answer_list[1]] = quiz_JSON[data].example1;
                            real_A[quiz_answer_list[2]] = quiz_JSON[data].example2;
                            real_A[quiz_answer_list[3]] = quiz_JSON[data].example3;


                            rightAnswer = quiz_answer_list[0];

                            $("#sub").hide();
                            $(".obj").show();
                            break;

                        case "sub" :

                            if(quiz_JSON[data].hint==null)
                                quiz_JSON[data].hint = "없음";

                            $('#sub').html('주관식문제 <br>Hint : '+quiz_JSON[data].hint);

                            $(".obj").hide();
                            $("#sub").show();
                            break;
                    }
                }

            });
        };
    </script>
</head>
<body>

<div id="wait_room_nav" class="inline-class">
    <img  class="inline-class" src="/img/blind_race.png" width="100" height="100">
    <span>Race</span>
    <span  id="race_name"  style="position: absolute;  left:40%; top:2%;">레이스 제목 </span>
    <span  id="race_count" style="position: absolute;  right:20%; top:4%; font-size:20px;" > 문제수 </span>
    <span  id="group_name" style="position: absolute;  right:10%; top:4%; font-size:20px;"> groovyroom </span>
    <span id="group_student_count" style="font-size:20px; position: absolute;  right: 2%; top:4%;">학생 총 수</span>
</div>

<div id="wait_room">
    <div class="student">

        <div id="room_Pin" class="counting">
        </div>

        <div id="counting_student">
            <span id="student_count" > 학생 수</span>
        </div>
        <button onclick="btn_click();" id="start_btn" class="btn btn-lg btn-primary" style="">시작하기</button>

    </div>


    <ul id="messages"></ul>


    <div class="waitingTable">
        <table class="table table-bordered" id="characterTable" style="text-align: center;">

        </table>
    </div>

    <div id="guide_footer" style="position:absolute; bottom:0; background-color:lightgreen; width:100%; height:10%; color:white; font-size:40px; line-height:100px;">
        <img src="/img/Info.png" style="width:50px; height:50px;" alt="">학생들이 다 들어오면 시작하기를 눌러주세요
    </div>
</div>
<div id="playing_contents" style="display:none;">
    @include('Race.race_content')
</div>
</body>
</html>