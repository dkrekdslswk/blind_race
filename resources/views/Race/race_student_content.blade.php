<link rel="stylesheet" href="css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>

    body{
        background-color:whitesmoke;
    }


    .main {
        /* Same width as the sidebar + left position in px */
        font-size: 28px;
        /* Increased text to enable scrolling */
        padding: 0 10px;
    }

    .column {
        float: left;
        width: 15%;
        padding: 20px;
        height: 20%;
        margin-left:50px;
        margin-top:10%;
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
        top:10%;
    }
    #mondai {
        top: 10%;
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

        width: 55%;
        height: 35%;
        border-radius: 20px;
        font-weight: bold;
        font-size: 30px;
        position: absolute;
        left: 25%;
        top: 50%;
    }
    .inline-class{
        display:inline-block;
    }
    #my_character {
        box-shadow: 60px 60px 100px -90px #000000, 60px 0px 100px -70px #000000;
        background-color: rgba(255,255,255,.84);
        width: 150px;
        height: 150px;
        border-radius: 20px;
        font-size: 30px;
        position: absolute;
        right: 5%;
        top: 15%;
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

<script>

</script>

<div class="main" style="">
    <div id='content'>

            <progress style="width:100%;  height:30px;"  value="0" max="30" id="progressBar"></progress>
            <div id="questions" style="height:250px;">

                <div class="inline-class" id="counter"></div>

                <div class="inline-class" id="mondai"><br><span id="mondai-content"></span></div>

                <div class="inline-class" id="my_character"><img src="#" alt=""></div>

            </div>


        <!--문제 번호-->
        <div class="obj" style="margin-left:4%; display:none; ">
            <!-- style="margin-left:10%;" -->
            <div class="column" style="background-color:#1bbc9b; ">
                <p class="answer_font" id="answer1">A</p>
            </div>
            <div class="column" style="background-color:#3598db;">
                <p class="answer_font" id="answer2">B</p>
            </div>
            <div class="column" style="background-color:#f1c40f;">
                <p class="answer_font" id="answer3">C</p>
            </div>
            <div class="column" style="background-color:#e84c3d;">
                <p class="answer_font" id="answer4">D</p>
            </div>
        </div>

        <div class="btn-primary" id="sub" ">
        <input type="text" style="  width:100%; height:150px; font-size:70px; color:black; border:2px solid silver;">
        <button onclick="user_in();" class="btn-primary" style="width:100%; height:40%; border:none;">확인</button>
        </div>

    </div>
</div>
