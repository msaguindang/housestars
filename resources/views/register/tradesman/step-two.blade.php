
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
			<span class="progress-line" style="width: 360px"></span>
			<span class="icon icon-payment" ></span>
			<span class="progress-line" style="width: 139px"></span>
		</div>
		<div class="row label">
			<span class="completed" style="margin-left: 140px;">Add Agents</span>
			<span class="completed" style="margin-left: 355px;">Payment Method</span>
			<span style="margin-left: 330px;">Review Preferences</span>
		</div>
	</div>
</section>

<section id="sign-up-form">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 form-box no-padding payment">

					<form name="form" action="{{env('APP_URL')}}/add-payment" method="POST">

					{{csrf_field() }}
				<div class="col-xs-6 padding-40">
					<h2>Add Payment Method</h2>
					@if(session('error'))
					<div class="alert alert-danger">
						{{session('error')}}
					</div>
					@endif
					<label>Name on Card</label>
					<input type="text" name="full-name" required>
					<label>Card Number</label>
					<input type="text" name="number" required>
					<div class="col-xs-6 no-padding-left">
						<label>Expiry Date</label>
						<div class="btn-group" style="width: 40%">
			           <input type="text"  name="exp_month" maxlength="2" required>
			        </div> / <div class="btn-group" style="width: 50%">
			            <input type="text" name="exp_year" maxlength="4" required>
			        </div>
					</div>
					<div class="col-xs-6 no-padding-right">
						<label>CVV</label>
						<input type="text" name="cvc" required>
					</div>
					<span class="spacing"></span>
					<input type="radio" name="subscription" value="yearly"> Pay $550 for a 12 month subscription </br>
					<input type="radio" name="subscription" value="monthly"> Pay an ongoing fee of $50 per month
				    <br/>
                    <a href="/register/tradesman/step-one" class="btn hs-primary" style="width:130px;padding:8px 15px 8px 30px;text-align:right;"> <span class="icon icon-arrow-left" style="margin-left:-20px;"></span> Back </a>
                </div>
				<div class="col-xs-6 border-left padding-40">
					<h2>Add Billing Address</h2>
					<label>Address</label>
					<input type="text" name="address" required>
					<label>Suburb</label>
					<div class="btn-group">
						<select id="select-suburb" name="suburb"  class="demo-default plain" required></select>
			        </div>
					<label>State</label>
					<div class="btn-group">
						<select id="select-state" name="state"  class="demo-default plain" required>
							<option value="New South Wales">NEW SOUTH WALES</option>
							<option value="Queensland">QUEENSLAND</option>
							<option value="South Australia">SOUTH AUSTRALIA</option>
							<option value="Tasmania">TASMANIA</option>
							<option value="Victoria">VICTORIA</option>
							<option value="Western Australia">WESTERN AUSTRALIA</option>
						</select>
			        </div>
			        <button class="btn hs-primary">SUBMIT <span class="icon icon-arrow-right"></span></button>
			    </form>
			</div>
		</div>
	</div>
</section>


 @endsection


 @section('scripts')
 <script type="text/javascript">
 $(function() {
    $('#select-state').selectize();
 });
 </script>
 <script type="text/javascript">
     $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': '{{ csrf_token() }}'
         },
     });

     $('#select-suburb').selectize({
         maxItems: 1,
         valueField: 'value',
         searchField: ['name', 'id'],
         labelField: 'name',
         sortField: 'text',
         create: false,
         render: {
             option: function(item, escape) {
                 return '<div class="option" data-selectable="" data-value="'+item.id+''+item.name+'">'+item.name+' ('+item.id+')</div>';
             }
         },
         load: function(query, callback) {
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
                     console.log('results: ', res);
                     callback(res.suburbs);
                     //callback(res.repositories.slice(0, 10));
                 }
             });
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

         if(typeof value == "undefined" || value == null || value == ""){

             console.log('undefined trade');
             $('#trade-btn-group').addClass('error');

             return false;
         }

         $('#trade-btn-group').removeClass('error');
         return true;

     });

     var validator = $('form[name=form]').validate({
         errorPlacement: function (error, element) {
             //console.log('error: ', error);
             //console.log('element: ', element);
         },
         ignore: '',
         rules:{
             'positions[]':{
                 positionsRequired:true
             },
             trade: {
                 tradeRequired:true
             }
         }
         /*submitHandler: function(form) {





         }*/
     });

     console.log('validator', validator);

 </script>
@stop
