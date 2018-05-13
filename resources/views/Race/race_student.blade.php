
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Waiting Room</title>
    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>

    <script>
        var active_mode;

        var characterId;
        var roomPin;
        var sessionId = 0;
        var socket = io(':8890');

        var nick;
        var web_ranking;
        var web_point;

        var web_quizId ="";
        var web_makeType;
        var web_alright;
        var web_answer_check;
        var web_correct_answer;

        var web_quiz_count;

        window.onload = function() {

            socket.on('web_enter_room',function(listName,quizCount,groupName,groupStudentCount, sessionId,enter_check){
                if(enter_check == true){

                    web_quiz_count = quizCount;

                    $('#entranceInfo_character_page').hide();
                    $('#entranceInfo_nickname_page').hide();

                    $('#race_name').html(listName);
                    $('#race_count').html(quizCount);
                    $('#group_name').html(groupName);
                    $('#group_student_count').html(groupStudentCount);

                    $('#student_guide').text('게임 시작 로딩중');

                    $('body').css("background-color","mediumslateblue");

                    $(".loading_page").show();

                }else{
                    alert('입장에실패했습니다. 입력정보를 확인해보십시오');
                }
            });

            socket.on('android_game_start',function(quizId , makeType){
                web_quizId = quizId;
                web_makeType = makeType;
                $('#entrance_page').hide();
                $('.loading_page').hide();
                $('#student_guide').text('로딩중');

                $('body').css("background-color","whitesmoke");

                $('#character_info').attr("src","/img/character/char"+ characterId +".png");

                $('#nickname_info').html(nick);
                $('#ranking_info').html('0등');
                $('#point_info').html('0point');
                switch(makeType){
                    case "obj":
                        $("#sub").hide();
                        $(".obj").show();
                        break;

                    case "sub" :
                        $(".obj").hide();
                        $("#sub").show();
                        break;
                }
                $('.contents').show();
            });

            socket.on('android_next_quiz',function(roomPin){

                switch(web_makeType){
                    case "obj":
                        $("#sub").hide();
                        $(".obj").show();
                        break;

                    case "sub" :
                        $(".obj").hide();
                        $("#sub").show();
                        break;
                }
                $('#makeTypes').show();

                $('#web_race_midresult').hide();

            });

            socket.on('race_mid_correct',function(correct){
                web_correct_answer = correct;
            });

            socket.on('android_mid_result',function(quizId, makeType, ranking){

                $('body').css("background-color","whitesmoke");
                $(".loading_page").hide();

                web_quizId = quizId;
                web_makeType = makeType;

                var ranking_json = JSON.parse(ranking);

                for(var i=0; i < ranking_json.length; i++){
                    //고쳐야되는 구문임
                    if(ranking_json[i].nick == nick) {
                        web_ranking = i + 1;
                        web_point = ranking_json[i].rightCount;
                        web_alright = ranking_json[i].answer;
                        web_answer_check = ranking_json[i].answerCheck;
                    }
                }

                $('#ranking_info').html(web_ranking+"등");
                $('#point_info').html(web_point*100+"point");
                $('#answer_content').html(web_correct_answer);

                if(web_answer_check == "X")
                    web_alright = "X";

                switch(web_alright){
                    case "O": $('#answer_check_img').attr("src","/img/right_circle.png");
                        $('#answer_check').html("정답");
                        break;
                    case "X": $('#answer_check_img').attr("src","/img/wrong.png");
                        $('#answer_check').html("오답");
                        break;
                }

                $('#race_room_nav').show();
                $('#mondai').show();

                $('#makeTypes').hide();
                $('#web_race_midresult').show();

            });

        };

        function web_answer(answer_num){

            switch(web_makeType){
                case "obj":
                    socket.emit('answer',roomPin , answer_num , sessionId , nick , web_quizId);
                    break;

                case "sub":
                    var sub_answer = document.getElementById('subanswer').value;
                    socket.emit('answer',roomPin , sub_answer , sessionId , nick , web_quizId);
                    break;
            }

            $('#makeTypes').hide();
            $('#mondai').hide();

            $('body').css("background-color","mediumslateblue");
            $(".loading_page").show();

        }

        function web_student_join(){
            roomPin = document.getElementById('roomPin').value;
            switch( active_mode ){
                case "Race":
                    var characters='<span style="font-size:40px; margin: 5% 0px 0px 40%;"> 캐릭터 선택</span><br>';

                    $.ajax({
                        type: 'POST',
                        url: "{{url('/raceController/studentIn')}}",
                        dataType: 'json',
                        async:false,
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data:"roomPin="+roomPin+"&sessionId=0",
                        success: function (result) {
                            if(result['check'] == true) {

                                sessionId = result['sessionId'];

                                socket.emit('join', roomPin);
                                characters +='<form href="#">';
                                for(var char_num =1; char_num <=28; char_num++){
                                    characters += '<label>';
                                    characters += '<input style="display:none;" name="character" id="'+char_num+'" type="radio" value="'+char_num+'" />';
                                    characters += '<img class="character_select" id="char_img'+char_num+'"  src="/img/character/char'+char_num+'.png" >'
                                    characters += '</label>';

                                }
                                characters +='</form>';

                                $('#race_menu').hide();
                                $('#roomPin_page').hide();
                                $('#entranceInfo_character_page').html(characters);
                                $('#entranceInfo_character_page').show();
                                $('#entranceInfo_nickname_page').show();

                                $('#student_guide').text('자신의 캐릭터와 닉네임을 입력하세요');
                            }
                            else{
                                alert("존재하지 않는 방입니다. 다시입력해주세요");
                            }

                        },
                        error: function(request, status, error) {
                            console.log("안드로이드 join 실패"+roomPin);
                        }
                    });
                    //ajax끝

                    break;

                case "Exam":
                    alert("쪽지시험은 미구현");
                    break;

            }

        }
        function user_in(){
            nick = document.getElementById('nickname').value;
            socket.emit('user_in',roomPin,nick,sessionId,characterId);
        }

        socket.on('race_ending',function(data){

            socket.on('race_result',function(race_result){
                alert(race_result);
            });


            $('body').css("background-color","mediumslateblue");
            $('#web_race_midresult').hide();
            $('#race_result').show();



        });

    </script>
    <script>
        $(document).ready(function(){
            //모드에서 재시험 클릭
            $('#Re-Test').click(function(){

                //다른 버튼들은 원래 색으로 돌려놓는 부분
                $('#Race').css("background","#03A9F4");
                $('#Exam').css("background","#9b59b6");
                //눌렸을떄의 색상
                $('#Re-Test').css("background","#9A0A35");

                $('#student_guide').text("재시험을 칠 레이스를 선택해주세요");
                $('#Re-Test_list').show();
                $('#roomPin_page').hide();
            });

            //모드에서 레이스 클릭
            $('#Race').click(function(){
                active_mode = "Race";

                //다른 버튼들은 원래 색으로 돌려놓는 부분
                $('#Re-Test').css("background","#ff69b4");
                $('#Exam').css("background","#9b59b6");

                //눌렸을떄의 색상
                $('#Race').css("background","#00008B");

                $('#student_guide').text("들어갈 방의 PIN번호 6자리를 입력해주세요");
                $('#roomPin_page').show();
                $('#Re-Test_list').hide();
            });

            //모드에서 쪽지시험 클릭
            $('#Exam').click(function(){
                active_mode = "Exam";

                //다른 버튼들은 원래 색으로 돌려놓는 부분
                $('#Re-Test').css("background","#ff69b4");
                $('#Race').css("background","#03A9F4");
                //눌렸을떄의 색상
                $('#Exam').css("background","#800080");

                $('#student_guide').text("쪽지시험을 칠 방의 PIN번호 6자리를 입력해주세요");
                $('#roomPin_page').show();
                $('#Re-Test_list').hide();
            });



            $(document).on("change","input[type=radio][name=character]",function(event){
                $('.character_select').css("background-color","white");
                $('#char_img'+this.value).css("background-color","yellow");
                characterId = this.value;
            });
        });
    </script>

    <style>
        .character_select{
            border-radius: 15px 50px 30px;
            background-color:white;
            border: 1px solid black;
        }
        #entranceInfo_nickname_page {
            position:absolute;
            left:25%;
            bottom:15%;
        }
        .entrance_input{
            width:400px;
            height:50px;
        }

        .loader { position: absolute; left: 50%; top: 50%; z-index: 1; width: 150px; height: 150px; margin: -75px 0 0 -75px; border: 16px solid #f3f3f3; border-radius: 50%; border-top: 16px solid #3498db; width: 120px; height: 120px; -webkit-animation: spin 2s linear infinite; animation: spin 2s linear infinite; }
        @-webkit-keyframes spin { 0% { -webkit-transform: rotate(0deg); } 100% { -webkit-transform: rotate(360deg); } }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

        #race_menu{
            margin-top:10%;
            margin-left:14%;
        }

        .race_menu_button{
            width:300px;
            height:300px;
            display:inline-block;

            transition: margin-top 0.3s ease,
            margin-left 0.3s ease,
            box-shadow 0.3s ease;

            margin-right:1%;
        }
        #Re-Test{
            background:#ff69b4;
            border: solid 1px #ff1493;

            box-shadow: 1px 0px 0px #ff1493,0px 1px 0px #ff1493,
            2px 1px 0px #ff1493,1px 2px 0px #ff1493,
            3px 2px 0px #ff1493,2px 3px 0px #ff1493,
            4px 3px 0px #ff1493,3px 4px 0px #ff1493,
            5px 4px 0px #ff1493,4px 5px 0px #ff1493,
            6px 5px 0px #ff1493,5px 6px 0px #ff1493,
            7px 6px 0px #ff1493,6px 7px 0px #ff1493,
            8px 7px 0px #ff1493,7px 8px 0px #ff1493,
            9px 8px 0px #ff1493,8px 9px 0px #ff1493;
        }
        #Re-Test:hover , #Re-Test:active ,#Re-Test:active:focus{
            background:#9A0A35;
        }
        #Race{
            background:#03A9F4;
            border: solid 1px #1976D2;

            box-shadow: 1px 0px 0px #1976D2,0px 1px 0px #1976D2,
            2px 1px 0px #1976D2,1px 2px 0px #1976D2,
            3px 2px 0px #1976D2,2px 3px 0px #1976D2,
            4px 3px 0px #1976D2,3px 4px 0px #1976D2,
            5px 4px 0px #1976D2,4px 5px 0px #1976D2,
            6px 5px 0px #1976D2,5px 6px 0px #1976D2,
            7px 6px 0px #1976D2,6px 7px 0px #1976D2,
            8px 7px 0px #1976D2,7px 8px 0px #1976D2,
            9px 8px 0px #1976D2,8px 9px 0px #1976D2;
        }
        #Race:hover, #Race:active, #Race:active:focus{
            background:#00008B;
        }
        #Exam{
            background:#9b59b6;
            border: solid 1px #8e44ad;

            box-shadow: 1px 0px 0px #8e44ad,0px 1px 0px #8e44ad,
            2px 1px 0px #8e44ad,1px 2px 0px #8e44ad,
            3px 2px 0px #8e44ad,2px 3px 0px #8e44ad,
            4px 3px 0px #8e44ad,3px 4px 0px #8e44ad,
            5px 4px 0px #8e44ad,4px 5px 0px #8e44ad,
            6px 5px 0px #8e44ad,5px 6px 0px #8e44ad,
            7px 6px 0px #8e44ad,6px 7px 0px #8e44ad,
            8px 7px 0px #8e44ad,7px 8px 0px #8e44ad,
            9px 8px 0px #8e44ad,8px 9px 0px #8e44ad;
        }
        #Exam:hover , #Exam:active, #Exam:active:focus{
            background: #800080;
        }
        .race_menu_button:active{
            transition: margin-top 0.3s ease;

            margin-left:9px;
            margin-top:9px;
            box-shadow: 0px 0px 0px #1976D2;
        }

        .race_menu_img{
            width:150px;
            height:150px;
        }
        .menu_time_img{
            width:100px;
            heihgt:50px;
        }
        .race_menu_span{
            font-size:40px;
            color:white;
        }
    </style>
</head>
<body>

<div id="entrance_page">
    <!-- 학생 레이스 입장화면 네비게이션  -->
    <div>
        @include('Navigation.main_nav')
    </div>

    <div id="race_menu">
        <button class="race_menu_button" id="Re-Test">
            <img class="menu_time_img" src="/img/race_student/freetime.png" alt=""><br>
            <img class="race_menu_img" src="/img/race_student/exam2.png" alt=""><br>
            <span class="race_menu_span">Re-Test</span>
        </button>
        <button class="race_menu_button" id="Race">
            <img class="menu_time_img" src="/img/race_student/realtime.png" alt=""><br>
            <img  class="race_menu_img" src="/img/race_student/blind_race.png" alt=""><br>
            <span class="race_menu_span">Race</span>
        </button>
        <!-- 부가기능이므로 아직은 미구현상태  -->
        <button class="race_menu_button" id="Exam" >
            <img class="menu_time_img" src="/img/race_student/realtime.png" alt=""><br>
            <img  class="race_menu_img" src="/img/race_student/exam.png" alt=""><br>
            <span class="race_menu_span">Exam</span>
        </button>
    </div>

    <div id="Re-Test_list" class="row" style="display:none; margin-top:2%;">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col col-xs-6">
                            <h3 class="panel-title">퀴즈 리스트</h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-list">
                        <thead>
                        <tr>
                            <th class="hidden-xs">#</th>
                            <th style="text-align: center">퀴즈명</th>
                            <th style="text-align: center">문항수</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="list">

                        {{--list 공간--}}

                        </tbody>
                    </table>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-xs-4">Page 1 of 5
                        </div>
                        <div class="col col-xs-8">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- 방의 핀번호 입력부분 -->
    <div id="roomPin_page" style="position:absolute; top:60%; left:40%;  display:none;">
        <br>
        <span >PIN</span>
        <input name="roomPin" id="roomPin" type="text"><button class="btn-primary" onclick="web_student_join();">확인</button>
        <input name="sessionId" type="hidden" value="0">
    </div>

    <!-- 캐릭터선택창 -->
    <div id="entranceInfo_character_page" style="display:none;"></div>

    <!-- 닉네임 입력 화면-->
    <div id="entranceInfo_nickname_page" style="display:none;">
        <span style="font-size:35px;">닉네임:</span>
        <input class="entrance_input" id="nickname" type="text"><br>
        <button onclick="user_in();" class="btn-primary" style="width:150px; height:50px; margin-left:10%;">Enter Room</button>
    </div>

    <footer style="position:absolute; bottom:0; background-color:lightgreen; width:100%; height:10%; color:white; font-size:40px; line-height:100px;">
        <img src="/img/info.png" style="width:60px; height:60px; position:absolute; bottom:20px;" alt="">
        <span id="student_guide" style="position:absolute; bottom:0; left:5%; font-size:50px;">레이스의 모드를 선택해주세요 </span>
    </footer>
</div>


<!-- 입장성공시 로딩화면 -->
<div class="loading_page" style="display:none;">
    <div class="loader"></div>
    <span id="loading_guide" style=" color:white; font-size:50px; position: absolute; left: 35%; top: 30%;  ">게임 시작 로딩중</span>
</div>


<div class="contents" style="display:none;">@include('Race.race_student_content')</div>
</body>
</html>