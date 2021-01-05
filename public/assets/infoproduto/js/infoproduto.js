(function($) {
  const Infoproduto = {
    start: function() {
      this.bind();
    },

    bind: function() {
      $('[data-btn-submit]').on('click', this.onBtnSubmit.bind(this));
      $('[data-research-option]').on('click', this.onRadioClick.bind(this));
    },

    onBtnSubmit: function(event) {
      event.preventDefault();

      $('[data-form-register-alert]').addClass('sr-only');

      const numQuestions = $('[data-form-count-questions]').val();

      var blankQuestion = false;
      var openedBlank   = false;

      for (i=1; i<=numQuestions; i++){
        var $option = $(`input[name="question-${i}"]:checked`);
        
        // Este for é para quando tiver mais de uma checkbox selecionada.
        for(j=0; j<=$option.length; j++) {
          // Verifica se tem questões não preenchidas
          if('string' != typeof($option.val())) {
            blankQuestion = true;
          }

          // Verifica se tem questões abertas não preenchidas.
          if ($option[j] != null) {
            if ($option[j].dataset.opened == 'true' && ($(`input[name="opened-question-${i}"]`).val() == '')) {
              openedBlank = true;
            }
          }
        }
      }

      // Mostra o alert de questões não respondidas.
      if(blankQuestion === true) {
        $('[data-form-register-alert]')
          .removeClass('sr-only')
          .removeClass('alert-success')
          .text('Há questões não respondidas!');
        return;
      }

      // Mostra o alert de questões abertas não respondidas.
      if(openedBlank === true) {
        $('[data-form-register-alert]')
          .removeClass('sr-only')
          .removeClass('alert-success')
          .text('Há alternativas abertas não preenchidas!');
        return;
      }

      const values = (this.getValues());

      const saving = $.ajax({
        method: 'POST',
        url: '/profile-research/research',
        contentType: 'application/json',
        data: JSON.stringify({
          _token : $('meta[name="csrf-token"]').attr('content'),
          data   : values, 
        }),
      });

      saving.done($.proxy(this.onCreateSuccess, this));  
      saving.fail($.proxy(this.onCreateFail, this));

    },

    onCreateSuccess: function (data) {
      if ('success' == data.status) { 

        $('[data-form-register-alert]')
          .removeClass('sr-only')
          .removeClass('alert-danger')
          .addClass('alert-success')
          .text('Sucesso! Redirecionando...');

          window.location.href = $('[data-store-url]').val()+'/incentive-emails/postback?customers_id='+$('[data-form-customer-id]').val()+'&incentive_email_code='+$('[data-incentive-email-code]').val() ;
      }
      
    },

    onCreateFail: function (error) {
      console.log(error)
    },

    onRadioClick: function(event) {
      const $option  = $(event.currentTarget);
      const opened   = $.trim($option.data('opened'));
      const questionId = $.trim($option.data('question'));

      if('checkbox' === $option[0].type && $option.prop('checked') && ('true' == opened)) { 
        $(`.opened-question-${questionId}`).removeClass('sr-only');
        return;
      }

      if('checkbox' === $option[0].type && (false === $option.prop('checked')) && ('true' == opened)) { 
        $(`.opened-question-${questionId}`).addClass('sr-only');
        $(`.opened-question-${questionId}`).val('');
        return;
      }

      if('radio' === $option[0].type && ('true' == opened)) { 
        $(`.opened-question-${questionId}`).removeClass('sr-only');
        return;
      }

      if('radio' === $option[0].type && ('false' == opened)) { 
        $(`.opened-question-${questionId}`).addClass('sr-only');
        $(`.opened-question-${questionId}`).val('');
        return;
      } 
    },

    getValues: function () {
      const $checked = ($('[data-research-option]:checked'));

      var allRes = [];
      var answerString = '';

      for(i=0; i<$checked.length; i++) {
        if($checked[i].dataset.opened == 'true') {
          answerString = $(`.opened-question-${$checked[i].dataset.question}`).val();
        } else {
          answerString = '';
        }
        
        var res = {
          research_id  : parseInt($('[data-form-customer-id]').val()),
          question_id  : parseInt($checked[i].dataset.question),
          option_id    : parseInt($checked[i].value),
          answer_string: answerString,
        };

        allRes.push(res);
      }

      return allRes;
      
    },

  };

  $(function() {
    Infoproduto.start();
  });
})(jQuery);