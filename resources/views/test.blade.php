<form action="{{url('raceController')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Person Info</h3>
    <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
    <button type="submit">전송</button>
</form>