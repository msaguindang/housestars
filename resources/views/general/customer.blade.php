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
                     <li><a href="{{env('APP_URL')}}/profile">Hi, {{Sentinel::getUser()->name}}</a></li>
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
                      <li class="active"><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @else
                      <li class="active"><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>

    <section id="featured-video">
      <div class="container">
        <div class="row">
          <iframe width="100%" height="530" src="https://www.youtube.com/embed/2nRhVpc9F3I" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </section>

    <section id="why-sign-up">
      <div class="container">
        <div class="row section-title">
          <h2 class="wide"><span class="icon icon-left-bar"></span>Why Sign Up with HOUSESTARS.COM.AU<span class="icon icon-right-bar"></span></h2>
         <span class="separator"></span>
         <p>House Stars has been developed to maximize the return on selling your property. It uses tried-and-tested methods , as well as modern technology to track your progress and help you get the best results for your sale.</p>
        </div>
        <div class="row widget">
          	<div class="col-xs-6">
          		<div class="widget-item">
          			<div class="col-xs-4">
          				<span class="icon icon-people"></span>
          			</div>
          			<div class="col-xs-8">
          				<h3>Get the best people working for you</h3>
          				<p>Teamwork makes the dream work! Our agents, trades and services have all been used by other people in your position, and rated to show you who is good and who is great! This means that you can select only the best professionals for your project and avoid any nasty surprises. By rating their performance, you help others after you to make the right choice.</p>
          			</div>
          		</div>
          		<div class="widget-item">
          			<div class="col-xs-4">
          				<span class="icon icon-value"></span>
          			</div>
          			<div class="col-xs-8">
          				<h3>Sell for more</h3>
          				<p>The absolute key to getting the best results is to have the buyer fall in love with the property. When this happens, they will pay much more than what the true value of the property is worth, because they "just love it!" By using a great agent, and smart renovating decisions, you can reach amazing outcomes.</p>
          			</div>
          		</div>
          	</div>
          	<div class="col-xs-6">
          		<div class="widget-item">
          			<div class="col-xs-4">
          				<span class="icon icon-sell-more"></span>
          			</div>
          			<div class="col-xs-8">
          				<h3>Increase the Value of Your Property</h3>
          				<p>You want to get the best results when selling your house right? A tidy garden, some new light fittings and a touch-up with some paint can add amazing value to your property. Spend just a few thousand dollars on renovation, and you could see thousands more added to the sell price of your house. Why would you do it any other way?</p>
          			</div>
          		</div>
          		<div class="widget-item">
          			<div class="col-xs-4">
          				<span class="icon icon-big-discount"></span>
          			</div>
          			<div class="col-xs-8">
          				<h3>The Biggest Discounts Around</h3>
          				<p>"The money you spend preparing your house for sale is returned to you once the sale is complete. It's the best decision you can make when selling your home. The best Agents, the best trades, the highest sell price and the biggest discounts.... Four reasons to sell your property with House Stars. <a href="#" class="content-hyperlink">See Terms and Conditions.</a></p>
          			</div>
          		</div>
          	</div>
        </div>
      </div>
    </section>

    <section id="savings-calculator" class="blue-area">
      <div class="container">
        <div class="row section-title">
         <h2 class="wide"><span class="icon icon-left-bar-white"></span>Savings Estimation Calculator<span class="icon icon-right-bar-white"></span></h2>
        </div>
        <div class="calculator">
        	<form id="savingsCalc">
            {{csrf_field()}}
        		<div class="col-xs-4">
        			<label>Name</label>
        			<input type="text" name="name">
        			<label>Suburb</label>
        			<input type="text" name="suburb">
        		</div>
        		<div class="col-xs-4">
        			<label>Email Address</label>
        			<input type="text" name="email">
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
        		</div>
        		<div class="col-xs-4">
        			<label>Phone Number</label>
        			<input type="text" name="phone">
        			<label>Estimated Selling Price</label>
               <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                    <ul class="dropdown-menu">
                    <li>
                      <input type="radio" id="any" name="any" value="any">
                      <label for="any">Any Price</label>
                    </li>
                    <li>
                      <input type="radio" id="b1" name="estimated-price" value="$700,000 - $800,000">
                      <label for="b1">$700,000 - $800,000</label>
                    </li>
                    <li>
                      <input type="radio" id="b2" name="estimated-price" value="$800,000 - $900,000">
                      <label for="b2">$800,000 - $900,000</label>
                    </li>
                    <li>
                      <input type="radio" id="b3" name="estimated-price" value="$1,000,000 - $1,100,000">
                      <label for="b3">$1,000,000 - $1,100,000</label>
                    </li>
                    <li>
                      <input type="radio" id="b4" name="estimated-price" value="$1,200,000 - $1,300,000">
                      <label for="b4">$1,200,000 - $1,300,000</label>
                    </li>
                    <li>
                      <input type="radio" id="b5" name="estimated-price" value="$1,400,000 - $1,500,000">
                      <label for="b5">$1,400,000 - $1,500,000</label>
                    </li>
                    <li>
                      <input type="radio" id="b6" name="estimated-price" value="$1,600,000 - $1,800,000">
                      <label for="b6">$1,600,000 - $1,800,000</label>
                    </li>
                    <li>
                      <input type="radio" id="b7" name="estimated-price" value="$1,900,000 - $2,000,000">
                      <label for="b7">$1,900,000 - $2,000,000</label>
                    </li>

                  </ul>
              </div>
        		</div>
        		<div class="col-xs-4 col-xs-offset-4">
        			<button class="btn-calculator"><span class="icon icon-calculate"></span> See Results <span class="icon icon-arrow-right"></span></button>
        		</div>
        	</form>
        </div>
      </div>
    </section>

    <section id="suburb-availability">
      <div class="container">
        <div class="row">
          <div class="row section-title">
              <h2 class="narrower"><span class="icon icon-left-bar"></span>View Local Agents<span class="icon icon-right-bar"></span></h2>
              <span class="separator"></span>
          </div>
          <div class="col-xs-6 col-xs-offset-3">
            <p>House Stars has been developed to maximize the return on selling your property. It uses trid-and-tested methods, as well as modern technology to track your progress and help you get the best results for your sale.</p>
            <form action="{{env('APP_URL')}}/search/agency" method="POST">
                {{csrf_field()}}
                <input type="text" name="term" placeholder="Enter Postcode" class="search" onchange="this.form.submit()">
            </form>
          </div>
        </div>
      </div>
    </section>

@endsection
