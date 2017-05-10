@extends("layouts.main")

@section('styles')
  @parent
  <style>
    .amount.form-inline {
      width: 150px;
    }
  </style>
@endsection

<?php
  $amountSold = $commissionPercentage = $commisionCharged = 0;
?>

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
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/profile">Process Page</a></li>
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
              @if(isset($data['recent']))
                @php ($a = $data['recent'])
              @endif
               @if(isset($data['property'][$a]['agent']))
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
              <label>Estimated Savings Target</label>
              {{--@if(isset($data['commission']['total']) && $data['commission']['total'] != 'N/A')
                  <h2 class="estimates">${{$data['commission']['total']}}</h2>
              @else
                  <h2 class="estimates">{{$data['commission']['total']}}</h2>
              @endif--}}
              @php ($savingsTarget = isset($data['property'][$a]['value-to']) ? ($data['property'][$a]['value-to'] * 0.025 * 0.2) : 'N/A')
              <h2 class="estimates">${{ $savingsTarget }}</h2>
            </div>
            <div class="col-xs-2 terms">
              @if(isset($data['meta']['commission']))
                <p>This is an estimate only. Actual amount will vary with sale price Please see <a href="#" class="content-hyperlink">Terms & Conditions</a>.</p>
              @endif
            </div>
          </div>
          <div class="col-xs-3 nav-panel">
            <a class="btn hs-primary" style="margin-bottom: 0;" href="{{env('APP_URL')}}/dashboard/customer/edit"><span class="icon icon-summary" style="margin-top: 6px;"></span>EDIT PROFILE <span class="icon icon-arrow-right"></span></a>
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
                @if(isset($data['commission']['estimate']) && $data['commission']['estimate'] != 'N/A')
                  <h3 class="estimated-amount">${{$data['commission']['estimate']}}</h3>
              @else
                  <h3 class="estimated-amount">{{$data['commission']['estimate']}}</h3>
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
                                @php ($unChecked = 'no')
                                @foreach($data['transaction_reviews'] as $review)
                                  @if($review['id'] == $transaction['tid'] && $review['transaction_id'] == $transaction['id'])
                                    <input type="checkbox" id="r{{$transaction['id']}}" name="cc" disabled checked/>
                                    @php ($unChecked = 'yes')
                                  @endif
                                @endforeach

                                @if($unChecked == 'no')
                                  <input type="checkbox" id="r{{$transaction['id']}}" name="cc" disabled/>
                                @endif
                                <label for="r{{$transaction['id']}}"><span></span></label>
                              </div>
                              @php ($x = 0)
                              @foreach($data['transaction_reviews'] as $review)
                                  @if($review['id'] == $transaction['tid'] && $review['transaction_id'] ==$transaction['id'])
                                    <a href="#" data-toggle="modal" data-target="#transactionReview{{$review['transaction_id']}}"><div class="stars">
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
                                    </div></a>

                                    <div class="modal fade" id="transactionReview{{$review['transaction_id']}}" tabindex="-1" role="dialog" aria-labelledby="signup-area">
                            					<div class="modal-dialog" role="document" style="margin-top: 3%;">
                            						<div class="modal-content">
                            							<div class="modal-header">
                            								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            							</div>
                            							<div class="modal-body">
                            								<h4>Rate Summary</h4></br>
                            									<div class="rating-stars">
                            										@if(isset($review['communication']))
                            										<p class="rating-label">Communication</p>
                            										<div class="stars">
                            											@for($i = 1; $i <= $review['communication']; $i++)
                            												<span class="icon icon-star"></span>
                            											@endfor
                            											@php ($rating = 5 - $review['communication'])
                            											@for($i = 1; $i <= $rating; $i++)
                            												<span class="icon icon-star-grey"></span>
                            											@endfor
                            										</div>
                            										@endif
                            									</div>
                            									<div class="rating-stars">
                            										@if(isset($review['work_quality']))
                            										<p class="rating-label">Work Quality</p>
                            										<div class="stars">
                            											@for($i = 1; $i <= $review['work_quality']; $i++)
                            												<span class="icon icon-star"></span>
                            											@endfor
                            											@php ($rating = 5 - $review['work_quality'])
                            											@for($i = 1; $i <= $rating; $i++)
                            												<span class="icon icon-star-grey"></span>
                            											@endfor
                            										</div>
                            										@endif
                            									</div>
                            									<div class="rating-stars">
                            										@if(isset($review['price']))
                            										<p class="rating-label">Price</p>
                            									 <div class="stars">
                            											@for($i = 1; $i <= $review['price']; $i++)
                            												<span class="icon icon-star"></span>
                            											@endfor
                            											@php ($rating = 5 - $review['price'])
                            											@for($i = 1; $i <= $rating; $i++)
                            												<span class="icon icon-star-grey"></span>
                            											@endfor
                            										</div>
                            										@endif
                            									</div>
                            									<div class="rating-stars">
                            										@if(isset($review['punctuality']))
                            										<p class="rating-label">Punctuality</p>
                            										<div class="stars">
                            											@for($i = 1; $i <= $review['punctuality']; $i++)
                            												<span class="icon icon-star"></span>
                            											@endfor
                            											@php ($rating = 5 - $review['punctuality'])
                            											@for($i = 1; $i <= $rating; $i++)
                            												<span class="icon icon-star-grey"></span>
                            											@endfor
                            										</div>
                            										@endif
                            									</div>
                            									<div class="rating-stars no-border">
                            										@if(isset($review['attitude']))
                            										<p class="rating-label">Attitude</p>
                            										<div class="stars">
                            											@for($i = 1; $i <= $review['attitude']; $i++)
                            												<span class="icon icon-star"></span>
                            											@endfor
                            											@php ($rating = 5 - $review['attitude'])
                            											@for($i = 1; $i <= $rating; $i++)
                            												<span class="icon icon-star-grey"></span>
                            											@endfor
                            										</div>
                            										@endif
                            									</div>
                            							</div>
                            						</div>
                            					</div>
                            				</div>
                                  @php ($x = 1)
                                 @break
                                @endif
                              @endforeach

                              @if($x == 0)
                                <button class="add-review" data-tid="{{$transaction['id']}}" data-trade="{{$transaction['tid']}}" data-token="{{ csrf_token()}}" id="reviewBtn{{$transaction['tid']}}"> Rate & Review </button>
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
                <a href="" class="btn hs-primary btn-add" data-toggle="modal" data-target="#processTrades"><span class="icon icon-add" style="margin-top: 6px;"></span>Add a receipt</span></a>
               @endif

              <div class="total" id="transactionsTotal">
                <div class="total-label">
                  <span>Total Spend</span>
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
                        <span id="value-to" class="fa fa-spin fa-spinner fa-2x" style='display:none;line-height:30px;margin-left: 5px;'> </span>
                        @if(isset($data['property'][$a]['amount-sold']) && $data['property'][$a]['amount-sold'] == 'yes')
                          <input type="checkbox" id="c7" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}" checked disabled />
                        @else
                          <input type="checkbox" id="c7" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}" />
                        @endif
                        <label for="c7"><span></span></label>
                      </div>
                      <div class="amount form-inline">
                        <div class="input-group">
                          <span class="input-group-addon" id="basic-addon1">$</span>
                          @php ($amountSold = isset($data['property'][$a]['value-to']) ? $data['property'][$a]['value-to'] : 0)
                          <input type="number" 
                                class="form-control" 
                                aria-describedby="basic-addon1" 
                                value="{{ $amountSold }}"
                                data-token="{{ csrf_token()}}" 
                                data-code="{{$data['property'][$a]['property-code']}}"
                                data-meta="amount-sold"
                                data-meta-key="value-to"
                          />
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Commission % as per sale contract</label>
                    </div>
                    <div class="value">
                      <div class="action">
                        <span id="commission" class="fa fa-spin fa-spinner fa-2x" style='display:none;line-height:30px;margin-left: 5px;'> </span>
                        @if(isset($data['property'][$a]['commission-percentage']) && isset($data['property'][$a]['commission-percentage']) && $data['property'][$a]['commission-percentage'] == 'yes')
                          <input type="checkbox" id="c8" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}" checked disabled />
                        @else
                          <input type="checkbox" id="c8" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}" />
                        @endif
                        <label for="c8"><span></span></label>
                      </div>
                      <div class="amount form-inline" id="{{$data['property']['user_id']}}" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}">
                        <div class="input-group">
                          @php ($commissionPercentage = isset($data['property'][$a]['commission']) ? $data['property'][$a]['commission'] : 0)
                          <input type="number" 
                                class="form-control" 
                                aria-label="Percentage" 
                                value="{{$commissionPercentage}}"
                                data-token="{{ csrf_token()}}" 
                                data-code="{{$data['property'][$a]['property-code']}}"
                                data-meta="commission-percentage"
                                data-meta-key="commission"
                          />
                          <span class="input-group-addon">%</span>
                        </div>
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="label">
                      <label>Total Commission Charge</label>
                    </div>
                    <div class="value">
                      @if(isset($data['agent']))
                        <div class="action">
                          <span id="commission-total" class="fa fa-spin fa-spinner fa-2x" style='display:none;line-height:30px;margin-left: 5px;'> </span>
                          @if(isset($data['property'][$a]['commission-charged']) && $data['property'][$a]['commission-charged'] == 'yes')
                            <input type="checkbox" id="c9" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}" checked disabled />
                          @else
                            <input type="checkbox" id="c9" name="cc" data-token="{{ csrf_token()}}" data-code="{{$data['property'][$a]['property-code']}}" />
                          @endif
                          <label for="c9"><span></span></label>
                        </div>
                      @endif
                      <div class="amount form-inline">
                          <div class="input-group">
                            @if(isset($data['agent']))
                              @php ($commisionCharged = ((isset($data['commission']['total']) && $data['commission']['total'] != 'N/A') ? $data['commission']['total'] : 0))
                              <span class="input-group-addon" id="basic-addon1">$</span>
                              <input type="number" 
                                class="form-control" 
                                aria-label="Percentage" 
                                value="{{$commisionCharged}}"
                                data-token="{{ csrf_token()}}" 
                                data-code="{{$data['property'][$a]['property-code']}}"
                                data-meta="commission-charged"
                                data-meta-key="commission-total"
                              />
                            @else
                              <p> N/A </p>
                            @endif
                          </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="total">
                <div class="total-label">
                  <span>Total Spend</span>
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
              @if(isset($data['agent']) && isset($data['property'][$a]['agent']))
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
                      <div class="fb-like" data-href="https://www.facebook.com/housestars.com.au/" data-layout="standard" data-action="like" data-size="large" data-show-faces="true" data-share="false"></div>
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
                <button id="process" class="btn hs-primary disabled" disabled="true"></span>SUBMIT <span class="icon icon-arrow-right"></span></button>
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
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9&appId=1889078964644540";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
  
  <script src="{{asset('js/processing.js')}}"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      var a = $("input[type='checkbox']");
      $('body').on('click', "input[type='checkbox']", function(evt) {
        if(a.length == a.filter(":checked").length) {
          $('#process').removeClass('disabled');
          $('#process').prop('disabled', false);
          $('.submit span').remove();
        }
      });
    });

    $(function() {
      $('#trades').selectize();
    });

  </script>
@stop
