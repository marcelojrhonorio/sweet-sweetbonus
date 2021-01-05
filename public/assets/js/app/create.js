(function (window, document, $) {
  'use strict';

  var create = (function()  {
    return {
      pixelFacebook: function () {

          var facebook = "<script>"
           + "!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?"
           + "n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;"
           + "n.push=n;n.loaded=!0;n.version=\"2.0\";n.queue=[];t=b.createElement(e);t.async=!0;"
           + "t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,\"script\",\"https://connect.facebook.net/en_US/fbevents.js\");"
           + "\n\n fbq('init', '722311067969081');"
           + "\n fbq('track', 'PageView');"
           + "</script>"
           + "<noscript><img height=\"1\" width=\"1\" style=\"display:none\" src=\"https://www.facebook.com/tr?id=722311067969081&ev=PageView&noscript=1\" /></noscript>"
           + "<script>fbq('track', 'Lead', {value: '0.01', currency: 'BRL'})</script>";


          $('body').append(facebook);
      },

      pixel: function(image) {
          $('.step-1').append(
              $('<img />').attr({
                  'src':image,
                  'width':'1',
                  'height':'1'
              })
          );
      },

      validateForm: function() {

          var
              messageErrors = '',
              isValid = true,
              countErrors = 0;

          $('#name, #email, #phone  cep').removeClass('error');


          if (!sweet.common.validateFullName($('#name').val())) {
             messageErrors += 'Preencher nome e sobrenome<br />';
             isValid = false;
             countErrors++;
          }

          if (!sweet.common.parseMail.test($('#email').val())) {
              messageErrors += 'E-mail inválido<br />';
              isValid = false;
              countErrors++;
          }

          if ($('#phone').val() === '' || $('#phone').val().length < 14) {

              //if ($('#phone').val() !== '' && $('#phone').val().length < 14) {
              //    messageErrors += 'Preencher o número do celular corretamente<br />';
              //}
              messageErrors += 'Preencher o número do telefone<br />';
              isValid = false;
              countErrors++
          }

          if (!$('input[type="radio"][name="gender"]').is(':checked')) {
              messageErrors += 'Selecionar o sexo<br />';
              isValid = false;
              countErrors++
          }

          if (!sweet.common.parseDate.test($('#birthdate').val()) || !sweet.common.validateDate($('#birthdate').val())) {
              messageErrors += 'Data de nascimento inválida<br />';
              isValid = false;
              countErrors++;
          }

          //cep
          if ($('#cep').val() === '' || !sweet.common.validadeCEP($('#cep').val())) {
              messageErrors += 'CEP inválido<br />';
              isValid = false;
              countErrors++;
          }

          if (isValid === false) {
             swal((countErrors == 1 ? 'Por favor, verificar o erro abaixo' : 'Por favor, verificar os erros abaixo'), messageErrors, 'error');
          }

          return isValid;
      },

      fields: function () {
        return {
          'fullname'    : $('#name').val(),
          'email'       : $('#email').val(),
          'phone_number': $('#phone').val(),
          'gender'      : $('input[type="radio"][name="gender"]:checked').val(),
          'birthdate'   : $('#birthdate').val(),
          'cep'         : $('#cep').val(),
          'source'      : $('#source').val(),
          'medium'      : $('#medium').val(),
          'campaign'    : $('#campaign').val(),
          'term'        : $('#term').val(),
          'content'     : $('#content').val(),
          'cpf'         : '',
        };
      },

      register: function() {
        try {
          var promise = sweet.common.crud.save({
            endpoint: laroute.route('sweet.api.create'),
            params: create.fields(),
          });

          promise.fail(function(error) {
            console.log(error.responseText);

            var isEmail = false, message = '', hasErros = false;

            $.each($.parseJSON(error.responseText).errors, function(index, value) {
              if (hasErros) {
                  message += '<br />';
              }

              if (index === 'email') {
                  isEmail = true;
              }

              message += value;
              hasErros = true;
            });


            if (isEmail) {
              $('#email').focus();
            }

            swal('Ops, ocorreu algum erro!', message, 'error');
          });

          promise.done(function(data) {
            var type    = 'error';
            var message = '';

            if (data.status == 'success') {
              type    = 'success';
              message = 'Dados cadastrado com sucesso';

              window.location.href = laroute.route('sweet.api.campaigns');
            }

            sweet.common.message(type, message);
          });
        } catch (e) {
          sweet.msgException.msg(e, 'companies.app.actions.create');
        }
      },

      hasEmail: function () {

          $('#email').on('blur', function () {

              if ($('#email').val() == '') {
                  return false;
              }

              $('#create').prop('disabled', 'disabled').val('Aguarde...');

              //swal({
              //    title: 'Aguarde...',
              //    text: 'Estamos verificando seu e-mail!',
              //    showConfirmButton: false,
              //    allowOutsideClick: false
              //});

              var promise = sweet.common.crud.read({
                  endpoint: laroute.route('sweet.api.validate.email'),
                  params: {'email':$('#email').val()}
              });


              promise.fail(function(error) {
                  //debugger;
                  //console.log(error);
                  //swal.close();
                  $('#create').prop('disabled', false).val('Receber amostra');
              });

              promise.done(function(data) {
                  if (data) {
                      swal({
                          title: 'Aguarde...',
                          text: 'E-mail já cadastrado, estamos redirecinando para o próximo passo!',
                          showConfirmButton: false,
                          allowOutsideClick: false
                      });

                     setTimeout(function () {
                         window.location.href = laroute.route('sweet.api.campaigns');
                     }, 1000)
                  }
                  //swal.close();
                  $('#create').prop('disabled', false).val('Receber amostra');
              });
          })
      },

      mobileTypeField: function() {
          //if (sweet.common.isMobile()) {
          if ($.browser.mobile) {
              new Date().toLocaleDateString('pt-BR');
              $('#birthdate').attr({
              //    'type':'date',
                  'type':'tel',
                  'pattern':'[0-9]{2}\/[0-9]{2}\/[0-9]{4}$'
              });

              $('#phone').attr({
                  'type':'tel',
                  'pattern':'\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$'
              });
          }

          //console.log(new Date().toLocaleDateString('pt-BR'));
          //console.log(window.navigator.userLanguage || window.navigator.language);
      },

      init: function () {
        var optionsBirthdate = {
          'translation': {
            'D': {
              pattern: /[0-3]/
            },
            'd': {
              pattern: /[0-9]/
            },
            'M': {
              pattern: /[0-1]/
            },
            'm': {
              pattern: /[0-9]/
            },
            'Y': {
              pattern: /[0-9]/
            }
          }
        };

        var maskPhoneBehavior = function (val) {
          return val.replace(/\D/g, '').length === 11 ? '(00)00000-0000' : '(00)0000-00009';
        };

        var optionsPhone = {
          onKeyPress: function(val, e, field, options) {
            field.mask(maskPhoneBehavior.apply({}, arguments), options);
          }
        };

        $('.mask-phone').mask(maskPhoneBehavior, optionsPhone);
        $('.mask-phonecell').mask("(00)00000-0000");

        $('#birthdate').mask('Dd/Mm/YYYY', optionsBirthdate);
        $("#cep").mask('99.999-999');

        this.hasEmail();
        this.mobileTypeField();

        $('#create').on('click', function (e) {
          e.preventDefault();
          e.stopPropagation();

          if (create.validateForm()) {
            create.pixel('https://sp.analytics.yahoo.com/spp.pl?a=10000&.yp=10043605');
            create.register();
          }
        });
      }
    };
  })();

  create.init();
})(window, document, jQuery);
