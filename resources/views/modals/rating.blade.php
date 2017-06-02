<!-- RATE A TRADE OR SERVICES SIGN IN 2-->
<!-- <div class="modal fade" id="rating" tabindex="-1" role="dialog" aria-labelledby="rating-area">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<h4>Rate a Trade or Service</h4>
				<p class="sub-heading">Verify that you are a real customer by signing in below</p>
				<div class="info-bar" data-toggle="tooltip" data-placement="left" title="This step proves that you are a genuine customer and not a robot. This ensures the ratings data on the site is not false, so you get real information when looking for your next trade or service.">What does this mean?</div>
					<a href="/verify/facebook/agency/{{$data['agency-id']}}" class="btn social-button hs-facebook"><span class="icon icon-fb-white">Sign in Using Facebook </span> </a>
					</br><p>OR</p>
					<a href="/verify/google/agency/{{$data['agency-id']}}" class="btn social-button hs-google-plus"><span class="icon icon-g-white">Sign in Using GOOGLE PLUS</span> </a>
			</div>
		</div>
	</div>
</div> -->

<div class="modal fade" id="rating" tabindex="-1" role="dialog" aria-labelledby="rating-area">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<h4>RATE A TRADE or SERVICE</h4>
				<p class="sub-heading">
					Verify you are a real customer by authenticating with an email address or facebook
				</p>
				<div class="info-bar" data-toggle="tooltip" data-placement="left" title="This step proves that you are a genuine customer and not a robot. This ensures the ratings data on the site is not false, so you get real information when looking for your next trade or service.">What does this mean?</div>
					<form action="{{ route('verify_to_rate') }}" method="POST" id='verify_to_rate'>
						{{csrf_field() }}
						<div id="error"></div>
						<div id="login-error"></div>
						<input type="hidden" name='role' value="{{$data['role']}}" />
						<input type="hidden" name='business' value="{{$data['id']}}" />
						<input type="email" name="email" placeholder="Email" required style="width: 100%;padding: 15px;border: 1px solid #e0e0e0;">
						<button class="btn hs-primary" data-text="Proceed"> Proceed </button>
					</form>
					</br><p>OR</p>
					<?php  $fbUrl = route('verify.provider.review.business', ['provider' => 'facebook', 'role' => $data['role'], 'businessId' => $data['id']]); ?>
					<a href="{{ $fbUrl }}" data-href="{{ $fbUrl }}" class="btn social-button hs-facebook"><span class="icon icon-fb-white">Proceed Using Facebook </span> </a>
			</div>
		</div>
	</div>
</div>

@section('scripts')
	@parent
	<script>
	$('#verify_to_rate').on('submit', function (event) {
        event.preventDefault();
        $sendBtn = $(this).find('button');
        $fbBtn = $(this).siblings('a');

        $.ajax({
          type: $(this).attr('method'),
          url: $(this).attr('action'),
          data: $(this).serialize(),
          dataType: "json",
          beforeSend: function() {
            $sendBtn.prop('disabled', true);
            $fbBtn.attr('href', "javascript:void(0);");
            $sendBtn.html("Verifying <span class='fa fa-spin fa-spinner' />");
          },
          success: function(data) {
            $sendBtn.prop('disabled', false);
            $sendBtn.html($sendBtn.data('text'));
            $fbBtn.attr('href', $fbBtn.data('href'));
            if(data.error && data.error.length != 0) {
              console.log(data.error);
            } else if(data.url) {
              window.location.href = data.url;
            } else if(data.verifying) {
              $("#verify-customer").modal('show');
              $('#rating').modal('hide');
            }
          }
        });
    });
	</script>
@endsection