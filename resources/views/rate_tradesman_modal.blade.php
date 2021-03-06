<!-- RATE A TRADESMAN 2-->
		<div class="modal fade" id="rateModal" tabindex="-1" role="dialog" aria-labelledby="signup-area">
			<div class="modal-dialog" role="document" style="margin-top: 3%;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<h4>Review Page</h4>
						<div class="col-xs-8  col-xs-offset-2 tradesman-info">
							@if ($businessInfo['photo'])
								<div class="col-xs-4 tradesman-profile">
									<img src="/{{ $businessInfo['photo'] }}" alt="{{$businessInfo['trading-name']}}" id="tradesmanPic">
								</div>
								<div class="col-xs-8 tradesman-name">
									<h4 id="tradesmanName">{{$businessInfo['trading-name']}}</h4>
								</div>
							@else
								<div class="col-xs-12 tradesman-name">
									<h4 id="tradesmanName">{{$businessInfo['trading-name']}}</h4>
								</div>
							@endif
						</div>
						<p style="color:#000000" class="bordered-desc">Your honest answers really help other customers</p>
						<form id="rateForm" enctype="multipart/form-data" method="post" action="/create/review">
							{{csrf_field() }}
							<input type="hidden" name="tradesman_id" id="tradesmanID" value="{{$businessInfo['id']}}">
							<input type="hidden" name='postcode' value="{{isset($businessInfo['postcode']) ? $businessInfo['postcode'] : ''}}">
							<div class="rating-stars">
								<p class="rating-label">Communication</p>
								<div class="stars">
									<input type="radio" name="communication" id="group-1-0" value="5" /><label for="group-1-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="communication" id="group-1-1" value="4" /><label for="group-1-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="communication" id="group-1-2" value="3" /><label for="group-1-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="communication" id="group-1-3" value="2" /><label for="group-1-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="communication" id="group-1-4"  value="1" /><label for="group-1-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							<div class="rating-stars">
								<p class="rating-label">Work Quality</p>
								<div class="stars">
									<input type="radio" name="work-quality" id="group-2-0" value="5" /><label for="group-2-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="work-quality" id="group-2-1" value="4" /><label for="group-2-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="work-quality" id="group-2-2" value="3" /><label for="group-2-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="work-quality" id="group-2-3" value="2" /><label for="group-2-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="work-quality" id="group-2-4"  value="1" /><label for="group-2-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							<div class="rating-stars">
								<p class="rating-label">Price</p>
								<div class="stars">
									<input type="radio" name="price" id="group-3-0" value="5" /><label for="group-3-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="price" id="group-3-1" value="4" /><label for="group-3-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="price" id="group-3-2" value="3" /><label for="group-3-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="price" id="group-3-3" value="2" /><label for="group-3-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="price" id="group-3-4"  value="1" /><label for="group-3-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							<div class="rating-stars">
								<p class="rating-label">Punctuality</p>
								<div class="stars">
									<input type="radio" name="punctuality" id="group-4-0" value="5" /><label for="group-4-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="punctuality" id="group-4-1" value="4" /><label for="group-4-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="punctuality" id="group-4-2" value="3" /><label for="group-4-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="punctuality" id="group-4-3" value="2" /><label for="group-4-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="punctuality" id="group-4-4"  value="1" /><label for="group-4-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							<div class="rating-stars no-border">
								<p class="rating-label">Attitude</p>
								<div class="stars">
									<input type="radio" name="attitude" id="group-5-0" value="5" /><label for="group-5-0" data-toggle="tooltip" data-placement="top" title="" data-original-title="Excellent"></label>
									<input type="radio" name="attitude" id="group-5-1" value="4" /><label for="group-5-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Satisfactory"></label>
									<input type="radio" name="attitude" id="group-5-2" value="3" /><label for="group-5-2" data-toggle="tooltip" data-placement="top" title="" data-original-title="Satisfactory"></label>
									<input type="radio" name="attitude" id="group-5-3" value="2" /><label for="group-5-3" data-toggle="tooltip" data-placement="top" title="" data-original-title="Poor"></label>
									<input type="radio" name="attitude" id="group-5-4"  value="1" /><label for="group-5-4" data-toggle="tooltip" data-placement="top" title="" data-original-title="Very Poor"></label>
								</div>
							</div>
							</br></br></br>
							<input type="text" name="review-title" placeholder="Enter Review Title" required>
							<textarea placeholder="Write your review.." name="review-text" class="no-top" required></textarea>
							<div class="review-tips">
								<p class="tooltip-info" data-toggle="tooltip" data-placement="right" title="" data-original-title="Tips for writing a great review </br> </br> <b>DO</b> </br> - Describe your overall experience</br> - Tell us if you would recommended the business to others</br>-Talk about the strengths and weaknesses of the experience </br></br> <b>DON'T</b></br>-Lie. Be as honest as possible</br>-Use bad language or personal insults</br>-Be racist, sexist or vulgar" data-html="true">Tips for writing a good review</p>
							 </br></br>
							</div>
							@if(count($errors) > 0)
								{{dump($errors)}}
							@endif
							<button type="submit" class="btn hs-primary">Submit Review</button>
						</form>
					</div>
				</div>
			</div>
		</div>