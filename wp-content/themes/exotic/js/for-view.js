$(function(){

  //  modals
  $('.js-modal').magnificPopup({
    type: 'inline'
  });

  $('.one-img').magnificPopup({
    type: 'image'
  });

  $('.show-gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: 'Loading image #%curr%...',
    mainClass: 'mfp-img-mobile',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0,1]
    },
    image: {
      tError: '<a href="%url%">Изображение #%curr%</a> не может быть отображено.'
    }
  });

  $('.js-link').click( function(){
    var scroll_el = $(this).attr('href');
    if ($(scroll_el).length != 0) {
      $('html, body').animate({ scrollTop: $(scroll_el).offset().top }, 600);
    }
    return false;
  });

});

