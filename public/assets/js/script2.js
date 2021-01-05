(function($) {
  $(function() {
    // Click scroll
    $('.scrollto, .go_to_div').on('click', function(event) {
      event.preventDefault();

      var $anchor = $(this);

      $('html, body').stop().animate({
          scrollTop: $($anchor.attr('href')).offset().top
      }, 1500);
    });

    // CTA UP
    var cta_up = $('#cta-up');

    if (cta_up.length) {
      var cta_up_container = $('#cta-up-container').offset().top;
      var x = cta_up.offset().top;

      if (x > cta_up_container) {
        cta_up.fadeIn();
      } else {
        cta_up.fadeOut();
      }

      $(document).on('scroll', function() {
        var y = $(this).scrollTop();

        if (y > cta_up_container) {
          cta_up.fadeIn();
        } else {
          cta_up.fadeOut();
        }
      });
    }

    // Modal login
    const $modal         = $('[data-sweet-modal]');
    const $btnLogin      = $('[data-trigger-login]');
    const $inputEmail    = $('[data-login-email]');
    const $inputPassword = $('[data-login-password]');

    $btnLogin.on('click', function(event) {
      event.preventDefault();
      $modal.modal('show');
    });
  });
})(jQuery);
