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

        .contents {
            margin-left: 25%;
        }

        .quiz {
            margin: 20px;
        }

        .quiz_table {
            border: 1px solid black;
        }

        .table tr{
            background-color: white;
        }
        
        .three_button {
            margin: 10px 20px 10px 0px;
            text-align: right;
        }

        #curve_chart {
            margin-top: 1em;
        }
    </style>

</head>
<body>
<nav>
    @include('Navigation.mainnav')
</nav>

<aside style="display:inline-block; vertical-align:top;">
    @include('Quiz_tree.Quiz_making_side_bar')
</aside>

<div class="contents">
    <div class="quiz">
        <table class="table table-bordered">
            <tr>
                <td style="background-color: #d9edf7">문항</td>
                <td>1</td>
                <td style="background-color: #d9edf7">난이도</td>
                <td>N1</td>
                <td style="background-color: #d9edf7">문제 유형</td>
                <td>사지선다</td>
            </tr>
            <tr>
                <td style="background-color: #d9edf7">문제</td>
                <td colspan="5">生活習慣病は40代を（　　）増え始める.</td>
            </tr>
            <tr>
                <td rowspan="3" style="background-color: #d9edf7">정답</td>
                <td colspan="3" style="background-color: #ffa500">さかいに</td>
                <td td colspan="2">とたんに</td >
            </tr>
            <tr>
                <td td colspan="3">たびに</td>
                <td colspan="2">もとに</td>
            </tr>
        </table>
    </div>

    <div class="quiz">
        <table class="table table-bordered">
            <tr>
                <td style="background-color: #d9edf7">문항</td>
                <td>2</td>
                <td style="background-color: #d9edf7">난이도</td>
                <td>N1</td>
                <td style="background-color: #d9edf7">문제 유형</td>
                <td>작성</td>
            </tr>
            <tr>
                <td style="background-color: #d9edf7">문제</td>
                <td colspan="5">この小説は[읽을 만한 가치가 없는]つまらないものだ</td>
            </tr>
            <tr>
                <td rowspan="3" style="background-color: #d9edf7">정답</td>
                <td colspan="5" style="background-color: #ffa500">読むに足りない</td>
            </tr>
        </table>
    </div>

    <div class="three_button">
        <button type="button" class="btn btn-primary">저장</button>
        <button type="button" class="btn btn-primary">추가</button>
        <button type="button" class="btn btn-primary">삭제</button>
    </div>


</div>