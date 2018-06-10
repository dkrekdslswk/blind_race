<script src="//code.jquery.com/jquery-1.11.1.js"></script>
<link rel="stylesheet" href="css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style>

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
        font-size: 10px;
        color: #2196F3;
        display: block;
        margin-right: 10px;
    }
    .sidenav a:hover {
        color: #064579;
    }

    .main {
        /* Same width as the sidebar + left position in px */
        font-size: 28px;
        /* Increased text to enable scrolling */
        padding: 0 10px;
    }

    .column {
        float: left;
        width: 45%;
        padding: 20px;
        height: 40%;
        margin-left:20px;
        margin-top:10px;
        border-radius: 10px;
        border-right:5px solid #DCDCDC;
        border-bottom:5px solid #DCDCDC;
    }

    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }
        .sidenav a {
            font-size: 18px;
        }
    }
    #counter{

        margin-top:50px;
        color:black;
        width:150px;
        height:150px;
        font-size:40px;
        font-weight:bold;
        line-height:100px;
        border: 20px solid purple;
        border-radius: 50%;
        background-color: rgba(255,255,255,.84);
        position:absolute;
        left:5%;
        top:25%;
    }
    #mondai {
        top: 20%;
        position: absolute;
        left: 25%;
        box-shadow: 60px 60px 100px -90px #000000, 60px 0px 100px -70px #000000;
        background-color: rgba(255,255,255,.84);
        width: 55%;
        height: 35%;
        border-radius: 20px;
        font-weight: bold;
        font-size: 40px;
    }
    .obj{
        margin-top:12%;
    }
    #sub{
        box-shadow: 60px 60px 100px -90px #000000, 60px 0px 100px -70px #000000;
        background-color: rgba(255,255,255,.84);
        width: 55%;
        height: 35%;
        border-radius: 20px;
        font-weight: bold;
        font-size: 30px;
        position: absolute;
        left: 25%;
        top: 60%;
    }
    .inline-class{
        display:inline-block;
    }
    #mondai-content{

    }
    #answer_c {
        box-shadow: 60px 60px 100px -90px #000000, 60px 0px 100px -70px #000000;
        background-color: rgba(255,255,255,.84);
        width: 150px;
        height: 150px;
        border-radius: 20px;
        font-size: 30px;
        position: absolute;
        right: 5%;
        top: 30%;
    }
    progress {
        text-align:left;
        width: 300px;
        padding: 4px;
        border: 0 none;

        background: silver;
        border-radius: 14px;
        box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,0.2);
    }
    progress::-webkit-progress-bar {
        background: transparent;
    }
    progress::-webkit-progress-value {
        border-radius: 12px;
        background: #4CAF50;
        box-shadow: inset 0 -2px 4px rgba(0,0,0,0.4), 0 2px 5px 0px rgba(0,0,0,0.3);
    }
    .answer_font{
        font-size:45px;
        text-align:center;
        line-height:100px;
    }
</style>

<div id="client">
    <script>
    </script>

    <div class="main" style="">
        <div id='content'>

            <center>
                <progress style="width:100%;  height:30px;"  value="0" max="30" id="progressBar"></progress>
                <div id="questions" style="height:250px;">

                    <div class="inline-class" id="counter"></div>

                    <div class="inline-class" id="mondai"><br><span id="mondai-content"></span></div>

                    <div class="inline-class" id="answer_c">Answers</div>

                </div>
            </center>

            <!--문제 번호-->
            <div class="obj" style="margin-left:4%; display:none;">
                <!-- style="margin-left:10%;" -->
                <div class="column" style="background-color:#1bbc9b; ">
                    <p class="answer_font" id="answer1">1번</p>
                </div>
                <div class="column" style="background-color:#3598db;">
                    <p class="answer_font" id="answer2">2번</p>
                </div>
                <div class="column" style="background-color:#f1c40f;">
                    <p class="answer_font" id="answer3">3번</p>
                </div>
                <div class="column" style="background-color:#e84c3d;">
                    <p class="answer_font" id="answer4">4번</p>
                </div>
            </div>

            <div id="sub" style="display:none; text-align:center">
                <p class="answer_font" id="hint">주관식문제입니다.<br> 작성해서보내주세요 </p>
            </div>

        </div>
    </div>

    <div id='mid_result' style='display:block; display:none;' >
        <div>
            @include('Race.mid_result')
        </div>
    </div>
</div>

























