<html>
<head>
    <script
            src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
</head>

<style>
    .navbar-brand {
        position: relative;
        z-index: 2;
    }
    .navbar-nav.navbar-right .btn {
        position: relative;
        z-index: 2;
        padding: 4px 20px;
        margin: 10px auto;
    }
    .navbar .navbar-collapse {
        position: relative;
    }
    .navbar .navbar-collapse .navbar-right > li:last-child {
        padding-left: 22px;
    }
    .navbar .nav-collapse {
        position: absolute;
        z-index: 1;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        padding-right: 120px;
        padding-left: 80px;
        width: 100%;
    }
    .navbar.navbar-default .nav-collapse {
        background-color: black;
        margin: 0;
    }
    .navbar.navbar-inverse .nav-collapse {
        background-color: #222;
    }
    .navbar .nav-collapse .navbar-form {
        border-width: 0;
        box-shadow: none;
    }
    .nav-collapse > li {
        float: right;
    }
    .btn.btn-circle {
        border-radius: 50px;
    }
    .btn.btn-outline {
        background-color: transparent;
    }
    @media screen and (max-width: 767px) {
        .navbar .navbar-collapse .navbar-right > li:last-child {
            padding-left: 15px;
            padding-right: 15px;
        }
        .navbar .nav-collapse {
            margin: 7.5px auto;
            padding: 0;
        }
        .navbar .nav-collapse .navbar-form {
            margin: 0;
        }
        .nav-collapse > li {
            float: none;
        }

    }
    element.style {
        width: 100%;
        height: 60px;
        border-color: transparent;
    }
    .row5, .row5 a {
        color: white;
        background-image: url(https://i.imgur.com/7nT1LDd.png);
        background-size: auto;
    }
    .row5, .row5 a {
    }

</style>
<body>
<div class="" style="background-color: black">
    <nav class="navbar  row5" style="margin: 0;width: 100%;">
        <div class="">
            <div class="navbar-header">
                <button
                        type="button"
                        class="navbar-toggle collapsed"
                        data-toggle="collapse"
                        data-target="#navbar-collapse-2">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <img src="https://i.imgur.com/dmXfbDm.png" style="width:125px; height:50px; "/>
            </div>

            <div class=" collapse navbar-collapse" id="navbar-collapse-2" style="position:absolute; right:0;">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('mygroup') }}">MyGroup</a>
                    </li>
                    <li>
                        <a href="{{ url('race_list') }}">Race</a>
                    </li>
                    <li>
                        <a href="{{ url('recordbox') }}">RecordBox</a>
                    </li>
                    <li>
                        <a href="{{ url('quiz_list') }}">QuizTree</a>
                    </li>

                    <li>

                    </li>
                </ul>

            </div>
        </div>
    </nav>
</div>
</body>

</html>