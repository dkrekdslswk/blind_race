<!DOCTYPE html>
<html>
    <title>My group</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script
        defer="defer"
        src="https://use.fontawesome.com/releases/v5.0.10/js/all.js"
        integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+"
        crossorigin="anonymous"></script>
    <body>

        <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">create class</button>
                                </div>
                            </div>
            <table id="tblData">
                <tr>
                    <th>
                        <input type="checkbox" id="chkParent"/>
                    </th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>zzzz</th>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"/>
                    </td>
                    <td>Maria asd</td>
                    <td>30</td>
                    <td>Germany</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"/>
                    </td>
                    <td>Francisco Chang</td>
                    <td>24</td>
                    <td>Mexico</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"/>
                    </td>
                    <td>Roland Mendel</td>
                    <td>100</td>
                    <td>Austria</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"/>
                    </td>
                    <td>Helen Bennett</td>
                    <td>28</td>
                    <td>UK</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"/>
                    </td>
                    <td>Yoshi Tannamuri</td>
                    <td>35</td>
                    <td>Canada</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"/>
                    </td>
                    <td>Giovanni Rovelli</td>
                    <td>46</td>
                    <td>Italy</td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox"/>
                    </td>
                    <td>Alex Smith</td>
                    <td>59</td>
                    <td>asd</td>
                </tr>
            </table>
        </body>

    </div>

    <style>
   
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #ccd;
        }

        tr:nth-child(even) {
            background-color: #ecf6fc;
        }

        tr:nth-child(odd) {
            background-color: #ddeedd;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('#chkParent').click(function () {
                var isChecked = $(this).prop("checked");
                $('#tblData tr:has(td)')
                    .find('input[type="checkbox"]')
                    .prop('checked', isChecked);
            });

            $('#tblData tr:has(td)')
                .find('input[type="checkbox"]')
                .click(function () {
                    var isChecked = $(this).prop("checked");
                    var isHeaderChecked = $("#chkParent").prop("checked");
                    if (isChecked == false && isHeaderChecked) 
                        $("#chkParent").prop('checked', isChecked);
                    else {
                        $('#tblData tr:has(td)')
                            .find('input[type="checkbox"]')
                            .each(function () {
                                if ($(this).prop("checked") == false) 
                                    isChecked = false;
                                }
                            );
                        console.log(isChecked);
                        $("#chkParent").prop('checked', isChecked);
                    }
                });
        });
    </script>
</body>
</html>