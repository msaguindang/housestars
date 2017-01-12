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

    <section id="cover-container" class="header-margin">
      <div class="cover-img">
        <div class="container">
          <div class="breadcrumbs">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <span class="blue">Search Category Listings</span> </p>
          </div>
        </div>
        <div class="row page-info">
          <h2 class="wide"><span class="icon icon-left-bar"></span> Search for a Tradesman or Service <span class="icon icon-right-bar"></span></h2>
          <span class="separator"></span>
          <p>Selecting your next Trade or Service with House Stars means no nasty surprises. Each of our business are rated and reviewed so you can choose the one that is best suited to your needs. Just enter your suburb below to get started.</p>
        </div>
        </div>   
      </div>
    </section>

    <section id="search-bar">
      <div class="container">
        <div class="row">
          <div class="col-xs-10">
            <input type="text" name="" placeholder="Suburb">
          </div>
          <div class="col-xs-2">
            <button class="btn hs-primary full-width search"><span class="icon icon-search"></span>SEARCH</button>
          </div>
        </div>
      </div>
    </section>


@endsection