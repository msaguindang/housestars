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
    


    <section id="settings" class="header-margin">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="row no-padding">
              <div class="spacing">
              </div>
              <div>
                <a class="btn btn-link" href="/profile">
                  <span class="fa fa-chevron-left"></span>
                  BACK
                </a>
              </div>
               @if(session('error'))
                  <div class="alert alert-danger error-box">
                    	{{session('error')}}
                  </div>
                  @endif
              <h2 class="section-title">Account Settings</h2>
              <div class="col-xs-6">
              <form action="{{env('APP_URL')}}/update-settings" method="POST" enctype="multipart/form-data">
                {{csrf_field() }}
                <label>Full Name</label>
                <input type="text" name="name" value="{{$data['name']}}">
                <label>Email <span class="font-weight: 300; font-style: italic">(You can't edit this field)</span></label> 
                <input type="text" name="email" value="{{$data['email']}}" disabled>
                <label>Password</label>
                <input type="password" name="password" placeholder="********">
                 <button class="btn hs-primary update-settings"><span class="icon icon-summary" style="margin-top: 6px;"></span>UPDATE SETTINGS <span class="icon icon-arrow-right"></span></button>
              </form>
              </div>
              <div class="col-xs-6">
                <form action="{{env('APP_URL')}}/update-payment" method="POST" enctype="multipart/form-data">
                {{csrf_field() }}
 
                <label>Credit Card</label>
                <input type="text" name="credit-card" value="**** **** **** {{$data['credit-card']}}">

                <div class="col-xs-8 no-padding" >
                  <label>Expiry Date</label>
                  <div class="btn-group" style="width: 40%">
                     <input type="text" size="2" name="exp_month" value="{{$data['expiry-month']}}">
                  </div> / <div class="btn-group" style="width: 50%">
                      <input type="text" size="2" name="exp_year" value="{{$data['expiry-year']}}">
                </div>
                </div>
                <div class="col-xs-4" style="padding-right: 0;">
                <label>CCV</label>
                <input type="text" name="cvc" placeholder="***">
                </div>
                <button class="btn hs-primary update-settings"><span class="icon icon-summary" style="margin-top: 6px;"></span>UPDATE CARD DETAILS <span class="icon icon-arrow-right"></span></button>
                </form>
              </div>

            </div>
            <div class="row no-padding agent-settings">
              <div class="spacing"></div>
              <h2 class="section-title">List Agents</h2>
              <form class="repeater agents small-screen" action="{{env('APP_URL')}}/update-agents" method="POST">
                {{csrf_field() }}

                
                <table>
                  <thead>
                    <tr>
                      <th style="width: 30%">FULL NAME</th>
                      <th style="width: 30%">EMAIL ADDRESS</th>
                      <th style="width: 30%">PASSWORD</th>
                      <th>ACTIVE/INACTIVE</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody data-repeater-list="add-agents">
                      <tr data-repeater-item>
                          <td style="width: 30%"><input type="text" name="name" value=""></td>
                          <td style="width: 30%"><input type="text" name="email" value=""></td>
                          <td style="width: 30%"><input type="password" name="password" placeholder=""></td>
                          <td style="width: 5%"><label class="switch" style="width: 70px">
                              <input type="checkbox" name="active">
                            <div class="slider round"></div></label></td>
                          <td>
                              <i data-repeater-delete  class="fa fa-minus" aria-hidden="true" style="color: #000"></i></i>
                          </td>
                        </tr>
                      @foreach($agents as $agent)
                        <tr data-repeater-item>
                            <input type="hidden" name="id" value="{{$agent->agent_id}}">
                          <td style="width: 30%"><input type="text" name="name" value="{{$agent->name}}"></td>
                          <td style="width: 30%"><input type="text" name="email" value="{{$agent->email}}"></td>
                          <td style="width: 30%"><input type="password" name="password" placeholder="********"></td>
                          <td style="width: 5%"><label class="switch" style="width: 70px">
                            @if($agent->active == '1')
                              <input type="checkbox" name="active" checked>
                            @else
                              <input type="checkbox" name="active">
                            @endif
                            <div class="slider round"></div></label></td>
                          <td>
                             @if($agent)
                              <a href="#" onclick="document.getElementById('delete-agent-{{$agent->agent_id}}').submit()"><i data-repeater-delete  class="fa fa-minus" aria-hidden="true" style="color: #000"></i></i></a>
                            @else
                              <a href="#" onclick="document.getElementById('delete-agent-{{$agent->agent_id}}').submit()"><i data-repeater-delete  class="fa fa-minus" aria-hidden="true" style="color: #000"></i></i></a>
                            @endif
                          </td>
                        </tr>
                      @endforeach


                  </tbody>
                </table>
               <div class="col-xs-2 col-xs-offset-7"><i data-repeater-create class="fa fa-plus add-agent" aria-hidden="true"><span class="btn-label">ADD MORE STAFF</span></i></div>
                <div class="col-xs-3"><button class="btn hs-primary update-settings"><span class="icon icon-summary" style="margin-top: 6px;"></span>UPDATE AGENT LIST<span class="icon icon-arrow-right"></span></button></div>
            </form>
            
            

            <form class="repeater agents mobile" action="{{env('APP_URL')}}/update-agents" method="POST">
              {{csrf_field() }}
			  

                <div data-repeater-list="add-agents" class="rep-agents">
                    <div data-repeater-item>
                      <label>Full Name</label>
                        <input type="text" name="name" value="">
                        <label>Email Address</label>
                        <input type="text" name="email" value="">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="">
                        <label>Status (Active/Inactive)</label>
                        <label class="switch" style="width: 70px">
                            <input type="checkbox" name="active">
                          <div class="slider round"></div></label>
                        <i data-repeater-delete  class="fa fa-minus" aria-hidden="true" style="color: #000"><span class="btn-label">REMOVE AGENT</span></i></i>
                      </div>
                    @foreach($agents as $agent)
                      <div data-repeater-item>

                        <input type="hidden" name="id" value="{{$agent->agent_id}}">
                        <label>Full Name</label>

                        <input type="text" name="name" value="{{$agent->name}}">
                        <label>Email Address</label>

                        <input type="text" name="email" value="{{$agent->email}}">
                          <label>Password</label>

                        <input type="password" name="password" placeholder="********">
                        <label>Status (Active/Inactive)</label>
                        <label class="switch" style="width: 70px">
                          @if($agent->active == '1')
                            <input type="checkbox" name="active" checked>
                          @else
                            <input type="checkbox" name="active">
                          @endif
                          <div class="slider round"></div></label>
                           @if($agent)
                            <a href="#" onclick="document.getElementById('delete-agent-{{$agent->agent_id}}').submit()"><i data-repeater-delete  class="fa fa-minus" aria-hidden="true" style="color: #000"><span class="btn-label">REMOVE AGENT</span></i></i></a>
                          @else
                            <a href="#" onclick="document.getElementById('delete-agent-{{$agent->agent_id}}').submit()"><i data-repeater-delete  class="fa fa-minus" aria-hidden="true" style="color: #000"><span class="btn-label">REMOVE AGENT</span></i></i></a>
                          @endif

                      </div>
                    @endforeach


                </div>
             <div class="col-xs-2 col-xs-offset-7"><i data-repeater-create class="fa fa-plus add-agent" aria-hidden="true"><span class="btn-label">ADD MORE STAFF</span></i></div>
              <div class="col-xs-3"><button class="btn hs-primary update-settings"><span class="icon icon-summary" style="margin-top: 6px;"></span>UPDATE AGENT LIST<span class="icon icon-arrow-right"></span></button></div>
          </form>
            @foreach($agents as $agent)
               <form action="{{env('APP_URL')}}/delete-agent" method="POST" id="delete-agent-{{$agent->agent_id}}"> {{csrf_field() }}<input type="hidden" name="agent-id" value="{{$agent->agent_id}}"></form>
            @endforeach
            </div>
          </div>
          <div class="spacing"></div>
        </div>
      </div>
    </section>

@endsection

 @section('scripts')

    <script src="{{asset('js/jquery.repeater.js')}}"></script>
    <script src="{{asset('js/bootstrap-toggle.min.js')}}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('.repeater').repeater({});
        });

        $(function() {
          $('#select-state').selectize({
              maxItems: 3
          });
        });


    </script>
 @stop
