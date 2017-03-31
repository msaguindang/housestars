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
                     <li><a>Hi, {{Sentinel::getUser()->name}}</a></li>
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

    <section id="savings-calculator" class="blue-area header-margin">
      <div class="container">
        <div class="row section-title">
         <h2 class="wide"><span class="icon icon-left-bar-white mobile-hidden"></span>Savings Estimation Calculator<span class="icon icon-right-bar-white mobile-hidden"></span></h2>
        </div>
        <div class="calculator">
          <form id="savingsCalc" method="POST">
            <div class="alert alert-danger" style="width: 100%; text-align: center; color: #000;"><span id="error"></span></div>
            {{csrf_field()}}
            <div class="col-xs-4">
              <label>Name</label>
              <input type="text" name="name">
              <label>Suburb</label>
              <select id="select-state" name="suburb"  class="demo-default"></select>
            </div>
            <div class="col-xs-4">
              <label>Email Address</label>
              <input type="text" name="email">
              <label>Property Type</label>
              <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                    <ul class="dropdown-menu">
                      <li>
                        <input type="radio" id="a1" name="property-type" value="Condominium">
                        <label for="a1">Condominium</label>
                      </li>
                      <li>
                        <input type="radio" id="a2" name="property-type" value="Commercial">
                        <label for="a2">Commercial</label>
                      </li>
                      <li>
                        <input type="radio" id="a3" name="property-type" value="Apartment">
                        <label for="a3">Apartment</label>
                      </li>
                      <li>
                        <input type="radio" id="a4" name="property-type" value="Foreclosures">
                        <label for="a4">Foreclosures</label>
                      </li>
                      <li>
                        <input type="radio" id="a5" name="property-type" value="Development">
                        <label for="a5">Development</label>
                      </li>
                      <li>
                        <input type="radio" id="a6" name="property-type" value="House">
                        <label for="a6">House</label>
                      </li>
                      <li>
                        <input type="radio" id="a7" name="property-type" value="Land">
                        <label for="a7">Land</label>
                      </li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-4">
              <label>Phone Number</label>
              <input type="text" name="phone">
              <label>Estimated Selling Price</label>
               <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                    <ul class="dropdown-menu">
                    <li>
                      <input type="radio" id="any" name="estimated-price" value="any">
                      <label for="any">Any Price</label>
                    </li>
                    <li>
                      <input type="radio" id="b1" name="estimated-price" value="$0 - $100,000">
                      <label for="b1">$0 - $100,000</label>
                    </li>
                    <li>
                      <input type="radio" id="b2" name="estimated-price" value="$100,000 - $200,000">
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

@endsection

@section('scripts')
<script type="text/javascript">
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

</script>
@stop
