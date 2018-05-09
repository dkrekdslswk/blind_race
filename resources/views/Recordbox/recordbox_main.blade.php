<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        body {
            font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            background-color: #f7f8fa;
            font-size: 13px;
            color: #5f5f5f;
            margin: 0;
            padding: 0;
        }
        body.disabled { overflow: hidden; }

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
            hegight:100%;
            left: 0;
            bottom: 0;
            float: left;
            position: relative;
            /*     min-height: 1000px; */
            top: 0px;
            transition: all 0.4s ease 0s;
            background-color: #ffffff;
            border-left: 1px solid #e1e2e3;
            border-right: 1px solid #e1e2e3;
            border-bottom: 1px solid #e1e2e3;
        }

        #group_chart {
            margin-left: 20px;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>

    <script type="text/javascript">

        window.onload = function() {
            getValue();
            makingChart(id,DateType);
            makingDropdown();
        };

        function recordControl(id){
            switch (id){
                case "nav_group_name" :
                    $('#group_chart').attr('class','');
                    $('#record_history').attr('class','hidden');
                    $('#record_students').attr('class','hidden');
                    $('#record_feedback').attr('class','hidden');
                    break;
                case "history" :
                    $('#record_history').attr('class','');
                    $('#group_chart').attr('class','hidden');
                    $('#record_students').attr('class','hidden');
                    $('#record_feedback').attr('class','hidden');
                    break;
                case "students" :
                    $('#record_students').attr('class','');
                    $('#group_chart').attr('class','hidden');
                    $('#record_history').attr('class','hidden');
                    $('#record_feedback').attr('class','hidden');
                    break;
                case "feedback" :
                    $('#record_feedback').attr('class','');
                    $('#group_chart').attr('class','hidden');
                    $('#record_students').attr('class','hidden');
                    $('#record_history').attr('class','hidden');
                    break;
            }
        }

        $(document).on('click','#groupA',function () {
            $('#nav_group_name').text("특강 A반");
            $('#wrapper').show();
            $('#group_chart').attr('class','');
            $('#record_history').attr('class','hidden');
        });

        $(document).on('click','#groupB',function () {
            $('#nav_group_name').text("특강 B반");
            $('#wrapper').hide();
        });


        function getValue() {

            var groupId = 1;
            var groupData = "";

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
                    groupData = data;

                    alert("Asdasd");

                    console.log(groupData['teacher']['name']);
                    console.log(groupData['group']['name']);
                    console.log(groupData['students']);

                    /*$('#teacher').html(teacher);
                    $('#group').html(group);

                    var student_list = '';

                    for (var i = 0; i < student.length; i++) {

                        student_list += '<tr><td>'

                            + student[i].name
                            + '</td><td>'
                            + student[i].id
                            + '</td><td>' +
                            '<button>학생 정보 수정</button>' +
                            '</td><td>' +
                            '<button>삭제하기</button>' +
                            '</td></tr>'
                    }

                    $('#student').html(student_list);
*/
                },
                error: function(request, status, error) {
                    alert("code: "+request.status+"\n"+"message: "+request.responseText+"\n"+"error: "+error);
                }
            });
        }


    </script>



</head>
<body>

{{--메인 네비바 불러오기--}}
<div id="main-navbar" >
    @include('Navigation.main_nav')
</div>

{{--사이드바 불러오기--}}
<aside id="menu-main" class="">
    @include('Recordbox.record_sidebar')
</aside>


{{--첫 화면 레이스 목록--}}
<div id="wrapper" class="" style="min-height: 1024px;">

    {{--메인 네비바 불러오기--}}
    <div id="main-recordnav" style="margin-bottom: 20px;">
        @include('Recordbox.test_recordnav')
    </div>

    <div id="group_chart">
        @include('Recordbox.record_chart')
    </div>

    <div class="hidden" id="record_history">
        @include('Recordbox.record_history')
    </div>

    <div class="hidden" id="record_students">
        @include('Recordbox.record_students_list')
    </div>

    <div class="hidden" id="record_feedback">
        @include('Recordbox.feedback')
    </div>

</div>

</body>
</html>