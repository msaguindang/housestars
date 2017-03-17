
	<!-- RATE INFO -->
		<div class="modal fade" id="rateInfo" tabindex="-1" role="dialog" aria-labelledby="signup-area">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>Rate a Trade or Service</h4>
						<p class="sub-heading">Choose a tradesman or an agency.</p>
						<form method="post" action="/review">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
							<!-- dropdown list tradesmen and services -->
							<div class="btn-group dropdown">
								<button data-toggle="dropdown" class="btn btn-default dropdown-toggle">Please Select... <span class="caret"><i class="fa fa-angle-down" aria-hidden="true"></i></span></button>
								<ul class="dropdown-menu">
									@foreach($businesses as $business)	
									<li>
										<label for="{{$business->user_id}}">{{$business->meta_value}}</label>
										<input type="radio" id="{{$business->user_id}}" name="businessId" value="{{$business->user_id}}">
									</li>
									@endforeach
								</ul>
							</div>
							<!--<input type="text" name="" placeholder="Your Postcode" class="no-top"> </br></br>-->
							<button type="submit" class="btn hs-primary">Rate Tradesman Now</button>
						</form>	
					</div>
				</div>
			</div>
		</div>
