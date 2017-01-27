
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
				<span class="label-header">Property to be sold</span>
				<div class="col-xs-12">
					<div class="col-xs-4 no-padding-left">
						<label>Property Type</label>
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
						
						<label>Number of Bedrooms</label>
						<input type="text" name="">
						<label>Post Code</label>
						<input type="text" name="">
					</div>
					<div class="col-xs-4">
						<label>Suburb</label>
						<div class="btn-group">
				            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
				            <ul class="dropdown-menu">
				              <li>
				                <input type="radio" id="b1" name="suburbs" value="1" checked="">
				                <label for="b1">Option1</label>
				              </li>
				              <li>
				                <input type="radio" id="b2" name="suburbs" value="2">
				                <label for="b2">Option2</label>
				              </li>
				              <li>
				                <input type="radio" id="b3" name="suburbs" value="3">
				                <label for="b3">Option3</label>
				              </li>
				            </ul>
				        </div>
						<label>State</label>
						<div class="btn-group">
				            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
				            <ul class="dropdown-menu">
				              <li>
				                <input type="radio" id="c1" name="suburbs" value="1" checked="">
				                <label for="c1">Option1</label>
				              </li>
				              <li>
				                <input type="radio" id="c2" name="suburbs" value="2">
				                <label for="c2">Option2</label>
				              </li>
				              <li>
				                <input type="radio" id="c3" name="suburbs" value="3">
				                <label for="c3">Option3</label>
				              </li>
				            </ul>
				        </div>
				        <div class="radio-btn">
				        	<label class="radio">Is the Property Currently Leased? </label>
							<div class="radio-select"><input type="radio" name="leased"> Yes </div>
							<div class="radio-select"> <input type="radio" name="leased"> No </div>
				        </div>
						

					</div>

					<div class="col-xs-4 no-padding-right">
						<label>Value of the Property</label>
						<input type="text" name="" placeholder="$" style="width: 47%"> to <input type="text" name="" placeholder="$" style="width: 47%">
						<label>Anything Specific we need to know?</label>
						<textarea placeholder="" class="no-top" style="height: 145px;"></textarea>

					</div>					
				</div>
				<span class="label-header">Personal Details</span>

				<div class="col-xs-12">
					<div class="col-xs-4 no-padding-left">
						<label>Name</label>
						<input type="text" name="">
						<label>Email Address</label>
						<input type="text" name="">
					</div>
					<div class="col-xs-4">
						<label>Address</label>
						<input type="text" name="">
						<label>Username</label>
						<input type="text" name="">
					</div>

					<div class="col-xs-4 no-padding-right">
						<label>Phone Number</label>
						<input type="text" name="">
						<label>Password</label>
						<input type="text" name="">
					</div>					
				</div>

				<span class="label-header">Agent Selection</span>

				<div class="col-xs-12">
					<input type="checkbox" id="inlineCheckbox1" value="option1"> <span class="checklist-label"> Mark Zuckerberg </span> 
					<input type="checkbox" id="inlineCheckbox1" value="option1"> <span class="checklist-label"> Bill Gates </span> 
					<input type="checkbox" id="inlineCheckbox1" value="option1"> <span class="checklist-label"> Elon Musk </span> 
					<input type="checkbox" id="inlineCheckbox1" value="option1"> <span class="checklist-label"> Donald Trump </span> 
					<input type="checkbox" id="inlineCheckbox1" value="option1"> <span class="checklist-label"> I am not ready to engage an agent yet. </span> 
				</div>
				<div class="col-xs-3 col-xs-offset-9">
					<button class="btn hs-primary" style="margin-top: 80px;">SUBMIT <span class="icon icon-arrow-right"></span></button>
					<div class="agreement">
						<input type="checkbox" id="inlineCheckbox1" value="option1"> I accept the <a href="#">Terms and Condition</a>
					</div>
				<div>
				
			</div>
		</div>
	</div>
</section>

 @endsection

 @section('scripts')
     <script src="js/autocomplete.js"></script>
@stop