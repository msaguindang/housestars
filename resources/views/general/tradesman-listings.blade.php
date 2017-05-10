@extends("layouts.main")
@section("content")
<div id="loading"><div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}" /></div></div>

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

  <div id="tradesmanList">
    <section id="cover-container" class="header-margin tradesman-listings">
      <div class="cover-img">
        <div class="container">
          <div class="breadcrumbs">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Category Listings </a> > <span class="blue">Tradesman Listings</span> </p>
          </div>
        </div>
        <div class="row page-info" style="margin-top: 50px">
          <h2 class="narrower"><span class="icon icon-left-bar"></span> Tradesman Listings <span class="icon icon-right-bar"></span></h2>
          <span class="separator"></span>
        </div>
        </div>
      </div>
    </section>
    <div class="dark-bg tradesman">
      <section id="search-bar" class="no-margin">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <input type="text" class="search" placeholder="Enter Tradesman Name Or Business Name" style="margin: 0">
              <!-- <form action="{{ route('search.item', ['item' => 'category']) }}" method="POST">
                  {{csrf_field()}}
                <input type="text" name="suburb" class="search" placeholder="Enter Tradesman Name Or Business Name" style="margin: 0">
                <button class="btn btn-primary">Search</button>
              </form> -->
            </div>
          </div>
        </div>
      </section>

      <section id="tradesman-results" class="dark-bg">
        <div class="container">
          <div class="row">
            @php ($x = count($data))
            @php ($y = 0)
            @php ($z = 4)
            @php ($a = 4)
            @php ($index = 0)

            @if(isset($data['cat']) && $x > 0)
              @if($data['suburb'])
                <!--  a <b>{{ $data['cat'] }}</b> in -->
                <p class="center">Your search for <b>{{ $data['suburb'] }}</b> generated the folowing results. Thanks for using Housestars.</p></br>
              @endif
            @endif
            <ul class="list">
              @if($x > 0)
                @foreach($data as $tradesman)
                  @if(count($tradesman) > 5)
                    <li>
                      <div class="col-xs-3">
                        <div class="item">
                           @if(isset($tradesman['cover-photo']))
                              @if(filter_var($tradesman['cover-photo'], FILTER_VALIDATE_URL) === FALSE)
                                @php ($tradesman['cover-photo'] = config('app.url') . '/' . $tradesman['cover-photo'])
                              @endif
                              <div class="cover-photo" style="background: url('{{ $tradesman['cover-photo'] }}'); background-size: cover;">
                            @else
                              <div class="cover-photo">
                            @endif

                            @if(isset($tradesman['profile-photo']))
                              @if(filter_var($tradesman['profile-photo'], FILTER_VALIDATE_URL) === FALSE)
                                @php ($tradesman['profile-photo'] = config('app.url') . '/' . $tradesman['profile-photo'])
                              @endif
                              <div class="profile-thumb" style="background: url('{{ $tradesman['profile-photo'] }}') no-repeat center center; background-size: cover;"></div>
                            @else
                             <div class="profile-thumb"></div>
                            @endif
                          </div>
                          <div class="profile-info">
                            <h3 class="name">{{ isset($tradesman['trading-name']) ? $tradesman['trading-name'] : 'N/A' }}</h3>
                            <p class="location">{{ isset($tradesman['trade']) ? $tradesman['trade'] : ''}}</p>
                            @if(isset($tradesman['rating']))
                              <div class="stars">
                                @for($i = 1; $i <= $tradesman['rating']; $i++)
                                  <span class="icon icon-star"></span>
                                @endfor
                                @php ($rating = 5 - $tradesman['rating'])
                                @for($i = 1; $i <= $rating; $i++)
                                  <span class="icon icon-star-grey"></span>
                                @endfor
                              </div>
                            @endif
                            <a href="{{env('APP_URL')}}/profile/tradesman/{{ $tradesman['id'] }}" class="btn hs-primary small">Visit Tradesman's Page</a>
                          </div>
                        </div>
                      </div>
                    </li>
                     @php ($y++)
                  @endif
                  @if($x > 7 )
	                   @if($y == $z )
	                   <div class="col-xs-12">
	                    <div class="ads">
	                      @if(isset($data['ads']) && $data['ads'])
	                        <img src="/{{ $data['ads']['image_path'] }}" alt="{{ $data['ads']['name'] }}" width="100%" height="100%">                        
	                      @endif
	                    </div>
	                  </div>
	                  @php($z = $z + 8)
	                  @endif
                  @else
	                  @if($y == ($x - 3) && count($tradesman) > 5)
	                   <div class="col-xs-12">
	                    <div class="ads">
	                      @if(isset($data['ads']) && $data['ads'])
	                        <img src="/{{ $data['ads']['image_path'] }}" alt="{{ $data['ads']['name'] }}" width="100%" height="100%">                        
	                      @endif
	                    </div>
	                  </div>
	                  @endif
                  @endif
                  @php ($index ++)
                  
              @endforeach
              @endif
              <!-- END AD SPACE HERE -->
            </ul>
          </div>
          <div class="row">
            <div class="col-xs-6">
                <nav aria-label="Page navigation" class="pagination">
                    <ul class="pagination"></ul>
                </nav>
            </div>
            <div class="col-xs-6">
                <button class="btn hs-primary medium" data-toggle="modal" data-target="#noTradesmen" style="float:right;width: 50%;margin-top: 40px;"><span class="icon icon-arrow-right"></span>Suggest a Tradesman</button>
            </div>
            <!-- <div class="col-xs-3">
              <a class="btn hs-primary medium search-again"><span class="icon icon-arrow-right"></span>Search Again</a>
            </div> -->
          </div>
        </div>
      </section>
    </div>
  </div>


@endsection


@section('scripts')
<script type="text/javascript">
 var tradesmanList = new List('tradesmanList', {
    valueNames: ['name'],
    page: 9,
    pagination: true
  });
</script>
@stop
