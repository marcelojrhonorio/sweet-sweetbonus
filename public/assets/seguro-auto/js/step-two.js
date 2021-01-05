(function($) {
  const StepTwo = {
    start: function() {
      this.$form   = $('[data-form-register]');
      this.$alert  = $('[data-form-register-alert]'); 
      
      this.$brand     = $('[data-insurance-brand]');
      this.$wrapBrand = $('[data-wrap-brand]');
      this.brand = '';

      this.$model     = $('[data-insurance-model]');
      this.$wrapModel = $('[data-wrap-model]'); 

      this.$year     = $('[data-insurance-year]');
      this.$wrapYear = $('[data-wrap-year]');

      this.$wrapHasInsurance = $('[data-wrap-has-insurance]');

      this.$wrapdateInsurance = $('[data-wrap-date-insurance]');
      this.$dateInsuranceMonth = $('[data-date-insurance-month]');
      this.$dateInsuranceYear = $('[data-date-insurance-year]');
    
      this.$insurer      = $('[ data-insurance-insurer]');
      this.$wrapInsurer = $('[data-wrap-insurer]');

      this.$btn = $('[data-btn-submit]');
      this.$btn.hide();

      this.$customer = $('[data-customer-id]');
     
      this.token = $('meta[name="csrf-token"]').attr('content');

      this.$wrapModel.hide();
      this.$wrapYear.hide();
      this.$wrapHasInsurance.hide();
      this.$wrapdateInsurance.hide();
      this.$wrapInsurer.hide();
      
      this.bind();
      this.customSelect();
    },

    bind () {
      this.$brand.on('change', $.proxy(this.onChangeBrand, this));
      this.$model.on('change', $.proxy(this.onChangeModel, this));
      this.$year.on('change', $.proxy(this.onChangeYear, this));
      this.$dateInsuranceMonth.on('change', $.proxy(this.onChangeInsuranceMonth, this));
      this.$dateInsuranceYear.on('change', $.proxy(this.onChangeInsuranceYear, this));
      $('input[name="has_insurance"]').on('change', $.proxy(this.onChangeHasInsurance, this));
      this.$insurer.on('change', $.proxy(this.onChangeInsurer, this));
      this.$form.on('submit', $.proxy(this.onFormSubmit, this));
    },

    onChangeBrand(event){
      event.preventDefault();

      this.$btn.prop('disabled', true);
      this.$btn.hide();

      if('' === this.$brand.val()){
        this.$model.prop('disabled', true);
      }

      this.$wrapInsurer.fadeOut()
      this.$insurer.val(null).trigger('change.selectize')
  
      this.$wrapdateInsurance.fadeOut()
      this.$dateInsuranceMonth.val('')
      this.$dateInsuranceYear.val('')

      this.$wrapHasInsurance.fadeOut()
  
      this.$wrapYear.fadeOut()
      this.$year.val(null);
  
      this.$wrapModel.fadeOut()
      this.$model.val(null);
  
      this.$wrapModel.fadeIn();        
    },

    onChangeModel(event){
      event.preventDefault();

      this.$btn.prop('disabled', true);
      this.$btn.hide();

      this.$wrapInsurer.fadeOut()
      this.$insurer.val(null).trigger('change.selectize')
  
      this.$wrapdateInsurance.fadeOut()
      this.$dateInsuranceMonth.val('')
      this.$dateInsuranceYear.val('')

      this.$wrapHasInsurance.fadeOut()
  
      this.$year.val(null).trigger('change.selectize')
      
      this.$wrapYear.fadeIn()
    },

    onChangeHasInsurance(event){
      event.preventDefault();
      const hasInsurance = $('input[name="has_insurance"]:checked').val();

      var insurer = $('[data-insurance-insurer]')[0].selectize;
      insurer.clearOptions();
      insurer.clear();

      this.$btn.prop('disabled', false);

      if ('Não' === hasInsurance) {
        this.$wrapInsurer.fadeOut()
        this.$insurer.val(null).trigger('change.selectize')
  
        this.$wrapdateInsurance.fadeOut()
        this.$dateInsuranceMonth.val('')
        this.$dateInsuranceYear.val('')

        this.$btn.show();
        this.$btn.text('Próxima etapa');

        this.$alert.addClass('sr-only');

        this.$btn.prop('disabled', false);
  
        return
      }      

      this.$wrapInsurer.fadeIn();

      this.$btn.prop('disabled', true);
      this.$btn.hide();

      this.$btn.text('Próxima etapa');
    },

    onChangeYear(event){
      event.preventDefault();
      this.$wrapHasInsurance.fadeIn();
      this.$btn.prop('disabled', true);
      this.$btn.hide();
    },   
    
    onChangeInsurer(event){
      event.preventDefault();

      this.$wrapdateInsurance.fadeIn();
      this.$btn.show();
      this.$btn.prop('disabled', false);
    },

    onChangeInsuranceMonth(event) {
      this.$btn.prop('disabled', false);
      event.preventDefault();
    },

    onChangeInsuranceYear(event) {
      this.$btn.prop('disabled', false);
      event.preventDefault();
    },

    customSelect() {
      var api = $('[data-sweet-api-url]').val() + '/api/seguroauto/v1/frontend';

      this.$brand.selectize({
        persist: 'false',
        valueField: 'id',
        labelField: 'brand_name',
        searchField: ['brand_name'],
        placeholder: 'Ex.: Volkswagen, Chevrolet, Citroen, etc...',
        maxOptions: 3,
        render: {
          option: function(item, escape) {
            return '<div>' + '&nbsp;&nbsp;&nbsp;&nbsp;' + '<span style="font-size:14px;">' + escape(item.brand_name) + '</span>' + '</div>';
          }
        },
        onChange: function(value){
          var model = $('[data-insurance-model]')[0].selectize;
          model.clearOptions();
          model.clear();
        },
        load: function(query, callback) {
          if (query.length < 3) return callback();
          $.ajax({
            url: api + '/brands?limit=50&like=brand_name,' + query,
            type: 'GET',
            dataType: 'json',
            error: function() {
              callback();
            },
            success: function(res) {
              callback(res.data);
            }
          });
        },
      });

      this.$model.selectize({
        persist: 'false',
        valueField: 'id',
        labelField: 'model_description',
        searchField: ['model_description'],
        placeholder: 'Ex.: Gol, Focus, Uno, etc...',
        maxOptions: 3,
        render: {
          option: function(item, escape) {
            return '<div>' + '&nbsp;&nbsp;&nbsp;&nbsp;' + '<span style="font-size:14px;">' + escape(item.model_description) +'</span>' + '</div>';
          }
        },
        onChange: function(value){
          var model = $('[data-insurance-year]')[0].selectize;
          model.clearOptions();
          model.clear();
        },        
        load: function(query, callback) {
          if (query.length < 3) return callback();
          $.ajax({
            url: api + '/vehicle-models?where[vehicle_type_id]=1&where[brand_id]=' + $('[data-insurance-brand]').val() + '&like=vehicle_model_name,' + query + '&limit=100',
            type: 'GET',
            dataType: 'json',
            error: function() {
              callback();
            },
            success: function(res) {
              var models = [];
              for (var i=0, n=res.data.length; i < n; i++) {
                var objectModels = {id: res.data[i].id, model_description: res.data[i].vehicle_model_name + ': ' + res.data[i].min_year + ' - ' + res.data[i].max_year};
                models.push(objectModels);
              }
              callback(models);
            }
          });
        },
      });

      this.$year.selectize({
        persist: 'false',
        valueField: 'id',
        labelField: 'year_description',
        searchField: ['year_description'],
        placeholder: 'Ex.: 1994, 2016, 2018, etc...',
        maxOptions: 3,
        render: {
          option: function(item, escape) {
            return '<div>' + '&nbsp;&nbsp;&nbsp;&nbsp;' + '<span style="font-size:14px;">' + escape(item.year_description) + '</span>' + '</div>';
          }
        },
        onChange: function(value){
          var hasInsurance = $('input[name="has_insurance"]:checked');
          hasInsurance.prop('checked', false);
        },
        load: function(query, callback) {
          if (query.length < 3) return callback();
          $.ajax({
            url: api + '/model-years?where[vehicle_model_id]=' + $('[data-insurance-model]').val() + '&limit=-1',
            type: 'GET',
            dataType: 'json',
            error: function() {
              callback();
            },
            success: function(res) {
              var years = [];
              for (var i=0, n=res.data.length; i < n; i++) {
                var objectYears = {id: res.data[i].id, year_description: res.data[i].year.year_description}
                years.push(objectYears);
              }
              callback(years);
            }
          });
        },
      });

      this.$insurer.selectize({
        persist: 'false',
        valueField: 'id',
        labelField: 'insurance_company_name',
        searchField: ['insurance_company_name'],
        placeholder: 'Ex.: Bradesco, Allianz, Porto Seguro, etc...',
        maxOptions: 3,
        render: {
          option: function(item, escape) {
            return '<div>' + '&nbsp;&nbsp;&nbsp;&nbsp;' + '<span style="font-size:14px;">' + escape(item.insurance_company_name) + '</span>' + '</div>';
          }
        },
        onChange: function(value){
          var mohtn = $('[data-date-insurance-month]')[0].selectize;
          var year  = $('[data-date-insurance-year]')[0].selectize;
          mohtn.clear();
          year.clear();
        },        
        load: function(query, callback) {
          if (query.length < 3) return callback();
          $.ajax({
            url: api + '/insurance-companys?like=insurance_company_name,' + query + '&limit=50',
            type: 'GET',
            dataType: 'json',
            error: function() {
              callback();
            },
            success: function(res) {
              callback(res.data);
            }
          });
        },        
      });

      this.$dateInsuranceMonth.selectize({
        persist: 'false',
        valueField: 'month_number',
        labelField: 'month_insurance',
        searchField: ['month_insurance'],
        placeholder: 'Ex.: Janeiro, Fevereiro, Março, etc...',
        maxOptions: 3,
        options: [
          {month_number: '01', month_insurance: 'Janeiro'},
          {month_number: '02', month_insurance: 'Fevereiro'},
          {month_number: '03', month_insurance: 'Março'},
          {month_number: '04', month_insurance: 'Abril'},
          {month_number: '05', month_insurance: 'Maio'},
          {month_number: '06', month_insurance: 'Junho'},
          {month_number: '07', month_insurance: 'Julho'},
          {month_number: '08', month_insurance: 'Agosto'},
          {month_number: '09', month_insurance: 'Setembro'},
          {month_number: '10', month_insurance: 'Outubro'},
          {month_number: '11', month_insurance: 'Novembro'},
          {month_number: '12', month_insurance: 'Dezembro'},
        ],
        render: {
          item: function(item, escape) {
            return '<span>' + escape(item.month_insurance) + '</span>'
          },
        },
      });

      this.$dateInsuranceYear.selectize({
        persist: 'false',
        valueField: 'year_number',
        labelField: 'year_insurance',
        searchField: ['year_insurance'],
        placeholder: 'Ex.: 2019, 2020, 2021, etc...',
        maxOptions: 3,
        options: [
          {year_number: '2018', year_insurance: '2018'},
          {year_number: '2019', year_insurance: '2019'},
          {year_number: '2020', year_insurance: '2020'},
          {year_number: '2021', year_insurance: '2021'},
        ],
        render: {
          item: function(item, escape) {
            return '<span>' + escape(item.year_insurance) + '</span>'
          },
        },
      });
    },

    onFormSubmit(event){
      event.preventDefault();

      this.$btn.prop('disabled', true);

      var hasInsurance = $('input[name="has_insurance"]:checked').val();
      
      if('Não' === hasInsurance){
        hasInsurance = false;

      } else {
       
        hasInsurance = true;
        if(('' == this.$insurer.val()) ||
           ('' == this.$dateInsuranceMonth.val()) ||
           ('' == this.$dateInsuranceYear.val())) {

          this.$alert.removeClass('sr-only');
          this.$alert.text('Por favor, informe a seguradora e a data de renovação corretamente.');
          
          this.$btn.prop('disabled', true);
          
          return;
        }
      }

      this.$btn.prop('disabled', true);

      const completedDate = this.$dateInsuranceMonth.val() + this.$dateInsuranceYear.val();

      this.$btn.prop('disabled', true);

      this.$alert.addClass('sr-only');
      
      var hasInsurance = 'Sim' === $('input[name="has_insurance"]:checked').val() ? true : false;

      const data = {
        _token          : this.token,
        hasInsurance    : hasInsurance,
        year            : $.trim($('[data-insurance-year]').val()),
        insurer         : $.trim($('[data-insurance-insurer]').val()),
        dateInsurance   : completedDate,
      };

      const saving = $.ajax({
        url: '/seguro-auto/step-two',
        dataType: 'json',
        method: 'POST',
        data: data,
      });

      saving.done($.proxy(this.onCreateSuccess, this));

      saving.fail($.proxy(this.onCreateFail, this));      

    },

    onCreateSuccess(data){
      if(false === data.data.data.customer_research_answer_has_insurance) {
        window.location.href = "/seguro-auto/research/";
        return;
      }

      window.location.href = "/seguro-auto/step-three/";
    },

    onCreateFail(error){
      this.$btn.prop('disabled', false);
      console.log(error);
    },

  }

  $(function () {
    StepTwo.start();
  });
})(jQuery);