@extends("layouts.main")
@section("content")

    <header id="header" class="animated desktop">
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

<section id="progress-bar" class="header-margin customer">
  <div class="container">
    <div class="row">
      <span class="progress-line completed" style="width: 300px"></span>
      <span class="icon icon-completed"></span>
      <span class="progress-line completed" style="width: 464px"></span>
      <span class="icon icon-payment-completed" ></span>
      <span class="progress-line" style="width: 300px"></span>
    </div>
    <div class="row label">
      <span class="completed" style="margin-left: 275px;">Additional Information</span>
      <span class="completed" style="margin-left: 443px;">Confirmation</span>
    </div>
  </div>
</section>

<section id="sign-up-form">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 form-box complete">
				<h2>Congratulations, {{$name}}!</h2>
				<p>Your registration is complete.</p></br>
				<p>You will shortly receive an email for your records, and if you have selected an agent, they will be in contact </br>with you soon. Please contact us if you have any questions along the way and we will be glad to help. You </br>can now view your profile page and start adding information.</p>
				<!-- <a href="#" class="btn hs-primary" style="padding: 13px; margin-right: 14px;"><span class="icon icon-summary"></span> DOWNLOAD CONTRACT</a> -->
        <a href="{{env('APP_URL')}}/profile" class="btn hs-primary" style="padding: 13px;"><span class="icon icon-summary"></span> VIEW PROCESSING PAGE</a>
			</div>
		</div>
	</div>
</section>

 @endsection

 @section('scripts')
     <script src="js/autocomplete.js"></script>
@stop
