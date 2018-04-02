
<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">


    <style>
        body {
            font-family: "Lato", sans-serif;
        }

        .sidenav {
            width: 130px;
            position: fixed;
            z-index: 1;
            top: 20px;
            left: 10px;
            background: #eee;
            overflow-x: hidden;
            padding: 8px 0;
        }

        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 25px;
            color: #2196F3;
            display: block;
            margin-right: 10px;
        }

        .sidenav a:hover {
            color: #064579;
        }

        .main {
            margin-left: 160px;
            /* Same width as the sidebar + left position in px */
            font-size: 28px;
            /* Increased text to enable scrolling */
            padding: 0 10px;
        }

        .column {
            float: left;
            width: 25%;
            padding: 20px;
            height: 300px;
            border-radius: 20px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }
            .sidenav a {
                font-size: 18px;
            }
        }
    </style>
</head>

<body id="client">

<script src="//code.jquery.com/jquery-1.11.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
<div id="app">
</div>
<script src="{{asset('js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script>

    window.onload = function () {
        var socket = io(':8890'); //1
        //아아아
        var quiz_number = 0;

        var timeleft = 10;

        var quiz_JSON = [
            {"quiz_num":"1", "name":"1今元気ですか",　"answer1":"はい", "answer2":"いいえ",	"answer3":"分からない","answer4":"分かる"},
            {"quiz_num":"2", "name":"2怒った？",　"answer1":"はい", "answer2":"いいえ",	"answer3":"分からない","answer4":"分かる"},
            {"quiz_num":"3", "name":"3持ちいいいいいい","answer1":"はい", "answer2":"いいえ",	"answer3":"分からない","answer4":"分かる"},
            {"quiz_num":"4", "name":"4いいいいいい","answer1":"はい", "answer2":"いいえ",	"answer3":"分からない","answer4":"分かる"},
            {"quiz_num":"5", "name":"5い","answer1":"はい", "answer2":"いいえ",	"answer3":"分からない","answer4":"分かる"}
        ];

        //서버 카운트다운 인
        socket.emit('count','1');
        socket.on('timer', function (data) {
            var counting = data/1000;
            document.getElementById('counter').innerText= counting;
        });
        //상탄 타임 게이지 바
        var downloadTimer = setInterval(function () {
                document
                    .getElementById("progressBar")
                    .value = 10 - --timeleft;
                if (timeleft <= 0)
                    clearInterval(downloadTimer);
            }
            , 1000);

        var x = document.getElementById("mondai");
        var A1 = document.getElementById("answer1");
        var A2 = document.getElementById("answer2");
        var A3 = document.getElementById("answer3");
        var A4 = document.getElementById("answer4");


        socket.on('answer-sum', function(data){
            document.getElementById('answer_c').innerText= data+ "/6명(db) 풀이완료";

            if(data == 2)
            {

                socket.emit('nextquiz','뭐넣징ㅎ');
                document.getElementById('answer_c').innerText= "0/6명(db) 풀이완료";

            }
        });

        socket.on('nextok',function(data){
            x.innerText  = quiz_JSON[data].name ;
            A1.innerText = quiz_JSON[data].answer1;
            A2.innerText = quiz_JSON[data].answer2;
            A3.innerText = quiz_JSON[data].answer3;
            A4.innerText = quiz_JSON[data].answer4;

        });


    };


</script>



<div class="main">
    <div class="sidenav">
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
        <p>asd</p>
    </div>


    <div id='content'>



        <div id="answer_c">0/6명(db) 풀이완료</div>
        <div id="load_tweets">
            <center>
                <progress style="width:100%;"  value="0" max="10" id="progressBar"></progress>

                <div id="questions">
                    <form name="formName" action="url_with_programming_here" method="POST">
                        <h1 id="counter">zzz</h1>
                        <h2 id="mondai">json을 잘몰겠슴다</h2>

                    </form>
            </center>
        </div>
    </div>


    <!--문제 번호-->
    <div class="row">
        <div class="column" style="background-color:#1bbc9b; ">
            <p id="answer1">1번</p>
        </div>

        <div class="column" style="background-color:#3598db;">
            <p id="answer2">2번</p>
        </div>

        <div class="column" style="background-color:#f1c40f;">
            <p id="answer3">3번</p>
        </div>

        <div class="column" style="background-color:#e84c3d;">
            <p id="answer4">4번</p>
        </div>
    </div>




</div>

</body>
</html>
























