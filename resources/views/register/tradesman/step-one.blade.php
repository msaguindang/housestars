@extends("layouts.main")
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
                    <h2>Tradesman Registration Form</h2>
                    <form name="step_one_form" action="{{env('APP_URL')}}/add-info" method="POST">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{session('error')}}
                            </div>
                        @endif
                        {{csrf_field() }}
                        <div class="col-xs-8">
                            <div class="col-xs-6 no-padding-left">
                                <label>Business Name <span class="required-symbol">*</span></label>
                                <input type="text" name="business-name" class="required-input" required>
                                <label>Suburbs Working In
                                    <span>(Enter the desired postcode and select suburbs)</span> <span class="required-symbol">*</span></label>
                                <select id="select-state" name="positions[]" multiple class="demo-default"
                                        class="required-input" required>
                                    {{--@foreach ($suburbs as $suburb)
                                        @if($suburb->availability != '3')
                                            <option value="{{ $suburb->id}}{{ $suburb->name }}">{{ $suburb->name }} ({{ $suburb->id}})</option>
                                        @endif
                                    @endforeach--}}
                                </select>
                                <label>Trading Name <span class="required-symbol">*</span></label>
                                <input type="text" name="trading-name" class="required-input" required>
                            </div>
                            <div class="col-xs-6 no-padding-right">
                                <label>Website <span class="required-symbol">*</span></label>
                                <input type="text" name="website" class="required-input" required>
                                <label>ABN <span class="required-symbol">*</span></label>
                                <input type="text" name="abn" class="required-input" required>
                                <label>Normal Charge Rate <span class="required-symbol">*</span></label>
                                <input type="text" name="charge-rate" class="required-input" required>


                            </div>
                            <label>Write Business Description</label>
                            <textarea placeholder="" class="summary"></textarea>
                        </div>
                        <div class="col-xs-4">
                            <label>Trade or Service <span>(1 only)</span> <span class="required-symbol">*</span></label>
                            <div id="trade-btn-group" class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select...
                                    <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <input type="radio" id="t1" name="trade"
                                               value="Architectural Glass and Metal Technician">
                                        <label for="t1">Architectural Glass and Metal Technician</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t2" name="trade" value="Brick and Stone Mason">
                                        <label for="t2">Brick and Stone Mason</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t3" name="trade" value="Cement (Concrete) Finisher">
                                        <label for="t3">Cement (Concrete) Finisher</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t4" name="trade" value="Cement Mason">
                                        <label for="t4">Cement Mason</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t5" name="trade" value="Concrete Pump Operator">
                                        <label for="t5">Concrete Pump Operator</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t6" name="trade" value="Construction Boilermaker">
                                        <label for="t6">Construction Boilermaker</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t7" name="trade" value="Construction Craft Worker">
                                        <label for="t7">Construction Craft Worker</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t8" name="trade" value="Construction Millwright">
                                        <label for="t8">Construction Millwright</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t9" name="trade"
                                               value="Drywall, Acoustic and Lathing Applicator">
                                        <label for="t9">Drywall, Acoustic and Lathing Applicator</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t10" name="trade"
                                               value="Drywall Finisher and Plasterer">
                                        <label for="t10">Drywall Finisher and Plasterer</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t11" name="trade"
                                               value="Electrician - Construction and Maintenance">
                                        <label for="t11">Electrician - Construction and Maintenance</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t12" name="trade"
                                               value="Electrician - Domestic and Rural">
                                        <label for="t12">Electrician - Domestic and Rural</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t13" name="trade"
                                               value="Exterior Insulated Finish Systems Mechanic">
                                        <label for="t13">Exterior Insulated Finish Systems Mechanic</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t14" name="trade" value="Floor Covering Installer">
                                        <label for="t14">Floor Covering Installer</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t15" name="trade" value="General Carpenter">
                                        <label for="t15">General Carpenter</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t16" name="trade" value="Hazardous Materials Worker">
                                        <label for="t16">Hazardous Materials Worker</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t17" name="trade" value="Heat and Frost Insulator">
                                        <label for="t17">Heat and Frost Insulator</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t18" name="trade"
                                               value="Heavy Equipment Operator - Dozer">
                                        <label for="t18">Heavy Equipment Operator - Dozer</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t19" name="trade"
                                               value="Heavy Equipment Operator - Excavator">
                                        <label for="t19">Heavy Equipment Operator - Excavator</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t20" name="trade"
                                               value="Heavy Equipment Operator - Tractor Loader Backhoe">
                                        <label for="t20">Heavy Equipment Operator - Tractor Loader Backhoe</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t21" name="trade"
                                               value="Hoisting Engineer - Mobile Crane Operator 1">
                                        <label for="t21">Hoisting Engineer - Mobile Crane Operator 1</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t22" name="trade"
                                               value="Hoisting Engineer - Mobile Crane Operator 2">
                                        <label for="t22">Hoisting Engineer - Mobile Crane Operator 2</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t23" name="trade"
                                               value="Hoisting Engineer - Tower Crane Operator">
                                        <label for="t23">Hoisting Engineer - Tower Crane Operator</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t24" name="trade" value="Ironworker - Generalist">
                                        <label for="t24">Ironworker - Generalist</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t25" name="trade"
                                               value="Ironworker - Structural and Ornamental">
                                        <label for="t25">Ironworker - Structural and Ornamental</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t26" name="trade"
                                               value="Native Residential Construction Worker">
                                        <label for="t26">Native Residential Construction Worker</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t27" name="trade"
                                               value="Painter and Decorator - Commercial and Residential">
                                        <label for="t27">Painter and Decorator - Commercial and Residential</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t28" name="trade"
                                               value="Painter and Decorator - Industrial">
                                        <label for="t28">Painter and Decorator - Industrial</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t29" name="trade" value="Plumber">
                                        <label for="t29">Plumber</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t30" name="trade" value="Powerline Technician">
                                        <label for="t30">Powerline Technician</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t31" name="trade" value="Precast Concrete Erector">
                                        <label for="t31">Precast Concrete Erector</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t32" name="trade" value="Precast Concrete Finisher">
                                        <label for="t32">Precast Concrete Finisher</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t33" name="trade" value="Refractory Mason">
                                        <label for="t33">Refractory Mason</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t34" name="trade"
                                               value="Refrigeration and Air Conditioning Systems Mechanic">
                                        <label for="t34">Refrigeration and Air Conditioning Systems Mechanic</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t35" name="trade" value="Reinforcing Rodworker">
                                        <label for="t35">Reinforcing Rodworker</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t36" name="trade"
                                               value="Residential Air Conditioning Systems Mechanic ">
                                        <label for="t36">Residential Air Conditioning Systems Mechanic </label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t37" name="trade"
                                               value="Residential (Low Rise) Sheet Metal Installer">
                                        <label for="t37">Residential (Low Rise) Sheet Metal Installer</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t38" name="trade" value="Restoration Mason">
                                        <label for="t38">Restoration Mason</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t39" name="trade" value="Roofer">
                                        <label for="t39">Roofer</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t39" name="trade" value="Sheet Metal Worker">
                                        <label for="t39">Sheet Metal Worker</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t40" name="trade"
                                               value="Sprinkler and Fire Protection Installer">
                                        <label for="t40">Sprinkler and Fire Protection Installer</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t41" name="trade" value="Steamfitter">
                                        <label for="t41">Steamfitter</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="t42" name="trade"
                                               value="Terrazzo, Tile and Marble Setter">
                                        <label for="t42">Terrazzo, Tile and Marble Setter</label>
                                    </li>
                                </ul>
                            </div>
                            <label>Promotion Code</label>
                            <input type="text" name="promotion-code">

                            <button class="btn hs-primary" id="submit" disabled>NEXT <span
                                        class="icon icon-arrow-right"></span></button>
                            <div class="agreement">
                                <input type="checkbox" id="terms"> I accept the <a href="#">Terms and Condition</a>
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
            maxItems: 3,
            valueField: 'value',
            searchField: ['name', 'id'],
            labelField: 'name',
            options: [],
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
