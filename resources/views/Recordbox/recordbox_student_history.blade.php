<div class="history">

    <div style="width: 100%;height: 80px;">
        <div class="radio" style="float: left;">
            <h3 style="float: left;margin: 0;">보기</h3>
            <label><input type="radio" checked="checked" id="radio_1" name="optradio" onclick="changeDateType()" value='1'>일</label>
            <label><input type="radio" id="radio_2" name="optradio" onclick="changeDateType()" value='2' >월</label>
            <label><input type="radio" id="radio_3" name="optradio" onclick="changeDateType()" value='3' >년도</label>
        </div>

        <div class="chooseDate" style="margin-left: 20px;float: left;">
            <h3 style="margin: 0;">기간</h3>

            <input type="date" name="chooseday" id="startDate"></input>

            <input type="date" name="chooseday" id="endDate"></input>

            <button class="btn btn-default" onclick="changeDateTypeToChart()">
                조회
            </button>
        </div>
    </div>

    <div style="width: 100%;">

    <div class="student_race_chart" style="width: 100%;height: 300px;margin: 10px;border: 1px solid #e5e6e8;">
        <div class="canvaschart_privacy_student" id="chartContainer_privacy_student"></div>
    </div>

    <div class="student_grade" >


        <div id="std_grade_list_table" style="margin: 20px;margin-bottom: 0;">
            <table class="table table-hover table-bordered" style="width: 100%;margin: 0;">
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

                <tbody id="student_race_list" class="">

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
                        <button class="btn btn-warning">미응시</button>
                    </td>
                    <td width="110px" style=" text-align: center;">
                        <button class="btn btn-primary">제출</button>
                    </td>
                    <td width="110px" style=" text-align: center;">
                        <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal_studentGradeCard">성적표</button>
                    </td>
                </tr>
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
    </div>


    </div>
</div>
{{--Modal : make quiz--}}
<div class="modal fade" id="modal_studentGradeCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 1200px">

        <div class="modal-content" style="padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">학생 점수</h3>
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
                        <th style="width: 100px">
                            재시험
                        </th>
                        <th style="width: 100px">
                            오답노트
                        </th>
                    </tr>
                    </thead>
                    <tbody id="student_grade_list">

                    </tbody>
                </table>
            </div>

            <script>

                var grade1 = ["김똘똘",55,20,20,15,"11/20","미응시","미제출"];

                var all_grade = [grade1];

                for(var i = 0 ; i < all_grade.length ; i++){
                    $('#student_grade_list').append($('<tr id="studentGrade_'+all_grade[i][0]+'">'));

                    for(var j = 0 ; j < all_grade[0].length ; j++ ) {

                        if( j >= 6){
                            if (all_grade[i][j] != "pass"){
                                $('#studentGrade_' + all_grade[i][0]).append($('<td>').append($('<button>').attr('class','btn btn-warning').text(all_grade[i][j])));
                            }else{
                                $('#studentGrade_' + all_grade[i][0]).append($('<td>').text(all_grade[i][j]));
                            }
                        }else{
                            $('#studentGrade_' + all_grade[i][0]).append($('<td>').text(all_grade[i][j]));
                        }
                    }
                }

            </script>

            <div class="modal-footer">
            </div>
        </div>

        {{--상세 보기--}}
        <div class="modal-content" style="margin-top: 10px;padding: 10px 20px 0 20px;">
            <div class="modal-header">
                <h3 class="modal-title" id="ModalLabel" style="text-align: center;">상세 보기</h3>
            </div>

            <div class="modal-body" style="text-align: left;margin: 0;">
                <div class="race_and_teacher" style="width: 100%;">
                    <h5 style="margin: 0;text-align:center">
                        <div class="" style="display: inline;margin-right: 10px;">
                            스쿠스쿠3
                        </div>
                        /
                        <div class="" style="display: inline;margin-left: 10px;">
                            김똘똘
                        </div>
                    </h5>
                </div>

                <div class="modal_date" style="width: 100%;text-align: right;"> 2018년 1월 16일</div>

                <div class="gradeDetail_quiz" style="width: 100%;clear: left">

                    <div class="modal_date" style="width: 100%;margin-top: 10px;text-align: left;">오답 문제 (3개)</div>

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
                        <div class="incorrect">
                            <tr>
                                <td rowspan="3"  style="border-right: 1px solid #e5e6e8; width: 50px;">
                                    3
                                </td>
                                <td rowspan="1" colspan="2" style="text-align: center;">
                                    苦労してためたお金なのだから、一円（　　）無駄には使いたくない。
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffa500; border-right: 1px solid transparent;">
                                    たりとも
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;background-color: #e5e6e8;">
                                    <div style="float:left;">
                                        ばかりも
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="float:left;">
                                        だけさえ
                                    </div>
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    <div style="float:left;">
                                        とはいえ
                                    </div>
                                </td>
                            </tr>
                        </div>
                        <div class="incorrect">
                            <tr>
                                <td rowspan="3"  style="border-right: 1px solid #e5e6e8; width: 50px;">
                                    13
                                </td>
                                <td rowspan="1" colspan="2" style="text-align: center;">
                                    この店は洋食と和食の両方が楽しめる（　　）、お得意さんが多い。
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffa500; border-right: 1px solid transparent;">
                                    とあって
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    からして
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #e5e6e8;">
                                    にあって
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    <div style="float:left;">
                                        にしては
                                    </div>
                                </td>
                            </tr>
                        </div>
                        <div class="incorrect">
                            <tr>
                                <td rowspan="3"  style="border-right: 1px solid #e5e6e8; width: 50px;">
                                    17
                                </td>
                                <td rowspan="1" colspan="2" style="text-align: center;">
                                    姉は市役所に勤める（　　）、ボランティアで日本語を教えています。
                                </td>
                            </tr>
                            <tr>
                                <td style="background-color: #ffa500; border-right: 1px solid transparent;">
                                    かたわら
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;">
                                    かたがた
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="float:left;">
                                        こととて
                                    </div>
                                </td>
                                <td style="border-left: 1px solid #e5e6e8;background-color: #e5e6e8;">
                                    <div style="float:left;">
                                        うちに
                                    </div>
                                </td>
                            </tr>
                        </div>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
