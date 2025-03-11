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
    <title>Cuba - Premium Admin Template</title>
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
<div class="container-fluid p-0">
   <div class="row m-0">
      <div class="col-12 p-0">
         <div class="login-card">
            <div>
               {{-- <div><a class="logo" href="{{ route('index') }}"><img class="img-fluid for-light" src="{{asset('assets/images/logo/login.png')}}" alt="looginpage"><img class="img-fluid for-dark" src="{{asset('assets/images/logo/logo_dark.png')}}" alt="looginpage"></a></div> --}}
               <div class="login-main">
                  <form action="{{ route('register.store')}}" method="POST" class="theme-form">
                     @csrf
                     <h4>Create your account</h4>
                     <p>Enter your personal details to create account</p>

                     @error('firstname')
                     <div class="alert alert-danger">{{ $message}}</div>
                     @enderror
                     @error('lastname')
                     <div class="alert alert-danger">{{ $message}}</div>
                     @enderror
                     @error('email')
                     <div class="alert alert-danger">{{ $message}}</div>
                     @enderror
                     @error('password')
                     <div class="alert alert-danger">{{ $message}}</div>
                     @enderror

                     @if (session('success'))

                     <div class="alert alert-success">
                        {{ session('success')}}
                     </div>
                     @endif

                     <div class="form-group">
                        <label class="col-form-label pt-0">Your Name</label>
                        <div class="row g-2">
                           <div class="col-6">
                              <input class="form-control" type="text" name="firstname" placeholder="First name" required >
                           </div>
                           <div class="col-6">
                              <input class="form-control" type="text"  name="lastname"  placeholder="Last name" required >
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">Email Address</label>
                        <input class="form-control" type="email" name="email" placeholder="Test@gmail.com" required >
                     </div>
                     <div class="form-group">
                        <label class="col-form-label">Password</label>
                        <input class="form-control" type="password" name="password" placeholder="" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" placeholder="" required>
                    </div>

                     <div class="form-group mb-0">
                        <div class="checkbox p-0">
                           <input id="checkbox1" type="checkbox">
                           <label class="text-muted" for="checkbox1">Agree with<a class="ms-2" href="#">Privacy Policy</a></label>
                        </div>
                        <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                     </div>
                     <h6 class="text-muted mt-4 or">Or signup with</h6>
                     <div class="social mt-4">
                        <div class="btn-showcase"><a class="btn btn-light" href="https://www.linkedin.com/login" target="_blank"><i class="txt-linkedin" data-feather="linkedin"></i> LinkedIn </a><a class="btn btn-light" href="https://twitter.com/login?lang=en" target="_blank"><i class="txt-twitter" data-feather="twitter"></i>twitter</a><a class="btn btn-light" href="https://www.facebook.com/" target="_blank"><i class="txt-fb" data-feather="facebook"></i>facebook</a></div>
                     </div>
                     <p class="mt-4 mb-0">Already have an account?<a class="ms-2" href="{{ route('login.form') }}">Sign in</a></p>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</body>
</html>
