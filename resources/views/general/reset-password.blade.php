  @extends("layouts.main")
  @section("content")
    <header id="header" class="animated">
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
                <div class="nav-items">
                  <ul>
                    <!-- <li><a href="#" data-toggle="modal" data-target="#signup">Signup Me Up!</a></li> -->
                    
                     @if(Sentinel::check())
                     <li><a>Hi, {{Sentinel::getUser()->name}}</a></li>
                    @else
                      <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                      <li><a href="#" data-toggle="modal" data-target="#signup">Signup</a></li>
                    @endif
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="main-nav">
                  <ul>
                    @if(Sentinel::check())
                    <li><span class="icon icon-logout-dark"></span>
                      <form action="{{env('APP_URL')}}/logout" method="POST" id="logout-form">
                        {{csrf_field() }}
                        <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
                      </form>
                    </li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/profile">Profile</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="{{env('APP_URL')}}/">Home</a></li>
                    @else
                    <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="{{env('APP_URL')}}/">Home</a></li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>

  <section id="sign-up-form" class="header-margin">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 form-box">
        <form id="resetPassword" action="" method="POST">
          {{csrf_field() }}
        <div class="form-desc">
          <h2>Set your new Password</h2>
          <p>You have successfully been identified.</p>
          <p>You may now set your new password. Your account will be enabled with this new password.</p>
          <p>Password must contain at least 7 characters and a special character.</p>
        </div>
        <div class="col-xs-4">
         
        </div>
        <div class="col-xs-4">
          @if(count($errors)>0)
            <div id="msg" style="padding-bottom: 0;">
            </br>
              @foreach($errors->all() as $error)
                <span class="error">{{$error}}</span></br>
              @endforeach
            </div>
          @endif
          <label>New Password</label>
          <input type="password" name="password">
          <label>Confirm Password</label>
          <input type="password" name="password_confirmation">
          <button class="btn hs-primary" style="width: 100%; text-align: center; margin-top: 30px;">Reset Password</button>
        </div>
        <div class="col-xs-4">
          
        </div>
      </form>
      </div>
    </div>
  </div>
</section>

    @endsection