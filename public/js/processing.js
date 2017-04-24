  $(document).on("change", '#receipt', function(){
      var filename = $('#receipt')[0].files[0];
      $('.upload-button span.label').addClass('hidden');
      $( ".upload-button" ).append( '<span class="label">' + filename.name + '</span>' );
    });


    $(document).on("change", '#tradesReceipt', function(){

      var url = window.location.origin;
      var transaction_id = $(this).parent().data('id');
      var id_label = '#picture'+ transaction_id + ' .ur-text';
      var id_receipt = '#picture'+ transaction_id + ' .upload-receipt';
      var checkbox = '#p' + transaction_id;

      $(id_label).remove();
      $(id_receipt).append( '<span class="ur-text"><img src="'+ url +'/assets/uploading.svg" alt="">Upload</span>' );
      $(id_receipt).css({ 'padding': "6.5px 8px" });

      var formData =  new FormData($(this).parent()[0]);

      $.ajax({
          url: '/upload-receipt',
          data: formData,
          type: 'POST',
          cache:false,
          contentType: false,
          processData: false,
          success: function(data){
            var url = window.location.origin;
            var id_picture = '#picture'+ data['id'];
            $(id_receipt).addClass( 'hidden' );
            $(id_picture).append('<img src="'+ url +'/'+data['url']+'">');
            $(checkbox).prop('checked', true);
            location.reload();
          }
      });
    });

      $(document).on("change", '#contract', function(){

      var url = window.location.origin;
      var user_id = $(this).parent().data('id');
      var id_label = '#contract'+ user_id + ' .ur-text';
      var id_receipt = '#contract'+ user_id + ' .upload-receipt';
      var checkbox = '#p' + user_id;

      $(id_label).remove();
      $(id_receipt).append( '<span class="ur-text"><img src="'+ url +'/assets/uploading.svg" alt="">Upload</span>' );
      $(id_receipt).css({ 'padding': "6.5px 8px" });

      var formData =  new FormData($(this).parent()[0]);

      $.ajax({
          url: '/upload-contract',
          data: formData,
          type: 'POST',
          cache:false,
          contentType: false,
          processData: false,
          success: function(data){
            location.reload();
          }
      });
    });

    $(document).on('submit', '#transaction' ,function(e){
      var formData =  new FormData(this);

      e.preventDefault();

       $.ajax({
          url: '/process-trades',
          data: formData,
          type: 'POST',
          cache:false,
          contentType: false,
          processData: false,
          success: function(data){
            var url = window.location.origin;
            var token = $("input[name=_token]").val();
            var trades_id =  data['id'];
            var tradesman_id = data['tid'];

            $("#transaction").trigger("reset");
            $('#processTrades').modal('hide');
            $('.upload-button span.label').remove();
            $('#transactionsTotal .total-amount').remove();
            $('#transactionsTotal .total-label').append('<span class="total-amount" data-total="'+ data['total']+'">$'+ data['total'] +'</span>');
            $('#commission .total-amount').remove();
            $('#commission').append('<span class="total-amount" data-total="'+ data['total']+'">$'+ data['total'] +'</span>');
            $( ".upload-button" ).append( '<span class="label">Click to add Receipt</span>' );

            if(data['receipt']){
              $('.transactions').append('<div class="entry"><ul><li><div class="label"><h4>'+ data['tradesman'] +'</h4><button class="remove-transaction" data-token="'+ token +'" data-id="'+ trades_id +'">REMOVE TRANSACTION</button></div><div class="value"><div class="action"><input type="checkbox" id="r'+trades_id+'" name="cc" disabled/><label for="r'+trades_id+'"><span></span></label></div><button class="add-review" data-id="'+ tradesman_id +'" data-token="'+ token +'" id="reviewBtn'+ tradesman_id +'"> Rate & Review </button></div></li><li><div class="label"><label>Picture of receipt</label></div><div class="value"><div class="action"><input type="checkbox" id="p'+trades_id+'" name="cc" checked disabled/><label for="p'+trades_id+'"><span></span></label></div><div class="picture"><img src="'+ url + '/' + data['receipt']+'" alt=""></div></div></li><li><div class="label"><label>Amount Spent</label></div><div class="value"><div class="action"><input type="checkbox" id="a'+trades_id+'" name="cc" checked disabled /><label for="a'+trades_id+'"><span></span></label></div><div class="amount" id="'+ trades_id +'" data-token="'+token+'"><h4>$<span contenteditable="true">'+ data['amount']+'</span></h4></div></div></li></ul></div>');

            } else {
              $('.transactions').append('<div class="entry"><ul><li><div class="label"><h4>'+ data['tradesman'] +'</h4><button class="remove-transaction" data-token="'+ token +'" data-id="'+ trades_id +'">REMOVE TRANSACTION</button></div><div class="value"><div class="action"><input type="checkbox" id="r'+trades_id+'" name="cc" disabled/><label for="r'+trades_id+'"><span></span></label></div><button class="add-review" data-id="'+ tradesman_id +'" data-token="'+ token +'" id="reviewBtn'+ tradesman_id +'"> Rate & Review </button></div></li><li><div class="label"><label>Picture of receipt</label></div><div class="value"><div class="action"><input type="checkbox" id="p'+trades_id+'" name="cc" disabled/><label for="p'+trades_id+'"><span></span></label></div><div class="picture" id="picture'+trades_id+'"><form id="uploadReceipt" enctype="multipart/form-data" data-id="'+trades_id+'"><input type="hidden" name="_token" value="'+token+'"><input type="file" name="receipt" id="tradesReceipt"><input type="hidden" name="id" value="'+trades_id+'" id="transaction_id"><input type="hidden" name="tid" value="'+tradesman_id+'"><div class="upload-receipt"><span class="ur-text">Add a Receipt</span></div></form></div></div></li><li><div class="label"><label>Amount Spent</label></div><div class="value"><div class="action"><input type="checkbox" id="a'+trades_id+'" name="cc" checked disabled /><label for="a'+trades_id+'"><span></span></label></div><div class="amount" id="'+ trades_id +'" data-token="'+token+'"><h4>$<span contenteditable="true">'+ data['amount']+'</span></h4></div></div></li></ul></div>');
            }

            location.reload();

          }
      });
    });

  $(document).on('blur','span[contenteditable=true]', function(){
      console.log($(this).parent().parent().attr('id'));
     $.ajax({
        url: '/process-spending',
        data: {_token: $(this).parent().parent().data('token'), content: $(this).text(), id: $(this).parent().parent().attr('id')},
        type: 'POST',
        success: function(data){
          $('#transactionsTotal .total-amount').remove();
          $('#transactionsTotal .total-label').append('<span class="total-amount" data-total="'+ data['total']+'">$'+ data['total'] +'</span>');
          $('#commission .total-amount').remove();
          $('#commission').append('<span class="total-amount" data-total="'+ data['total']+'">$'+ data['total'] +'</span>');
        }
    });
  });

  $(document).on('blur','h4[contenteditable=true]', function(){
      console.log($(this).parent().attr('id'));
     $.ajax({
        url: '/update-commission',
        data: {_token: $(this).parent().data('token'), content: $(this).text(), id: $(this).parent().attr('id'), code: $(this).parent().data('code')},
        type: 'POST',
        success: function(data){
          location.reload();
        }
    });
  });

  $(document).on('click', '.remove-transaction' ,function(e){

    $(this).parent().parent().parent().parent().remove();

    $.ajax({
      url: '/delete-transaction',
      data: {_token: $(this).data('token'), id: $(this).data('id')},
      type: 'POST',
      success: function(data){

          $('#transactionsTotal .total-amount').remove();
          $('#transactionsTotal .total-label').append('<span class="total-amount" data-total="'+ data['total']+'">$'+ data['total'] +'</span>');
          location.reload();
      }

    });
  });

  $(document).on('click', '.add-review' ,function(e){

    var tradesmanID = $(this).data('trade');
    var tid = $(this).data('tid');

    $.ajax({
      url: '/review-vendor',
      data: {_token: $(this).data('token'), id: $(this).data('trade')},
      type: 'POST',
      success: function(data) {
        var url = window.location.origin + '/',
            photo = data['isPhotoUrl'] ? data['photo'] : url + data['photo'];

        $("#reviewForm").trigger("reset");
        $('#tradesmanPic').remove();
        $('.tradesman-profile').append('<img src="'+ photo +'" alt="'+ data['name'] +'" id="tradesmanPic">');
        $('#tradesmanName').remove();
        $('.tradesman-name').append('<h4 id="tradesmanName">'+ data['name'] +'</h4>');
        $('#tradesmanID').val(tradesmanID);
        $('#transactionID').val(tid);
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

  $(document).on('click', '.selectAgent' ,function(){
    var id = $(this).data('id');
    var token = $(this).data('token');
    var code = $(this).data('code');
    $.ajax({
      url: '/get-agent-info',
      data: {_token: token, id: id, code: code},
      type: 'POST',
      success: function(data){
        $('#agency').remove();
        $('#addAgent').modal('hide');
        location.reload();
      }
    });
  });

    $(document).on('click', '#c7' ,function(){
      var token = $(this).data('token');
      var code = $(this).data('code');
      var meta = 'amount-sold';

      if ($(this).is(':checked')){
        var isChecked = 'yes';
      } else {
        var isChecked = 'no';
      }

      $.ajax({
          url: '/confirm',
          data: {_token: token, code: code, meta: meta, checked: isChecked},
          type: 'POST',
          success: function(data){
            location.reload();
          }
        });
    });

    $(document).on('click', '#c8' ,function(){
      var token = $(this).data('token');
      var code = $(this).data('code');
      var meta = 'commission-percentage';

      if ($(this).is(':checked')){
        var isChecked = 'yes';
      } else {
        var isChecked = 'no';
      }

      $.ajax({
          url: '/confirm',
          data: {_token: token, code: code, meta: meta, checked: isChecked},
          type: 'POST',
          success: function(data){
            location.reload();
          }
        });
    });

    $(document).on('click', '#c9' ,function(){
      var token = $(this).data('token');
      var code = $(this).data('code');
      var meta = 'commission-charged';

      if ($(this).is(':checked')){
        var isChecked = 'yes';
      } else {
        var isChecked = 'no';
      }

      $.ajax({
          url: '/confirm',
          data: {_token: token, code: code, meta: meta, checked: isChecked},
          type: 'POST',
          success: function(data){
            location.reload();
          }
        });
    });


    $(document).on('submit', '#processForm' ,function(e){
        e.preventDefault();
        var data = $(this).serialize();
        $('#processSuccess').modal('show');

        $.ajax({
          url: '/process-form',
          data: data,
          type: 'POST',
          processData: false,
          success: function(data){

          }
        });
    });

    $(document).on('click', '#processSuccess' ,function(){
      location.reload();
    });

    var timeoutId;
    $(document).on('input propertychange change', '.input-group > input' ,function() {
      var $this = $(this),
          token = $this.data('token'),
          code = $this.data('code'),
          meta = $this.data('meta'),
          meta_amount_name = $this.data('meta-key'),
          meta_amount_value = $this.val(),
          isChecked = 'yes';

      $loader = $('#'+meta_amount_name);

      clearTimeout(timeoutId);
      timeoutId = setTimeout(function() {
        $.ajax({
          url: '/confirm',
          data: {_token: token, code: code, meta: meta, checked: isChecked, meta_amount_name: meta_amount_name, meta_amount_value: meta_amount_value},
          type: 'POST',
          beforeSend: function() {
            $loader.show();
            $loader.siblings('label').hide();
          },success: function(data) {
            $loader.hide();
            $loader.siblings('label').show();
            location.reload();
          },
          error: function(){
            $loader.hide();
            $loader.siblings('label').show();
          }
        });
      }, 1000);
    });
