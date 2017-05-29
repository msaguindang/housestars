
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

<section id="progress-bar" class="header-margin tradesman">
	<div class="container">
		<div class="row">
			<span class="progress-line completed" style="width: 139px"></span>
			<span class="icon icon-completed"></span>
			<span class="progress-line completed" style="width: 360px"></span>
			<span class="icon icon-add-agents-completed"></span>
			<span class="progress-line completed" style="width: 360px"></span>
			<span class="icon icon-payment-completed" ></span>
			<span class="progress-line" style="width: 139px"></span>
		</div>
		<div class="row label">
			<span class="completed" style="margin-left: 140px;">Add Agents</span>
			<span class="completed" style="margin-left: 355px;">Payment Method</span>
			<span class="completed" style="margin-left: 330px;">Review Preferences</span>
		</div>
	</div>
</section>

<section id="sign-up-form">
	<div class="container">
		<div class="row">
			<form action="{{env('APP_URL')}}/charge" method="POST">
				{{csrf_field() }}
			<div class="col-xs-12 form-box" style="padding: 40px">
				<h2>Trade/Service Package</h2>
				<p>Please Review your details below. If you are happy that all of your details are correct, please click "Subscribe Now"</p>
				<div class="package-review row">
					<div class="col-xs-6">
						<div class="preview-label" style="width: 25%">
						</div>
						<div class="preview-value">
							<p><b>Email Address:</b> {{ $email }}</p>
							@foreach($userinfo as $info)
								@if($info->meta_name == 'business-name')
									<p><b>Business Name:</b> {{$info->meta_value}}</p>
								@elseif ($info->meta_name == 'trading-name')
									<p><b>Trading Name:</b> {{$info->meta_value}}</p>
								@elseif ($info->meta_name == 'charge-rate')
									<p><b>Charge Rate:</b> {{$info->meta_value}}</p>
								@endif
							@endforeach
							@if(count($trades))
								<p><b> Trade or Service: </b> {{ implode(', ', $trades)}} </p>
							@endif
						</div>
					</div>
					<div class="col-xs-5 tradesman">
						<div class="preview-total">
							<span class="icon icon-total"></span>
							@if($price == '550')
							<p> Total charges = <b>${{$price}} for a 12 month subscription</b></p>
							@else
							<p> Total charges = <b>${{$price}} for a 1 month subscription</b></p>
							@endif
						</div>
						<input type="hidden" name="plan" value="tradesman-{{$price}}">
						<p>Subscription will expired on <span class="blue">{{$expiry}}</span></p>
					</div>
				</div>

				<button class="btn hs-primary" style="margin-right: 22px;"><span class="icon icon-summary"></span> SUBSCRIBE NOW</button>
			</div>
		</form>
		</div>
	</div>
</section>

 @endsection

 @section('scripts')
     <script src="{{asset('js/jquery.repeater.js')}}"></script>
     <script src="{{asset('js/bootstrap-toggle.min.js')}}"></script>
     <script>
	    $(document).ready(function () {
	        $('.repeater').repeater({});
	    });
	</script>
@stop
