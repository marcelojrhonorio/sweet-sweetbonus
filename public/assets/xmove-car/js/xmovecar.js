(function($) {
    const XMoveCar = {
        $form: null,

        start: function() {

            this.$form        = $('[data-form-xmove]');
            this.button       = this.$form.find('[data-form-button]');
            this.buttonText   = this.$form.find('[data-button-text]'); 
            
            this.applyMasks();
            this.bind();
        },

        applyMasks: function() {
            $('[data-cell-phone]').mask('(00)00000-0000');
            $('[data-phone]').mask('(00)00000-0000');
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

            return {
              name        : this.$form.find('#name').val(),
              email       : this.$form.find('#email').val(),              
              cell_phone  : this.$form.find('#cell_phone').val(),
              phone       : this.$form.find('#phone').val(),
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
              url        : 'xmove-car/create',
              contentType: 'application/json; charset=utf-8',
            });
      
            this.buttonText.text('Aguarde...');
            this.button.prop('disabled', true); 
            this.button.removeClass('submit-button');
            this.button.addClass('wait-button');           
      
            creating.done($.proxy(this.onSuccess, this));
      
            creating.fail($.proxy(this.onFail, this));
        },

        onSuccess: function(data) {

            switch (data.status) {
                case 'email_exists':        
                    this.buttonText.text('Quero saber mais');
                    this.button.prop('disabled', false);
                    this.button.addClass('submit-button');
                    this.button.removeClass('wait-button');
            
                    $('[data-form-register-alert]')
                    .html('Você já possui cadastro na XMove Car.')
                    .removeClass('sr-only');        
                break;

                case 'success':
                    window.location.href = "xmove-car/final";
                break;
            }

        },

        onFail: function(xhr) {
            console.log(xhr.responseJSON);
        },

    };

$(function() {
    XMoveCar.start();
  });
})(jQuery);