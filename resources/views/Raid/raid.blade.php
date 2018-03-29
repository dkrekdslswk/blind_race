
<!doctype html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    
                  <style type="text/css">
				body {
					font-family: "Lato", sans-serif;
				}
                    questions {
                        width: 100%;
                        margin: 0 auto;
                    }
                    /*this margin is to center the div automatically, just in case*/
                    .left_options,
                    .right_optiones {
                        width: 45%;
                        float: left;
                    }

					.sidenav {
					height: 100%;
					width: 160px;
					position: fixed;
					z-index: 1;
					top: 0;
					right: 0;
					background-color: #111;
					overflow-x: hidden;
					padding-top: 20px;
				}

				.sidenav a {
					padding: 6px 8px 6px 16px;
					text-decoration: none;
					font-size: 25px;
					color: #818181;
					display: block;
				}

				.sidenav a:hover {
					color: #f1f1f1;
				}

				.main {
					margin-left: 160px; /* Same as the width of the sidenav */
					font-size: 28px; /* Increased text to enable scrolling */
					padding: 0px 10px;
				}

				.column {
					float: left;
					width: 25%;
					padding: 20px;
					height: 300px;
					border-radius: 20px;
				}

				.row:after {
					content: "";
					display: table;
					clear: both;
				}
				
				
				@media screen and (max-height: 450px) {
					.sidenav {padding-top: 15px;}
					.sidenav a {font-size: 18px;}
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
            
            var quiz_number = 0;
            
            var timeleft = 10;
            
            var quiz_JSON = [
    		{"quiz_num":"1", "name":"今元気ですか",　"answer1":"はい", "answer2":"いいえ",	"answer3":"分からない","answer4":"分かる"},
    		{"quiz_num":"2", "name":"怒った？",　"answer1":"はい", "answer2":"いいえ",	"answer3":"分からない","answer4":"分かる"},
    		{"quiz_num":"3", "name":"気持ちいいいいいい","answer1":"はい", "answer2":"いいえ",	"answer3":"分からない","answer4":"分かる"}
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
                
                // setTimeout(function(){
                //     quiz_number++;
                //     socket.emit('nextquiz',quiz_number);
                // },10000);

                // setTimeout(function(){ x.innerText="2번문제";}, 30000);
            
        
        	socket.on('answer-sum', function(data){
                document.getElementById('answer_c').innerText= data+ "/6명(db) 풀이완료";
                
                if(data == 6)
                    {
                        setTimeout(function(){
                            socket.emit('nextquiz','뭐넣징ㅎ');
                             document.getElementById('answer_c').innerText= "0/6명(db) 풀이완료";
                        }, 1000);
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

<div id="counter">zzz</div>
<div id="answer_c">0/6명(db) 풀이완료</div>

            <div class="sidenav">
			<p>asd</p>
			<p>asd</p>
			<p>asd</p>
			</div>

			<div id='content'></div>

			<div id="load_tweets">
                <center>
                    <progress style="width:100%;"  value="0" max="10" id="progressBar"></progress>

                    <div id="questions">
                        <form name="formName" action="url_with_programming_here" method="POST">
                            <h2 id="mondai">json을 잘몰겠슴다</h2>

                        </form>
                    </center>
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
			




</body>
</html>






























<!--<html></html>-->
<!--    <head>-->
<!--        <title>BLUEB</title>-->
<!--        <link-->
<!--            rel="stylesheet"-->
<!--            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
<!--        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>-->
<!--		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>-->
        
<!--		<script src="http://code.jquery.com/jquery-latest.min.js"></script>-->
<!--          <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>-->


<!--        <script>-->
                

<!--        </script>-->
        
<!--        <script>-->
<!--        window.onload= function timedText() {-->
       
            
<!--        };-->
<!--        </script>-->

<!--		   <script type="text/javascript">-->

<!--			var race = '{\-->
<!--					"race":[{\-->
<!--						"raceName":"스쿠스쿠문법1",\-->
<!--						"raceCount":30}],\-->
<!--					"group":[{\-->
<!--						"groupName":"2학년 특강 A반",\-->
<!--						"groupStudentCount":6}]\-->
<!--					}';-->
<!--			var members = ["egoing","k8805","sorialgi"];-->

<!--			var getJsonDate = JSON.parse(race);-->

		
<!--			</script>-->

<!--		<script>-->
		
<!--		</script>-->
	

<!--        <body>-->
		

<!--	  </body>-->


	  
<!--		<script>-->
<!--			$('#race_name').html(getJsonDate.race[0].raceName);-->
<!--			$('#race_count').html(getJsonDate.race[0].raceCount);-->
<!--			$('#group_name').html(getJsonDate.group[0].groupName);-->
			
			

			
<!--		</script>-->

	 


		