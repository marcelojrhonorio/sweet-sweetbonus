(function($) {
  const RaptorInfo = {
    start: function() {

      this.$btnsubmit = $('[data-btn-submit]');

      this.$form = $('[data-form-register]');
      this.$alert = $('[data-form-register-alert]');
      this.$customerId = $('[data-form-customer-id]');
   
      this.bind();
    },

    bind: function() {
      this.$btnsubmit.on('click', this.onFormSubmit.bind(this));
    },

    onFormSubmit: function(event) {
      event.preventDefault();

      const values = this.getValues();

      // Reset Alert.
      this.$alert.removeClass('alert-danger');
      this.$alert.removeClass('alert-success');      
      this.$alert.addClass('sr-only');

      if (("" === values.retired || null === values.retired) || typeof values.retired === "undefined") {
        this.$alert.addClass('alert-danger');
        this.$alert.text('Opção não informada.');
        this.$alert.removeClass('sr-only');
        return;
      }

      if ("2" == values.retired) {
        window.location.href = ('/opinion-research/no-profile');
        return;
      }

      // if ("" === values.age || null === values.age) {
      //   this.$alert.addClass('alert-danger');
      //   this.$alert.text('Idade não informada.');
      //   this.$alert.removeClass('sr-only');        
      //   return;
      // }

      // if ("" === values.salary || null === values.salary) {
      //   this.$alert.addClass('alert-danger');
      //   this.$alert.text('Faixa salarial não informada.');
      //   this.$alert.removeClass('sr-only');        
      //   return;
      // }

      // if ("" === values.salary || null === values.salary || 0 === values.social_class) {
      //   this.$alert.addClass('alert-danger');
      //   this.$alert.text('Faixa salarial não informada.');
      //   this.$alert.removeClass('sr-only');
      //   return;
      // }

      // const link = `https://survey.webraptor.com.br//mailing?EstudoUniqueID=ZEu3VzhH5uc=&T=0&ClientUniqueID=${values.customer_id}&texto5=SM&site=7&texto1=${values.age}&texto2=${values.gender}&texto3=${values.social_class}&texto4=${values.salary}&texto6=SMTID&AllowNew=1&cw=1`;

      // const link = `https://survey.webraptor.com.br//mailing?EstudoUniqueID=fk+Dz8uzXvc=&T=0&cw=1&ClientUniqueID=${values.customer_id}&site=7&sexo=${values.gender}&idade=${values.age}&classe=${values.social_class}&texto6=SWEETDEZ&texto5=SW&token=SW&AllowNew=1&cw=1`;
      
      // const link = `https://survey.webraptor.com.br//mailing?EstudoUniqueID=ECUPoz2AOmI=&T=0&cw=1&ClientUniqueID=${values.customer_id}&texto2=${values.customer_id}&site=7&sexo=${values.gender}&idade=${values.age}&classe=${values.social_class}&texto6=SWEETJAN&texto5=SW&token=SW&AllowNew=1&cw=1`;

      const link = `https://survey.webraptor.com.br//mailing?EstudoUniqueID=uuxJgkP9SQo=&T=0&ClientUniqueID=${values.customer_id}&tipoentrevistado=1&codusuario=2&codgrupo=1&token=SW&site=7&texto7=SWEETFEV&numero1=0&numero2=2&texto6=SW&numero6=0&AllowNew=1&cw=1`;
      
      window.location.href = (link);
    },
    
    getValues: function()
    {
      return {
        'customer_id' : $('[data-form-customer-id]').val(),
        'retired' : $("input[name='question-1']:checked").val(),
        // 'age' : $('[data-raptor-age]').val(),
        // 'salary' : $("input[name='question-2']:checked").val(),
        // 'social_class' : this.getSocialClass($("input[name='question-2']:checked").val()),
      }
    },

    getSocialClass(salaryId) {
      // Cast 
      salaryId = parseInt(salaryId);

      var finalClass = 0;

      switch (salaryId) {
        case 1:
            finalClass = 4;
          break;
        case 2:
            finalClass = 4;
          break;
        case 3:
            finalClass = 4;
            break;
        case 4:
            finalClass = 3;
            break;
        case 5:
            finalClass = 3;
            break;
        case 6:
            finalClass = 2;
            break;
        case 7:
            finalClass = 2;
            break;
        case 8:
            finalClass = 1;
            break;                            
      }
      return finalClass;
    },

  };

  $(function() {
    RaptorInfo.start();
  });
})(jQuery);