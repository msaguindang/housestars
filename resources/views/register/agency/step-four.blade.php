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

<section id="progress-bar" class="header-margin">
	<div class="container">
		<div class="row">
			<span class="progress-line completed" style="width: 139px"></span>
			<span class="icon icon-completed"></span>
			<span class="progress-line completed"></span>
			<span class="icon icon-completed"></span>
			<span class="progress-line completed"></span>
			<span class="icon icon-completed"></span>
			<span class="progress-line completed"></span>
			<span class="icon icon-payment-completed"></span>
			<span class="progress-line" style="width: 139px"></span>
		</div>
		<div class="row label">
			<span class="completed" style="margin-left: 114px;">Additional Information</span>
			<span  class="completed" style="margin-left: 202px;">Add Agents</span>
			<span  class="completed" style="margin-left: 215px;">Payment Method</span>
			<span class="completed" style="margin-left: 195px;">Review Preferences</span>
		</div>
	</div>
</section>

<section id="sign-up-form">
	<form action="charge" method="POST">
		{{csrf_field() }}
	<div class="container">
		<div class="row">
				@if(session('error'))
					<div class="alert alert-danger">
						{{session('error')}}
					</div>
					@endif
			<div class="col-xs-12 form-box" style="padding: 40px">
				<h2>Agency Package</h2>
				<p>Please review the details below. If you are happy with your selection, click "Subscribe Now”</p>
				<div class="package-review row">
					<div class="col-xs-4">
						<div class="preview-label">
							<p>Business Name:</p>
							<p>Trading Name:</p>
							<p>Principal Name:</p>
							<p>Principal Phone:</p>
							<p>Principal Email:</p>
						</div>
						<div class="preview-value">
							@foreach($userinfo as $info)

								@if($info->meta_name == 'agency-name')
									<p>{{$info->meta_value}}</p>
								@elseif ($info->meta_name == 'trading-name')
									<p>{{$info->meta_value}}</p>
								@elseif ($info->meta_name == 'principal-name')
									<p>{{$info->meta_value}}</p>
								@elseif ($info->meta_name == 'phone')
									<p>{{$info->meta_value}}</p>
								@endif

							@endforeach

							<p>{{$email}}</p>
						</div>
					</div>
					<div class="col-xs-4">
						<div class="preview-label">
							<p>Position 1 Taken:</p>
							<p>Position 2 Taken:</p>
							<p>Position 3 Taken:</p>
							<p>Discount:</p>
						</div>
						<div class="preview-value">
							@foreach($positions as $position)
								<p>{{$position}} <span class="price"> = $2,000 per year</span></p>
							@endforeach

							@if(count($positions) > 2)
								<p>For 3 Positions = $1000 per year</p>
							@endif

							
						</div>
					</div>
					<div class="col-xs-4">
						<div class="preview-total">
						
							<input type="hidden" name="plan" value="agency-{{count($positions)}}">
							<span class="icon icon-total"></span> <p> Total Charges = <b>{{$price}} per year</b></p>
						</div>
						<p>Subscription will expired on <span class="blue">{{$expiry}}</span></p>
					</div>
				</div>
				
				<button class="btn hs-primary" style="margin-right: 22px;"><span class="icon icon-summary"></span> SUBSCRIBE NOW</button>
				<button class="btn hs-default close-btn"><span class="icon icon-close"></span> CANCEL</button>
			
			</div>
		</div>
	</div>
	</form>
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