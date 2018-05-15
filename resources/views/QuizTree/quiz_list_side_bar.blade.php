<head>

    <style>
        .page-small {
            display: none !important;
        }
        .page-small {
            width: 100% !important;
        }

        .m-t-lg {
            margin-top: 30px !important;
        }
        .main-left-menu { list-style-type: none; margin: 0px; padding: 0px; }
        .main-left-menu > li > a.noaction { cursor: default; font-size: 12px; font-weight: normal; padding-bottom: 3px; padding-top: 30px; color: #a2a2a1; }
        .main-left-menu > li > a.noaction:hover { background: transparent; color: #a2a2a1; cursor: default; }
        .main-left-menu > li > a { position: relative; display: block; padding: 8px 15px; color: #5f5f5f; font-weight: normal; border-left: 3px solid transparent; font-size: 14px; }
        .main-left-menu > li > a > .icon:before { content: "▼"; }
        .main-left-menu > li > a:hover { /* background: rgba(0, 0, 0, 0.06); */ color: #7DA0B1; }
        .main-left-menu > li.active > a { background: #d9edf7; margin: 0px 10px; padding: 4px 0px 4px 5px; }
        .main-left-menu > li.active.class-toggle > a { background: transparent; color: #5f5f5f; pointer-events: auto; cursor: pointer; }
        .main-left-menu > li.active.class-toggle > a:hover { color: #8ebd4d; }
        .main-left-menu > li.active > a > .icon:before { content: "▲"; }
        .main-left-menu > li.active .toggle-class > a, .main-left-menu > li:hover .toggle-class > a { color: #8ebd4d; }

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
            padding: 50px 16px 10px 16px;
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

        #side-menu li .nav-second-level li a, #side-menu2 li .nav-second-level li a, #side-menu2 li .nav-second-level a {
            padding: 8px 10px 8px 20px;
            color: #5f5f5f;
            text-transform: none;
            font-weight: normal;
            position: relative;
            display: block;
            font-size: 14px;
        }
        .class_list a:hover{
            background-color:#d9edf7;
        }

        @media (max-width: 768px) {
            .page-small .content, .page-small #wrapper-class .content, .page-small .content-main {
                padding: 15px 5px;
                min-width: 320px
            }
        }
    </style>

</head>

<div id="navigation" style="min-height: 900px;height:100%">

    <!--네비바 위부분 공백-->
    <div class="page-small" style="text-align: center; margin-top: 10px; margin-bottom:10px;">
    </div>

    <div class="m-t-lg">
        <ul class="main-left-menu" id="side-menu2">

            {{--그룹 파트--}}
            <li class="" id="side-menu3_li" style=" margin-top: 20px;margin-left: 10px;">
                나의 클래스
            </li>

            <li class="class-toggle">
                {{--클래스 이름 리스트 들어갈 자리--}}
                <div class="nav-second-level class_list" id="group_names">

                </div>
            </li>
        </ul>
    </div>

</div>