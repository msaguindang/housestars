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