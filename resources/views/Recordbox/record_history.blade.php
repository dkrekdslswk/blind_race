<style>
    .record_history {
        z-index: 1;
        position: relative;
        display: block;
        clear: both;
    }
    .recordbox-history {
        margin-top: 40px;
        margin-left: 20px;
        margin-right: 20px;
        padding: 0;
    }
    .historyContainer {
        width: 100%;
    }
    .historyContainer .historyList {
        display: block;
        float: left;
        width: 65%;
    }
    .historyContainer .raceListDetail {
        display: block;
        float: left;
        width: 30%;
        text-align: center;
        height: 70%;
    }
    .historyContainer .raceListDetail .raceListDetailScroll {
        width: 100%;
        height: 100%;
        overflow-y: scroll;
        border: 1px solid #e5e6e8;
    }
    .raceListDetail table thead tr th ,.raceListDetail table tbody {
        text-align: center;
    }

</style>

<script>

    $(document).ready(function () {

    });

</script>

<div class="recordbox-history">
    <div class="historyContainer">

        <div class="historyList">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>번호</th>
                    <th>퀴즈 제목</th>
                    <th>날짜</th>
                    <th>성적표</th>
                    <th>과제 확인하기</th>
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

        <div style="display: block;float: left;margin: 2%;">
        </div>

        {{--과제 목록 보기--}}
        <div class="raceListDetail">
            <div class="raceListDetailScroll">
                <table class="table table-hover table-bordered table-striped" >
                    <thead>
                    <tr>
                        <th id="historyListNumber">
                            번호
                        </th>
                        <th id="historyListRaceName" colspan="2">
                            퀴즈제목
                        </th>
                    </tr>
                    <tr>
                        <th>
                            학생
                        </th>
                        <th>
                            재시험
                        </th>
                        <th>
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
    </div>
</div>

<div class="modal_page">
    {{--Modal : Race Record--}}
    <div class="modal fade" id="modal_RaceGradeCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 1000px
        ;" >

            {{--PAGE SPLIT 1. 모달 학생점수 페이지--}}
            <div class="modal-content studentGrade">

                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel" >학생 점수</h3>

                    {{--INSERT DATA 1. 날짜--}}
                    <div id="modal_date"> </div>

                    {{--INSERT DATA 2. 레이스이름과 교수님 성함--}}
                    <div id="modal_raceName_teacher"></div>

                </div>

                <div class="modal-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th id="modal_total_students">

                            </th>
                            <th>
                                평균점수
                            </th>
                            <th>
                                어휘
                            </th>
                            <th>
                                문법
                            </th>
                            <th>
                                독해
                            </th>
                            <th>
                                갯수
                            </th>
                        </tr>
                        </thead>

                        {{--INSERT DATA 3. 학생들 성적 테이블--}}
                        <tbody id="modal_gradeList">

                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">

                    {{--PAGE SPLIT 2. 모달 전체 평균 점수들--}}
                    {{--INSERT DATA 4. 전체 평균 점수들--}}
                    <div id="modal_total_grades"> </div>
                </div>
            </div>

            {{--PAGE SPLIT 3. 모달 상세보기 페이지--}}
            <div class="modal-content detail">
                <div class="modal-header">
                    <h3 class="modal-title" id="ModalLabel">상세 보기</h3>
                </div>

                <div class="modal-body">

                    {{--PAGE SPLIT 6. 모달 레이스 전체 오답노트 리스트--}}
                    <div id="toggle_only_wrong_answers" class="modal_wrong">

                        <div class="wrong_left">

                        </div>
                        <div class="wrong_right">

                        </div>

                        <div>
                            <table class="table table-hover">
                                <tbody id="modal_allWrongAnswerList">

                                </tbody>

                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>