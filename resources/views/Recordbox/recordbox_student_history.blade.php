<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<style>
    .recordStudent_history {
        z-index: 1;
        position: relative;
        display: block;
        clear: both;
    }
    .record_chart{
        z-index: 1;
        position: relative;
        display: block;
        text-align: center;
        clear: both;
    }
    .chartAttribute {
        margin-top: 10px;
        height : 80px;
        width: 100%;
    }
    .attributeContainer {
        margin: auto;
        width: 80%;
        text-align: center;
    }
    .recordbox-radio{
        display: block;
        height: 100%;
        float:left;
        margin:0;
        vertical-align: middle;
    }
    .chooseDate {
        display: block;
        height: 100%;
        float:right;
        margin-right:7%;
        vertical-align: middle;
    }
    .recordbox-radio h4,.chooseDate h4{
    }
    .recordbox-radioButtons {
        vertical-align: middle;
    }
    .recordbox-radioButtons label{
        margin-left: 20px;
        margin-right: 20px;
    }
    .chart_total {
        color: #f08080;
    }
    .chart_vocabulary {
        color: #51cda0;
    }
    .chart_grammer {
        color: #df7970;
    }
    .chart_word {
        color: #4c9ca0;
    }
    .chartArea{
        height: 400px;
        width: 100%;
        margin: 0;
        padding: 0;
    }
    .chartWrapper {
        margin-left: 5%;
        margin-right: 5%;
        width: 80%;
        height: 100%;
    }
    .chartAreaWrapper {
        margin: 0;
        width: 100%;
        height: 100%;
        overflow-x: scroll;
    }
    .canvaschart{
        position: relative;
        padding-top: 10px;
        left: 0;
        top: 0;
        width: 100%;
        height: 95%;
        margin: 0;
    }
    .record_student {
        z-index: 1;
        position: relative;
        display: block;
        clear: both;
    }
    .studentContainer {
        width: 100%;
        height: auto;
        text-align: center;
    }
    .studentChart {
        width: 100%;
        height: 500px;
        text-align: center;
        margin-bottom: 50px;
    }

    .stdAllList_scroll {
        width: 250px;
        height: 500px;
        border: 1px solid #e5e6e8;
        float: left;
        position: relative;
        margin: 0;
        padding: 0;
    }
    .stdAllList {
        height: 500px;
        width: 100%;
        overflow-y: scroll;
    }
    .stdAllList .studentList {
        width: 100%;
    }
    .stdAllList .studentList thead tr th ,.stdAllList .studentList thead tr td{
        width: 50px;

    }


    .chartArea{
        float: left;
        position: relative;
        height: 500px;
        width: 70%;
        margin: 0;
        padding: 0;
    }
    .chartWrapper {
        margin-left: 10%;
        margin-right: 10%;
        width: 100%;
        height: 100%;
    }
    .chartAreaWrapper {
        margin: 0;
        width: 100%;
        height: 100%;
        overflow-x: scroll;
    }
    .canvaschart{
        position: relative;
        padding-top: 10px;
        left: 0;
        top: 0;
        width: 100%;
        height: 95%;
        margin: 0;
    }

    .student_grade {
        width: 90%;
        clear: both;
        position: relative;
        margin: 0;
    }



</style>

<div class="recordStudent_history">

    <div class="record_chart">
        <div class="recordbox-chartContainer">

            <div class="chartAttribute">

                <div class="attributeContainer">

                    <div class="recordbox-radio">
                        <h4>보기</h4>

                        <div class="recordbox-radioButtons">
                            <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='1' checked="checked">일주일</label>
                            <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='2' >한달</label>
                            <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='3' >3개월</label>
                            <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='4' >6개월</label>
                            <label><input type="radio" class="radio_changeDateToChart" name="optradio" onclick="changeDateToChart()" value='5' >12개월</label>
                        </div>
                    </div>

                    <div class="chooseDate" >
                        <h4>기간</h4>

                        <input type="date" name="chooseday" id="startDate"></input>

                        <input type="date" name="chooseday" id="endDate"></input>

                        <button class="btn btn-default" onclick="orderChart()">
                            조회
                        </button>
                    </div>
                </div>
            </div>


            <div class="chartArea">
                <div class="chartWrapper">
                    <div class="chartAreaWrapper">
                        <div class="canvaschart" id="chartContainer_privacy_student"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


<div class="record_student">

    <div class="studentContainer">

        <div class="student_grade">

            <div id="std_grade_list_table">
                <table class="table table-hover table-bordered" >
                    <thead>
                    <tr>
                        <th width="50px" style=" text-align: center;">
                            번호
                        </th>
                        <th width="140px" style=" text-align: center;">
                            날짜
                        </th>
                        <th style="text-align: center;">
                            문제 이름
                        </th>
                        <th width="80px" style=" text-align: center;">
                            총 점수
                        </th>
                        <th width="60px" style=" text-align: center;">
                            어휘
                        </th>
                        <th width="60px" style=" text-align: center;">
                            독해
                        </th>
                        <th width="60px" style=" text-align: center;">
                            단어
                        </th>
                        <th width="100px" style=" text-align: center;">
                            오답노트
                        </th>
                        <th width="80px" style=" text-align: center;">
                            성적표
                        </th>
                    </tr>
                    </thead>

                    <tbody id="studentGradeList" class="">


                    </tbody>

                </table>
            </div>
        </div>
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
