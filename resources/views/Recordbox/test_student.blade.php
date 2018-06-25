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


    .chartArea_student{
        float: left;
        position: relative;
        height: 500px;
        width: 70%;
        margin: 0;
        padding: 0;
    }
    .chartWrapper_student {
        width: 90%;
        height: 100%;
        margin-left: 5%;
        margin-right: 5%;
    }
    .chartAreaWrapper_student {
        margin: 0;
        width: 100%;
        height: 100%;
        overflow-x: scroll;
    }
    .canvaschart_student{
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
    .student_grade table tr{
        height: 50px;
        text-align: center;
    }


</style>


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

        <div class="chartArea_student">
            <div class="chartWrapper_student">
                <div class="chartAreaWrapper_student">
                    <div class="canvaschart_student" id="chartContainer_privacy_student"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="student_grade">

        <div id="std_grade_list_table" >
            <table class="table table-hover table-bordered" >
                <thead>
                <tr>
                    <th style=" text-align: center;min-width: 50px;">
                        번호
                    </th>
                    <th style=" text-align: center;min-width: 140px;">
                        날짜
                    </th>
                    <th style="text-align: center;min-width: 200px;">
                        문제 이름
                    </th>
                    <th style=" text-align: center;min-width: 80px;">
                        총 점수
                    </th>
                    <th style=" text-align: center;min-width: 80px;">
                        어휘
                    </th>
                    <th style=" text-align: center;min-width: 80px;">
                        독해
                    </th>
                    <th style=" text-align: center;min-width: 80px;">
                        단어
                    </th>
                    <th style=" text-align: center;min-width: 80px;">
                        재시험
                    </th>
                    <th style=" text-align: center;min-width: 100px;">
                        오답노트
                    </th>
                    <th style=" text-align: center;min-width: 100px;">
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
