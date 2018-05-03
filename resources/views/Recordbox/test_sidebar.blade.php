<head>

    <style>
        .page-small .set-small, .page-small .learn-small, .page-small .main-small {
            display: none !important;
        }
        .page-small .board-small-show {
            width: 100% !important;
        }

        .set-small-show, .set-small-show-table, .learn-small-show, .set-small-show-init {
            display: none !important;
        }
        .page-small .set-small-show, .page-small .learn-small-show {
            display: block !important;
        }
        .page-small .set-small-show-init { display: initial !important; }
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

    <script src="text/javascript">

    </script>

</head>

<div id="navigation" style="min-height: 600px;">

    <!--네비바 위부분 공백-->
    <div class="page-small" style="text-align: center; margin-top: 10px; margin-bottom:10px;">
    </div>

    <div class="m-t-lg">
        <ul class="main-left-menu" id="side-menu2">

            {{--그룹 파트--}}
            <li class="" id="side-menu3_li" style=" margin-top: 20px;">
                <a href="#">
                    나의 그룹
                </a>
            </li>
            <li class="class-toggle">
                <div class="nav-second-level class_list">
                    <a class="" href="#" onclick="$('#myrace').attr('class','hidden');$('#mygroup').attr('class','');$('.active').attr('class','');$('#mygroup_panel_name').text('특강 A반');$('#side-menu3_li').attr('class','active');">
                        <div style="display:inline-block; width: 160px;">특강 A반</div>
                    </a>
                    <a class="" href="#" onclick="$('#myrace').attr('class','hidden');$('#mygroup').attr('class','');$('.active').attr('class','');$('#mygroup_panel_name').text('특강 B반');$('#side-menu3_li').attr('class','active');">
                        <div style="display:inline-block; width: 160px;">특강 B반</div>
                    </a>
                    <a class="" href="#" onclick="$('#myrace').attr('class','hidden');$('#mygroup').attr('class','');$('.active').attr('class','');$('#mygroup_panel_name').text('특강 C반');$('#side-menu3_li').attr('class','active');">
                        <div style="display:inline-block; width: 160px;">특강 C반</div>
                    </a>
                </div>

                <div class="nav-second-level class-config" style="padding-left: 15px;">
                    <div style="display: inline-block; width: 12%; text-align: center;">
                        <a class="btn-new-class" style="display: block; padding: 10px 0px;" onclick="">
                            <i class="fa fa-plus" style="font-size: 16px; position: relative; top: 1px;"></i>
                        </a>
                    </div>

                </div>
            </li>
        </ul>
    </div>

    <div class="sidebar_footer">
        <div class="news">
            <div class="news_image">
                <img src="/img/news_img.png" style="width: 100%;height: 100px;padding: 2px 2px 2px 2px;">
            </div>
            <div class="news_contents">
                NEWS! 쥿뿐쥬분에 새로운 기능이 생겼어요!<br><br>

                문제나무에는 암기할 내용에 따라 단어,문장,용어세트 그리고 빈칸세트가 있죠.
                빈칸세트는 다른 세트와 달리 암기학습 보다는 빈칸형태의 문제풀이 활동에 적합합니다.
                그런데 빈칸을 입력하고 거기에 객관식 선택지를 입력하는 방식이 아무래도 익숙한 방식은 아니었던거 같습니다.
                그래서 사용법 문의가 많았습니다.
                그래서문제풀이에 적합한 세트로 특화시키고...
            </div>
        </div>
    </div>
</div>
