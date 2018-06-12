<style>
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

<div class="record_student">

    <div class="studentContainer">

        <div class="studentChart">
            <div class="stdAllList_scroll">
                <div class="stdAllList">
                    <table class="studentList table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>
                                번호
                            </th>
                            <th>
                                이름
                            </th>
                        </tr>
                        </thead>

                        {{--getStudent()로 학생들 불러오기--}}
                        <tbody id="student_list">

                        </tbody>

                    </table>
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

        <div class="student_grade">

            <div id="std_grade_list_table">
                <table class="table table-hover table-bordered" >
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
    </div>
</div>