@extends("layouts.main")
@section("content")
<div id="loading"><div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}" /></div></div>

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
<section id="progress-bar" class="header-margin">
	<div class="container">
		<div class="row">
			<span class="progress-line completed" style="width: 139px"></span>
			<span class="icon icon-review-completed"></span>
			<span class="progress-line"></span>
			<span class="icon icon-additional-info"></span>
			<span class="progress-line"></span>
			<span class="icon icon-add-agents"></span>
			<span class="progress-line"></span>
			<span class="icon icon-payment"></span>
			<span class="progress-line" style="width: 139px"></span>
		</div>
		<div class="row label">
			<span class="completed" style="margin-left: 114px;">Additional Information</span>
			<span style="margin-left: 202px;">Add Agents</span>
			<span style="margin-left: 215px;">Payment Method</span>
			<span style="margin-left: 195px;">Review Preferences</span>
		</div>
	</div>
</section>

<section id="sign-up-form">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 form-box">
				<form action="{{env('APP_URL')}}/add-info" method="POST">
					{{csrf_field() }}
				<h2>Agency Registration Form</h2>
				<div class="col-xs-4">
					<label>Agency Business Name</label>
					<input type="text" name="agency-name">
					<label>Agency Trading Name</label>
					<input type="text" name="trading-name">
					<label>Principal Name <span>(One Principal only as a point of contact)</span></label>
					<input type="text" name="principal-name">
					<label>Business Address</label>
					<input type="text" name="business-address">
				</div>
				<div class="col-xs-4">
					<label>Website</label>
					<input type="text" name="website">
					<label>Phone</label>
					<input type="number" name="phone">
					<label>ABN</label>
					<input type="text" name="abn" required>
					<label>Positions <span>(Enter the postcode of the suburd required)</span></label>
					<select id="select-state" name="positions[]" multiple  class="demo-default">
					@foreach ($suburbs as $suburb)
						@if($suburb->availability != '3')
					    <option value="{{ $suburb->availability }},{{ $suburb->id}}{{ $suburb->name }}">{{ $suburb->name }}</option>
					    @endif
					@endforeach

					</select>
				</div>
				<div class="col-xs-4">
					<label>Base Commission Charge</label>
					<input type="number" name="base-commission">
					<label>Marketing Budget</label>
					<input type="number" name="marketing-budget">
					<label>Sales Type</label>
					<div class="btn-group">
			            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
			            <ul class="dropdown-menu">
			              <li>
			                <input type="radio" id="b1" name="sales-type" value="Auction" checked="">
			                <label for="b1">Auction</label>
			              </li>
			              <li>
			                <input type="radio" id="b2" name="sales-type" value="Private Treaty">
			                <label for="b2">Private Treaty</label>
			              </li>
			              <li>
			                <input type="radio" id="b3" name="sales-type" value="Off Market">
			                <label for="b3">Off Market</label>
			              </li>
			              <li>
			                <input type="radio" id="b4" name="sales-type" value="Distressed Sale">
			                <label for="b4">Distressed Sale</label>
			              </li>
			              <li>
			                <input type="radio" id="b5" name="sales-type" value="Other">
			                <label for="b5">Other</label>
			              </li>
			            </ul>
			        </div>
			        <label>Review URL</label>
			        <input type="text" name="review-url">
					
					<button class="btn hs-primary" id="submit" disabled>NEXT <span class="icon icon-arrow-right"></span></button>
					<div class="agreement">
						<input type="checkbox" id="terms"> I accept the <a href="#">Terms and Condition</a>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</section>

 @endsection

 @section('scripts')
     <script type="text/javascript">
     	var checker = document.getElementById('terms');
     	var btn = document.getElementById('submit');

     	checker.onchange = function(){
     		btn.disabled = !this.checked;
     	}

		
$(function() {
     	$('#select-state').selectize({
					maxItems: 3
				});
     	});
	</script>
@stop