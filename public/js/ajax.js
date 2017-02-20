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