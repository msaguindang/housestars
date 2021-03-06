$( "#signup-form" ).submit(function( e ) {

	$.ajax({
		type: 'post',
		url: '/register',
		data: $(this).serialize(),
		dataType: 'json',
		error: function(response){
		//var errors = response;
		console.log(response);
		// Render the errors with js ...
		}
	});
});


$(document).on('submit', '#forgotPass' ,function(e){
	e.preventDefault();
	var data = $(this).serialize();
	$('#forgotPassword #msg').empty();
	$('#forgotPassword #msg').append('<span>Please wait, we are validating your request...</span>');
		$('#forgotPass .btn').attr("disabled",true);
	$.ajax({
	url: '/retrieve-password',
	data: data,
	type: 'POST',
	processData: false,
	success: function(data){

		console.log(data);


		if(typeof data['err'] === 'undefined'){
		var error = '<span class="success">'+ data['msg'] +'</span>';

		} else {
		var error = '<span class="error">'+ data['err'] +'</span>';
		}

        $('#forgotPassword #msg').empty();
        $('#forgotPassword #msg').append(error);
        $('#forgotPass .btn').attr("disabled",false);
      }
    });
  });

  $(document).on('submit', '#categorySearch' ,function(e){
      e.preventDefault();

      var data = $(this).serialize();
      $('.message').empty();
      $('#trades').empty();
      //
      $.ajax({
        url: '/search/category',
        data: data,
        type: 'POST',
        success: function(data){
          var suburb = $('#suburb').val();
          var exists = [];

					for(i = 0; i < data['item'].length; i++) {
            if (Array.isArray(data['item'][i]['trade'])) {
              $.each(data['item'][i]['trade'], function (index, item) {
                exists.push(item);
              });
            } else {
              exists.push(data['item'][i]['trade']);
            }
					}

          $('.message').append('<p>Available Trades And Services for location <b class="suburb">' + data.suburb_name + ' (' + data.suburb_id + ') </b></p>');
          for(i = 0; i < data['cat'].length; i++) {
            if(jQuery.inArray(data['cat'][i]['category'], exists) !== -1) {
              $category = (data['cat'][i]['category']).replace('/', '_');
              $('#trades').append('<div class="col-xs-4 item"><a href="/listing/'+ $category +'/'+ suburb + '"><span class="icon icon-hammer"></span>'+ data['cat'][i]['category'] +'<span class="icon icon-arrow-right-blue"></span></a></div>');
            } else {
              $('#trades').append('<div class="col-xs-4 item"><a href="#" data-toggle="modal" data-target="#noTradesmenCategory"><span class="icon icon-hammer"></span>'+ data['cat'][i]['category'] +'<span class="icon icon-arrow-right-blue"></span></a></div>');
            }
          }
          $('#trades').append('<div class="col-xs-12"><div class="col-xs-4 no-padding-left"><button class="btn hs-primary medium" data-toggle="modal" data-target="#submitCategory"><span class="icon icon-arrow-right"></span> <span>The category i am looking for is not here </span> </button></div><div class="col-xs-4 no-padding-left"><button class="btn hs-primary medium" data-toggle="modal" data-target="#noTradesmen"><span class="icon icon-arrow-right"></span>Recommend A Trade or Service</button></div></div>');
        }
      });
  });

  $(document).on('click', '#helpful' ,function(e) {
      e.preventDefault();
      var countClass = '#count-' + $(this).data('id');
      $(this).attr("disabled", true);
      $.ajax({
        url: '/helpful',
        data: {_token: $(this).data('token'), id: $(this).data('id')},
        type: 'POST',
        success: function(data){
          $(countClass).text('(' + data['count'] + ')');
          console.log(data);
        }

      });

  });

  $(document).on('submit', '#suggestTradesman' ,function(e){
      e.preventDefault();
      var data = $(this).serialize();

      $.ajax({
        url: '/send/tradesman',
        data: data,
        type: 'POST',
        success: function(data){
          $('#noTradesmen').modal('hide');
          $('#noTradesmenCategory').modal('hide');
          $('#thankYouTrades').modal('show');
        }

      });

  });

	$(document).on('submit', '#suggestAgency' ,function(e){
      e.preventDefault();
      var data = $(this).serialize();

      $.ajax({
        url: '/send/agency',
        data: data,
        type: 'POST',
        success: function(data){
          $('#noAgency').modal('hide');
          $('#thankYouTrades').modal('show');
        }

      });

  });

    $(document).on('submit', '#submitCat' ,function(e){
      e.preventDefault();
      var data = $(this).serialize();

      $.ajax({
        url: '/send/category',
        data: data,
        type: 'POST',
        success: function(data){
          $('#submitCategory').modal('hide');
          $('#thankYouCategory').modal('show');
        }

      });

  });


// submit rateInfo modal
$("#rateInfo").submit(function() {
    var data = $("#rateInfo").serialize();
    console.log(data); // it's only for test
});

// on submit rate form
$(document).on('submit', '#rateForm' ,function(e){
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
    url: '/create/review',
    data: data,
    type: 'POST',
    processData: false,
    success: function(data){
      $('#thankYou .modal-body').html('<h1>Thanks For Your Review!</h1><p>We appreciate you for leaving a review! We value your opinion and use your feedback to help promote trades or services.</p>');
      $('#rateModal').modal('hide');
      $('#thankYou').modal('show');
    },
    error: function() {
      alert('Blank responses are not allowed');
    }
  });
});

$(document).on('click', '#switch' ,function(e){

    var stat = $('input[name=switch]').val();

    if(stat == '0'){
      $('.nav-panel').css('display', 'none');
      $('.profile-details').css('display', 'block');
      // $('div.gallery').show();
      $('input[name=switch]').val('1')
      $('input[name=switch]').attr('checked', true);
    } else {
      // $('div.gallery').hide();
      $('.nav-panel').css('display', 'block');
      $('.profile-details').css('display', 'none');
      $('input[name=switch]').val('0')
      $('input[name=switch]').attr('checked', false);
    }
});

$(document).on('submit', '#orderBusinessCard' ,function(e){
      e.preventDefault();
      var data = $(this).serialize();

      $.ajax({
        url: '/order-business-card',
        data: data,
        type: 'POST',
        processData: false,
        success: function(data){
          $('.sub-heading').empty();
          $('#orderBC h4').empty();
          $('#orderBusinessCard').html('<h4>REVIEW CARDS ORDERED</h4></br><p>Your order has been placed. Our team will contact you shortly for details.</p>');
        }
      });
  });

$(document).on('submit', '#contactUS' ,function(e){
      e.preventDefault();
      var data = $(this).serialize();

      $.ajax({
        url: '/contact-us',
        data: data,
        type: 'POST',
        processData: false,
        success: function(data){
          $('.sub-heading').empty();
          $('#contactUS').html('<p>Thanks for your contact. Our staff will reply to you shortly.</p>');
        }
      });
  });

$(document).on('submit', '#savingsCalc' ,function(e){
      e.preventDefault();
      var data = $(this).serialize();
      $("#loading").fadeIn("slow");
      $.ajax({
        url: '/create/potential-customer',
        data: data,
        type: 'POST',
        processData: false,
        success: function(data){
					console.log(data);
					$('#error').empty();
					$('#select-state')[0].selectize.clear();
					$('#select-type')[0].selectize.clear();
					$('.dropdown-toggle').empty();
					$("#savingsCalc")[0].reset();
					$("#loading").fadeOut("slow");
					$('#savingsSuccess').modal('show');
        },
				error: function(data){
					$("#loading").fadeOut("slow");
					$errors = data.responseJSON;
					$('#select-state')[0].selectize.clear();
					$('#select-type')[0].selectize.clear();
					$("#savingsCalc")[0].reset();
					$('.dropdown-toggle').empty();
					$('#error').empty();
					$('#error').append('Please complete the form, you need to fill in all fields.');
				}
      });
  });

$(document).on('submit', '#referral' ,function(e){
  e.preventDefault();
  var data = $(this).serialize();
	$('#referral .error').empty();
  $.ajax({
    url: '/referral',
    data: data,
    type: 'POST',
    success: function(data){
      $('#referral .error').append(data);
    }
  });
});

$(document).on('submit', '#signupform' ,function(e){
  e.preventDefault();
  var data = $(this).serialize();
	$('#errors-signup').empty();
  $.ajax({
    url: '/register',
    data: data,
    type: 'POST',
    success: function(data){
			window.location.replace(data['redirect']);
    },
		error: function(data){
			var errors = data.responseJSON;
			var x = 0;
			$.each( errors, function( key, value ) {
				if(x == 0){
					$('#errors-signup').append('<span>'+ value[0] + '</span></br></br>');
				}
				x = x + 1;
			});

		}
  });
});

$(document).on('submit', '#loginform' ,function(e){
  e.preventDefault();
  var data = $(this).serialize();
	$('#login-error').empty();
  $.ajax({
    url: '/login',
    data: data,
    type: 'POST',
    success: function(data){
			window.location.replace(data['redirect']);
			console.log(data['redirect']);
    },
		error: function(data){
			var errors = data.responseJSON;
			var x = 0;
			$.each( errors, function( key, value ) {
				if(x == 0){
					$('#login-error').append('<span>'+ value[0] + '</span></br></br>');
				}
				x = x + 1;
			});

		}
  });
});

$(document).on('click', '.addreview' ,function(e) {

	var id = $(this).data('id');

	$.ajax({
		url: '/review-vendor',
		data: {_token: $(this).data('token'), id: $(this).data('id')},
		type: 'POST',
    beforeSend: function() {
      $('#tradesmanPic, #tradesmanName').remove();
    },success: function(data) {
			var url = window.location.origin + '/',
					photo = data['isPhotoUrl'] ? data['photo'] : url + data['photo'];

			$("#reviewForm").trigger("reset");
			$('.tradesman-profile').append('<img src="'+ photo +'" alt="'+ data['trading-name'] +'" id="tradesmanPic">');
			$('.tradesman-name').append('<h4 id="tradesmanName">'+ data['trading-name'] +'</h4>');
			$('#tradesmanID').val(id);
			$('#rateTradesman').modal('show');
		}
	});
});

$(document).on('submit', '#reviewForm' ,function(e){
		e.preventDefault();
		var data = $(this).serialize();

		$.ajax({
		url: '/add-review',
		data: data,
		type: 'POST',
		processData: false,
		success: function(data){
			$('#rateTradesman').modal('hide');
			location.reload();
		}
	});
});
