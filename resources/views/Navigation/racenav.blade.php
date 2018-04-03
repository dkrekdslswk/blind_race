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

        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Waiting Room</title>

    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript">

        var race = '{\
                "race":[{\
                    "raceName":"스쿠스쿠문법1",\
                    "raceCount":30}],\
                "group":[{\
                    "groupName":"2학년 특강 A반",\
                    "groupStudentCount":6}]\
                }';
        var members = ["egoing","k8805","sorialgi"];

        var getJsonDate = JSON.parse(race);

    </script>


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
            right: 20px;"
        }

        .group ul li {
            background-color: #212529;
            color: white;
            font-family: 'a옛날사진관3';
            font-size: 30px;
            margin-right: 15px;
        }

    </style>

</head>
<body>

<div class="race_container">
    <nav class="navbar navbar-expand-lg" style="height: 100%;">
        <div class="navbar-brand">
            <img class="nav-icon " src="img/golden_bell.png"></img>블라인드 레이스
        </div>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav navbar-sidenav">
                <li class="nav-item">
                    <div class="nav-link" style="height: 100%;" id="race_name">레이스 이름
                    </div>
                </li>
                <li class="nav-item">
                    <span class="nav-link" style="height: 100%;" id="race_count">레이스 문항 수
                    </span>
                </li>
            </ul>
            <ul class="navbar-nav sidenav-toggler">
                <li class="nav-item blank">

                </li>
            </ul>
        </div>
        <div class="collapse navbar-collapse group">
            <ul class="navbar-nav sidenav-toggler group">
                <li class="nav-item">
                    <span class="nav-link" style="height: 100%;" id="group_name">그룹 이름
                    </span>
                </li>
                <li class="nav-item" >
                    <img class="nav-icon " src="img/student.png" style="display: inline-block;"></img>
                    <span class="nav-link" style="height: 100%; display: inline-block;" id="group_student_count">학생 총 수
                    </span>
                </li>
            </ul>
        </div>

    </nav>
</div>


<script>
    $('#race_name').html(getJsonDate.race[0].raceName);
    $('#race_count').html(getJsonDate.race[0].raceCount + "문항");
    $('#group_name').html(getJsonDate.group[0].groupName);
    $('#group_student_count').html("총 " + getJsonDate.group[0].groupStudentCount + "명");
</script>

</body>
</html>