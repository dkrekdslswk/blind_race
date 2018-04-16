<html !DOCTYPE>
<head>
    <title>Bootstrap 3 Collapsible Sidebar</title>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">

    <style>
        @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";

        body {
            font-family: 'Poppins', sans-serif;
            background: #fafafa;
        }

        .wrapper p {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1em;
            font-weight: 300;
            line-height: 1.7em;
            color: #999;
        }

        .wrapper button {
            /*background-color: #657BB8;*/
            width: 220px;
            border: 1px solid #8691B7;
        }

        .wrapper a,.wrapper a:hover,.wrapper a:focus {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s;
        }

        .wrapper navbar {
            padding: 15px 10px;
            background: #fff;
            border: none;
            border-radius: 0;
            margin-bottom: 40px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .wrapper navbar-btn {
            box-shadow: none;
            outline: none !important;
            border: none;
        }

        .wrapper line {
            width: 100%;
            height: 1px;
            border-bottom: 1px dashed #ddd;
            margin: 40px 0;
        }

        /* ---------------------------------------------------
            SIDEBAR STYLE
        ----------------------------------------------------- */
        #sidebar {
            width: 250px;
            position: fixed;
            top: 63px;
            left: 0;
            height: 100vh;
            z-index: 999;
            background: #F0F1F0;
            color: #fff;
            transition: all 0.3s;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #697FC2;
            border-bottom: 1px solid #47748b;
        }

        #sidebar ul.components {
            padding: 0;
            color: #fff;
        }

        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }

        #sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
            background: #fff;
            color: #5860A2;
        }
        #sidebar ul li a:hover {
            color: #F0F1F0;
            background: #7391C8;
            border-bottom: 1px solid white;
        }

        #sidebar ul li.active > a, a[aria-expanded="true"] {
            color: #000;
            background: #697FC2;
            border-bottom: 1px solid white;
        }


        a[data-toggle="collapse"] {
            position: relative;
        }

        a[aria-expanded="false"]::before, a[aria-expanded="true"]::before {
            content: '\e259';
            display: block;
            position: absolute;
            right: 20px;
            font-family: 'Glyphicons Halflings';
            font-size: 0.6em;
        }
        .wrapper a[aria-expanded="true"]::before {
            content: '\e260';
        }


        .wrapper ul ul a {
            font-size: 0.9em !important;
            padding-left: 30px !important;
            background: #6d7fcc;
        }

        .wrapper ul.CTAs {
            padding: 20px;
        }

        .wrapper ul.CTAs a {
            text-align: center;
            font-size: 0.9em !important;
            display: block;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .wrapper a.download {
            background: #fff;
            color: #7386D5;
        }
        .wrapper a.article,.wrapper a.article:hover {
            background: #6d7fcc !important;
            color: #fff !important;
        }

        /* ---------------------------------------------------
            MEDIAQUERIES
        ----------------------------------------------------- */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #content {
                width: 100%;
            }
            #content.active {
                width: calc(100% - 250px);
            }
            #sidebarCollapse span {
                display: none;
            }
        }


    </style>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <!-- Bootstrap Js CDN -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom Scroller Js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

    <Script>
        function side_menu_clicked(data){
            switch(data){
                case "recordbox":
                    document.getElementById('record_box_title').innerText = "학습기록 조회";
                    break;
                case 2:
                    document.getElementById('record_box_title').innerText = "피드백과 질문";
                    break;
            }
        }
    </Script>
</head>
<body>

<div class="wrapper">

    <nav id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header" id="sidebar_header">

                <a  href="/recordbox">
                    <h3 id="record_box_title">피드백과 질문</h3>
                </a>
        </div>

        <!-- Sidebar Links -->
        <ul class="list-unstyled components">
{{--            <li id="selectList"><!-- Link with dropdown items -->
                <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" style="text-align: center;">그룹 선택</a>
                <ul class="collapse list-unstyled" id="homeSubmenu"style="text-align: center;">
                    <li><a href="#">특강 A반</a></li>
                    <li><a href="#">특강 B반</a></li>
                    <li><a href="#">특강 C반</a></li>
                </ul>
            </li>--}}
            <div style="text-align: center;margin-top: 10px;">

                <a id="record" href="/recordbox">
                <button class="btn btn-default" style="margin-bottom: 5px">
                    학습 기록 조회
                </button>
                </a>


                <a id="feedback" href="/feedback">
                <button class="btn btn-default">

                    피드백과 질문

                </button>
                </a>

            </div>
        </ul>
    </nav>
</div>


</body>
</html>
