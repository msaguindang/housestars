@extends("layouts.main")
@section("content")
    <header id="header" class="animated">
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
                    <li><a href="#" data-toggle="modal" data-target="#signup">Signup Me Up!</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="main-nav">
                  <ul>
                    <li><span class="icon icon-customer-dark"></span><a href="customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="trades-services">Trades & Services</a></li>
                    <li class="active"><span class="icon icon-agency-dark"></span><a href="agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
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

    <section id="how-we-help">
      <div class="container">
        <div class="row section-title">
          <h2 class="wide"><span class="icon icon-left-bar"></span>WHAT WE CAN OFFER TO YOUR AGENCY<span class="icon icon-right-bar"></span></h2>
         <span class="separator"></span>
        </div>
        <div class="row widget">
          <div class="col-xs-4 animated">
            <h3>Build A Personalize Page</h3>
            <p>Populate your page with your logo, as well as pictures and details of what you do. The page is easily edited so you can update it as often as you like.</p>
            <div class="featured-img">
              <img src="assets/img-square-agent.png" alt="Want to sell a property?">
            </div>
          </div>
          <div class="col-xs-4 animated">
            <h3>Monopolize a Suburb</h3>
            <p>There is only space for three agents in each suburb. You have the ability to take one space, and compete with your fellow agents, or take all three spots and really boost your sales figures.</p>
            <div class="featured-img">
              <img src="assets/img-house.png" alt="are you a trade or service?">
            </div>
          </div>
          <div class="col-xs-4 animated">
            <h3>ATTRACT NEW VENDORS</h3>
            <p>The vendors that come to you from this site are new prospects that do not have a preferred agent. Our aim is to make you number 1 in your suburb, by using our sales funnel to dominate your competition and position your business as the best choice in the area.</p>
            <div class="featured-img">
              <img src="assets/img-agentcalling.png" alt="Are you an agent?">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="agent-price-guide" class="grey-area">
    	<div class="container">
    		<div class="row">
    			<div class="section-title">
			       <h2 class="narrower"><span class="icon icon-left-bar"></span>AGENT PRICE GUIDE<span class="icon icon-right-bar"></span></h2>
			       <span class="separator"></span>
			    </div>
    			<div class="col-xs-6 col-xs-offset-3">
    				<ul class="pricing">
    					<li><p><span class="icon icon-price"></span><b>1 position</b> = $2000 per year + 25% of commission price</p></li>
    					<li><p><span class="icon icon-price"></span><b>3 position</b> = $5000 per year + 25% of commission price</p></li>
    				</ul>
    				</br></br>
    				<p>Each time you are invited to list a property, you will have the ability to either accept or decline the sale. Some listings will be charged at a lower commission rate, and you will never be charged at more than 25%.</p>
    			</div>
    		</div>
    	</div>
    </section>

    <section id="suburb-availability">
    	<div class="container">
    		<div class="row">
    			<div class="row section-title">
			        <h2 class="narrower"><span class="icon icon-left-bar"></span>SUBURB AVAILABILITY<span class="icon icon-right-bar"></span></h2>
			      	<span class="separator"></span>
			    </div>
			    <div class="col-xs-6 col-xs-offset-3">
			    	<p>Please enter the postcode of the suburb desired.</p>
			    	<input type="text" name="suburb" placeholder="Enter Postcode" class="search" id="postcode">
			    </div>
    		</div>
    	</div>
    </section>

    <section id="testimonials" class="grey-area">
      <div class="container">
        <div class="row">
          <div class="section-title">
             <h2 class="wide"><span class="icon icon-left-bar"></span>Testimonials from our agents<span class="icon icon-right-bar"></span></h2>
             <span class="separator"></span>
             <p>Our agents love our personalized service and attention to detail. Above all else, we listen to our agents to make sure we are doing everything we can to follow through on our promise of making them number 1. </p>
          </div>
          <div class="testimonials-carousel">
            <div class="col-md-12" data-wow-delay="0.2s">
                <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                  <!-- Carousel Slides / Quotes -->
                    <div class="carousel-inner text-center">
                    <!-- Testimonials 1 -->
                      <div class="item active">
                          <div class="row">
                            <div class="col-xs-1 col-xs-offset-1 thumb">
                              <img src="assets/testimonial-thumb.jpg" alt="Name Here">
                            </div>
                            <div class="col-xs-4 bubble-left">
                              <b class="left">Tiffany Yee</b>
                              <span class="date right">Posted: January 2015</span>
                              <p class="left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !</p>
                              <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful <span class="small">(200)</span></button>
                              <div class="stars left">
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                              </div>
                            </div>
                            <div class="col-xs-1 thumb">
                              <img src="assets/testimonial-thumb.jpg" alt="Name Here">
                            </div>
                             <div class="col-xs-4 bubble-left">
                              <b class="left">Jane Uy</b>
                              <span class="date right">Posted: March 2015</span>
                              <p class="left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit!</p>
                              <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful <span class="small">(156)</span></button>
                              <div class="stars left">
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                              </div>
                            </div>
                          </div>
                      </div>
                      <!-- Testimonials 2 -->
                      <div class="item">
                          <div class="row">
                            <div class="col-xs-1 col-xs-offset-1 thumb">
                              <img src="assets/testimonial-thumb.jpg" alt="Name Here">
                            </div>
                            <div class="col-xs-4 bubble-left">
                              <b class="left">Tiffany Yee</b>
                              <span class="date right">Posted: January 2015</span>
                              <p class="left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !</p>
                              <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful <span class="small">(200)</span></button>
                              <div class="stars left">
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                              </div>
                            </div>
                            <div class="col-xs-1 thumb">
                              <img src="assets/testimonial-thumb.jpg" alt="Name Here">
                            </div>
                             <div class="col-xs-4 bubble-left">
                              <b class="left">Jane Uy</b>
                              <span class="date right">Posted: March 2015</span>
                              <p class="left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit!</p>
                              <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful <span class="small">(156)</span></button>
                              <div class="stars left">
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                              </div>
                            </div>
                          </div>
                      </div>
                      <!-- Testimonials 3 -->
                      <div class="item">
                          <div class="row">
                            <div class="col-xs-1 col-xs-offset-1 thumb">
                              <img src="assets/testimonial-thumb.jpg" alt="Name Here">
                            </div>
                            <div class="col-xs-4 bubble-left">
                              <b class="left">Tiffany Yee</b>
                              <span class="date right">Posted: January 2015</span>
                              <p class="left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !</p>
                              <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful <span class="small">(200)</span></button>
                              <div class="stars left">
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                              </div>
                            </div>
                            <div class="col-xs-1 thumb">
                              <img src="assets/testimonial-thumb.jpg" alt="Name Here">
                            </div>
                             <div class="col-xs-4 bubble-left">
                              <b class="left">Jane Uy</b>
                              <span class="date right">Posted: March 2015</span>
                              <p class="left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit!</p>
                              <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful <span class="small">(156)</span></button>
                              <div class="stars left">
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                              </div>
                            </div>
                          </div>
                      </div>          

                            <!-- Carousel Buttons Next/Prev -->
                            <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><span class="icon icon-left"></span></a>
                            <a data-slide="next" href="#quote-carousel" class="right carousel-control"><span class="icon icon-right"></span></i></a>
                        </div>
                    </div>
          </div>
        </div>
      </div>
    </section>

    <section id="faq">
      <div class="container">
        <div class="row">
          <div class="section-title">
             <h2 class="narrow-1x"><span class="icon icon-left-bar"></span>AGENT FAQ<span class="icon icon-right-bar"></span></h2>
             <span class="separator"></span>
             <p>Want to know more? Go to our FAQ for detailed answers to all of your questions.</p>
             <button class="btn btn-primary"><i class="fa fa-question-circle" aria-hidden="true"></i> Visit FAQ Section</button>
          </div>
        </div>
      </div>
    </section>

@endsection


@section('scripts')
     <script src="js/autocomplete.js"></script>
@stop