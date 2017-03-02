<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>HouseStars - Smarter Property Sales</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{url('favicon.png')}}">

    <!-- Bootstrap -->
    <link href="{{env('APP_URL')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{env('APP_URL')}}/css/housestars-main.css" rel="stylesheet">
    <link href="{{env('APP_URL')}}/css/housestars-icon.css" rel="stylesheet">



<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{ env('APP_URL').'/css/pe-icon-7-stroke.css' }}" rel="stylesheet">

    <style>
        body {
            background: #f1f3f6;
            width: auto !important;
            min-width: 200px;
        !important;
        }

        .login-form {
            background: #ffffff;
            padding: 30px 40px;
            /* margin-top: 110px; */
            width: 450px;
            margin: 110px auto;
        }

        .login-form .forgot-password {
            color: #909090;
            font-size: 12px;
            text-align: center;
            margin-top: -12px;
        }

        .logo-img {
            width: 85%;
            margin: auto;
            margin-bottom: 20px;
        }

        a {
            color: #23527c;
        }

        p.errors{
            text-align:center;
        }

        /* Extra Small Devices, Phones */
        @media only screen and (max-width: 480px) {

            .login-form {
                margin: 0 !important;
            }

            .logo-img {
                width: 100% !important;
            }

        }
    </style>
</head>
<body>




    <form method="POST" action="{{ url(env('APP_URL').'/admin/login') }}">
        {{csrf_field() }}
        <div class="login-form">
            <img class="img-responsive logo-img" src="{{ env('APP_URL').'/assets/logo-header-home.png' }}">
            {{--<p class="sub-heading">Access your account and let’s start working</p>--}}
            <form action="login" method="POST" class="ajax">
                <div id="error"></div>
                <div id="login-error"></div>
                <input type="text" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password" class="no-top">

                <p class="errors">
                    @if($errors->has('login_error'))
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                        @endif
                </p>

                <button class="btn hs-primary btn-block"><i class="pe-7s-lock"></i> Login To My Account
                </button>
            </form>
            <p class="forgot-password">Forgot your login credentials? Click <a href="#">here</a></p>
        </div>
    </form>


</body>
</html>