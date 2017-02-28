@extends("layouts.main")
@section("content")
<div id="loading"><div class="loading-screen"><img id="loader" src="{{asset('assets/loader.png')}}" /></div></div>

<header id="header" class="animated">
        <div class="container">
          <div class="row">
            <div class="col-xs-3 branding">
              <a href=""><img src="{{asset('assets/logo-nav.png')}}" alt="HouseStars Logo"></a>
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
                  		<form action="logout" method="POST" id="logout-form">
                        {{csrf_field() }}
                        <a href="#" onclick="document.getElementById('logout-form').submit()">Logout</a>
                      </form>
                  	</li>
                  	<li><span class="icon icon-tradesman-dark"></span><a href="">Profile</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
                  	@else
                  	<li><span class="icon icon-customer-dark"></span><a href="customer" >Customer</a></li>
                    <li><span class="icon icon-tradesman-dark"></span><a href="trades-services">Trades & Services</a></li>
                    <li><span class="icon icon-agency-dark"></span><a href="agency">Agency</a></li>
                    <li><span class="icon icon-home-dark"></span><a href="/">Home</a></li>
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
			<span class="icon icon-completed"></span>
			<span class="progress-line completed"></span>
			<span class="icon icon-additional-info-completed"></span>
			<span class="progress-line"></span>
			<span class="icon icon-add-agents"></span>
			<span class="progress-line"></span>
			<span class="icon icon-payment"></span>
			<span class="progress-line" style="width: 139px"></span>
		</div>
		<div class="row label">
			<span class="completed" style="margin-left: 114px;">Additional Information</span>
			<span class="completed" style="margin-left: 202px;">Add Agents</span>
			<span style="margin-left: 215px;">Payment Method</span>
			<span style="margin-left: 195px;">Review Preferences</span>
		</div>
	</div>
</section>

<section id="sign-up-form">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 form-box" style="padding: 40px">
				<h2>Add Agents</h2>
				<p>By adding your staff, they can update your profile page with pictures, stats and comments. If they leave your company, just mark them inactive.</p>
				<form class="repeater agents" action="add-agents" method="POST">
					{{csrf_field() }}

					@if(session('error'))
					<div class="alert alert-danger">
						{{session('error')}}
					</div>
					@endif
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
								<td style="width: 30%"><input type="text" name="name" value="" placeholder="" required/></td>
								<td style="width: 30%"><input type="text" name="email" value="" placeholder="" required/></td>
								<td style="width: 30%"><input type="password" name="password" value="" placeholder="" required/></td>
								<td style="padding: 0 15px;"><label class="switch"><input type="checkbox" name="active"><div class="slider round"></div></label></td>
								<td><i data-repeater-delete  class="fa fa-minus" aria-hidden="true"></i></i></td>
							</tr>
						</tbody>
					</table>
					<div class="col-xs-2 col-xs-offset-8"><i data-repeater-create class="fa fa-plus add-agent" aria-hidden="true"><span class="btn-label">ADD MORE AGENTS</span></i></div>
				    <div class="col-xs-2"><button class="btn hs-primary">NEXT <span class="icon icon-arrow-right"></span></button></div>
				    
				</form>
				
			</div>
		</div>
	</div>
</section>


 @endsection

 @section('scripts')
     <script src="{{asset('js/jquery.repeater.js')}}"></script>
     <script src="{{asset('js/bootstrap-toggle.min.js')}}"></script>
     <script>
	    $(document).ready(function () {
	        $('.repeater').repeater({});
	    });
	</script>
@stop