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
    </header>
    <section id="progress-bar" class="header-margin">
        <div class="container">
            <div class="row">
                <span class="progress-line completed" style="width: 139px"></span>
                <span class="icon icon-review-completed"></span>
                <span class="progress-line"></span>
                <span class="icon icon-additional-info"></span>
                <span class="progress-line"></span>
                <span class="icon icon-add-agents"></span>
                <span class="progress-line"></span>
                <span class="icon icon-payment"></span>
                <span class="progress-line" style="width: 139px"></span>
            </div>
            <div class="row label">
                <span class="completed" style="margin-left: 114px;">Additional Information</span>
                <span style="margin-left: 202px;">Add Agents</span>
                <span style="margin-left: 215px;">Payment Method</span>
                <span style="margin-left: 195px;">Review Preferences</span>
            </div>
        </div>
    </section>
   

    <section id="sign-up-form">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 form-box">
                    <form name="step_one_form" action="{{env('APP_URL')}}/add-info" method="POST">
                        {{csrf_field() }}
                        <h2>Agency Registration Form</h2>
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{session('error')}}
                            </div>
                        @endif
                        <div class="col-xs-4">
                            <label>Agency Business Name</label>
                            <input type="text" name="agency-name" required value="{{isset($user['agency-name']) ? $user['agency-name'] : ''}}">
                            <label>Agency Trading Name</label>
                            <input type="text" name="trading-name" required value="{{isset($user['trading-name']) ? $user['trading-name'] : ''}}">
                            <label>Principal Name <span>(One Principal only as a point of contact)</span></label>
                            <input type="text" name="principal-name" required value="{{isset($user['principal-name']) ? $user['principal-name'] : ''}}">
                            <label>Business Address</label>
                            <input type="text" name="business-address" required value="{{isset($user['business-address']) ? $user['business-address'] : ''}}">
                        </div>
                        <div class="col-xs-4">
                            <label>Website</label>
                            <input type="text" name="website" value="{{isset($user['website']) ? $user['website'] : ''}}">
                            <label>Phone</label>
                            <input type="text" name="phone" required value="{{isset($user['phone']) ? $user['phone'] : ''}}">
                            <label>ABN</label>
                            <input type="text" name="abn" required value="{{isset($user['abn']) ? $user['abn'] : ''}}"}}>
                            <label>Positions <span>(Enter the postcode of the suburb required)</span></label>
                            <select id="select-state" name="positions[]" multiple class="demo-default"></select>
                            
                        </div>
                        <div class="col-xs-4">
                            <label>Base Commission Charge <i class="fa fa-question-circle tooltip-info"
                                                             aria-hidden="true" data-toggle="tooltip"
                                                             data-placement="right" title=""
                                                             data-original-title="NB. This figure is not shown to anyone. It is used for administration purposes only."
                                                             data-html="true"></i></label>
                            <div class="input-group">
                                <input type="text" min="0" name="base-commission" id="base-commission" required value="{{isset($user['base-commission']) ? $user['base-commission'] : ''}}">
                                <span class="input-group-addon" id="basic-addon1">%</span>
                            </div>
                            <label>Marketing Budget</label>
                            <input type="text" name="marketing-budget" value="{{isset($user['marketing-budget']) ? $user['marketing-budget'] : ''}}">
                            <label>Review URL <i class="fa fa-question-circle tooltip-info" aria-hidden="true"
                                                 data-toggle="tooltip" data-placement="right" title=""
                                                 data-original-title="If you have a profile or a rate and review list on another website that you would like to display, type the URL here, and it will be added to your profile page."
                                                 data-html="true"></i> </label>
                            <input type="text" name="review-url" value="{{isset($user['review-url']) ? $user['review-url'] : ''}}">

                            <button class="btn hs-primary" id="submit" disabled>NEXT <span
                                        class="icon icon-arrow-right"></span></button>
                            <div class="agreement">
                                <input type="checkbox" id="terms"> I accept the <a
                                        href="{{env('APP_URL')}}/legal/terms-conditions" target="_blank">Terms and
                                    Condition</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    	@php ($json = $user["pos_json"])
	
	
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ config('app.url').'/js/number.js' }}"></script>
    <!--
    <script type="text/javascript">
	    $('#select-state').on('change', function() {
			  $.ajax({
				url: '{{url('agency/add-position')}}',
				data: data,
				type: 'POST',
				processData: false,
				success: function(data){
						
					}
				});
			});
    </script>
-->
    <script type="text/javascript">
        var checker = document.getElementById('terms');
        var btn = document.getElementById('submit');

        checker.onchange = function () {

            btn.disabled = !this.checked;


        };

        $(function () {
            $('#base-commission').bind('input', function (e) {
                if (!Money.isValidMoney(e.target.value)) {
                    $(this).val('');
                }
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        });
        
        var selectedSuburbs = '{{!!$json!!}}';
        
        
		console.log(selectedSuburbs);
        var $positionSelector = $('#select-state').selectize({
            maxItems: 10,
            valueField: 'value',
            searchField: ['name', 'id'],
            labelField: 'name',
            hideSelected: true,
            options: [],
            create: false,
            render: {
                option: function (item, escape) {
                    return '<div class="option" data-selectable="" data-value="' + item.total_availability + ',' + item.id + '' + item.name + '">' + item.name + ' (' + item.id + ')<span class="icn icon-available-' + item.total_availability + '"></span></div>';
                }
            },
            load: function (query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '{{ url('agency/search-suburb') }}',
                    type: 'GET',
                    data: {
                        query: query
                    },
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        console.log('results: ', res);
                        callback(res.suburbs);
                        //callback(res.repositories.slice(0, 10));
                    }
                });
            }
        });
        


        var positionSelectorSelectize = $positionSelector[0].selectize;
        var json = JSON.parse('{!!$json!!}');
        		
		
		var name = '';
		var x = 1;
		
        for (var i = 0, len = json.length; i < len; i++) {
	        if(parseInt(json[i]['total_availability']) > 3){
		        json[i]['total_availability'] = 3;
	        }
	        
	         if(name == json[i]['name']){
		        json[i]['total_availability'] = parseInt(json[i]['total_availability']) - x;
		        var value = json[i]['id'] + '' + json[i]['name'] + '-dup-' + json[i]['total_availability'];
		        x = x + 1;
	        } else {
		        var value = json[i]['id'] + '' + json[i]['name'] + '-dup-' + json[i]['total_availability'];
	        }
	        
	        name = json[i]['name'];
	      
	        currentSuburb = {value: value,
		        			total_availability: json[i]['total_availability'],
		        			name: json[i]['name'],
		        			id: json[i]['id']};
		       
		   positionSelectorSelectize.addOption(currentSuburb);
		    positionSelectorSelectize.addItem(value);
			console.log(value);		   
		}

	

		
        var currentItems = {};
        var currentSuburb = {};
        
		
        positionSelectorSelectize.on('change', function (items) {

        });

        positionSelectorSelectize.on('item_add', function(value, $item){

            console.log('item_add', value);

            if (typeof value == "undefined" || value == null) {
                return false;
            }

            var suburbResponse = getSuburb(value);

            if (!suburbResponse.valid) {

                positionSelectorSelectize.removeItem(value);
                $('#noPositions').modal();

                return false;
            }

            currentSuburb = suburbResponse.suburb;
            var currentAvailability = currentSuburb.total_availability;

            var total_availability = updateCurrentItems(value, currentAvailability);

            if(total_availability>3){
                positionSelectorSelectize.removeItem(value);
                $('#noPositions').modal();

                return false;
            }

            currentSuburb.value = currentSuburb.id+currentSuburb.name+"-dup-"+total_availability;
            currentSuburb.total_availability = total_availability;
            positionSelectorSelectize.addOption(currentSuburb);

        });

        positionSelectorSelectize.on('item_remove', function(value, $item){

            var rawValue = value;
            var total_availability = 1;

            if(value.indexOf('-dup') !== false){

                rawValue = value.split('-dup')[0];

            }
			console.log('item-remove: ' + rawValue);
			
            if(currentItems.hasOwnProperty(rawValue)){
                total_availability = currentItems[rawValue]-1;
            } else {
	            total_availability = currentItems[rawValue]-2;
            }

            currentItems[rawValue] = total_availability;
			
			var availabilities = [1, 2, 3];
			index = availabilities.indexOf(total_availability);
			availabilities.splice(index, 1);
			
			console.log('avail' + index);
			positionSelectorSelectize.removeOption(value);

		
            return total_availability;

        });

        function getSuburb(currentValue) {

            console.log('currentValue', currentValue);

            var suburb = null;

            $.ajax({
                method: 'POST',
                url: '{{ url('agency/validate-availability') }}',
                data: {
                    data: currentValue
                },
                async: false,
                success: function (res) {
                    console.log('res: ', res);
                    suburb = res;
                }
            });

            return suburb;
        }

        function updateCurrentItems(value, currentAvailability) {

            var rawValue = value;
            var total_availability = currentAvailability+1;

            if(value.indexOf('-dup') !== false){

                rawValue = value.split('-dup')[0];

            }

            if(currentItems.hasOwnProperty(rawValue)){
                total_availability = currentItems[rawValue]+1;
            }

            currentItems[rawValue] = total_availability;

            return total_availability;
        }


        jQuery.validator.addMethod('positionsRequired', function (value, element) {

            if (typeof value == "undefined" || value == null || value == "") {

                $('.selectize-control .selectize-input').addClass('error');

                return false;
            }

            $('.selectize-control .selectize-input').removeClass('error');
            return true;

        });

        jQuery.validator.addMethod('tradeRequired', function (value, element) {

            if (typeof value == "undefined" || value == null || value == "") {

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
            rules: {
                'positions[]': {
                    positionsRequired: true
                },
                trade: {
                    tradeRequired: true
                }
            }
            /*submitHandler: function(form) {





             }*/
        });

        console.log('validator', validator);

    </script>
@stop
