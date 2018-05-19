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

{{--Modal : make quiz--}}
<div class="modal fade" id="modal_RaceGradeCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 1200px">

        <div class="modal-content" style="padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">학생 점수</h3>

                <div class="modal_date" style="width: 100%;text-align: right;"> </div>

                <div class="race_and_teacher" style="width: 100%;">
                    <h5 style="margin: 0;text-align:center">
                        <div class="" id="modal_raceName_teacher" style="display: inline;margin-right: 10px;">
                        </div>
                    </h5>
                </div>

            </div>

            <div class="modal-body" style="text-align: left;margin: 0;">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>
                            학생
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
                    <tbody id="grade_list">

                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                    <div class="modal_total_list" id="modal_total_grade" style="width: 30%;float: right;">

                    </div>


            </div>
        </div>

        {{--상세 보기--}}
        <div class="modal-content" style="margin-top: 10px;padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">상세 보기</h3>
            </div>

            <div class="modal-body" style="text-align: left;margin: 0;">

                <div class="race_and_teacher" style="width: 100%;margin-bottom: 10px;margin-left: 50px;">
                    <h5 style="margin: 0;text-align:left">
                        <div class="" style="display: inline;margin-right: 10px;">
                            <input type="checkbox" checked="checked" id="checkbox_0" value="0" onclick="toggle_detailStudent_and_Wrong()">학생
                        </div>
                        <div class="" style="display: inline;margin-left: 10px;">
                            <input type="checkbox" checked="checked" id="checkbox_1" value="1" onclick="toggle_detailStudent_and_Wrong()">오답 문제
                        </div>
                    </h5>
                </div>

                <div id="toggle_only_students">
                    <div class="gradeDetail_student" style="height: 550px;width: 100%;">
                        <div class="modal_list_student" style="width: 100%;margin-top: 10px;">학생</div>

                        <div class="stdAllList_scroll" style="float: left;overflow-y: scroll;margin-left: 60px;height: 500px;border: 1px solid #e5e6e8;">
                            <div id="stdAllList" style="width: 250px;">
                                <table class="table table-hover table-bordered" style="width: 100%;height: 0;">
                                    <thead>
                                    <tr>
                                        <th width="50px">
                                            번호
                                        </th>
                                        <th>
                                            이름
                                        </th>
                                    </tr>
                                    </thead>

                                    {{--getStudent()로 학생들 불러오기--}}
                                    <tbody id="toggle_student_list">

                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <div style="margin-top: 50px;margin-left: 50px;margin-right: 50px;float: left;">
                            >
                        </div>

                        <div class="stdAllList_scroll" style="float: left;overflow-y: scroll;margin-left: 60px;height: 500px;border: 1px solid #e5e6e8;">
                            <div id="stdAllList" style="width: 600px;">
                                <table class="table table-hover table-bordered" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th width="50px">
                                                번호
                                            </th>
                                            <th colspan="3">
                                                정답
                                            </th>
                                        </tr>
                                    </thead>

                                    {{--getStudent()로 학생들 불러오기--}}
                                    <tbody id="toggle_wrong_answers">

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="toggle_only_wrong_answers" class="" style="width: 100%;clear: left">

                    <div class="modal_list_wrong" style="width: 100%;margin-top: 10px;text-align: left;">오답 문제</div>

                    <table class="table table-hover">
                        <thead>
                        <tr id="race_detail_record">
                            <th style="width: 50px">
                                번호
                            </th>
                            <th colspan="2">
                                문제
                            </th>
                            <th style="width: 100px">
                                오답률
                            </th>
                        </tr>
                        </thead>

                        <tbody id="wrong_detail">

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


{{--Modal : 오답 노트 --}}
<div class="modal fade" id="modal_studentWrongGradeCard_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 1200px">

        <div class="modal-content" style="padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">오답 노트</h3>

                <div class="modal_wrong_date_history" style="width: 100%;text-align: right;"> </div>

                <div class="student_race_and_teacher_history" style="width: 100%;">
                    <h5 style="margin: 0;text-align:center">
                        <div class="" id="modal_wrong_raceName_teacher" style="display: inline;margin-right: 10px;"> </div>

                    </h5>
                </div>

            </div>
            <div class="modal-body" style="text-align: left;margin: 0;">
                <table class="table table-hover">
                    <thead>
                    <tr id="race_detail_record">
                        <th style="width: 50px">
                            번호
                        </th>
                        <th colspan="2">
                            문제
                        </th>
                    </tr>
                    </thead>

                    <tbody id="wrongQuestions_history">

                    </tbody>
                </table>

            </div>

            <input type="hidden" name="hiddenValue" id="hiddenValue" value="" />

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="changeCheck()" id="feedback_modal_confirm">확인</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modal_feedback_cancel">취소</button>
            </div>

            <script>
                function changeCheck(){
                    alert('정상 등록하였습니다.');
                    $('#1check').attr('class','btn btn-primary').text('확인');
                }
            </script>
        </div>


    </div>
</div>