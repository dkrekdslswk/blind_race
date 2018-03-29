<html>
<head></head>
<body>
<div class="container">
    <h1>POST 전송</h1>
    {{--<form method="post" action="/raceControll">
        <div class="form-group">
            <label for="name">이름</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="이름" />
        </div>
        <div class="form-group">
            <label for="email">이메일</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="이메일" />
        </div>
        <button type="submit" class="btn btn-success">전송</button>
        <button type="reset" class="btn btn-danger">리셋</button>
    </form>--}}


    <form method="post" action="raceController">
        ID : <input type="text" id="id" name="id"><br>
        PW : <input type="text" id="passowrd" name="password"><br>
        NAME : <input type="text" id="name" name="name"><br>
        <button type="submit">보내기</button>
    </form>

</div>
</body>
</html>