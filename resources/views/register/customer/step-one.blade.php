
@extends("layouts.main")
@section("content")
<div id="loading"><div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}" /></div></div>

<header id="header" class="animated">
        <div class="container">
          <div class="row">
            <div class="col-xs-3 branding">
              <a href="/"><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
            </div>
            <div class="col-xs-7 col-xs-offset-2 navigation">
              <div class="row top-links">
                <div class="customer-care">
                  <p><span class="label">Call Customer Care </span><a href="tel:0404045597" class="number">0404045597</a></p>
                </div>
                <div class="nav-items">
                  <ul>
                    <!-- <li><a href="#" data-toggle="modal" data-target="#signup">Signup Me Up!</a></li> -->
                    <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="main-nav">
                  <ul>
                    <li><span class="icon icon-customer-dark"></span><a href="/customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="/trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="/agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>

<section id="progress-bar" class="header-margin">
	<div class="container">
		<div class="row">
			<span class="progress-line completed" style="width: 300px"></span>
			<span class="icon icon-additional-info-completed"></span>
			<span class="progress-line" style="width: 464px"></span>
			<span class="icon icon-payment" ></span>
			<span class="progress-line" style="width: 300px"></span>
		</div>
		<div class="row label">
			<span class="completed" style="margin-left: 275px;">Additional Information</span>
			<span style="margin-left: 443px;">Confirmation</span>
		</div>
	</div>
</section>

<section id="sign-up-form">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 form-box" style="padding: 40px 25px;">
				<h2>Vendors Registration Form</h2>
				<form action="/add-property" method="POST">
					@if(session('error'))
					<div class="alert alert-danger">
						{{session('error')}}
					</div>
					@endif
					{{csrf_field() }}
				<span class="label-header">Property to be sold</span>
				<div class="col-xs-12">
					<div class="col-xs-4 no-padding-left">
						<label>Property Type</label>
						<div class="btn-group">
				            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
				            <ul class="dropdown-menu">
				              <li>
				                <input type="radio" id="a1" name="property-type" value="Condominium">
				                <label for="a1">Condominium</label>
				              </li>
				              <li>
				                <input type="radio" id="a2" name="property-type" value="Commercial">
				                <label for="a2">Commercial</label>
				              </li>
				              <li>
				                <input type="radio" id="a3" name="property-type" value="Apartment">
				                <label for="a3">Apartment</label>
				              </li>
				              <li>
				                <input type="radio" id="a4" name="property-type" value="Foreclosures">
				                <label for="a4">Foreclosures</label>
				              </li>
				              <li>
				                <input type="radio" id="a5" name="property-type" value="Development">
				                <label for="a5">Development</label>
				              </li>
				              <li>
				                <input type="radio" id="a6" name="property-type" value="House">
				                <label for="a6">House</label>
				              </li>
				              <li>
				                <input type="radio" id="a7" name="property-type" value="Land">
				                <label for="a7">Land</label>
				              </li>
				            </ul>
				        </div>
						
						<label>Number of Bedrooms</label>
						<input type="text" name="number-rooms">
						<label>Post Code</label>
						<input type="text" name="post-code">
					</div>
					<div class="col-xs-4">
						<label>Suburb</label>
						<div class="btn-group">
				            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
				            <ul class="dropdown-menu">
				            @php($x = 0)
				            @foreach ($suburbs as $suburb)
				              <li  onclick="getAgency('{{ csrf_token() }}', '{{$suburb->id}}{{$suburb->name}}')">
				              	<label for="b{{$x}}">{{ $suburb->name }}</label>
				                <input type="radio" id="b{{$x}}" name="suburb" value="{{ $suburb->name }}">
				              </li>
				              @php($x++)
				            @endforeach
				            </ul>
				        </div>
						<label>State</label>
						<div class="btn-group">
				            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
				            <ul class="dropdown-menu">
				              <li>
				                <input type="radio" id="c1" name="state" value="NEW SOUTH WALES">
				                <label for="c1">NEW SOUTH WALES</label>
				              </li>
				              <li>
				                <input type="radio" id="c2" name="state" value="QUEENSLAND">
				                <label for="c2">QUEENSLAND</label>
				              </li>
				              <li>
				                <input type="radio" id="c3" name="state" value="SOUTH AUSTRALIA">
				                <label for="c3">SOUTH AUSTRALIA</label>
				              </li>
				              <li>
				                <input type="radio" id="c4" name="state" value="TASMANIA">
				                <label for="c4">TASMANIA</label>
				              </li>
				              <li>
				                <input type="radio" id="c5" name="state" value="VICTORIA">
				                <label for="c5">VICTORIA</label>
				              </li>
				              <li>
				                <input type="radio" id="c6" name="state" value="WESTERN AUSTRALIA">
				                <label for="c6">WESTERN AUSTRALIA</label>
				              </li>
				            </ul>
				        </div>
				        <div class="radio-btn">
				        	<label class="radio">Is the Property Currently Leased? </label>
							<div class="radio-select"><input type="radio" name="leased" value="yes"> Yes </div>
							<div class="radio-select"> <input type="radio" name="leased" value="no"> No </div>
				        </div>
						

					</div>

					<div class="col-xs-4 no-padding-right">
						<label>Value of the Property</label>
						<input type="text" name="value-from" placeholder="$" style="width: 47%" required> to <input type="text" name="value-to" placeholder="$" style="width: 47%" required>
						<label>Anything Specific we need to know?</label>
						<textarea name="more-details" placeholder="" class="no-top" style="height: 145px;"></textarea>

					</div>					
				</div>
				<span class="label-header">Personal Details</span>

				<div class="col-xs-12">
					<div class="col-xs-4 no-padding-left">
						<label>Name</label>
						<input type="text" name="name" disabled value="{{$user['name']}}" class="disabled">
						<label>Email Address</label>
						<input type="text" name="email" disabled value="{{$user['email']}}" class="disabled">
					</div>
					<div class="col-xs-4">
						<label>Address</label>
						<input type="text" name="address">
						<label>Username</label>
						<input type="text" name="username">
					</div>

					<div class="col-xs-4 no-padding-right">
						<label>Phone Number</label>
						<input type="text" name="phone">
						<label>Password</label>
						<input type="password" name="password" disabled value="******" class="disabled">
					</div>					
				</div>

				<span class="label-header">Agent Selection</span>

				<div class="col-xs-12" id="agencyList"></div>
				<div class="col-xs-3 col-xs-offset-9">
					<button class="btn hs-primary" id="submit" disabled>NEXT <span class="icon icon-arrow-right"></span></button>
					<div class="agreement">
						<input type="checkbox" id="terms"> I accept the <a href="#">Terms and Condition</a>
					</div>
				<div>
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
     	  $(document).ready(function() {


     	  });

     	function getAgency(token, suburb){

        	$.ajax({
	          url: '/agency-list',
	          data: {'_token': token, 'suburb': suburb},
	          type: 'POST',
	          success: function(data){
	          	$( ".option" ).addClass('hidden');
	          	
	          	for (var i in data){
	          		$( "#agencyList" ).append( '<span class="option"><input type="radio" value="' + data[i].id +'" name="agent"> <span class="checklist-label"> '+ data[i].name +' </span> ' );
	          	}

	          	console.log(data);
	          	$( "#agencyList" ).append('<span class="option"><input type="radio" value="0" name="agent"> <span class="checklist-label"> I am not ready to engage an agent yet. </span>');
	          	
	          },
	          error: function(data){
	          	$( ".option" ).addClass('hidden');
	          	$( "#agencyList" ).append( '<span class="option checklist-label">No agency listed under ' + suburb + ' yet<span class="checklist-label">' );
	          }
	        });

     	}
     </script>
@stop