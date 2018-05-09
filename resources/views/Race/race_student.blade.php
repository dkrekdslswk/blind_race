
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

    <script type="text/javascript"></script>
    <script>
        function web_student_join(){
            var roomPin = document.getElementById('roomPin').value;

            $.ajax({
                type: 'POST',
                url: "{{url('/raceController/studentIn')}}",
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data:"roomPin="+roomPin+"&sessionId=0",
                success: function (result) {
                    if(result['check'] == true) {
                        // socket.emit('join', roomPin);
                        alert("성공");
                    }
                    else{

                    }

                },
                error: function(request, status, error) {
                    console.log("안드로이드 join 실패"+roomPin);
                }
            });


        }
    </script>
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

    <div id="entranceInfo_page">

    </div>

    <footer>
        <span style="position:absolute; bottom:0; left:10%; font-size:50px;">들어갈 방의 PIN번호 6자리를 입력해주세요</span>
    </footer>
</body>
</html>