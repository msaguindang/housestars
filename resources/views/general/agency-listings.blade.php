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
                      <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li class="active"><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @else
                      <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li class="active"><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @endif
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
    <div class="dark-bg agency">
      <section id="search-bar" class="no-margin">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
                <form action="{{env('APP_URL')}}/search/agency" method="POST">
                  {{csrf_field()}}
                  <input type="text" class="search" name="term" placeholder="Enter Agency Name or Suburb" style="margin: 0">
                  <button class="btn btn-primary">Search</button>
                </form>
            </div>
          </div>
        </div>
      </section>

      <section id="agency-results" class="dark-bg">
        <div class="container">
          <div class="row">
            @if(isset($data))
              @php ($x = count($data))
              @if(isset($data['cat']) && $x > 1)
                <p class="center">
                  Your search for a <b>{!! $data['cat'] !!}</b> generated the folowing results. Thanks for using House Stars.
                </p></br>
              @endif
              <ul class="list">
              @if($x > 1)
                  @foreach($data as $agency)
                    @if(count($agency) > 5)
                      <li>
                        <div class="col-xs-4">
                          <div class="item">
                            @if(isset($agency['cover-photo']))
                            <div class="cover-photo"  style="background: url('{{env('APP_URL')}}/{{$agency['cover-photo']}}'); background-size: cover;">
                            @else
                            <div class="cover-photo">
                            @endif
                              @if(isset($agency['profile-photo']))
                                @if(filter_var($agency['profile-photo'], FILTER_VALIDATE_URL) === FALSE)
                                  @php ($agency['profile-photo'] = env('APP_URL').'/'.$agency['profile-photo'])
                                @endif
                                <div class="agency-info">
                                  <div class="col-xs-2"><div class="profile-thumb" style="background: url('{{ $agency['profile-photo'] }}'); background-size: cover;"></div></div>
                                  <div class="col-xs-10">
                                    <h3 class="name">{{ isset($agency['agency-name']) ? $agency['agency-name'] : '' }}</h3>
                                    <p class="location">{{ isset($agency['business-address']) ? $agency['business-address'] : ''}}</p>
                                  </div>
                                </div>
                              @else
                               <div class="profile-thumb"></div>
                              @endif
                            </div>
                            <div class="profile-info">
                              @if(isset($agency['summary']))
                                <p>{{$agency['summary']}} ...</p>
                              @endif
                              <a href="{{env('APP_URL')}}/profile/agency/{{$agency['id']}}" class="btn hs-primary small">Visit Agency's Page</a>
                            </div>
                          </div>
                        </div>
                      </li>
                    @endif
                @endforeach
                @endif
              @endif
              <!-- END AD SPACE HERE -->
            </ul>
          </div>
          <div class="row">
            <div class="col-xs-9">
                <nav aria-label="Page navigation" class="pagination">
                    <ul class="pagination"></ul>
                </nav>
            </div>
          </div>
        </div>
      </section>
@endsection
