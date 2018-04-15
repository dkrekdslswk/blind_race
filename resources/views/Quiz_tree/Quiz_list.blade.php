<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz list</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

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

        .content{
            height:80px;
        }

        table {
            border-spacing: 1;
            border-collapse: collapse;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            width: 100%;
            margin: 0 auto;
            position: relative;
        }

        table * {
            position: relative;
        }

        table td, table th {
            padding-left: 8px;
            vertical-align:middle;
        }

        table thead tr {
            height: 60px;
            background: navy;
            color:white;
            font-size: 16px;
        }

        table tbody tr {
            height: 48px;
            border-bottom: 1px solid #E3F1D5;
        }

        table tbody tr:last-child {
            border: 0;
        }

        table td, table th {
            text-align: center;
        }

        .btn-process{
            margin-left:40%;
            margin-bottom:40px;
        }
    </style>

</head>

<script>
    $(document).ready(function () {
        $('#quizName').change(function () {
            var quizName = $("#quizName").val();

            var quizNameObj = document.getElementById("raceName");
            quizNameObj.value = quizName;
        });
    });



</script>

<body>
<nav>
    @include('Navigation.mainnav')
</nav>

<aside style="display:inline-block; vertical-align:top;">
    @include('Quiz_tree.Quiz_list_side_bar')

</aside>

<div style="margin-left:20%; display:inline-block; width:50%;">
    <div class="container" >
        <div class="wrap" style="margin-bottom: 30px;">
            {{--<a href="#" class="btn btn-primary">N1 문법 모음</a>
            <a href="#" class="btn btn-primary">퀴즈 2개</a>--}}
            <button class="btn btn-info" data-toggle="modal" data-target="#Modal">퀴즈 만들기</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="">
            <thead>
                <tr class="bg-dark" style="height:40px">
                    <th>퀴즈명</th>
                    <th>문항수</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="list">

            <?php foreach ($response['raceList'] as $raceData): ?>
            <tr class="content">
                <input type="hidden" id="{{$raceData['raceId']}}">
                <td>{{$raceData['raceName']}}</td>
                <td><button type="button" class="btn btn-default">{{$raceData['quizCount']}}</button></td>
                <td><button type="button" class="btn btn-info btn">수정</button></td>
                <td><button type="button" class="btn btn-info btn">삭제</button></td>
            </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

{{--Modal : make quiz--}}
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{url('quizTreeController/createRace')}}"  method="Post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="raceName" id="raceName" value="">
            <input type="hidden" name="folderId" id="folderId" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">퀴즈 만들기</h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    {{--퀴즈명 입력란--}}
                    퀴즈 이름 <input type="text" id="quizName">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">만들기</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>

</html>
