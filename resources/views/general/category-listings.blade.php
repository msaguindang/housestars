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
                    <li><a href="#" data-toggle="modal" data-target="#signup">Signup Me Up!</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="main-nav">
                  <ul>
                    <li><span class="icon icon-customer-dark"></span><a href="/customer" >Customer</a></li>
                    <li class="active"><span class="icon icon-tradesman-dark"></span><a href="/trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="/agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>

    <section id="page-breadcrumbs" class="header-margin dark-bg">
      <div class="container">
        <div class="breadcrumbs">
          <div class="row">
            <p class="links"><a href=""> Home Page</a> > <a href=""> Search Category Listings</a> > <span class="blue"> Category Listings</span> </p>
          </div>
        </div>
      </div>   
    </section>

    <section id="search-results" class="category-listings dark-bg">
      <div class="container">
        <div class="row section-heading">
          <div class="col-xs-2"><button class="btn hs-primary small"><span class="icon icon-arrow-left"></span>SEARCH AGAIN</button></div>
          <div class="col-xs-8 section-title">
            <h2 class="secondary-title">Trades And Services</h2>
            <p>Displaying search results for location: <b class="suburb">Adelaide</b></p>
          </div>
        </div>
        <div class="row category">
          <div class="col-xs-4 item">
            <a href="#"><span class="icon icon-hammer"></span> Carpenter <span class="icon icon-arrow-right-blue"></span></a>
          </div>
          <div class="col-xs-4 item">
            <a href="#"><span class="icon icon-trade"></span> Gardener <span class="icon icon-arrow-right-blue"></span></a>
          </div>
          <div class="col-xs-4 item">
            <a href="#"><span class="icon icon-wrench"></span> Plumber <span class="icon icon-arrow-right-blue"></span></a>
          </div>
          <div class="col-xs-4 item">
            <a href="#"><span class="icon icon-brush"></span> Painter <span class="icon icon-arrow-right-blue"></span></a>
          </div>
          <div class="col-xs-4 item">
            <a href="#"><span class="icon icon-clipper"></span> Electrician <span class="icon icon-arrow-right-blue"></span></a>
          </div>
          <div class="col-xs-4 item">
            <a href="#"><span class="icon icon-hammer"></span> Cable Guy <span class="icon icon-arrow-right-blue"></span></a>
          </div>
          <div class="col-xs-4 item">
            <a href="#"><span class="icon icon-hammer"></span> Housekeeping <span class="icon icon-arrow-right-blue"></span></a>
          </div>
          <div class="col-xs-4 item">
            <a href="#"><span class="icon icon-hammer"></span> Carpenter <span class="icon icon-arrow-right-blue"></span></a>
          </div>
          <div class="col-xs-4 item">
            <a href="#"><span class="icon icon-hammer"></span> Carpenter <span class="icon icon-arrow-right-blue"></span></a>
          </div>
          <div class="col-xs-4">
            <button class="btn hs-primary medium"><span class="icon icon-arrow-right"></span>The category I am looking for is not here</button>
          </div>
          <div class="spacing"></div>
        </div>
      </div>
    </section>
  
@endsection