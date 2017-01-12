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
                    <li class="active"><span class="icon icon-customer-dark"></span><a href="/customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="/trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="/agency">Agency</a></li>
                    <li ><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>

    <section id="cover-container" class="header-margin customer">
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Customer</a> > <span class="blue">Customer Dashboard</span> </p>
          </div>
          <div class="profile">
            <div class="profile-info">
              <h1>Jack Black</h1>
              <p>Location: East Bunbury, Australia</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="user-info" class="customer">
      <div class="container">
        <div class="row">
          <div class="col-xs-9">
            <div class="col-xs-4">
              <p class="telephone">000-000-000</p>
              <p class="email">jackblack@ljbrookerbyronbay.com</p>
            </div>
            <div class="col-xs-3 agency-info">
              <label>Listed Under Agency:</label>
              <h2 class="agency-name">LJ Hooker Byron Bay</h2>
              <div class="stars left">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
            </div>
            <div class="col-xs-3">
              <label>Estimated Commission Target</label>
              <h2 class="estimates">$3,000</h2>
            </div>
            <div class="col-xs-2 terms"> 
              <p>This is an estimate only. Actual amount will vary with sale price Please see <a href="#" class="content-hyperlink">Terms & Conditions</a>.</p>
            </div>
          </div>
          <div class="col-xs-3 nav-panel">
            <button class="btn hs-primary" style="margin-bottom: 0;"><span class="icon icon-summary" style="margin-top: 6px;"></span>EDIT PROFILE <span class="icon icon-arrow-right"></span></button>
          </div>
        </div>
      </div>
    </section>

    <section id="main-content" class="grey-area" style="padding: 25px; margin-top: 10px;">
      <div class="container">
        <div class="row">
          <div class="col-xs-9 processing-form">
            <div class="row property-info">
              <div class="col-xs-4">
                <label>Property To be Renovated</label>
              </div>
              <div class="col-xs-8">
                <h3>20 Rockwell Heights, Abbotsford, NSW</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-8">
                <h3 class="left">ESTIMATED COMMISSION DISCOUNT</h3>
              </div>
              <div class="col-xs-4">
                <h3 class="estimated-amount">$3,000</h3>
              </div>
              <div class="col-xs-12 section-title">
                <h4>Trades and Services</h4>
              </div>
              <div class="entry">
                <ul>
                  <li>
                    <div class="label">
                      <h4>Afterglow Electrical</h4>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c1" name="cc" />
                        <label for="c1"><span></span></label>
                      </div>
                      <div class="stars">
                        <span class="icon icon-star"></span>
                        <span class="icon icon-star"></span>
                        <span class="icon icon-star"></span>
                        <span class="icon icon-star"></span>
                        <span class="icon icon-star"></span>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Picture of receipt</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c2" name="cc" />
                        <label for="c2"><span></span></label>
                      </div>
                      <div class="picture">
                        <img src="{{asset('assets/img-gallery-1.jpg')}}" alt="">
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Amount Spent</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c3" name="cc" />
                        <label for="c3"><span></span></label>
                      </div>
                      <div class="amount">
                        <h4>$3,000</h4>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="entry">
                <ul>
                  <li>
                    <div class="label">
                      <h4>Captain Carpentry</h4>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c1" name="cc" />
                        <label for="c1"><span></span></label>
                      </div>
                      <div class="stars">
                        <span class="icon icon-star"></span>
                        <span class="icon icon-star"></span>
                        <span class="icon icon-star"></span>
                        <span class="icon icon-star"></span>
                        <span class="icon icon-star"></span>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Picture of receipt</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c2" name="cc" />
                        <label for="c2"><span></span></label>
                      </div>
                      <div class="picture">
                        <img src="{{asset('assets/img-gallery-1.jpg')}}" alt="">
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Amount Spent</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c3" name="cc" />
                        <label for="c3"><span></span></label>
                      </div>
                      <div class="amount">
                        <h4>$3,000</h4>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-xs-3 sidebar">
            <div class="advertisement">
              <div class="ads"></div>
              <div class="ads"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection