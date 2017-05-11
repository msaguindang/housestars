<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>HouseStars -  Smarter Property Sales</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{url('favicon.png')}}">

    <!-- Bootstrap -->
    <link href="{{config('app.url')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{config('app.url')}}/css/dropdowns-enhancement.css" rel="stylesheet">
    <link href="{{config('app.url')}}/css/animate.css" rel="stylesheet">
    <link href="{{config('app.url')}}/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="{{config('app.url')}}/css/selectize.css" rel="stylesheet">
    <link href="{{config('app.url')}}/css/basic.css" rel="stylesheet">
    <link href="{{config('app.url')}}/css/dropzone.css" rel="stylesheet">
    <link href="{{config('app.url')}}/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{config('app.url')}}/css/housestars-main.css" rel="stylesheet">
    <link href="{{config('app.url')}}/css/housestars-icon.css" rel="stylesheet">

    <!-- Responsiveness -->

    <link href="{{config('app.url')}}/css/housestars-tablet.css" rel="stylesheet">
    <link href="{{config('app.url')}}/css/housestars-mobile.css" rel="stylesheet">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="{{config('app.url')}}/js/loading.js"></script>
    <script src="{{config('app.url')}}/js/standalone/selectize.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('styles')
  </head>
  <body>
    <header id="header" class="tablet">
        <div class="container">
          <div class="row">
            <div class="col-xs-3 branding">
              <a href="{{env('APP_URL')}}/"><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
            </div>
            <div class="col-xs-7 col-xs-offset-2 navigation">
              <div class="row top-links">
                <div class="customer-care">
                  <p><span class="label">Call Customer Care </span><a href="tel:0404045597" class="number">0404045597</a></p>
                </div>
                <!-- <div class="nav-items">
                  <ul>
                    @if(Sentinel::check())
                     <li><a href="{{env('APP_URL')}}/profile">Hi, {{Sentinel::getUser()->name}}</a></li>
                    @else
                      <li><a href="#" data-toggle="modal" data-target="#login" id="login-form">Login</a></li>
                    @endif
                  </ul>
                </div> -->
              </div>
              <div class="row">
                <div class="main-nav">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainnav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <!-- /.navbar-collapse -->
                  <!-- <ul>
                    @if(Sentinel::check())
                    <li><span class="icon icon-logout-dark"></span>
                      <form action="{{env('APP_URL')}}/logout" method="POST" id="logout-form">
                        {{csrf_field() }}
                        <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
                      </form>
                    </li>
                    <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @else
                    <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="{{env('APP_URL')}}/">Home</a></li>
                    @endif
                  </ul> -->
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="dropdown-nav">
          <div class="collapse navbar-collapse" id="mainnav">
            <ul class="nav navbar-nav">
              @if(Sentinel::check())
              <li><a href="{{env('APP_URL')}}/profile">Profile</a></li>
              <li><a href="{{env('APP_URL')}}/agency">Agency</a></li>
              <li><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
              <li><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
              <li>
                <form action="{{env('APP_URL')}}/logout" method="POST" id="logout-form">
                  {{csrf_field() }}
                  <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
                </form>
              </li>
              @else
              <li><a href="{{env('APP_URL')}}/">Home</a></li>
              <li><a href="{{env('APP_URL')}}/agency">Agency</a></li>
              <li><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
              <li><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
              <li><a href="#" data-toggle="modal" data-target="#login" id="login-form">Login</a></li>
              <li><a href="#" data-toggle="modal" data-target="#signup" id="signup-form">Signup</a></li>
              @endif
            </ul>
          </div>
        </div>
    </header>


@yield("content")
    <footer>
      <div class="container main-footer">
        <div class="row widget">
          <div class="col-xs-3 company-identity">
              <img src="{{asset('assets/logo-footer.png')}}" alt="HouseStars" class="logo">
              <p class="label">Office Address</p>
              <p>21 Main Street Alstonville, </br>New South Wales 2477</p>
              <p>Tel No: 0404045597 </p>
              <a href="#" data-toggle="modal" data-target="#team" class="hs-transparent-dark">BECOME PART OF THE TEAM</a>
          </div>
          <div class="col-xs-8 col-xs-offset-1 links">
            <div class="row footer-nav">
              <div class="col-xs-3 nav-category">
                <p class="label">The Company</p>
                <ul>
                  <li><a href="{{env('APP_URL')}}/about-us">About Us</a></li>
                  <li><a href="#">In The Media</a></li>
                  <li><a href="#" data-toggle="modal" data-target="#contact">Contact Us</a></li>
                </ul>
              </div>
              <div class="col-xs-3 nav-category">
                <p class="label">Agency</p>
                <ul>
	              <li><a href="{{env('APP_URL')}}/faq/agency">Agent FAQ</a></li>
                  <li><a href="{{env('APP_URL')}}/our-agent-philosophy">Our Agent Philosophy</a></li>
                </ul>
              </div>
              <div class="col-xs-3 nav-category">
                <p class="label">TRADE/SERVICE</p>
                <ul>
	              <li><a href="{{env('APP_URL')}}/faq/tradesman">Service FAQ</a></li>
                  <li><a href="{{env('APP_URL')}}/our-service-philosophy">Our Service Philosophy</a></li>
                </ul>
              </div>
              <div class="col-xs-3 nav-category">
                <p class="label">Customer</p>
                <ul>
                  <li><a href="{{env('APP_URL')}}/faq/customer">Customer FAQ</a></li>
                  <li><a href="{{env('APP_URL')}}/guidelines">Review Guidelines</a></li>
                  <li><a href="{{env('APP_URL')}}/process-page">Process Page</a></li>
                </ul>
              </div>
            </div>
            <div class="row social-media desktop">
              <div class="col-xs-4 social-item">
                <span class="icon icon-fb"></span>
                <a href="https://www.facebook.com/housestars.com.au/" target="_blank">Housestars</a>
                <p>www.facebook.com/housestars</p>
              </div>
              <div class="col-xs-4 social-item">
                <span class="icon icon-ig"></span>
                <a href="https://www.instagram.com/housestars.com.au/" target="_blank">@Housestars</a>
                <p>www.instagram.com/housestars</p>
              </div>
              <div class="col-xs-4 social-item">
                <span class="icon icon-tw"></span>
                <a href="https://twitter.com/HousestarsAu" target="_blank">@Housestars</a>
                <p>www.twitter.com/housestars</p>
              </div>
            </div>
          </div>
        </div>
        <div class="row social-media tablet">
          <div class="col-xs-4 social-item">
            <span class="icon icon-fb"></span>
            <a href="https://www.facebook.com/housestars.com.au/" target="_blank">Housestars</a>
            <p>www.facebook.com/housestars</p>
          </div>
          <div class="col-xs-4 social-item">
            <span class="icon icon-ig"></span>
            <a href="https://www.instagram.com/housestars.com.au/" target="_blank">@Housestars</a>
            <p>www.instagram.com/housestars</p>
          </div>
          <div class="col-xs-4 social-item">
            <span class="icon icon-tw"></span>
            <a href="https://twitter.com/HousestarsAu" target="_blank">@Housestars</a>
            <p>www.twitter.com/housestars</p>
          </div>
        </div>
      </div>
      <div class="copyright">
        <div class="container">
          <p class="trademark">Copyright 2016 HouseStars</p>
          <ul class="legal-links">
            <li><a href="{{env('APP_URL')}}/legal/terms-conditions" target="_blank">Terms and Conditions</a></li>
            <li><a href="{{env('APP_URL')}}/legal/privacy-policy" target="_blank">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
    </footer>


@include("modals")

    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{config('app.url')}}/js/bootstrap.min.js"></script>
    <script src="{{config('app.url')}}/js/dropdowns-enhancement.js"></script>
    <script src="{{config('app.url')}}/js/custom.js"></script>
    <script src="{{config('app.url')}}/js/laravel.ajax.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="{{config('app.url')}}/js/dropzone.js"></script>
    <script src="{{config('app.url')}}/js/pagination.js"></script>
    <script src="{{config('app.url')}}/js/ajax.js"></script>
    <script src="{{config('app.url')}}/js/jquery.validate.min.js"></script>

    <script>
      $('#signup-form').click(function() {
          laravel.errors.errorBagContainer = $('#errors-signup');
      });

      $('#login-form').click(function() {
          laravel.errors.errorBagContainer = $('#error');
      });

      $('#login1-form').click(function() {
          laravel.errors.errorBagContainer = $('#error');
      });

      // redirect when review form is closed
      $('#rateInfo').on('hidden.bs.modal', function () {
        window.location.replace('/');
      });

      laravel.errors.showErrorsBag = true;
      laravel.errors.showErrorsInFormGroup = false;
    </script>

    @yield("scripts")
  </body>
</html>
