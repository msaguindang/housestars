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

    <section class="header-margin default-page">
        <div class="container">
          <div class="breadcrumbs">
            <div class="row">
              <p class="links"><a href="">Home Page</a> > <span class="blue">Our Agent Philosophy</span> </p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="about-wrapper page">
                <h3>Our Service Philosophy.</h3>
                <p>The life of a tradie can be tough, REALLY tough. There is the start-up phase where you don't have any clients at all. Then you start to get clients, but the are the sort that you don’t want, and you start having trouble getting paid. You slowly get on your feet and then you find that there is never enough time in the day to do books, keep your customers happy and maintain a half decent lifestyle. We know. Some of our staff are tradies. Our philosophy toward Trades and Services is easy to understand. Leave them in a better position than when they first signed up. </p>

                <p>To win in the game takes a lot of work. It also takes risk, sacrifice and courage. But what if there was a blueprint of how to be successful. A step by step guide on how to be in a better position today than you were yesterday. This is it. This is the future. </p>

                <p>There is a stigma around being rated and reviewed, because people don’t want customers to know how rubbish they are. But we see it a different way. We see no more paying $5000 per year for advertising and not knowing if it actually works or not. We see people looking at your profile and choosing you because you fit into what they want. We see Tradies taking control of their advertising and driving it in the direction they want. This is the future.</p>

                <p>When you sign up with Housestars, you get ratings cards delivered to you in the mail. This is your ability to shape your profile. If it makes you lift your game in order to get a good rating, great! The key is to select your market carefully and look after them as if they were fragile eggs. Jump in a taxi, and then jump in an Uber and see what the difference is. The Uber guys are still getting paid, but they have mints, water, they can hold a conversation and they know where they are going! If you had to choose, there is no comparison. This analogy is coming to the trades and services industry. If you are a Housestars partner, we will do everything in our power to make you successful and fulfill on our Philosophy. </p>

                <p>Come with us. Trust us to help you win more clients and make your business better than that of your competition. We want you to be the best that you can be. We want you to say goodbye to the days where there is not enough time to get it all done, and hello to the days of servicing your niche market, having better quality clients who know, love and trust what you do, and having more time with your family. That’s our goal. That’s our dream, and with your help, we can create an army of trades and services that wear the Housestars badge with pride and strive to build better businesses, and better lives.</p>
                
                </br></br>
                <p>
                  <h4>Blair Rankin</h4>
                  <b>CEO</b></br>
                  <i>Housestars.com.au</i>
                </p>

              </div>
            </div>
          </div>
        </div>
    </section>



@endsection

@section('scripts')

@stop
