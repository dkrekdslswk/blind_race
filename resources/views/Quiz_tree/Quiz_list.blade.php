<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz_tree list</title>
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

        #curve_chart {
            margin-top: 1em;
        }
    </style>

</head>

<script>
    $(document).ready(function () {
        $('#quizName').change(function () {
            var testT = $("#quizName").attr('value');

            var quizNameObj = document.getElementById("test");
            quizNameObj.value = testT;
        });
    });



</script>

<body>
<nav>
    @include('Navigation.mainnav')
</nav>

<aside style="display:inline-block; vertical-align:top;">
    @include('Quiz_tree.Nav_side_bar.Quiz_side_bar')

</aside>

<!--<div id="app"></div>-->
<!--<script src="{{asset('js/app.js')}}"></script>  -->


<div class="container" >

    <div class="wrap" style="margin-bottom: 30px;">
        <a href="#" class="btn btn-primary">N1 문법 모음</a>
        <a href="#" class="btn btn-primary">퀴즈 2개</a>
        <button class="btn btn-info" data-toggle="modal" data-target="#Modal">퀴즈 만들기</button>
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
                <button type="button" class="btn btn-default">N3</button>
                <button type="button" class="btn btn-info btn-lg">수정</button>
                <button type="button" class="btn btn-info btn-lg">삭제</button>
            </td>
        </tr>
        <tr>
            <td>스쿠스쿠 레이스2</td>
            <td>
                <button type="button" class="btn btn-default">N3</button>
                <button type="button" class="btn btn-info btn-lg">수정</button>
                <button type="button" class="btn btn-info btn-lg">삭제</button>
            </td>
        </tbody>
    </table>
</div>

{{--Modal : make quiz--}}
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{url('raceController/create')}}"  method="Post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="groupId" id="groupId" value="1">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">퀴즈 만들기</h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    {{--퀴즈명 입력란--}}
                    퀴즈 이름 <input type="text" id="quizName">
                    <input type="text" id="test">
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
