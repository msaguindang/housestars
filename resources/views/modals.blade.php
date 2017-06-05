		<!-- MODALS -->

		<!-- LOGIN -->
		<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="login-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>Login to your account</h4>
						<p class="sub-heading">Access your account and let’s start working</p>
						<form id="loginform">
							{{csrf_field() }}
							<div class="alert alert-danger"><div id="login-error"></div></div>
							<input type="text" name="email" placeholder="Email">
							<input type="password" name="password" placeholder="Password" class="no-top">
							<button class="btn hs-primary">Login Now</button>
						</form>
						<a href="#" data-toggle="modal" data-target="#forgotPassword" id="openForgotPasswordModal">Forgot your login password?</a>
						<p class="heading"><span class="hLine left"></span>SIGN IN USING YOUR SOCIAL ACCOUNTS <span class="hLine right"></span></p>
						<div class="row social-buttons">
							<div class="col-xs-6 no-padding-right"><a class="btn hs-primary facebook" href="/login/facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Login with Facebook</a></div>
							<div class="col-xs-6 no-padding-left"><a class="btn hs-primary google" href="/login/google"><i class="fa fa-google" aria-hidden="true"></i> Login with Google</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- FORGOT PASSWORD -->
		<div class="modal fade" id="forgotPassword" tabindex="-1" role="dialog" aria-labelledby="login-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>Forgot your password?</h4>
						<p class="sub-heading">Fill in required field below.</p>
						<form id="forgotPass">
							{{csrf_field() }}
							<div id="msg"></div>
							<input type="text" name="email" placeholder="Email">
							<button class="btn hs-primary">Retrieve Password</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- SIGNUP -->
		<div class="modal fade" id="signup" tabindex="-1" role="dialog" aria-labelledby="signup-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>REGISTER NOW</h4>
						<p class="sub-heading">Already a member? Please login <a href="" data-toggle="modal" data-target="#login" id="open">here</a></p>
						<form id="signupform">
							{{csrf_field() }}
							<div class="alert alert-danger"><div id="errors-signup"></div></div>
							<input type="text" name="name" placeholder="Full Name">
							<input type="text" name="email" placeholder="Your Email Address" class="no-top"> </br></br>
							<input type="password" name="password" placeholder="Create Password">
							<input type="password" name="password_confirmation" placeholder="Confirm Password" class="no-top">
							<div class="row account-option">
								<div class="col-xs-3 radio-account-div"><input type="radio" name="account" value="agency" checked> <label class="radio-account-label">Agent</label></div>
								<div class="col-xs-4 radio-account-div"><input type="radio" name="account" value="tradesman"> <label class="radio-account-label">Trade/Service</label></div>
								<div class="col-xs-4 radio-account-div"><input type="radio" name="account" value="customer"> <label class="radio-account-label">Customer</label></div>
							</div>
							<button class="btn hs-primary">Create an Account Now</button>
						</form>
						<p class="heading signup-social"><span class="hLine left"></span>SIGN UP USING YOUR SOCIAL ACCOUNTS <span class="hLine right"></span></p>
						<div class="row social-buttons">
							<div class="col-xs-6 no-padding-right social-button"><a class="btn hs-primary facebook" href="/login/facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Signup with Facebook</a></div>
							<div class="col-xs-6 no-padding-left social-button"><a class="btn hs-primary google" href="/login/google"><i class="fa fa-google" aria-hidden="true"></i> Signup with Google</a></div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- RATE A TRADE OR SERVICES SIGN IN 1-->
		<div class="modal fade" id="rating" tabindex="-1" role="dialog" aria-labelledby="rating-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>RATE A TRADE, SERVICE, OR AGENT</h4>
						<p class="sub-heading">
							Verify you are a real customer by authenticating with an email address or facebook
						</p>
						<div class="info-bar mobile" data-toggle="tooltip" data-placement="top" title="This step proves that you are a genuine customer and not a robot. This ensures the ratings data on the site is not false, so you get real information when looking for your next trade or service.">What does this mean?</div>
						<div class="info-bar mobile-hidden" data-toggle="tooltip" data-placement="left" title="This step proves that you are a genuine customer and not a robot. This ensures the ratings data on the site is not false, so you get real information when looking for your next trade or service.">What does this mean?</div>
							<form action="{{ route('verify_to_rate') }}" method="POST" id='verify_to_rate'>
								{{csrf_field() }}
								<div id="error"></div>
								<div id="login-error"></div>
								<input type="email" name="email" placeholder="Email" required style="width: 100%;padding: 15px;border: 1px solid #e0e0e0;">
								<!-- <input type="password" name="password" placeholder="Password" class="no-top"> -->
								<button class="btn hs-primary" data-text="Proceed"> Proceed </button>
							</form>
							</br><p>OR</p>
							<a href="/verify/facebook" data-href="/verify/facebook" class="btn social-button hs-facebook"><span class="icon icon-fb-white">Proceed Using Facebook </span> </a>
							<!-- <a href="/verify/google" class="btn social-button hs-google-plus"><span class="icon icon-g-white">Sign in Using GOOGLE PLUS</span> </a> -->
					</div>
				</div>
			</div>
		</div>

		<!-- POTENTIAL CUSTOMER VERIFY MODAL -->
		<div class="modal fade" id="verify-customer" tabindex="-1" role="dialog" aria-labelledby="rating-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<p>
							Please check your email and click the validation link. You will be automatically redirected to Rate A Trade Or Service
						</p>
					</div>
				</div>
			</div>
		</div>

		<!-- RATE INFO -->
		<div class="modal fade" id="rateInfo" tabindex="-1" role="dialog" aria-labelledby="signup-area" >
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>RATE A TRADE, SERVICE, OR AGENCY</h4>
						<p class="sub-heading">Enter the business name you wish to select</p>
						<form method="post" action="/review">
				            <input type="hidden" name="_token" value="{{csrf_token()}}">
							<!-- dropdown list tradesmen and services -->
							<select name="businessId" id='select-rate-business' required>
								<option disabled selected></option>
								@foreach($businesses as $business)
									<option class='item' id="{{$business->user_id}}" value="{{$business->user_id}}"> {{$business->meta_value}} </option>
								@endforeach
							</select>
							<button type="submit" class="btn hs-primary">Rate business now</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		 <!-- RATE A TRADESMAN -->
		<div class="modal fade" id="rateTradesman" tabindex="-1" role="dialog" aria-labelledby="signup-area">
			<div class="modal-dialog" role="document" style="margin-top: 3%;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>Review Page</h4>
						<div class="col-xs-8  col-xs-offset-2 tradesman-info">
							<div class="col-xs-4 tradesman-profile">
								<img src="assets/thumb-profile.jpg" alt="Tradesman Name" id="tradesmanPic">
							</div>
							<div class="col-xs-8 tradesman-name">
								<h4 id="tradesmanName">John Joe Smith</h4>
							</div>
						</div>
						<p style="color:#000000" class="bordered-desc">Your honest answers really help other customers</p>
						<form id="reviewForm" enctype="multipart/form-data" method="post" action="/create">
							{{csrf_field() }}
							<input type="hidden" name="tradesman_id" id="tradesmanID">
							<input type="hidden" name="transaction_id" id="transactionID">
							<input type="hidden" name="user_id" id="userID">
							<div class="rating-stars">
								<p class="rating-label">Communication</p>
								<div class="stars">
									<input type="radio" name="communication" id="group-1-0" value="5" /><label for="group-1-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="communication" id="group-1-1" value="4" /><label for="group-1-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="communication" id="group-1-2" value="3" /><label for="group-1-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="communication" id="group-1-3" value="2" /><label for="group-1-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="communication" id="group-1-4"  value="1" /><label for="group-1-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							<div class="rating-stars">
								<p class="rating-label">Work Quality</p>
								<div class="stars">
									<input type="radio" name="work-quality" id="group-2-0" value="5" /><label for="group-2-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="work-quality" id="group-2-1" value="4" /><label for="group-2-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="work-quality" id="group-2-2" value="3" /><label for="group-2-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="work-quality" id="group-2-3" value="2" /><label for="group-2-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="work-quality" id="group-2-4"  value="1" /><label for="group-2-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							<div class="rating-stars">
								<p class="rating-label">Price</p>
								<div class="stars">
									<input type="radio" name="price" id="group-3-0" value="5" /><label for="group-3-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="price" id="group-3-1" value="4" /><label for="group-3-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="price" id="group-3-2" value="3" /><label for="group-3-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="price" id="group-3-3" value="2" /><label for="group-3-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="price" id="group-3-4"  value="1" /><label for="group-3-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							<div class="rating-stars">
								<p class="rating-label">Punctuality</p>
								<div class="stars">
									<input type="radio" name="punctuality" id="group-4-0" value="5" /><label for="group-4-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="punctuality" id="group-4-1" value="4" /><label for="group-4-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="punctuality" id="group-4-2" value="3" /><label for="group-4-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="punctuality" id="group-4-3" value="2" /><label for="group-4-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="punctuality" id="group-4-4"  value="1" /><label for="group-4-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							<div class="rating-stars no-border">
								<p class="rating-label">Attitude</p>
								<div class="stars">
									<input type="radio" name="attitude" id="group-5-0" value="5" /><label for="group-5-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="attitude" id="group-5-1" value="4" /><label for="group-5-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="attitude" id="group-5-2" value="3" /><label for="group-5-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="attitude" id="group-5-3" value="2" /><label for="group-5-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="attitude" id="group-5-4"  value="1" /><label for="group-5-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							</br></br></br>
							<input type="text" name="review-title" placeholder="Enter Review Title">
							<textarea placeholder="Write your review.." name="review-text" class="no-top"></textarea>
							<div class="review-tips">
								<p class="tooltip-info" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tips for writing a great review </br> </br> <b>DO</b> </br> - Describe your overall experience</br> - Tell us if you would recommended the business to others</br>-Talk about the strengths and weaknesses of the experience </br></br> <b>DON'T</b></br>-Lie. Be as honest as possible</br>-Use bad language or personal insults</br>-Be racist, sexist or vulgar" data-html="true">Tips for writing a good review</p>
							 </br></br>
							</div>
							<button type="submit" class="btn hs-primary">Submit Review</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		 <!-- NO TRADESMAN LISTED-->
		<div class="modal fade" id="noTradesman" tabindex="-1" role="dialog" aria-labelledby="signup-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>There are currently no Carpenters</br>Listed in your area</h4>
						</br><p class="sub-heading">If you know a carpenter that can benefit from this site, please enter their name below and press submit. We will contact them regarding signing up to be a partner. Thank you.</p>
						<form>
							<input type="text" name="" placeholder="Trade or Service name"></br>
							<button class="btn hs-primary">SUBMIT</button>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- NO POSITIONS AVAILABLE -->
		<div class="modal fade" id="noPositions" tabindex="-1" role="dialog" aria-labelledby="signup-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>No Positions Available</h4>
						</br><p class="sub-heading">
							We're sorry there are no positions available for your particular trade or service in this area at this point in time.
						</p>

					</div>
				</div>
			</div>
		</div>

    <!-- Agency Rate Us -->
    <div class="modal fade" id="agencyRate" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document" style="margin-top: 3%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Review Us!</h4>
            <p style="color:#000000" class="bordered-desc">Your honest answers really help other customers</p>

            <form id="reviewForm" enctype="multipart/form-data">
              {{csrf_field() }}
              <input type="hidden" name="tradesman_id" id="agency_id" value="1">
              <div class="rating-stars">
                <p class="rating-label">Communication</p>
                <div class="stars">
                  <input type="radio" name="communication" id="agency-1-0" value="5" /><label for="agency-1-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="communication" id="agency-1-1" value="4" /><label for="agency-1-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="communication" id="agency-1-2" value="3" /><label for="agency-1-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="communication" id="agency-1-3" value="2" /><label for="agency-1-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="communication" id="agency-1-4"  value="1" /><label for="agency-1-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              <div class="rating-stars">
                <p class="rating-label">Work Quality</p>
                <div class="stars">
                  <input type="radio" name="work-quality" id="agency-2-0" value="5" /><label for="agency-2-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="work-quality" id="agency-2-1" value="4" /><label for="agency-2-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="work-quality" id="agency-2-2" value="3" /><label for="agency-2-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="work-quality" id="agency-2-3" value="2" /><label for="agency-2-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="work-quality" id="agency-2-4"  value="1" /><label for="agency-2-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              <div class="rating-stars">
                <p class="rating-label">Price</p>
                <div class="stars">
                  <input type="radio" name="price" id="agency-3-0" value="5" /><label for="agency-3-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="price" id="agency-3-1" value="4" /><label for="agency-3-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="price" id="agency-3-2" value="3" /><label for="agency-3-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="price" id="agency-3-3" value="2" /><label for="agency-3-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="price" id="agency-3-4"  value="1" /><label for="agency-3-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              <div class="rating-stars">
                <p class="rating-label">Punctuality</p>
                <div class="stars">
                  <input type="radio" name="punctuality" id="agency-4-0" value="5" /><label for="agency-4-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="punctuality" id="agency-4-1" value="4" /><label for="agency-4-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="punctuality" id="agency-4-2" value="3" /><label for="agency-4-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="punctuality" id="agency-4-3" value="2" /><label for="agency-4-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="punctuality" id="agency-4-4"  value="1" /><label for="agency-4-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              <div class="rating-stars no-border">
                <p class="rating-label">Attitude</p>
                <div class="stars">
                  <input type="radio" name="attitude" id="agency-5-0" value="5" /><label for="agency-5-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
                  <input type="radio" name="attitude" id="agency-5-1" value="4" /><label for="agency-5-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
                  <input type="radio" name="attitude" id="agency-5-2" value="3" /><label for="agency-5-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
                  <input type="radio" name="attitude" id="agency-5-3" value="2" /><label for="agency-5-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
                  <input type="radio" name="attitude" id="agency-5-4"  value="1" /><label for="agency-5-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
                </div>
              </div>
              </br></br></br>
              <input type="text" name="review-title" placeholder="Enter Review Title">
              <textarea placeholder="Write your review.." name="review-text" class="no-top"></textarea>
              <div class="review-tips">
                <p class="tooltip-info" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tips for writing a great review </br> </br> <b>DO</b> </br> - Describe your overall experience</br> - Tell us if you would recommended the business to others</br>-Talk about the strengths and weaknesses of the experience </br></br> <b>DON'T</b></br>-Lie. Be as honest as possible</br>-Use bad language or personal insults</br>-Be racist, sexist or vulgar" data-html="true">Tips for writing a good review</p>
               </br></br>
              </div>
              <button class="btn hs-primary">Submit Reviews</button>
            </form>
          </div>
        </div>
      </div>
    </div>



    @if(isset($data['reviews']))

      @foreach($data['reviews'] as $review)

        <div class="modal fade" id="rateReview{{$review['id']}}" tabindex="-1" role="dialog" aria-labelledby="signup-area">
          <div class="modal-dialog" role="document" style="margin-top: 3%;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <h4>Rate Summary</h4></br>
                  <input type="hidden" name="tradesman_id" id="tradesmanID">
                  <div class="rating-stars">
										@if(isset($review['communication']))
                    <p class="rating-label">Communication</p>
                    <div class="stars">
                      @for($i = 1; $i <= $review['communication']; $i++)
                        <span class="icon icon-star"></span>
                      @endfor
                      @php ($rating = 5 - $review['communication'])
                      @for($i = 1; $i <= $rating; $i++)
                        <span class="icon icon-star-grey"></span>
                      @endfor
                    </div>
										@endif
                  </div>
                  <div class="rating-stars">
										@if(isset($review['work_quality']))
                    <p class="rating-label">Work Quality</p>
                    <div class="stars">
                      @for($i = 1; $i <= $review['work_quality']; $i++)
                        <span class="icon icon-star"></span>
                      @endfor
                      @php ($rating = 5 - $review['work_quality'])
                      @for($i = 1; $i <= $rating; $i++)
                        <span class="icon icon-star-grey"></span>
                      @endfor
                    </div>
										@endif
                  </div>
                  <div class="rating-stars">
										@if(isset($review['price']))
                    <p class="rating-label">Price</p>
                   <div class="stars">
                      @for($i = 1; $i <= $review['price']; $i++)
                        <span class="icon icon-star"></span>
                      @endfor
                      @php ($rating = 5 - $review['price'])
                      @for($i = 1; $i <= $rating; $i++)
                        <span class="icon icon-star-grey"></span>
                      @endfor
                    </div>
										@endif
                  </div>
                  <div class="rating-stars">
										@if(isset($review['punctuality']))
                    <p class="rating-label">Punctuality</p>
                    <div class="stars">
                      @for($i = 1; $i <= $review['punctuality']; $i++)
                        <span class="icon icon-star"></span>
                      @endfor
                      @php ($rating = 5 - $review['punctuality'])
                      @for($i = 1; $i <= $rating; $i++)
                        <span class="icon icon-star-grey"></span>
                      @endfor
                    </div>
										@endif
                  </div>
                  <div class="rating-stars no-border">
										@if(isset($review['attitude']))
                    <p class="rating-label">Attitude</p>
                    <div class="stars">
                      @for($i = 1; $i <= $review['attitude']; $i++)
                        <span class="icon icon-star"></span>
                      @endfor
                      @php ($rating = 5 - $review['attitude'])
                      @for($i = 1; $i <= $rating; $i++)
                        <span class="icon icon-star-grey"></span>
                      @endfor
                    </div>
										@endif
                  </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @endif

	<!-- RATING SUMMARY -->
	
	@if(isset($data['reviews']))
        <div class="modal fade" id="overallRatingSummary" tabindex="-1" role="dialog" aria-labelledby="signup-area">
          <div class="modal-dialog" role="document" style="margin-top: 3%;">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                <h4>Rating Summary</h4></br>
					<hr>
					@php($a = 0 )
					@php($b = 0)
					@php($c = 0)
					@php($d = 0)
					@php($e = 0)
					@php($f = 0)
				  	@foreach($data['reviews'] as $review)
						@if(isset($review['average']))
							@if($review['average'] == '0')
							@php($a = $a + 1 )
							@elseif($review['average'] == '1')
							@php($b = $b + 1 )
							@elseif($review['average'] == '2')
							@php($c = $c + 1 )
							@elseif($review['average'] == '3')
							@php($d = $d + 1 )
							@elseif($review['average'] == '4')
							@php($e = $e + 1 )
							@elseif($review['average'] == '5')
							@php($f = $f + 1 )
							@endif
						@endif
				  	@endforeach
				  	<div class="rating-stars no-border">
					  	<div class="rate">
						  	<a href="#star5" class="rating-label collapsed" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="star5" style="display: block; width: 100%; "> 
							  	<p style="float: left;"> Number of users who rated 5 Stars</p> 
							  	<p style="float: right;"><b>({{$f}})</b> </p>
						  	</a>
					  		<div class="collapse in" id="star5" aria-expanded="true" style="width: 100%; float: left;     padding: 15px 0;"> 
						  		 @if(isset($data['reviews']))
					                @foreach($data['reviews'] as $review)
					                	@if($review['average'] == '5')
					                	<div class="review-item">
						                	<p style="float: left;"><b>{{$review['name']}}</b></p>
						                	<div class="stars left">
					
					                        @for($i = 1; $i <= $review['average']; $i++)
					                            <span class="icon icon-star"></span>
					                        @endfor
					                        @php ($rating = 5 - $review['average'])
					                        @for($i = 1; $i <= $rating; $i++)
					                            <span class="icon icon-star-grey"></span>
					                        @endfor
					                    </div>
					                	</div>
					                    @endif
					                @endforeach
					              @endif

						  	</div>
					  	</div>
					  		<hr>
					  	<div class="rate">
		                    <a href="#star4" class="rating-label collapsed" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="star4" style="display: block; width: 100%; "> 
							  	<p style="float: left;"> Number of users who rated 4 Stars</p> 
							  	<p style="float: right;"><b>({{$e}})</b> </p>
						  	</a>
					  		<div class="collapse in" id="star4" aria-expanded="true" style="width: 100%; float: left;     padding: 15px 0;"> 
						  		 @if(isset($data['reviews']))
					                @foreach($data['reviews'] as $review)
					                	@if($review['average'] == '4')
					                	<div class="review-item">
						                	<p style="float: left;"><b>{{$review['name']}}</b></p>
						                	<div class="stars left">
					
					                        @for($i = 1; $i <= $review['average']; $i++)
					                            <span class="icon icon-star"></span>
					                        @endfor
					                        @php ($rating = 5 - $review['average'])
					                        @for($i = 1; $i <= $rating; $i++)
					                            <span class="icon icon-star-grey"></span>
					                        @endfor
					                    </div>
					                	</div>
					                    @endif
					                @endforeach
					              @endif

						  	</div>
	                    </div>
	                    <hr>
	                    <div class="rate">
		                    <a href="#star3" class="rating-label collapsed" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="star3" style="display: block; width: 100%; "> 
							  	<p style="float: left;"> Number of users who rated 3 Stars</p> 
							  	<p style="float: right;"><b>({{$d}})</b> </p>
						  	</a>
					  		<div class="collapse in" id="star3" aria-expanded="true" style="width: 100%; float: left;     padding: 15px 0;"> 
						  		 @if(isset($data['reviews']))
					                @foreach($data['reviews'] as $review)
					                	@if($review['average'] == '3')
					                	<div class="review-item">
						                	<p style="float: left;"><b>{{$review['name']}}</b></p>
						                	<div class="stars left">
					
					                        @for($i = 1; $i <= $review['average']; $i++)
					                            <span class="icon icon-star"></span>
					                        @endfor
					                        @php ($rating = 5 - $review['average'])
					                        @for($i = 1; $i <= $rating; $i++)
					                            <span class="icon icon-star-grey"></span>
					                        @endfor
					                    </div>
					                	</div>
					                    @endif
					                @endforeach
					              @endif

						  	</div>
	                    </div>
	                    <hr>
	                    <div class="rate">
		                    <a href="#star2" class="rating-label collapsed" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="star2" style="display: block; width: 100%; "> 
							  	<p style="float: left;"> Number of users who rated 2 Stars</p> 
							  	<p style="float: right;"><b>({{$c}})</b> </p>
						  	</a>
					  		<div class="collapse in" id="star2" aria-expanded="true" style="width: 100%; float: left; padding: 15px 0;"> 
						  		 @if(isset($data['reviews']))
					                @foreach($data['reviews'] as $review)
					                	@if($review['average'] == '2')
					                	<div class="review-item">
						                	<p style="float: left;"><b>{{$review['name']}}</b></p>
						                	<div class="stars left">
					
					                        @for($i = 1; $i <= $review['average']; $i++)
					                            <span class="icon icon-star"></span>
					                        @endfor
					                        @php ($rating = 5 - $review['average'])
					                        @for($i = 1; $i <= $rating; $i++)
					                            <span class="icon icon-star-grey"></span>
					                        @endfor
					                    </div>
					                	</div>
					                    @endif
					                @endforeach
					              @endif

						  	</div>
	                    </div>
	                    <hr>
	                    <div class="rate">
		                    <a href="#star1" class="rating-label collapsed" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="star1" style="display: block; width: 100%; "> 
							  	<p style="float: left;"> Number of users who rated 1 Star</p> 
							  	<p style="float: right;"><b>({{$b}})</b> </p>
						  	</a>
					  		<div class="collapse in" id="star1" aria-expanded="true" style="width: 100%; float: left;     padding: 15px 0;"> 
						  		 @if(isset($data['reviews']))
					                @foreach($data['reviews'] as $review)
					                	@if($review['average'] == '1')
					                	<div class="review-item">
						                	<p style="float: left;"><b>{{$review['name']}}</b></p>
						                	<div class="stars left">
					
					                        @for($i = 1; $i <= $review['average']; $i++)
					                            <span class="icon icon-star"></span>
					                        @endfor
					                        @php ($rating = 5 - $review['average'])
					                        @for($i = 1; $i <= $rating; $i++)
					                            <span class="icon icon-star-grey"></span>
					                        @endfor
					                    </div>
					                	</div>
					                    @endif
					                @endforeach
					              @endif

						  	</div>
	                    </div>
	                    <hr>
	                    <div class="rate">
		                    <a href="#star0" class="rating-label collapsed" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="star0" style="display: block; width: 100%; "> 
							  	<p style="float: left;"> Number of users who rated 0 Star</p> 
							  	<p style="float: right;"><b>({{$a}})</b> </p>
						  	</a>
					  		<div class="collapse in" id="star0" aria-expanded="true" style="width: 100%; float: left;     padding: 15px 0;"> 
						  		 @if(isset($data['reviews']))
					                @foreach($data['reviews'] as $review)
					                	@if($review['average'] == '0')
					                	<div class="review-item">
						                	<p style="float: left;"><b>{{$review['name']}}</b></p>
						                	<div class="stars left">
					
					                        @for($i = 1; $i <= $review['average']; $i++)
					                            <span class="icon icon-star"></span>
					                        @endfor
					                        @php ($rating = 5 - $review['average'])
					                        @for($i = 1; $i <= $rating; $i++)
					                            <span class="icon icon-star-grey"></span>
					                        @endfor
					                    </div>
					                	</div>
					                    @endif
					                @endforeach
					              @endif

						  	</div>
	                    </div>
						<hr>
                  </div>
				  	
              </div>
            </div>
          </div>
        </div>
      
    @endif

	
	
    <!-- RATE SUMMARY-->


     <!-- NO TRADESMAN LISTED-->
    <div class="modal fade" id="noTradesmen" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>
            	KNOW A GREAT TRADE OR SERVICE BUSINESS?
            </h4>
            </br><p class="sub-heading">If you know a trade or service business that can benefit from this site, please enter their name below and press submit. We will contact them regarding signing up to be a partner. Thank you.</p>
            <form id="suggestTradesman">
              {{csrf_field() }}
              <input type="hidden" id="search-suburb" name="suburb" />
              <input type="text" name="name" placeholder="Tradesman or Business Name"></br>
              <input type="text" name="contact" placeholder="Business Phone No. (not essential)" class="no-top"></br>
              <input type="text" name="suburb-name" placeholder="Suburb"> </br>
              <button class="btn hs-primary">SUBMIT</button>
            </form>
          </div>
        </div>
      </div>
    </div>

		<!-- NO TRADESMAN LISTED-->
	 <div class="modal fade" id="noAgency" tabindex="-1" role="dialog" aria-labelledby="signup-area">
		 <div class="modal-dialog" role="document">
			 <div class="modal-content">
				 <div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				 </div>
				 <div class="modal-body">
					 <h4>There are no agents currently</br>listed in your suburb</h4>
				 </br><p class="sub-heading">If you know a real estate agency in your area that could benifit from this site, please enter their details below. We will contact them with regards to becoming a partner with us.</p>
					 <form id="suggestAgency">
						 {{csrf_field() }}
						 <input type="hidden" id='no-agency-suburb' name="suburb" />
						 <input type="text" name="name" placeholder="Agency/Agent Name"></br>
						 <input type="text" name="contact" placeholder="Contact Number" class="no-top"></br>
						 <button class="btn hs-primary">SUBMIT</button>
					 </form>

					 <p class="heading"><span class="hLine left"></span>NEAREST AGENCIES<span class="hLine right"></span></p>
					 <div id="nearby">
						 <div class="col-xs-4">
						 		<a class="agent-profile0">
						 		<div class="col-xs-12 tradesman-profile">
						 					<div class="thumb-holder0"></div>
						 					<p class="agent-name0" style="margin-top: 10px; margin-bottom: 0;"></p>
											<p class="location0" style="margin: 0; font-style: italic; font-size: 11px;"></p>
						 		</div>
						 		<br>
								<div class="stars rating0">

						 		</div>
						   </a>
						 </div>
						 <div class="col-xs-4">
						 		<a class="agent-profile1">
						 		<div class="col-xs-12 tradesman-profile">
						 					<div class="thumb-holder1"></div>
						 					<p class="agent-name1" style="margin-top: 10px; margin-bottom: 0;"></p>
											<p class="location1" style="margin: 0; font-style: italic; font-size: 11px;"></p>
						 		</div>
						 		<br>
								<div class="stars rating1">

						 		</div>
						   </a>
						 </div>
						 <div class="col-xs-4">
						 		<a class="agent-profile2">
						 		<div class="col-xs-12 tradesman-profile">
						 					<div class="thumb-holder2"></div>
						 					<p class="agent-name2" style="margin-top: 10px; margin-bottom: 0;"></p>
											<p class="location2" style="margin: 0; font-style: italic; font-size: 11px;"></p>
						 		</div>
						 		<br>
								<div class="stars rating2">

						 		</div>
						   </a>
						 </div>
					 </div>
				 </div>
			 </div>
		 </div>
	 </div>

    <!-- SUBMIT CATEGORY-->
    <div class="modal fade" id="submitCategory" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Submit Category Listing</h4>
            </br><p class="sub-heading">Please enter the desired category and press “Submit”.</br> If the category is aligned with our Philosophy, </br>we will create a new category. Thank you.</p>
            <form id="submitCat">
              {{csrf_field() }}
              <input type="text" name="trade" placeholder="Category Name"></br>
              <input type="text" name="name" placeholder="Your Name" class="no-top"></br>
              <input type="text" name="email" placeholder="Your Email" class="no-top"></br>
              <button class="btn hs-primary">SUBMIT</button>
            </form>
          </div>
        </div>
      </div>
    </div>

		<!-- Thank You Note / Savings Calculator-->
		<div class="modal fade" id="thankYou" tabindex="-1" role="dialog" aria-labelledby="signup-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>Thank You!</h4>
						</br><p class="sub-heading">An email is now being sent to your inbox with your estimated savings and explanation.</p>
						</br><p class="sub-heading">Please see our customer FAQ for more information regarding the savings estimation calculator and how this estimates are calculated</p>
						<button class="btn hs-primary">Got it</button>
					</div>
				</div>
			</div>
		</div>

		<!-- NO AGENT LISTED-->
		<div class="modal fade" id="noAgent" tabindex="-1" role="dialog" aria-labelledby="signup-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>There are no agents currently</br>listed in your suburb</h4>
						</br><p class="sub-heading">If you know a great Agent that can benefit from this site, please enter their name below and click Submit. We will be in contact with them. Your closest 3 agents are: The site selects; the closest agents by geographical distance; and presents them.</p>
						<form>
							<input type="text" name="" placeholder="Agent Name"></br>
							<button class="btn hs-primary">SUBMIT</button>
						</form>
						 <p class="heading"><span class="hLine left"></span>RELATED AGENTS <span class="hLine right"></span></p>
						 <div class="agents">
							<div class="col-xs-4">
								<a href="#">
									<div class="col-xs-8  col-xs-offset-2 tradesman-profile">
										<img src="assets/thumb-profile.jpg" alt="Tradesman Name">
									</div>
									</br>
									<p class="agent-name">John Joe Smith</p>
									<div class="stars">
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
									</div>
								</a>
							</div>
							<div class="col-xs-4">
								<a href="#">
									<div class="col-xs-8  col-xs-offset-2 tradesman-profile">
										<img src="assets/thumb-profile.jpg" alt="Tradesman Name">
									</div>
									</br>
									<p class="agent-name">John Joe Smith</p>
									<div class="stars">
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
									</div>
								</a>
							</div>
							<div class="col-xs-4">
								<a href="#">
									<div class="col-xs-8  col-xs-offset-2 tradesman-profile">
										<img src="assets/thumb-profile.jpg" alt="Tradesman Name">
									</div>
									</br>
									<p class="agent-name">John Joe Smith</p>
									<div class="stars">
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
										<span class="icon icon-star"></span>
									</div>
								</a>
							</div>
						 </div>
					</div>
				</div>
			</div>
		</div>

    <!-- Thank You Note / Tradesman Submission-->
    <div class="modal fade" id="thankYouTrades" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Thank You!</h4>
            </br><p class="sub-heading">We will contact them regarding signing up to be a partner.</p>
            <button class="btn hs-primary" data-dismiss="modal" aria-label="Close">Got it</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Thank You Note / Tradesman Submission-->
    <div class="modal fade" id="thankYouCategory" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Thank You!</h4>
            </br><p class="sub-heading">Your suggestion has been noted.</p>
            <button class="btn hs-primary" data-dismiss="modal" aria-label="Close">Got it</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Thank You Note / Tradesman Submission-->
    <div class="modal fade" id="processSuccess" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>We will process your property submission.</h4>
            </br><p class="sub-heading">You have successfully completed your process page. Please wait up to 10 working days for confirmation</p>
          </div>
        </div>
      </div>
    </div>

    <!-- NO AGENT LISTED-->
    <div class="modal fade" id="noAgent" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>There are no agents currently</br>listed in your suburb</h4>
            </br><p class="sub-heading">If you know a great Agent that can benefit from this site, please enter their name below and click Submit. We will be in contact with them. Your closest 3 agents are: The site selects; the closest agents by geographical distance; and presents them.</p>
            <form>
              <input type="text" name="" placeholder="Agent Name"></br>
              <button class="btn hs-primary">SUBMIT</button>
            </form>
             <p class="heading"><span class="hLine left"></span>RELATED AGENTS <span class="hLine right"></span></p>
             <div class="agents">
              <div class="col-xs-4">
                <a href="#">
                  <div class="col-xs-8  col-xs-offset-2 tradesman-profile">
                    <img src="assets/thumb-profile.jpg" alt="Tradesman Name">
                  </div>
                  </br>
                  <p class="agent-name">John Joe Smith</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="#">
                  <div class="col-xs-8  col-xs-offset-2 tradesman-profile">
                    <img src="assets/thumb-profile.jpg" alt="Tradesman Name">
                  </div>
                  </br>
                  <p class="agent-name">John Joe Smith</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                </a>
              </div>
              <div class="col-xs-4">
                <a href="#">
                  <div class="col-xs-8  col-xs-offset-2 tradesman-profile">
                    <img src="assets/thumb-profile.jpg" alt="Tradesman Name">
                  </div>
                  </br>
                  <p class="agent-name">John Joe Smith</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                </a>
              </div>
             </div>
          </div>
        </div>
      </div>
    </div>
    <!-- RATE AGENT -->
    <div class="modal fade" id="rateAgent" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document" style="margin-top: 3%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Rate An Agent</h4>
						<form>
							<textarea placeholder="Type your comments here.."></textarea>
							<button class="btn hs-primary">Submit Reviews</button>
						</form>
					</div>
				</div>
			</div>
		</div>


    <!-- ORDER BUSINESS CARD -->
    <div class="modal fade" id="orderBC" tabindex="-1" role="dialog" aria-labelledby="order-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>ORDER YOUR REVIEW CARDS</h4>
            <p class="sub-heading">Please enter the business name that will appear on review cards.</p>
            <form id="orderBusinessCard">
              {{csrf_field() }}
              <div id="error"></div>
              <input type="text" name="name" placeholder="Business Name">
<!--
              <input type="text" name="address" placeholder="Your Full Address" class="no-top">
              <input type="text" name="contact" placeholder="Your Contact Number" class="no-top">
              <input type="text" name="email" placeholder="Your Email Address" class="no-top">
              <input type="text" name="website" placeholder="Your Website" class="no-top">
-->
              <button class="btn hs-primary">Order Now</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- CONTACT US FORM-->
    <div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="order-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Contact Us</h4>
            <p class="sub-heading">How can we help you?</p>
            <form id="contactUS">
              {{csrf_field() }}
              <div id="error"></div>
							@if(Sentinel::check())
							<input type="hidden" name="name" value="{{Sentinel::getUser()->name}}">
              <input type="hidden" name="email" value="{{Sentinel::getUser()->email}}">
							@else
							<input type="text" name="name" placeholder="Full Name">
              <input type="text" name="email" placeholder="Email Address" class="no-top">
							@endif
							<div class="btn-group">
					            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle no-top">Please Select A Topic... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
					            <ul class="dropdown-menu">
					              <li>
					                <input type="radio" id="a1" name="topic" value="General Enquiry" selected>
					                <label for="a1">General Enquiry</label>
					              </li>
					              <li>
					                <input type="radio" id="a2" name="topic" value="Support">
					                <label for="a2">Support</label>
					              </li>
					              <li>
					                <input type="radio" id="a3" name="topic" value="Complaints">
					                <label for="a3">Complaints</label>
					              </li>
					              <li>
					                <input type="radio" id="a4" name="topic" value="Make a Suggestion">
					                <label for="a4">Make a Suggestion</label>
					              </li>
					            </ul>
					        </div>
              <input type="text" name="subject" placeholder="Subject">
              <textarea name="message" placeholder="Your Message Here" class="no-top"></textarea>

              <button class="btn hs-primary">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- ADD TRADES / PROCESSING PAGE-->
    <div class="modal fade" id="processTrades" tabindex="-1" role="dialog" aria-labelledby="order-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            @php($x = 0)
            @if(isset($data['tradesmen']) && count($data['tradesmen']) > 0)
	            <h4>ADD A RECEIPT</h4>
	            <p class="sub-heading">Process a transaction with a trade or service.</p>
	            <form id="transaction" enctype="multipart/form-data">
		            {{csrf_field() }}
		            <div id="error"></div>
		            <!-- dropdown list tradesmen and services -->
		             @php($x = 0)
					<select name="trades" id='select-trades' required>
						<option disabled selected></option>
						@foreach ($data['tradesmen'] as $tradesman)
							<option class='item' value="{{ $tradesman['id'] }}"> {{ $tradesman['trading-name'] }}</option>
						@endforeach
					</select>
					<span class="dollar-sign">$</span>
	              	<input type="text" name="amount-spent"  placeholder="Amount Spent" class="no-top" id="amount">
	              	@if(isset($a))
	                	<input type="hidden" name="property-code" value="{{$data['property'][$a]['property-code']}}" id="code">
	              	@endif
	              	<div class="upload-button no-top">
	                	<span class="label">Click to add Receipt</span>
	                	<input type="file" name="receipt" id="receipt">
		            </div>
		            @if($data['id'])
		             <input type="hidden" name="user_id" value="{{$data['id']}}">
		            @endif
		            <button class="btn hs-primary" id="transaction">Submit</button>
              	</form>
            @else
	            <h4>NO LISTED TRADESMAN</h4>
	            <p class="sub-heading">We have no tradesman listed on our system at the moment.</p>
            @endif
          </div>
        </div>
      </div>
    </div>

	<!-- NO AGENT LISTED-->
		<div class="modal fade" id="addAgent" tabindex="-1" role="dialog" aria-labelledby="signup-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>SELECT YOUR AGENT</h4></br>
						<p class="sub-heading">
							@if(isset($data['agents']) && count($data['agents']))
								Select an agency near your property location.
							@else
	                			Sorry, there are currently no agents registered near your area.
				            @endif
						</p>
						<div class="agents">

							@php($x = 0)
							@php($y = 0)
							@php($z = 2)
							@if(isset($data['agents']))
								@foreach($data['agents'] as $agent)
								@if($y == 0)
									<div class="row">
								@endif
									<div class="col-xs-4">
										@if($data['id'])
											<a class="selectAgent" data-id="{{$agent['id']}}" data-userid="{{$data['id']}}" data-token="{{csrf_token()}}" data-code="{{$data['code']}}">
										@endif
											<div class="col-xs-8  col-xs-offset-2 tradesman-profile">
												@if(isset($agent['photo']))
												<img src="{{url($agent['photo'])}}" alt="{{$agent['name']}}">
												@else
												<img src="{{asset('assets/default.png')}}" alt="{{$agent['name']}}">
												@endif
												<p class="agent-name" style="margin-top: 10px;">{{$agent['name']}}</p>
											</div>
											</br>

											<div class="stars">
												@if($agent['rating'] == 0)
													<span class="icon icon-star-grey"></span>
													<span class="icon icon-star-grey"></span>
													<span class="icon icon-star-grey"></span>
													<span class="icon icon-star-grey"></span>
													<span class="icon icon-star-grey"></span>
												@else
													@for($i = 0; $i < $agent['rating']; $i++)
															<span class="icon icon-star"></span>
													@endfor
													@php ($x = 5 - $agent['rating'])
													@for($i = 0; $i < $x; $i++)
															<span class="icon icon-star-grey"></span>
													@endfor
                        @endif
                      </div>
                    </a>
                  </div>
								@if($y == $z)
									</div>
									<div class="row">
								@php($z = $z + 2)
								@endif

								@php($y++)

                @endforeach
              	@endif
             </div>
          </div>
        </div>
      </div>
    </div>
	</div>

    @if(isset($data['property']))
      @foreach($data['property'] as $property)
        @if(isset($property['property-type']))
          <!-- Preview Contract-->
          <div class="modal fade" id="{{$property['property-code']}}" tabindex="-1" role="dialog" aria-labelledby="signup-area">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                  <div class="img-preview">
                    @if(isset($property['contract']))
                      <img src="{{env('APP_URL')}}/{{$property['contract']}}" alt="">
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    @endif

      <!-- Thank You Note / Tradesman Submission-->
    <div class="modal fade" id="savingsSuccess" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Thank You!</h4>
            </br><p class="sub-heading">An email is now being sent to your inbox with your estimated savings and explanation.</p>
          </br><p class="sub-heading">Please see our customer FAQ for more information regarding the savings estimation calculator and how these estimates are calculated.</p>
          </div>
        </div>
      </div>
    </div>

		<!-- Become Part of Our Team-->
	<div class="modal fade" id="team" tabindex="-1" role="dialog" aria-labelledby="signup-area">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<h4>WANT TO DO SOMETHING DIFFERENT?</h4>
				</br><p class="sub-heading">At Housestars, we are always looking for partners, affiliates, leaders and staff to help us move foward. If you have something of value that you could give to the site, send us an email outlining your talent and what you want to achieve. Mark the heading of the email with the title "Where do I sign?" and we will contact you as soon as we can. Thanks for your interest. We look foward to you joining us and creating something amazing!</p>
				</div>
			</div>
		</div>
	</div>

	<!-- NO POSITIONS AVAILABLE -->
		<div class="modal fade" id="editErrorModal" tabindex="-1" role="dialog" aria-labelledby="signup-area">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				</div>
				<div class="modal-body">
					<h4 class="text-danger">Error!</h4>
					</br><p class="sub-heading">
						@if(isset($errors) && $errors->any())
							@foreach ($errors->all() as $error)
							    {{ $error }}<br/>
							@endforeach
		              	@endif
					</p>
				</div>
			</div>
		</div>
	</div>

@section('scripts')
	@parent
	<script>
		$("#select-rate-business").selectize({
			maxItems: 1,
	        openOnFocus: true,
	        placeholder: "Name of the business",
	        dropdownParent: null,
			render: {
				option: function(item, escape) {
					return "<div class='option' id="+item.value+" value="+item.value+">" + escape(item.text) + "</div>";
				}
			}
		});
		
	</script>
@endsection