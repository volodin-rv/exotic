$(document).ready(function(){
  if ($('.cause')) {
      var causeLeftTop = $(".cause-left").offset();
      var causeRightTop = $(".cause-right").offset();
      var causeHeight = $(".cause").height();
      var windowHeight = $(window).height()/2;

      if ($(window).width() > 1024){
          $(window).scroll(function() {
              if ($(document).scrollTop() > (causeLeftTop.top - windowHeight - causeHeight)){
                  $(".cause-left").addClass("active");
              }
              if ($(document).scrollTop() > (causeRightTop.top - windowHeight - causeHeight)){
                  $(".cause-right").addClass("active");
              }
          });
      }
  }
});

