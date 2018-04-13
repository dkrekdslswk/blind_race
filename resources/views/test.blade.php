<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>test</title>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

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
            margin-top: 25px;
            margin-left: 20px;
            text-align: center;
            border: 1px solid black;
            overflow-y: scroll;
            width: 90%;
            height: 70%;
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

    /*function btnClick() {
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

     $.ajax({
     type: "POST",
     url: "",
     dataType: "json",
     data:

     });*/

    //        넘겨줄 값↓↓↓↓↓
    //            'bookId' => 1,
    //            'pageStart' => 17,
    //            'pageEnd' => 18,
    //            'type' => 'o',
    //            'level' => 1

    /*$('#btn').on("click", function () {

        var url="quizTreeController/getQuiz";
        var params="bookId="+ +"pageStart="+ +"pageEnd="+ +"type="+ +"level=";

        $.ajax({
            type:"POST",
            url:url,
            data:params,
            success:function(args){
                $("#result").html(args);
            },
            beforeSend:showRequest,
            error:function(e){
                alert(e.responseText);
            }
        });
    });*/

    $(document).ready(function () {
        $('#bookSelect').change(function () {
            var selectedBook = $("#bookSelect :selected").val();
        });

        $('#levelSelect').change(function () {
            var selectedLevel = $("#levelSelect :selected").val();
        });

        $('#pageStart').change(function () {
            var pageStart = $("#pageStart").val();
        })

        $('#pageEnd').change(function () {
            var pageEnd = $("#pageEnd").val();
        })
    });

</script>

<body>

<div class="sidenav">

    <form action="{{url('quizTreeController/getBookGet')}}"  method="Post" enctype="multipart/form-data" class="form-horizontal">
        {{csrf_field()}}
        <div class="select">
            <select id="bookSelect" class="form-control" >
                <option>교재 선택</option>
                <option value="1">급소공략</option>
            </select>
        </div>

        <div class="select">
            <select id="levelSelect" class="form-control">
                <option>난이도 선택</option>
                <option value="1">N1</option>
                <option value="2">N2</option>
                <option value="3">N3</option>
            </select>
        </div>

        <div class="form-inline" style="margin: 5%">
            <input id="pageStart" class="form-control" type="text" placeholder="페이지" style="width: 6em">
            &nbsp;~&nbsp;
            <input id="pageEnd" class="form-control" type="text" placeholder="페이지" style="width: 6em">
            <button id="btn" type="button" class="btn btn-info" style="margin-left: 5%">검색</button>

        </div>
    </form>

    {{--예문--}}
    <div class="sample_quiz">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>번호</th>
                <th>예문</th>
            </tr>
            </thead>

            <tbody id="example">
            {{--<tr>
                <td><a href="#">1</a></td>
                <td><a href="#">生活習慣病は40代を（　　）増え始める</a></td>
                <td>50%</td>
            </tr>

            <tr>
                <td><a href="#">2</a></td>
                <td><a href="#">食中毒を起こしたら店にはさすがに誰も（　）しない.</a></td>
                <td>70%</td>
            </tr>--}}

            </tbody>
        </table>
    </div>

</div>
</body>
</html>
