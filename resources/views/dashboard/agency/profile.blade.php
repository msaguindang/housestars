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
                    <li><span class="icon icon-tradesman-dark"></span><a href="profile">Profile</a></li>
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

    <section id="cover-container" class="header-margin" style="background: url({{url($cp)}})">
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Agency</a> > <span class="blue">Agency Dashboard</span> </p>
          </div>
          <div class="profile">
            <div class="profile-img" style="background: url({{url($dp)}})">
            </div>
            <div class="profile-info">
              @foreach ($meta as $info)
                @if($info->meta_name == 'agency-name')
                  <h1>{{$info->meta_value}}</h1>
                @elseif ($info->meta_name == 'business-address')
                  <p>Location: {{$info->meta_value}}</p>
                @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="user-info">
      <div class="container">
        <div class="row">
          <div class="col-xs-9">
            <div class="statistics">
              <span class="info"><i class="fa fa-list" aria-hidden="true"></i> 50 Listings</span> <span class="info"><i class="fa fa-list" aria-hidden="true"></i> 30 Properties Sold</span>
              <div class="status">
                <span class="status-icon"></span>
                <span class="status-p">Available</span>
                <span class="rating-p">Overall Ratings</span>
                <div class="stars left">
                  @for ($i = 0; $i < 3; $i++)
                      <span class="icon icon-star"></span>
                  @endfor
                </div>
              </div>
            </div>
            <div class="description">
              @foreach ($meta as $info)
                @if($info->meta_name == 'summary')
                  <p>{{$info->meta_value}}</p>
                @endif
              @endforeach
            </div>
          </div>
          <div class="col-xs-3 nav-panel">
            <a href="edit" class="btn hs-primary" style="margin-bottom: 0;"><span class="icon icon-summary" style="margin-top: 6px;"></span>EDIT PROFILE <span class="icon icon-arrow-right"></span></a>
            <a href="settings" class="btn hs-primary"><span class="icon icon-summary" style="margin-top: 6px;"></span>ACCOUNT SETTINGS <span class="icon icon-arrow-right"></span></a>
            <div class="col-xs-8 no-padding-left">
              <p style="line-height: 30px;">Switch to Customer View</p>
            </div>
            <div class="col-xs-4">
              <label class="switch" style="margin: 0"><input type="checkbox"><div class="slider round" style="float: right;"></div></label>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="main-content" class="grey-area" style="padding: 25px; margin-top: 10px; top: -60px;">
      <div class="container">
        <div class="row">
          <div class="col-xs-9">
            <div class="row gallery">
                <h2 class="section-title">Gallery</h2>
                <a href="" class="view-all"><i class="fa fa-list" aria-hidden="true"></i> View All</a>
                <div class="gallery-carousel">
                  <div class="col-md-12" data-wow-delay="0.2s">
                      <div class="carousel slide" data-ride="carousel" id="quote-carousel" style="margin: 0; top: -60px">
                                  <a data-slide="next" href="#quote-carousel" class="right carousel-control" style="top: 0; float: right;"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                  <a data-slide="prev" href="#quote-carousel" class="left carousel-control" style="top: 0; float: right;"><i class="fa fa-angle-left" aria-hidden="true"></i></a>      
                          <div class="carousel-inner">
                            <div class="item active">
                                <div class="row">
                                  <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image">
                                      <div class="gallery-label">
                                          <span class="property-name">Property Name</span>
                                          <span class="property-location">New South Wales, Australia</span>
                                        </div> 
                                      </div>
                                      <div class="gallery-desc">
                                        <p>Classy apartment with panoramic view along the Danube from Margitsziget (Margaret Island) through the Parliament Building to Gellért hegy. Central location and lots of amenities. Excellent choice for families. </p>
                                      </div>
                                    </div>
                                  </div>

                                   <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image">
                                      <div class="gallery-label">
                                          <span class="property-name">Property Name</span>
                                          <span class="property-location">New South Wales, Australia</span>
                                        </div> 
                                      </div>
                                      <div class="gallery-desc">
                                        <p>Classy apartment with panoramic view along the Danube from Margitsziget (Margaret Island) through the Parliament Building to Gellért hegy. Central location and lots of amenities. Excellent choice for families. </p>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image">
                                      <div class="gallery-label">
                                          <span class="property-name">Property Name</span>
                                          <span class="property-location">New South Wales, Australia</span>
                                        </div> 
                                      </div>
                                      <div class="gallery-desc">
                                        <p>Classy apartment with panoramic view along the Danube from Margitsziget (Margaret Island) through the Parliament Building to Gellért hegy. Central location and lots of amenities. Excellent choice for families. </p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="item">
                               <div class="row">
                                  <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image">
                                      <div class="gallery-label">
                                          <span class="property-name">Property Name</span>
                                          <span class="property-location">New South Wales, Australia</span>
                                        </div> 
                                      </div>
                                      <div class="gallery-desc">
                                        <p>Classy apartment with panoramic view along the Danube from Margitsziget (Margaret Island) through the Parliament Building to Gellért hegy. Central location and lots of amenities. Excellent choice for families. </p>
                                      </div>
                                    </div>
                                  </div>

                                   <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image">
                                      <div class="gallery-label">
                                          <span class="property-name">Property Name</span>
                                          <span class="property-location">New South Wales, Australia</span>
                                        </div> 
                                      </div>
                                      <div class="gallery-desc">
                                        <p>Classy apartment with panoramic view along the Danube from Margitsziget (Margaret Island) through the Parliament Building to Gellért hegy. Central location and lots of amenities. Excellent choice for families. </p>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image">
                                      <div class="gallery-label">
                                          <span class="property-name">Property Name</span>
                                          <span class="property-location">New South Wales, Australia</span>
                                        </div> 
                                      </div>
                                      <div class="gallery-desc">
                                        <p>Classy apartment with panoramic view along the Danube from Margitsziget (Margaret Island) through the Parliament Building to Gellért hegy. Central location and lots of amenities. Excellent choice for families. </p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="item">
                               <div class="row">
                                  <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image">
                                      <div class="gallery-label">
                                          <span class="property-name">Property Name</span>
                                          <span class="property-location">New South Wales, Australia</span>
                                        </div> 
                                      </div>
                                      <div class="gallery-desc">
                                        <p>Classy apartment with panoramic view along the Danube from Margitsziget (Margaret Island) through the Parliament Building to Gellért hegy. Central location and lots of amenities. Excellent choice for families. </p>
                                      </div>
                                    </div>
                                  </div>

                                   <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image">
                                      <div class="gallery-label">
                                          <span class="property-name">Property Name</span>
                                          <span class="property-location">New South Wales, Australia</span>
                                        </div> 
                                      </div>
                                      <div class="gallery-desc">
                                        <p>Classy apartment with panoramic view along the Danube from Margitsziget (Margaret Island) through the Parliament Building to Gellért hegy. Central location and lots of amenities. Excellent choice for families. </p>
                                      </div>
                                    </div>
                                  </div>
                                  
                                  <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image">
                                      <div class="gallery-label">
                                          <span class="property-name">Property Name</span>
                                          <span class="property-location">New South Wales, Australia</span>
                                        </div> 
                                      </div>
                                      <div class="gallery-desc">
                                        <p>Classy apartment with panoramic view along the Danube from Margitsziget (Margaret Island) through the Parliament Building to Gellért hegy. Central location and lots of amenities. Excellent choice for families. </p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>

                            
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="row ratings">
              <h2 class="section-title">Client Reviews</h2>
              <a href="" class="view-all"><i class="fa fa-list" aria-hidden="true"></i> View All</a>
              
              <div class="col-xs-12 review-box">
                <b class="left">Tiffany Yee</b>
                <span class="date right">Posted: January 2015</span>
                <p class="left rating-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !</p>
                <button class="btn btn-helpful right"><span class="icon icon-helpful"></span> Helpful <span class="small">(200)</span></button>
                <div class="stars left">
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                </div>
              </div>
              <div class="col-xs-12 review-box">
                <b class="left">Tiffany Yee</b>
                <span class="date right">Posted: January 2015</span>
                <p class="left rating-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !</p>
                <button class="btn btn-helpful right"><span class="icon icon-helpful"></span> Helpful <span class="small">(200)</span></button>
                <div class="stars left">
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                </div>
              </div>
              <div class="col-xs-12 review-box">
                <b class="left">Tiffany Yee</b>
                <span class="date right">Posted: January 2015</span>
                <p class="left rating-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !</p>
                <button class="btn btn-helpful right"><span class="icon icon-helpful"></span> Helpful <span class="small">(200)</span></button>
                <div class="stars left">
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                </div>
              </div>
              <div class="col-xs-12 review-box">
                <b class="left">Tiffany Yee</b>
                <span class="date right">Posted: January 2015</span>
                <p class="left rating-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !</p>
                <button class="btn btn-helpful right"><span class="icon icon-helpful"></span> Helpful <span class="small">(200)</span></button>
                <div class="stars left">
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                </div>
              </div>
              <div class="col-xs-12 review-box">
                <b class="left">Tiffany Yee</b>
                <span class="date right">Posted: January 2015</span>
                <p class="left rating-p">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. !</p>
                <button class="btn btn-helpful right"><span class="icon icon-helpful"></span> Helpful <span class="small">(200)</span></button>
                <div class="stars left">
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                  <span class="icon icon-star"></span>
                </div>
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