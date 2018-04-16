<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Dashboard with Off-canvas Sidebar</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
    <link href="js/bootstrap.min.js" rel="stylesheet">

    <style type="text/css">

        .feedback_page {
            margin-left: 300px;
        }

        .container {
            margin-top: 20px;
        }

    </style>


    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">


    </script>

</head>
<body>

    <nav>
        @include('Navigation.main_nav')
    </nav>

    <aside style="display:inline-block; vertical-align:top;">
        @include('Recordbox.sidebar')
    </aside>

    <div class="feedback_page">
        <div style="position : relative; display: block;">
            <button type="button" class="btn btn-primary" style="display: inline;" >그룹 선택</button>
            <select id="bookSelect" >
                <blank></blank>
                <option value="1">특강 A반</option>
                <option value="2">특강 B반</option>
                <option value="3">특강 C반</option>
            </select>
        </div>

        <div class="container" style="display: block;position: relative;">
            <table class="table">
                <thead>
                    <tr>
                        <th>날짜</th>
                        <th>제목</th>
                        <th>답변</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>01/08</td>
                        <td>
                            <a href="/recordbox/feedback/question_id">
                            궁금하다
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">답변완료</button>
                        </td>
                    </tr>
                    <tr>
                        <td>01/08</td>
                        <td>질문이다</td>
                        <td>
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">답변완료</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>

