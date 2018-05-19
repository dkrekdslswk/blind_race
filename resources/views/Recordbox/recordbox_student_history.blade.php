<div class="history">

    <div style="width: 100%;height: 80px;">
        <div style="float: left;">
            <div class="radio">
                <h3>보기</h3>
                <label><input type="radio" checked="checked" id="radio_1" name="optradio" onclick="changeDateToChart()" value='1'>일주일</label>
                <label><input type="radio" id="radio_2" name="optradio" onclick="changeDateToChart()" value='2' >한달</label>
                <label><input type="radio" id="radio_3" name="optradio" onclick="changeDateToChart()" value='3' >3개월</label>
                <label><input type="radio" id="radio_4" name="optradio" onclick="changeDateToChart()" value='4' >6개월</label>
                <label><input type="radio" id="radio_5" name="optradio" onclick="changeDateToChart()" value='5' >12개월</label>
            </div>
        </div>

        <div class="chooseDate" style="margin-left: 20px;float: left;display: block;">
            <h3 style="margin: 0;">기간</h3>

            <input type="date" name="chooseday" id="startDate"></input>

            <input type="date" name="chooseday" id="endDate"></input>

            <button class="btn btn-default" onclick="orderChart()">
                조회
            </button>
        </div>
    </div>

    <div class="student_race_chart" style="width: 1000px;height: 450px;margin: 20px;border: 1px solid #e5e6e8;">
        <div class="canvaschart_privacy_student" id="chartContainer_privacy_student"></div>
    </div>

</div>

<div class="student_grade" style="margin: 20px;">

    <div id="std_grade_list_table">
        <table class="table table-hover table-bordered" style="width: 1600px;">
            <thead>
            <tr>
                <th width="50px" style=" text-align: center;">
                    번호
                </th>
                <th width="200px" style=" text-align: center;">
                    날짜
                </th>
                <th style=" text-align: center;">
                    문제 이름
                </th>
                <th width="150px" style=" text-align: center;">
                    총 점수
                </th>
                <th width="100px" style=" text-align: center;">
                    어휘
                </th>
                <th width="100px" style=" text-align: center;">
                    독해
                </th>
                <th width="100px" style=" text-align: center;">
                    단어
                </th>
                <th width="110px" style=" text-align: center;">
                    재시험
                </th>
                <th width="110px" style=" text-align: center;">
                    오답노트
                </th>
                <th width="110px" style=" text-align: center;">
                    성적표
                </th>
            </tr>
            </thead>

            <tbody id="studentGradeList" class="">


            </tbody>

        </table>
    </div>

</div>



{{--Modal : make quiz--}}
<div class="modal fade" id="modal_studentGradeCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 1200px">

        <div class="modal-content" style="padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">학생 점수</h3>

                <div class="modal_student_date" style="width: 100%;text-align: right;"> </div>

                <div class="student_race_and_teacher" style="width: 100%;">
                    <h5 style="margin: 0;text-align:center">
                        <div class="" id="modal_student_raceName_teacher" style="display: inline;margin-right: 10px;"> </div>

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
                    <tbody id="studentGradeCard">

                    </tbody>
                </table>
            </div>

            <input type="hidden" name="hiddenValue" id="hiddenValue" value="" />

            <div class="modal-footer">
            </div>
        </div>

        {{--상세 보기--}}
        <div class="modal-content" style="margin-top: 10px;padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">상세 보기</h3>
            </div>

            <div class="modal-body" style="text-align: left;margin: 0;">

                <div class="gradeDetail_quiz" style="width: 100%;clear: left">

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

                        <tbody id="details_record">

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


{{--Modal : make quiz--}}
<div class="modal fade" id="modal_studentWritingWrons" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 1200px">

        <div class="modal-content" style="padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">오답 노트</h3>

                <div class="modal_student_wrong_date" style="width: 100%;text-align: right;"> </div>

                <div class="student_race_and_teacher" style="width: 100%;">
                    <h5 style="margin: 0;text-align:center">
                        <div class="" id="modal_student_wrong_raceName_teacher" style="display: inline;margin-right: 10px;"> </div>

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

                    <tbody id="wrongQuestions">

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
