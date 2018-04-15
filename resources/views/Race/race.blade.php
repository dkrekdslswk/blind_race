<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Race list</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

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
        width: 100px;
    }

    .panel-table .panel-body .table-bordered > thead > tr > th:last-of-type,
    .panel-table .panel-body .table-bordered > tbody > tr > td:last-of-type {
        border-right: 0px;
        width: 150px;
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
        $('#groupSelect').change(function () {
            var selectedText = $("#groupSelect :selected").attr('value');

            var groupIdObj = document.getElementById("groupId");
            groupIdObj.value = selectedText;
        });
    });
</script>

<body>

<nav>
    @include('Navigation.mainnav')
</nav>

<div class="btn-process" style="margin-top:50px;"></div>

<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default panel-table">
            <div class="panel-heading">
                <div class="row">
                    <div class="col col-xs-6">
                        <h3 class="panel-title">퀴즈 리스트</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered table-list">
                    <thead>
                    <tr>
                        <th class="hidden-xs">#</th>
                        <th>퀴즈명</th>
                        <th>문항수</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="list">

                    <tr>
                        <td class="hidden-xs">1</td>
                        <td>스쿠스쿠 레이스 1</td>
                        <td>30</td>
                        <td align="center">
                            <button type="submit" class="btn btn-primary" data-toggle="modal" data-target="#Modal">시작하기</button>
                        </td>
                    </tr>

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

{{--Modal : select group--}}
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{url('raceController/create')}}"  method="Post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="groupId" id="groupId" value="">
            <input type="hidden" name="raceMode" id="raceMode" value="n">
            <input type="hidden" name="examCount" id="examCount" value="30">
            <input type="hidden" name="raceId" id="raceId" value="1">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">그룹 선택</h5>
                </div>
                <div class="modal-body" style="text-align: center">
                    {{--Dropdowns--}}
                    <select id="groupSelect" class="selectpicker">
                        <option>그룹명</option>
                        <option value="1">2-특강 A반</option>
                        <option value="2">1-특강 B반</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">선택하기</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

</body>
</html>