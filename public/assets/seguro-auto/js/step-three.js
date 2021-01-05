(function($) {
  const StepThree = {
    start: function() {
      this.$form   = $('[data-form-register]');
      this.$alert  = $('[data-form-register-alert]'); 
      this.$alertSuccess = $('[data-form-register-alert-success]');

      this.$mobile = $('[data-insurance-mobile]');
      this.$phone  = $('[data-insurance-phone]');
      this.$cpf    = $('[data-insurance-cpf]');

      this.token = $('meta[name="csrf-token"]').attr('content');
      this.$store = $('[data-store-url]');
      this.$btn = $('[data-btn-submit]');

      this.bind();
      this.mask();
    },

    bind () {
      this.$form.on('submit', $.proxy(this.onFormSubmit, this));
    },

    mask() {
      this.$mobile.mask('(00) 00000-0000');
      this.$phone.mask('(00) 0000-0000');
      this.$cpf.mask('000.000.000-00');
      return this
    },

    isValidCpf(input) {
      const number = input.toString().replace(/\.|-/g, '')
    
      const blackList = [
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999',
      ]
    
      if (-1 !== blackList.indexOf(number)) {
        return false;
      }
    
      let sum;
      let rest;
    
      sum = 0;
    
      for (let i = 1; i <= 9; i++) {
        sum = sum + parseInt(number.substring(i - 1, i)) * (11 - i);
      }
    
      rest = (sum * 10) % 11;
    
      if ((rest == 10) || (rest == 11)) {
        rest = 0;
      }
    
      if (rest != parseInt(number.substring(9, 10))) {
        return false;
      }
    
      sum = 0;
    
      for (let i = 1; i <= 10; i++) {
        sum = sum + parseInt(number.substring(i - 1, i)) * (12 - i);
      }
    
      rest = (sum * 10) % 11;
    
      if ((rest == 10) || (rest == 11)) {
        rest = 0;
      }
    
      if (rest != parseInt(number.substring(10, 11))) {
        return false;
      }
    
      return true;
    },    

    onFormSubmit(event){
      event.preventDefault();

      var cell  = $.trim($('[data-insurance-mobile]').val());
      var hasValidCell  = 14 === cell.length  || 15 === cell.length  ? true : false;
      cell = $.trim($('[data-insurance-mobile]').val()).replace(/\D/g, '');
      
      const blackList = [
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999',
      ];

      if (-1 !== blackList.indexOf(cell)) {
        hasValidCell = false;
      }      

      const hasValidCpf   = this.isValidCpf(this.$cpf.val());

      if( '' === this.$mobile.val()         ||
          '' === this.$cpf.val()            ||
          !hasValidCell                     ||
          !hasValidCpf                
        ) {

        this.$alert.removeClass('sr-only');
        this.$btn.prop('disabled', false);

      } else {
        this.$alert.addClass('sr-only');
      
        const data = {
          _token       : this.token,
          mobile_phone : $.trim($('[data-insurance-mobile]').val()),//.replace(/\D/g, ''),
          phone        : $.trim($('[data-insurance-phone]').val()).replace(/\s/g, ''),
          cpf          : $.trim($('[data-insurance-cpf]').val()).replace(/[^\d]+/g,''),
        };
  
        const saving = $.ajax({
          url: '/seguro-auto/step-three',
          dataType: 'json',
          method: 'POST',
          data: data,
        });
  
        saving.done($.proxy(this.onCreateSuccess, this));
  
        saving.fail($.proxy(this.onCreateFail, this));
      }      
      
    },

    onCreateSuccess(data){
      if (false == data.success) {
        this.$alert.removeClass('sr-only');
        this.$alert.text(data.message);
        this.$btn.prop('disabled', false);

      } else {
        this.$alert.addClass('sr-only');
        this.$alertSuccess.removeClass('sr-only');
        this.$alertSuccess.text('Pesquisa concluída! Redirecionando para Store...');
        this.$btn.prop('disabled', true);
        window.setTimeout(function(){
          window.location.href = $('[data-store-url]').val();
        }, 3000); 
      }

    },
  
    onCreateFail(error){
      console.log(error);
    },    

  }

  $(function () {
    StepThree.start();
  });  
})(jQuery);