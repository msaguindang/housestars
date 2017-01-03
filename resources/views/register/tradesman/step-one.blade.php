
@extends("layouts.main")
@section("content")
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
			<span class="progress-line completed" style="width: 139px"></span>
			<span class="icon icon-additional-info-completed"></span>
			<span class="progress-line" style="width: 328px"></span>
			<span class="icon icon-add-agents"></span>
			<span class="progress-line" style="width: 360px"></span>
			<span class="icon icon-payment" ></span>
			<span class="progress-line" style="width: 139px"></span>
		</div>
		<div class="row label">
			<span class="completed" style="margin-left: 115px;">Additional Information</span>
			<span style="margin-left: 355px;">Payment Method</span>
			<span style="margin-left: 330px;">Review Preferences</span>
		</div>
	</div>
</section>

<section id="sign-up-form">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 form-box" style="padding: 40px 25px;">
				<h2>Tradesman Registration Form</h2>
				<div class="col-xs-8">
					<div class="col-xs-6 no-padding-left">
						<label>Business Name</label>
						<input type="text" name="">
						<label>Suburbs Working In  <span>(Enter the desired postcode and select suburbs)</span></label>
						<div class="btn-group">
				            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
				            <ul class="dropdown-menu">
				              <li>
				                <input type="radio" id="a1" name="suburbs" value="1" checked="">
				                <label for="a1">Option1</label>
				              </li>
				              <li>
				                <input type="radio" id="a2" name="suburbs" value="2">
				                <label for="a2">Option2</label>
				              </li>
				              <li>
				                <input type="radio" id="a3" name="suburbs" value="3">
				                <label for="a3">Option3</label>
				              </li>
				            </ul>
				        </div>
						<label>Trading Name</label>
						<input type="text" name="">
					</div>
					<div class="col-xs-6 no-padding-right">
						<label>Website</label>
						<input type="text" name="">
						<label>ABN</label>
						<input type="text" name="">
						<label>Normal Charge Rate</label>
						<input type="text" name="">

						
					</div>
					<label>Write Business Description</label>
					<textarea placeholder="" class="no-top"></textarea>
				</div>
				<div class="col-xs-4">
					<label>Trade or Service <span>(1 only)</span></label>
					<div class="btn-group">
			            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
			            <ul class="dropdown-menu">
			              <li>
			                <input type="radio" id="b1" name="trade" value="1" checked="">
			                <label for="b1">Option1</label>
			              </li>
			              <li>
			                <input type="radio" id="b2" name="trade" value="2">
			                <label for="b2">Option2</label>
			              </li>
			              <li>
			                <input type="radio" id="b3" name="trade" value="3">
			                <label for="b3">Option3</label>
			              </li>
			            </ul>
			        </div>
					<label>Promotion Code</label>
					<input type="text" name="">
				
					<button class="btn hs-primary" style="margin-top: 150px;">SUBMIT <span class="icon icon-arrow-right"></span></button>
					<div class="agreement">
						<input type="checkbox" id="inlineCheckbox1" value="option1"> I accept the <a href="#">Terms and Condition</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

 @endsection

 @section('scripts')
     <script src="js/autocomplete.js"></script>
@stop