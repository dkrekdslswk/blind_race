<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Quiz_tree list</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

    <style type="text/css">

        .container {
            margin-left: 280px;
        }

        .wrap {
            margin : 10px;
            position: relative;
            align: left;
            display : block;
        }

        #curve_chart {
            margin-top: 1em;
        }
    </style>

</head>
<body>

<script>
    // delete Quiz
    function deleteQ() {
        alert("Delete Quiz");
    }
</script>

<nav>
    @include('Navigation.mainnav')
</nav>

<aside style="display:inline-block; vertical-align:top;">
    @include('Quiz_tree.Nav_side_bar.Quiz_side_bar')

</aside>

<!--<div id="app"></div>-->
<!--<script src="{{asset('js/app.js')}}"></script>  -->



<div style="position : fixed">
    <button type="button" class="btn btn-primary" style="margin-left:90px;">2-특강 A반</button>
    <button type="button" class="btn btn-primary">돌아가기</button>
</div>


<div class="container" >

    <div class="wrap" style="margin-bottom: 30px;">
        <a href="#" class="btn btn-primary">N1 문법 모음</a>
        <a href="#" class="btn btn-primary">퀴즈 2개</a>

    </div>


    <table class="table">
        <thead>
        <tr>
            <th>퀴즈명</th>
            <th>레벨</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>스쿠스쿠 레이스1</td>
            <td>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">N3</button>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">수정</button>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="deleteQ()">삭제</button>

            </td>
        </tr>
        <tr>
            <td>스쿠스쿠 레이스2</td>
            <td>
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">N3</button>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">수정</button>
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" onclick="deleteQ()">삭제</button>
            </td>


        </tbody>
    </table>
</div>

</body>

</html>

<?
#퀴즈리스트 리스트 목록
#김승목
?>