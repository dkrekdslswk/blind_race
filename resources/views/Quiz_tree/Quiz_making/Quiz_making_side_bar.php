<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: "Lato", sans-serif;
        }

        /* Fixed sidenav, full height */
        .sidenav {
            height: 100%;
            width: 25%;
            position: fixed;
            z-index: 1;
            left: 0;
            background-color: white;
            border-right : 2px solid midnightblue;
        }

        /* Style the sidenav links and the dropdown button */

        .sidenav a{
            text-decoration: none;
            cursor: pointer;
            color: #818181;
        }

        .selection {
            margin: 20px 5px 5px 10px;
            width: 100%;
            text-align: center;
        }

        .select {
            width: 90%;
            margin: 5%;
        }

        .sidenav drop-contents {
            padding: 6px 8px 6px 8px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
            display: inline;
            border: block;
            background: none;
            width: 100%;
            cursor: pointer;
            outline: none;
            text-align: left;
        }


        .dropdown {
            margin-top: 20px;
            width: 100%;
        }

        .dropdown-btn {
            text-align: left;
            padding: 10px 19px 10px 19px;
            margin: 10px;
            text-decoration: none;
            font-size: 15px;
            color: #818181;
            display: block;
            border: none;
            background: #b9bbbe;
            width: 90%;
            cursor: pointer;
            outline: none;
        }

        .dropdown2-btn {
            padding: 6px 0px 6px 0px;
            margin-top: 20px;
            text-decoration: none;
            font-size: 20px;
            color: #818181;
            display: inline;
            border: none;
            background: none;
            width: 45%;
            cursor: pointer;
            outline: none;
        }

        /* On mouse-over */
        .sidenav a:hover, .dropdown-btn:hover {
            color: black;
        }

        /* Main content */
        .main {
            margin-left: 200px; /* Same as the width of the sidenav */
            font-size: 20px; /* Increased text to enable scrolling */
            padding: 0px 10px;
        }

        /* Add an active class to the active dropdown button */
        .active {
            background-color: grey;
            color: white;
        }

        /* Dropdown container (hidden by default). Optional: add a lighter background color and some left padding to change the design of the dropdown content */
        .dropdown-container {
            display: none;
            background-color: #262626;
            padding: 10px 19px 10px 19px;
            margin: 5%;
        }

        .dropdown-container a {
            display: block;
        }

        /* Optional: Style the caret down icon */
        .fa-caret-down {
            float: right;
            padding-right: 8px;
        }

        .sample_quiz {
            margin-top: 20px;
            margin-left: 10px;
            text-align: center;
            border: 1px solid black;
            overflow-y: scroll;
            width: 95%;
            height: 50%;
            background-color: #f8f8f8;
        }

        .table {
            background-color: #F2F2F2;
        }

        .table thead, .table thead tr th{
            font-size : 10px;
            padding: 1px 1px 1px 1px;
        1}

        .main {
            margin-left: 40%;
        }

        /* Some media queries for responsiveness */
        @media screen and (max-height: 450px) {
            .sidenav {padding-top: 15px;}
            .sidenav a {font-size: 18px;}
        }
    </style>
</head>
<body>

<div class="sidenav">
    <div class="selection">
        <button type="button" class="btn btn-default">직접 만들기</button>
        <button type="button" class="btn btn-default">문제 가져오기</button>
    </div>

    <form class="select">
        <select class="form-control" data-live-search="true">
            <option data-tokens="ketchup mustard">교제 선택</option>
            <option data-tokens="mustard">특강 B반</option>
            <option data-tokens="frosting">특강 C반</option>
        </select>
    </form>

    <form class="select">
        <select class="form-control" data-live-search="true">
            <option data-tokens="ketchup mustard">난이도 선택</option>
            <option data-tokens="mustard">N1</option>
            <option data-tokens="mustard">N2</option>
            <option data-tokens="mustard">N3</option>
        </select>
    </form>

    <form class="select">
        <select class="form-control" data-live-search="true">
            <option data-tokens="ketchup mustard">교제 선택</option>
            <option data-tokens="mustard">특강 B반</option>
            <option data-tokens="frosting">특강 C반</option>
        </select>
    </form>

    <form class="select">
        <select class="form-control" data-live-search="true">
            <option data-tokens="ketchup mustard">문제 유형</option>
            <option data-tokens="mustard">사지선다</option>
            <option data-tokens="frosting">작성</option>
            <option data-tokens="frosting">순서 맞추기</option>
        </select>
    </form>

    <form class="select">
        <select class="form-control" data-live-search="true">
            <option data-tokens="ketchup mustard">종류</option>
            <option data-tokens="mustard">문법</option>
            <option data-tokens="frosting">단어</option>
        </select>
    </form>

    <div class="sample_quiz">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>번호</th>
                <th>예문</th>
                <th>난이도</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td><a href="#">1</a></td>
                <td><a href="#">生活習慣病は40代を（　　）増え始める</a></td>
                <td>50%</td>
            </tr>

            <tr>
                <td><a href="#">2</a></td>
                <td><a href="#">食中毒を起こしたら店にはさすがに誰も（　）しない.</a></td>
                <td>70%</td>
            </tr>

            </tbody>
        </table>

    </div>

</div>


<script>
    /* Loop through all dropdown buttons to toggle between hiding and showing its dropdown content - This allows the user to have multiple dropdowns without any conflict */
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var dropdown2 = document.getElementsByClassName("dropdown2-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }

    for (i = 0; i < dropdown2.length; i++) {
        dropdown2[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === "block") {
                dropdownContent.style.display = "none";
            } else {
                dropdownContent.style.display = "block";
            }
        });
    }

</script>

</body>
</html>

<?
#퀴즈리스트 사이드 바
#김승목
?>