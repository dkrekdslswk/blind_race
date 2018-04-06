<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chatroom</title>
</head>
<body>
    <form action="{{url('raceController/create')}}"  method="Post" enctype="multipart/form-data">
        {{csrf_field()}}
        <h3 class="form-section">Person Info</h3>
        <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
        <button type="submit">傈价</button>
    </form>
    <form action="{{url('raceController/teacherIn')}}"  method="Post" enctype="multipart/form-data">
        {{csrf_field()}}
        <h3 class="form-section">Person Info</h3>
        <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
        <button type="submit">傈价</button>
    </form>
    <form action="{{url('raceController/studentIn')}}"  method="Post" enctype="multipart/form-data">
        {{csrf_field()}}
        <h3 class="form-section">Person Info</h3>
        <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
        <button type="submit">傈价</button>
    </form>
    <form action="{{url('raceController/quizNext')}}"  method="Post" enctype="multipart/form-data">
        {{csrf_field()}}
        <h3 class="form-section">Person Info</h3>
        <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
        <button type="submit">傈价</button>
    </form>
      
</body>
</html>