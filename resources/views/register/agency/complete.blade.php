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
                    <!-- <li><a href="#" data-toggle="modal" data-target="#signup">Signup Me Up!</a></li> -->
                    
                     @if(Sentinel::check())
                     <li><a>Hi, {{Sentinel::getUser()->name}}</a></li>
                    @else
                      <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                    @endif
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="main-nav">
                  <ul>
                    @if(Sentinel::check())
                    <li><span class="icon icon-logout-dark"></span>
                      <form action="logout" method="POST" id="logout-form">
                        {{csrf_field() }}
                        <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
                      </form>
                    </li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="">Profile</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
                    @else
                    <li><span class="icon icon-customer-dark"></span><a href="customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
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
			<div class="col-xs-12 form-box complete">
				<h2>Congratulations!</h2>
				<p>Welcome to House Stars. You are now on your way to selling more property. </br> You can then start customizing your profile to suit your taste, and win more listings.</p>
				<p>Click the button below to view your profile.</p>
				<a class="btn hs-primary" href="dashboard/agency/profile"><span class="icon icon-summary"></span> GO TO MY PROFILE</a>
			</div>
		</div>
	</div>
</section>
 @endsection

 @section('scripts')
     <script src="js/autocomplete.js"></script>
@stop