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
    <link rel="stylesheet" href="style.css">
    <title>Url shortener</title>

</head>

<body>
    <div class="mynavbar ">
        <div class="container ">
            <nav class="navbar navbar-expand-lg navbar-light">
                <h3>Url shorter</h3>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                        </li>
                        @auth
                        <li class="nav-item">
                            <a class="nav-link" href="dashboard">Dashboard</a>
                        </li>
                        @endauth
                        <!-- <li class="nav-item"> -->
                        <!-- <a class="nav-link" href="#">Pricing</a> -->
                        <!-- </li> -->
                    </ul>
                    @auth
                    <span class="navbar user">
                        <p> {{AUTH()->user()->username}}</p>
                    </span>
                    <span class="navbar ">
                        <a href="logout">Logout</a>
                    </span> @endauth @guest
                    <span class="navbar ">
                        <p>Guset</p>
                    </span>
                    <span class="navbar-text login_a">
                        <a href="#">Login/Register</a>
                    </span> @endguest

                </div>
            </nav>

        </div>
    </div>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4 text-center">Url shorter</h1>
            <p class="lead text-center">Easy easy easy</p>
            <!-- <a class="lead text-center">Easy</q> -->
            <!-- <a class="lead text-center">Easy</q> -->
        </div>
    </div>




    <script src='https://www.google.com/recaptcha/api.js?render=6Le1lLUZAAAAAEpqoDAtR-mmAvQ28F2ymOVqF7Lm'></script>



    <div class="container ">

        <ul class="nav nav-pills mb-3 justify-content-center  " id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active url_input_space" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">url</a>
            </li>
            <li class="nav-item">
                <a class="nav-link img_input_space" id="pills-img-tab" data-toggle="pill" href="#pills-img" role="tab" aria-controls="pills-img" aria-selected="false">img</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-filecloud-tab" data-toggle="pill" href="#pills-filecloud" role="tab" aria-controls="pills-filecloud" aria-selected="false">Filecloud</a>
            </li>
        </ul>


        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="input-group mb-3">
                    <input type="text" class="form-control url_input" placeholder="https://" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary url_send" type="button" id="button-addon2 ">Shorten</button>
                    </div>
                </div>
            </div>

            <!-- ------------------------------------------------------------------------------ -->

            <div class="tab-pane fade" id="pills-img" role="tabpanel" aria-labelledby="pills-img-tab">
                <div class="row">
                    <!-- <div class="col-md-6"> -->
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" accept="image/* " class="custom-file-input img_upload" id="inputGroupFile02 ">
                            <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose
                                file</label>
                        </div>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="col-md-6"> -->
                    <div class="input-group mb-3">
                        <input type="text" class="form-control password_input" placeholder="password" aria-label="Recipient's username" aria-describedby="button-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary img_send" type="button" id="button-addon2 ">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-filecloud" role="tabpanel" aria-labelledby="pills-filecloud">
                <h6 class="text-center">Max file size:10MB</h6>
                <h6 class="text-center">File life time:10 minutes</h6>
                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input file_cloud_input" id="inputGroupFile02">
                        <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                    </div>
                    <div class="input-group-append">
                        <!-- <span class="input-group-text file_cloud_btn" id="">Upload</span>
                         -->
                        <input type="submit" value="Upload" class="btn btn btn-outline-secondary file_cloud_btn ">

                    </div>
                </div>




            </div>

        </div>
    </div>
    </div>

    </div>


    <div class="result_zone d-none">
        <div class="container">

            <div class="input-group mb-3 ">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">https://example.com/</span>
                </div>
                <input type="text" class="form-control url_result " placeholder="result" aria-label="Recipient's username" aria-describedby="button-addon2">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary copy_btn" type="button" id="button-addon2">copy</button>
                </div>
            </div>
            <div class="url_qrcode text-center ">
            </div>
        </div>
    </div>










    <div class="footer ">
        <div class="jumbotron ">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <!-- <img src="https://fakeimg.pl/30x30/" alt=""> Name -->
                        <!-- <a class="navbar-brand" href="#"> -->
                        <!-- <img src="https://img.icons8.com/material-outlined/48/000000/cloud-link.png" /> Name -->
                        <!-- </a> -->
                        <h3>Url shorter</h3>
                        <p>Make url easier</p>
                        <p>
                            &copy;0xdeciverAngel
                        </p>
                    </div>
                    <!-- <div class="col-md-4 text-left">
                        <h6>common questions</h6>
                    </div> -->
                    <div class="col-md-6 text-left ">
                        <h4>contact us
                        </h4>
                        <p>E-mail:31663805+0xdeciverAngel@users.noreply.github.com</p>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- <div class="container-fulid text-center">
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        &copy;0xdeciverAngel
    </div> -->







    <div class="modal fade progress_modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Progressing</h5>

                </div>
                <div class="modal-body">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">100%</div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade login_modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="exampleModalLongTitle"> -->
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-login-tab" data-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-register-tab" data-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">Register</a>
                        </li>

                    </ul>
                    <!-- </h5> -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="pills-login-tab">
                            <form action="login" method="POST">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="l_email form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" required>
                                    <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="l_password form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                                </div>

                            </form>
                            <button type="submit" class="login_btn btn btn-primary">Login</button>

                        </div>
                        <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="pills-register">
                            <form action="register" method="POST">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" class="r_name form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name" name="name" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email</label>
                                    <input type="email" class="r_email form-control" id="exampleInputPassword1" placeholder="Enter email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="r_pw form-control" id="exampleInputPassword1" placeholder="Enter password" name="password" required>
                                </div>

                            </form>
                            <button type="submit" class="reg_btn btn btn-primary">Register</button>
                        </div>
                    </div>



                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade modal_error" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Error message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal_error_body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast" id="myToast" style="position: absolute; top: 0; right: 0;" data-delay="5000">
        <div class="toast-header">
            <strong class="mr-auto"><i class="fa fa-grav"></i>Message</strong>

            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <div>error format</div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
</body>

</html>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script> -->
<script src="index.js"></script>
</body>

</html>