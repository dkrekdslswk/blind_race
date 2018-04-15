<link
        href = "//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"
        rel = "stylesheet"
        id = "bootstrap-css" > <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script
        defer="defer"
        src="https://use.fontawesome.com/releases/v5.0.9/js/all.js"
        integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl"
        crossorigin="anonymous"></script>

<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<div id="ranking_head">순위 발표</div>
<div class="nav-side-menu">
    <i
            class="fa fa-bars fa-2x toggle-btn "
            data-toggle="collapse"
            data-target="#menu-content"></i>

    <div class="menu-list">

        <ul id="menu-content" class="menu-content collapse out">

            <!--<li data-toggle="collapse" data-target="#products" class="box collapsed active ">-->
            <!--    <img src="https://i.imgur.com/guhQqnS.png" width="40px" alt=""/>-->
            <!--    <i class="fa fa-lg"></i>-->
            <!--    징징이-->

            <!--    <i class="magin fas fa-trophy"></i>-->
            <!--    <span >100</span>-->
            <!--    <i class="margin">-->
            <!--        <img src="https://i.imgur.com/GqML11K.gif" width="60px"></i>-->
            <!--    </a>-->
            <!--</li>-->
            <!--<li data-toggle="collapse" data-target="#products" class="box collapsed active">-->
            <!--    <img src="https://i.imgur.com/KARrYZA.png" width="40px" alt=""/>-->
            <!--    <i class="fa fa-lg"></i>-->
            <!--    별가-->

            <!--    <i class="magin fas fa-trophy"></i>-->
            <!--    <span >100</span>-->
            <!--    <i class="margin">-->
            <!--        <img src="https://i.imgur.com/bLqSyYO.gif" width="55px"></i>-->
            <!--    </a>-->
            <!--</li>-->
            <!--<li data-toggle="collapse" data-target="#products" class="box collapsed active">-->
            <!--    <img src="https://i.imgur.com/ageVYAE.png" width="40px" alt=""/>-->
            <!--    <i class="fa fa-lg"></i>-->
            <!--    스폰지준-->
            <!--    <i class="magin fas fa-trophy"></i>-->
            <!--    <span >90</span>-->
            <!--    <i class="margin">-->
            <!--        <img src="https://i.imgur.com/a21ovjk.gif" width="50px"></i>-->
            <!--    </a>-->
            <!--</li>-->
            <!-- <li data-toggle="collapse" data-target="#products" class="collapsed active">
ZZ
                4위 감기콜드
                <i class="magin fas fa-trophy"></i>
                <span >90</span>
                <i class="margin">
                    <img src="https://i.imgur.com/jbVKOQW.gif" width="40px"></i>
                </a>
            </li>

            <li data-toggle="collapse" data-target="#products" class="collapsed active">

                5위 딘딘
                <i class="magin fas fa-trophy"></i>
                <span >90</span>
                <i class="margin">
                    <img src="https://i.imgur.com/B2olO8b.gif" width="40px"></i>
                </a>
            </li> -->

        </ul>
    </div>
</div>

<style>
    #ranking_head {
        background-color: #23282e;
        width:230px;
        line-height: 50px;
        display: block;
        text-align: center;
        font-size: 20px;
        color:white;
    }

    .nav-side-menu {
        overflow: auto;
        font-family: verdana;
        font-size: 12px;
        font-weight: 200;
        background-color: #2e353d;
        position:fixed;
        top: 0;
        margin-top:180px;
        width: 230px;
        height: 100%;
        color: #e1ffff;
    }
    .nav-side-menu .brand {
        background-color: #23282e;
        line-height: 50px;
        display: block;
        text-align: center;
        font-size: 14px;
    }
    .nav-side-menu .toggle-btn {
        display: none;
    }
    .nav-side-menu li,
    .nav-side-menu ul {
        list-style: none;
        padding: 0;
        margin: 0;
        line-height: 35px;
        cursor: pointer;
        /*
.collapsed{
   .arrow:before{
             font-family: FontAwesome;
             content: "\f053";
             display: inline-block;
             padding-left:10px;
             padding-right: 10px;
             vertical-align: middle;
             float:right;
        }
 }
*/
    }
    .nav-side-menu li :not(collapsed) .arrow:before,
    .nav-side-menu ul :not(collapsed) .arrow:before {
        font-family: FontAwesome;
        content: "\f078";
        display: inline-block;
        padding-left: 10px;
        padding-right: 10px;
        vertical-align: middle;
        float: right;
    }
    .nav-side-menu li .active,
    .nav-side-menu ul .active {
        border-left: 3px solid #d19b3d;
        background-color: grey;
    }
    .nav-side-menu li .sub-menu li.active,
    .nav-side-menu ul .sub-menu li.active {
        color: #d19b3d;
    }
    .nav-side-menu li .sub-menu li.active a,
    .nav-side-menu ul .sub-menu li.active a {
        color: #d19b3d;
    }
    .nav-side-menu li .sub-menu li,
    .nav-side-menu ul .sub-menu li {
        background-color: #181c20;
        border: none;
        line-height: 28px;
        border-bottom: 1px solid #23282e;
        margin-left: 0;
    }
    .nav-side-menu li .sub-menu li:hover,
    .nav-side-menu ul .sub-menu li:hover {
        background-color: #020203;
    }
    .nav-side-menu li .sub-menu li:before,
    .nav-side-menu ul .sub-menu li:before {
        font-family: FontAwesome;
        content: "\f105";
        display: inline-block;
        padding-left: 10px;
        padding-right: 10px;
        vertical-align: middle;
    }
    .nav-side-menu li {
        padding-left: 0;
        border-left: 3px solid #2e353d;
        border-bottom: 1px solid #23282e;
    }
    .nav-side-menu li a {
        text-decoration: none;
        color: #e1ffff;
    }
    .nav-side-menu li a i {
        padding-left: 10px;
        width: 20px;
        padding-right: 20px;
    }
    .nav-side-menu li:hover {
        border-left: 3px solid #d19b3d;
        background-color: #4f5b69;
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -o-transition: all 1s ease;
        -ms-transition: all 1s ease;
        transition: all 1s ease;
    }
    @media (max-width: 767px) {
        .nav-side-menu {
            position: relative;
            width: 100%;
            margin-bottom: 10px;
        }
        .nav-side-menu .toggle-btn {
            display: block;
            cursor: pointer;
            position: absolute;
            right: 10px;
            top: 10px;
            z-index: 10 !important;
            padding: 3px;
            background-color: #ffffff;
            color: #000;
            width: 40px;
            text-align: center;
        }

    }


    @media (min-width: 767px) {
        .nav-side-menu .menu-list .menu-content {
            display: block;
        }
    }
    body {
        margin: 0;
        padding: 0;
    }

    .maginv {
        margin-left: 30px;
    }
</style>

<script>
    var colors = [
        'grey',
        'pupple',
        'green',
        'teal',
        'rosybrown',
        'tan',
        'plum',
        'saddlebrown'
    ];
    var boxes = document.querySelectorAll(".box");

    for (var i = 0; i < boxes.length; i++) {
        // Pick a random color from the array 'colors'.
        boxes[i].style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
    }
</script>