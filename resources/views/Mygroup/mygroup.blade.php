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
        <!-- <div class="w3-sidebar w3-bar-block w3-light-grey w3-card"
        style="width:20%"> <form> <input type="text" name="search" placeholder="학생 찿기"
        class="input"> </form> <button type="button" class="w3-bar-item w3-button"
        data-toggle="modal" data-target="#create"> 클래스 생성 </button> <p></p> <div
        class="w3-dropdown-hover"> <h2>나의 클래스</h2> <button class="w3-button">클래스 <i
        class="fa fa-caret-down"></i> </button> <a href="#" class="w3-bar-item
        w3-button">A반</a> <a href="#" class="w3-bar-item w3-button">B반</a> <a href="#"
        class="w3-bar-item w3-button">C반</a> <a href="#" class="w3-bar-item
        w3-button">D반</a> </div> </div> -->

        <!-- Page Content -->

        <div class="container">
            <div class="jumbotron">

                <form class="form-inline">
                    <div class="form-group"></div>
                    <div class="form-group"></div>
                </form>
                    <!-- <div class="fa-3x">
                        <i class="fas fa-cog fa-spin light" data-toggle="modal" data-target="#teacher"></i>
                    </div> -->
                    <p id ="teacher">김민수 선생님</p>
                    <h1  id ="group" >A반</h1>
                <button id="close" class="btn btn-link" ><img src="https://i.imgur.com/5JqDi1z.png" style =" width:40px  ;" ></button>
                
                    <!-- <button
                        type="submit"
                        class="btn btn-default"
                        data-toggle="modal"
                        data-target="#exampleModal">초대하기</button> -->

                 
                </div>

            </div>

            <div class="w3-container"></div>
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
                // Get the modal
                var modal = document.getElementById('myModal');

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks the button, open the modal
                btn.onclick = function () {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function () {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }

                // Get the modal
                var modal = document.getElementById('id01');

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }

                $(document).ready(function () {
                    $('#chkParent').click(function () {
                        var isChecked = $(this).prop("checked");
                        $('#tblData tr:has(td)')
                            .find('input[type="checkbox"]')
                            .prop('checked', isChecked);
                    });

                    $('#tblData tr:has(td)')
                        .find('input[type="checkbox"]')
                        .click(function () {
                            var isChecked = $(this).prop("checked");
                            var isHeaderChecked = $("#chkParent").prop("checked");
                            if (isChecked == false && isHeaderChecked) 
                                $("#chkParent").prop('checked', isChecked);
                            else {
                                $('#tblData tr:has(td)')
                                    .find('input[type="checkbox"]')
                                    .each(function () {
                                        if ($(this).prop("checked") == false) 
                                            isChecked = false;
                                        }
                                    );
                                console.log(isChecked);
                                $("#chkParent").prop('checked', isChecked);
                            }
                        });
                });



                function getValue() {
                    var groupId = 1;

                      $.ajax({
                    type: 'POST',
                    url: "{{url('/groupController/groupDataGet')}}",
                    //processData: false,
                    //contentType: false,
                    dataType: 'json',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    //data: {_token: CSRF_TOKEN, 'post':params},
                    data: "groupId="+groupId,
                    success: function (data) {
                        GroupData = data;
//                        alert(JSON.stringify(GroupData['students']));

                        teacher = GroupData['teacher']['name'];
                        group = GroupData['group']['name'];
                        student = GroupData['students'];

                        $('#teacher').html(teacher);
                        $('#group').html(group);

                        var student_list = '';

                        for( var i = 0 ; i < student.length; i++){

                            student_list +='<tr><td>'

                                +student[i].name
                                +'</td><td>'
                                +student[i].id
                                +'</td><td>'+
                                '<button>학생 정보 수정</button>' +
                                '</td><td>'+
                                '<button>삭제하기</button>'+
                                '</td></tr>'
                        }

                        $('#student').html(student_list);


                    },
                    error: function (data) {
                        alert("에러");
                    }
                });

                }

            </script>
        </body>
    </html>