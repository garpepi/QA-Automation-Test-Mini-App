$(document).ready(function() {
  var table = $('#dataTableTransactions').DataTable({
      'columnDefs': [
      {
        "targets": 0, // your case first column
        "visible": false,
        "searchable": false
      },
      {
        "targets": 1, // your case first column
        "className": "text-center"
      },
      {
        "targets": 5,
        "className": "text-left",
      }],
  });
  
  $('#dataTableTransactions tbody').on( 'click', 'tr', function () {
    console.log( table.row( this ).data() );
  });

});
