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

        .contents {
            margin-left: 25%;
        }

        .quiz {
            margin: 20px;
        }

        .table tr{
            background-color: white;
        }
        
        .two_button {
            margin: 10px 20px 10px 0px;
            text-align: right;
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
                <td colspan="5">
                    <textarea style="width: 100%; border: 0"></textarea>
                </td>
            </tr>
            <tr>
                <td rowspan="3" style="background-color: #d9edf7">정답</td>
                <td colspan="3" style="background-color: #EAEAEA">
                    <input type="text" style="width: 100%; background-color: #EAEAEA; border: 0">
                </td>
                <td td colspan="2">
                    <input type="text" style="width: 100%; border: 0">
                </td >
            </tr>
            <tr>
                <td td colspan="3">
                    <input type="text" style="width: 100%; border: 0">
                </td>
                <td colspan="2">
                    <input type="text" style="width: 100%; border: 0">
                </td>
            </tr>
        </table>
    </div>

    <div class="two_button">
        <button type="button" class="btn btn-primary">저장</button>
        <button type="button" class="btn btn-primary">추가</button>
    </div>


</div>