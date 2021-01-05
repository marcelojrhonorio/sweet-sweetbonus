(function($) {
  const AlfaconResults = {
    start: function () {

      this.$table = $('[data-result-table]');
      this.$datatable = null;

      this.$html = '';

      this.dataTable();
      this.bind();
    },

    bind: function () {
      this.$table.on('click', '[data-customer-answer]', $.proxy(this.onBtnResponsesClick, this));
    },

    dataTable: function () {
      this.$datatable = this.$table.DataTable({
        processing: true,
        serverSide: true,
        pageLength: 25,
        searching: false,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [],
        language: {
          url: 'https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json',
        },
        ajax: {
          url: '/alfacon/results/search',
        },
        columns: [
          {
            data: 'id',
            width: '5%',
          },
          {
            data: 'fullname',
          },
          {
            data: 'email',
          },
          {
            data: 'ddd',
          },
          {
            data: 'phone_number',
          },
          {
            data: 'site_origin',
          },
          {
            data: 'response',
          },
          {
            data: 'created_at',
          },
          {
            data: 'email',
            render: function(data, type, full, meta) {
                data = '<a href="#" data-customer-answer data-email='+ data +'>' + 'ver respostas' + '</a>';
                return data;
            }
          },
        ],
      });
    },

    onBtnResponsesClick: function(event) {
      event.preventDefault();

      const $btn  = $(event.currentTarget);
      const email = $.trim($btn.data('email'));

      $.ajax({
        method: 'GET',
        url: `/alfacon/results/search-research/${email}`,
        cache      : false,
        dataType   : 'json',
        contentType: false,
        processData: false,
        headers: {
          'X-XSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result){
          const html = AlfaconResults.renderAnswersQuestions(result.data);
          Swal.fire({
            title: 'Resposta da pesquisa.',
            html: html,
            width: 600,
            showConfirmButton: false,
            onClose: () => {
              AlfaconResults.$html = '';
            }
          })
        }
      });      
    },

    renderAnswersQuestions: function (result) {
      $.each(result, function (index, valueQuestion) {
        AlfaconResults.$html = AlfaconResults.$html + ("<br><h5 align='left'><strong>"+valueQuestion.question+"</strong></h5>");
        AlfaconResults.renderAnswersOptions(valueQuestion);
      });
      const htmlData = AlfaconResults.$html;
      return htmlData;
    },

    renderAnswersOptions: function (question) {
      $.each(question.options, function (index, valueOption) {
        AlfaconResults.$html = AlfaconResults.$html + ("<h6 align='left'>R. "+valueOption+"</h6>");
      });
    },

  };

  $(function() {
    AlfaconResults.start();
  });
})(jQuery);