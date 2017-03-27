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

    <section id="cover-container" class="header-margin customer">
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Customer</a> > <span class="blue">Customer Dashboard</span> </p>
          </div>
          <div class="profile">
            <div class="profile-info">
              <h1>{{Sentinel::getUser()->name}}</h1>
              <p>Location: {{$data['meta']['address']}}</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="user-info" class="customer">
      <div class="container">
        <div class="row">
          <div class="col-xs-9">
            <div class="col-xs-3">
              <p class="telephone">{{$data['meta']['phone']}}</p>
              <p class="email">{{$data['meta']['email']}}</p>
            </div>
            <div class="col-xs-4 agency-info">
              <label>Listed Under Agency:</label>
                <h2 class="estimates">N/A</h2>
            </div>
            <div class="col-xs-3">

              <label>Estimated Commission Target</label>
              <h2 class="estimates">N/A</h2>
            </div>
            <div class="col-xs-2 terms">
              @if(isset($data['meta']['commission']))
                <p>This is an estimate only. Actual amount will vary with sale price Please see <a href="#" class="content-hyperlink">Terms & Conditions</a>.</p>
              @endif
            </div>
          </div>
          <div class="col-xs-3 nav-panel">
            <a href="{{env('APP_URL')}}/dashboard/customer/edit" class="btn hs-primary" style="margin-bottom: 0;"><span class="icon icon-summary" style="margin-top: 6px;"></span>EDIT PROFILE <span class="icon icon-arrow-right"></span></a>
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
                <label>Add a Property To be Renovated</label>
              </div>
              <div class="col-xs-8">
                <a href="{{env('APP_URL')}}/dashboard/customer/add" class="btn hs-primary" style="float: right; margin: 0 !important;">ADD PROPERTY</a>
              </div>
            </div>

            <div class="row property-info mobile-hidden">
              <div class="col-xs-12">
                <label>Processed Property</label>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Property</th>
                      <th>Type</th>
                      <th>Price</th>
                      <th>Commission</th>
                      <th>Contract</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(isset($data['property']))
                      @foreach($data['property'] as $property)
                        @if(isset($property['property-type']))
                          <tr>
                              <td><p>{{$property['suburb']}}, {{$property['state']}}</p></td>
                              <td><p>{{$property['property-type']}}</p></td>
                              <td><p>${{$property['value-from']}} - ${{$property['value-to']}}</p></td>
                              <td><p>
                              @if(isset($property['discount']))
                                ${{$property['discount']}}
                              @endif
                              </p></td>
                              @if(isset($property['contract']))
                              <td><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#{{$property['property-code']}}">Contract</button></td>
                              @else
                              <td><button type="button" class="btn btn-primary btn-xs disabled" >Contract</button></td>
                              @endif



                                @if(isset($property['process']))
                                  @if($property['process'] == 'Pending')
                                  <td style="text-align:center"><p class="bg-info">
                                    {{$property['process']}}
                                  </p></td>
                                  @else
                                  <td style="text-align:center"><p class="bg-success">
                                    {{$property['process']}}
                                  </p></td>
                                  @endif
                                @endif

                          </tr>
                        @endif
                      @endforeach
                    @endif
                  </tbody>
                </table>
              </div>
              <div class="col-xs-12">
              </div>
            </div>

            <div class="row property-info mobile">
              <div class="col-xs-12">
                <label>Processed Property</label>
                    @if(isset($data['property']))
                      @foreach($data['property'] as $property)
                        @if(isset($property['property-type']))
                          <hr>
                          <p><b>Property: </b>{{$property['suburb']}}, {{$property['state']}}</p>
                          <p><b>Type: </b>{{$property['property-type']}}</p>
                          <p><b>Price: </b>${{$property['value-from']}} - ${{$property['value-to']}}</p>
                          <p><b>Commission: </b>
                              @if(isset($property['discount']))
                                ${{$property['discount']}}
                              @endif
                              </p>
                              @if(isset($property['contract']))

                          <b>Contract: </b><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#{{$property['property-code']}}">Contract</button>
                              @else
                              <b>Contract: </b><button type="button" class="btn btn-primary btn-xs disabled" >Contract</button>
                              @endif



                                @if(isset($property['process']))
                                  @if($property['process'] == 'Pending')
                                <p><b>Status: </b>
                                    {{$property['process']}}
                                  </p>
                                  @else
                                  <p><b>Status: </b>
                                    {{$property['process']}}
                                  </p>
                                  @endif
                                @endif
                        @endif
                      @endforeach
                    @endif
              </div>
              <div class="col-xs-12">
              </div>
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

    <div id="fb-root"></div>

@endsection
