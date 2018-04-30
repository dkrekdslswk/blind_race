<?php
/**
 * Created by PhpStorm.
 * User: kimseungmok
 * Date: 2018-03-28
 * Time: 오후 7:57
 *
 * 레이스 기본 네비게이션
 */
?>



<style>
    .race_container {
        background-color : #212529;
        margin : 0px;
        width : 100%;
        height: 100px;
    }

    .navbar-brand {
        border: 1px solid white;
        color: white;
        font-family: 'a옛날사진관3';
        font-size: 30px;
        text-align: left;
    }

    .race_container ul li {
        background-color: white;
        color: black;
        font-family: 'a옛날사진관3';
        font-size: 30px;
        margin-right: 15px;
    }

    .group ul {
        position: absolute;
        right: 20px;
    }

    .group ul li {
        background-color: #212529;
        color: white;
        font-family: 'a옛날사진관3';
        font-size: 30px;
        margin-right: 15px;
    }
    .nav-color{
        background-color:#2e353d;
    }
</style>

</head>
<body onload="nav_load();">

<div class="race_container">
    <nav  style="height: 100%;">

        <div>
            블라인드 레이스
        </div>

        <div >
            <ul>
                <li >
                    <div  style="height: 100%;" id="race_name">레이스 이름
                    </div>
                </li>
                <li>
                    <span  style="height: 100%;" id="race_count">레이스 문항 수
                    </span>
                </li>
            </ul>
            <ul>
                <li>

                </li>
            </ul>
        </div>
        <div>
            <ul>
                <li>
                    <span style="height: 100%;" id="group_name">그룹 이름
                    </span>
                </li>
                <li >
                    <span style="height: 100%; display: inline-block;" id="group_student_count">학생 총 수
                    </span>
                </li>
            </ul>
        </div>
    </nav>
</div>