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
     
        <!-- Sidebar -->
        <!-- <div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:20%">
            <form>
                <input type="text" name="search" placeholder="학생 찿기" class="input">
            </form>
            <button
                type="button"
                class="w3-bar-item w3-button"
                data-toggle="modal"
                data-target="#create">
                클래스 생성
            </button>

            <p></p>
            <div class="w3-dropdown-hover">
                <h2>나의 클래스</h2>
                <button class="w3-button">클래스
                    <i class="fa fa-caret-down"></i>
                </button>

                <a href="#" class="w3-bar-item w3-button">A반</a>
                <a href="#" class="w3-bar-item w3-button">B반</a>
                <a href="#" class="w3-bar-item w3-button">C반</a>
                <a href="#" class="w3-bar-item w3-button">D반</a>

            </div>

        </div> -->

        <!-- Page Content -->
    

            <div class="container">
                <div class="jumbotron">
                    <div class="fa-3x">
                        <i class="fas fa-cog fa-spin light" data-toggle="modal" data-target="#teacher"></i>
                    </div>
                    <p>김민수 선생님</p>
                    <h1>현재 클래스 이름</h1>

                    <button
                        type="button"
                        class="btn btn-primary light"
                        data-toggle="modal"
                        data-target="#exampleModal">
                        초대하기
                    </button>

                    <!-- careate Modal -->

                    <div
                        class="modal fade"
                        id="create"
                        tabindex="-1"
                        role="dialog"
                        aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                  
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                <div class="form-group">
                                <label for="exampleDropdownFormEmail1">학급 이름</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="exampleDropdownFormEmail1"
                                    placeholder="학급이름을 입력하세요">
                            </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">create class</button>
                                </div>
                            </div>

                            
                        </div>

                        
                    </div>

                    <!-- Modal -->

                </div>

            </div>

            <div class="w3-container"></div>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    김민수
                  <p class="badge badge-primary badge-pill"></p>
                    <button
                        type="button"
                        class="badge badge-primary badge-pill"
                        data-toggle="modal"
                        data-target="#studnetsetting">학생 정보 수정</button>

                    <button class ="badge badge-primary badge-pill" type="button" onclick="location.href='/recordbox' ">레코드 박스</button>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    징징이
                    <button
                        type="button"
                        class="badge badge-primary badge-pill"
                        data-toggle="modal"
                        data-target="#studnetsetting">학생 정보 수정</button>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    심우림
                    <button
                        type="button"
                        class="badge badge-primary badge-pill"
                        data-toggle="modal"
                        data-target="#studnetsetting">학생 정보 수정</button>
                </li>
            </ul>

            <!-- teacher modal -->
            <div
                class="modal fade"
                id="teacher"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleDropdownFormEmail1">교사 이름</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="exampleDropdownFormEmail1"
                                    placeholder="김민수">
                            </div>
                            <div>
                                <p>현재 클래스</p>
                                <select>
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                    <option value="opel">Opel</option>
                                    <option value="audi">Audi</option>
                                </select>
                                <p>이동할 클래스</p>
                                <select>
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                    <option value="opel">Opel</option>
                                    <option value="audi">Audi</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 초대 modal -->
            <div
                class="modal fade"
                id="exampleModal"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ... 선생님의 클래스에 등록하세요 초대코드 00000을 입력하세요
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">복사하기</button>
                        </div>
                    </div>
                </div>

            </div>
            <!-- 학생 modal -->
            <div
                class="modal fade"
                id="studnetsetting"
                tabindex="-1"
                role="dialog"
                aria-labelledby="exampleModalLongTitle"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form class="px-4 py-3">
                            <div class="form-group">
                                <label for="exampleDropdownFormEmail1">이름</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="exampleDropdownFormEmail1"
                                    placeholder="김민수">
                            </div>
                            <div class="form-group">
                                <label for="exampleDropdownFormEmail1">학번</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    id="exampleDropdownFormEmail1"
                                    placeholder="1301036">
                            </div>
                            <div class="form-group">
                                <label for="exampleDropdownFormPassword1">비밀번호</label>
                                <input
                                    type="password"
                                    class="form-control"
                                    id="exampleDropdownFormPassword1"
                                    placeholder="1301036">
                            </div>
                            <div>
                                <p>반이동 현재반</p>
                                <select>
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                    <option value="opel">Opel</option>
                                    <option value="audi">Audi</option>
                                </select>
                                <p>이동할 클래스</p>
                                <select>
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                    <option value="opel">Opel</option>
                                    <option value="audi">Audi</option>
                                </select>
                            </div>

                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>

                <style>
                    .input[type=text] {
                        width: 130px;
                        box-sizing: border-box;
                        border: 2px solid #ccc;
                        border-radius: 4px;
                        font-size: 16px;
                        background-color: white;
                        background-image: url("https://i.imgur.com/LCkVIxO.png");
                        background-position: 10px 10px;
                        background-repeat: no-repeat;
                        padding: 12px 20px 12px 40px;
                        -webkit-transition: width 0.4s ease-in-out;
                        transition: width 0.4s ease-in-out;
                    }

                    .input[type=text]:focus {
                        width: 100%;
                    }

                    /* The Modal (background) */
                    .modal {
                        display: none;
                        /* Hidden by default */
                        position: fixed;
                        /* Stay in place */
                        z-index: 1;
                        /* Sit on top */
                        padding-top: 100px;
                        /* Location of the box */
                        left: 0;
                        top: 0;
                        width: 100%;
                        /* Full width */
                        height: 100%;
                        /* Full height */
                        overflow: auto;
                        /* Enable scroll if needed */
                        background-color: rgb(0,0,0);
                        /* Fallback color */
                        background-color: rgba(0,0,0,0.4);
                        /* Black w/ opacity */
                    }

                    /* Modal Content */
                    .modal-content {
                        position: relative;
                        background-color: #fefefe;
                        margin: auto;
                        padding: 0;
                        border: 1px solid #888;
                        width: 80%;
                        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
                        -webkit-animation-name: animatetop;
                        -webkit-animation-duration: 0.4s;
                        animation-name: animatetop;
                        animation-duration: 0.4s;
                    }

                    /* Add Animation */
                    @-webkit-keyframes animatetop {
                        from {
                            top: -300px;
                            opacity: 0;
                        }
                        to {
                            top: 0;
                            opacity: 1;
                        }
                    }

                    @keyframes animatetop {
                        from {
                            top: -300px;
                            opacity: 0;
                        }
                        to {
                            top: 0;
                            opacity: 1;
                        }
                    }

                    /* The Close Button */
                    .close {
                        color: white;
                        float: right;
                        font-size: 28px;
                        font-weight: bold;
                    }

                    .close:focus,
                    .close:hover {
                        color: #000;
                        text-decoration: none;
                        cursor: pointer;
                    }

                    .modal-header {
                        padding: 2px 16px;
                        background-color: #5cb85c;
                        color: white;
                    }

                    .modal-body {
                        padding: 2px 16px;
                    }

                    .modal-footer {
                        padding: 2px 16px;
                        background-color: #5cb85c;
                        color: white;
                    }
                    .modal-backdrop {
                        position: relative !important;
                    }
                    .light {
                        margin-left: 840px;
                    }
                    .inline {
                        display: inline-block;
                    }
                </style>

                <script>
                    // Get the modal
                    var modal = document.getElementById('myModal');

                    // Get the button that opens the modal
                    var btn = document.getElementById("myBtn");

                    // Get the <span> element that closes the modal
                    var span = document.getElementsByClassName("close")[0];

                    // When the user clicks the button, open the modal
                    btn.onclick = function () {
                        modal.style.display = "block";
                    }

                    // When the user clicks on <span> (x), close the modal
                    span.onclick = function () {
                        modal.style.display = "none";
                    }

                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function (event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }

                    // Get the modal
                    var modal = document.getElementById('id01');

                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function (event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                </script>
            </body>
        </html>