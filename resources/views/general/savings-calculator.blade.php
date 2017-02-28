@extends("layouts.main")
@section("content")
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
                     <li><a>Hi, {{Sentinel::getUser()->name}}</a></li>
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
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/profile">Profile</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="{{env('APP_URL')}}/">Home</a></li>
                    @else
                    <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="{{env('APP_URL')}}/">Home</a></li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>

    <section id="savings-calculator" class="blue-area header-margin">
      <div class="container">
        <div class="row section-title">
         <h2 class="wide"><span class="icon icon-left-bar-white"></span>Savings Estimation Calculator<span class="icon icon-right-bar-white"></span></h2>
        </div>
        <div class="calculator">
          <form>
            <div class="col-xs-4">
              <label>Name</label>
              <input type="text" name="">
              <label>Suburb</label>
              <input type="text" name="">
            </div>
            <div class="col-xs-4">
              <label>Email Address</label>
              <input type="text" name="">
              <label>Property Type</label>
              <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                  <ul class="dropdown-menu">
                    <li>
                      <input type="radio" id="all" name="all" value="all" checked="">
                      <label for="all">Any Property type</label>
                    </li>
                    <li>
                      <input type="radio" id="condo" name="condominium" value="Condominium">
                      <label for="condo">Condominium/label>
                    </li>
                    <li>
                      <input type="radio" id="commercial" name="commercial" value="Commercial">
                      <label for="commercial">Commercial</label>
                    </li>
                    <li>
                      <input type="radio" id="Apartment" name="Apartment" value="Apartment">
                      <label for="Apartment">Apartment</label>
                    </li>
                    <li>
                      <input type="radio" id="Foreclosures" name="Foreclosures" value="Foreclosures">
                      <label for="Foreclosures">Foreclosures</label>
                    </li>
                    <li>
                      <input type="radio" id="Development" name="Development" value="Development">
                      <label for="Development">Development</label>
                    </li>
                    <li>
                      <input type="radio" id="House" name="House" value="House">
                      <label for="House">House</label>
                    </li>
                    <li>
                      <input type="radio" id="Land" name="Land" value="Land">
                      <label for="Land">Land</label>
                    </li>
                  </ul>
              </div>
            </div>
            <div class="col-xs-4">
              <label>Phone Number</label>
              <input type="text" name="">
              <label>Estimated Selling Price</label>
               <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                  <ul class="dropdown-menu">
                    <li>
                      <input type="radio" id="any" name="any" value="any" checked="">
                      <label for="any">Any Price</label>
                    </li>
                    <li>
                      <input type="radio" id="option1" name="" value="$700,000 - $800,000">
                      <label for="option1">$700,000 - $800,000</label>
                    </li>
                    <li>
                      <input type="radio" id="option2" name="" value="$800,000 - $900,000">
                      <label for="option2">$800,000 - $900,000</label>
                    </li>
                    <li>
                      <input type="radio" id="option3" name="" value="$1,000,000 - $1,100,000">
                      <label for="option3">$1,000,000 - $1,100,000</label>
                    </li>
                    <li>
                      <input type="radio" id="option4" name="" value="$1,200,000 - $1,300,000">
                      <label for="option4">$1,200,000 - $1,300,000</label>
                    </li>
                    <li>
                      <input type="radio" id="option5" name="" value="$1,400,000 - $1,500,000">
                      <label for="option5">$1,400,000 - $1,500,000</label>
                    </li>
                    <li>
                      <input type="radio" id="option6" name="" value="$1,600,000 - $1,800,000">
                      <label for="option6">$1,600,000 - $1,800,000</label>
                    </li>
                    <li>
                      <input type="radio" id="option7" name="" value="$1,900,000 - $2,000,000">
                      <label for="option7">$1,900,000 - $2,000,000</label>
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

@endsection

@section('scripts')
     <script src="js/autocomplete.js"></script>
@stop