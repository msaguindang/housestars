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
    
    <section id="cover-container" class="header-margin tradesman-listings">
      <div class="cover-img">
        <div class="container">
          <div class="breadcrumbs">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Agency Listings </a> > <span class="blue">Agency Listings</span> </p>
          </div>
        </div>
        <div class="row page-info" style="margin-top: 50px">
          <h2 class="narrower"><span class="icon icon-left-bar"></span> Agency Listings <span class="icon icon-right-bar"></span></h2>
          <span class="separator"></span>
        </div>
        </div>   
      </div>
    </section>
    <div class="dark-bg">
      <section id="search-bar" class="no-margin">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <p class="center">Your search for a Agents in Abbotsford Suburb generated the folowing results. Thanks for using House Stars.</p>
            </div>
          </div>
        </div>
      </section>

      <section id="tradesman-results" class="dark-bg">
        <div class="container">
          <div class="row">
            <div class="col-xs-3">
              <div class="item">
                <div class="cover-photo">
                  <div class="profile-thumb"></div>
                </div>
                <div class="profile-info">
                  <h3 class="name">John Joe Smith</h3>
                  <p class="location">29 Some Avenue, NSW, Australia</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                  <a class="btn hs-primary small">Visit Agent's Page</a>
                </div>
              </div>
            </div>
            <div class="col-xs-3">
              <div class="item">
                <div class="cover-photo">
                  <div class="profile-thumb"></div>
                </div>
                <div class="profile-info">
                  <h3 class="name">John Joe Smith</h3>
                  <p class="location">29 Some Avenue, NSW, Australia</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                  <a class="btn hs-primary small">Visit Agent's Page</a>
                </div>
              </div>
            </div>
            <div class="col-xs-3">
              <div class="item">
                <div class="cover-photo">
                  <div class="profile-thumb"></div>
                </div>
                <div class="profile-info">
                  <h3 class="name">John Joe Smith</h3>
                  <p class="location">29 Some Avenue, NSW, Australia</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                  <a class="btn hs-primary small">Visit Agent's Page</a>
                </div>
              </div>
            </div>
            <div class="col-xs-3">
              <div class="item">
                <div class="cover-photo">
                  <div class="profile-thumb"></div>
                </div>
                <div class="profile-info">
                  <h3 class="name">John Joe Smith</h3>
                  <p class="location">29 Some Avenue, NSW, Australia</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                  <a class="btn hs-primary small">Visit Agent's Page</a>
                </div>
              </div>
            </div>

            <!--AD SPACE HERE -->
            <div class="col-xs-12">
              <div class="ads"></div>
            </div>
            <!-- END AD SPACE HERE -->

            <div class="col-xs-3">
              <div class="item">
                <div class="cover-photo">
                  <div class="profile-thumb"></div>
                </div>
                <div class="profile-info">
                  <h3 class="name">John Joe Smith</h3>
                  <p class="location">29 Some Avenue, NSW, Australia</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                  <a class="btn hs-primary small">Visit Agent's Page</a>
                </div>
              </div>
            </div>
            <div class="col-xs-3">
              <div class="item">
                <div class="cover-photo">
                  <div class="profile-thumb"></div>
                </div>
                <div class="profile-info">
                  <h3 class="name">John Joe Smith</h3>
                  <p class="location">29 Some Avenue, NSW, Australia</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                  <a class="btn hs-primary small">Visit Agent's Page</a>
                </div>
              </div>
            </div>
            <div class="col-xs-3">
              <div class="item">
                <div class="cover-photo">
                  <div class="profile-thumb"></div>
                </div>
                <div class="profile-info">
                  <h3 class="name">John Joe Smith</h3>
                  <p class="location">29 Some Avenue, NSW, Australia</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                  <a class="btn hs-primary small">Visit Agent's Page</a>
                </div>
              </div>
            </div>
            <div class="col-xs-3">
              <div class="item">
                <div class="cover-photo">
                  <div class="profile-thumb"></div>
                </div>
                <div class="profile-info">
                  <h3 class="name">John Joe Smith</h3>
                  <p class="location">29 Some Avenue, NSW, Australia</p>
                  <div class="stars">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
                  <a class="btn hs-primary small">Visit Agent's Page</a>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
              <ul class="pagination-items">
                <a href="#"><li>First</li></a>
                <a href="#"><li>Previous</li></a>
                <a href="#" class="selected"><li>1</li></a>
                <a href="#"><li>2</li></a>
                <a href="#"><li>3</li></a>
                <a href="#"><li>4</li></a>
                <a href="#"><li>5</li></a>
                <a href="#"><li>Next</li></a>
                <a href="#"><li>Last</li></a>
              </ul>
            </div>
            <div class="col-xs-3">
              <a class="btn hs-primary medium search-again"><span class="icon icon-arrow-right"></span>Search Again</a>
            </div>
          </div>
        </div>
      </section>
    </div>


@endsection