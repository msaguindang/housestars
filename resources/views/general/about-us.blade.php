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
                      <li class="active"><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @else
                      <li class="active"><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>

    <section id="cover-container" class="header-margin about-us">
        <div class="container">
          <div class="breadcrumbs">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <span class="blue">About Us</span> </p>
          </div>
        </div>
        <div class="row page-info">
          <h2 class="narrow"><span class="icon icon-left-bar"></span> About Housestars.com.au <span class="icon icon-right-bar"></span></h2>
          <span class="separator"></span>
          <p>Out too the been like hard off. Improve enquire welcome own beloved matters her. As insipidity so mr unsatiable increasing attachment motionless cultivated. Addition mr husbands unpacked occasion he oh. Is unsatiable if projecting boisterous insensible. It recommend be resolving pretended middleton.
</p>
          <p>Or kind rest bred with am shed then. In raptures building an bringing be. Elderly is detract tedious assured private so to visited. Do travelling companions contrasted it. Mistress strongly remember up to. Ham him compass you proceed calling detract. Better of always missed we person mr. September smallness northward situation few her certainty something. </p>
        </div>
        </div>
    </section>

    <section id="about-content">
      <div class="container">
        <div class="row">
          <div class="col-xs-8">
            <div class="about-wrapper">
              <h3>Or kind rest bred with am shed then.</h3>
              <p>Instrument cultivated alteration any favourable expression law far nor. Both new like tore but year. An from mean on with when sing pain. Oh to as principles devonshire companions unsatiable an delightful. The ourselves suffering the sincerity. Inhabit her manners adapted age certain. Debating offended at branched striking be subjects. </p>
              <p>Enjoyed minutes related as at on on. Is fanny dried as often me. Goodness as reserved raptures to mistaken steepest oh screened he. Gravity he mr sixteen esteems. Mile home its new way with high told said. Finished no horrible blessing landlord dwelling dissuade if. Rent fond am he in on read. Anxious cordial demands settled entered in do to colonel. </p>
              <p>She travelling acceptance men unpleasant her especially entreaties law. Law forth but end any arise chief arose. Old her say learn these large. Joy fond many ham high seen this. Few preferred continual sir led incommode neglected. Discovered too old insensible collecting unpleasant but invitation. </p>
              <p>Prevailed sincerity behaviour to so do principle mr. As departure at no propriety zealously my. On dear rent if girl view. First on smart there he sense. Earnestly enjoyment her you resources. Brother chamber ten old against. Mr be cottage so related minuter is. Delicate say and blessing ladyship exertion few margaret. Delight herself welcome against smiling its for. Suspected discovery by he affection household of principle perfectly he. </p>
            </div>
          </div>
          <div class="col-xs-4">
            <div class="about-wrapper">
              <h3>Customer Stories</h3>
              <hr>
              <div class="review">
                <p>Instrument cultivated alteration any favourable expression law far nor. Both new like tore but year.</p>
                <div class="col-xs-3 thumb">
                  <img src="{{(isset($comment['img'])) ? url($comment['img']) : '/assets/default.png'}}" alt="Name Here">
                </div>
                <div class="col-xs-9 details">
                  <b>Mark Zuckerberg</b></br>
                  <small>Managing Director</small></br>
                  <small>Australian Realty, LLC</small>
                </div>
              </div>
              <hr>
              <div class="review">
                <p>Instrument cultivated alteration any favourable expression law far nor. Both new like tore but year.</p>
                <div class="col-xs-3 thumb">
                  <img src="{{(isset($comment['img'])) ? url($comment['img']) : '/assets/default.png'}}" alt="Name Here">
                </div>
                <div class="col-xs-9 details">
                  <b>Mark Zuckerberg</b></br>
                  <small>Managing Director</small></br>
                  <small>Australian Realty, LLC</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="partners">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="about-wrapper">
              <h3>OUR PARTNERS</h3>
              <hr>
              <div class="col-xs-3">
                <img src="{{asset('assets/partner-1.png')}}" alt="">
              </div>
              <div class="col-xs-3">
                <img src="{{asset('assets/partner-2.png')}}" alt="">
              </div>
              <div class="col-xs-3">
                <img src="{{asset('assets/partner-3.png')}}" alt="">
              </div>
              <div class="col-xs-3">
                <img src="{{asset('assets/partner-4.png')}}" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>



@endsection

@section('scripts')

@stop
