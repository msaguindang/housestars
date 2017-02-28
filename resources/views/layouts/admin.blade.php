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
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Animation library for notifications   -->
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">

    <!--  Light Bootstrap Table core CSS    -->
    <link href="{{asset('css/light-bootstrap.css')}}" rel="stylesheet">


    <!--  CSS for Demo Purpose, don't include it in your project     -->
{{--<link href="assets/css/demo.css" rel="stylesheet" />--}}


<!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{asset('css/pe-icon-7-stroke.css')}}" rel="stylesheet">


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
                    <img src="{{asset('assets/logo.png')}}">
                </a>
            </div>

            <ul class="nav">
                <li>
                    <a href="#/dashboard"> <!-- #/dashboard -->
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
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
                    <a href="#/advertisements"> <!-- #/advertisements -->
                        <i class="pe-7s-rocket"></i>
                        <p>Advertisements</p>
                    </a>
                </li>
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
                            <a href="{{ url('/admin') }}">
                                <p>Admin</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/') }}">
                                <p>Homepage</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/admin/logout') }}">
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


</body>

<!--   Core JS Files   -->
<script src="{{asset('js/jquery-1.10.2.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="{{asset('js/bootstrap-checkbox-radio-switch.js')}}"></script>

<!--  Charts Plugin -->
<script src="{{asset('js/chartist.min.js')}}"></script>

<!--  Notifications Plugin    -->
<script src="{{asset('js/bootstrap-notify.js')}}"></script>

<!--  Google Maps Plugin    -->
{{--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>--}}

<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
<script src="{{asset('js/light-bootstrap-dashboard.js')}}"></script>

<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
{{--<script src="assets/js/demo.js"></script>--}}

<script type="text/javascript">

    var $baseUrl = '{{ url('/') }}';
    $_token = '{{ csrf_token() }}';

</script>

{{--<script type="text/javascript" src="{{asset('js/modules/main.js')}}"></script>--}}

<script type="text/javascript" src="{{ asset('housestars/bower_components/angular/angular.min.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('housestars/bower_components/angular-route/angular-route.min.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('housestars/bower_components/angular-bootstrap/ui-bootstrap.min.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('housestars/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/angular/app.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/angular/routes.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/angular/controllers.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/angular/services.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/angular/directives.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/angular/filters.js') }}"></script>

@yield('scripts')


</html>