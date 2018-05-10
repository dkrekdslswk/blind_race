<div class="col-xs-6" style="padding: 6px 15px;">
    총 학생 5명
</div>
<br>


<div class="list_box" >
    <div class="list_container" style="max-width: 1180px; margin-left: 10px;margin-right: 10px;">

            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="50px">
                            번호
                        </th>
                        <th>
                            이름
                        </th>
                        <th>
                            전체 성적
                        </th>
                        <th>
                            어휘
                        </th>
                        <th>
                            문법
                        </th>
                        <th>
                            단어
                        </th>
                    </tr>
                </thead>
                <tbody id="student_list">

                </tbody>

                <script>

                    var grade1 = ["김똘똘",95,32,30,33];
                    var grade2 = ["최천재",75,20,28,27];
                    var grade3 = ["심사쵸",55,15,14,15];
                    var grade4 = ["안예민",55,15,14,15];
                    var grade5 = ["사라다",55,15,14,15];

                    var all_grade = [grade1,grade2,grade3,grade4,grade5];

                    for(var i = 0 ; i < all_grade.length; i++){
                        $('#student_list').append($('<tr id="student_list_'+i+'">'));

                        for(var j = 0 ; j < all_grade[0].length ; j++ ) {

                            if( j == 0){
                                $('#student_list_' + i).append($('<td>').text(i+1));
                                $('#student_list_' + i).append($('<td>').append($('<a href="#">').text(all_grade[i][j])));

                            }else{
                                $('#student_list_' + i).append($('<td>').text(all_grade[i][j]));
                            }
                        }
                    }

                </script>

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

