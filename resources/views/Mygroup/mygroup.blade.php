<!DOCTYPE html>
<html>
    <title>My group</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script
        defer="defer"
        src="https://use.fontawesome.com/releases/v5.0.10/js/all.js"
        integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"
        crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <body >
    <!--그룹이 아무것도 없을때의 경우를 생각하지않았음 -->

        <!-- Sidebar -->
        {{--<div class="w3-sidebar w3-bar-block w3-light-grey w3-card"--}}
        {{--style="width:20%"> <form> <input type="text" name="search" placeholder="학생 찿기"--}}
        {{--class="input"> </form> <button type="button" class="w3-bar-item w3-button"--}}
        {{--data-toggle="modal" data-target="#create"> 클래스 생성 </button> <p></p> <div--}}
        {{--class="w3-dropdown-hover"> <h2>나의 클래스</h2> <button class="w3-button">클래스 <i--}}
        {{--class="fa fa-caret-down"></i> </button> <a href="#" class="w3-bar-item--}}
        {{--w3-button">A반</a> <a href="#" class="w3-bar-item w3-button">B반</a> <a href="#"--}}
        {{--class="w3-bar-item w3-button">C반</a> <a href="#" class="w3-bar-item--}}
        {{--w3-button">D반</a> </div> </div>--}}

        <!-- Page Content -->

        <div class="container">
            <div class="jumbotron">
                <!-- Button trigger modal -->


                <!-- Modal -->
                <div class="modal fade" id="studnetchange" tabindex="-1" role="dialog" aria-labelledby="studnetchange1" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="studnetchange1">학생 정보 수정</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <label for="studentnumber"><b>학번</b></label>
                                <input type="text"  name="studentnumber"  id="studentnumbers"  required>
                                <p></p>


                                <label for="name"><b>이름</b></label>
                                <input type="text"  name="name" id="studentnames" required>
                                <input type="hidden">
                                <p></p>

                                <input id="checkBox" type="checkbox">
                                <label for="psw"><b>비밀번호 바꾸기</b></label>
                                <input type="text" placeholder="새로운 비밀번호 변경" id="psw" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">닫기</button>
                                <button type="button" onclick="update('#')">변경하기</button>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="form-inline">
                    <div class="form-group"></div>
                    <div class="form-group"></div>
                </form>
                    <!-- <div class="fa-3x">
                        <i class="fas fa-cog fa-spin light" data-toggle="modal" data-target="#teacher"></i>
                    </div> -->
                    <p id ="teacher">김민수 선생님</p>
                    <h1  id ="group" >A반</h1>


                <!-- Button trigger modal -->
                <img src="https://i.imgur.com/5JqDi1z.png" style =" width:40px  ;"  data-toggle="modal" data-target="#exampleModal">

                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div >
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <textarea id="cmemo" cols="30" rows="10"></textarea>
                                <label for="firstChk"><input type="hidden" id="firstChk" value="1" onclick="enterTabTable('cmemo','cview')"></label>
                                <button type="button" onclick="enterTabTable('cmemo','cview')">확인</button>
                                <button type="button" onclick="expBasicData('cmemo','cview')">예시 보기</button>
                                <button type="button" onclick="excel('cview')">저장</button>
                                <div id="cview"></div>

                            </div>


                            </div>

                        </div>
                    </div>
                </div>

            </div>

            </div>

    <div class="row">
        <div class="col-xs-5">
            <input
                    class="margins"
                    type="text"
                    id="myInput"
                    onkeyup="myFunction()"
                    placeholder="미소속 학생 찾기"
                    title="Type in a name"
                    value="">
            <table>
                <tr class="header">
                    <th style="width:25%;">이름</th>
                    <th style="width:35%;">학번</th>
                    <th style="width:20%;">추가</th>
                </tr>
            </table>
            <table id="myTable">
            </table>
        </div>
        <div class="col-xs-7">>
            <table>
                <tr class="header">
                    <th style="width:15%;">이름</th>
                    <th style="width:20%;">학번</th>
                    <th style="width:35%;">학생 정보</th>
                    <th style="width:25%;">삭제</th>
                </tr>
            </table>

            <table id="student">
                <tr>
                    <th>
                        <input type="checkbox"/>클래스</th>
                    <th>이름</th>
                    <th>학번</th>
                    <th>레코드 박스</th>
                </tr>
                <tr>
                    <td><input type="checkbox"/>B반
                        <button>X</button>
                    </td>
                    <td  data-toggle="modal" data-target="#studnetsetting">안준휘</td>
                    <td>1401036</td>
                    <td>확인</td>
                </tr>

            </table>
        </div>

    </div>


            <style>
                button {
                    display: inline-block;
                }

                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                }

                td,
                th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }

                th {
                    background-color: #ccd;
                }

                tr:nth-child(even) {
                    background-color: #ecf6fc;
                }

                tr:nth-child(odd) {
                    background-color: #ddeedd;
                }

                .input[type=text] {
                    width: 130px;
                    box-sizing: border-box;
                    border: 2px solid #ccc;
                    border-radius: 4px;
                    font-size: 16px;
                    background-color: white;
                    background-image: url("https://i.imgur.com/LCkVIxO.png");
                    background-position: 10px 10px;
                    background-repeat: no-repeat;
                    padding: 12px 20px 12px 40px;
                    -webkit-transition: width 0.4s ease-in-out;
                    transition: width 0.4s ease-in-out;
                }

                .input[type=text]:focus {
                    width: 100%;
                }

                /* The Modal (background) */
                .modal {
                    display: none;
                    /* Hidden by default */
                    position: fixed;
                    /* Stay in place */
                    z-index: 1;
                    /* Sit on top */
                    padding-top: 100px;
                    /* Location of the box */
                    left: 0;
                    top: 0;
                    width: 100%;
                    /* Full width */
                    height: 100%;
                    /* Full height */
                    overflow: auto;
                    /* Enable scroll if needed */
                    background-color: rgb(0,0,0);
                    /* Fallback color */
                    background-color: rgba(0,0,0,0.4);
                    /* Black w/ opacity */
                }

                /* Modal Content */
                .modal-content {
                    position: relative;
                    background-color: #fefefe;
                    margin: auto;
                    padding: 0;
                    border: 1px solid #888;
                    width: 80%;
                    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
                    -webkit-animation-name: animatetop;
                    -webkit-animation-duration: 0.4s;
                    animation-name: animatetop;
                    animation-duration: 0.4s;
                }

                /* Add Animation */
                @-webkit-keyframes animatetop {
                    from {
                        top: -300px;
                        opacity: 0;
                    }
                    to {
                        top: 0;
                        opacity: 1;
                    }
                }

                @keyframes animatetop {
                    from {
                        top: -300px;
                        opacity: 0;
                    }
                    to {
                        top: 0;
                        opacity: 1;
                    }
                }

                /* The Close Button */
                .close {
                    color: white;
                    float: right;
                    font-size: 28px;
                    font-weight: bold;
                }

                .close:focus,
                .close:hover {
                    color: #000;
                    text-decoration: none;
                    cursor: pointer;
                }

                .modal-header {
                    padding: 2px 16px;
                    background-color: #5cb85c;
                    color: white;
                }

                .modal-body {
                    padding: 2px 16px;
                }

                .modal-footer {
                    padding: 2px 16px;
                    background-color: #5cb85c;
                    color: white;
                }
                .modal-backdrop {
                    position: relative !important;
                }
                .light {
                    margin-left: 840px;
                }
                .inline {
                    display: inline-block;
                }
            </style>

    <script>

        //학생 정보 수정
        function update() {


            var userId = document.getElementById("studentnumbers").value;
            var userName = document.getElementById("studentnames").value;
            var passwordState = document.getElementById("checkBox").value;
            var password = document.getElementById("psw").value;

            if(passwordState == 'on'){
                passwordState = true;
            }



            var postData =
            {
                userId :    userName,
                userName :  userId,
                password :  password,
                passwordState  :passwordState

            }



            alert(JSON.stringify(postData));

//            studentnumbers studentnames checkBox psw
            $.ajax({
                type: 'POST',
                url: "{{url('/groupController/studentModify')}}",
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: postData ,
                success: function (data) {
                    alert(JSON.stringify(postData))
                },
                error: function (data) {
                    alert("수정 실패");
                }
            });
        }






        function expBasicData(obj,obj2) {
            var sampleData = "1301036\t 김민수\n";
            sampleData += "1301032\t 박민수\n";
            sampleData += "1301033\t 최민수\n";
            sampleData += "1301030\t 공민수\n";
            document.getElementById(obj).value = sampleData;

            enterTabTable(obj,obj2);
        }

        function enterTabTable(obj,obj2) {
            var i, k, ftag, str="";
            var text = document.getElementById(obj).value;
            var arr = text.split("\n"); // 엔터키로 분리
            if(text.length > 2) {
                str += "<table border='1' cellpadding='3' cellspacing='1'>\n";
                str += "<tbody>\n";
                for(i=0; i < arr.length; i++) {
                    var sub_arr = arr[i].split("\t"); // 탭키로 분리
                    if(sub_arr.length==2) {
                        ftag = (document.getElementById("firstChk").checked == true) ? (i == 0) ? "No" : i : (i + 1);
                        str += "<tr>\n";
                        str += "</td>\n";


                        for (k = 0; k < sub_arr.length; k++) {

                            str += "<td>" + sub_arr[k] + "</td>\n";

                        }
                    }
                }

                str += "</tbody>\n";
                str += "</table>\n";

            }
            document.getElementById(obj2).innerHTML = str;

        }

        function excel() {

            var text = document.getElementById('cmemo').value;
            var arr = text.split("\n"); // 엔터키로 분리
            var studentlist =new Array();

            if(text.length > 0) {
                for (var i = 0; i < arr.length; i++) {
                    var sub_arr = arr[i].split("\t"); // 탭키로 분리
                    if (sub_arr.length == 2) {
                        studentlist.push({
                            id:sub_arr[0],
                            name:sub_arr[1]
                        }) ;
                    }
                }
            }


            var excelstudent = document.getElementById("cview").value;

            var params = {
                groupId : groupIds,
                students :JSON.stringify(studentlist)
            };
            alert(JSON.stringify(studentlist))
            jQuery.ajaxSettings.traditional = true;


            $.ajax({
                type: 'POST',
                url: "{{url('/groupController/pushInvitation')}}",
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:params,
                success: function (data) {

//                    alert(JSON.stringify(data));

                },
                error: function (data) {
                    alert("엑셀등록 에러");
                }
            });
        }

    </script>
        </body>
    </html>