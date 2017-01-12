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
                    <li><a href="#" data-toggle="modal" data-target="#signup">Signup Me Up!</a></li>
                    <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                  </ul>
                </div>
              </div>
              <div class="row">
                <div class="main-nav">
                  <ul>
                    <li><span class="icon icon-customer-dark"></span><a href="/customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="/trades-services">Trades & Services</a></li>
                    <li class="active"><span class="icon icon-agency-dark"></span><a href="/agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>

    <section id="cover-container" class="header-margin">
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Agency</a> > <span class="blue">Agency Dashboard</span> </p>
            <button class="btn hs-secondary update-cover"><span class="icon icon-image"></span> Change Photo</button>
          </div>
          <div class="profile">
            <div class="profile-img" style="background: url({{asset('assets/thumb-profile.jpg')}})">
              <button class="btn hs-secondary update-profile"><span class="icon icon-image"></span> Change Photo</button>
            </div>
            <div class="profile-info">
              <label>Agency Name</label>
              <input type="text" name="" value="RJ Realty Agency">
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
              <label>Position Hold</label>
              <input type="text" name="">
            </div>
            <div class="col-xs-4">
              <label>Address</label>
              <input type="text" name="">
            </div>
            <div class="col-xs-4">
              <label>Base Commission Charge</label>
              <input type="text" name="">
            </div>
          </div>
          <div class="col-xs-2">
              <label>ABN</label>
              <input type="text" name="">
            </div>
          <div class="col-xs-10">
            <div class="col-xs-4">
              <label>Agency Trading Name</label>
              <input type="text" name="">
            </div>
            <div class="col-xs-4">
              <label>Website</label>
              <input type="text" name="">
            </div>
            <div class="col-xs-4">
              <label>Marketing Budget</label>
              <input type="text" name="">
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-2">
            <div class="col-xs-4">
              <label>Principal Name</label>
              <input type="text" name="">
            </div>
            <div class="col-xs-4">
              <label>Phone</label>
              <input type="text" name="">
            </div>
            <div class="col-xs-4">
              <label>Sales Type</label>
              <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                  <ul class="dropdown-menu">
                    <li>
                      <input type="radio" id="a1" name="ex1_3" value="1" checked="">
                      <label for="a1">Option1</label>
                    </li>
                    <li>
                      <input type="radio" id="a2" name="ex1_3" value="2">
                      <label for="a2">Option2</label>
                    </li>
                    <li>
                      <input type="radio" id="a3" name="ex1_3" value="3">
                      <label for="a3">Option3</label>
                    </li>
                  </ul>
              </div>
            </div>
          </div>
          <div class="col-xs-10 col-xs-offset-2">
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
          </div>
          <div class="col-xs-10 col-xs-offset-2">
            <div class="col-xs-4 col-xs-offset-8 btn-holder">
              <button class="btn hs-primary" style="margin-bottom: 0;"><span class="icon icon-save" style="margin-top: 6px;"></span>SAVE CHANGES <span class="icon icon-arrow-right"></span></button>
            </div>
          </div>
          <div class="spacing"></div>
        </div>
      </div>
    </section>

@endsection