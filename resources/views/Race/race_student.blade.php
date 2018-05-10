
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
        var characterId;
        var roomPin;
        var sessionId = 0;
        var socket = io(':8890');
        var nick;

        var web_quizId ="";
        window.onload = function() {

            socket.on('web_enter_room',function(listName,quizCount,groupName,groupStudentCount, sessionId,enter_check){
                if(enter_check == true){

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
                $('#entrance_page').hide();
                $('#student_guide').text('로딩중');

                $('body').css("background-color","whitesmoke");

                $('#character_info').css("src","/img/character/char'+ characterId +'.png");
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

        };

        function web_student_join(){
            roomPin = document.getElementById('roomPin').value;

            var characters='<span style="font-size:40px; margin: 5% 0px 0px 40%;"> 캐릭터 선택</span><br>';

            $.ajax({
                type: 'POST',
                url: "{{url('/raceController/studentIn')}}",
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:"roomPin="+roomPin+"&sessionId=0",
                success: function (result) {
                    if(result['check'] == true) {
                        socket.emit('join', roomPin);
                        characters +='<form href="#">';
                        for(var char_num =1; char_num <=28; char_num++){
                            characters += '<label>';
                            characters += '<input style="display:none;" name="character" id="'+char_num+'" type="radio" value="'+char_num+'" />';
                            characters += '<img class="character_select" id="char_img'+char_num+'"  src="/img/character/char'+char_num+'.png" >'
                            characters += '</label>';

                        }
                        characters +='</form>';

                        $('#roomPin_page').hide();
                        $('#entranceInfo_character_page').html(characters);
                        $('#entranceInfo_character_page').show();
                        $('#entranceInfo_nickname_page').show();

                         $('#student_guide').text('자신의 캐릭터와 닉네임을 입력하세요');
                    }
                    else{

                    }

                },
                error: function(request, status, error) {
                    console.log("안드로이드 join 실패"+roomPin);
                }
            });
        }
        function user_in(){
            nick = document.getElementById('nickname').value;
            socket.emit('user_in',roomPin,nick,sessionId,characterId);
        }


    </script>
    <script>
        $(document).ready(function(){
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

    </style>
</head>
<body>

<div id="entrance_page">
    <!-- 학생 레이스 입장화면 네비게이션  -->
    <div>
        @include('Navigation.main_nav')
    </div>

    <!-- 방의 핀번호 입력부분 -->
    <div id="roomPin_page" style="position:absolute; top:35%; left:40%;">
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

    <!-- 입장성공시 로딩화면 -->
    <div class="loading_page" style="display:none;">
        <div class="loader"></div>
        <span id="loading_guide" style=" color:white; font-size:50px; position: absolute; left: 35%; top: 30%;  ">게임 시작 로딩중</span>
    </div>

    <footer style="position:absolute; bottom:0; background-color:lightgreen; width:100%; height:10%; color:white; font-size:40px; line-height:100px;">
        <img src="/img/info.png" style="width:60px; height:60px; position:absolute; bottom:20px;" alt="">
        <span id="student_guide" style="position:absolute; bottom:0; left:5%; font-size:50px;">들어갈 방의 PIN번호 6자리를 입력해주세요</span>
    </footer>
</div>

    <div class="contents" style="display:none;">@include('race.race_student_content')</div>
</body>
</html>