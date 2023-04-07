$(function() {

  var header = $('.header')
  header_offset = header.offset();
  header_height = header.height();
  $(window).scroll(function() {
    if ($(window).scrollTop() > 0) {
      header.addClass('scroll');
      $('#nav-toggle').addClass('menuwh');
      $('.breadcrumb').addClass('hidden');
    } else {
      header.removeClass('scroll');
      $('#nav-toggle').removeClass('menuwh');
      $('.breadcrumb').removeClass('hidden');
    }
  });


  //---------------------------------
  // Smooth Scrolling
  //---------------------------------

  $('a[href^="#"]').click(function() {

    var the_id = $(this).attr("href");

    $('html, body').animate({
      scrollTop: $(the_id).offset().top - 50
    }, 'slow');

    return false;
  });



  $('#nav-toggle').on('touch click',function() {
    if($('body').hasClass('open')) {
      $('body').removeClass('open');
    } else {
      $('body').addClass('open');
    }
  });

});
// (function($) {
//     $(function () {
//       $('#nav-toggle').on('click', function() {
//         $('body').toggleClass('open');
//       });
//     });
// })(jQuery);
