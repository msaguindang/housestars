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
			<span class="icon icon-completed"></span>
			<span class="progress-line completed"></span>
			<span class="icon icon-completed"></span>
			<span class="progress-line completed"></span>
			<span class="icon icon-add-agents-completed"></span>
			<span class="progress-line"></span>
			<span class="icon icon-payment"></span>
			<span class="progress-line" style="width: 139px"></span>
		</div>
		<div class="row label">
			<span class="completed" style="margin-left: 114px;">Additional Information</span>
			<span  class="completed" style="margin-left: 202px;">Add Agents</span>
			<span  class="completed" style="margin-left: 215px;">Payment Method</span>
			<span style="margin-left: 195px;">Review Preferences</span>
		</div>
	</div>
</section>

<section id="sign-up-form">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 form-box no-padding payment">
				
				<div class="col-xs-6 padding-40">
					<h2>Add Payment Method</h2>
					<label>Name on Card</label>
					<input type="text" name="">
					<label>Card Number</label>
					<input type="text" name="">
					<div class="col-xs-6 no-padding-left">
						<label>Expiry Date</label>
						<div class="btn-group" style="width: 40%">
			            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">MM<span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
			            <ul class="dropdown-menu">
			              <li>
			                <input type="radio" id="1" name="month" value="1" checked="">
			                <label for="1">01</label>
			              </li>
			              <li>
			                <input type="radio" id="2" name="month" value="2" checked="">
			                <label for="2">02</label>
			              </li>
			              <li>
			                <input type="radio" id="3" name="month" value="3" checked="">
			                <label for="3">03</label>
			              </li>
			              <li>
			                <input type="radio" id="4" name="month" value="4" checked="">
			                <label for="4">04</label>
			              </li>
			              <li>
			                <input type="radio" id="5" name="month" value="5" checked="">
			                <label for="5">05</label>
			              </li>
			              <li>
			                <input type="radio" id="6" name="month" value="6" checked="">
			                <label for="6">06</label>
			              </li>
			              <li>
			                <input type="radio" id="7" name="month" value="7" checked="">
			                <label for="7">07</label>
			              </li>
			              <li>
			                <input type="radio" id="8" name="month" value="8" checked="">
			                <label for="8">08</label>
			              </li>
			              <li>
			                <input type="radio" id="9" name="month" value="9" checked="">
			                <label for="9">09</label>
			              </li>
			              <li>
			                <input type="radio" id="10" name="month" value="10" checked="">
			                <label for="10">10</label>
			              </li>
			              <li>
			                <input type="radio" id="11" name="month" value="11" checked="">
			                <label for="11">11</label>
			              </li>
			              <li>
			                <input type="radio" id="12" name="month" value="12" checked="">
			                <label for="12">12</label>
			              </li>
			            </ul>
			        </div> / <div class="btn-group" style="width: 50%">
			            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">YYYY <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
			           <ul class="dropdown-menu">
			              <li>
			                <input type="radio" id="2017" name="year" value="2017" >
			                <label for="2017">2017</label>
			              </li>
			              <li>
			                <input type="radio" id="2018" name="year" value="2018" >
			                <label for="2018">2018</label>
			              </li>
			              <li>
			                <input type="radio" id="2019" name="year" value="2019" >
			                <label for="2019">2019</label>
			              </li>
			              <li>
			                <input type="radio" id="2020" name="year" value="2020" checked="">
			                <label for="2020">2020</label>
			              </li>
			              <li>
			                <input type="radio" id="2021" name="year" value="2021" checked="">
			                <label for="2021">2021</label>
			              </li>
			              <li>
			                <input type="radio" id="2022" name="year" value="2022" checked="">
			                <label for="2022">2022</label>
			              </li>
			              <li>
			                <input type="radio" id="2023" name="year" value="2023" checked="">
			                <label for="2023">2023</label>
			              </li>
			              <li>
			                <input type="radio" id="2024" name="year" value="2024" checked="">
			                <label for="2024">2024</label>
			              </li>
			              <li>
			                <input type="radio" id="2025" name="year" value="2025" checked="">
			                <label for="2017">2025</label>
			              </li>
			              <li>
			                <input type="radio" id="2026" name="year" value="2026" checked="">
			                <label for="2026">2026</label>
			              </li>
			            </ul>
			        </div>
					</div>
					<div class="col-xs-6 no-padding-right">
						<label>CVV</label>
						<input type="text" name="">
					</div>
				</div>
				<div class="col-xs-6 border-left padding-40">
					<h2>Add Billing Address</h2> 
					<label>Address</label>
					<input type="text" name="">
					<label>Suburb</label>
					<div class="btn-group">
			            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Select Suburb <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
			           <ul class="dropdown-menu">
			              <li>
			                <input type="radio" id="AP" name="suburb" value="Aarons Pass" >
			                <label for="AP">Aarons Pass</label>
			              </li>
			              <li>
			                <input type="radio" id="AB" name="suburb" value="Abbeyard" >
			                <label for="AB">Abbeyard</label>
			              </li>
			              <li>
			                <input type="radio" id="ABB" name="suburb" value="Abbotsford" >
			                <label for="ABB">Abbotsford</label>
			              </li>
			              <li>
			                <input type="radio" id="ABay" name="suburb" value="Abels Bay" checked="">
			                <label for="ABay">Abels Bay</label>
			              </li>
			              <li>
			                <input type="radio" id="AR" name="suburb" value="Abercrombie River" checked="">
			                <label for="AR">Abercrombie River</label>
			              </li>
			              <li>
			                <input type="radio" id="Af" name="suburb" value="Aberfeldie" checked="">
			                <label for="AF">Aberfeldie</label>
			              </li>
			            </ul>
			        </div>
					<label>State</label>
					<div class="btn-group">
			            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Select State <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
			           <ul class="dropdown-menu">
			              <li>
			                <input type="radio" id="NSW" name="state" value="New South Wales" >
			                <label for="NSW">New South Wales</label>
			              </li>
			              <li>
			                <input type="radio" id="Q" name="state" value="Queensland" >
			                <label for="Q">Queensland</label>
			              </li>
			              <li>
			                <input type="radio" id="SA" name="state" value="South Australia" >
			                <label for="SA">South Australia</label>
			              </li>
			              <li>
			                <input type="radio" id="T" name="state" value="Tasmania" checked="">
			                <label for="T">Tasmania</label>
			              </li>
			              <li>
			                <input type="radio" id="V" name="state" value="Victoria" checked="">
			                <label for="V">Victoria</label>
			              </li>
			              <li>
			                <input type="radio" id="WA" name="state" value="Western Australia" checked="">
			                <label for="WA">Western Australia</label>
			              </li>
			            </ul>
			        </div>
			        <button class="btn hs-primary">SUBMIT <span class="icon icon-arrow-right"></span></button>
				</div>
			</div>
		</div>
	</div>
</section>

 @endsection

 @section('scripts')
     <script src="js/autocomplete.js"></script>
@stop