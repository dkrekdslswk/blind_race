
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
        window.onload = function() {

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
                            //유저한테 다시보내줌 result['characterId'];
                            socket.emit('android_enter_room',roomPin, result['characterId'], sessionId);
                        }
                        else{
                        }

                    },
                    error: function(request, status, error) {
                        alert("AJAX 에러입니다. ");
                    }
                });
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
            alert("씨발");
            var nick = document.getElementById('nickname').value;
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


    </style>
</head>
<body>
    <!-- 학생 레이스 입장화면 네비게이션  -->
    <div>
        @include('Navigation.main_nav')
    </div>

    <div id="roomPin_page" style="position:absolute; top:35%; left:40%;">
        <br>
        <span >PIN</span>

        <input name="roomPin" id="roomPin" type="text"><button class="btn-primary" onclick="web_student_join();">확인</button>
        <input name="sessionId" type="hidden" value="0">
    </div>

    <div id="entranceInfo_character_page" style="display:none;">
    </div>
        <div id="entranceInfo_nickname_page" style="display:none;">
            <span style="font-size:35px;">닉네임:</span>
            <input class="entrance_input" id="nickname" type="text"><br>
            <button onclick="user_in();" class="btn-primary" style="width:150px; height:50px;">Enter Room</button>
        </div>

    <footer style="position:absolute; bottom:0; background-color:lightgreen; width:100%; height:10%; color:white; font-size:40px; line-height:100px;">
        <img src="/img/info.png" style="width:60px; height:60px; position:absolute; bottom:20px;" alt="">
        <span id="student_guide" style="position:absolute; bottom:0; left:5%; font-size:50px;">들어갈 방의 PIN번호 6자리를 입력해주세요</span>
    </footer>
</body>
</html>