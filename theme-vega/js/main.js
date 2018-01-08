/* INITIALISATION */
$(document).ready(function(){
    $('.slick-slider').slick({
      dots: true,
      infinite: false,
      speed: 700,
      arrows: false,
      slidesToShow: 1,
      slidesToScroll: 1,
  });
    $('.gallery-slider').slick({
     dots: false,
      infinite: false,
      speed: 700,
      arrows: true,
      slidesToShow: 4,
      slidesToScroll: 2,
      responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
      }
    },
    {
      breakpoint: 900,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 700,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }

  ]
  });



    /* ANIMATION */
    /* scroll-site */
    var h = $(window).height();
    $(window).scroll(function(){

       if($(".main").hasClass("home")){
          if ( ($(this).scrollTop()+h) >= $("section.home-gallery").offset().top) {
              $("section.home-gallery").addClass('animation');
          }
          if ( ($(this).scrollTop()+h) >= $("section.news").offset().top) {
              $("section.news").addClass('animation');
          }
          if ( ($(this).scrollTop()+h) >= $("section.sales").offset().top) {
              $("section.sales").addClass('animation');
          }
        }
         if ($(this).scrollTop() > h) {
            $('.wrapper').addClass("wrapper-scroll");
        }
        else{
             $('.wrapper').removeClass("wrapper-scroll");
        }
    });
    /* scroll-link */
    $('a[href^="#"]').click(function () {
        var target = $(this).attr('href');
        $('html, body').animate({scrollTop: $(target).offset().top}, 800);
        return false;
    });
    $("a").click(function () {
        var selected = $(this).attr('href');
        $.scrollTo(selected, 500);
        return false;
    });    
    /* ACTIONS */
    /* mob-menu */
    jQuery("#header").find(".navigation-opener").click(function(){
        jQuery(this).toggleClass("opener");
        jQuery("#header").find("nav").toggleClass("opener");
        jQuery("#header").find(".contact ul").removeClass("opener");
    });
    jQuery("#header").find(".contact-opener").click(function(){
        jQuery("#header").find(".contact ul").toggleClass("opener");
        jQuery("#header").find("nav").removeClass("opener");
        jQuery("#header").find(".navigation-opener").removeClass("opener");
    });
     jQuery(".slick-slider").mousedown(function(){
         jQuery(this).addClass("touch");
      });
     jQuery(".slick-slider").mouseup(function(){
         jQuery(this).removeClass("touch");
     });
     jQuery(".faq-list li>strong").click(function(){
         jQuery(this).parent("li").siblings("li").find(">strong").removeClass("active");
          jQuery(this).parent("li").find(">strong").toggleClass("active");
     });
     jQuery(".reviews-list li").click(function(){
         jQuery(this).siblings("li").find(".reviews-text-all").removeClass("active");
          jQuery(this).find(".reviews-text-all").toggleClass("active");
     });





});








