@extends("layouts.main")
@section("content")
<div id="loading"><div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}" /></div></div>
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

    <section id="featured-video">
      <div class="container">
        <div class="row">
          @php ($url = isset($data['video']) ? $data['video'] : 'https://www.youtube.com/embed/2nRhVpc9F3I')
          <iframe width="100%" height="530" src="{{ $url }}" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </section>

    <section id="why-sign-up">
      <div class="container">
        <div class="row section-title">
          <h2 class="wide"><span class="icon icon-left-bar"></span>Why Sign Up with HOUSESTARS.COM.AU<span class="icon icon-right-bar"></span></h2>
         <span class="separator"></span>
         <p>House Stars has been developed to maximize the return on selling your property. It uses tried-and-tested methods , as well as modern technology to track your progress and help you get the best results for your sale.</p>
        </div>
        <div class="row widget">
          	<div class="col-xs-6">
          		<div class="widget-item">
          			<div class="col-xs-4">
          				<span class="icon icon-people"></span>
          			</div>
          			<div class="col-xs-8">
          				<h3>Get the best people working for you</h3>
          				<p>Teamwork makes the dream work! Our agents, trades and services have all been used by other people in your position, and rated to show you who is good and who is great! This means that you can select only the best professionals for your project and avoid any nasty surprises. By rating their performance, you help others after you to make the right choice.</p>
          			</div>
          		</div>
          		<div class="widget-item">
          			<div class="col-xs-4">
          				<span class="icon icon-value"></span>
          			</div>
          			<div class="col-xs-8">
          				<h3>Sell for more</h3>
          				<p>The absolute key to getting the best results is to have the buyer fall in love with the property. When this happens, they will pay much more than what the true value of the property is worth, because they "just love it!" By using a great agent, and smart renovating decisions, you can reach amazing outcomes.</p>
          			</div>
          		</div>
          	</div>
          	<div class="col-xs-6">
          		<div class="widget-item">
          			<div class="col-xs-4">
          				<span class="icon icon-sell-more"></span>
          			</div>
          			<div class="col-xs-8">
          				<h3>Increase the Value of Your Property</h3>
          				<p>You want to get the best results when selling your house right? A tidy garden, some new light fittings and a touch-up with some paint can add amazing value to your property. Spend just a few thousand dollars on renovation, and you could see thousands more added to the sell price of your house. Why would you do it any other way?</p>
          			</div>
          		</div>
          		<div class="widget-item">
          			<div class="col-xs-4">
          				<span class="icon icon-big-discount"></span>
          			</div>
          			<div class="col-xs-8">
          				<h3>The Biggest Discounts Around</h3>
          				<p>"The money spent on trades and services is returned to you once the house is sold. It's the best decision you can make when selling your home. You can claim work up to 7 years after it was done, so the next time you need a trade or service, make sure they are a Housestars partner. </br><a href="#" class="content-hyperlink">See Terms and Conditions.</a></p>
          			</div>
          		</div>
          	</div>
        </div>
      </div>
    </section>

    <section id="savings-calculator" class="blue-area">
      <div class="container">
        <div class="row section-title">
         <h2 class="wide"><span class="icon icon-left-bar-white mobile-hidden"></span>Savings Estimation Calculator<span class="icon icon-right-bar-white mobile-hidden"></span></h2>
        </div>
        <div class="calculator">
          <form id="savingsCalc" method="POST" action="/create/potential-customer">
            {{csrf_field()}}
        		<div class="col-xs-4">
              <div class="alert alert-danger" style="width: 100%; text-align: center; color: #000;"><span id="error"></span></div>
        			<label>Name</label>
        			<input type="text" name="name">
        			<label>Suburb</label>
        			<select id="select-suburb" name="suburb"  class="demo-default"></select>
              <span class="fa fa-spin fa-spinner hidden" style="position:relative;top:-37px;z-index:1;float:right;right:35px;"></span>
        		</div>
        		<div class="col-xs-4">
        			<label>Email Address</label>
        			<input type="text" name="email">
        			<label>Property Type</label>
              <select id="select-type" name="property-type"  class="demo-default" placeholder="Select or Type in Property">
                <option value=""></option>
                <option value="House">House</option>
                <option value="Unit">Unit</option>
                <option value="Apartment">Apartment</option>
                <option value="Land">Land</option>
                <option value="Townhouse">Townhouse</option>
                <option value="Other">Other</option>
              </select>
        		</div>
        		<div class="col-xs-4">
        			<label>Phone Number</label>
        			<input type="text" name="phone">
        			<label>Estimated Selling Price</label>
               <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                    <ul class="dropdown-menu">
                      <li>
                        <input type="radio" id="b1" name="estimated-price" value="$0-$100,000">
                        <label for="b1">$0 - $100,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b2" name="estimated-price" value="$100,000-$200,000">
                        <label for="b2">$100,000 - $200,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b3" name="estimated-price" value="$200,000 - $300,000">
                        <label for="b3">$200,000 - $300,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b4" name="estimated-price" value="$300,000 - $400,000">
                        <label for="b4">$300,000 - $400,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b5" name="estimated-price" value="$400,000 - $500,000">
                        <label for="b5">$400,000 - $500,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b6" name="estimated-price" value="$500,000 - $600,000">
                        <label for="b6">$500,000 - $600,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b7" name="estimated-price" value="$600,000 - $700,000">
                        <label for="b7">$600,000 - $700,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b8" name="estimated-price" value="$700,000 - $800,000">
                        <label for="b8">$700,000 - $800,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b9" name="estimated-price" value="$800,000 - $900,000">
                        <label for="b9">$800,000 - $900,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b10" name="estimated-price" value="$1,000,000 - $1,100,000">
                        <label for="b10">$1,000,000 - $1,100,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b11" name="estimated-price" value="$1,200,000 - $1,300,000">
                        <label for="b11">$1,200,000 - $1,300,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b12" name="estimated-price" value="$1,400,000 - $1,500,000">
                        <label for="b12">$1,400,000 - $1,500,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b13" name="estimated-price" value="$1,600,000 - $1,800,000">
                        <label for="b13">$1,600,000 - $1,800,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b14" name="estimated-price" value="$1,900,000 - $2,000,000">
                        <label for="b14">$1,900,000 - $2,000,000</label>
                      </li>
                      <li>
                        <input type="radio" id="b15" name="estimated-price" value="$2,000,000-$2,100,000">
                        <label for="b15">$2,000,000+</label>
                      </li>
                  </ul>
              </div>
        		</div>
        		<div class="col-xs-4 col-xs-offset-4">
        			<button class="btn-calculator"><span class="icon icon-calculate"></span> See Results <span class="icon icon-arrow-right"></span></button>
        		</div>
        	</form>
        </div>
      </div>
    </section>

    <section id="suburb-availability">
      <div class="container">
        <div class="row">
          <div class="row section-title">
              <h2 class="narrower"><span class="icon icon-left-bar"></span>View Local Agents<span class="icon icon-right-bar"></span></h2>
              <span class="separator"></span>
          </div>
          <div class="col-xs-6 col-xs-offset-3">
            <p>
              Enter your suburb below to see which local agents are available to help you sell your property.
            </p>
              <input type="text" id="select-state" name="term" class="required-input" required />
              <span class="fa fa-spin fa-spinner hidden" style="position:relative;top:-37px;z-index:1;float:right;right:35px;"></span>
          </div>
        </div>
      </div>
    </section>

@endsection

@section('scripts')
<script type="text/javascript">
    $('#select-type').selectize({
        create: true,
        // sortField: 'text'
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
    });

    $('#select-state').selectize({
        maxItems: 1,
        valueField: 'value',
        searchField: ['name', 'id'],
        labelField: 'name',
        sortField: 'text',
        create: false,
        render: {
            option: function(item, escape) {
                return '<div class="option" data-selectable="" data-value="'+item.id+''+item.name+'">'+item.name+' ('+item.id+')</div>';
            }
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: '{{ url('tradesman/search-suburb') }}',
                type: 'GET',
                data: {
                    query: query
                },
                error: function() {
                    callback();
                },
                success: function(res) {
                    console.log('results: ', res);
                    callback(res.suburbs);
                    //callback(res.repositories.slice(0, 10));
                }
            });
        },
        onChange: function(value) {

            if(typeof value == "undefined" || value == null){
                return false;
            }

            var selectize = $('#select-state').selectize();
            var length = value.length;

            $.ajax({
                method:'POST',
                url:'{{ url('/search/agency') }}',
                data:{
                    term:value
                },
                success: function(term){


                 $('.thumb-holder0').empty();
                 $('.thumb-holder1').empty();
                 $('.thumb-holder2').empty();

                 $('.agent-name0').empty();
                 $('.agent-name1').empty();
                 $('.agent-name2').empty();

                 $('.location0').empty();
                 $('.location1').empty();
                 $('.location2').empty();

                 if(term == 'redirect'){
                   window.location.href = "/search-agency";
                 }

                  if(term.length < 1000 && term != 'error' && term != 'redirect'){
                    $('#noAgency').modal('show');
                    for(i = 0; term.length - 1; i++){
                      if(term[i]['photo'] == null){
                        $('.thumb-holder'+i).append('<img src="/assets/default.png" alt="">');
                      } else {
                        $('.thumb-holder'+i).append('<img src="'+term[i]['photo']+'" alt="">');
                      }
                      $('.agent-profile'+i).attr("href", "/profile/agency/"+term[i]['id'])
                      $('.agent-name'+i).append(term[i]['name']);
                      $('.location'+i).append('('+term[i]['suburb']+')');
                    }
                  } else if(term != 'error' && term != 'redirect'){
                      $('#noAgency').modal('show');
                  }


               }
            });

        }
    });
    
    jQuery.validator.addMethod('positionsRequired', function(value, element){

        if(typeof value == "undefined" || value == null || value == ""){

            $('.selectize-control .selectize-input').addClass('error');

            return false;
        }

        $('.selectize-control .selectize-input').removeClass('error');
        return true;

    });

    jQuery.validator.addMethod('tradeRequired', function(value, element){

        if(typeof value == "undefined" || value == null || value == ""){

            console.log('undefined trade');
            $('#trade-btn-group').addClass('error');

            return false;
        }

        $('#trade-btn-group').removeClass('error');
        return true;

    });

    var validator = $('form[name=form]').validate({
        errorPlacement: function (error, element) {
            //console.log('error: ', error);
            //console.log('element: ', element);
        },
        ignore: '',
        rules:{
            'positions[]':{
                positionsRequired:true
            },
            trade: {
                tradeRequired:true
            }
        }
        /*submitHandler: function(form) {





        }*/
    });

    console.log('validator', validator);
    
    $elements = $('#select-suburb');
    // #view-local-agents
    $elements.selectize({
        maxItems: 1,
        valueField: 'value',
        searchField: ['name', 'id'],
        labelField: 'name',
        sortField: 'text',
        create: false,
        render: {
            option: function(item, escape) {
                return '<div class="option" data-selectable="" data-value="'+item.id+''+item.name+'">'+item.name+' ('+item.id+')</div>';
            }
        },
        onChange: function(value) {
        },
        load: function(query, callback) {
            if (!query.length) return callback();
            $.ajax({
                url: '{{ url('tradesman/search-suburb') }}',
                type: 'GET',
                data: {
                    query: query
                },
                beforeSend: function() {
                    $elements.siblings('span.fa-spin').removeClass('hidden');
                },
                error: function() {
                    $elements.siblings('span.fa-spin').addClass('hidden');
                    callback();
                },
                success: function(res) {
                    $elements.siblings('span.fa-spin').addClass('hidden');
                    callback(res.suburbs);
                    //callback(res.repositories.slice(0, 10));
                }
            });
        }
    });

</script>
@stop
