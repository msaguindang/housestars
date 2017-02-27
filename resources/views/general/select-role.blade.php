  @extends("layouts.main")
  @section("content")
    <header id="header" class="animated">
        <div class="container">
          <div class="row">
            <div class="col-xs-3 branding">
              <a href="/"><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
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

  <section id="select-role" class="header-margin">
  <div class="container">
    <div class="row">
      <h2>Select an account type</h2>
      <div class="col-xs-4">
        <div class="option">
          <h3>Agency</h3>
          <p>Need more listings? could you do with a great funnel for attracting new interest to your company? Fancy yourself as being number 1 in your suburb? hit the video below to see what the benefits are for you.</p>

          <a class="btn hs-primary" style="width: 100%; text-align: center; margin-top: 30px;" href="/assign-role/agency/">Select Agency</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="option">
          <h3>Tradesman</h3>
          <p>House Stars is a fantastic way to boost your customer base and increase your sales. Watch the video below to check out the benefits of becoming a House Star.</p>

          <a class="btn hs-primary" style="width: 100%; text-align: center; margin-top: 30px;" href="/assign-role/tradesman/">Select Tradesman</a>
        </div>
      </div>
      <div class="col-xs-4">
        <div class="option">
          <h3>Customer/Vendor</h3>
          <p>There’s no better way to sell your property than with House Stars. The best team with the best results at the best prices.</p>

          <a class="btn hs-primary" style="width: 100%; text-align: center; margin-top: 30px;" href="/assign-role/customer/">Select Customer</a>
        </div>
      </div>
      </div>
    </div>
  </div>
</section>

    @endsection