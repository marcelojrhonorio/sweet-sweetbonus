(function($) {
    const StepOne = {
      start: function() {
        this.$form                = $('[data-form-register]');
        this.$alert               = $('[data-form-register-alert]');
        this.$insuranceQuestion   = $('[data-hasinsurance-question]');
  
        this.bind();
      },
  
      bind: function() {
        this.$form.on('submit', $.proxy(this.onFormSubmit, this));
        $('input[name="has_vehicle"]').on('change', $.proxy(this.onHasCarClick, this));
      },
  
      onFormSubmit: function(event){
        event.preventDefault();
        if ($('input[name="has_vehicle"]:checked').val() !== ('Sim' || 'Não')){
          this.$alert.removeClass('sr-only');
          this.$alert.text('Por favor, marque uma opção.');
        }
      },
  
      onHasCarClick: function(event) {
        event.preventDefault();
        
        if('Sim' === $('input[name="has_vehicle"]:checked').val()){
          window.location.href = "/seguro-auto/step-one/redirect?step_id=1&has_car=1";
        } else {
          window.location.href = "/seguro-auto/step-one/redirect?step_id=1&has_car=0";
        }
      },
  
    }
  
    $(function() {
      StepOne.start();
    });
  })(jQuery);  