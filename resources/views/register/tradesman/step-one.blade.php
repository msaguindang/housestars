@extends("layouts.main")
<?php
    $businessName = isset($data['business-name']) ? $data['business-name'] : '';
    $tradingName = isset($data['trading-name']) ? $data['trading-name'] : '';
    $summary = isset($data['summary']) ? $data['summary'] : '';
    $trade = isset($data['trade']) ? $data['trade'] : '';
    $website = isset($data['website']) ? $data['website'] : '';
    $abn = isset($data['abn']) ? $data['abn'] : '';
    $chargeRate = isset($data['charge-rate']) ? $data['charge-rate'] : '';
    $phone = isset($data['phone-number']) ? $data['phone-number'] : '';
    $promotionCode = isset($data['promotion-code']) ? $data['promotion-code'] : '';
    $positions = isset($data['positions']) ? json_encode($data['positions']) : json_encode([]);
    $selectedTradeIndex = -1;
?>

@section("content")
    <div id="loading">
        <div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}"/></div>
    </div>

    <header id="header" class="animated desktop">
        <div class="container">
            <div class="row">
                <div class="col-xs-3 branding">
                    <a href="{{env('APP_URL')}}/"><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
                </div>
                <div class="col-xs-7 col-xs-offset-2 navigation">
                    <div class="row top-links">
                        <div class="customer-care">
                            <p><span class="label">Call Customer Care </span><a href="tel:0404045597" class="number">0404045597</a>
                            </p>
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
                                            <a href="#"
                                               onclick="document.getElementById('logout-form').submit()">Logout</a>
                                        </form>
                                    </li>
                                    <li><span class="icon icon-tradesman-dark"></span><a
                                                href="{{env('APP_URL')}}/profile">Profile</a></li>
                                    <li><span class="icon icon-home-dark"></span><a href="{{env('APP_URL')}}/">Home</a>
                                    </li>
                                @else
                                    <li><span class="icon icon-customer-dark"></span><a
                                                href="{{env('APP_URL')}}/customer">Customer</a></li>
                                    <li><span class="icon icon-tradesman-dark"></span><a
                                                href="{{env('APP_URL')}}/trades-services">Trades & Services</a></li>
                                    <li><span class="icon icon-agency-dark"></span><a href="{{env('APP_URL')}}/agency">Agency</a>
                                    </li>
                                    <li><span class="icon icon-home-dark"></span><a href="{{env('APP_URL')}}/">Home</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="progress-bar" class="header-margin tradesman">
        <div class="container">
            <div class="row">
                <span class="progress-line completed" style="width: 139px"></span>
                <span class="icon icon-additional-info-completed"></span>
                <span class="progress-line" style="width: 328px"></span>
                <span class="icon icon-add-agents"></span>
                <span class="progress-line" style="width: 360px"></span>
                <span class="icon icon-payment"></span>
                <span class="progress-line" style="width: 139px"></span>
            </div>
            <div class="row label">
                <span class="completed" style="margin-left: 115px;">Additional Information</span>
                <span style="margin-left: 297px;">Payment Method</span>
                <span style="margin-left: 330px;">Review Preferences</span>
            </div>
        </div>
    </section>
    <section id="sign-up-form">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 form-box tradesman" style="padding: 40px 25px;">
                    <h2>Trade/Service Registration Form</h2>
                    <form name="step_one_form" action="{{env('APP_URL')}}/add-info" method="POST">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{session('error')}}
                            </div>
                        @endif
                        {{csrf_field() }}
                        <div class="col-xs-8">
                            <div class="col-xs-6 no-padding-left">
                                <label>Business Name <span class="required-symbol">*</span> <span class="placeholder">This name will be displayed in search results</span></label>
                                <input type="text" name="business-name" class="required-input" value="{{ $businessName}} " required>
                                <label>Postcodes Serviced
                                    <!-- Suburbs Working In <span>(Enter the desired postcode and select suburbs)</span>  -->
                                    <span class="required-symbol">*</span></label>
                                <select id="select-state" name="positions[]" multiple class="demo-default"
                                        class="required-input" required>
                                    {{--@foreach ($suburbs as $suburb)
                                        @if($suburb->availability != '3')
                                            <option value="{{ $suburb->id}}{{ $suburb->name }}">{{ $suburb->name }} ({{ $suburb->id}})</option>
                                        @endif
                                    @endforeach--}}
                                </select>
                                <label>Trading Name <span class="required-symbol">*</span> <span class="placeholder">For a sole trader or a partnership, please enter N/A.</span></label>
                                <input type="text" name="trading-name" class="required-input" value="{{ $tradingName}} " required>
                            </div>
                            <div class="col-xs-6 no-padding-right">
                                <label>Website <span class="required-symbol">*</span></label>
                                <input type="text" name="website" class="required-input" value="{{ $website }} " required>
                                <label>ABN <span class="required-symbol">*</span></label>
                                <input type="text" name="abn" class="required-input" value="{{ $abn}} " required>
                                <label>Standard Hourly Rate <span class="required-symbol">*</span> <span class="placeholder">Enter N/A if this does not apply to you</span></label>
                                <input type="text" name="charge-rate" class="required-input" value="{{ $chargeRate }} " required>
                            </div>
                            <label>Write Business Description</label>
                            <textarea placeholder="" class="summary" name="summary">{{$summary}}</textarea>
                        </div>
                        <div class="col-xs-4">
                            <label>Trade or Service <span class="required-symbol">*</span> <span>(1 only)</span></label>
                            <div id="trade-btn-group" class="btn-group">
                                <button data-toggle="dropdown" id="trade-service-select" class="btn btn-default dropdown-toggle">
                                    {{-- empty($trade) ? 'Please Select... ' :  --}}
                                    Please Select... 
                                    <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($categories as $index => $cat)
                                        @if (!empty($trade) && strtolower($trade) == strtolower($cat->category))
                                            @php ($selectedTradeIndex = ($index+1))
                                        @endif
                                        <li>
                                            <input type="radio" id="t{{$index+1}}" name="trade" value="{{ $cat->category }}">
                                            <label for="t{{$index+1}}">{{ $cat->category }}</label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <label>Promotion Code</label>
                            <input type="text" name="promotion-code" value="{{ $promotionCode }} ">
                            
                            <label>Phone Number</label>
                            <input type="text" name="phone-number" value="{{ $phone }} ">

                            <button class="btn hs-primary" id="submit" disabled>NEXT <span
                                        class="icon icon-arrow-right"></span></button>
                            <div class="agreement">
                                <input type="checkbox" id="terms"> I accept the <a href="{{env('APP_URL')}}/legal/terms-conditions" target="_blank">Terms and Condition</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        var checker = document.getElementById('terms');
        var btn = document.getElementById('submit');

        checker.onchange = function () {
            btn.disabled = !this.checked;
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        });
        
        $('#select-state').selectize({
            maxItems: 10000,
            valueField: 'value',
            searchField: ['name', 'id'],
            labelField: 'id',
            options: [],
            create: false,
            render: {
                option: function(item, escape) {
                    return '<div class="option" data-selectable="" data-value="'+item.id+''+item.name+'">'+item.id+'</div>';
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
                        callback(res.suburbs);
                    }
                });
            },
            onChange: function(value) {

                if(typeof value == "undefined" || value == null) {
                    return false;
                }

                var selectize = $('#select-state').selectize();
                var length = value.length;
                var currentValue = value[length-1];

                $.ajax({
                    method:'POST',
                    url:'{{ url('tradesman/validate-availability') }}',
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
        
        // var positions = {!! $positions !!};
        // $.each(positions, function(id, item) {
        //     $('<div class="option" data-selectable="" data-value="'+item.id+''+item.name+'">'+item.id+'</div>').insertBefore($(".selectize-input.items > input"));
        // });

        jQuery.validator.addMethod('positionsRequired', function(value, element){

            if(typeof value == "undefined" || value == null || value == ""){

                $('.selectize-control .selectize-input').addClass('error');

                return false;
            }

            $('.selectize-control .selectize-input').removeClass('error');
            return true;
        });

        jQuery.validator.addMethod('tradeRequired', function(value, element){
            if(typeof value == "undefined" || value == null || value == "") {

                console.log('undefined trade');
                $('#trade-btn-group').addClass('error');

                return false;
            }

            $('#trade-btn-group').removeClass('error');
            return true;

        });

        var validator = $('form[name=step_one_form]').validate({
            errorPlacement: function (error, element) {
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
        });

        var selectedTradeIndex = {!! $selectedTradeIndex !!};
        if (selectedTradeIndex != -1) {
            $("#t"+selectedTradeIndex).trigger('click');
        } 
    </script>
@stop
