<?php
    $appUrl = env('APP_URL').'/';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>Housestars Admin</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>


    <!-- Bootstrap core CSS     -->
    <link href="{{ $appUrl.'css/bootstrap.min.css' }}" rel="stylesheet">

    <!-- Animation library for notifications   -->
    <link href="{{ $appUrl.'css/animate.css' }}" rel="stylesheet">

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{ $appUrl.'css/light-bootstrap.css' }}" rel="stylesheet">


    <!--  CSS for Demo Purpose, don't include it in your project     -->
{{--<link href="assets/css/demo.css" rel="stylesheet" />--}}


<!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{ $appUrl.'css/pe-icon-7-stroke.css' }}" rel="stylesheet">


    <style>
        /* temporary styles */
        .form-item {
            margin-bottom: 10px;
        }

        .form-item label {
            margin-top: 10px;
        }

        .form-item .radio-inline {
            margin-top: 10px;
        }

        input.number-input {
            width: 50%;
        }

        #loading {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            background-color: rgba(192, 192, 192, 0.5);

            background-repeat: no-repeat;
            background-position: center;
        }

        .loading-screen {
            width: 100px;
            height: 100px;
            margin: 350px auto;
            background-image: url('../assets/loading.png');
        }

        #loader {
            width: 30px;
            margin: 0 auto;
            display: block;
            position: relative;
            top: 27px;
        }

        #loader {
            -webkit-animation-name: spinner;
            -webkit-animation-timing-function: linear;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-duration: 2s;
            animation-name: spinner;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-duration: 2s;
            -webkit-transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transform-style: preserve-3d;
        }

        /* WebKit and Opera browsers */
        @-webkit-keyframes spinner {
            from {
                -webkit-transform: rotateY(0deg);
            }
            to {
                -webkit-transform: rotateY(-360deg);
            }
        }

        /* all other browsers */
    </style>


    @yield('css')
</head>
<body data-ng-app="app">

<div class="wrapper">
    <div class="sidebar" data-color="purple"> <!-- data-image="assets/img/sidebar-5.jpg" -->

        <!--   you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple" -->


        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                    <img src="{{ $appUrl.'assets/logo.png' }}">
                </a>
            </div>

            <ul class="nav">
                {{--<li>
                    <a href="#/dashboard"> <!-- #/dashboard -->
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>--}}
                <li>
                    <a href="#/members "> <!-- #/members -->
                        <i class="pe-7s-user"></i>
                        <p>Members</p>
                    </a>
                </li>
                <li>
                    <a href="#/properties"> <!-- #/properties -->
                        <i class="pe-7s-note2"></i>
                        <p>Properties</p>
                    </a>
                </li>
                <li>
                    <a href="#/reviews"> <!-- #/reviews -->
                        <i class="pe-7s-news-paper"></i>
                        <p>Reviews</p>
                    </a>
                </li>
                <li>
                    <a href="#/categories"> <!-- #/reviews -->
                        <i class="pe-7s-way"></i>
                        <p>Categories</p>
                    </a>
                </li>
                <li>
                    <a href="#/suburbs"> <!-- #/reviews -->
                        <i class="pe-7s-map-2"></i>
                        <p>Suburbs</p>
                    </a>
                </li>
                {{--<li>
                    <a href="#/advertisements"> <!-- #/advertisements -->
                        <i class="pe-7s-rocket"></i>
                        <p>Advertisements</p>
                    </a>
                </li>--}}
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                </div>
                <div class="collapse navbar-collapse">

                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{ url($appUrl.'admin') }}">
                                <p>Admin</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ $appUrl }}">
                                <p>Homepage</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url($appUrl.'admin/logout') }}">
                                <p>Log out</p>
                            </a>
                        </li>
                        <li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content">
            <div id="content" class="content-container" ng-controller="MainCtrl">
                <div class="container-fluid">

                    <section data-ng-view class="view-container"></section>
                    {{--@yield('content')--}}

                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="container-fluid">
                <p class="copyright pull-right">
                    &copy;
                    <script>document.write(new Date().getFullYear())</script>
                    <a href="http://webforest.solutions">Webforest Digital Solutions</a>
                </p>
            </div>
        </footer>


    </div>
</div>

@yield('modals')

<div id="loading" style="display:none;">
    <div class="loading-screen">
        <img id="loader" src="{{ $appUrl.'assets/loader.png' }}"/>
    </div>
</div>

</body>

<!--   Core JS Files   -->
<script src="{{ $appUrl.'js/jquery-1.10.2.js' }}" type="text/javascript"></script>
<script src="{{ $appUrl.'js/bootstrap.min.js' }}" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="{{ $appUrl.'js/bootstrap-checkbox-radio-switch.js' }}"></script>

<!--  Charts Plugin -->
<script src="{{ $appUrl.'js/chartist.min.js' }}"></script>

<!--  Notifications Plugin    -->
<script src="{{ $appUrl.'js/bootstrap-notify.js' }}"></script>

<!--  Google Maps Plugin    -->
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>--}}

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="{{ $appUrl.'js/light-bootstrap-dashboard.js' }}"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
{{--<script src="assets/js/demo.js"></script>--}}

<script type="text/javascript">

    var $baseUrl = '{{ env('APP_URL') }}';
    $_token = '{{ csrf_token() }}';

    /*$(window).load(function () {
        $("#loading").fadeOut("slow");
    });

    $("#loading").fadeOut("slow");*/

</script>

{{--<script type="text/javascript" src="{{asset('js/modules/main.js')}}"></script>--}}

<script type="text/javascript" src="{{ $appUrl.'housestars/bower_components/angular/angular.min.js' }}"></script>
<script type="text/javascript"
        src="{{ $appUrl.'housestars/bower_components/angular-route/angular-route.min.js' }}"></script>
<script type="text/javascript"
        src="{{ $appUrl.'housestars/bower_components/angular-bootstrap/ui-bootstrap.min.js' }}"></script>
<script type="text/javascript"
        src="{{ $appUrl.'housestars/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js' }}"></script>

<script type="text/javascript" src="{{ $appUrl.'js/angular/app.js' }}"></script>

<script type="text/javascript" src="{{ $appUrl.'js/angular/routes.js' }}"></script>
<script type="text/javascript" src="{{ $appUrl.'js/angular/controllers.js' }}"></script>
<script type="text/javascript" src="{{ $appUrl.'js/angular/services.js' }}"></script>
<script type="text/javascript" src="{{ $appUrl.'js/angular/directives.js' }}"></script>
<script type="text/javascript" src="{{ $appUrl.'js/angular/filters.js' }}"></script>

@yield('scripts')


</html>