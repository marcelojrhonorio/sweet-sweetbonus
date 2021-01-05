(function($) {
  /**
   * Sweet form
   */
  const SweetForm = {
    $form: null,

    start: function() {
      this.$form        = $('[data-form-register]');
      this.storeUrl     = this.$form.find('[data-store-url]').val();
      this.button       = this.$form.find('[data-form-button]');
      this.buttonText   = this.$form.find('[data-button-text]');

      this.labels          = {}
      this.labels.register = 'Cadastre-se gratuitamente!'
      this.labels.wait     = 'Aguarde...'

      //this.buttonText.text(this.labels.register);

      this.applyMasks();
      this.bind();
    },
    
    applyMasks: function() {
      $('[data-mask-ddd]').mask('00');
      $('[data-mask-date]').mask('00/00/0000');
      $('[data-mask-cep]').mask('00.000-000');
    },

    bind: function() {
      this.$form.on('submit', $.proxy(this.onSubmit, this));
      this.$form.on('keydown change select','[data-mask-name]' , $.proxy(this.onKeydown, this));
    },

    onKeydown: function(event) {
      var keyCode = (event.keyCode ? event.keyCode : event.which);
      if (keyCode > 47 && keyCode < 58 || keyCode > 95 && keyCode < 107 ){
        event.preventDefault();
      }
      var matches = $('[data-mask-name]').val().match(/\d+/g);
      if (matches != null) {
        $('[data-mask-name]').val('');
      }
    },

    getValues: function() {

      var act = $('[action_id_mgm]').val();

      if(act != null) {

        return {
          fullname       : this.$form.find('#name').val(),
          email          : this.$form.find('#email').val(),
          gender         : this.$form.find('input[name="gender"]:checked').val(),
          birthdate      : this.$form.find('#birthdate').val(),
          cep            : this.$form.find('#cep').val(),
          ddd            : this.$form.find('#ddd').val(),
          site_origin    : this.$form.find('#site_origin').val(),
          indicated_from : this.$form.find('#indicated_from').val(),
          indicated_by   : this.$form.find('#indicated_by').val(),          
          action_id      : $('[action_id_mgm]').val(),   
          action_type    : $('[action_type_mgm]').val(),
        };

      }

      return {
        fullname       : this.$form.find('#name').val(),
        email          : this.$form.find('#email').val(),
        gender         : this.$form.find('input[name="gender"]:checked').val(),
        birthdate      : this.$form.find('#birthdate').val(),
        cep            : this.$form.find('#cep').val(),
        ddd            : this.$form.find('#ddd').val(),
        site_origin    : this.$form.find('#site_origin').val(),
        indicated_from : this.$form.find('#indicated_from').val(),
        indicated_by   : this.$form.find('#indicated_by').val(),
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
        url        : '/create',
        contentType: 'application/json; charset=utf-8',
      });

      this.buttonText.text(this.labels.wait);
      this.button.prop('disabled', true);
      this.button.removeClass('submit-button');
      this.button.addClass('wait-button');

      creating.done($.proxy(this.onSuccess, this));

      creating.fail($.proxy(this.onFail, this));
    },

    onSuccess: function(data) {
      switch (data.status) {
        case 'email_exists':

          //window.location.href = this.storeUrl;

          this.buttonText.text(this.labels.register);
          this.button.prop('disabled', false);
          this.button.addClass('submit-button');
          this.button.removeClass('wait-button');

          $('[data-form-register-alert]')
            .html('Você já possui cadastro na Sweet, <strong><a href="'+this.storeUrl+'">clique aqui</a></strong> para acessar a página de login.')
            .removeClass('sr-only');

          break;

        case 'invalid_birthdate':

          this.buttonText.text(this.labels.register);
          this.button.prop('disabled', false);
          this.button.addClass('submit-button');
          this.button.removeClass('wait-button');

          $('[data-form-register-alert]')
            .html('Por favor, verifique a <b>data de nascimento</b>.')
            .removeClass('sr-only');

          this.$form.find('#birthdate').focus();

          break;

        case 'invalid_ddd':

          this.buttonText.text(this.labels.register);
          this.button.prop('disabled', false);
          this.button.addClass('submit-button');
          this.button.removeClass('wait-button');          

          $('[data-form-register-alert]')
            .html('Por favor, verifique seu <b>DDD</b>.')
            .removeClass('sr-only');

          this.$form.find('#ddd').focus();

          break;          

        case 'invalid_cep':

          this.buttonText.text(this.labels.register);
          this.button.prop('disabled', false);
          this.button.addClass('submit-button');
          this.button.removeClass('wait-button');        

          $('[data-form-register-alert]')
            .html('Por favor, informe um <b>CEP</b> válido.')
            .removeClass('sr-only');

          this.$form.find('#birthdate').focus();

          break;

          case 'email_deleted':
          
          this.buttonText.text(this.labels.register);
          this.button.prop('disabled', false);
          this.button.addClass('submit-button');
          this.button.removeClass('wait-button');

          $('[data-form-register-alert]')
            .html('Conta com este e-mail desativada. <br>Entre em contato com <b>contato@sweetpanels.com</b>')
            .removeClass('sr-only');

          this.$form.find('#email').focus();

          break;

        case 'success':

          window.location.href = window.location.origin + '/campaigns';

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
    SweetForm.start();
  });
})(jQuery);
