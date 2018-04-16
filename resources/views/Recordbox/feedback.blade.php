<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Dashboard with Off-canvas Sidebar</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

    <style type="text/css">

        .feedback_page {
            margin-left: 300px;
        }

        .container {
            margin-top: 20px;
        }

    </style>

</head>
<body>
<nav>
    @include('Navigation.main_nav')
</nav>

    <aside style="display:inline-block; vertical-align:top;">
        @include('Recordbox.sidebar')
    </aside>

    <div class="feedback_page">
        <div style="position : relative; display: block;">
            <button type="button" class="btn btn-primary" style="display: inline;" >그룹 선택</button>
            <select id="bookSelect" >
                <blank></blank>
                <option value="1">특강 A반</option>
                <option value="2">특강 B반</option>
                <option value="3">특강 C반</option>
            </select>
        </div>

        <div class="container" style="display: block;position: relative;">
            <table class="table">
                <thead>
                    <tr>
                        <th>날짜</th>
                        <th>제목</th>
                        <th>수정</th>
                        <th>삭제</th>
                        <th>답변</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01/08</td>
                        <td>
                            <a href="#" data-toggle="modal" data-target="#Modal">
                            잘 모르겠습니다.
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">답변완료</button>
                        </td>
                    </tr>
                    <tr>
                        <td>01/08</td>
                        <td>
                            질문이다
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">답변완료</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{--Modal : select group--}}
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{url('raceController/create')}}"  method="Post" enctype="multipart/form-data">
                {{csrf_field()}}
                <input type="hidden" name="groupId" id="groupId" value="">
                <input type="hidden" name="raceMode" id="raceMode" value="n">
                <input type="hidden" name="examCount" id="examCount" value="0">
                <input type="hidden" name="raceId" id="raceId" value="">
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
                        답글
                    </div>
                </div>
            </form>
        </div>
    </div>


</body>
</html>

