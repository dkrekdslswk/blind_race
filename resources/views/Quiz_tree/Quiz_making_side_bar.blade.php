<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: "Lato", sans-serif;
        }

        /* Fixed sidenav, full height */
        .sidenav {
            height: 100%;
            width: 25%;
            position: fixed;
            z-index: 1;
            left: 0;
            background-color: white;
            border-right : 2px solid midnightblue;
        }

        /* Style the sidenav links and the dropdown button */

        .sidenav a{
            text-decoration: none;
            cursor: pointer;
            color: #818181;
        }

        .select {
            width: 90%;
            margin: 5%;
        }

        .sidenav drop-contents {
            padding: 6px 8px 6px 8px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
            display: inline;
            border: block;
            background: none;
            width: 100%;
            cursor: pointer;
            outline: none;
            text-align: left;
        }

        /* On mouse-over */
        .sidenav a:hover, .dropdown-btn:hover {
            color: black;
        }

        .dropdown-container a {
            display: block;
        }

        .sample_quiz {
            margin-top: 20px;
            margin-left: 25px;
            text-align: center;
            border: 1px solid black;
            overflow-y: scroll;
            width: 90%;
            height: 50%;
            background-color: #f8f8f8;
        }

        .table {
            background-color: #F2F2F2;
        }

        .table thead, .table thead tr th{
            font-size : 10px;
            padding: 1px 1px 1px 1px;
        }

        /* Some media queries for responsiveness */
        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }
    </style>
</head>

<script>

    function btnClick() {
        var xmlReqObj = new XMLHttpRequest();

        // 접속 대상 설정
        var url;

        xmlReqObj.onreadystatechange = function() {
            // 통신이 완료되면
            if(xmlReqObj.readyState == 4 && xmlReqObj.status == 200) {
                resultObj.value = xmlReqObj.responseText;
            }
        };

        xmlReqObj.open("POST", url, true);
        xmlReqObj.send();
    }

</script>

<body>
<?php ?>

<div class="sidenav">

    <form class="select">
        <select class="form-control">
            <option>교재 선택</option>
            <option>급소공략</option>
        </select>
    </form>

    <form class="select">
        <select class="form-control">
            <option>난이도 선택</option>
            <option>N1</option>
            <option>N2</option>
            <option>N3</option>
        </select>
    </form>

    <form class="form-inline" style="margin: 5%">
        <select class="form-control">
            <option>페이지</option>
            <option>1p</option>
            <option>2p</option>
        </select>
        &nbsp;~&nbsp;
        <select class="form-control">
            <option>페이지</option>
            <option>1p</option>
            <option>2p</option>
        </select>
        <button type="button" class="btn btn-info" style="margin-left: 5%" onclick="btnClick()">검색</button>
    </form>


    {{--<div class="sample_quiz">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>번호</th>
                <th>예문</th>
                <th>난이도</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td><a href="#">1</a></td>
                <td><a href="#">生活習慣病は40代を（　　）増え始める</a></td>
                <td>50%</td>
            </tr>

            <tr>
                <td><a href="#">2</a></td>
                <td><a href="#">食中毒を起こしたら店にはさすがに誰も（　）しない.</a></td>
                <td>70%</td>
            </tr>

            </tbody>
        </table>
    </div>--}}

</div>
</body>
</html>
