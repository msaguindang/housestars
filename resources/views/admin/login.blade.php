<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">

    <!-- custom and temporary login css -->
    <style>

        body, html {
            height: 100%;
        }


    </style>
</head>
<body>
<div class="container">
    <div class="wrapper">
        <form class="form-signin" method="POST" action="{{ url(env('APP_URL').'/login') }}">
            {{csrf_field() }}
            <div class="form-signin-body">
                <div class="form-group">
                    <input type="text" placeholder="Email" class="form-control" name="email" required autofocus/>
                </div>

                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control" name="password"/>
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
            </div>
        </form>

    </div>
</div>
</body>
</html>