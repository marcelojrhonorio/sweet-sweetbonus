var Campaigns = (function ($, global, _) {
  'use strict';

  var app = {
    table: null,

    contConfig: 1,

    dataSearch: {},

    domain: $('#domain').val(),

    countCampaigns: 0,

    campaignsStorage: [],

    campaignsAnswerStorage: [],

    clickout: function(options) {
      var className = '';
      var answerDivClass = '';
      var clicked = '';
      
      var div       = $('<div />').addClass('campaign-answer');

      $.each(options.clickout, function(index, item) {

        var itemAffirmative = parseInt(item.affirmative);

        className       = (itemAffirmative === 1) ? 'color-box-affirmative'    : 'color-box-negative';
        clicked         = (itemAffirmative === 1) ? 'clicked-css-affirmative'  : 'clicked-css-negative';
        answerDivClass  = (itemAffirmative === 1) ? 'check-answer-affirmative' : 'check-answer-negative';

        div.append(
          $('<div />').addClass('text-left ' + clicked).append(
            $('<input />').attr({
              'type':'radio',
              'name':'answser' + options.campaign,
              'id':'answser' + item.id,
              'data-answer': item.affirmative,
              'data-campaign': options.campaign,
              'data-link': item.link,
              'data-type': options.types.id,
              'data-tab': (options.types.type === 'ClickOut') ? 1 : 0,
              'data-postback': options.postback_url,
              'value': item.answer,
              'class': answerDivClass,
            })).append($('<label />').attr({'class': className + ' ' + clicked}).html('&nbsp;' + item.answer)
          )
        );
      });

      return div;
    },

    buttonAction: function(current, last) {
        if (current === last) {
          return (
            $('<button />').addClass('btn btn-warning btn-last').attr({
              'name':'btn-last',
              'id':'btn-last-'.concat(last),
              'data-id': last,
            }).html('Finalizar&nbsp;').append($('<span />').addClass('glyphicon glyphicon-chevron-right'))
          );
        }

        return (
          $('<button />').addClass('btn btn-warning btn-next').attr({
            'name':'btn-next',
            'id':'btn-next-'.concat(current),
            'data-id': current,
          }).html('Continuar&nbsp;').append($('<span />').addClass('glyphicon glyphicon-chevron-right'))
        );
    },

    divClick: function () {
      $(_).on('click', '.clicked-css-affirmative', function(event) {
        var $input = $(this).find('input');

        $input.prop('checked', true).trigger('change');

        if ($(event.target).hasClass('clicked-css-affirmative')) {
          Campaigns.sliderCampaigns._openLink($input);
        }
      });

      $(_).on('click', '.clicked-css-negative', function(event) {
        $(this).find('input').prop('checked', true).trigger('change');
      });
    },

    search: function() {
      try {
        var promise = sweet.common.crud.read({
          endpoint: laroute.route('sweet.api.search.campaigns'),
          type: 'get',
        });

        promise.fail(function(error) {
          if ($.parseJSON(error.responseText).error === 'unauthenticated') {
            global.location.href = laroute.route('sweet.api.main');
          }
        });

        promise.done(function(data) {
          var countCampaigns = 0;
          var results        = data.results;
          var ul             = $('#slider');
          var lastId         = ($(results).last()[0]);

          if (results.length == 0) {
            app.redirect();
          }

          $.each(results, function (index, item) {
            if (index == 0) {
              app.save.campaigns(item.id);
            }

            var li = $('<li />').append(
              $('<input />').attr({
                'type': 'hidden',
                'name': 'campaign-' + item.id,
                'id': 'campaign-' + item.id,
                'value': item.id,
              })
            ).append(
              $('<div />').addClass('row').append(
                $('<div />').addClass('col-md-12').append(
                  $('<div />').addClass('row').append(
                    $('<div />').addClass('col-md-4 media roundeed').append(
                      $('<img />').attr('src', app.domain.concat('/storage/', item.image)).addClass('img-responsive')
                    )
                  ).append(
                    $('<div />').addClass('col-md-8').append(
                      $('<div />').addClass('campaign-box campaign-' + item.id).append(
                        $('<h2 />').html(item.title)
                      ).append(
                        $('<div />').addClass('campaign-question').append(
                          $('<h4 />').addClass('text-left').css('padding', '10px').html(item.question)
                        )
                      ).append(
                        app.clickout({
                          'clickout': item.clickout,
                          'types': item.types,
                          'campaign': item.id,
                          'postback_url': item.postback_url,
                        })
                      ).append(
                        $('<div />').addClass('text-right button-next').append(
                          app.buttonAction(item.id, lastId.id)
                        )
                      )
                    )
                  )
                )
              )
            );

            if (index == 0) {
              li.addClass('active');
            }

            li.appendTo(ul);

            countCampaigns++;
          });

          $('ul#slider li').not('.active').css('display', 'none');
          $('ul#slider li.active').css('height', '2000px');
          $('ul#slider').css('height', '1500px');
          $('#slider').fadeIn('slow');
          $('#campaigns-total').val(countCampaigns);
          waitingDialog.hide();
        });
      } catch (e) {
        sweet.msgException.msg(e, 'companies.app.actions.create');
      }
    },

    sliderCampaigns: {
      progressBar: function(answser) {
        var calculate = parseInt((parseInt(answser) / parseInt($('#campaigns-total').val())) * 100) + 1;

        setTimeout(function() {
          if (calculate > 0) {
            $('#zero').removeClass('no-color').addClass('warning-color');
          }

          if (calculate >= 25) {
            $('#twenty-five').removeClass('no-color').addClass('warning-color');
          }

          if (calculate >= 50) {
            $('#fifty').removeClass('no-color').addClass('warning-color');
          }

          if (calculate >= 75) {
            $('#seventy-five').removeClass('no-color').addClass('warning-color');
          }

          if (calculate >= 100) {
            $('#hundred').removeClass('no-color').addClass('warning-color');
          }
        }, 250);

        $('.progress-bar-warning').css('width', calculate + '%');

        return this;
      },

      adjustHeight: function(timeOut) {
        var timeOut = (!sweet.validate.isNull(timeOut)) ? timeOut : 10;

        setTimeout(function() {
          var witdhWindow       = $(window).width();
          var heightCampaignBox = ($('.campaign-'.concat($('#slider .active .btn-next').data('id'))).innerHeight());

          if ($.browser.mobile || sweet.common.isFacebookApp()) {
            heightCampaignBox = ($('#slider .active .img-responsive').height() + heightCampaignBox);
          }

          heightCampaignBox = ($('#slider .active .img-responsive').height() + $('#slider .active .img-responsive').height() + heightCampaignBox);

          $('#slider').css('height', heightCampaignBox + 'px');
          $('#slider li.active').css('height', (heightCampaignBox * 2) + 'px');
        }, 100);
      },

      slider: function() {
        var sliderActive = $('#slider .active');
        var sliderNext   = sliderActive.next().length ? sliderActive.next() : $('#slider li:first');

        $('ul#slider li').last().addClass('last-element');

        // Alternativa
        $('ul#slider li').css('display', 'none');

        sliderNext.addClass('active').fadeIn(700, function(){
          setTimeout(function(){
            app.sliderCampaigns.adjustHeight();
          }, 100);
        });

        sliderActive.removeClass('active').fadeOut(100);

        app.save.campaigns($('#slider .active button').data('id'));

        return this;
      },

      validateChoose: function (id) {
        var name = 'answser'.concat(id);
        return $('input[name="' + name + '"]').is(':checked');
      },

      postbackCreate: function() {
        $(_).on('change, click', '.check-answer', function() {
          if (parseInt($(this).data('answer'), 10) === 1 && $(this).data('postback') !== '') {
            var verify = function (postback) {
              if (sweet.validate.isNull(postback.match(/http/g))) {
                return 'http://' + postback;
              }

              return postback;
            };

            $('body').append(
              $('<img />').attr({
                'src': verify($(this).data('postback')),
                'frameborder': '0',
                'width': '1',
                'height': '1',
              })
            );
          }
        });
      },

      openLink: function() {
        $(_).on('change, click', '.check-answer', function() {
          if (parseInt($(this).data('answer'), 10) === 1 && $(this).data('link') !== '') {
            var verify = function(link) {
              if (sweet.validate.isNull(link.match(/http/g))) {
                return 'http://' + link;
              }
              return link;
            };

            if(8 === parseInt($(this).data('type'), 10)) {
              var customerId = $('[data-customer-id]').val();
              
              global.open(verify($(this).data('link') + 
                '&USER_ID=f-'+ customerId), '_blank');

            } else {
              global.open(verify($(this).data('link')), '_blank');
            }
            
            $('#slider .active button').trigger('click');
          }
        });

        return this;
      },

      _openLink: function($input) {

        if (parseInt($input.data('answer'), 10) === 1 && $input.data('link') !== '') {
          var verify = function(link) {
            if (sweet.validate.isNull(link.match(/http/g))) {
              return 'http://' + link;
            }

            return link;
          };

          global.open(verify($input.data('link')), '_blank');

          $('#slider .active button').trigger('click');
        }
      },

      action: function() {
        var answser = 0;

        $('#slider').on('click', '.btn-last', function(e) {
          e.preventDefault();
          e.stopPropagation();

          var id = $(this).data('id');

          if (!app.sliderCampaigns.validateChoose(id)) {
            sweet.common.message('error', 'Por favor, responda a todas as perguntas.');

            return false;
          }

          app.save.answers({
            'campaign': id,
            'answer': $('input[name="answser'.concat(id) + '"]:checked').val(),
          });

          app.sliderCampaigns.progressBar(100);

          app.redirect();
        });

        $('#slider').on('click', '.btn-next', function(e) {
          e.preventDefault();
          e.stopPropagation();

          var id = $(this).data('id');

          if (!app.sliderCampaigns.validateChoose(id)) {
            sweet.common.message('error', 'Por favor, responda a todas as perguntas.');
            return false;
          }

          answser++;

          app.save.answers({
            'campaign': id,
            'answer': $('input[name="answser'.concat(id) + '"]:checked').val(),
          });

          app.sliderCampaigns.slider().progressBar(answser);
        });
      },

      storage: {
        visualized: {
          create: function(id) {
            app.campaignsStorage.push(id);
            global.localStorage.setItem('campaignVisualized', JSON.stringify(app.campaignsStorage));
          },

          delete: function() {
            global.localStorage.removeItem('campaignVisualized');
          },

          read: function() {
            global.localStorage.getItem('campaignVisualized');
          },
        },

        answer: {
          create: function(option) {
            app.campaignsAnswerStorage.push({
              'campaign' : option.campaign,
              'answer': option.answer,
              'constumer': option.costumer,
            });

            global.localStorage.setItem('answer', JSON.stringify(app.campaignsAnswerStorage));
          },

          delete: function() {
            global.localStorage.removeItem('answer');
          },

          read: function() {
            global.localStorage.getItem('answer');
          },
        },
      },
    },

    save: {
      campaigns: function(id) {
        try {
          var promise = sweet.common.crud.save({
            endpoint: laroute.route('sweet.api.save.campaigns'),
            params: {'id' : id},
          });

          promise.fail(function(error) {
            //
          });

          promise.done(function(data) {
            //
          });
        } catch (e) {
          sweet.msgException.msg(e, 'companies.app.campaigns.save');
        }
      },

      answers: function(option) {
        try {
          var promise = sweet.common.crud.save({
            endpoint: laroute.route('sweet.api.save.answers'),
            params: {
              'campaign': option.campaign,
              'answer': option.answer,
            },
          });

          promise.fail(function(error) {
            //
          });

          promise.done(function(data) {
            //
          });
        } catch (e) {
          sweet.msgException.msg(e, 'companies.app.answers.save');
        }
      },

      run: function() {
        // return 'As mudanças deste formulário não foram salvas.
        // Saindo desta página, todas as mudanças serão perdidas.';
      },
    },

    disabledKeys: function() {
      $(_).keydown(function(e) {
        switch (true) {
          case ((e.which || e.keyCode) == 116):
            return false;
            break;
          case ((e.ctrlKey) && (e.which || e.keyCode) == 82):
            return false;
            break;
        }
      });
    },

    redirect: function() {
      setTimeout(function() {
        global.location.replace(laroute.route('sweet.redirect'));
      }, 100);
    },

    init: function() {
      waitingDialog.show('Aguarde', {
        progressType: 'warning',
        dialogSize: 'sm',
      });

      this.disabledKeys();
      this.search();
      this.sliderCampaigns.action();

      setTimeout(function() {
        Campaigns.sliderCampaigns.openLink().postbackCreate();
        Campaigns.divClick();
      }, 300);
    },
  };

  return app;
})(jQuery, window, document);

Campaigns.init();
