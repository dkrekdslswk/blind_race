<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz list</title>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
</head>

<style type="text/css">

    .panel-table .panel-body{
        padding:0;
    }

    .panel-table .panel-body .table-bordered{
        border-style: none;
        margin:0;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type {
        text-align:center;
        width: 150px;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:last-of-type,
    .panel-table .panel-body .table-bordered > tbody > tr > td:last-of-type {
        border-right: 0px;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:first-of-type,
    .panel-table .panel-body .table-bordered > tbody > tr > td:first-of-type {
        border-left: 0px;
    }

    .panel-table .panel-body .table-bordered > tbody > tr:first-of-type > td{
        border-bottom: 0px;
    }

    .panel-table .panel-body .table-bordered > thead > tr:first-of-type > th{
        border-top: 0px;
    }

    .panel-table .panel-footer .pagination{
        margin:0;
    }

    /*
    used to vertically center elements, may need modification if you're not using default sizes.
    */
    .panel-table .panel-footer .col{
        line-height: 34px;
        height: 34px;
    }

    .panel-table .panel-heading .col h3{
        line-height: 30px;
        height: 30px;
    }

    .panel-table .panel-body .table-bordered > tbody > tr > td{
        line-height: 34px;
    }

</style>



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
    @include('Navigation.main_nav')
</nav>

<aside style="display:inline-block; vertical-align:top;">
    {{--@include('QuizTree.Quiz_list_side_bar')--}}
</aside>

<div class="btn-process" style="margin-top:50px;"></div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="row">
                    <div class="col col-xs-6">
                        <h3 class="panel-title">퀴즈 리스트</h3>
                    </div>
                    <div class="col col-xs-6 text-right">
                        <button type="button" class="btn btn-sm btn-primary btn-create" data-toggle="modal" data-target="#Modal">퀴즈 만들기</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                    <tr>
                        <th><em class="fa fa-cog"></em></th>
                        <th class="hidden-xs" style="text-align: center">#</th>
                        <th style="text-align: center">퀴즈명</th>
                        <th style="text-align: center">문항수</th>
                    </tr>
                    </thead>
                    <tbody id="list">

                    <?php foreach ($response['raceList'] as $raceData): ?>
                    <tr>
                        <td align="center">
                            <a class="btn btn-default"><em class="fa fa-pencil"></em></a>
                            <a class="btn btn-danger"><em class="fa fa-trash"></em></a>
                        </td>
                        <td class="hidden-xs" style="text-align: center">{{$raceData['raceId']}}</td>
                        <td style="text-align: center">{{$raceData['raceName']}}</td>
                        <td style="text-align: center">{{$raceData['quizCount']}}</td>
                    </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col col-xs-4">Page 1 of 5
                    </div>
                    <div class="col col-xs-8">
                        <ul class="pagination hidden-xs pull-right">
                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">4</a></li>
                            <li><a href="#">5</a></li>
                        </ul>
                        <ul class="pagination visible-xs pull-right">
                            <li><a href="#">«</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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
