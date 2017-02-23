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
            <form action="login" method="POST" class="ajax">
              {{csrf_field() }}
              <div id="error"></div>
              <div id="login-error"></div>
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
            <form class="ajax" action="/register" method="POST">
              {{csrf_field() }}
              <div id="errors-signup"></div>
              <input type="text" name="name" placeholder="Full Name">
              <input type="text" name="email" placeholder="Your Email Address" class="no-top"> </br></br>
              <input type="password" name="password" placeholder="Create Password">
              <input type="password" name="password_confirmation" placeholder="Confirm Password" class="no-top">
              <div class="row account-option">
                <div class="col-xs-3"><input type="radio" name="account" value="agency" checked> Agent</div>
                <div class="col-xs-3"><input type="radio" name="account" value="tradesman"> Trade</div>
                <div class="col-xs-4"><input type="radio" name="account" value="customer"> Customer</div>
              </div>
              <button class="btn hs-primary">Create an Account Now</button>
            </form>
            <p class="heading"><span class="hLine left"></span>SIGN UP USING YOUR SOCIAL ACCOUNTS <span class="hLine right"></span></p>
            <div class="row social-buttons">
              <div class="col-xs-6 no-padding-right"><a class="btn hs-primary facebook" href="/login/facebook"><i class="fa fa-facebook" aria-hidden="true"></i> Signup with Facebook</a></div>
              <div class="col-xs-6 no-padding-left"><a class="btn hs-primary google" href="/login/google"><i class="fa fa-google" aria-hidden="true"></i> Signup with Google</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- RATE A TRADE OR SERVICES SIGN IN-->
    <div class="modal fade" id="rating" tabindex="-1" role="dialog" aria-labelledby="rating-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Rate a Trade or Service</h4>
            <p class="sub-heading">Verify that you are a real customer by signing in below</p>
            <div class="info-bar" data-toggle="tooltip" data-placement="left" title="This step proves that you are a genuine customer and not a robot. This ensures the ratings data on the site is not false, so you get real information when looking for your next trade or service.">What does this mean?</div>
              <a class="btn social-button hs-facebook" href="/login/facebook"><span class="icon icon-fb-white">Sign in Using Facebook </span> </a>
              </br><p>OR</p>
              <a class="btn social-button hs-google-plus" href="/login/facebook"><span class="icon icon-g-white">Sign in Using GOOGLE PLUS</span> </a>
          </div>
        </div>
      </div>
    </div>

     <!-- RATE INFO -->
    <div class="modal fade" id="rateInfo" tabindex="-1" role="dialog" aria-labelledby="signup-area">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <h4>Rate a Trade or Service</h4>
            <p class="sub-heading">Enter the details of the business you require.</p>
            <form>
              <input type="text" name="" placeholder="Business Name">
              <input type="text" name="" placeholder="Your Postcode" class="no-top"> </br></br>
              <button class="btn hs-primary">Rate Tradesman Now</button>
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
            <h4>Rate a Trade or Service</h4>
            <div class="col-xs-8  col-xs-offset-2 tradesman-info">
              <div class="col-xs-4 tradesman-profile">
                <img src="assets/thumb-profile.jpg" alt="Tradesman Name" id="tradesmanPic">
              </div>
              <div class="col-xs-8 tradesman-name">
                <h4 id="tradesmanName">John Joe Smith</h4>
              </div>
            </div>
            <p class="bordered-desc">Your Honest answers really help other customers</p>

            <form id="reviewForm" enctype="multipart/form-data">
              {{csrf_field() }}
              <input type="hidden" name="tradesman_id" id="tradesmanID">
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
              <button class="btn hs-primary">Submit Reviews</button>
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
            </br><p class="sub-heading">If you know a carpenter that can benefit from this site, Please enter their name below and press submit. We will contact them regarding signing up to be a partner. Thank you.</p>
            <form>
              <input type="text" name="" placeholder="Trade or Service name"></br>
              <button class="btn hs-primary">SUBMIT</button>
            </form>
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
            <form>
              <input type="text" name="trade" placeholder="Trades or Service Name"></br>
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
            <h4>ORDER YOUR BUSINESS CARD</h4>
            <p class="sub-heading">Enter the details you want to appear on your business card.</p>
            <form action="login" method="POST" class="ajax">
              {{csrf_field() }}
              <div id="error"></div>
              <input type="text" name="name" placeholder="Your Full Name">
              <input type="text" name="address" placeholder="Your Full Address" class="no-top">
              <input type="text" name="contact" placeholder="Your Contact Number" class="no-top">
              <input type="text" name="email" placeholder="Your Email Address" class="no-top">
              <input type="text" name="website" placeholder="Your Website" class="no-top">
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
            <form action="login" method="POST" class="ajax">
              {{csrf_field() }}
              <div id="error"></div>
              <input type="text" name="subject" placeholder="Subject">
              <textarea name="address" placeholder="Your Message Here" class="no-top"></textarea>
              
              <button class="btn hs-primary">Order Now</button>
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
            @if(isset($data['tradesmen']))
            <h4>ADD TRANSACTION</h4>
            <p class="sub-heading">Process a transaction with a Tradesman.</p>
            <form id="transaction" enctype="multipart/form-data">
              {{csrf_field() }}
              <div id="error"></div>
              <div class="btn-group dropdown">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                    <ul class="dropdown-menu">
                    @php($x = 0)
                    @foreach ($data['tradesmen'] as $tradesman)
                      <li>
                        <label for="b{{$x}}">{{ $tradesman['trading-name'] }}</label>
                        <input type="radio" id="b{{$x}}" name="trades" value="{{ $tradesman['id'] }}">
                      </li>
                      @php($x++)
                    @endforeach
                    </ul>
                </div>
              <input type="number" name="amount-spent" placeholder="Amount Spent" class="no-top" id="amount">
              <input type="hidden" name="property-code" value="{{$data['property'][0]['property-code']}}" id="code">
              <div class="upload-button no-top">
                <span class="label">Click to add Receipt</span>
                <input type="file" name="receipt" id="receipt">
              </div>
              
                    
                <button class="btn hs-primary" id="transaction">Order Now</button>
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
            <h4>SELECT YOUR AGENT</h4>
            </br><p class="sub-heading">Select an agency near your property location.</p>
             <div class="agents">
              
              @php($x = 0)
              @if(isset($data['agents']))
                @foreach($data['agents'] as $agent)
                  <div class="col-xs-4">
                    <a class="selectAgent" data-id="{{$agent['id']}}" data-token="{{csrf_token()}}" data-code="{{$data['code']}}">
                      <div class="col-xs-8  col-xs-offset-2 tradesman-profile">
                        <img src="{{url($agent['photo'])}}" alt="{{$agent['name']}}">
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
                @endforeach
              @endif
              
             </div>
          </div>
        </div>
      </div>
    </div>