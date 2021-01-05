(function($) {
    const XMoveCarResults = {
        start: function() {

            this.$table       = $('[data-xmove-table]');
            this.$datatable   = null;  

            this.dataTable();
            this.bind();
        },  

        bind: function() {
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
                url: '/xmove-car/search',
              },
              columns: [
                {
                  data: 'id',
                  width: '5%',
                },
                {
                  data: 'name',
                },
                {
                  data: 'email',
                },
                {
                  data: 'phone',
                },
                {
                  data: 'cell_phone',
                },
              ],
            });
        },
    };

$(function() {
    XMoveCarResults.start();
  });
})(jQuery);