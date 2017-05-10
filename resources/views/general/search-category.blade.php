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

    <section id="cover-container" class="header-margin">
      <div class="cover-img">
        <div class="container">
          <div class="breadcrumbs">
          <div class="row">
            <p class="links"><a href="">Home Page</a> > <span class="blue">Search Category Listings</span> </p>
          </div>
        </div>
        <div class="row page-info">
          <h2 class="wide"><span class="icon icon-left-bar"></span> Search for a Trade or Service business <span class="icon icon-right-bar"></span></h2>
          <span class="separator"></span>
          <p>Selecting your next Trade or Service with Housestars means no nasty surprises. Each of our business are rated and reviewed so you can choose the one that is best suited to your needs. Just enter your suburb below to get started.</p>
        </div>
        </div>
      </div>
    </section>

    <section id="search-bar">
      <div class="container">
        <div class="row">
          <form id="categorySearch">
            {{csrf_field() }}
            <!-- <div class="col-xs-10">
              <input type="text" name="suburb" placeholder="Suburb" required id="suburb">
            </div> -->
            <div class="col-xs-10">
              <input class="" type="text" name="suburb" placeholder="Suburb" required id="suburb">
            </div>
            <div class="col-xs-2">
              <button class="btn hs-primary full-width search">
                <span class="icon icon-search"></span>SEARCH
              </button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <section id="result">
      <div class="container">
        <div class="row result">
          <div class="row section-heading">
          <div class="col-xs-8 col-xs-offset-2 section-title">
            <div class="message"></div>
          </div>
        </div>
        <div class="row category">
          <div id="trades"></div>
          <div class="spacing"></div>
          
        </div>

        </div>
      </div>
    </section>


@endsection

@section('scripts')
  @parent
  <script type="text/javascript">
    $('body').on('click', "a[data-target='#noTradesmen'], button[data-target='#noTradesmen']", function (e) {
      $suburb = $('#suburb').val();
      $('#search-suburb').val($suburb);
    });

    $(document).on('mouseenter', '[data-toggle="tooltip"]', function() {
        $(this).tooltip('show');
    });
    $(document).on('mouseleave', '[data-toggle="tooltip"]', function() {
        $(this).tooltip('hide');
    });
  </script>

  <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
        });
        $defSearch = "<span class='icon icon-search'></span>SEARCH";
        $searchBtn = $('button.search');

        $('#suburb').selectize({
            maxItems: 1,
            valueField: 'value',
            searchField: ['name', 'id'],
            labelField: 'name',
            create: false,
            render: {
                option: function(item, escape) {
                  return '<div class="option" data-value="'+item.name+'">'+item.name+' ('+item.id+')</div>';
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
                      $searchBtn.html($defSearch);
                      callback();
                    },
                    beforeSend: function() {
                      $searchBtn.html("<span class='fa fa-spinner fa-spin fa-2x' /> SEARCH");
                    },
                    success: function(res) {
                      $searchBtn.html($defSearch);
                      callback(res.suburbs);
                    }
                });
            }
        });
        $('.selectized').siblings('div').removeClass('selectize-control');
        $('.selectize-input').css('border', '0px');
    </script>
@endsection