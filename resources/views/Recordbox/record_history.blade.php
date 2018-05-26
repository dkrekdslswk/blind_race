<div class="history">
    <div style="width: 1000px;margin-left: 50px;float: left;">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>번호</th>
                <th>이름</th>
                <th>날짜</th>
                <th>재시험</th>
                <th>오답노트</th>
                <th>성적표</th>
            </tr>
            </thead>
            <tbody id="history_list">
            </tbody>
        </table>

        <div class="panel-footer" style="height: 80px;">
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


    <div style="margin-top: 50px;margin-left: 50px;margin-right: 50px;float: left;">
            >
    </div>

    {{--과제 목록 보기--}}
    <div class="raceListDetail" style="width: 400px;float: left;">
        <table class="table table-hover table-bordered table-striped" >
            <thead>
            <tr>
                <th width="50px">
                    번호
                </th>
                <th>
                    학생
                </th>
                <th width="110px">
                    재시험
                </th>
                <th width="110px">
                    오답노트
                </th>
            </tr>
            </thead>

            {{--getStudent()로 학생들 불러오기--}}
            <tbody id="history_homework">

            </tbody>

        </table>
    </div>
</div>

