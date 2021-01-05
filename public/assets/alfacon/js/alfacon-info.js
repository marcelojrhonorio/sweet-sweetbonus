(function($) {
  const AlfaconInfo = {
    start: function() {
      this.$form     = $('[data-form-register]');
      this.$alert    = $('[data-form-register-alert]');

      this.$fullname = $('[data-customer-fullname]');
      this.$email = $('[data-customer-email]');
      this.$phone = $('[data-customer-phone]');

      this.applyMasks();
      this.bind();
    },

    bind: function() {
      this.$form.on('submit', $.proxy(this.onFormSubmit, this));
    },

    applyMasks: function() {
      this.$phone.mask('(00)00000-0000');
    },

    onFormSubmit: function(event) {
      event.preventDefault();

      const data = this.getValues();

      /**
       * Reset alert.
       */
      this.$alert.addClass('sr-only');
      this.$alert.removeClass('alert-danger');
      this.$alert.removeClass('alert-success');

      if (null === data.fullname) {
        this.$alert.addClass('alert-danger');
        this.$alert.removeClass('alert-success');
        this.$alert.text('Campo sobrenome em branco!');
        this.$alert.removeClass('sr-only');
        return;
      }

      if (null === data.email) {
        this.$alert.addClass('alert-danger');
        this.$alert.removeClass('alert-success');
        this.$alert.text('Campo e-mail em branco!');
        this.$alert.removeClass('sr-only');
        return;
      }

      if (null === data.phone) {
        this.$alert.addClass('alert-danger');
        this.$alert.removeClass('alert-success');
        this.$alert.text('Campo celular em branco!');
        this.$alert.removeClass('sr-only');
        return;
      }

      if (11 !== data.phone.length) {
        this.$alert.addClass('alert-danger');
        this.$alert.removeClass('alert-success');
        this.$alert.text('Campo celular inválido!');
        this.$alert.removeClass('sr-only');
        return;
      }

      /**
       * Send data to controller.
       */
      const saving = $.ajax({
        method: 'POST',
        url: '/alfacon/info',
        contentType: 'application/json',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({
          fullname: data.fullname,
          email: data.email,
          phone: data.phone,
        }),
      });

      saving.done($.proxy(this.onSaveSuccess, this));

      saving.fail($.proxy(this.onSaveFail, this));

    },

    onSaveSuccess: function(data) {
      if(data.success) {
        this.$alert.removeClass('alert-danger');
        this.$alert.addClass('alert-success');
        this.$alert.text(data.message);
        this.$alert.removeClass('sr-only');

        window.setTimeout(function() {
          window.location.href = "/alfacon";
        }, 3000);   
        
        return;
      }
    },

    onSaveFail: function(error) {
      console.log(error);
    },

    getValues: function() {
      return {
        fullname : this.$fullname.val(),
        email : this.$email.val(),
        phone : this.$phone.val().replace(/[^\d]+/g,''),
      }
    },
  };

  $(function() {
    AlfaconInfo.start();
  });
})(jQuery);