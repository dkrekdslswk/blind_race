<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatroom</title>
</head>
<body>
<form action="{{url('quizTreeController/getfolderLists')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Person Info</h3>
    <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
    <button type="submit">getfolderLists</button>
</form>
<form action="{{url('quizTreeController/createFolder')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Person Info</h3>
    <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
    <button type="submit">createFolder</button>
</form>
<form action="{{url('quizTreeController/createList')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Person Info</h3>
    <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
    <button type="submit">createList</button>
</form>
<form action="{{url('quizTreeController/getQuiz')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Person Info</h3>
    <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
    <button type="submit">getQuiz</button>
</form>
<form action="{{url('quizTreeController/insertList')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Person Info</h3>
    <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
    <button type="submit">insertList</button>
</form>

<form action="{{url('raceController/createRace')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Person Info</h3>
    <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
    <button type="submit">createRace</button>
</form>
<form action="{{url('raceController/teacherIn')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Person Info</h3>
    <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
    <button type="submit">teacherIn</button>
</form>
</body>
</html>