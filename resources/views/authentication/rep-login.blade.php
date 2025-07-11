

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('frontend/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/favicon.png') }}" type="image/x-icon">
    <title>Royal Insuarance</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/feather-icon.css') }}">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('frontend/assets/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/responsive.css') }}">
  </head>
  <body>
   <!-- login page start-->
   <div class="container-fluid p-0">
      <div class="row m-0">
        <div class="col-12 p-0">
        <div class="login-card">
            <div>
               {{-- <div><a class="logo" href="{{ route('index') }}"><img class="img-fluid for-light" src="{{asset('frontend/assets/images/logo/login.png')}}" alt="loginpage"><img class="img-fluid for-dark" src="{{asset('frontend/assets/images/logo/logo_dark.png')}}" alt="loginpage"></a></div> --}}
               <div class="login-main">

                  <form action="{{ route('rep.login') }}" method="POST" class="theme-form">
    @csrf
    <h4>Rep Login</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="form-group">
        <label>Agent/Sub Agent Code</label>
        <input type="text" name="code" class="form-control" placeholder="Enter your code" required>
    </div>

    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
    </div>

    <div class="form-group mb-0">
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </div>

    <p class="mt-4 mb-0">Don’t have an account?
        <a class="ms-2" href="{{ route('rep.register.form') }}">Register here</a>
    </p>
</form>

               </div>
            </div>
         </div>
        </div>
        </div>
      </div>
    </div>
  </body>
</html>
