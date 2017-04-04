@extends("layouts.main")
@section("content")
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
                      <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li class="active"><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @else
                      <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li class="active"><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
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

    <section id="how-it-works" class="grey-area no-top-margin tradesman small-btm-margin">
      <div class="container">
        <div class="row section-title">
          <h2 class="narrower"><span class="icon icon-left-bar"></span>OUR EASY PROCESS <span class="icon icon-right-bar"></span></h2>
          <span class="separator"></span>
          <p>Signing up with Housestars is the best decision you will make all year. It's cheap, easy and will help you get more customers and more money! </br> Here's how:</p>
        </div>
        <div class="row steps">
          <div class="left">
            <!---- STEP ONE ---->
            <div class="step-image stepOne desktop">
              <img src="assets/img-agent.png" alt="Step 1: Sign up as a Trade or Service">
            </div>

            <!---- STEP 2 ---->
            <div class="step-description stepTwo animated desktop">
              <div class="description-box-right">
                <h3>Get Listed in our System</h3>
                <p>You will be listed next to all of the other similar businesses in your area. Every time someone rates you, your listing goes to the top of the page, so its important to ask people to rate you on every job, including the ones that don't go so well. 100 comments at 3 stars is better than 5 comments at 5 stars.</p>
              </div>
            </div>

            <!---- STEP 3 ---->
            <div class="step-image stepThree desktop">
              <img src="assets/img-city.png" alt="Step 3: Get Hired to do a Task">
            </div>

          </div>
          <div class="divider"></div>
          <div class="right">
            <!---- STEP ONE ---->
             <div class="step-description stepOne animated">
              <div class="description-box-left">
               <h3>Sign up as a Trade or Service</h3>
                <p>When you sign up, you create a profile page which people will use to help them choose the business that is right for them. They can see all of your details, as well as ratings from past customers. The better your profile looks, the more work you will win.</p>
              </div>
            </div>

            <!---- STEP 2 ---->
            <div class="step-image stepTwo desktop">
              <img src="assets/img-list.png" alt="Step 2: Get Listed in our System">
            </div>

            <div class="step-description stepTwo animated tablet">
              <div class="description-box-left">
                <h3>Get Listed in our System</h3>
                <p>You will be listed next to all of the other similar businesses in your area. Every time someone rates you, your listing goes to the top of the page, so its important to ask people to rate you on every job, including the ones that don't go so well. 100 comments at 3 stars is better than 5 comments at 5 stars.</p>
              </div>
            </div>

            <!---- STEP 3 ---->
            <div class="step-description stepThree animated">
              <div class="description-box-left">
                <h3>Get Hired to do a Task</h3>
                <p>Customers will see your profile and call you to do some work. You do the work and bill them as you normally would. Its a great way to gain new, high quality customers for your business, boost your revenue and increase your local reputation. Put simply, its the best advertising money you will spend all year. <a href="#" class="content-hyperlink">(see our trade/service FAQ for more details)</a></p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>

    <section id="how-we-help" class="tradesman">
      <div class="container">
        <div class="row section-title">
          <h2 class="wide"><span class="icon icon-left-bar"></span>what we can offer your business<span class="icon icon-right-bar"></span></h2>
         <span class="separator"></span>
        </div>
        <div class="row widget">
          <div class="col-xs-4 animated">
            <h3>Access to great new clients</h3>
            <p>We all know that there are some clients out there that you just don't want to work for. Housestars targets a unique section of the community who have all the right signs that they are going to be great customers for years to come. They have money, they have a time frame, AND they are less critical about the price because they know they will get that money back when they sell.</p>
            <div class="featured-img mobile-hidden">
              <img src="assets/img-square-agent.png" alt="Want to sell a property?">
            </div>
          </div>
          <div class="col-xs-4 animated">
            <h3>Great advertising value </br>for money</h3>
            <p>If you only have a small advertising budget, you should definitely put it here. House Stars tracks and measures how many people look at your profile and have used your service, to show you if it is working for you. Every time your receive a rating, your profile goes to the top of the list, so if all of your customers rate you, you stay on top!</p>
            <div class="featured-img mobile-hidden">
              <img src="assets/img-house.png" alt="are you a trade or service?">
            </div>
          </div>
          <div class="col-xs-4 animated">
            <h3>Get in early and stay ahead </br>of the game</h3>
            <p>The future of the trades and services industry is "If they cant see you, they cant trust you." Our database will be around for a long time and the more ratings you have, the more people will trust and use you. Start building your profile today and watch the new clients </br>come rolling in.</p>
            <div class="featured-img mobile-hidden">
              <img src="assets/img-agentcalling.png" alt="Are you an agent?">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="agent-price-guide" class="grey-area tradesman">
      <div class="container">
        <div class="row">
          <div class="section-title">
             <h2 class="wide"><span class="icon icon-left-bar"></span>TRADE AND SERVICE PRICE GUIDE<span class="icon icon-right-bar"></span></h2>
             <span class="separator"></span>
          </div>
          <div class="col-xs-8 col-xs-offset-2">
            <ul class="pricing">
              <li><p><span class="icon icon-price"></span><b>1 listing</b> = $50 per month direct debited from your account (Total of $600 per year)</p>
                  </br><b class="indent" style="text-align: center">OR</b></br> </br>
                  <p><span class="icon icon-price"></span><b>1 listing</b> = $550 paid in full at the start of your annual subscription </p></br>
                  <b class="indent">PLUS</b></br></br>
                  <p class="indent">   If 2 other trade/service businesses sign up using your ABN as a promotion code, and you paid in full at the beginning of your subscription, your subscription will increase by 12 months (Total of $550 for 24 months)</p>
              </li>
            </ul>
            </div>
        </div>
      </div>
    </section>

@endsection
