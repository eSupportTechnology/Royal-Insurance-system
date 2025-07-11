<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('frontend/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('frontend/assets/images/favicon.png') }}" type="image/x-icon">
    <title>Royal Insuarance</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap"
        rel="stylesheet">
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
                        <div class="login-main">
                            <form action="{{ route('rep.register') }}" method="POST" class="theme-form"
                                id="code-check-form">
                                @csrf
                                <h4>Sign in or Setup your account</h4>
                                <p>Enter your code to create account</p>

                                @error('code')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="form-group">
                                    <label class="col-form-label pt-0">Agent/Sub Agent Code</label>
                                    <div class="input-group">
                                        <input class="form-control col-8" type="text" name="code"
                                            id="rep_code_input" placeholder="Code here" required>
                                        <button type="button" id="check-code-btn"
                                            class="btn btn-outline-primary ms-2 col-4">Check Eligibility</button>
                                    </div>
                                    <div id="code-message" class="mt-2"></div>
                                </div>

                                {{-- Password field (initially hidden) --}}
                                <div class="form-group" id="password-field" style="display: none;">
                                    <label class="col-form-label pt-0">Password</label>
                                    <input class="form-control" type="password" name="password"
                                        placeholder="Enter password">
                                        <br>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Confirm password">
                                </div>

                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                                </div>

                                <p class="mt-4 mb-0">Already have an account?
                                    <a class="ms-2" href="{{ route('rep.login.form') }}">Sign in</a>
                                </p>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#check-code-btn').on('click', function() {
            let code = $('#rep_code_input').val().trim();

            if (code !== '') {
                $.ajax({
                    url: '{{ route('rep.check.code') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        code: code
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#code-message').html(
                                '<span class="text-success">✅ Eligible code</span>');
                            $('#password-field').slideDown();
                        } else {
                            $('#code-message').html(
                                '<span class="text-danger">❌ Invalid or ineligible code</span>');
                            $('#password-field').slideUp();
                        }
                    },
                    error: function() {
                        $('#code-message').html(
                            '<span class="text-danger">Something went wrong. Please try again.</span>'
                        );
                        $('#password-field').slideUp();
                    }
                });
            } else {
                $('#code-message').html('<span class="text-danger">Please enter a code.</span>');
                $('#password-field').slideUp();
            }
        });
    </script>



</body>

</html>
