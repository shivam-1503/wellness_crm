@php @endphp
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>People | Syntorix Consulting Pvt Ltd</title>

        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend_assets/images/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('backend_assets/images/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend_assets/images/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('backend_assets/images/favicon/site.webmanifest') }}">


        <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
        
	    <link href="{{ asset('backend_assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
        
        <!-- STYLE CSS -->
	    <link href="{{ asset('backend_assets/css/style.css') }}" rel="stylesheet" />

	    <link href="{{ asset('backend_assets/css/icons.css') }}" rel="stylesheet" />
        
        <!-- COLOR SKIN CSS -->
        <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('backend_assets/colors/color1.css') }}" />
    
        <style>
            .login-bg {
                /* background: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg') no-repeat center center fixed;  */
                background: url('backend_assets/images/banner6.jpg') no-repeat center center fixed; 
                -webkit-background-size: cover;
                -moz-background-size: cover;
                -o-background-size: cover;
                background-size: cover;
            }
        </style>
    </head>


    

    <body class="bg-white">
        <main >
            <div class="container-fluid login-bg">
            
            <div class="row">
                <div class="col-md-6 d-flex">
                    <!-- <img src="{{ asset('backend_assets/images/banner3.jpg') }}" alt="login image" class="login-img img"> -->
                </div>
                
                <div class="col-md-6 px-3" style="margin: 100px 0;">
                    
                    <div class="login-wrapper m-auto">
                        <div class="brand-wrapper text-center">
                            <img src="{{ asset('backend_assets/images/brand/logo.jpeg') }}" width="150" alt="logo" >
                        </div>
                        
                        <p class="login-description text-center">Sign into your account</p>
                        
                        <form method="POST" action="{{ route('login') }}">
                        @csrf

                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-email-outline"></i></span>
                                    </div>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    
                                    <!-- @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror -->
                                    
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>

                            
                            
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="mdi mdi-lock-outline"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    <!-- @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror -->
                                    
                                </div>
                                @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                
                            </div>
                            <div class="form-options-wrapper text-center">
                                <label class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="custom-control-label">Remember me</span>
                                </label>
                                @if (Route::has('password.request'))
                                    <a class="forgot-password-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-block login-btn">
                                {{ __('Login') }}
                            </button>
                        </form>

                    </div>
                </div>
            </div>
            </div>
        </main>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>