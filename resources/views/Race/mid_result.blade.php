<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<link
        rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">

<script
        src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link   rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<link rel="stylesheet" href="../css/circle.css">
<style type="text/css">

    body{
        background-color:whitesmoke;
    }

    #curve_chart {
        margin-top: 1em;
    }
    #Mid_Q_Name{
        font-size:40px;
    }
    #Mid_A_Right{
        font-size:40px;
        color:red;
    }

    .orange {
        background-color: #e67e22;
        box-shadow: 0px 5px 0px 0px #CD6509;
    }

    .orange:hover {
        background-color: #FF983C;
    }

    /* button div */
    #buttons {
        padding-top: 50px;
        text-align: center;
    }

    /* start da css for da buttons */
    .btn {
        border-radius: 5px;
        padding: 15px 25px;
        font-size: 22px;
        text-decoration: none;
        margin: 20px;
        color: #fff;
        position: relative;
        display: inline-block;
    }

    .btn:active {
        transform: translate(0px, 5px);
        -webkit-transform: translate(0px, 5px);
        box-shadow: 0px 1px 0px 0px;
    }
    .rank_th{
        text-align:center;
        color:white;
        background-color:deepskyblue;
    }
    .rank_hr{

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

    #student_rank td{
        border-right:5px solid deepskyblue;
    }
</style>

    <div class="block" style="display:inline-block; margin-left:15%; width:70%; height:20%; ">
        <h2 class='titular' style="line-height:30px;">
            <span id="quiz_number">1번</span>
            문제 및 정답
        </h2>

        <div class="clearfix" style="display:inline-block; width:100px; height:100px; margin-right:30px;" >
            <div class="c100 p50 green">
                <span>50%</span>
                <div class="slice">
                    <div class="bar"></div>
                    <div class="fill"></div>
                </div>
            </div>
        </div>

        <div class="divss" style="display:inline-block;">


            <div class="" style="border-radius:10px; background-color: white; display:inline-block; width:700px; height:70px; margin-bottom:10px;">
                <div style="width:100px; height:70px; display:inline-block; border-radius:8px; background-color:rebeccapurple; font-size:50px; color:white;">問題</div>
                <div style="width:550px; height:70px; display:inline-block;">
                    <span  id="Mid_Q_Name" style="font-size:20px; color:black;">姉は市役所に勤める（　　）、ボランティアで日本語を教えています。dddddddddddddddddddddddddddddddddd</span>
                </div>
            </div>

            <div class="" style="border-radius:10px;  background-color: white; display:block; width:700px; height:40px;">
                <div style="width:100px; height:40px; display:inline-block; border-radius:8px; background-color:red; font-size:30px; color:white;">正答</div>
                <span id="Mid_A_Right" style="font-size:30px;" >かたわら</span>
            </div>

        </div>
    </div>

<div id="mid_content" >

    <div id="buttons" style="position:absolute; top:30%; right: 3%;">
        <a id="Mid_skip_btn" class="btn btn-lg nextbutton orange" href="#" role="button">Next</a>
    </div>




    <div class="block" style="display: inline-block; width:46%; margin-left:15%;">
        <h2 class='titular'>Ranking board</h2>
        <table id="student_rank" style="width:100%; border-collapse: separate; border-spacing:5px 10px;">
            <tr>
                <th></th>
                <th></th>
                <th class="rank_th">Nick-Name</th>
                <th class="rank_th">Score</th>
                <th class="rank_th">Answer</th>
            </tr>

            <tr class="rank_hr">
                <td  style="width:50px; height:50px; text-align:center;">
                    <div style="width:30px; height:30px; background-color:white;">1</div>
                </td>

                <td style="width:50px; height: 50px; background-color:skyblue;">
                    <img src="/img/character/char1.png" style="width:50px; height: 50px;"  alt="">
                </td>
                <td style="width:350px; background-color:white;">LONDON SPITFIRE</td>
                <td  style="width:150px; text-align:center; background-color:white;">100 Point</td>
                <td style=" background-color:white;"><img src="/img/right_circle.png" style="width:50px; height: 50px;"  alt=""></td>
            </tr>

            <tr class="rank_hr">
                <td  style="width:50px; height:50px; text-align:center;">
                    <div style="width:30px; height:30px; background-color:white;">2</div>
                </td>

                <td style="width:50px; height: 50px; background-color:yellow;">
                    <img src="/img/character/char2.png" style="width:50px; height: 50px;"  alt="">
                </td>
                <td style="width:350px; background-color:white;">LONDON SPITFIRE</td>
                <td  style="width:150px; text-align:center; background-color:white;">100 Point</td>
                <td style=" background-color:white;"><img src="/img/right_circle.png" style="width:50px; height: 50px;"  alt=""></td>
            </tr>

            <tr class="rank_hr">
                <td  style="width:50px; height:50px; text-align:center;">
                    <div style="width:30px; height:30px; background-color:white;">3</div>
                </td>

                <td style="width:50px; height: 50px; background-color:#e75480;">
                    <img src="/img/character/char3.png" style="width:50px; height: 50px;"  alt="">
                </td>
                <td style="width:350px; background-color:white;">LONDON SPITFIRE</td>
                <td  style="width:150px; text-align:center; background-color:white;">100 Point</td>
                <td style=" background-color:white;"><img src="/img/right_circle.png" style="width:50px; height: 50px;"  alt=""></td>
            </tr>
        </table>
    </div>
            <div class="bar-chart-block block" style="height:450px; display:inline-block; position:absolute; right:12%;">
                <h2 class='titular'>보기 선택 현황</h2>
                <h2 class='titular'>가장많이나온답 </h2>
                <div class='grafico bar-chart'>
                    <ul class='eje-y'>
                        <li data-ejeY='100'></li>
                        <li data-ejeY='80'></li>
                        <li data-ejeY='60'></li>
                        <li data-ejeY='40'></li>
                        <li data-ejeY='20'></li>
                        <li data-ejeY='0'></li>
                    </ul>
                    <ul class='eje-x'>
                        <li ><i>A</i></li>
                        <li ><i>B</i></li>
                        <li ><i>C</i></li>
                        <li ><i>D</i></li>
                    </ul>
                </div>

                <ul class="os-percentages horizontal-list">
                    <li>
                        <p class="ios os scnd-font-color">A</p>
                        <p class="os-percentage">21<sup>%</sup></p>
                    </li>
                    <li>
                        <p class="mac os scnd-font-color">B</p>
                        <p class="os-percentage">39<sup>%</sup></p>
                    </li>
                    <li>
                        <p class="linux os scnd-font-color">C</p>
                        <p class="os-percentage">9<sup>%</sup></p>
                    </li>
                    <li>
                        <p class="win os scnd-font-color">D</p>
                        <p class="os-percentage">31<sup>%</sup></p>
                    </li>
                </ul>
            </div>

</div>
<style>

    /************************
    Css orignal https://codepen.io/jlalovi/details/bIyAr
    ************************/
    @import url(https://fonts.googleapis.com/css?family=Ubuntu:400,700);
    * {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    ul {
        list-style-type: none;
        margin: 0;
        padding-left:0;
    }

    h1 {
        font-size: 23px;
    }

    h2 {
        font-size: 17px;
    }

    p {
        font-size: 15px;
    }
    #mid_content h1,#mid_content h2,#mid_content p,#mid_content a,#mid_content span{
        color: #fff;
    }
    .scnd-font-color {
        color: white;
    }
    .titular {
        display: block;
        line-height: 60px;
        margin: 0;
        text-align: center;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .horizontal-list {
        margin: 0;
        padding: 0;
        list-style-type: none;
    }
    .horizontal-list li {
        float: left;
    }
    .block {
        margin: 25px 25px 0 0;
        background: #394264;
        border-radius: 10px;
        width: 300px;
        height:450px;
        overflow: hidden;
    }
    /******************************************** LEFT CONTAINER *****************************************/
    .left-container {}
    .menu-box {
        height: 360px;
    }

    .donut-chart-block {
        overflow: hidden;
    }
    .donut-chart-block .titular {
        padding: 10px 0;
    }
    .os-percentages li {
        width: 75px;
        border-left: 1px solid #394264;
        text-align: center;
        background: #50597b;
    }
    .os {
        margin: 0;
        padding: 10px 0 5px;
        font-size: 15px;
    }
    .os.ios {
        border-top: 4px solid #11a8ab;
    }
    .os.mac {
        border-top: 4px solid #4fc4f6;
    }
    .os.linux {
        border-top: 4px solid #fcb150;
    }
    .os.win {
        border-top: 4px solid #e64c65;
    }
    .os-percentage {
        margin: 0;
        padding: 0 0 15px 10px;
        font-size: 25px;
    }
    .bar-chart-block {
        height: 400px;
    }
    .line-chart {
        height: 200px;
        background: #11a8ab;
    }
    .time-lenght {
        padding-top: 22px;
        padding-left: 38px;
        overflow: hidden;
    }
    .time-lenght-btn {
        display: block;
        width: 70px;
        line-height: 32px;
        background: #50597b;
        border-radius: 5px;
        font-size: 14px;
        text-align: center;
        margin-right: 5px;
        -webkit-transition: background .3s;
        transition: background .3s;
    }
    .time-lenght-btn:hover {
        text-decoration: none;
        background: #e64c65;
    }
    .month-data {
        padding-top: 28px;
    }
    .month-data p {
        display: inline-block;
        margin: 0;
        padding: 0 25px 15px;
        font-size: 16px;
    }
    .month-data p:last-child {
        padding: 0 25px;
        float: right;
        font-size: 15px;
    }
    .increment {
        color: #e64c65;
    }

    /******************************************
    ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓ ↓
    ESTILOS PROPIOS DE LOS GRÄFICOS
    ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑ ↑
    GRAFICO LINEAL
    ******************************************/

    .grafico {
        padding: 2rem 1rem 1rem;
        width: 100%;
        height: 100%;
        position: relative;
        color: #fff;
        font-size: 80%;
    }
    .grafico span {
        display: block;
        position: absolute;
        bottom: 3rem;
        left: 2rem;
        height: 0;
        border-top: 2px solid;
        transform-origin: left center;
    }
    .grafico span > span {
        left: 100%; bottom: 0;
    }
    [data-valor='25'] {width: 75px; transform: rotate(-45deg);}
    [data-valor='8'] {width: 24px; transform: rotate(65deg);}
    [data-valor='13'] {width: 39px; transform: rotate(-45deg);}
    [data-valor='5'] {width: 15px; transform: rotate(50deg);}
    [data-valor='23'] {width: 69px; transform: rotate(-70deg);}
    [data-valor='12'] {width: 36px; transform: rotate(75deg);}
    [data-valor='15'] {width: 45px; transform: rotate(-45deg);}

    [data-valor]:before {
        content: '';
        position: absolute;
        display: block;
        right: -4px;
        bottom: -3px;
        padding: 4px;
        background: #fff;
        border-radius: 50%;
    }
    [data-valor='23']:after {
        content: '+' attr(data-valor) '%';
        position: absolute;
        right: -2.7rem;
        top: -1.7rem;
        padding: .3rem .5rem;
        background: #50597B;
        border-radius: .5rem;
        transform: rotate(45deg);
    }
    [class^='eje-'] {
        position: absolute;
        left: 0;
        bottom: 0rem;
        width: 100%;
        padding: 1rem 1rem 0 2rem;
        height: 80%;
    }
    .eje-x {
        height: 2.5rem;
    }
    .eje-y li {
        height: 25%;
        border-top: 1px solid #777;
    }
    [data-ejeY]:before {
        content: attr(data-ejeY);
        display: inline-block;
        width: 2rem;
        text-align: right;
        line-height: 0;
        position: relative;
        left: -2.5rem;
        top: -.5rem;
    }
    .eje-x li {
        width: 33%;
        float: left;
        text-align: center;
    }

    /******************************************
    GRAFICO CIRCULAR PIE CHART
    ******************************************/
    .donut-chart {
        position: relative;
        width: 200px;
        height: 200px;
        margin: 0 auto 2rem;
        border-radius: 100%
    }
    p.center-date {
        background: #394264;
        position: absolute;
        text-align: center;
        font-size: 28px;
        top:0;left:0;bottom:0;right:0;
        width: 130px;
        height: 130px;
        margin: auto;
        border-radius: 50%;
        line-height: 35px;
        padding: 15% 0 0;
    }
    .center-date span.scnd-font-color {
        line-height: 0;
    }
    .recorte {
        border-radius: 50%;
        clip: rect(0px, 200px, 200px, 100px);
        height: 100%;
        position: absolute;
        width: 100%;
    }
    .quesito {
        border-radius: 50%;
        clip: rect(0px, 100px, 200px, 0px);
        height: 100%;
        position: absolute;
        width: 100%;
        font-family: monospace;
        font-size: 1.5rem;
    }
    #porcion1 {
        transform: rotate(0deg);
    }

    #porcion1 .quesito {
        background-color: #E64C65;
        transform: rotate(76deg);
    }
    #porcion2 {
        transform: rotate(76deg);
    }
    #porcion2 .quesito {
        background-color: #11A8AB;
        transform: rotate(140deg);
    }
    #porcion3 {
        transform: rotate(215deg);
    }
    #porcion3 .quesito {
        background-color: #4FC4F6;
        transform: rotate(113deg);
    }
    #porcionFin {
        transform:rotate(-32deg);
    }
    #porcionFin .quesito {
        background-color: #FCB150;
        transform: rotate(32deg);
    }
    .nota-final {
        clear: both;
        color: #4FC4F6;
        font-size: 1rem;
        padding: 2rem 0;
    }
    .nota-final strong {
        color: #E64C65;
    }
    .nota-final a {
        color: #FCB150;
        font-size: inherit;
    }
    /**************************
    BAR-CHART
    **************************/
    .grafico.bar-chart {
        background: #3468AF;
        padding: 0 1rem 2rem 1rem;
        width: 100%;
        height: 50%;
        position: relative;
        color: #fff;
        font-size: 80%;
    }
    .bar-chart [class^='eje-'] {
        padding: 0 1rem 0 2rem;
        bottom: 1rem;
    }
    .bar-chart .eje-x {
        bottom: 0;
    }
    .bar-chart .eje-y li {
        height: 20%;
        border-top: 1px solid #fff;
    }
    .bar-chart .eje-x li {
        width: 14%;
        position: relative;
        text-align: left;
    }
    .bar-chart .eje-x li i {
        transform: rotatez(-45deg) translatex(-1rem);
        transform-origin: 30% 60%;
        display: block;
        visibility:hidden
    }
    .bar-chart .eje-x li:before {
        content: '';
        position: absolute;
        bottom: 0.1rem;
        width: 100%;
        right: 5%;
        box-shadow: 3px 0 rgba(0,0,0,.1), 3px -3px rgba(0,0,0,.1);
    }
    .bar-chart .eje-x li:nth-child(1):before {

        background: #11A8AB;
        height: 100px;
    }
    .bar-chart .eje-x li:nth-child(2):before {
        background: #3598db;
        height: 200px;
        left:35px;
    }
    .bar-chart .eje-x li:nth-child(3):before {
        background: #FCB150;
        height: 400%;
        left:75px;
    }
    .bar-chart .eje-x li:nth-child(4):before {
        background: #E64C65;
        height: 290%;
        left:110px;
    }
    .bar-chart .eje-x li:nth-child(5):before {
        background: #FFED0D;
        height: 720%;
    }
    .bar-chart .eje-x li:nth-child(6):before {
        background: #F46FDA;
        height: 820%;
    }
    .bar-chart .eje-x li:nth-child(7):before {
        background: #15BFCC;
        height: 520%;
    }
    /*****************************
    USO NÚMEROS MÁGICOS EN ALGUNOS VALORES
    POR NO PARARME A ESTUDIAR A FONDO
    EL CSS DEL PEN ORIGINAL
    *****************************/




    @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,700);

    @keyframes bake-pie {
        from {
            transform: rotate(0deg) translate3d(0,0,0);
        }
    }
    main {
        width: 400px;
        margin: 30px auto;
    }
    section {
        margin-top: 30px;
    }
    .pieID {
        display: inline-block;
        vertical-align: top;
    }
    .pie {
        height: 200px;
        width: 200px;
        position: relative;
        margin: 0 30px 30px 0;
    }
    .pie::before {
        text-align: center;
        font-size: 35pt;
        content: "";
        display: block;
        position: absolute;
        z-index: 1;
        width: 100px;
        height: 100px;
        background: #EEE;
        border-radius: 50%;
        top: 50px;
        left: 50px;
        line-height:100px;
    }
    .pie::after {
        content: "";
        display: block;
        width: 120px;
        height: 2px;
        background: rgba(0,0,0,0.1);
        border-radius: 50%;
        box-shadow: 0 0 3px 4px rgba(0,0,0,0.1);
        margin: 220px auto;

    }
    .slice {
        position: absolute;
        width: 200px;
        height: 200px;
        clip: rect(0px, 200px, 200px, 100px);
        animation: bake-pie 1s;
    }
    .slice span {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        background-color: black;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        clip: rect(0px, 200px, 200px, 100px);
    }
    .legend {
        list-style-type: none;
        padding: 0;
        margin: 0;
        background: #FFF;
        padding: 15px;
        font-size: 13px;
        box-shadow: 1px 1px 0 #DDD, 2px 2px 0 #BBB;
    }
    .legend li {
        width: 110px;
        height: 1.25em;
        margin-bottom: 0.7em;
        padding-left: 0.5em;
        border-left: 1.25em solid black;
    }
    .legend em {
        font-style: normal;
    }
    .legend span {
        float: right;
    }
    footer {
        position: fixed;
        bottom: 0;
        right: 0;
        font-size: 13px;
        background: #DDD;
        padding: 5px 10px;
        margin: 5px;
    }

    .progress {
        width: 150px;
        height: 150px;
        line-height: 150px;
        background: none;
        margin: 0 auto;
        box-shadow: none;
        position: relative;
    }
    .progress:after {
        content: "";
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 12px solid #fff;
        position: absolute;
        top: 0;
        left: 0;
    }
    .progress > span {
        width: 50%;
        height: 100%;
        overflow: hidden;
        position: absolute;
        top: 0;
        z-index: 1;
    }
    .progress .progress-left {
        left: 0;
    }
    .progress .progress-bar {
        width: 100%;
        height: 100%;
        background: none;
        border-width: 12px;
        border-style: solid;
        position: absolute;
        top: 0;
    }
    .progress .progress-left .progress-bar {
        left: 100%;
        border-top-right-radius: 80px;
        border-bottom-right-radius: 80px;
        border-left: 0;
        -webkit-transform-origin: center left;
        transform-origin: center left;
    }
    .progress .progress-right {
        right: 0;
    }
    .progress .progress-right .progress-bar {
        left: -100%;
        border-top-left-radius: 80px;
        border-bottom-left-radius: 80px;
        border-right: 0;
        -webkit-transform-origin: center right;
        transform-origin: center right;
        animation: loading-1 1.8s linear forwards;
    }
    .progress .progress-value {
        width: 90%;
        height: 90%;
        border-radius: 50%;
        background: #44484b;
        font-size: 24px;
        color: #fff;
        line-height: 135px;
        text-align: center;
        position: absolute;
        top: 5%;
        left: 5%;
    }
    .progress.blue .progress-bar {
        border-color: #049dff;
    }
    .progress.blue .progress-left .progress-bar {
        animation: loading-2 1.5s linear forwards 1.8s;
    }

    .progress.pink .progress-bar {
        border-color: #ed687c;
    }
    .progress.pink .progress-left .progress-bar {
        animation: loading-4 0.4s linear forwards 1.8s;
    }
    .progress.green .progress-bar {
        border-color: #1abc9c;
    }
    .progress.green .progress-left .progress-bar {
        animation: loading-5 1.2s linear forwards 1.8s;
    }
    @keyframes loading-1 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
        }
    }
    @keyframes loading-2 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(144deg);
            transform: rotate(144deg);
        }
    }
    @keyframes loading-3 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
        }
    }
    @keyframes loading-4 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(36deg);
            transform: rotate(36deg);
        }
    }
    @keyframes loading-5 {
        0% {
            -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        100% {
            -webkit-transform: rotate(126deg);
            transform: rotate(126deg);
        }
    }
    @media only screen and (max-width: 990px) {
        .progress {
            margin-bottom: 20px;
        }
    }
    .well {
        width: 500px;
        height:200px;
        padding: 19px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        font-weight:bold;
        display: inline-block;
        font-size: 20px;
        text-align:center;
    }

    .divss {
        display: inline-block;
        height:150px;
    }
    .nextbutton {
        margin-left: 550px;
    }
</style>

<script>

    // function sliceSize(dataNum, dataTotal) {
    //     return (dataNum / dataTotal) * 360;
    // }
    // function addSlice(sliceSize, pieElement, offset, sliceID, color) {
    //     $(pieElement).append(
    //         "<div class='slice " + sliceID + "'><span></span></div>"
    //     );
    //     var offset = offset - 1;
    //     var sizeRotation = -179 + sliceSize;
    //     $("." + sliceID).css({
    //         "transform": "rotate(" + offset + "deg) translate3d(0,0,0)"
    //     });
    //     $("." + sliceID + " span").css({
    //         "transform": "rotate(" + sizeRotation + "deg) translate3d(0,0,0)",
    //         "background-color": color
    //     });
    // }
    // function iterateSlices(
    //     sliceSize,
    //     pieElement,
    //     offset,
    //     dataCount,
    //     sliceCount,
    //     color
    // ) {
    //     var sliceID = "s" + dataCount + "-" + sliceCount;
    //     var maxSize = 179;
    //     if (sliceSize <= maxSize) {
    //         addSlice(sliceSize, pieElement, offset, sliceID, color);
    //     } else {
    //         addSlice(maxSize, pieElement, offset, sliceID, color);
    //         iterateSlices(
    //             sliceSize - maxSize,
    //             pieElement,
    //             offset + maxSize,
    //             dataCount,
    //             sliceCount + 1,
    //             color
    //         );
    //     }
    // }
    // function createPie(dataElement, pieElement) {
    //     var listData = [];
    //     $(dataElement + " span").each(function () {
    //         listData.push(Number($(this).html()));
    //     });
    //     var listTotal = 0;
    //     for (var i = 0; i < listData.length; i++) {
    //         listTotal += listData[i];
    //     }
    //     var offset = 0;
    //     var color = [
    //         "green",
    //         "red",
    //         "orange",
    //         "tomato",
    //         "crimson",
    //         "purple",
    //         "turquoise",
    //         "forestgreen",
    //         "navy",
    //         "gray"
    //     ];
    //     for (var i = 0; i < listData.length; i++) {
    //         var size = sliceSize(listData[i], listTotal);
    //         iterateSlices(size, pieElement, offset, i, 0, color[i]);
    //         $(dataElement + " li:nth-child(" + (
    //             i + 1
    //         ) + ")").css("border-color", color[i]);
    //         offset += size;
    //     }
    // }
    // createPie(".pieID.legend", ".pieID.pie");
    // </script>

