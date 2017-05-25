
@extends("layouts.main")
@section("content")
<div id="loading"><div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}" /></div></div>
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
				<h2>Customer Registration Form</h2>
				<form name="form" action="{{env('APP_URL')}}/add-property" method="POST">
					@if(session('error'))
					<div class="alert alert-danger">
						{{session('error')}}
					</div>
					@endif
					{{csrf_field() }}
				<span class="label-header">PROPERTY TO BE RENOVATED</span>
				<div class="col-xs-12">
					<div class="col-xs-4 no-padding-left">
						<label>Property Type</label>
						<div id="trade-btn-group" class="btn-group">
				            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
				            <ul class="dropdown-menu">
				              <li>
				                <input type="radio" id="a1" name="property-type" value="House">
				                <label for="a1">House</label>
				              </li>
				              <li>
				                <input type="radio" id="a2" name="property-type" value="Unit">
				                <label for="a2">Unit</label>
				              </li>
				              <li>
				                <input type="radio" id="a3" name="property-type" value="Apartment">
				                <label for="a3">Apartment</label>
				              </li>
				              <li>
				                <input type="radio" id="a4" name="property-type" value="Land">
				                <label for="a4">Land</label>
				              </li>
				              <li>
				                <input type="radio" id="a5" name="property-type" value="Townhouse">
				                <label for="a5">Townhouse</label>
				              </li>
				              <li>
				                <input type="radio" id="a6" name="property-type" value="Other">
				                <label for="a6">Other</label>
				              </li>
				            </ul>
				        </div>

						<label>Number of Bedrooms</label>
						<input type="text" name="number-rooms">
						<label>Post Code</label>
						<input type="text" name="post-code">
						<input type="hidden" name="commission" value="20">
					</div>
					<div class="col-xs-4">
						<label>Address</label>
						<input type="text" name="property-address">
						<label>Suburb</label>
                        <select id="select-state" name="suburb" class="demo-default"
                                class="required-input">
                        </select>
						<label>State</label>
						<div id="state-btn-group" class="btn-group">
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
				        


					</div>

					<div class="col-xs-4 no-padding-right price">
						<label>Value of the Property</label>
						<input type="text" name="value-from" placeholder="$" style="width: 47%" required> to <input type="text" name="value-to" placeholder="$" style="width: 47%" required>
						<div class="radio-btn" style="margin-top: 16px">
				        	<label class="radio">Is the Property Currently Leased? </label>
							<div class="radio-select"><input type="radio" name="leased" value="yes"> Yes </div>
							<div class="radio-select"> <input type="radio" name="leased" value="no"> No </div>
				        </div>
						<label>Anything Specific we need to know?</label>
						<textarea name="more-details" placeholder="" class="no-top" style="height: 145px;" maxlength="10000"></textarea>
						

					</div>
				</div>
				<span class="label-header">PERSONAL DETAILS</span>

				<div class="col-xs-12">
					<div class="col-xs-4 no-padding-left">
						<label>Name</label>
						<input type="text" name="name" disabled value="{{$user['name']}}" class="disabled">
						<label>Email Address</label>
						<input type="text" name="email" disabled value="{{$user['email']}}" class="disabled">
					</div>
					<div class="col-xs-4">
						<label>Address</label>
						<input type="text" name="address" required>
						<!-- <label>Username</label>
						<input type="text" name="username"> -->
					</div>

					<div class="col-xs-4 no-padding-right">
						<label>Phone Number</label>
						<input type="text" name="phone" required>
						<!-- <label>Password</label>
						<input type="password" name="password" disabled value="******" class="disabled"> -->
					</div>
				</div>

				<span class="label-header">Agent Selection</span>

				<div class="col-xs-12" id="agencyList"></div>
                <div class="col-xs-12" id="nearbyAgencyList"></div>
				<div class="col-xs-3 col-xs-offset-9">
					<button class="btn hs-primary" id="submit" disabled>NEXT <span class="icon icon-arrow-right"></span></button>
					<div class="agreement customer">
						<input type="checkbox" id="terms"> I accept the <a target="_blank" href="{{env('APP_URL')}}/legal/terms-conditions">Terms and Condition</a>
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

     checker.onchange = function () {

         btn.disabled = !this.checked;


     };

     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': '{{ csrf_token() }}'
         },
     });

     $('#select-state').selectize({
         maxItems: 1,
         maxOptions: 10,
         valueField: 'value',
         searchField: ['name', 'id'],
         labelField: 'name',
         options: [],
         sortField: 'text',
         create: false,
         render: {
            option: function(item, escape) {
                return '<div class="option" data-selectable="" data-value="'+item.id+''+item.name+'">'+item.name+' ('+item.id+')</div>';
            }
         },
         load: function(query, callback) {
	         console.log(query);
             if (!query.length) return callback();
             $.ajax({
                 url: '{{ url('tradesman/search-suburb') }}',
                 type: 'GET',
                 data: {
                    query: query
                 },
                 error: function() {
                    callback();
                 },
                 success: function(res) {
                    callback(res.suburbs);
                    console.log('results: ', res);
                }
             });
         },
         onChange: function(value) {

             if (typeof value == "undefined" || value == null ) {
                return;
             }

             var selectize = $('#select-state').selectize();
             var length = value.length;

             $.ajax({
                 method:'POST',
                 url:'{{ url('/agency-list') }}',
                 data:{
                     data:value
                 },
                success: function(data) {

    			  $( ".option" ).addClass('hidden');

                  if(data['search'].length != 0){
                      $( "#agencyList").html('<span style=" margin: 20px 0; font-size: 13px; font-style: italic; color: #0f70b7;">Agencies in '+ data['term'] +': </span></br>');
                    for (var i in data['search']){
               				$( "#agencyList" ).append( '<span class="option"><input type="radio" value="' + data['search'][i].id +'" name="agent"> <span class="checklist-label"> '+ data['search'][i].name +' </span> ' );
               			}
                  } else {
                      $( "#agencyList").html('<span style=" margin: 20px 0; font-size: 13px; font-style: italic; color: #0f70b7;">No agencies listed under selected suburb " '+ data['term'] +'"</span></br>');
                  }

                  if (data['nearby'].length != 0) {
                    $("#nearbyAgencyList").html('</br><span style=" margin: 20px 0; font-size: 13px; font-style: italic; color: #0f70b7;">Nearby Agencies: </span></br>');
                    for (var i in data['nearby']) {
           				$( "#nearbyAgencyList" ).append( '<span class="option"><input type="radio" value="' + data['nearby'][i].id +'" name="agent"> <span class="checklist-label"> '+ data['nearby'][i].name +' ('+ data['nearby'][i].suburb +') </span> ' );
           			}
                  } else {
                      $( "#nearbyAgencyList").html('</br><span style=" margin: 20px 0; font-size: 13px; font-style: italic; color: #0f70b7;">No nearby agencies listed.</span></br>');
                  }
                    $( "#nearbyAgencyList" ).append('</br></br><input type="checkbox" value="1" name="agent"> <span class="checklist-label"> I am ready for an agent, but there are none available. </span><span class="option"><input type="checkbox" value="0" name="agent"> <span class="checklist-label"> I am not ready to engage an agent yet. </span><span class="option">');
         		},
         		error: function(data) {
         			$( ".option" ).addClass('hidden');
         			$( "#agencyList" ).append( '<span class="option checklist-label">No agency listed under ' + suburb + ' yet<span class="checklist-label">' );
                }
            });
        },
        onDelete: function(values) {
            $('#select-state').selectize()[0].selectize.clearOptions();
        }
     });

     jQuery.validator.addMethod('positionsRequired', function(value, element){

         if(typeof value == "undefined" || value == null || value == ""){

             $('.selectize-control .selectize-input').addClass('error');

             return false;
         }

         $('.selectize-control .selectize-input').removeClass('error');
         return true;

     });

     jQuery.validator.addMethod('tradeRequired', function(value, element){

         if (typeof value == "undefined" || value == null || value == "") {

            $('#trade-btn-group').addClass('error');
             return false;
         }

         $('#trade-btn-group').removeClass('error');
         return true;

     });

     jQuery.validator.addMethod('stateRequired', function(value, element){

         if (typeof value == "undefined" || value == null || value == "") {

            $('#state-btn-group').addClass('error');
             return false;
         }

         $('#state-btn-group').removeClass('error');
         return true;

     });

     var validator = $('form[name=form]').validate({
         errorPlacement: function (error, element) {
             //console.log('error: ', error);
             //console.log('element: ', element);
         },
         ignore: '',
         rules:{
             'suburb':{
                 positionsRequired:true
             },
             'property-type': {
                 tradeRequired:true
             },
             'state': {
                stateRequired:true
             }
         }
         /*submitHandler: function(form) {





         }*/
     });

     console.log('validator', validator);

 </script>
@stop
