<div class="col-xs-6" style="padding: 6px 15px;">
    학생 5명
</div>
<br>


<div class="list_box" style="margin-left: 10px;margin-right: 10px;height: 0;width: 100%;">
    <div class="list_container" style="max-width: 1180px; margin: 0px auto;">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>
                    번호
                </th>
                <th>
                    이름
                </th>
            </tr>
        </thead>
        <tbody id="lists">

        </tbody>

        <script>
            var names = [ "김똘똘", "최천재", "안예민", "심사쵸" , "사라다"];

            for (var i = 0 ; i < names.length ; i++){
                $('#lists').append($('<tr id="student'+i+'">'));
            }

            for (var i = 0 ; i < names.length ; i++){
                $('#student'+i).append($('<td style="width: 50px">').text(i+1));
                $('#student'+i).append($('<td>').text(names[i]));
            }

        </script>
    </table>
</div>
</div>

