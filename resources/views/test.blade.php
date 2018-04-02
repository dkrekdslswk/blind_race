<form action="{{url('raceController')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Test Info</h3>
    <input type="text" name="groupId" id="groupId" placeholder="groupId">
    <input type="text" name="raceMode" id="raceMode" placeholder="raceMode">
    <input type="text" name="examCount" id="examCount" placeholder="examCount">
    <input type="text" name="raceId" id="raceId" placeholder="raceId">
    <button type="submit">전송</button>
</form>


{{--
<form action="{{url('raceController')}}"  method="Post" enctype="multipart/form-data" class="form-horizontal" id="add_user_form">
    {{csrf_field()}}
    <div class="form-body">
        <h3 class="form-section">Person Info</h3>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-3">First Name</label>
                    <div class="col-md-9">
                        <input type="text" name="first_name" id="first_name" class="form-control first_name"  placeholder="First Name">
                        <button type="submit">전송</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>--}}
