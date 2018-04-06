<?php
/**
 * Created by PhpStorm.
 * User: kimseungmok
 * Date: 2018-04-05
 * Time: 오후 8:16
 */

?>


<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>

<form action="{{url('RaceController')}}"  method="Post" enctype="multipart/form-data">
    {{csrf_field()}}
    <h3 class="form-section">Person Info</h3>
    <input type="text" name="post" id="post" class="form-control first_name"  placeholder="First Name">
    <button type="submit">전송</button>
</form>