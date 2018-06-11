<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<nav class="navbar navbar-default">
    <div class="container-fluid">

        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a  href="#"><img src="{{ asset('https://i.imgur.com/dmXfbDm.png') }}" style="width:125px; height:50px; "/></a>
        </div>


        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a></a>
                </li>
                <li>
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="{{ url('mygroup') }}">My Class</a>
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
            </ul>
            <form id="signin" class="navbar-form navbar-right" role="form">
                <div class="input-group">
                    <span ></span>
                    <input id="email"  name="email" value="" placeholder="ID">
                </div>

                <div class="input-group">
                    <span ></span>
                    <input id="password" type="password"  name="password" value="" placeholder="Password">
                </div>

                <button type="submit" class="btn-primary-outline btn-round-lg"> 로그인 </button>
            </form>

        </div>
    </div>
</nav>
<style>
    .btn-primary-outline {
        background-color: transparent;
        border-color: #ccc;
    }
    .btn-round-lg {
        border-radius: 20.5px;
    }
</style>