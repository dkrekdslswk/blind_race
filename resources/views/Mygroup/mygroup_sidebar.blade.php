<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .page-small .learn-small,
        .page-small .main-small,
        .page-small .set-small {
            display: none !important;
        }
        .page-small .board-small-show {
            width: 100% !important;
        }

        .learn-small-show,
        .set-small-show,
        .set-small-show-init,
        .set-small-show-table {
            display: none !important;
        }
        .page-small .learn-small-show,
        .page-small .set-small-show {
            display: block !important;
        }
        .page-small .set-small-show-init {
            display: initial !important;
        }
        .page-small .set-small-show-table {
            display: table-cell !important;
        }

        .profile-picture {
            padding: 10px 10px 25px 16px;
            position: relative;
        }

        .profile-picture table {
            width: 100%;
        }

        .m-t-lg {
            margin-top: 30px !important;
        }
        .main-left-menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }
        .main-left-menu > li > a.noaction {
            cursor: default;
            font-size: 12px;
            font-weight: normal;
            padding-bottom: 3px;
            padding-top: 30px;
            color: #a2a2a1;
        }
        .main-left-menu > li > a.noaction:hover {
            background: transparent;
            color: #a2a2a1;
            cursor: default;
        }
        .main-left-menu > li > a {
            position: relative;
            display: block;
            padding: 8px 15px;
            color: #5f5f5f;
            font-weight: normal;
            border-left: 3px solid transparent;
            font-size: 14px;
        }
        .main-left-menu > li > a > .icon:before {
            content: "▼";
        }
        .main-left-menu > li > a:hover {
            /* background: rgba(0, 0, 0, 0.06); */
            color: #8ebd4d;
        }
        .main-left-menu > li.active > a {
            background: #D4FF93;
            margin: 0 10px;
            padding: 4px 0 4px 5px;
        }
        .main-left-menu > li.active.class-toggle > a {
            background: transparent;
            color: #5f5f5f;
            pointer-events: auto;
            cursor: pointer;
        }
        .main-left-menu > li.active.class-toggle > a:hover {
            color: #8ebd4d;
        }
        .main-left-menu > li.active > a > .icon:before {
            content: "▲";
        }
        .main-left-menu > li.active .toggle-class > a,
        .main-left-menu > li:hover .toggle-class > a {
            color: #8ebd4d;
        }

        .sidebar_main {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            color: #5f5f5f;
            font-size: 13px;
            line-height: 18px;
            margin-top: 30px;
        }

        .sidebar_footer {
            text-align: center;
            padding: 50px 16px 10px;
        }

        .news {
            width: 100%;
            text-align: left;
        }
        .news_image {
            border: 1px solid #e1e2e3;
        }
        .news_contents {
            margin-top: 10px;
        }

        #navigation {}

        @media (max-width: 768px) {
            .page-small #wrapper-class .content,
            .page-small .content,
            .page-small .content-main {
                padding: 15px 5px;
                min-width: 320px;
            }
        }

        .w3-card,
        .w3-card-2 {
            position: absolute !important;
        }
        .margins {

        }






    </style>
    <script>
            var groupIds ;

            function getAnothergroup(groupId) {

                $.ajax({
                    type: 'POST',
                    url: "{{url('/groupController/groupDataGet')}}",
                    //processData: false,
                    //contentType: false,
                    async:false,
                    dataType: 'json',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    //data: {_token: CSRF_TOKEN, 'post':params},
                    data: "groupId=" + groupId,
                    success: function (data) {
                            GroupData = data;
//                     alert(JSON.stringify(GroupData['students']));

                            teacher = GroupData['teacher']['name'];
                            group = GroupData['group']['name'];
                            groupIds = GroupData['group']['id'];
                            student = GroupData['students'];

                            $('#teacher').html(teacher);
                            $('#group').html(group);
                            $('#groupIds').val(groupIds);
                            var student_list = '';

                            for (var i = 0; i < student.length; i++) {

                                student_list += '<tr><td>'

                                    + student[i].name
                                    + '</td><td id="delete' + i + '">'
                                    + student[i].id
                                    + '</td><td>' +
                                    ' <button type="button"  data-toggle="modal" ' +
                                    '   data-target="#studnetchange" onclick="setting(' + i + ');">\n' +
                                    ' 비밀번호 변경\n' +
                                    ' </button>' +
                                    '</td><td>' +
                                    '<button onclick="Delete(' + i + ')">제외하기</button>' +
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
</head>

<div id="navigation" style="min-height: 600px;">

    <!--네비바 위부분 공백-->
    <div
            class="page-small"
            style="text-align: center; margin-top: 10px; margin-bottom:10px;"></div>


    <div class="w3-sidebar w3-bar-block w3-light-grey w3-card">
        <!-- <form> -->
        <!-- <input type="text" name="search" placeholder="학생 찿기" class="input"></form>
        -->

        <button class="w3-bar-item w3-button">
            <!-- <a href="#" class="class=" w3-bar-item="w3-bar-item"
            w3-button""="w3-button""">미등록 학생</a> -->
        </button>

        <button
                type="button"

                data-toggle="modal"
                data-target="#create">
            클래스 생성
        </button>

        <div class="w3-dropdown-hover">
            <h2>나의 클래스</h2>


            <table id="Myclass">
            </table>


        </div>




    </div>
</div>

