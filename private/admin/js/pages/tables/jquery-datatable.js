$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
          //'copy', 'csv', 'excel', 'pdf', 'print'
            {
              extend: 'copy',
              exportOptions: {
                columns: 'th:not(:last-child)'
              }
            },
            {
              extend: 'csv',
              exportOptions: {
                columns: 'th:not(:last-child)'
              }
            },
            {
              extend: 'excel',
              exportOptions: {
                columns: 'th:not(:last-child)'
              }
            },
            {
              extend: 'pdf',
              exportOptions: {
                columns: 'th:not(:last-child)'
              }
            },
            {
              extend: 'print',
              exportOptions: {
                columns: 'th:not(:last-child)'
              }
            }
        ]
    });
});
