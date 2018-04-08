<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
    <button class="btn btn-info" data-toggle="modal" data-target="#Modal">시작하기</button>
    {{--Modal : select group--}}
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{url('raceController/create')}}"  method="Post" enctype="multipart/form-data">
                {{csrf_field()}}

                <input type="hidden" name="raceMode" id="raceMode" value="n">
                <input type="hidden" name="examCount" id="examCount" value="30">
                <input type="hidden" name="raceId" id="raceId" value="1">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <h5 class="modal-title" id="ModalLabel">그룹 선택</h5>
                    </div>
                    <div class="modal-body">
                        {{--Dropdowns--}}
                        {{--<div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" id="mystatus" value="title" type="button" data-toggle="dropdown" aria-expanded="true">
                                그룹명
                            </button>
                            <ul id="mytype" class="dropdown-menu" role="menu" aria-labelledby="searchType">
                                <li role="presentation">
                                    <a
                                    <a role="menuitem" tabindex="-1" href="#">2-특강 A반</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="#">1-특강 B반</a>
                                </li>
                            </ul>
                        </div>--}}
                        <select id="groupSelect" class="selectpicker">
                            <option name="groupId" value="1">2-특강 A반</option>
                            <option name="groupId" value="2">1-특강 B반</option>
                        </select>
                    </div>
                    <div class="modal-footer" style="text-align: center">
                        <button type="submit" class="btn btn-primary">선택하기</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>