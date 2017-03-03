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
               @if(isset($data['agent']))
                <h2 class="agency-name">{{$data['agent']['name']}}</h2>
                <div class="stars left">
                    @if($data['agent']['rating'] == 0)
                          <span class="icon icon-star-grey"></span>
                          <span class="icon icon-star-grey"></span>
                          <span class="icon icon-star-grey"></span>
                          <span class="icon icon-star-grey"></span>
                          <span class="icon icon-star-grey"></span>
                        @else 
                          @for($i = 0; $i < $data['agent']['rating']; $i++)
                              <span class="icon icon-star"></span>
                          @endfor

                          @php ($x = 5 - $data['agent']['rating'])

                          @for($i = 0; $i < $x; $i++)
                              <span class="icon icon-star-grey"></span>
                          @endfor

                        @endif
                  </div>
              @else
                <h2 class="estimates">N/A</h2>
              @endif
            </div>
            <div class="col-xs-3">
              <label>Estimated Commission Target</label>
              @if(isset($data['commission']['total']) && $data['commission']['total'] != 'N/A')
                  <h2 class="estimates">${{$data['commission']['total']}}</h2>
              @else
                  <h2 class="estimates">{{$data['commission']['total']}}</h2>
              @endif
            </div>
            <div class="col-xs-2 terms"> 
              @if(isset($data['meta']['commission']))
                <p>This is an estimate only. Actual amount will vary with sale price Please see <a href="#" class="content-hyperlink">Terms & Conditions</a>.</p>
              @endif
            </div>
          </div>
          <div class="col-xs-3 nav-panel">
            <button class="btn hs-primary" style="margin-bottom: 0;"><span class="icon icon-summary" style="margin-top: 6px;"></span>EDIT PROFILE <span class="icon icon-arrow-right"></span></button>
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
                <label>Property To be Renovated</label>
              </div>
              <div class="col-xs-8">
                @if(isset($data['recent']))
                  @php ($a = $data['recent'])
                <h3 class="address">{{$data['property'][$a]['suburb']}}, {{$data['property'][$a]['state']}}</h3>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="col-xs-8">
                <h3 class="left">ESTIMATED COMMISSION DISCOUNT</h3>
              </div>
              <div class="col-xs-4">
                @if(isset($data['commission']['total']) && $data['commission']['total'] != 'N/A')
                  <h3 class="estimated-amount">${{$data['commission']['total']}}</h3>
              @else
                  <h3 class="estimated-amount">{{$data['commission']['total']}}</h3>
              @endif
              </div>
              <div class="col-xs-12 section-title">
                <h4>Trades and Services</h4>
              </div>
              
              @if(isset($data['transactions']))
              <div class="transactions">
                  @foreach($data['transactions'] as $transaction)
                    @if($transaction['code'] == $data['property'][$a]['property-code'])
                      <div class="entry">
                        <ul>
                          <li>
                            <div class="label"><h4>{{$transaction['name']}}</h4> <button class="remove-transaction" data-token="{{ csrf_token()}}" data-id="{{$transaction['id']}}">REMOVE TRANSACTION</button></div>
                            <div class="value">
                              <div class="action">
                                @foreach($data['reviews'] as $review)
                                  @if($review['id'] == $transaction['tid'])
                                    <input type="checkbox" id="r{{$transaction['id']}}" name="cc" disabled checked/>
                                    @php ($unChecked = 'no')
                                  @endif
                                @endforeach

                                @if(!isset($unChecked))
                                  <input type="checkbox" id="r{{$transaction['id']}}" name="cc" disabled/>
                                @endif
                                <label for="r{{$transaction['id']}}"><span></span></label>
                              </div>
                              @php ($x = 0)
                              @foreach($data['reviews'] as $review)
                                  @if($review['id'] == $transaction['tid'])
                                    <div class="stars">
                                        @if($review['rate'] == 0)
                                          <span class="icon icon-star-grey"></span>
                                          <span class="icon icon-star-grey"></span>
                                          <span class="icon icon-star-grey"></span>
                                          <span class="icon icon-star-grey"></span>
                                          <span class="icon icon-star-grey"></span>
                                        @else 
                                          @for($i = 0; $i < $review['rate']; $i++)
                                              <span class="icon icon-star"></span>
                                          @endfor

                                          @php ($x = 5 - $review['rate'])

                                          @for($i = 0; $i < $x; $i++)
                                              <span class="icon icon-star-grey"></span>
                                          @endfor

                                        @endif
                                    </div>
                                  @php ($x = 1)
                                 @break
                                @endif
                              @endforeach

                              @if($x == 0)
                                <button class="add-review" data-id="{{$transaction['tid']}}" data-token="{{ csrf_token()}}" id="reviewBtn{{$transaction['tid']}}"> Rate & Review </button>
                              @endif
                                 
                            </div>
                          </li>
                          <li>
                            <div class="label"><label>Picture of receipt</label></div>
                            <div class="value">
                              <div class="action">
                                @if($transaction['receipt'])
                                  <input type="checkbox" id="p{{$transaction['id']}}" name="cc"  checked disabled/><label for="p{{$transaction['id']}}"><span></span></label>
                                @else
                                  <input type="checkbox" id="p{{$transaction['id']}}" name="cc"  disabled/><label for="p{{$transaction['id']}}"><span></span></label>
                                @endif
                              </div>
                              <div class="picture" id="picture{{$transaction['id']}}">
                                @if($transaction['receipt'])
                                  <img src="{{env('APP_URL')}}/{{$transaction['receipt']}}" alt="">
                                @else
                                <form id="uploadReceipt" enctype="multipart/form-data" data-id="{{$transaction['id']}}">
                                  {{csrf_field() }}
                                  <input type="file" name="receipt" id="tradesReceipt">
                                  <input type="hidden" name="id" value="{{$transaction['id']}}">
                                  <input type="hidden" name="tid" value="{{$transaction['tid']}}">
                                  <div class="upload-receipt"><span class="ur-text">Add a Receipt</span></div>
                                </form>
                                @endif
                              </div>
                            </div>
                          </li>
                          <li>
                            <div class="label"><label>Amount Spent</label></div>
                            <div class="value">
                              <div class="action">
                                <input type="checkbox" id="a{{$transaction['id']}}" name="cc" checked disabled/><label for="a{{$transaction['id']}}"><span></span></label>
                              </div>
                              <div class="amount" id="{{$transaction['id']}}" data-token="{{ csrf_token()}}"><h4>$<span contenteditable="true">{{$transaction['amount_spent']}}</span></h4></div>
                            </div>
                          </li>
                        </ul>
                      </div>
                    @endif
                  @endforeach
              </div>
                <a href="" class="btn hs-primary btn-add" data-toggle="modal" data-target="#processTrades"><span class="icon icon-add" style="margin-top: 6px;"></span>Transaction</span></a>
               @endif
              
              <div class="total" id="transactionsTotal">
                <div class="total-label">
                  <span>Total Spending</span>
                  <span class="total-amount" data-total="{{$data['spending']['total']}}">${{$data['spending']['total']}}</span>
                </div>
              </div>
                @if($data['spending']['total'] > $data['commission']['total'])
                  <p class="spending">Spending above estimate <span class="spending-amount">${{$data['commission']['total']}}</span></p>
                @endif
              
            </div>

            <div class="row">
              <div class="entry">
                <ul style="border: none;">
                  <li>
                    <div class="label">
                      <label>Amount property was sold for</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        @if(isset($data['property'][$a]['amount-sold']))
                          @if($data['property'][$a]['amount-sold'] == 'yes')
                            <input type="checkbox" id="c7" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}" checked/>
                          @else
                            <input type="checkbox" id="c7" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}"/>
                          @endif
                        @else
                          <input type="checkbox" id="c7" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}"/>
                        @endif
                        
                        <label for="c7"><span></span></label>
                      </div>
                      <div class="amount">
                        @if(isset($data['property'][$a]['value-to']))
                          <h4>${{$data['property'][$a]['value-to']}}</h4>
                        @else
                          <h4>N/A</h4>
                        @endif
                        
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Commission % as per sale contract</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        @if(isset($data['property'][$a]['commission-percentage']))
                          @if(isset($data['property'][$a]['commission-percentage']) && $data['property'][$a]['commission-percentage'] == 'yes')
                            <input type="checkbox" id="c8" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}" checked/>
                          @else
                            <input type="checkbox" id="c8" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}"/>
                          @endif
                        @else
                          <input type="checkbox" id="c8" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}"/>
                        @endif
                        <label for="c8"><span></span></label>
                      </div>
                      <div class="amount">
                        @if(isset($data['property'][$a]['commission']))
                          <h4>{{$data['property'][$a]['commission']}}%</h4>
                        @else
                          <h4>N/A</h4>
                        @endif
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Total Commission Charge</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        @if(isset($data['property'][$a]['commission-charged']))
                          @if(isset($data['property'][$a]['commission-charged']) && $data['property'][$a]['commission-charged'] == 'yes')
                            <input type="checkbox" id="c9" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}" checked/>
                          @else
                            <input type="checkbox" id="c9" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}"/>
                          @endif
                        @else
                          <input type="checkbox" id="c9" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}"/>
                        @endif
                        <label for="c9"><span></span></label>
                      </div>
                      <div class="amount">
                         @if(isset($data['commission']['total']) && $data['commission']['total'] != 'N/A')
                              <h4>${{$data['commission']['total']}}</h4>
                          @else
                              <h4>{{$data['commission']['total']}}</h4>
                          @endif
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="total">
                <div class="total-label">
                  <span>Total Spending</span>
                  <div id="commission">
                    <span class="total-amount" data-total="{{$data['spending']['total']}}">${{$data['spending']['total']}}</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12 section-title">
                <h4>AGENTS</h4>
              </div>
              @if(isset($data['agent']))
              <div class="entry">
                <ul style="border: none">
                  <li>
                    <div class="label">
                      <h4>{{$data['agent']['name']}}</h4>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c10" name="cc" disabled checked/>
                        <label for="c10"><span></span></label>
                      </div>
                      <div class="stars">
                        @if($data['agent']['rating'] == 0)
                          <span class="icon icon-star-grey"></span>
                          <span class="icon icon-star-grey"></span>
                          <span class="icon icon-star-grey"></span>
                          <span class="icon icon-star-grey"></span>
                          <span class="icon icon-star-grey"></span>
                        @else 
                          @for($i = 0; $i < $data['agent']['rating']; $i++)
                              <span class="icon icon-star"></span>
                          @endfor

                          @php ($x = 5 - $data['agent']['rating'])

                          @for($i = 0; $i < $x; $i++)
                              <span class="icon icon-star-grey"></span>
                          @endfor

                        @endif
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Picture of Contract</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        @if(isset($data['property'][$a]['contract']))
                        <input type="checkbox" id="c11" name="cc" checked disabled/>
                        <label for="c11"><span></span></label>
                        @else
                        <input type="checkbox" id="c11" name="cc" disabled/>
                        <label for="c11"><span></span></label>  
                         @endif
                      </div>
                      <div class="picture" id="contract{{$data['property']['user_id']}}">
                              @if(isset($data['property'][$a]['contract']))
                                <img src="{{env('APP_URL')}}/{{$data['property'][$a]['contract']}}" alt="">
                              @else
                              <form id="uploadReceipt" enctype="multipart/form-data" data-id="{{$data['property']['user_id']}}">
                                {{csrf_field() }}
                                <input type="file" name="contract" id="contract">
                                <input type="hidden" name="user_id" value="{{$data['property']['user_id']}}">
                                <input type="hidden" name="property_code" value="{{$data['property'][$a]['property-code']}}">
                                <div class="upload-receipt"><span class="ur-text">Upload</span></div>
                              </form>
                              @endif
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      @if($data['agent']['rating'] == 0)
                        <button class="btn hs-primary btn-write add-review" data-id="{{$data['agent']['id']}}" data-token="{{ csrf_token()}}" id="reviewBtn{{$data['agent']['id']}}"><span class="icon icon-write"></span>RATE AND REVIEW</span></button>
                      @endif  
                    </div>
                  </li>
                </ul>
              </div>
              @else
              <div class="agency"></div>
              <button id="agency" class="btn hs-primary btn-add" data-toggle="modal" data-target="#addAgent"><span class="icon icon-add" style="margin-top: 6px;"></span>Agent</span></button>
              @endif
              
            </div>

            <div class="row" style="padding: 10px 20px;a">
              <div class="entry" style="margin: 0">
                <ul style="border: none">
                  <li>
                    <div class="label">
                      <label style="margin-bottom: 7px !important;width: 100%;text-align: left;">Like us on Facebook</label>
                      <div class="fb-like" id="fb" data-href="https://www.facebook.com/webforest.solutions/" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="false" style="float: left; margin-bottom: 15px;"></div>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c13" name="cc" />
                        <label for="c13"><span></span></label>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <div class="row submit">
              <form id="processForm">
                {{csrf_field()}}
                <input type="hidden" name="commission" value="{{$data['commission']['total']}}">
                <input type="hidden" name="property_code" value="{{$data['property'][$a]['property-code']}}">
                <button id="process" class="btn hs-primary disabled"></span>SUBMIT <span class="icon icon-arrow-right"></span></button>
              </form>
              <span>Cannot submit until all criteria above met.</span>
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

 @section('scripts')
 <script>(function(d, s, id) {
  $('#c13').prop('checked', true);
  var js, fjs = d.getElementsByTagName(s)[$a];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=1889078964644540";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  <script src="{{asset('js/processing.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      var a = $("input[type='checkbox']");
      if(a.length == a.filter(":checked").length){
          $('#process').removeClass('disabled');
          $('.submit span').remove();
      }
    });

    $(function() {
      $('#trades').selectize();
    });

  </script>
@stop