<style>
    .record_student {
        z-index: 1;
        position: relative;
        display: block;
        clear: both;
    }

    .privacyStudentChart {
        position: relative;
        width: 500px;
        height: 300px;
        /*overflow-x: scroll;
        overflow-y: hidden;*/
    }
    .privacyStudentChartArea {
        margin: 0;
        width: 500px;
    }

    .canvaschart_privacy_student{
        position: relative;
        width: 0px;
        height: 0px;
        margin-left: 350px;
    }

</style>

<div class="record_student">

    <div>
        <div class="canvaschart_privacy_student" id="chartContainer_privacy_student"></div>
    </div>

    <div class="stdAllList_scroll" style="margin-bottom: 70px;overflow-y: scroll;margin-left: 60px;width: 250px;height: 500px;border: 1px solid #e5e6e8;">
        <div id="stdAllList">
            <table class="table table-hover table-bordered" style="width: 250px;height: 0;">
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
                <tbody id="student_list">

                </tbody>

            </table>
        </div>
    </div>

    <div class="student_grade">

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
</div>