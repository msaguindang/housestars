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

    <section id="cover-container" class="header-margin" style="background: url({{env('APP_URL')}}/{{$data['cover-photo']}})">
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Tradesman</a> > <span class="blue">Tradesman Dashboard</span> </p>
          </div>
          <div class="profile">
            <div class="profile-img" style="background: url({{env('APP_URL')}}/{{$data['profile-photo']}}) 100%">
            </div>
            <div class="profile-info">
                  
                  @if(isset($data['business-name']))
                  <h1>{{$data['business-name']}}</h1>
                  @endif
                  @if (isset($data['website']))
                  <p>Website: {{$data['website']}}</p>
                  @endif
                  
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
                @if(isset($data['trade']))
                  <h2 class="trade">{{$data['trade']}}</h2>
                  @endif
              
              <div class="status">
                <span class="rating-p">Overall Ratings</span>
                <div class="stars left">
                  @for ($i = 0; $i < 3; $i++)
                      <span class="icon icon-star"></span>
                  @endfor
                </div>
                <span class="rating-p" style="margin-left: 10px;">957 Reviews</span>
              </div>
            </div>
            <div class="description">
                
                @if(isset($data['summary']))
                  <p>{{$data['summary']}}</p>
                  @endif
            </div>
          </div>
          <div class="col-xs-3 nav-panel">
            <a href="edit" class="btn hs-primary" style="margin-bottom: 0;"><span class="icon icon-summary" style="margin-top: 6px;"></span>EDIT PROFILE <span class="icon icon-arrow-right"></span></a>
            <a href="settings" class="btn hs-primary" style="margin-bottom: 0;"><span class="icon icon-summary" style="margin-top: 6px;"></span>ACCOUNT SETTINGS <span class="icon icon-arrow-right"></span></a>
            <button class="btn hs-primary white" style="margin-bottom: 0;" data-toggle="modal" data-target="#orderBC"><span class="icon icon-summary-dark" style="margin-top: 6px;" ></span>ORDER BUSINESSCARD <span class="icon icon-arrow-right-dark"></span></button>
            <button class="btn hs-primary white" data-toggle="modal" data-target="#contact"><span class="icon icon-summary-dark" style="margin-top: 6px;"></span>CONTACT US <span class="icon icon-arrow-right-dark"></span></button>
            <div class="col-xs-8 no-padding-left">
              <p style="line-height: 30px;">Switch to Customer View</p>
            </div>
            <div class="col-xs-4">
               <label class="switch" style="margin: 0"><input type="checkbox" name="switch" value="false"><div id="switch" class="slider round" style="float: right;"></div></label>
            </div>
          </div>
          <div class="col-xs-3 profile-details" style="display: none;">
           <!--  <h3>More Details</h3> -->
            @if(isset($data['website']))
            <div class="col-xs-2 icon"><i class="fa fa-globe" aria-hidden="true"></i></div>
            <div class="col-xs-10 detail">
              <p> <b> Website </b></br><span class="detail">{{$data['website']}}</span></p>
            </div>
            @endif

            @if(isset($data['email']))
            <div class="col-xs-2 icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
            <div class="col-xs-10 detail">
              <p> <b> Email Address </b></br><span class="detail">{{$data['email']}}</span></p>
            </div>
            @endif

            @if(isset($data['abn']))
            <div class="col-xs-2 icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
            <div class="col-xs-10 detail">
              <p><b> ABN </b></br><span class="detail">{{$data['abn']}}</span></p>
            </div>
            @endif

            @if(isset($data['charge-rate']))
            <div class="col-xs-2 icon"><i class="fa fa-usd" aria-hidden="true"></i></div>
            <div class="col-xs-10 detail">
              <p><b> Charge Rate </b></br><span class="detail">${{$data['charge-rate']}}</span></p>
            </div>
            @endif
            <div class="col-xs-8 no-padding-left">
              <p style="line-height: 30px;">Switch to Customer View</p>
            </div>
            <div class="col-xs-4">
               <label class="switch" style="margin: 0"><input type="checkbox" name="switch" value="true"><div id="switch" class="slider round" style="float: right;"></div></label>
            </div>
            
          </div>
        </div>
      </div>
    </section>

    <section id="main-content" class="grey-area tradesman" style="padding: 25px; margin-top: 10px; top: -60px;">
      <div class="container">
        <div class="row">
          <div class="col-xs-9">
            <div class="row gallery">
                <h2 class="section-title">Gallery</h2>
                
                <div class="gallery-carousel ">
                  <div class="col-md-12" data-wow-delay="0.2s">
                      <div class="carousel slide" data-ride="carousel" id="quote-carousel" style="margin: 0; top: -60px">
                        <!-- Carousel Buttons Next/Prev -->
                                  <a data-slide="next" href="#quote-carousel" class="right carousel-control" style="top: 0; float: right;"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                  <a data-slide="prev" href="#quote-carousel" class="left carousel-control" style="top: 0; float: right;"><i class="fa fa-angle-left" aria-hidden="true"></i></a>      
                        <!-- Carousel Slides / Quotes -->
                          <div class="carousel-inner">
                          <!-- Gallery 1 -->
                            
                              @if(isset($data['gallery']))
                                @php($x = 0)
                                @php($y = 2)
                                
                                @php($items = count($data['gallery']) - 1)

                                @foreach($data['gallery'] as $item)
                                  @if ($x == 0 )
                                    <div class="item active">
                                      <div class="row">
                                  @endif  
                                  <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <div class="gallery-image" style="background: url({{env('APP_URL')}}/{{$item}})"></div>
                                    </div>
                                  </div>

                                  @if ($x == $items)
                                    </div>
                                  </div>

                                  @elseif($x == $y)
                                     </div>
                                  </div>
                                  <div class="item">
                                      <div class="row">
                                  @php($y = $y + 3)
                                  @endif

                                  @php($x++)

                                @endforeach
                              @else
                                <p class="no-data">No Uploaded Photos. <a href="edit">Upload Here</a></p>
                              @endif
       


                               



                            
                        </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="row ratings">
              <h2 class="section-title">Client Reviews</h2>
              <a href="" class="view-all"><i class="fa fa-list" aria-hidden="true"></i> View All</a>
              @if(isset($data['reviews']))
                @foreach($data['reviews'] as $review)
                  @if($review['content'] != '')
                  <div class="col-xs-12 review-box">
                    <!-- <b class="left"></b> -->
                    <span class="date right">Posted: {{$review['created']}}</span>
                    <p><b>{{$review['name']}}</b></p>
                    <p class="left rating-p">{{$review['content']}}</p>
                    <button class="btn btn-helpful right" id="helpful" data-id="{{$review['id']}}" data-token="{{csrf_token()}}"><span class="icon icon-helpful"></span> Helpful <span class="small" id="count-{{$review['id']}}">({{$review['helpful']}})</span></button>
                    
                    <div class="stars left">
                     
                        @for($i = 1; $i <= $review['average']; $i++)
                            <span class="icon icon-star"></span>
                        @endfor
                        @php ($rating = 5 - $review['average'])
                        @for($i = 1; $i <= $rating; $i++)
                            <span class="icon icon-star-grey"></span>
                        @endfor
                       <a href="#" data-toggle="modal" data-target="#rateReview{{$review['id']}}">(View Rate Summary)</a> 
                    </div>
                  </div>
                  @endif
                @endforeach
              @endif
             
            </div>
          </div>
            <div class="col-xs-3 sidebar">
              <div class="advertisement">
                @if(isset($data['advert']))
                  @foreach($data['advert'] as $ad)
                    <div class="ads" style="background: url({{env('APP_URL')}}/{{$ad['url']}})"></div>
                  @endforeach
                @endif
              </div>
            </div>
        </div>
      </div>
    </section>

@endsection