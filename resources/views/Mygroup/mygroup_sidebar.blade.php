<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #make {
            width: 250px;
            height: 70px;
            background-image: url(https://i.imgur.com/8QcmVFs.png);
            background-repeat: no-repeat;
            background-size: width 250px;
            margin-top: -10px;

        }
        .w3-light-grey {
            background-image: url("https://i.imgur.com/HSrLDSe.png");
            background-size: 100%;
        }
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
        .tablede {
            background-image: url("https://i.imgur.com/fFksbHc.png");
            border:1px solid transparent !important;
            padding: 8px;
            width: 100%;
            font-family: arial, sans-serif;
            border-collapse: collapse; !important;
            background-size: cover;
            border-spacing: 0px 0px !important;
        }






    </style>
    <script>


    </script>
</head>

<div id="navigation" style="min-height: 600px;">

    <!--네비바 위부분 공백-->
    <div
            class="page-small"
            style="text-align: center; margin-top: 10px; margin-bottom:10px;"></div>


    <div class>
        <!-- <form> -->
        <!-- <input type="text" name="search" placeholder="학생 찿기" class="input"></form>
        -->



        <button
                id ="make"
                type="button"
                data-toggle="modal"
                data-target="#create"
                class="classmake">클래스 생성
        </button>

        <div>
           <div style="width: 300px ; height: 100px">
               <p></p>
               <p></p>
               <p></p>
               <h2><i>  </i> My Class</h2>
               <p></p>
               <p></p>
               <p></p>
           </div>


            <table class="tablede" id="Myclass">
            </table>


        </div>




    </div>
</div>

