



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
          this.$active = $('.active');
      },
      bindEvents: function(){
        this.$scroll.scroll('on', this.animateOnScroll.bind(this));
        this.$rate.on('click', this.animateOnClick.bind(this));
        this.$modalRegister.on('click', this.hide.bind(this));
      },
      animateOnScroll: function(){
          this.addAnimation('.stepOne', false, 'fadeInRight', 50);
          this.addAnimation('.stepTwo', false, 'fadeInLeft', 500);
          this.addAnimation('.stepThree', false, 'fadeInRight', 1000);
          this.addAnimation('.stepFour', false, 'fadeInLeft', 1200);
          this.addAnimation('#how-we-help .item', false, 'fadeIn', 2100);
          //console.log(this.$scroll.scrollTop());
          this.stickyNav('#header', 'slideInDown', 130);
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
      hide: function(){
          $('#signup').modal('hide');
      }
};

animation.init();

})()

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})