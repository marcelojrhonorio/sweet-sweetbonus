<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/ketchup.all.js"></script>
<script src="assets/js/contact_form.js"></script>
<script src="assets/js/exitpopup.js"></script>
<script src="assets/js/library/sweetalert2.all.js"></script>
<script src="assets/js/library/toastr/toastr.min.js"></script>
<script src="assets/js/library/modernizr-custom.js"></script>
<script src="assets/js/library/detectmobilebrowser.js"></script>
<script src="assets/js/laroute.js?{{time()}}"></script>
<script src="assets/js/app/sweet.js?{{time()}}"></script>
<script src="assets/js/app/validate.js"></script>
<script src="assets/js/library/remodal.js"></script>
<script src="assets/js/library/waitingDialog.js"></script>
{{-- FORM VALIDATION --}}
<script src="assets/js/jquery.maskedinput/jquery.maskedinput.min.js"></script>
<script src="assets/js/jquery.mask/jquery.mask.min.js"></script>
<script src="assets/js/jquery.maskmoney/jquery.maskMoney.min.js"></script>
{{-- NIFTY MODALS --}}
<script src="assets/js/exit-intent/stick-to-me.js"></script>

<script src="assets/js/script2.js?{{time()}}"></script>

<script src="assets/js/fitvids.js"></script>

<script src="assets/js/app/create.js?{{time()}}"></script>

<script>
  sweet.common.setTimeOut({{ env('AJAX_TIMEOUT') }});
  sweet.common.url = '{{ env('APP_URL') }}';

  (function($) {
    'use strict';

    toastr.options = {
      'closeButton': true,
      'debug': false,
      'newestOnTop': false,
      'progressBar': true,
      'positionClass': 'toast-top-center',
      'preventDuplicates': false,
      'onclick': null,
      'showDuration': 400,
      'hideDuration': 1000,
      'timeOut': 7000,
      'extendedTimeOut': 1000,
      'showEasing': 'swing',
      'hideEasing': 'linear',
      'showMethod': 'fadeIn',
      'hideMethod': 'fadeOut',
    }

    $('.go-home').click(function(event) {
      event.preventDefault();

      $('html, body').delay(50).animate({
          scrollTop: $('#home').offset().top
      }, 500);
    });
  })(jQuery);
</script>

@yield('script')
