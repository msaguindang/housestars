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
      var suburb = $('#suburb').val();
      //
      $.ajax({
        url: 'search/category',
        data: data,
        type: 'POST',
        success: function(data){
          if(typeof data['msg'] != 'undefined'){
            $('.message').empty();
            $('#trades').empty();
            $('.message').append('<p><b class="suburb">'+ data['msg']+'</b></p>');
          } else {
            $('.message').empty();
            $('#trades').empty();

            $('.message').append('<p>Available Trades And Services for location <b class="suburb">'+ suburb +'</b></p>');
            for(i = 0; i < data.length; i++){
               
               $('#trades').append('<div class="col-xs-4 item"><a href="/search/category/'+ data[i] +'"><span class="icon icon-hammer"></span>'+ data[i] +'<span class="icon icon-arrow-right-blue"></span></a></div>');
            }

            $('#trades').append('<div class="col-xs-12"><div class="col-xs-4 no-padding-left"><button class="btn hs-primary medium" data-toggle="modal" data-target="#submitCategory"><span class="icon icon-arrow-right"></span>The category I am looking for is not here</button></div></div>');
          }
          
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

