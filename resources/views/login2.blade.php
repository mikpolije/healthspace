<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="login_assets/style.css">
    <link rel="stylesheet" href="{{asset('toastr/toastr.min.css')}}">
    <title>HEALTHSPACE</title>
</head>

<body>
    <div class="container">
      
        <div class="panels-container">
            <div class="panel left-panel">
              

            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Belum Punya Akun?</h3>
                    <p></p>
                    <img src="login_assets/img/logo.png" alt="" class="image">
                    <a href="{{url('register')}}">  <button  class="btn" id="">Sign Up</button></a>
                </div>
            </div>
        </div>
        <div class="signin-signup">
            <form action="{{url('postlogin')}}" method="post" class="sign-in-form">
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
                
                <h4 class="title">Selamat Datang di</h4>
                <h4 class="title">HealthSpace</h4>
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Email" name="email">
                </div>

                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Password" name="password">
                </div>
                <!-- Checkbox -->
                <!-- <div class="remember-forgot">
                    <label><input type="checkbox"> Remember me </label>
                    <a href="#">Forgot Password?</a>
                </div> -->
                <!-- end section Checkbox -->
                <input type="submit" value="SIGN IN" class="btn">
                <p class="social-text">Or Sign in with </p>
                <div class="social-media">
                    <a href="{{url('login-google-auth')}}" class="social-icon">
                        <i class="fab fa-google"></i>
                    </a>
                </div>
                <!-- <a href="/homepage" class="small text-muted">Klinik Fanda Berkat Medika Panti</a> -->
            </form>
            <form action="" method="post" class="sign-up-form">
   
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="login_assets/js/login.js"></script>
    <script src="{{asset('toastr/toastr.min.js')}}"></script>
    <script>
			$(function() {

				$('.toastrDefaultSuccess').addClass(function() {

					toastr.success('Berhasil Mendaftar. Silahkan Login')
				});

			});
		</script>
</body>

</html>