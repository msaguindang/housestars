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

    <section class="header-margin default-page">
        <div class="container">
          <div class="breadcrumbs">
            <div class="row">
              <p class="links"><a href="">Home Page</a> > <span class="blue">Our Agent Philosophy</span> </p>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="about-wrapper page">
                <h3>Review Guidelines</h3>
                <p>We really value your contributions to our site! We also want to make sure that the data collected on this site is as accurate and helpful as possible. To help us with this goal we have outlined some of the core points to consider when reviewing a business:</p></br>

                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          Family-Friendly
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        <p>To maintain a safe, family-friendly environment, we don’t allow profanity or vulgarities in reviews. We also reject reviews that include sexually explicit comments, hate speech, prejudiced language, threats or personal insults. So keep it suitable for all ages! </p>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Relevant to other Customers
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
                        <p>Keep your reviews relevant and helpful to all– keep in mind that they are reading your review to understand what an experience with the business might be like. For this reason, please don’t include personally insulting language, smear campaigns or any personal opinions about politics, ethics, religion or wider social issues. Housestars does not allow reviews that promote intolerance for individuals or groups of people based on their race, gender, religion, sexual preference or nationality. If you have a question or comment for Housestars about our moderation policies, you can contact us.</p>
                      </div>
                    </div>
                  </div>
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Unbiased
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                        <p>Reviews are most helpful when they provide unbiased advice. We discourage individuals or entities who own or are affiliated with a business to publish reviews of that business or competing businesses. Reviews submitted in an attempt to blackmail a listing will not be published. If you suspect a review is fraudulent or doesn’t meet housestars’s posting guidelines, you can contact us.</p>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading4">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                          Helpful, First-Hand
                        </a>
                      </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4">
                      <div class="panel-body">
                        <p>Our community wants to hear about your experience. This means no second-hand information, rumours or quotations from other sources in your review. Please only provide reviews based on substantial experiences you’ve had and be sure to include enough detail in your review that other users will find your advice helpful.</p>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading5">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
                          Recent
                        </a>
                      </h4>
                    </div>
                    <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5">
                      <div class="panel-body">
                        <p>The best reviews are those that are written within a year of your experience, so we discourage publishing reviews for an outdated experience. We want to hear about every trade or service, but keep in mind that you can only submit one review per experience. You can only submit a number of reviews before you will be stopped. If you are found to be creating false reviews you will be removed from the site.</p>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading6">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
                          Original
                        </a>
                      </h4>
                    </div>
                    <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading6">
                      <div class="panel-body">
                        <p>Give us your best, most accurate advice – just make sure it’s yours! Reviews should contain original content and no extensive quoted material from other sources. Any review content plagiarised from other websites, reviewers, emails or printed materials will be removed.</p>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading7">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" aria-controls="collapse4">
                          Non-commercial
                        </a>
                      </h4>
                    </div>
                    <div id="collapse7" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading7">
                      <div class="panel-body">
                        <p>Reviews are designed to provide advice to others, not to advertise a service or business. Please don’t include commercial or promotional content of any kind. Reviews that are being offered in exchange for personal gain, such as gifts, services or money, will be removed. We reserve the right to reject specific content for any reason. We do not allow reviews that contain links to external websites.</p>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading8">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" aria-controls="collapse4">
                          Respectful of Private Information
                        </a>
                      </h4>
                    </div>
                    <div id="collapse8" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading8">
                      <div class="panel-body">
                        <p>We respect your privacy and the privacy of the businesses we list. We want you to tell us all about your experience but please keep personal or exclusive information to yourself. Any reviews containing personal financial information, including credit card numbers, loyalty rewards numbers or other financial information, will also be removed. This includes both the reviewer’s information and the information of others. We allow names to be published to our site; however, we will remove last names upon request. This includes the last names of employees or owners associated with the business you are reviewing.  </p>
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="heading9">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="false" aria-controls="collapse9">
                          Listed by Housestars
                        </a>
                      </h4>
                    </div>
                    <div id="collapse9" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading9">
                      <div class="panel-body">
                        <p>A review must relate directly to the business to which it is submitted, so please ensure you are submitting your review to the correct listing on Housestars. For instance, if you intend to review a plumber who is a sub-contractor of a builder, but not the builder himself, please ensure your review is submitted to the corresponding plumber’s profile page, not the builder’s profile page.</p>
                      </div>
                    </div>
                  </div>

                </div>

                <p>Housestars reserves the right to remove a review or management response at any time, for any reason. The reviews posted on Housestars are individual and highly subjective opinions. The opinions expressed in reviews are those of Housestars customers and not of Housestars.com.au. We do not endorse any of the opinions expressed by reviewers or in management responses.</p>

              </div>
            </div>
          </div>
        </div>
    </section>



@endsection

@section('scripts')

@stop
