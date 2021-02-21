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
                        <p> {{AUTH::user()->username}}</p>
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
    <div class="container ">
        <div class="row justify-content-center">
            <div class="table_area justify-content-center">
                <table class="table table-hover w-auto">
                    <thead>
                        <tr>
                            <th scope="col">org_url</th>
                            <th scope="col">redirect_url</th>
                            <th scope="col">redirect_times</th>
                            <th scope="col">creat_time</th>
                            <th scope="col">last_time_use</th>
                            <th scope="col">delete url</th>
                            <th scope="col">change password</th>
                        </tr>

                    </thead>
                    <tbody>
                        <!-- {{$user}} -->
                        @foreach( $user as $u)
                        <tr>
                            <td>{{$u->org_url}}</td>
                            <td><a href="{{$u->redirect_url}}">{{$u->redirect_url}}</a></td>
                            <td>{{$u->redirect_times}}</td>
                            <td>{{$u->creat_time}}</td>
                            <td>{{$u->last_time_use}}</td>
                            <td><button class="btn btn-primary del_btn" type="submit" url="{{$u->redirect_url}}">Delete</button></td>
                            @if($u->type=='img')
                            <td><button class="btn btn-primary change_btn" type="submit" url="{{$u->redirect_url}}">Change </button></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="modal fade change_modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">New Password</label>
                        <input type="password" class="form-control pw_input" id="exampleInputPassword1" placeholder="Enter password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary change_pw_btn">Change</button>
                </div>
                <div class="modal-footer">

                </div>
            </div>
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
<script src="dashboard.js"></script>
</body>

</html>