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
                     <li><a>Hi, {{$data['name']}}</a></li>
                    @else
                      <li><a href="#" data-toggle="modal" data-target="#signup">Sign Me Up</a></li>
                      <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                      <li><a href="/">Home</a></li>
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
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/dashboard/{{$category}}/profile">Profile</a></li>
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

    @if(filter_var($data['cover-photo'], FILTER_VALIDATE_URL) === FALSE)
      @php ($data['cover-photo'] = config('app.url') . '/' . $data['cover-photo'])
    @endif
    <section id="cover-container" class="header-margin" style="background: url({{$data['cover-photo']}})">
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Tradesman</a> > <span class="blue">Tradesman Dashboard</span> </p>
          </div>
          <div class="profile">
            @if(filter_var($data['profile-photo'], FILTER_VALIDATE_URL) === FALSE)
              @php ($data['profile-photo'] = config('app.url') . '/' . $data['profile-photo'])
            @endif
            <div class="profile-img" style="background: url({{$data['profile-photo']}}) 100%">
            </div>
            <div class="profile-info">
              @if(isset($data['trading-name']))
                <h1>{{$data['trading-name']}}</h1>
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
                  <h2 class="trade">{{ implode(', ', $data['trade']) }}</h2>
                @endif

              <div class="status">
                <span class="rating-p">Overall Ratings</span>
                <div class="stars left">
                  @for($i = 1; $i <= $data['rating']; $i++)
                      <span class="icon icon-star"></span>
                  @endfor
                  @php ($rating = 5 - $data['rating'])
                  @for($i = 1; $i <= $rating; $i++)
                      <span class="icon icon-star-grey"></span>
                  @endfor
                </div>
                <span class="rating-p" style="margin-left: 10px;">{{$data['total']}} Reviews</span>
                <a href="#"  class="view-summary" data-toggle="modal" data-target="#overallRatingSummary">(View Summary)</a>
              </div>
              <div class="positions">
	              <span class="label">Postcodes: </span>
	              @foreach($data['position'] as $position)
	              	<span class="position">{{$position}}</span>
	              @endforeach
              </div>
            </div>


                @if(isset($data['summary']) && $data['summary'] != '')
                  <div class="description">
                    <p>{{$data['summary']}}</p>
                  </div>
                @endif

          </div>
          <div class="col-xs-3 profile-details">
           <!--  <h3>More Details</h3> -->
            @if(is_admin())
              @php($editUrl = "/profile/tradesman/{$data['id']}/edit")
              <a href="{{ env('APP_URL') . $editUrl}}" class="btn hs-primary">EDIT PROFILE <span class="fa fa-chevron-right"></span></a>
            @endif

            <div class="info-item">
              @if(isset($data['email']))
              <div class="col-xs-2 icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
              <div class="col-xs-10 detail">
                <p> <b> Email Address </b></br><span class="detail">{{$data['email']}}</span></p>
              </div>
              @endif
            </div>
            <div class="info-item">
              @if(isset($data['abn']))
              <div class="col-xs-2 icon"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
              <div class="col-xs-10 detail">
                <p><b> ABN </b></br><span class="detail">{{$data['abn']}}</span></p>
              </div>
              @endif
            </div>
            <div class="info-item">
              @if(isset($data['charge-rate']))
              <div class="col-xs-2 icon"><i class="fa fa-usd" aria-hidden="true"></i></div>
              <div class="col-xs-10 detail">
                <p><b> Charge Rate </b></br><span class="detail">{{$data['charge-rate']}}</span></p>
              </div>
              @endif
            </div>
            <div class="info-item">
              @if(isset($data['phone-number']))
              <div class="col-xs-2 icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
              <div class="col-xs-10 detail">
                <p><b> Phone Number </b></br><span class="detail">{{$data['phone-number']}}</span></p>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="main-content" class="grey-area tradesman" style="padding: 25px; margin-top: 10px; top: -60px;">
      <div class="container">
        <div class="row">
          <div class="col-xs-9">


            <div class="row gallery mobile-hidden">
                @if(isset($data['gallery']))
                <h2 class="section-title">Gallery</h2>
                @else
                  <div class="spacing"></div>
                @endif

                <div class="gallery-carousel " id='lightgallery'>
                   @if(isset($data['gallery']))
                                @php($x = 0)
                                @php($y = 2)
                  <div class="col-md-12" data-wow-delay="0.2s">
                      <div class="carousel slide" data-ride="carousel" id="quote-carousel" style="margin: 0; top: -60px">
                        <!-- Carousel Buttons Next/Prev -->
                              <div class="controller">
                                  <a data-slide="next" href="#quote-carousel" class="right carousel-control" style="top: 0; float: right;"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                  <a data-slide="prev" href="#quote-carousel" class="left carousel-control" style="top: 0; float: right;"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                              </div>
                        <!-- Carousel Slides / Quotes -->
                          <div class="carousel-inner">
                          <!-- Gallery 1 -->


                                @php($items = count($data['gallery']) - 1)

                                @foreach($data['gallery'] as $item)
                                  @if ($x == 0 )
                                    <div class="item active">
                                      <div class="row">
                                  @endif
                                  <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <!-- <div class="gallery-image" style="background: url({{url($item)}})" data-src="{{url($item)}}"></div> -->
                                      <div class="gallery-image-wrapper" data-src="{{url($item)}}">
                                        <img src="{{url($item)}}" data-src="{{ url($item) }}">
                                      </div>
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
                        </div>
                    </div>
                </div>
                    @endif
              </div>
            </div>

            <div class="row gallery mobile">
                @if(isset($data['gallery']))
                <h2 class="section-title">Gallery</h2>
                @else
                  <div class="spacing"></div>
                @endif

                <div class="gallery-carousel ">
                   @if(isset($data['gallery']))
                                @php($x = 0)
                  <div class="col-md-12" data-wow-delay="0.2s">
                      <div class="carousel slide" data-ride="carousel" id="quote-carousel" style="margin: 0; top: -60px">
                        <!-- Carousel Buttons Next/Prev -->
                              <div class="controller">
                                  <a data-slide="next" href="#quote-carousel" class="right carousel-control" style="top: 0; float: right;"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                  <a data-slide="prev" href="#quote-carousel" class="left carousel-control" style="top: 0; float: right;"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                              </div>
                        <!-- Carousel Slides / Quotes -->
                          <div class="carousel-inner">
                          <!-- Gallery 1 -->


                                @php($items = count($data['gallery']) - 1)

                                @foreach($data['gallery'] as $item)
                                  @if ($x == 0 )
                                    <div class="item active">
                                      <div class="row">
                                  @else
                                  <div class="item">
                                    <div class="row">
                                  @endif
                                  <div class="col-xs-4">
                                    <div class="gallery-item">
                                      <!-- <div class="gallery-image" style="background: url({{url($item)}})"></div> -->
                                      <div class="gallery-image-wrapper" data-src="{{url($item)}}">
                                        <img src="{{url($item)}}" data-src="{{ url($item) }}">
                                      </div>
                                    </div>
                                  </div>
                                    </div>
                                  </div>
                                  @php($x++)

                                @endforeach
                        </div>
                    </div>
                </div>
                    @endif
              </div>
            </div>

            <div class="row ratings">
              <h2 class="section-title">Client Reviews</h2>
              @if(Sentinel::check())
              <button class="addreview btn hs-primary" data-id="{{$data['tradesman-id']}}" data-token="{{ csrf_token()}}" id="reviewBtn{{$data['tradesman-id']}}">+ Review</button>
              @else
              <button onClick="openRatingModal()" class="btn hs-primary" style="">+ Review</button>
              @endif
              <a href="" class="view-all"><i class="fa fa-list" aria-hidden="true"></i> View All</a>
              @if(isset($data['reviews']))
                @foreach($data['reviews'] as $review)
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
      @include("modals.tradesmanrating")
      @include("modals.thankyou")
      @if($businessInfo = session('businessInfo'))
        @include("rate_tradesman_modal")
      @endif
    </section>
     <script>
      function openRatingModal() {
        $('#rating').modal('show');
      }
    </script>
@endsection

@section('scripts')
  @parent
  <script>
    $toShowRatingModal = {!! session('show_rate')  ? 'true' : 'false' !!};
    if($toShowRatingModal) {
      $("#rateModal").modal('show');
    }
  </script>
  <script type="text/javascript">
    $("#lightgallery").lightGallery({
      selector: '.gallery-image-wrapper'
    });
  </script>
@endsection