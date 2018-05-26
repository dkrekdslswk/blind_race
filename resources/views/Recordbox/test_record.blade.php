
{{--Modal : Race Record--}}
<div class="modal fade" id="modal_RaceGradeCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 1200px">

        <div class="modal-content" style="padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">학생 점수</h3>

                <div class="modal_date" style="width: 100%;text-align: right;"> </div>

                <div class="" id="modal_raceName_teacher" style="text-align:center;width: 100%;"></div>

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
                <div class="modal_total_list" id="modal_total_grade" style="width: 30%;float: right;"></div>
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