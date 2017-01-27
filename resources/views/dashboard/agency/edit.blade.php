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
 <form action="/update-profile" method="POST" enctype="multipart/form-data">
    <section id="cover-container" class="header-margin" style="background: url({{url($data['cover-photo'])}})">
     
        {{csrf_field() }}
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Agency</a> > <span class="blue">Agency Dashboard</span> </p>
            <div class="upload">
              <input id="CoverUpload" type="file" name="cover-photo"/>
            <button class="btn hs-secondary update-cover"><span class="icon icon-image"></span> Change Photo</button>
            </div>
          </div>
          <div class="profile">
            <div class="profile-img" style="background: url({{url($data['profile-photo'])}})">
              <button class="btn hs-secondary update-profile"><span class="icon icon-image"></span> Change Photo</button>
              <input id="profileupload" type="file" name="profile-photo"/>
            </div>
            <div class="profile-info">
              <label>Agency Name</label>
                  <input type="text" name="agency-name" value="{{$data['agency-name']}}">  
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="edit-user-info">
      <div class="container">
        <div class="row">
          <div class="col-xs-10 col-xs-offset-2">
            <div class="col-xs-4">
              <div id="image-holder"> </div>
              <label>ABN</label>
              <input type="text" name="abn" value="{{$data['abn']}}">
            </div>
            <div class="col-xs-4">
              <label>Address</label>
              <input type="text" name="business-address" value="{{$data['business-address']}}">
            </div>
            <div class="col-xs-4">
              <label>Base Commission Charge</label>
              <input type="text" name="base-commission" value="{{$data['base-commission']}}">
            </div>
          </div>
          <div class="col-xs-2">
              
            </div>
          <div class="col-xs-10">
            <div class="col-xs-4">
              <label>Agency Trading Name</label>
              <input type="text" name="trading-name" value="{{$data['trading-name']}}">
            </div>
            <div class="col-xs-4">
              <label>Website</label>
              <input type="text" name="website" value="{{$data['website']}}">
            </div>
            <div class="col-xs-4">
              <label>Marketing Budget</label>
              <input type="text" name="marketing-budget" value="{{$data['marketing-budget']}}">
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-2">
            <div class="col-xs-4">
              <label>Principal Name</label>
              <input type="text" name="" value="{{$data['principal-name']}}">
            </div>
            <div class="col-xs-4">
              <label>Phone</label>
              <input type="text" name="" value="{{$data['phone']}}">
            </div>
            <div class="col-xs-4">
              <label>Sales Type</label>
              <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">{{$data['sales-type']}} <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                  <ul class="dropdown-menu">
                    <li>
                      <input type="radio" id="b1" name="sales-type" value="Auction" checked>
                      <label for="b1">Auction</label>
                    </li>
                    <li>
                      <input type="radio" id="b2" name="sales-type" value="Private Treaty">
                      <label for="b2">Private Treaty</label>
                    </li>
                    <li>
                      <input type="radio" id="b3" name="sales-type" value="Off Market">
                      <label for="b3">Off Market</label>
                    </li>
                    <li>
                      <input type="radio" id="b4" name="sales-type" value="Distressed Sale">
                      <label for="b4">Distressed Sale</label>
                    </li>
                    <li>
                      <input type="radio" id="b5" name="sales-type" value="Other">
                      <label for="b5">Other</label>
                    </li>
                  </ul>
              </div>
            </div>
          </div>
       <!--    <div class="col-xs-10 col-xs-offset-2">
            <div class="upload-gallery">
              <div class="col-xs-6">
                <label>Gallery Photos</label>
                <img src="{{asset('assets/img-gallery-1.jpg')}}" alt="">
                <img src="{{asset('assets/img-gallery-1.jpg')}}" alt="">
                <img src="{{asset('assets/img-gallery-1.jpg')}}" alt="">
                <img src="{{asset('assets/img-gallery-1.jpg')}}" alt="">

              </div>
              <div class="col-xs-6">
                <label>Upload More Gallery Photos</label>
                <div class="upload-media">
                  <span> Click to Add Images</span>
                  <input type="file" name="img" multiple>
                  <button class="btn hs-upload-icon"></button>
                </div>
                
              </div>
            </div>
          </div> -->
          <div class="col-xs-10 col-xs-offset-2">
            <div class="col-xs-8">
            <label>Write Agency Summary</label>
            <textarea style="height: 150px;" name="summary">{{$data['summary']}}</textarea>
            </div>
            <div class="col-xs-4 btn-holder">
              <div class="spacing"></div>
              <button class="btn hs-primary" style="margin-bottom: 0;"><span class="icon icon-save" style="margin-top: 6px;"></span>SAVE CHANGES <span class="icon icon-arrow-right"></span></button>
            </div>
          </div>
          <div class="spacing"></div>
        </div>
      </div>
    </section>
  </form>

@endsection

 @section('scripts')
  <script type="text/javascript">
      function readURL(input, url) {
          if (input.files && input.files[0]) {
              var preview = url;
              var reader = new FileReader();

              reader.onload   = function (e) {
                  $(preview).attr('style', 'background: url(' + e.target.result + ') center top no-repeat');
              }

              reader.readAsDataURL(input.files[0]);
          }
      }

      $("#CoverUpload").change(function () {
          readURL(this, '#cover-container');
      });

      $("#profileupload").change(function () {
          readURL(this, '.profile-img');
      });


  </script>
 @stop