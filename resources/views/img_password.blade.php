<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Url Shortener">
    <meta property="og:image:type" content="image/jpg">
    <meta property="og:description" content="Make url easiser" />
    <!-- <meta property="og:image" content="og_logo.jpg"> -->
    <!-- <meta property="og:image:width" content="48" /> -->
    <!-- <meta property="og:image:height" content="48" /> -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@500&family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="img_password_page.css">
    <title>Url shortener</title>


</head>

<body>
    <div class="mynavbar">
        <div class="container ">
            <nav class="navbar navbar-expand-lg  navbar-light" style="background-color:white;">
                <a class="" href="#">
                    <img src="https://img.icons8.com/material-outlined/48/000000/cloud-link.png" /> name

                    <a class="nav-link" href="#">About us

                    </a>

            </nav>
        </div>
    </div>
    <script src='https://www.google.com/recaptcha/api.js?render=6Le1lLUZAAAAAEpqoDAtR-mmAvQ28F2ymOVqF7Lm'></script>

    <div class="summit_area {{$summit_disyplay ?? ''}}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="input-group mb-3 " style="width:360px; margin-top: 150px;">
                    <input type="text" class="form-control password_input" placeholder="password" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary password_send_btn" type="button" id="button-addon2">Summit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="img_aera">
        <div class="container">
            <div class="row justify-content-center">
                <img src="data:image/png;base64,{{$img_data??''}}" class="img_show" alt="">
            </div>
        </div>
    </div>

    <div class=" footer fixed-bottom ">
        <div class=" jumbotron ">
            <div class=" container ">
                <div class=" row ">
                    <div class=" col-md-6 ">
                        <!-- <img src=" https://fakeimg.pl/30x30/ " alt=" "> Name -->
                        <a class=" navbar-brand " href=" # ">
                            <img src=" https://img.icons8.com/material-outlined/48/000000/cloud-link.png " /> Name
                        </a>

                        <p>describe</p>
                        <p>
                            &copy;0xdeciverAngel
                        </p>
                    </div>
                    <!-- <div class=" col-md-4 text-left ">
                        <h6>common questions</h6>
                    </div> -->
                    <div class=" col-md-6 text-left ">
                        <h4>contact us
                        </h4>
                        <p>E-mail:admin@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- ---------------------------------------- -->

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Error message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src=" https://code.jquery.com/jquery-3.3.1.min.js " crossorigin=" anonymous "></script>
    <script src=" https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js " integrity=" sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut " crossorigin=" anonymous "></script>
    <script src=" https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js " integrity=" sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k " crossorigin=" anonymous "></script>
    <script type=" text/javascript " src=" https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js "></script>
</body>

</html>
<script src=" img_password_page.js "></script>
</body>

</html>