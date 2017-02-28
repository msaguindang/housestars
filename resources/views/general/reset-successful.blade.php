  @extends("layouts.main")
  @section("content")
    <header id="header" class="animated">
        <div class="container">
          <div class="row">
            <div class="col-xs-3 branding">
              <a href=""><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
            </div>
            <div class="col-xs-7 col-xs-offset-2 navigation">
              <div class="row top-links">
                <div class="customer-care">
                  <p><span class="label">Call Customer Care </span><a href="tel:0404045597" class="number">0404045597</a></p>
                </div>
                <div class="nav-items">
                  <ul>
                    <li><a href="#" data-toggle="modal" data-target="#signup">Signup Me Up!</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="main-nav">
                  <ul>
                    <li><span class="icon icon-customer-dark"></span><a href="customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
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
        <div class="form-desc">
        </br></br>
          <h2>You successfully reset your password!</h2>
          <p>Your password has been changed successfully, please try to login in now.</p>
        </div>
        <div class="col-xs-4">
         
        </div>
        <div class="col-xs-4">
          <a class="btn hs-primary" style="width: 100%; text-align: center; margin-top: 30px;" href="#" data-toggle="modal" data-target="#login">Click here to Login</a>
        </div>
        <div class="col-xs-4">
          
        </div>
      </div>
    </div>
  </div>
</section>

    @endsection