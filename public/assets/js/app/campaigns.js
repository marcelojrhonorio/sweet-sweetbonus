(function($) {
  /**
   * Sweet campaign
   */
  const SweetCampaign = {
    start: function() {
      this.$campaignTitle    = $('[data-campaign-title]');
      this.$campaignQuestion = $('[data-campaign-question]');
      this.$campaignAnswers  = $('[data-campaign-answers]');

      this.$btn     = $('[data-btn-answer]');
      this.$spanBtn = $('[data-span-btn]');

      this.$campaignWrap = $('[data-campaign-wrap]');

      this.$ajaxSpinner  = $('[data-ajax-spinner]');

      /**
       * Storage URL.
       */
      this.$storage = $('[data-storage-url]');

      /**
       * Image path.
       */
      this.$img = $('[data-image-path]');

      /**
       * Progress bar.
       */
      this.$progress = $('[data-campaign-progress]');

      this.$campaignId = '';

      /**
       * Get first camapaign data 
       * to render progress bar.
       */
      this.$initialCampaigns = {
        inicialized      :  false,
        campaigns_number :  0,
      };

      /**
       * Global variable to store campaigns
       * coming from API.
       */
      this.$campaignsData = {
        campaigns : [],
        size: 0,
        current_index : 0,
      };

      /**
       * Percentage balloons
       */
      this.$balloon0 = $('[data-balloon-percent0]');
      this.$balloon25 = $('[data-balloon-percent25]');
      this.$balloon50 = $('[data-balloon-percent50]');
      this.$balloon75 = $('[data-balloon-percent75]');
      this.$balloon100 = $('[data-balloon-percent100]');
      this.$balloonIcon0 = $('[data-balloon-percent0-icon]');
      this.$balloonIcon25 = $('[data-balloon-percent25-icon]');
      this.$balloonIcon50 = $('[data-balloon-percent50-icon]');
      this.$balloonIcon75 = $('[data-balloon-percent75-icon]');
      this.$balloonIcon100 = $('[data-balloon-percent100-icon]');

      this.bind();
      this.showModalConfirmation();
      // this.getCampaigns();
    },

    bind: function() {
      this.$campaignAnswers.on('change', '[data-campaign-answer-yes]', $.proxy(this.onYesClick, this));
      this.$campaignAnswers.on('change', '[data-campaign-answer-no]', $.proxy(this.onNoClick, this));
      this.$btn.on('click', $.proxy(this.onBtnClick, this));
    },

    showModalConfirmation: function () {
      /**
       * Hide campaign wrap first.
       */
      this.$campaignWrap.addClass('sr-only');

      const text = '<i class="fas fa-envelope" style="font-size: 80px; color: #bc6ba3"></i>' + 
      '<h2>Bem-vindo(a) a Sweet!</h2>' +
      'Enviamos um e-mail de confirmação para o endereço cadastrado. Cheque sua caixa de entrada ' + 
      'ou caixa de Spam. Lembre-se: confirmando sua conta<strong> você ganha 30 pontos</strong> e garante o recebimento ' + 
      'das melhores ofertas!';

      Swal.fire({
        html: text,
        confirmButtonColor: '#4cc5b9',
      }).then((result) => {
        this.getCampaigns();
      });
    },

    getCampaigns: function () {
      var pathname = window.location.pathname;

      /**
       * Show loading.
       */
      Swal.fire({
        title: 'Aguarde!',
        html: 'Carregando as melhores campanhas...'
      });
      
      Swal.showLoading();

      /**
       * Verify if campaigns is current path.
       */
      if ('/campaigns' !== pathname) {
        return;
      }

      const headers = {
        'Accept'      : 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      };   

      // this.$campaignWrap.addClass('sr-only');
      this.$campaignWrap.fadeIn("slow");

      /**
       * Get and show campaign.
       */
      const gettingCampaign = $.ajax({
        cache       : false,
        type        : 'get',
        dataType    : 'json',
        headers     : headers,
        url         : '/campaigns/search',
        contentType : 'application/json; charset=utf-8'
      });

      gettingCampaign.done($.proxy(this.onGetCampaignsSuccess, this));

      gettingCampaign.fail($.proxy(this.onGetCampaignsFail, this));
    },

    onGetCampaignsSuccess: function(data) {
      /**
       * Show campaign wrap.
       */
      this.$campaignWrap.removeClass('sr-only');
      
      /**
       * Close modal.
       */
      Swal.close();

      this.$campaignsData.campaigns = data.results;
      this.$campaignsData.current_index = 0;
      this.$campaignsData.size = data.results.length;

      this.renderCampaign();
    },

    onYesClick: function (event) {
      event.preventDefault();

      $('[data-campaign-answer-no]').prop('checked', false);

      const $btn  = $(event.currentTarget);
      const link  = $.trim($btn.data('link'));
      const value = $.trim($btn.data('value'));

      this.saveCampaignAnswer(value);

      window.open(link);
    },

    onNoClick: function (event) {
      event.preventDefault();
      $('[data-campaign-answer-yes]').prop('checked', false);
    },

    /**
     * Save campaign answer.
     */
    saveCampaignAnswer: function (value) {

      this.$spanBtn.text('');
      this.$btn.prop('disabled', true);
      this.$ajaxSpinner.removeClass('sr-only');

      const headers = {
        'Accept'      : 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      };

      values = {
        answer  : value,
        campaign: this.$campaignId,
      };

      const saving = $.ajax({
        cache       : false,
        type        : 'POST',
        dataType    : 'json',
        headers     : headers,
        url         : '/campaigns/answers/save',
        contentType : 'application/json; charset=utf-8',
        data        : JSON.stringify(values),
      });

      saving.done($.proxy(this.onSaveSuccess, this));

      saving.fail($.proxy(this.onSaveFail, this));

    },

    onSaveSuccess: function (data) {        
      this.$campaignWrap.fadeOut('slow', function() {
        SweetCampaign.renderCampaign();
      });
    },

    onSaveFail: function (error) {
      this.$spanBtn.text('Continuar');
      this.$btn.prop('disabled', false);
      this.$ajaxSpinner.addClass('sr-only');
      console.log(error);
    },

    /**
     * Button confirm method.
     */
    onBtnClick: function (event) {  
      event.preventDefault();
      const answer = $('input[name="answer"]:checked');

      this.$spanBtn.text('');
      this.$btn.prop('disabled', true);
      this.$ajaxSpinner.removeClass('sr-only');

      if (answer.length < 1) {
        Swal.fire({
          type: 'error',
          title: 'Oops...',
          text: 'Marque ao menos uma alternativa!',
          confirmButtonColor: '#4cc5b9',
        });

        this.$spanBtn.text('Continuar');
        this.$btn.prop('disabled', false);
        this.$ajaxSpinner.addClass('sr-only');

        return;
      }

      this.saveCampaignAnswer(answer[0].dataset.value);
    },

    /**
     * Change balloons colors. 
     */
    changeBalloons: function (percent) {
      if (percent >= 1 && percent < 25) {
        this.$balloon0.css("background-color", '#f4ae30');
        this.$balloonIcon0.css("color", '#f4ae30');
      }

      if (percent >= 25 && percent < 50) {
        this.$balloon25.css("background-color", '#f4ae30');
        this.$balloonIcon25.css("color", '#f4ae30');
      }

      if (percent >= 50 && percent < 75) {
        this.$balloon50.css("background-color", '#f4ae30');
        this.$balloonIcon50.css("color", '#f4ae30');
      }

      if (percent >= 75 && percent < 100) {
        this.$balloon75.css("background-color", '#f4ae30');
        this.$balloonIcon75.css("color", '#f4ae30');
      }

      if (percent >= 100) {
        this.$balloon100.css("background-color", '#f4ae30');
        this.$balloonIcon100.css("color", '#f4ae30');
      }
    },

    renderCampaign: function () {      
      /**
       * Reset form.
       */
      this.$spanBtn.text('Continuar');
      this.$btn.prop('disabled', false);
      this.$ajaxSpinner.addClass('sr-only');
      this.$img.removeAttr("src");

      /**
       * Reset answers.
       */
      $('[data-campaign-answers-list]').remove();

      /**
       * Get number of campaigns.
       */
      var campaigns_number = this.$campaignsData.campaigns.length - this.$campaignsData.current_index;

      /**
       * Verify if is the first get campaigns 
       * to storage data.
       */
      if (false === this.$initialCampaigns.inicialized) {
        this.$initialCampaigns.inicialized = true;
        this.$initialCampaigns.campaigns_number = campaigns_number;
      } 

      /**
       * Render progress bar.
       */
      else {
        campaigns_number = this.$initialCampaigns.campaigns_number - campaigns_number;
        const percent = (campaigns_number * 100) / this.$initialCampaigns.campaigns_number;
        this.$progress.css({width: percent + '%'});
        this.changeBalloons(percent);
      }

      /**
       * Get current array data.
       */
      var campaign = this.$campaignsData.campaigns[this.$campaignsData.current_index];

      /**
       * Verify if all campaigns is answered.
       */
      if (null == campaign) {
        
        // this.$campaignWrap.addClass('sr-only');
        this.$campaignWrap.fadeOut("slow");

        Swal.fire({
          title: 'Aguarde!',
          html: 'Redirecionando para o portal...'
        });
        
        Swal.showLoading();
        
        /**
         * Redirect to Store.
         */
        window.location.replace("/final-campaign");

        return;
      }

      this.$campaignId = parseInt(campaign.id);
      
      /**
       * Render title and question.
       */

      this.$campaignTitle.html($.parseHTML(campaign.title));
      this.$campaignQuestion.html($.parseHTML(campaign.question));
      
      /**
       * Render image.
       */
      this.$img.attr("src", this.$storage.val() + '/storage/' + campaign.image);

      /**
       * Each campaign answer.
       */
      $.each(campaign.clickout, function (index, value) {
        if ("1" === value.affirmative) {
          /**
           * Verify if is affirmative.
           */
          $('[data-campaign-answers]').append("<div class='radio yellow yes' data-campaign-answers-list>" + 
          "<label>" + 
          "<input type='radio' name='answer' class='answer' data-value='"+ String(value.answer) +"' data-answer='yes' data-link="+ String(value.link) +" data-campaign-answer-yes>"+ value.answer +"</label>" +
          "</div>");
              
          /**
           * Verify if is negative.
           */
        } else {
          $('[data-campaign-answers]').append("<div class='radio no' data-campaign-answers-list>" + 
          "<label>" +
          "<input type='radio' name='answer' class='answer' data-value='"+ String(value.answer) +"' data-answer='no' data-campaign-answer-no>"+ value.answer +"</label>" + 
          "</div>");
        }
      });

      // this.$campaignWrap.removeClass('sr-only');
      this.$campaignWrap.fadeIn("slow");

      this.$campaignsData.current_index ++;
    },

  };

  /**
   * Fires when document is ready.
   */
  $(function() {
    SweetCampaign.start();
  });

})(jQuery);