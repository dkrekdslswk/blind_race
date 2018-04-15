<html>
<head>
    <meta charset="UTF-8">
    <title>Race list</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
</head>
<style type="text/css">
    .content{
        height:60px;
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
<body>
<script>

    $(document).ready(function () {
        $('#groupSelect').change(function () {
            var selectedText = $("#groupSelect :selected").attr('value');

            var groupIdObj = document.getElementById("groupId");
            groupIdObj.value = selectedText;
        });
    });

</script>

<div class="btn-process" style="margin-left:20%; margin-top:50px;">

</div>

<div class="table-responsive">
    <table class="" >
        <thead>
        <tr class="bg-dark" style="height:40px">
            <th>퀴즈명</th>
            <th>문항수</th>
            <th></th>
        </tr>
        </thead>

        <tbody id="list">

            {{--foreach문 추가--}}
            <tr class="content">
                <td>스쿠스쿠 레이스 1</td>
                <td>30</td>
                <td><button class="btn btn-info" data-toggle="modal" data-target="#Modal">시작하기</button></td>
            </tr>

        </tbody>
    </table>
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

</body>
</html>
          

