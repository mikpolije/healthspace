<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('admin_theme/assets/vendor/fonts/boxicons.css')}}" />
    <link rel="stylesheet" href="{{asset('admin_theme/assets/vendor/css/core.css')}}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('admin_theme/assets/vendor/css/theme-default.css')}}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('admin_theme/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <script src="{{asset('admin_theme/assets/vendor/js/helpers.js')}}"></script>
    <script src="{{asset('admin_theme/assets/js/config.js')}}"></script>

    <link rel="stylesheet" href="{{asset('toastr/toastr.min.css') }}">

    <style>
        input[type="text"] {
            border-top: 0;
            border-right: 0;
            border-left: 0;

            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .btn-success {
            background-color: #31534C;
            border-color: #31534C;
        }
    </style>

</head>

<body>


    <div class="container">

        <div class="card my-5">
            <div class="d-flex flex-row">
                <div class="w-50 d-flex align-items-center justify-content-center" style="background-color : #31534C;">
                    <img src="{{asset('login_assets/img/logo.png')}}" width="200" alt="">
                </div>
                <div class="w-50 py-5 px-3">
                    <div class="container px-5">
                        <h2 class="text-center fw-bold mb-0">Selamat Datang di</h2>
                        <h2 class="text-center fw-bold mt-0">Healthspace</h2>
                        <a href="{{url('login-google-auth')}}" class="btn btn-white border mx-auto d-block w-50 w mb-5">
                            <img src="https://cdn-icons-png.flaticon.com/256/2702/2702602.png" alt="" width="30">
                            Login With Google
                        </a>
                        <form action="{{url('postlogin')}}" method="post">
                            @csrf
                            @if(session()->has('message'))
                            <div class="toastrDefaultSuccess" role="alert" id="notif">
                            </div>
                            @endif

                            @if(session()->has('error'))
                            <div class="alert alert-danger" role="alert" id="notif">
                                <span data-notify="icon" class="fa fa-bell"></span>
                                <span data-notify="title">Gagal</span> <br>
                                <span data-notify="message">{{session()->get('error')}}</span>
                            </div>
                            @endif
                            @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show col-md-12" role="alert">
                                <strong>Gagal !</strong>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="d-flex justify-content-between mt-4 mb-1">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me">
                                    <label class="form-check-label" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                                <button class="btn btn-success px-5" type="submit">Login</button>
                            </div>

                            <div class="text-center mt-2 mb-2">
                                <span>No Account Yet? <a href="{{url('register')}}">Sign Up</a></span>
                            </div>

                            <button type="button" class="bg-white float-end border rounded-circle px-3 py-3">
                                <i class='bx bx-chat'></i>
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('admin_theme/assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('admin_theme/assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('admin_theme/assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('admin_theme/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('admin_theme/assets/vendor/js/menu.js')}}"></script>
    <script src="{{asset('admin_theme/assets/js/main.js')}}"></script>




</body>

</html>