<html>
<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <!-- Bootstrap CSS CDN -->
    <style>
        body {
            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            background-color: #f7f8fa;
            font-size: 13px;
            color: #5f5f5f;
            margin: 0;
            padding: 0;
        }
        .recordbox_main {
            clear: both;
            width: 100%;
            height: 100%;
            display: block;
            position: relative;
        }
        .record_mainPage {
            padding: 0;
            position: relative;
            float: left;
            width: 85%;
        }
        .changePages {
            z-index: 1;
            position: relative;
            display: block;
            text-align: center;
            clear: both;
            margin-bottom: 50px;
        }
        .insertMargin {
            margin-left: 15%;
        }

        /*modal-page*/
        .modal-dialog {
            width: 1000px;
        }
        .modal-content.studentGrade ,.modal-content.detail {
            margin-bottom: 5px;
            padding: 10px 20px 0 20px;

        }
        .modal-header {
            text-align: center;
        }
        .modal-header #modal_date{
            text-align: right;
        }
        .modal-body {
            text-align: left;
        }
        .modal-footer #modal_total_grades{
            float: right;
        }

        .modal_wrong {
            width: 100%;
            clear: both;
        }
        .wrong_left ,.wrong_right{
            float: left;
            position: relative;
            width: 50%;
            padding: 10px;
            border: 1px solid #e5e6e8;
        }
        .noBoardLine {
            border: 0;
        }

        .table_wrongList thead tr {
            vertical-align: top;
        }
        .table_wrongList thead tr > th:first-child{
            width: 30px;
        }
        .table_wrongList thead tr > th:first-child div{
            margin-top: 3px;
        }
        .table_wrongList thead tr > th:last-child{
            margin-top: 3px;
        }
        .table_wrongList thead tr > th:last-child div{
            margin-bottom: 10px;
        }

        .table_wrongList tbody ul{
            list-style-type: circle;
            padding: 0 0 0 25px;
            margin: 0;
            font-size: 15px;
        }
        .table_wrongList tbody ul > li:first-child{
            list-style-type: disc;
            color: red;
            margin-bottom: 3px;
        }
        .table_wrongList tbody .wrongExamples{
            margin-left: 20px;
        }
        .table_wrongList tbody .wrongWriting {
            width: 440px;
            min-height: 70px;
            margin-top: 10px;
            margin-bottom: 15px;
            border:1px solid #e5e6e8;
        }

        .btnHomeworkCheck {
            color: black;
            text-align: center;
            border: solid 2px grey;
            border-radius: 12px;
        }

        #modal_allWrongAnswerList tr , #details_record tr , #wrongQuestions tr{
            border-bottom: 1px solid #e5e6e8;
        }
        #modal_allWrongAnswerList tr td , #details_record tr td , #wrongQuestions tr td {
            border-left: 1px solid #e5e6e8;
        }

    </style>


</head>
<body>

{{--메인 네비바 불러오기--}}
@include('Navigation.main_nav')

<div class="recordbox_main">

    {{--사이드바 불러오기--}}
    @include('Recordbox.record_sidebar')

    <div class="record_mainPage">

        <div class="recordbox_navbar">
            {{--레코드 네비바 불러오기--}}
            @include('Recordbox.record_recordnav')

        </div>

        <div class="changePages">
            {{--레코드 flz 불러오기--}}
            @include('Recordbox.record_'.$where)
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


</body>
</html>