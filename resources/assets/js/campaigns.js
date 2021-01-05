(function($) {
  /**
   * Sweet campaign
   */
  const SweetCampaign = {
    start: function() {
      this.$campaignTitle    = $('[data-campaign-title]');
      this.$campaignQuestion = $('[data-campaign-question]');
      this.$campaignAnswers  = $('[data-campaign-answers]');
      this.$btn              = $('[data-btn-answer]');

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
      this.getCampaigns();
    },

    bind: function() {
      this.$campaignAnswers.on('change', '[data-campaign-answer-yes]', $.proxy(this.onYesClick, this));
      this.$campaignAnswers.on('change', '[data-campaign-answer-no]', $.proxy(this.onNoClick, this));
      this.$btn.on('click', $.proxy(this.onBtnClick, this));
    },

    getCampaigns: function () {
      var pathname = window.location.pathname;

      /**
       * Reset answers.
       */
      $('[data-campaign-answers-list]').remove();

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

      this.$campaignWrap.addClass('sr-only');

      /**
       * Show modal.
       */
      // Swal.fire({
      //   title: 'Aguarde!',
      //   html: 'Carregando as melhores campanhas...'
      // });

      /**
       * Show loading in modal.
       */
      // Swal.showLoading();

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
       * Close modal with loading.
       */
      // Swal.close();
      this.$campaignWrap.removeClass('sr-only');

      /**
       * Get number of campaigns.
       */
      var campaigns_number = data.results.length;
      
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
       * Get first array data.
       */
      var campaign = data.results[0];

      /**
       * Verify if all campaigns is answered.
       */
      if (null == campaign) {
        
        this.$campaignWrap.addClass('sr-only');

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
      this.$campaignTitle.text(campaign.title);
      this.$campaignQuestion.text(campaign.question);

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
      this.$spanBtn.text('Continuar');
      this.$btn.prop('disabled', false);
      this.$ajaxSpinner.addClass('sr-only');
      this.getCampaigns();
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

  };

  /**
   * Fires when document is ready.
   */
  $(function() {
    SweetCampaign.start();
  });

})(jQuery);
