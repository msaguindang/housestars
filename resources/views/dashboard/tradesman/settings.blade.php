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
    @php ($coverPhoto = (isset($data['cover-photo']) ? $data['cover-photo'] : 'assets/default_cover_photo.jpg'))
    <section id="cover-container" class="header-margin" style="background: url({{ url($coverPhoto) }})">
      
        {{csrf_field() }}
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Tradesman</a> > <span class="blue">Tradesman Settings</span> </p>
          </div>
        </div>
      </div>
    </section>

    <section id="settings">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="row no-padding">
              <div class="spacing"></div>
              <div class="col-xs-6">
                <h2 class="section-title">Account Settings</h2>
              <form action="{{env('APP_URL')}}/update-settings" method="POST" enctype="multipart/form-data">
                {{csrf_field() }}
                <label>Full Name</label>
                <input type="text" name="name" value="{{$data['name']}}" required>
                <label>Email</label>
                <input type="text" name="email" value="{{$data['email']}}" required>
                <label>Password</label>
                <input type="password" name="password" placeholder="********">
                 <button class="btn hs-primary update-settings"><span class="icon icon-summary" style="margin-top: 6px;"></span>UPDATE SETTINGS <span class="icon icon-arrow-right"></span></button>
              </form>
              </div>
              <div class="col-xs-6 ">
                <h2 class="section-title">Subscription Details</h2>
                  <div class="subscription-details row">
                    <div class="col-xs-5 no-padding">
                      <span class="subs-label">Plan: </span><span class="subs-value">{{$data['plan']}}</span>
                    </div>
                    <div class="col-xs-3 no-padding">
                      <span class="subs-label">Status: </span><span class="subs-value">{{$data['subscription-status']}}</span>
                    </div>
                    <div class="col-xs-4 no-padding">
                      <span class="subs-label">End: </span><span class="subs-value">{{$data['subscription-expiry']}}</span>
                    </div>
                  </div>

                  <div class="subscription-payment row">
                     <form action="{{ env('APP_URL') }}/update-payment" method="POST" enctype="multipart/form-data">
                      {{csrf_field() }}
                      @if(session('error'))
                        <div class="alert alert-danger">
                          {{session('error')}}
                        </div>
                        @endif
                      <label>Credit Card</label>
                      <input type="text" name="credit-card" value="**** **** **** {{$data['credit-card']}}">

                      <div class="col-xs-8 no-padding" >
                        <label>Expiry Date</label>
                        <div class="btn-group" style="width: 40%">
                           <input type="text" size="2" name="exp_month" value="{{$data['expiry-month']}}">
                        </div> / <div class="btn-group" style="width: 50%">
                            <input type="text" size="2" name="exp_year" value="{{$data['expiry-year']}}">
                      </div>
                      </div>
                      <div class="col-xs-4" style="padding-right: 0;">
                      <label>CVC</label>
                      <input type="text" name="cvc" placeholder="***">
                      </div>
                      <button class="btn hs-primary update-settings"><span class="icon icon-summary" style="margin-top: 6px;"></span>UPDATE CARD DETAILS <span class="icon icon-arrow-right"></span></button>
                    </form>
                  </div>


              </div>
            </div>
          <div class="spacing"></div>
        </div>
      </div>
    </section>

@endsection

 @section('scripts')

    <script src="{{asset('js/jquery.repeater.js')}}"></script>
    <script src="{{asset('js/bootstrap-toggle.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('.repeater').repeater({});
        });

        $(function() {
          $('#select-state').selectize({
              maxItems: 3
          });
        });


    </script>
 @stop
