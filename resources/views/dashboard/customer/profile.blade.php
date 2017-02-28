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
            <div class="col-xs-4">
              <p class="telephone">{{$data['meta']['phone']}}</p>
              <p class="email">{{$data['meta']['email']}}</p>
            </div>
            <div class="col-xs-3 agency-info">
              <label>Listed Under Agency:</label>
              @if(isset($data['meta']['agent']))
                <h2 class="agency-name">LJ Hooker Byron Bay</h2>
                <div class="stars left">
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                    <span class="icon icon-star"></span>
                  </div>
              @else
                <h2 class="estimates">N/A</h2>
              @endif
            </div>
            <div class="col-xs-3">
              <label>Estimated Commission Target</label>
              @if(isset($data['meta']['commission']))
                <h2 class="estimates">$3,000</h2>
              @else
                <h2 class="estimates">N/A</h2>
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
                <h3 class="address">{{$data['meta']['address']}}, {{$data['property'][0]['suburb']}}, {{$data['property'][0]['state']}}</h3>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-8">
                <h3 class="left">ESTIMATED COMMISSION DISCOUNT</h3>
              </div>
              <div class="col-xs-4">
                @if(isset($data['meta']['commission']))
                  <h3 class="estimated-amount">$3,000</h3>
                @else
                  <h3 class="estimated-amount">N/A</h3>
                @endif
              </div>
              <div class="col-xs-12 section-title">
                <h4>Trades and Services</h4>
              </div>
              
              @if(isset($data['transactions']))
              <div class="transactions">
                  @foreach($data['transactions'] as $transaction)
                    <div class="entry">
                      <ul>
                        <li>
                          <div class="label"><h4>{{$transaction['name']}}</h4> <button class="remove-transaction" data-token="{{ csrf_token()}}" data-id="{{$transaction['id']}}">REMOVE TRANSACTION</button></div>
                          <div class="value">
                            <div class="action">
                              @foreach($data['reviews'] as $review)
                              @if($review['id'] == $transaction['tid'])
                                <input type="checkbox" id="r{{$transaction['id']}}" name="cc" disabled checked/>
                                @break                            
                              @endif
                              <input type="checkbox" id="r{{$transaction['id']}}" name="cc" disabled/>
                              @endforeach
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
                                <img src="{{env('APP_URL')/$transaction['receipt']}}" alt="">
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
                  @endforeach
              </div>
                <button class="btn hs-primary btn-add" data-toggle="modal" data-target="#processTrades"><span class="icon icon-add" style="margin-top: 6px;"></span>Transaction</span></button>
               @endif
              
              <div class="total" id="transactionsTotal">
                <div class="total-label">
                  <span>Total Spending</span>
                  <span class="total-amount" data-total="{{$data['spending']['total']}}">${{$data['spending']['total']}}</span>
                </div>
              </div>
              <p class="spending">Spending above estimate <span class="spending-amount">$9,000</span></p>
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
                        <input type="checkbox" id="c7" name="cc" />
                        <label for="c7"><span></span></label>
                      </div>
                      <div class="amount">
                        <h4>$3,000</h4>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Commission % as per sale contract</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c8" name="cc" />
                        <label for="c8"><span></span></label>
                      </div>
                      <div class="amount">
                        <h4>$3,000</h4>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Total Commission Charge</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c9" name="cc" />
                        <label for="c9"><span></span></label>
                      </div>
                      <div class="amount">
                        <h4>$3,000</h4>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="total">
                <div class="total-label">
                  <span>Total Spending</span>
                  <span class="total-amount">$12,000</span>
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
                      <label>Picture of receipt</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="c11" name="cc" />
                        <label for="c11"><span></span></label>
                      </div>
                      <div class="picture">
                        <img src="{{asset('assets/img-gallery-1.jpg')}}" alt="">
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <button class="btn hs-primary btn-write add-review" data-id="{{$transaction['tid']}}" data-token="{{ csrf_token()}}" id="reviewBtn{{$transaction['tid']}}"><span class="icon icon-write"></span>RATE AND REVIEW</span></button>
                    </div>
                    <div class="value">
                      <div class="action">
                        <input type="checkbox" id="12" name="cc" />
                        <label for="c12"><span></span></label>
                      </div>
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
                      <label>Like us on Facebook</label>
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
              <button class="btn hs-primary disabled"></span>SUBMIT <span class="icon icon-arrow-right"></span></button>
              <span>Cannot submit until all criteria above met.</span>
            </div>

          </div>
          <div class="col-xs-3 sidebar">
            <div class="advertisement">
              <div class="ads"></div>
              <div class="ads"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection

 @section('scripts')
  <script src="{{asset('js/processing.js')}}"></script>
  <script type="text/javascript">

    $(function() {
      $('#trades').selectize();
    });

  </script>
@stop