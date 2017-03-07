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
          var exists = data['item'];

          $('.message').append('<p>Available Trades And Services for location <b class="suburb">'+ suburb +'</b></p>');
            
          for(i = 0; i < data['cat'].length; i++){               
            if(jQuery.inArray(data['cat'][i]['category'], exists) !== -1){
              $('#trades').append('<div class="col-xs-4 item"><a href="/search/category/'+ data['cat'][i]['category'] +'/'+ suburb + '"><span class="icon icon-hammer"></span>'+ data['cat'][i]['category'] +'<span class="icon icon-arrow-right-blue"></span></a></div>');
            } else {
              $('#trades').append('<div class="col-xs-4 item"><a href="#" data-toggle="modal" data-target="#noTradesman"><span class="icon icon-hammer"></span>'+ data['cat'][i]['category'] +'<span class="icon icon-arrow-right-blue"></span></a></div>');
            } 
          }

          $('#trades').append('<div class="col-xs-12"><div class="col-xs-4 no-padding-left"><button class="btn hs-primary medium" data-toggle="modal" data-target="#submitCategory"><span class="icon icon-arrow-right"></span>The category I am looking for is not here</button></div></div>');
          
          
        }

      });

  });

  $(document).on('click', '#helpful' ,function(e){
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
          $('#noTradesman').modal('hide');
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
          $('#thankYouTrades').modal('show');
        }

      });

  });

$(document).on('submit', '#reviewForm' ,function(e){
      e.preventDefault();
      var data = $(this).serialize();

      $.ajax({
      url: 'add-review',
      data: data,
      type: 'POST',
      processData: false,
      success: function(data){
        $('#agencyRate').modal('hide');
        location.reload();
      }
    });
  });

  $(document).on('click', '#switch' ,function(e){
      
      var stat = $('input[name=switch]').val();

      if(stat == '0'){
        $('.nav-panel').css('display', 'none');
        $('.profile-details').css('display', 'block');
        $('input[name=switch]').val('1')
        $('input[name=switch]').attr('checked', true);
      } else {
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
          $('#orderBusinessCard').html('<p>We successfully send your details for your business card. Our team will contact you shortly for details.</p>');
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
          $('#contactUS').html('<p>We successfully send your concern. Our team will connect to you shortly.</p>');
        }
      });
  });

$(document).on('submit', '#savingsCalc' ,function(e){
      e.preventDefault();
      var data = $(this).serialize();
      $("#loading").fadeIn("slow");
      $.ajax({
        url: '/savings-calculator',
        data: data,
        type: 'POST',
        processData: false,
        success: function(data){
          $("#loading").fadeOut("slow");
          $('#savingsSuccess').modal('show');
        }
      });
  });


