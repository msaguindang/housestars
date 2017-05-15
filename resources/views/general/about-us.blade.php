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

    <section id="cover-container" class="header-margin about-us">
        <div class="container">
          <div class="breadcrumbs">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <span class="blue">About Us</span> </p>
          </div>
        </div>
        <div class="row page-info">
          <h2 class="narrow"><span class="icon icon-left-bar"></span> About Housestars.com.au <span class="icon icon-right-bar"></span></h2>
          <span class="separator"></span>
          <p>
            The housestars concept was born in 2015 as a way for trades and services to connect and interact with their customers online, and as a way for property owners to maximise the return on their assets. Word of mouth, as everyone knows, is the best way to advertise for a small business but there are some problems with it. For the business, it is impossible to scale, and the message can sometimes get mixed up along the line. For the customer, it just works too slowly. If your friends or family don't know a good plasterer, you are back to taking a punt on the business that spent the most on advertising. The home improvement space was calling out for a trusted platform to connect business with customer, and that trusted space, is Housestars.
          </p>
        </div>
        </div>
    </section>

    <section id="about-content">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="about-wrapper">
              <h3>Blair Rankin</h3>
              <div class="title-main-page">
                <p>
                  Blair Rankin started an electrical business in and around Byron Bay in 2010 which focussed on helping Real Estate companies service their rent-rolls. Through this, he developed a deep working relationship and close friendship with real estate agents, principals and property managers around the area. His business model worked, and he went from arriving in the area with nothing, to hitting $1M in sales in 25 months.
                </p>
                <p>
                  He would always be thinking of ways to better his business, coming up with new ideas, concepts and strategies, which he would pitch to his agent friends. A lot of the ideas went nowhere, but some did gather traction, which were implemented with varying degrees of success.
                </p>
                <p>
                  Then in 2015, he was approached by the principal of an agency to come and join the company as an agent, with the view to becoming a co-principal. Then another agency found out about the offer, and decided to offer the same thing, saying, “we can't afford to let you go to someone else.” The fact that Blair knew nothing about selling property did not matter, as they saw the energy and drive he had inside him.
                </p>
                <p>
                  Eventually both offers fell by the wayside, but this cemented in his head that he was destined to do something else. He played to his strengths, and came up with Housestars. A company combining trades, agents, business and customer relations all into one website. He now spends his time working on his dream of building Housestars into something amazing.
                </p>
              </div>
            </div>
          </div>
          <div class="col-xs-4 hidden">
            <div class="about-wrapper">
              <h3>Customer Stories</h3>
              <hr>
              <div class="review">
                <p>Instrument cultivated alteration any favourable expression law far nor. Both new like tore but year.</p>
                <div class="col-xs-3 thumb">
                  <img src="{{(isset($comment['img'])) ? url($comment['img']) : '/assets/default.png'}}" alt="Name Here">
                </div>
                <div class="col-xs-9 details">
                  <b>Mark Zuckerberg</b></br>
                  <small>Managing Director</small></br>
                  <small>Australian Realty, LLC</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="partners">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="about-wrapper">
              <h3>OUR PARTNERS</h3>
              <hr>
              <div class="col-xs-3">
                <img src="{{asset('assets/partner-1.png')}}" alt="">
              </div>
              <div class="col-xs-3">
                <img src="{{asset('assets/partner-2.png')}}" alt="">
              </div>
              <div class="col-xs-3">
                <img src="{{asset('assets/partner-3.png')}}" alt="">
              </div>
              <div class="col-xs-3">
                <img src="{{asset('assets/partner-4.png')}}" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



@endsection

@section('scripts')

@stop
