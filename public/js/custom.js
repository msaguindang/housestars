
(function(){

var animation = {
      init: function(){
          this.cacheDom();
          this.bindEvents();
      },
      cacheDom: function(){
          this.$scroll =  $(window);
          this.$rate =  $('#rate');
          this.$modalRegister = $('#open');
          this.$modalPassword = $('#openForgotPasswordModal');
          this.$active = $('.active');
      },
      bindEvents: function(){
        this.$scroll.scroll('on', this.animateOnScroll.bind(this));
        this.$rate.on('click', this.animateOnClick.bind(this));
        this.$modalRegister.on('click', this.hideSignup.bind(this));
        this.$modalPassword.on('click', this.hideLogin.bind(this));
      },
      animateOnScroll: function(){
          this.addAnimation('.home .stepOne', false, 'fadeInRight', 50);
          this.addAnimation('.home .stepTwo', false, 'fadeInLeft', 500);
          this.addAnimation('.home .stepThree', false, 'fadeInRight', 1000);
          this.addAnimation('.home .stepFour', false, 'fadeInLeft', 1200);
          this.addAnimation('#how-we-help .item', false, 'fadeIn', 2100);
          //console.log(this.$scroll.scrollTop());
          this.stickyNav('.sticky', 'slideInDown', 130);
      },
      animateOnClick: function(){
          this.addAnimation('#rate img', true, 'bounceIn', null);
      },
      addAnimation: function(className, isElement, effect, height){
        if(isElement == false){
          if (this.$scroll.scrollTop()>height)
          {
              $(className).addClass(effect);
          }
        } else if(isElement == true){

          $(className).addClass(effect);

          setTimeout(function () {
              $(className).removeClass(effect);
          }, 500);

        }

      },
      stickyNav: function(className, effect, height){
         if (this.$scroll.scrollTop()>height)
          {
              $(className).addClass(effect).removeClass('hide');

          } else {
              $(className).removeClass(effect).addClass('hide');
          }
      },
      hideSignup: function(){
          $('#signup').modal('hide');
      },
      hideLogin: function(){
          $('#login').modal('hide');
      }
};

animation.init();

})()

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

$("#property-type .selected a").click(function() {
    $("#property-type .options ul").toggle();
});

//SELECT OPTIONS AND HIDE OPTION AFTER SELECTION
$("#property-type .options ul li a").click(function() {
    var text = $(this).html();
    $("#property-type .selected a span").html(text);
    $("#property-type .options ul").hide();
});


//HIDE OPTIONS IF CLICKED ANYWHERE ELSE ON PAGE
$(document).bind('click', function(e) {
    var $clicked = $(e.target);
    if (! $clicked.parents().hasClass("drop-down"))
        $("#property-type .options ul").hide();
});


$("#close").click(function() {
    $('#error').addClass('hide');
});

var _URL = window.URL || window.webkitURL;

$("#CoverUpload").change(function(e) {
    var file, img;

console.log('YES');

    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function() {

            if(this.width < 1328){
              $('#thankYou .modal-body').html('<p>Image width is too small, please resize and upload it again for better quality.</p>');
              $('#thankYou').modal('show');
            }
        };

        img.onerror = function() {
            alert( "not a valid file: " + file.type);
        };
        img.src = _URL.createObjectURL(file);


    }

});

$("#profileUpload").change(function(e) {
    var file, img;

console.log('YES');

    if ((file = this.files[0])) {
        img = new Image();
        img.onload = function() {

            if(this.width < 177){
              $('#thankYou .modal-body').html('<p>Image width is too small, please resize and upload it again for better quality.</p>');
              $('#thankYou').modal('show');
            }
        };

        img.onerror = function() {
            alert( "not a valid file: " + file.type);
        };
        img.src = _URL.createObjectURL(file);


    }

});
