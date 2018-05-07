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
</html>