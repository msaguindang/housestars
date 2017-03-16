@extends("layouts.main")
@section("content")
<div id="loading"><div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}" /></div></div>

<header id="header" class="animated desktop">
        <div class="container">
          <div class="row">
            <div class="col-xs-3 branding">
              <a href="{{config('app.url')}}/"><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
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
                      <form action="{{config('app.url')}}/logout" method="POST" id="logout-form">
                        {{csrf_field() }}
                        <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
                      </form>
                    </li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{config('app.url')}}/profile">Profile</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="{{config('app.url')}}/">Home</a></li>
                    @else
                    <li><span class="icon icon-customer-dark"></span><a href="{{config('app.url')}}/customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="{{config('app.url')}}/trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="{{config('app.url')}}/agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="{{config('app.url')}}/">Home</a></li>
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
    </header>
 <form action="{{config('app.url')}}/tradesman/update-profile" method="POST" enctype="multipart/form-data">
  {{csrf_field() }}
    <section id="cover-container" class="header-margin" style="background: url({{config('app.url')}}/{{$data['cover-photo']}})">

        {{csrf_field() }}
      <div class="cover-img">
        <div class="breadcrumbs container">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <a href="">Tradesman</a> > <span class="blue">Tradesman Dashboard</span> </p>
            <div class="upload">
              <input id="CoverUpload" type="file" name="cover-photo" class="tooltip-info" data-toggle="tooltip" data-placement="left" title="" data-original-title="<b>Minimum size: 1328 x 272</b>" data-html="true">
            <button class="btn hs-secondary update-cover"><span class="icon icon-image"></span> Change Photo</button>
            </div>
          </div>
          <div class="profile">
            <div class="profile-img" style="background: url({{config('app.url')}}/{{$data['profile-photo']}}) 100%">
              <button class="btn hs-secondary update-profile"><span class="icon icon-image"></span> Change Photo</button>
              <input id="profileupload" type="file" name="profile-photo" class="tooltip-info" data-toggle="tooltip" data-placement="right" title="" data-original-title="<b>Minimum size: 117 x 117</b>" data-html="true">
            </div>
            <div class="profile-info">
              <label>Tradesman Name</label>

              @if(isset($data['business-name']))
              <input type="text" name="business-name" value="{{$data['business-name']}}">
              @else
              <input type="text" name="business-name" value="">
              @endif
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="edit-user-info" class="tradesman">
      <div class="container">
        <div class="row">
          <div class="col-xs-9" style="padding-left: 0">
            <div class="col-xs-3"></div>
            <div class="col-xs-4 dash-field">
              <label>Website</label>

              @if(isset($data['website']))
              <input type="text" name="website" value="{{$data['website']}}">
              @else
              <input type="text" name="website" value="">
              @endif
            </div>
            <div class="col-xs-4 dash-field" style="padding-right: 0">
              <label>Charge Type</label>

              @if(isset($data['charge-rate']))
              <input type="text" name="charge-rate" value="{{$data['charge-rate']}}">
              @else
              <input type="text" name="charge-rate" value="">
              @endif
            </div>

            <div class="col-xs-3">
              <label>ABN</label>

              @if(isset($data['abn']))
              <input type="text" name="abn" value="{{$data['abn']}}">
              @else
              <input type="text" name="abn" value="">
              @endif
            </div>
            <div class="col-xs-4 dash-field">
              <label>Trading As</label>
              <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-default dropdown-toggle"><span class="value">
                    @if(isset($data['trade']))
                    {{$data['trade']}}
                    @else
                    Select a Trade
                    @endif

                  </span><span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
                  <ul class="dropdown-menu">
                    <li>
                      <input type="radio" id="t1" name="trade" value="Architectural Glass and Metal Technician">
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
                      <input type="radio" id="t9" name="trade" value="Drywall, Acoustic and Lathing Applicator">
                      <label for="t9">Drywall, Acoustic and Lathing Applicator</label>
                    </li>
                    <li>
                      <input type="radio" id="t10" name="trade" value="Drywall Finisher and Plasterer">
                      <label for="t10">Drywall Finisher and Plasterer</label>
                    </li>
                    <li>
                      <input type="radio" id="t11" name="trade" value="Electrician - Construction and Maintenance">
                      <label for="t11">Electrician - Construction and Maintenance</label>
                    </li>
                    <li>
                      <input type="radio" id="t12" name="trade" value="Electrician - Domestic and Rural">
                      <label for="t12">Electrician - Domestic and Rural</label>
                    </li>
                    <li>
                      <input type="radio" id="t13" name="trade" value="Exterior Insulated Finish Systems Mechanic">
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
                      <input type="radio" id="t18" name="trade" value="Heavy Equipment Operator - Dozer">
                      <label for="t18">Heavy Equipment Operator - Dozer</label>
                    </li>
                    <li>
                      <input type="radio" id="t19" name="trade" value="Heavy Equipment Operator - Excavator">
                      <label for="t19">Heavy Equipment Operator - Excavator</label>
                    </li>
                    <li>
                      <input type="radio" id="t20" name="trade" value="Heavy Equipment Operator - Tractor Loader Backhoe">
                      <label for="t20">Heavy Equipment Operator - Tractor Loader Backhoe</label>
                    </li>
                    <li>
                      <input type="radio" id="t21" name="trade" value="Hoisting Engineer - Mobile Crane Operator 1">
                      <label for="t21">Hoisting Engineer - Mobile Crane Operator 1</label>
                    </li>
                    <li>
                      <input type="radio" id="t22" name="trade" value="Hoisting Engineer - Mobile Crane Operator 2">
                      <label for="t22">Hoisting Engineer - Mobile Crane Operator 2</label>
                    </li>
                    <li>
                      <input type="radio" id="t23" name="trade" value="Hoisting Engineer - Tower Crane Operator">
                      <label for="t23">Hoisting Engineer - Tower Crane Operator</label>
                    </li>
                    <li>
                      <input type="radio" id="t24" name="trade" value="Ironworker - Generalist">
                      <label for="t24">Ironworker - Generalist</label>
                    </li>
                    <li>
                      <input type="radio" id="t25" name="trade" value="Ironworker - Structural and Ornamental">
                      <label for="t25">Ironworker - Structural and Ornamental</label>
                    </li>
                    <li>
                      <input type="radio" id="t26" name="trade" value="Native Residential Construction Worker">
                      <label for="t26">Native Residential Construction Worker</label>
                    </li>
                    <li>
                      <input type="radio" id="t27" name="trade" value="Painter and Decorator - Commercial and Residential">
                      <label for="t27">Painter and Decorator - Commercial and Residential</label>
                    </li>
                    <li>
                      <input type="radio" id="t28" name="trade" value="Painter and Decorator - Industrial">
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
                      <input type="radio" id="t32" name="trade" value="Precast Concrete Finisher"
                      <label for="t32">Precast Concrete Finisher</label>
                    </li>
                    <li>
                      <input type="radio" id="t33" name="trade" value="Refractory Mason">
                      <label for="t33">Refractory Mason</label>
                    </li>
                    <li>
                      <input type="radio" id="t34" name="trade" value="Refrigeration and Air Conditioning Systems Mechanic">
                      <label for="t34">Refrigeration and Air Conditioning Systems Mechanic</label>
                    </li>
                    <li>
                      <input type="radio" id="t35" name="trade" value="Reinforcing Rodworker" >
                      <label for="t35">Reinforcing Rodworker</label>
                    </li>
                    <li>
                      <input type="radio" id="t36" name="trade" value="Residential Air Conditioning Systems Mechanic ">
                      <label for="t36">Residential Air Conditioning Systems Mechanic </label>
                    </li>
                    <li>
                      <input type="radio" id="t37" name="trade" value="Residential (Low Rise) Sheet Metal Installer">
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
                      <input type="radio" id="t39" name="trade" value="Sheet Metal Worker" >
                      <label for="t39">Sheet Metal Worker</label>
                    </li>
                    <li>
                      <input type="radio" id="t40" name="trade" value="Sprinkler and Fire Protection Installer">
                      <label for="t40">Sprinkler and Fire Protection Installer</label>
                    </li>
                    <li>
                      <input type="radio" id="t41" name="trade" value="Steamfitter">
                      <label for="t41">Steamfitter</label>
                    </li>
                    <li>
                      <input type="radio" id="t42" name="trade" value="Terrazzo, Tile and Marble Setter">
                      <label for="t42">Terrazzo, Tile and Marble Setter</label>
                    </li>
                  </ul>
              </div>
            </div>
            <div class="col-xs-4 dash-field" style="padding-right: 0">
              <label>Postcodes Working In</label>
              <select id="select-state" name="positions[]" multiple class="demo-default"
                      class="required-input" required>
                      @if(isset($data['suburbs']))
                        @foreach ($data['suburbs'] as $suburb)
                          <option value="{{ $suburb['code']}}{{ $suburb['name'] }}" selected>{{ $suburb['name'] }}</option>
                        @endforeach
                      @endif
              </select>
            </div>
          </div>
          <div class="col-xs-3">
            <label>Write Business Description</label>

            @if(isset($data['summary']))
              <textarea style="height: 230px;" name="summary">{{$data['summary']}}</textarea>
              @else
              <textarea style="height: 230px;" name="summary"></textarea>
              @endif
            <button class="btn hs-primary full-width"><span class="icon icon-save" style="margin-top: 6px;"></span>SAVE CHANGES <span class="icon icon-arrow-right"></span></button>
          </div>
          <div class="spacing"></div>
        </div>
      </div>
    </section>
     </form>


      <div class="container gallery-uploader">
        <div class="row">
          <div class="col-xs-9">
              <div class="upload-gallery" style="margin: 35px 0;">
                <div class="col-xs-7">
                  <label>Gallery Photos</label>
                  <div class="gallery">

                  @if(isset($data['gallery']))
                    @foreach ($data['gallery'] as $item)
                      <div class="item"><a href="#" data-item-id="{{$item['id']}}" data-token="{{ csrf_token() }}"><i class="fa fa-times" aria-hidden="true" id="close"></a></i><img src="{{url($item['url'])}}" alt="" style="width: 100%; height: auto;"></div>
                    @endforeach
                  @endif
                  </div>

                </div>
                <div class="col-xs-5">
                  <label>Upload More Gallery Photos</label>
                  <div class="upload-media">
                  <form  action="{{config('app.url')}}/upload" method="POST" enctype="multipart/form-data" class="dropzone">
                    {{csrf_field() }}

                  </form>
                  </div>


                </div>
              </div>
            </div>
        </div>
      </div>


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

     <script type="text/javascript">

      $(".item a").click(function(){
        var token = $(this).data('token');
        var id = $(this).data('item-id');
        console.log(token);
        $.ajax({
          url: '/delete-item',
          data: {'_token': token, 'item-id': id},
          type: 'POST',
          success: function(result){
            $('.item a[data-item-id=' + id + ']').parent().addClass('hidden');
          }
        });
      });


     </script>

     <script src="{{asset('js/image-preview.js')}}"></script>
@stop
