@extends("layouts.main")
@section("content")
<div id="loading"><div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}" /></div></div>

    <header id="header" class="animated">
        <div class="container">
          <div class="row">
            <div class="col-xs-3 branding">
              <a href=""><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
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
                    <li><span class="icon icon-customer-dark"></span><a href="customer" >Customer</a></li>
                    <li class="active"><span class="icon icon-tradesman-dark"></span><a href="trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
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
    <div class="dark-bg">
      <section id="search-bar" class="no-margin">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <input type="text" class="search" placeholder="Enter Tradesman Name Or Business Name" style="margin: 0">
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
            @if(isset($data['cat']) && $x > 0)
            <p class="center">Your search for a <b>{{$data['cat']}}</b> in <b>{{$data['suburb']}}</b> generated the folowing results. Thanks for using House Stars.</p></br>
            @endif
            <ul class="list">
              @if($x > 0)
                @foreach($data as $tradesman)
                  @if(count($tradesman) > 5)
                    <li>
                      <div class="col-xs-3">
                        <div class="item">
                           @if(isset($tradesman['cover-photo']))
                             <div class="cover-photo" style="background: url('{{env('APP_URL')/$tradesman['cover-photo']}}'); background-size: cover;">
                            @else
                              <div class="cover-photo">
                            @endif
                           
                            @if(isset($tradesman['profile-photo']))
                              <div class="profile-thumb" style="background: url('{{env('APP_URL')/$tradesman['profile-photo']}}') no-repeat center center; background-size: cover;"></div>
                            @else
                             <div class="profile-thumb"></div>
                            @endif
                          </div>
                          <div class="profile-info">
                            <h3 class="name">{{$tradesman['business-name']}}</h3>
                            <p class="location">{{$tradesman['trade']}}</p>
                            <div class="stars">
                              @for($i = 1; $i <= $tradesman['rating']; $i++)
                                <span class="icon icon-star"></span>
                              @endfor
                              @php ($rating = 5 - $tradesman['rating'])
                              @for($i = 1; $i <= $rating; $i++)
                                <span class="icon icon-star-grey"></span>
                              @endfor
                            </div>
                            <a href="profile/tradesman/{{$tradesman['id']}}" class="btn hs-primary small">Visit Tradesman's Page</a>
                          </div>
                        </div>
                      </div>
                    </li>
                     @php ($y++)
                  @endif
                    @if($y == $z)
                   <div class="col-xs-12">
                    <div class="ads"></div>
                  </div>
                  @php($z = $z + 8)
                  @endif
              @endforeach
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
            <div class="col-xs-3">
              <a class="btn hs-primary medium search-again"><span class="icon icon-arrow-right"></span>Search Again</a>
            </div>
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
