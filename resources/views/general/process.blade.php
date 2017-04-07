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
                <h3>Process Page</h3>
                <p>The Process Page is the page where it all comes together. It lists all of the trades and services used on a site, the address and customer, the agent chosen, rebate target and sales price. As a customer, you can not receive your rebate unless you submit your Process Page. You can only submit the page after all of the criteria have been completed. This ensures that customers do not cheat the system, the ratings data remains pure and relevant, and the correct trades, services and agents are used throughout the transaction. </p>

                <p>If you have any problems with the Process Page, our staff are here to help. Housestars encourages you to create a Process Page, even if you are not in the market to sell your home. You can sell your property up to 7 years later and still claim the work that was done on the site, provided the trade or service is a Housetars partner. With this in mind, it is advantageous to log the transaction every time a trade or service comes to your house. This way, when the time comes to sell, you have a catalogue of work spanning the last 7 years that you can claim as your rebate. Note that the maximum claim is 20% of the commission charged by the agent, and if the process page is not submitted within a set time frame, you may not be eligible for your rebate once the house is sold.</p>

                <p>So create your own Process page and start renovating!</p>
              </div>
            </div>
          </div>
        </div>
    </section>



@endsection

@section('scripts')

@stop
