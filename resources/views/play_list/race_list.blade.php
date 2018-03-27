<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
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
<script></script>
<body>
    <div class="btn-process" style="margin-left:20%; margin-top:50px;">
        <form id="" class="form-inline my-2 my-lg-0 mr-lg-2">
            <div class="input-group">
                <select class="selectpicker btn btn-primary">
                    <optgroup label="검색옵션">
                        <option>제목</option>
                        <option>난이도</option>
                        <option>페이지</option>
                    </optgroup>
                </select>
                <input class="form-control" type="text" placeholder="Search for...">
                <span class="input-group-append">
                    <button class="btn btn-primary" type="button">
                      <i class="fa fa-search">검색</i>
                    </button>
                  </span>
                <button class="btn btn-info" style="margin-left:100px;">목록</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table class="" >
            <thead>
            <tr class="bg-dark" style="height:40px">
                <th>Name</th>
                <th>Level</th>
                <th>page</th>
                <th></th>
            </tr>
            </thead>
            <tr class="content">
                <td>스쿠스쿠 레이스 1</td>
                <td>Level</td>
                <td>p15 - p30</td>
                <td><button class="btn btn-info" data-toggle="modal" data-target="#Modal">시작하기</button></td>
            </tr>
            <tr class="content">
                <td>스쿠스쿠 레이스 2</td>
                <td>Level</td>
                <td>p30 - p45</td>
                <td><button class="btn btn-info">시작하기</button></td>
            </tr>
            <tr class="content">
                <td>스쿠스쿠 레이스 3</td>
                <td>Level</td>
                <td>p45 - p60</td>
                <td><button class="btn btn-info">시작하기</button></td>
            </tr>
        </table>
    </div>

    {{--Modal : select group--}}
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/race_waiting">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <h5 class="modal-title" id="ModalLabel">그룹 선택</h5>
                    </div>
                    <div class="modal-body">
                        {{--드롭 다운--}}
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" id="mystatus" value="title" type="button" data-toggle="dropdown" aria-expanded="true">
                                그룹명
                            </button>
                            <ul id="mytype" class="dropdown-menu" role="menu" aria-labelledby="searchType">
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="#">2-특강 A반</a>
                                </li>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="#">1-특강 B반</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer" style="text-align: center">
                        <form action="/test">
                            <button type="submit" class="btn btn-primary">선택하기</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">취소</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
          

