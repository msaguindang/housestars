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
                <h3>Our agent Philosophy.</h3>
                <p>In keeping with the idea of Housestars being a win for all three parties, it is the number one priority and focus of the website to help you, our listed agents become number 1 in your suburb. Our aim is to develop a close, trusting relationship with all of our agents, based on mutual respect for each others position in the market and above all, honesty. After all, the site would be nothing without you. We know that some sales come easy, but we also know that there are some that take a lot of work. Work that vendors don't see, and work that most people don't give you credit for. Because of our close working relationship with agents, we know what makes you tick. We feel your pain, we know what drives you and we know the sacrifices you make every day in your profession. </p>
                <p>With this in mind, our philosophy is simple. If you are an agent listed on our site, thank you. We will do everything in our power to help you rise above your competition, dominate your suburb, control the flow of listings and increase your net worth. If you are an agent who is not on our site, please rethink your position. In the near future, you may find it much more difficult to attract vendors, your trusted customers may eventually leave you, your advertising will be drowned out by the signs of our affiliate agents and you may even end up closing because it's just too much pressure to continue. We would not wish that on anyone. Please join us. Together, we can do amazing things.     </p>
                <p>   The game for agents is changing every day. The real estate agency is one of the most targeted industries for digital disruption. Purple Bricks, Settl, By My Property, Sell Without Agents… Your job is to choose who is your friend and who is your enemy. Join our army of faithful followers and see the difference we can make together. </p></br></br>
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
