	@extends("layouts.main")
	@section("content")
		<header id="header" class="animated hide sticky desktop">
				<div class="container">
					<div class="row">
						<div class="col-xs-3 branding">
							<a href="/"><img src="assets/logo-nav.png" alt="HouseStars Logo"></a>
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
											<li><a href="#" data-toggle="modal" data-target="#login" id="login-form">Login</a></li>
										@endif
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="main-nav">
									<ul>
										@if(Sentinel::check())
										<li><span class="icon icon-logout-dark"></span>
											<form action="/logout" method="POST" id="logout-form">
												{{csrf_field() }}
												<a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
											</form>
										</li>
										<li><span class="icon icon-tradesman-dark"></span><a href="/profile">Profile</a></li>
										<li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
										@else
										<li><span class="icon icon-customer-dark"></span><a href="/customer" >Customer</a></li>
										<li><span class="icon icon-tradesman-dark"></span><a href="/trades-services">Trades & Services</a></li>
										<li><span class="icon icon-agency-dark"></span><a href="/agency">Agency</a></li>
										<li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
										@endif
									</ul>
								</div>
							</div>
						</div>
					</div>
		</header>

		<section id="top-header" class="desktop">
			<div class="container">
				<div class="row">
					<div class="col-xs-7 col-xs-offset-5 navigation">
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
											<li><a href="#" data-toggle="modal" data-target="#login" id="login1-form">Login</a></li>
										@endif
									</ul>
								</div>
							</div>
					</div>
				</div>
			</div>
		</section>

		<section id="home-banner">
			<div class="container">
				<div class="row header desktop">
					<div class="col-xs-4 logo">
						<a href="/"><img src="assets/logo-header-home.png" alt="HouseStars Logo"></a>
					</div>
					<div class="col-xs-6 col-xs-offset-2 main-nav">
						<ul>
							@if(Sentinel::check())
								<li><span class="icon icon-logout"></span>
									<form action="/logout" method="POST" id="logout-form">
										{{csrf_field() }}
										<a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
									</form>
								</li>
								<li><span class="icon icon-tradesman"></span><a href="/profile">Profile</a></li>
							@else
								<li><span class="icon icon-customer"></span><a href="/customer" >Customer</a></li>
								<li><span class="icon icon-tradesman"></span><a href="/trades-services">Trades & Services</a></li>
								<li><span class="icon icon-agency"></span><a href="/agency">Agency</a></li>
							@endif
									</ul>
					</div>
				</div>
				<div class="rate-trade-services desktop">
					<a href="#" id="rate" data-toggle="modal" data-target="#rating"><img src="assets/img-banner-rate.png" alt="Rate Trade & Services" class="animated"></a>
				</div>
				<div class="row highlight">
					<div class="col-xs-6 col-xs-offset-3 highlight-text">
						<h1 class="animated fadeInRight">Sell your property smarter</h1>
						<p class="animated fadeInLeft">The value spent on trades and services is deducted from the commission charged by the agent. Its smart, simple and can save you thousands. Scroll down to find out more.</p>
					</div>
				</div>
				<div class="row tooltip-nav">
					<div class="col-xs-11 col-xs-offset-1 tooltip-items">
						<ul>
							<li class="search-local animated fadeInDown"><span class="icon icon-search-local mobile-hidden"></span><a href=""> Search Local Trades & Services <span class="icon icon-arrow-right"></span></a></li>
							<li class=" calculate-savings animated fadeInDown"><span class="icon icon-calculate-savings mobile-hidden"></span><a href="#" data-toggle="modal" data-target="#rateTradesman">Calculate My Savings <span class="icon icon-arrow-right"></span></a></li>
								@if(!Sentinel::check())
								 <li class="sign-up animated fadeInDown"><span class="icon icon-sign-up mobile-hidden"></span><a href="" data-toggle="modal" data-target="#signup" id="signup-form">Sign Me Up <span class="icon icon-arrow-right"></span></a></li>
								@endif
						</ul>
					</div>
				</div>
				<div class="rate-trade-services tablet">
					<a href="#" id="rate" data-toggle="modal" data-target="#rating"><img src="assets/img-banner-rate.png" alt="Rate Trade & Services" class="animated"></a>
				</div>
				<div class="banner-ad desktop">
					<img src="assets/banner-ad.png" alt="Banner Ad">
				</div>
			</div>
		</section>

		<div class="horizontal-bg desktop"></div>

		<section id="how-it-works" class="home">
      <div class="container">
        <div class="row section-title">
          <h2 class="wide"><span class="icon icon-left-bar mobile-hidden"></span>How Housestars.com.au Works <span class="icon icon-right-bar mobile-hidden"></span></h2>
          <span class="separator"></span>
          <p>House Stars is a great way to sell your property. By using local trades and services to prepare your house for sale, and by hiring the best agents to represent you, you can be sure you'll get the best results, at the cheapest prices.</p>
        </div>
        <div class="row steps">
          <div class="left">
            <!---- STEP ONE ---->
            <div class="step-image stepOne desktop">
              <img src="assets/img-hand.png" alt="Step 1: Signup">
            </div>

            <!---- STEP 2 ---->
            <div class="step-description stepTwo animated desktop">
              <div class="description-box-right">
                <h3>Hire Tradesman to Renovate your Property</h3>
                <p>Once you have signed up, you can start using the trades and services on the site, all rated and reviewed by house owners like you, to work on your property. You organise the tradies, the work is performed and you pay them as you normally would. Then you simply add the receipts to your process page and leave a rating and a comment about them for future users to see. The total of the receipts will be the savings you receive when you sell your property using one of the agents listed on the site. </p>
                <p class="highlight-small">(See our faq for details about how much you can save)</p>
              </div>
            </div>

            <!---- STEP 3 ---->
            <div class="step-image stepThree desktop">
              <img src="assets/img-agent.png" alt="Step 3: Engage an Agent">
            </div>

            <!---- STEP 4 ---->
            <div class="step-description stepFour animated desktop">
              <div class="description-box-right">
                <h3>Sign Up</h3>
                <p>Once the property is sold, the agent helps you through the closing process, and charges you the normal commission price. After your process page is complete, you receive your discount via a cheque in the mail. You can then spend that money on your new home, or a trip to Bali, or whatever you want!</p>
              </div>
            </div>

          </div>
          <div class="divider"></div>
          <div class="right">
            <!---- STEP ONE ---->
             <div class="step-description stepOne animated">
              <div class="description-box-left">
                <h3>The Property is Sold</h3>
                <p>Register with House stars and create your own process page. You can do this with absolutely no requirement or pressure to continue. This step will start you on your journey to selling your property. You can sell your property up to 7 years later, and still claim the work you have done against your sales costs.</p>
                <p class="highlight-small">Please see our <a href="#" class="content-hyperlink">terms and conditions</a> for details.</p>
              </div>
            </div>

            <!---- STEP 2 ---->
            <div class="step-image stepTwo desktop">
              <img src="assets/img-tradesman.png" alt="Step 2: Hire Tradesman to Renovate your Property">
            </div>

            <div class="step-description stepTwo animated tablet">
              <div class="description-box-left">
                <h3>Hire Tradesman to Renovate your Property</h3>
                <p>Once you have signed up, you can start using the trades and services on the site, all rated and reviewed by house owners like you, to work on your property. You organise the tradies, the work is performed and you pay them as you normally would. Then you simply add the receipts to your process page and leave a rating and a comment about them for future users to see. The total of the receipts will be the savings you receive when you sell your property using one of the agents listed on the site. </p>
                <p class="highlight-small">(See our faq for details about how much you can save)</p>
              </div>
            </div>

            <!---- STEP 3 ---->
            <div class="step-description stepThree animated">
              <div class="description-box-left">
                <h3>Engage an Agent</h3>
                <p>Once you have completed the work on your property, its time to bring in the agent. We have approached the best agents in town to team up with us, so you get the very best team working for you. You work in with the agent as you normally would, to agree on things like a sales strategy, sale price, commission and advertising. When you are ready, the property is listed.</p>
              </div>
            </div>

            <!---- STEP 4 ---->
            <div class="step-image stepFour desktop">
              <img src="assets/img-relaxing.png" alt="Step 4: The Property is Sold">
            </div>

            <div class="step-description stepFour animated tablet">
              <div class="description-box-left">
                <h3>Sign Up</h3>
                <p>Once the property is sold, the agent helps you through the closing process, and charges you the normal commission price. After your process page is complete, you receive your discount via a cheque in the mail. You can then spend that money on your new home, or a trip to Bali, or whatever you want!</p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
    <section id="how-we-help" class="grey-area">
      <div class="container">
        <div class="row section-title">
          <h2 class="narrow"><span class="icon icon-left-bar mobile-hidden"></span>How May We Help You <span class="icon icon-right-bar mobile-hidden"></span></h2>
        </div>
        <div class="row widget">
          <div class="col-xs-4 item animated">
            <h3>Want to sell a property?</h3>
            <p>There’s no better way to sell your property than with House Stars. The best team with the best results at the best prices.</p>
            <div class="featured-img mobile-hidden">
              <img src="assets/img-square-buildings.png" alt="Want to sell a property?">
            </div>
            <a href="{{env('APP_URL')}}/agency" class="btn hs-primary"><span class="icon icon-play-video"></span> Watch Video</a>
          </div>
          <div class="col-xs-4 item animated">
            <h3>are you a trade or service?</h3>
            <p>House Stars is a fantastic way to boost your customer base and increase your sales. Watch the video below to check out the benefits of becoming a House Star.</p>
            <div class="featured-img mobile-hidden">
              <img src="assets/img-square-services.png" alt="are you a trade or service?">
            </div>
            <a href="{{env('APP_URL')}}/tradesman" class="btn hs-primary"><span class="icon icon-play-video"></span> Watch Video</a>
          </div>
          <div class="col-xs-4 item animated">
            <h3>Are you an agent?</h3>
            <p>Need more listings? could you do with a great funnel for attracting new interest to your company? Fancy yourself as being number 1 in your suburb? hit the video below to see what the benefits are for you.</p>
            <div class="featured-img mobile-hidden">
              <img src="assets/img-square-agent.png" alt="Are you an agent?">
            </div>
            <a href="{{env('APP_URL')}}/customer" class="btn hs-primary"><span class="icon icon-play-video"></span> Watch Video</a>
          </div>
        </div>
      </div>
    </section>
    @include("rate_tradesman_modal");
		@include("agency_rate_modal");
		<script>
			$(document).ready(function() {
					$('#rateTradesmanModal').modal('show');
			});

			// redirect when review form is closed
			$('#rateTradesmanModal').on('hidden.bs.modal', function () {
				setTimeout(function() {
					window.location.replace('/');	
				}, 2000);
				
			});
		</script>
		@endsection
