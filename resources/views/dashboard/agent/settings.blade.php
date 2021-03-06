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

    <section id="edit-user-info" class="header-margin">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="row no-padding">
              <div class="spacing"></div>
              <h2 class="section-title">Account Settings</h2>
              <div class="col-xs-6">
              <form action="{{env('APP_URL')}}/update-settings" method="POST" enctype="multipart/form-data">
                {{csrf_field() }}
                <label>Full Name</label>
                <input type="text" name="name" value="{{$data['name']}}">
                <label>Email <span class="font-weight: 300; font-style: italic">(You can't edit this field)</span></label>
                <input type="text" name="email" value="{{$data['email']}}" disabled>
                <label>Password</label>
                <input type="password" name="password" placeholder="********">
                 <button class="btn hs-primary update-settings"><span class="icon icon-summary" style="margin-top: 6px;"></span>UPDATE SETTINGS <span class="icon icon-arrow-right"></span></button>
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