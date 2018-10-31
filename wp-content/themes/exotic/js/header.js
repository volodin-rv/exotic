$(function(){
  /* replace menu and profile */
  function adaptiveNav(){
    if($(document).width() < 1024 || $(window).width() < 1024){
      $("nav").prependTo($("header"));
    }
    else{
      $("nav").insertAfter($("header"));
      $("nav").show();
    }
  }
  $(window).on('resize', adaptiveNav);
  adaptiveNav();

  /* show-hide menu */
  $(".nav-icon").click(function(){
    $("header nav").slideToggle();
    $(this).toggleClass("active");
  });

  /* scroll to top */
  $(".to-top").click(function(event) {
    event.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, 800, "swing");
    return false;
  });
  $(window).scroll(function(){
    if ($(document).scrollTop() > 200){
      $(".to-top").addClass("show");
    }
    else{
      $(".to-top").removeClass("show");
    }
  });

});

