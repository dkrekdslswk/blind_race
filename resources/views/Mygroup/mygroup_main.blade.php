<html>
<head>
    <meta charset="UTF-8">
    <meta
            name="viewport"
            content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Document</title>

    <!-- Bootstrap CSS CDN -->
    <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script>
        //그룹ID

        function add_student(st_made_number){
            var student_number = $("#st"+st_made_number).text();

            var student_number_zip = new Array();

            //배열을 push 할 경우는 [["13","14","15"],"19","18"] 이런식으로 2차원으로 들어가 처리가 더필요함
            student_number_zip.push(student_number);


            student_number_zip = JSON.stringify(student_number_zip);

            $.ajax({
                type: 'POST',
                url: "{{url('/groupController/pushInvitation')}}",
                dataType: 'json',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: "groupId="+pub_groupId+"&students="+student_number_zip,
                success: function (data) {
                    alert("성공");
                },
                error: function (data) {
                    alert("에러");
                }
            });
        }

    </script>
    <style>
        body {
            font-family: arial, sans-serif;
            background-color: #f7f8fa;
            font-size: 13px;
            color: #5f5f5f;
            margin: 0;
            padding: 0;
            border-collapse: collapse;
            width: 100%;

        }
        body.disabled {
            overflow: hidden;
        }

        .main-body {
            max-width: 1220px;
            min-width: 955px;
            /*     overflow: hidden; */
            margin: 0 auto;
            position: relative;
            height: 1024px;
        }
        .page-small .main-body {
            max-width: 768px;
            min-width: 320px;
        }

        #wrapper {
            margin: 0 0 0 220px;
            padding: 0;
            transition: all 0.4s ease 0s;
            position: relative;
            /*     min-height: 100% */
            min-height: 705px;
            min-width: 1000px;
        }

        #menu-main {
            width: 220px;
            hegight: 100%;
            left: 0;
            bottom: 0;
            float: left;
            position: absolute;
            /*     min-height: 1000px; */
            top: 0;
            transition: all 0.4s ease 0s;
            background-color: #ffffff;
            border-left: 1px solid #e1e2e3;
            border-right: 1px solid #e1e2e3;
            border-bottom: 1px solid #e1e2e3;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script
            src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>


</head>

<body onload="getValue()">



<input type="hidden" name="_token" value="{{csrf_token()}}">



<nav>
    @include('Navigation.main_nav')
</nav>
<div class="main-body">
    {{--사이드바 불러오기--}}
    <aside id="menu-main" class="">
        @include('Mygroup.mygroup_sidebar')
    </aside>

    {{--첫 화면 레이스 목록--}}
    <div id="wrapper" style="min-height: 1024px;">

        {{--나의 그룹 불러오기--}}
        <div id="myrace">
            @include('Mygroup.mygroup')
            @include('Mygroup.mygroup_modal')
        </div>
     
 

    </div>
</div>

</body>
<script>
    function setting(settingNumber){
        $('#studentnumbers').val(student[settingNumber].name);
        $('#studentnames').val(student[settingNumber].id);
//

    }




    function add_student(st_made_number){
        var student_number = $("#st"+st_made_number).text();

        var student_number_zip = new Array();

        //배열을 push 할 경우는 [["13","14","15"],"19","18"] 이런식으로 2차원으로 들어가 처리가 더필요함
        student_number_zip.push(student_number);


        student_number_zip = JSON.stringify(student_number_zip);

        $.ajax({
            type: 'POST',
            url: "{{url('/groupController/pushInvitation')}}",
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: "groupId="+pub_groupId+"&students="+student_number_zip,
            success: function (data) {
                alert("성공");
            },
            error: function (data) {
                alert("에러");
            }
        });
    }

    $(document).ready(function () {

        var params = {
            groupId: 1
        };

        $.ajax({
            type: 'POST',
            url: "{{url('/groupController/groupsGet')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            //data: {_token: CSRF_TOKEN, 'post':params},
            data: params,
            success: function (data) {
                GroupData = data;
//                alert(JSON.stringify(GroupData['groups']));


                Myclass = GroupData['groups'];

                var class_list = '';

                for (var i = 0; i < Myclass.length; i++) {

                    buttonGroupID = Myclass[i].groupId;
//                        class_list +=Myclass[i].groupName
                    class_list
                        += '<tr><td>'
                        + '<button class="btn btn-link" id="' + buttonGroupID + '" onclick="getAnothergroup(this.id)">' + Myclass[i].groupName + '</button>'
                        + '</td><tr>'


                }

                $('#Myclass').html(class_list);
            },
            error: function (data) {
                alert("클래스찾기 에러");
            }
        });


        // 검색하기
        $.ajax({
            type: 'POST',
            url: "{{url('/groupController/selectUser')}}",
            //processData: false,
            //contentType: false,
            dataType: 'json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: "search=&groupId=1",
            success: function (data) {
                GroupData = data;

                search_studentJSON = GroupData['users'];

                var student_list = '';

                for( var i = 0 ; i < search_studentJSON.length; i++){

                    student_list +='<tr><td>'
                        +search_studentJSON[i].name
                        +'</td><td>'
                        +search_studentJSON[i].id
                        +'</td><td><button onclick="add_student()">+</button></td></tr>'
                }

                $('#myTable').html(student_list);

            },
            error: function (data) {
                alert("검색에러");
            }
        });





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

    function myFunction() {
        var input,
            filter,
            table,
            tr,
            td,
            i;
        input = document.getElementById("myInput");
        filter = input
            .value
            .toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }

    }

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
//                     alert(JSON.stringify(GroupData['students']));

                teacher = GroupData['teacher']['name'];
                group = GroupData['group']['name'];
                groupIds = GroupData['group']['id'];
                student = GroupData['students'];

                $('#teacher').html(teacher);
                $('#group').html(group);
                $('#groupIds').val(groupIds);
                var student_list = '';

                for( var i = 0 ; i < student.length; i++){

                    student_list +='<tr><td>'

                        +student[i].name
                        +'</td><td>'
                        +student[i].id
                        +'</td><td>'+
                        ' <button type="button"  data-toggle="modal" ' +
                        '   data-target="#studnetchange" onclick="setting('+i+');">\n' +
                        ' 학생 정보 수정\n' +
                        ' </button>' +
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




        function getAnothergroup(groupId) {

            $.ajax({
                type: 'POST',
                url: "{{url('/groupController/groupDataGet')}}",
                //processData: false,
                //contentType: false,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                //data: {_token: CSRF_TOKEN, 'post':params},
                data: "groupId=" + groupId,
                success: function (data) {
                    GroupData = data;
//                        alert(JSON.stringify(GroupData['students']));

                    teacher = GroupData['teacher']['name'];
                    group = GroupData['group']['name'];
                    student = GroupData['students'];

                    $('#teacher').html(teacher);
                    $('#group').html(group);

                    var student_list = '';

                    for (var i = 0; i < student.length; i++) {

                        student_list += '<tr><td>'

                            + student[i].name
                            + '</td><td>'
                            + student[i].id
                            + '</td><td>' +
                            '<button data-toggle="modal" data-target="#">학생 정보 수정</button>' +
                            '</td><td>' +
                            '<button>삭제하기</button>' +
                            '</td></tr>'
                    }

                    $('#student').html(student_list);


                },
                error: function (data) {
                    alert("에러");
                }
            });
        }

        function enterTabTable(obj,obj2) {
            var i, k, ftag, str="";
            var text = document.getElementById(obj).value;
            var arr = text.split("\n"); // 엔터키로 분리
            if(text.length > 2) {
                str += "<table border='1' cellpadding='3' cellspacing='1'>\n";
                str += "<tbody>\n";
                for(i=0; i < arr.length; i++) {
                    ftag = (document.getElementById("firstChk").checked == true) ? (i == 0) ? "No" : i : (i+1);
                    str += "<tr>\n";
                    str += "<td>"+ftag+"</td>\n";
                    var sub_arr = arr[i].split("\t"); // 탭키로 분리
                    for(k=0; k < sub_arr.length; k++) {
                        str += "<td>"+sub_arr[k]+"</td>\n";
                    }
                }
                str += "</tbody>\n";
                str += "</table>\n";
            }
            document.getElementById(obj2).innerHTML = str;
        }






    }


</script>
</html>