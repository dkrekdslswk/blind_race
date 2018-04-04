
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
        #mid_result{
            margin-left:160px;
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

        var timeleft = 20;

        var quiz_JSON = [
            {"quiz_num":"1", "name":"아",　"answer1":"あ", "answer2":"い",	"answer3":"い","answer4":"お"},
            {"quiz_num":"2", "name":"카",　"answer1":"か", "answer2":"き",	"answer3":"く","answer4":"け"},
            {"quiz_num":"3", "name":"사","answer1":"さ", "answer2":"し",	"answer3":"す","answer4":"せ"},
            {"quiz_num":"4", "name":"타","answer1":"た", "answer2":"ち",	"answer3":"つ","answer4":"て"},
            {"quiz_num":"5", "name":"하","answer1":"は", "answer2":"ひ",	"answer3":"ふ","answer4":"へ"}
        ];


<<<<<<< HEAD
        
        socket.emit('count','1');
  
        socket.on('mid_ranking',function(data){
            document.getElementById('counter').innerText= " ";
            
            $("#content").hide();
            $("#mid_result").html(data);
            $("#mid_result").show();
            setTimeout(function(){ socket.emit('count','time on');  $("#content").show();  $("#mid_result").hide(); socket.emit('android_nextkey','미정'); }, 3000);
=======

        socket.emit('count','1');

        socket.on('mid_ranking',function(data){
            document.getElementById('counter').innerText= " ";

            $("#content").hide();
            $("#mid_result").html(data);
            $("#mid_result").show();
            setTimeout(function(){ socket.emit('count','time on');  $("#content").show();  $("#mid_result").hide();  }, 3000);
            socket.emit('android_nextquiz','미정');
>>>>>>> f49fe5743c6aafafca2c009a04a41f2c8a8407e1
        });

        socket.on('timer', function (data) {
            var counting = data/1000;
            document.getElementById('counter').innerText= counting;
<<<<<<< HEAD
            
             document.getElementById("progressBar")
                    .value = 20 - counting;
                if (timeleft == 0)
                    timeleft = 20;
        
            
=======

            document.getElementById("progressBar")
                .value = 20 - counting;
            if (timeleft == 0)
                timeleft = 20;


>>>>>>> f49fe5743c6aafafca2c009a04a41f2c8a8407e1
            if(counting == 0 )
                socket.emit('count_off','on');
        });

        //상탄 타임 게이지 바
<<<<<<< HEAD
       
=======

>>>>>>> f49fe5743c6aafafca2c009a04a41f2c8a8407e1

        var x = document.getElementById("mondai");
        var A1 = document.getElementById("answer1");
        var A2 = document.getElementById("answer2");
        var A3 = document.getElementById("answer3");
        var A4 = document.getElementById("answer4");


        socket.on('answer-sum', function(data){
            document.getElementById('answer_c').innerText= data+ "/6명(db) 풀이완료";

            if(data == 2)
            {

                socket.emit('count_off','on');
                document.getElementById('answer_c').innerText= "0/6명(db) 풀이완료";

            }
        });

        socket.on('nextok',function(data){
<<<<<<< HEAD
           
            if(quiz_JSON.length == data){
                 location.href="/recordbox";
            }
            else{
             x.innerText  = quiz_JSON[data].name ;
            A1.innerText = quiz_JSON[data].answer1;
            A2.innerText = quiz_JSON[data].answer2;
            A3.innerText = quiz_JSON[data].answer3;
            A4.innerText = quiz_JSON[data].answer4;
            
=======

            if(quiz_JSON.length == data){
                x.innerText  =  "문제끝";
                A1.innerText =  "문제끝";
                A2.innerText =  "문제끝";
                A3.innerText =  "문제끝";
                A4.innerText = "문제끝";
            }
            else{
                x.innerText  = quiz_JSON[data].name ;
                A1.innerText = quiz_JSON[data].answer1;
                A2.innerText = quiz_JSON[data].answer2;
                A3.innerText = quiz_JSON[data].answer3;
                A4.innerText = quiz_JSON[data].answer4;

>>>>>>> f49fe5743c6aafafca2c009a04a41f2c8a8407e1
            }
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
                <progress style="width:100%;"  value="0" max="20" id="progressBar"></progress>
                <div id="questions">
                    <form name="formName" action="url_with_programming_here" method="POST">
                        <h1 id="counter"></h1>
                        <h2 id="mondai"></h2>
                    </form>
            </center>
        </div>
<<<<<<< HEAD
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
</div>

<div id='mid_result' style='display:none;'>
    <div id="app">
    </div>
</div>
 
 
=======
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
</div>

<div id='mid_result' style='display:none;'>
    <div class="jumbotron">
        <h1 class="display-4">Hello, world!</h1>
        <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
        <hr class="my-4">
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
        </p>
    </div>

>>>>>>> f49fe5743c6aafafca2c009a04a41f2c8a8407e1
</div>

</body>
</html>
























