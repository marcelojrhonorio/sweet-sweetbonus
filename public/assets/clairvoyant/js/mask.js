(function($) {
  /**
   * Clairvoyant form
   */
  const ClairVoyantForm = {
    $form: null,

    start: function() {
      this.$form    = $('[data-form-register]');
      this.$modal   = $('[data-sweet-modal-clairvoyant]');
      this.applyMasks();
      this.bind();
    },

    applyMasks: function() {
      $('[data-mask-birthdate]').mask('00/00/0000');
    },
    
    bind: function() {
      this.$form.on('submit', $.proxy(this.onSubmit, this));
      this.$modal.on('hidden.bs.modal', $.proxy(this.onCloseModal, this));
    },

    onCloseModal: function(){
      this.$form[0].reset();
    },

    getValues: function() {
      var birthdate = this.$form.find('#birthdate').val();
      birthdate = birthdate.split('/')[2] + '/' + birthdate.split('/')[1] + '/' + birthdate.split('/')[0];
      
      // var emailPattern = new RegExp('/^[a-zA-Z\d]‌+([\\-\._]‌?[a-zA-Z\d]‌+)*@[a-zA-Z\d]‌+([\\-\.]‌?[a-zA-Z\d]‌+)*\.[a-zA-Z]{2,}$/');
      // var res = emailPattern.test(this.$form.find('#email_address').val());

      return {
        first_name      : this.$form.find('#first_name').val(),
        email_address   : this.$form.find('#email_address').val(),
        birthdate       : birthdate,
        gender          : $('input[name="gender"]:checked').val(),
        site_origin     : 'sweetbonus.com.br/clairvoyant',
      };
    },

    onSubmit: function(event) {
      event.preventDefault();

      const values = JSON.stringify(this.getValues());

      const headers = {
        'Accept'      : 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      };

      const creating = $.ajax({
        cache      : false,
        type       : 'post',
        dataType   : 'json',
        data       : values,
        headers    : headers,
        url        : '/saveclairvoyant',
        contentType: 'application/json; charset=utf-8',
      });

      creating.done($.proxy(this.onSuccess, this));

      creating.fail($.proxy(this.onFail, this));
    },


    onSuccess: function(data) {
      
      switch (data.status) {
        case 'email_exists':
          
          $('[data-form-register-alert]').removeClass('sr-only');
          $('[data-form-register-alert]').text('E-mail já cadastrado.');

          break;

        case 'non_existent_email':

          $('[data-form-register-alert]').removeClass('sr-only');
          $('[data-form-register-alert]').text('E-mail inexistente.');        

          break;

        case 'invalid_birthdate':

          $('[data-form-register-alert]').removeClass('sr-only');
          $('[data-form-register-alert]').text('Data de nascimento inválida.');         

          break;
        
        case 'success':

          $('[data-form-register-alert]').addClass('sr-only');
          $('[data-sweet-modal-clairvoyant]').modal('show');
          
          break;

        default:

          console.log('Status inválido...');
      }
    },

    onFail: function(xhr) {
      console.log(xhr.responseJSON);
    },

  };

  /**
   * Fires when document is ready.
   */
  $(function() {
    ClairVoyantForm.start();
  });
})(jQuery);
