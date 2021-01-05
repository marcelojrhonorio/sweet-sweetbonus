(function($) {
  const InsuranceInfo = {
    start: function() {
      this.$form      = $('[data-form-register]');
      this.$alert = $('[data-form-register-alert]');

      this.applyMasks();
      this.bind();
    },

    bind: function() {
      this.$form.on('submit', $.proxy(this.onFormSubmit, this));
    },

    onFormSubmit: function(event) {
      event.preventDefault();

      if ('' === $.trim($('input[name="gender"]:checked').val())) {
        this.$alert.removeClass('sr-only');
        this.$alert.text('Por favor, selecione um sexo.');        
      }

      if ('' === $.trim($('[data-customer-fullname]').val())) {
        this.$alert.removeClass('sr-only');
        this.$alert.text('Por favor, informe seu nome completo.');        
      }

      if (('' === $.trim($('[data-customer-ddd]').val())) && '' === $.trim($('[data-customer-id]'))) {
        this.$alert.removeClass('sr-only');
        this.$alert.text('Por favor, informe um DDD.');        
      }      

      if ('' === $.trim($('[data-customer-cep]').val())) {
        this.$alert.removeClass('sr-only');
        this.$alert.text('Por favor, informe um CEP.');        
      }      
      
      if ('' === $.trim($('[data-customer-birthdate]').val())) {
        this.$alert.removeClass('sr-only');
        this.$alert.text('Por favor, informe uma data de nascimento.');        
      }

      if ('' === $.trim($('[data-customer-email]').val())) {
        this.$alert.removeClass('sr-only');
        this.$alert.text('Por favor, informe um e-mail válido.');        
      }

      const values = new FormData(this.$form[0]);

      const saving = $.ajax({
        cache      : false,
        dataType   : 'json',
        contentType: false,
        processData: false,
        method     : 'POST',
        url        : '/seguro-auto/info',
        data       : values,
      });

      saving.done($.proxy(this.onCreateSuccess, this));

      saving.fail($.proxy(this.onCreateFail, this));
      
    },

    onCreateSuccess: function(data) {
      switch (data.status) {
        case 'invalid_ddd':
            this.$alert.removeClass('sr-only');
            this.$alert.text('O DDD é inválido.');  
          break;
          
        case 'invalid_cep':
          this.$alert.removeClass('sr-only');
          this.$alert.text('O CEP é inválido.');         
          break;
          
        case 'invalid_birthdate': 
          this.$alert.removeClass('sr-only');
          this.$alert.text('A data de nascimento é inválida.');  
          break;

        case 'email_exists': 
         this.$alert.removeClass('sr-only');
         this.$alert.text('Usuário já existe.');  
         break;  

        case 'success':
          console.log('Próxima etapa');
          break;

        default:
          console.log('Status inválido...');          
      }
    },

    onCreateFail: function(error) {
      console.log(error);
    },

    applyMasks: function() {
      $('[data-customer-ddd]').mask('00');
      $('[data-customer-birthdate]').mask('00/00/0000');
      $('[data-customer-cep]').mask('00.000-000');
    },


  };

  $(function() {
    InsuranceInfo.start();
  });
})(jQuery);