<style>
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
    .radioStudentGrade {
        margin-bottom: 20px;
    }
    .canvaschart_privacy_student{
        position: relative;
        width: 0px;
        height: 0px;
        margin-left: 350px;
    }
    .student_grade {
        margin-top: 300px;
    }

</style>

<div class="radioStudentGrade">
    <input type="radio" checked="checked" name="studentGrade" value="0" onclick="sothat()">학생
    <input type="radio" name="studentGrade" value="1" onclick="sothat()">레이스

</div>

<div>
    <div class="canvaschart_privacy_student" id="chartContainer_privacy_student"></div>
</div>

<div class="stdAllList_scroll" style="margin-bottom: 70px;overflow-y: scroll;float: left;margin-left: 60px;height: 500px;border: 1px solid #e5e6e8;">
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

<div class="student_grade" style="display: block;">

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

            <tbody id="student_grade_list" class="">

            <tr>
                <td width="50px" style=" text-align: center;">
                    1
                </td>
                <td width="200px" style=" text-align: center;">
                    2018년 04월 24일
                </td>
                <td style=" text-align: center;">
                    스쿠스쿠 문법 풀이
                </td>
                <td width="150px" style=" text-align: center;">
                    55
                </td>
                <td width="100px" style=" text-align: center;">
                    20
                </td>
                <td width="100px" style=" text-align: center;">
                    20
                </td>
                <td width="100px" style=" text-align: center;">
                    15
                </td>
                <td width="110px" style=" text-align: center;">
                    미응시
                </td>
                <td width="110px" style=" text-align: center;">
                    미제출
                </td>
                <td width="110px" style=" text-align: center;">
                    <button class="btn btn-info">성적표</button>
                </td>
            </tr>
            </tbody>

        </table>
    </div>

</div>

<script>
    $('#raceAllList').attr('class','hidden');
    $('#race_grade_list').attr('class','hidden');

    function sothat(){
        var selectedradio = $("input[type=radio][name=studentGrade]:checked").val();

        if(selectedradio == 0){
            $('#stdAllList').attr('class','');
            $('#std_grade_list_table').attr('class','');
            $('#raceAllList').attr('class','hidden');
            $('#race_grade_list').attr('class','hidden');
        }else{
            $('#raceAllList').attr('class','');
            $('#race_grade_list').attr('class','');
            $('#stdAllList').attr('class','hidden');
            $('#std_grade_list_table').attr('class','hidden');
        }
    }

</script>