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
                      <li><a href="#" data-toggle="modal" data-target="#signup">Sign Me Up</a></li>
                      <li><a href="#" data-toggle="modal" data-target="#login">Login</a></li>
                      <li><a href="/">Home</a></li>
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
                      <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li class="active"><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
                    @else
                      <li><span class="icon icon-customer-dark"></span><a href="{{env('APP_URL')}}/customer" >Customer</a></li>
                      <li><span class="icon icon-tradesman-dark"></span><a href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                      <li class="active"><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a></li>
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

    <section id="how-we-help">
      <div class="container">
        <div class="row section-title">
          <h2 class="wide"><span class="icon icon-left-bar"></span>WHAT WE CAN OFFER TO YOUR AGENCY<span class="icon icon-right-bar"></span></h2>
         <span class="separator"></span>
        </div>
        <div class="row widget">
          <div class="col-xs-4 animated">
            <h3>BUILD A PERSONALIZED PAGE</h3>
            <p>Populate your page with your logo, as well as pictures and details of what you do. The page is easily edited so you can update it as often as you like. You can also easily link to other sites such as Rate My Agent to showcase your profile and win more listings.</p>
            <div class="featured-img mobile-hidden">
              <img src="assets/img-square-agent.png" alt="Want to sell a property?">
            </div>
          </div>
          <div class="col-xs-4 animated">
            <h3>Monopolize a Suburb</h3>
            <p>There is only space for three agents in each suburb. You have the ability to take one space, and compete with your fellow agents, or take all three spots and really boost your sales figures.</p>
            <div class="featured-img mobile-hidden">
              <img src="assets/img-house.png" alt="are you a trade or service?">
            </div>
          </div>
          <div class="col-xs-4 animated">
            <h3>ATTRACT NEW VENDORS</h3>
            <p>The vendors that come to you from this site are new prospects that do not have a preferred agent. Our aim is to make you number 1 in your suburb, by using our sales funnel to dominate your competition and position your business as the best choice in the area.</p>
            <div class="featured-img mobile-hidden">
              <img src="assets/img-agentcalling.png" alt="Are you an agent?">
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="agent-price-guide" class="grey-area">
    	<div class="container">
    		<div class="row">
    			<div class="section-title">
			       <h2 class="narrower"><span class="icon icon-left-bar"></span>AGENT PRICE GUIDE<span class="icon icon-right-bar"></span></h2>
			       <span class="separator"></span>
			    </div>
    			<div class="col-xs-6 col-xs-offset-3">
    				<ul class="pricing">
    					<li><p><span class="icon icon-price"></span><b>1 position</b> = FREE per year + 25% of commission price</p></li>
    					<li><p><span class="icon icon-price"></span><b>Each additional Position</b> =  $1000 per Annum plus 25% </br>of commission price</p></li>
    				</ul>
    				</br></br>
    				<p>Each time you are invited to list a property, you will have the ability to either accept or decline the sale. Some listings will be charged at a lower commission rate, and you will never be charged at more than 25%.</p>
    			</div>
    		</div>
    	</div>
    </section>

    <section id="suburb-availability">
    	<div class="container">
    		<div class="row">
    			<div class="row section-title">
			        <h2 class="narrower"><span class="icon icon-left-bar"></span>SUBURB AVAILABILITY<span class="icon icon-right-bar"></span></h2>
              <span class="separator"></span>
              <p>
                Enter your desired suburb. Green squares indicate available positions within that suburb. Red squares indicate occupied positions.    
              </p></br>
			    </div>
			    <div class="col-xs-6 col-xs-offset-3">
			    	<select id="select-state" name="positions[]" multiple  class="demo-default">
          </select>
			    </div>
    		</div>
    	</div>
    </section>

    <section id="testimonials" class="grey-area">
      <div class="container">
        <div class="row">
          <div class="section-title">
             <h2 class="wide"><span class="icon icon-left-bar"></span>Testimonials from our agents<span class="icon icon-right-bar"></span></h2>
             <span class="separator"></span>
             <p>Our agents love our personalized service and attention to detail. Above all else, we listen to our agents to make sure we are doing everything we can to follow through on our promise of making them number 1. </p>
             @if(isset($data['comments']))
              @if(Sentinel::check())
                <a class="btn btn-primary" data-toggle="modal" data-target="#agencyRate">Add Review</a>
              @else
                <a class="btn btn-primary" data-toggle="modal" data-target="#login">Login to Add Review</a>
              @endif
             @else
              @if(Sentinel::check())
                <a class="btn btn-primary" data-toggle="modal" data-target="#agencyRate">Be the first one to review us!</a>
              @else
                <a class="btn btn-primary" data-toggle="modal" data-target="#login">Be the first one to review us!</a>
              @endif
             @endif
          </div>
          @if(isset($data['comments']))
          @if(count($data['comments']) > 0)
          <div class="testimonials-carousel">
            <div class="col-md-12" data-wow-delay="0.2s">
                <div class="carousel slide" data-ride="carousel" id="quote-carousel">
                    <div class="carousel-inner">
                      @php ($x = count($data['comments']))
                      @php ($y = 0)
                      @php ($counter = 2)

                      @foreach($data['comments'] as $comment)
                        @if($y == 0 && $y != $counter)
                          <div class="item active">
                            <div class="row">
                              <div class="col-xs-1 col-xs-offset-1 thumb">
                                <img src="{{(isset($comment['img'])) ? url($comment['img']) : '/assets/default.png'}}" alt="Name Here">
                              </div>
                              <div class="col-xs-4 bubble-left">
                                <b class="left">{{ isset($comment['name']) ? $comment['name'] : '' }}</b>
                                <span class="date right">Posted: {{ $comment['post_date']->format('F Y') }}</span>
                                <p class="left">{{$comment['content']}}</p>
                                <!-- <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful ({{$comment['helpful']}})</button> -->
                                <div class="stars left">
                                  @for($i = 1; $i <= $comment['average']; $i++)
                                    <span class="icon icon-star"></span>
                                  @endfor
                                  @php ($rating = 5 - $comment['average'])
                                  @for($i = 1; $i <= $rating; $i++)
                                    <span class="icon icon-star-grey"></span>
                                  @endfor
                                </div>
                              </div>
                          @php ($y++)
                        @elseif($y == $counter)
                              </div>
                          </div>
                          <div class="item">
                              <div class="row">
                                <div class="col-xs-1 col-xs-offset-1 thumb">
                                  <img src="{{(isset($comment['img'])) ? url($comment['img']) : '/assets/default.png'}}" alt="Name Here">
                                </div>
                                <div class="col-xs-4 bubble-left">
                                  <b class="left">{{ isset($comment['name']) ? $comment['name'] : '' }}</b>
                                  <span class="date right">Posted: {{ $comment['post_date']->format('F Y') }}</span>
                                  <p class="left">{{$comment['content']}}</p>
                                  <!-- <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful ({{$comment['helpful']}})</button> -->
                                  <div class="stars left">
                                    @for($i = 1; $i <= $comment['average']; $i++)
                                      <span class="icon icon-star"></span>
                                    @endfor
                                    @php ($rating = 5 - $comment['average'])
                                    @for($i = 1; $i <= $rating; $i++)
                                      <span class="icon icon-star-grey"></span>
                                    @endfor
                                  </div>
                                </div>
                          @php ($y++)
                          @php ($counter = $counter + 2)
                        @else
                            <div class="col-xs-1 thumb">
                              <img src="{{(isset($comment['img'])) ? url($comment['img']) : '/assets/default.png'}}" alt="Name Here">
                            </div>
                            <div class="col-xs-4 bubble-left">
                              <b class="left">{{ isset($comment['name']) ? $comment['name'] : '' }}</b>
                              <span class="date right">Posted: {{ $comment['post_date']->format('F Y') }}</span>
                              <p class="left">{{$comment['content']}}</p>
                              <!-- <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful ({{$comment['helpful']}})</button> -->
                              <div class="stars left">
                                  @for($i = 1; $i <= $comment['average']; $i++)
                                    <span class="icon icon-star"></span>
                                  @endfor
                                  @php ($rating = 5 - $comment['average'])
                                  @for($i = 1; $i <= $rating; $i++)
                                    <span class="icon icon-star-grey"></span>
                                  @endfor
                              </div>
                            </div>
                            @php ($y++)
                            @endif


                        @if($y == $x)
                          </div>
                        </div>
                        @endif

                      @endforeach

                      <!-- <div class="item active">
                          <div class="row">
                            <div class="col-xs-1 col-xs-offset-1 thumb">
                              <img src="assets/testimonial-thumb.jpg" alt="Name Here">
                            </div>

                            <div class="col-xs-1 thumb">
                              <img src="assets/testimonial-thumb.jpg" alt="Name Here">
                            </div>
                            <div class="col-xs-4 bubble-left">
                              <b class="left">Jane Uy</b>
                              <span class="date right">Posted: March 2015</span>
                              <p class="left">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipiscing elit!</p>
                              <button class="btn btn-helpful left"><span class="icon icon-helpful"></span> Helpful <span class="small">(156)</span></button>
                              <div class="stars left">
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                                <span class="icon icon-star"></span>
                              </div>
                            </div>
                          </div>
                      </div>     -->
                            <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><span class="icon icon-left"></span></a>
                            <a data-slide="next" href="#quote-carousel" class="right carousel-control"><span class="icon icon-right"></span></i></a>
                        </div>
                    </div>
          </div>
            @endif
          @endif
        </div>
      </div>
    </section>

    <section id="faq">
      <div class="container">
        <div class="row">
          <div class="section-title">
             <h2 class="narrow-1x"><span class="icon icon-left-bar"></span>AGENT FAQ<span class="icon icon-right-bar"></span></h2>
             <span class="separator"></span>
             <p>Want to know more? Go to our FAQ for detailed answers to all of your questions.</p>
             <a class="btn btn-primary" href="{{env('APP_URL')}}/faq/agency"><i class="fa fa-question-circle" aria-hidden="true"></i> Visit FAQ Section</a>
          </div>
        </div>
      </div>
    </section>

@endsection


@section('scripts')
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        });

        $('#select-state').selectize({
            maxItems: 3,
            valueField: 'value',
            searchField: ['name', 'id'],
            labelField: 'name',
            options: [],
            create: false,
            render: {
                option: function(item, escape) {
                       return '<div class="option" data-selectable="" data-value="'+item.total_availability+','+item.id+''+item.name+'">'+item.name+' ('+item.id+')<span class="icn icon-available-'+item.total_availability+'"></span></div>';
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
                var currentValue = value[length-1];

                $.ajax({
                    method:'POST',
                    url:'{{ url('agency/validate-availability') }}',
                    data:{
                        data:currentValue
                    },
                    success: function(res){

                        if(!res.valid){
                            selectize[0].selectize.removeItem(currentValue);
                            $('#noPositions').modal();
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

        var validator = $('form[name=step_one_form]').validate({
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

    </script>
@stop
