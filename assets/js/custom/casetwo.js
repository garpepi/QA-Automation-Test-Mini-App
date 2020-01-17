$(document).ready(function() {
  var id = 0;
  
  var table = $('#dataTableTransactions').DataTable({
      "ajax": '/casetwo/datafetch',
      "columns": [
        { "data": "id" },
        { "data": "type" },
        { "data": "amount" },
        { "data": "description" },
        { "data": "status" },
        { "data": null }
      ],
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
      },
      {
            "targets": -1,
            "data": null,
            "defaultContent": "<button>Click!</button>"
      }],
  });
  
  $('#dataTableTransactions tbody').on( 'click', 'tr', function () {
    console.log( table.row( this ).data() );
  });

 $("#target").on("click", function(){ alert('sasas');});
  
  $('#actionForm').submit(function(event){
      // cancels the form submission
      event.preventDefault();

      // do whatever you want here
      var data = $('#actionForm').serializeArray();
      $.ajax({    
        type: 'POST',  
        url: '/casetwo/makerDoPost',  
        data:data,  
        dataType:'json',
         beforeSend:function(xhr, settings){
         settings.data += '&id='+id;
         },
        success:function(data){
          //  json response
          successDiv(data.text);
        },
        error: function(data) { 
          // if error occured
          errorDiv(data.responseJSON);
        }
      });
  });
  
  function errorDiv(message) {
    console.log(message.errorMessage);
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
    jQuery.each(message.errorMessage, function(i, val) {
      let div = document.createElement("div");
      div.innerHTML = '<div class="alert alert-danger alert-dismissible show" role="alert">'
              +val
              +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
              +'<span aria-hidden="true">&times;</span>'
            +'</button>'
          +'</div>';
      document.getElementById("all-alert-loc").appendChild(div);
    });
    
  }
  
  function successDiv(message = '') {
    let div = document.createElement("div");
    div.innerHTML = '<div class="alert alert-success alert-dismissible show" role="alert">'
            +message
            +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
            +'<span aria-hidden="true">&times;</span>'
          +'</button>'
        +'</div>';
    document.getElementById("all-alert-loc").appendChild(div);
    
    // Reset The Form
    $('#actionForm').trigger("reset");
    
    // Collaps the Form
    $('#collapseExample').collapse('hide');
    
    window.setTimeout(function() {
      $(".alert-success").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove(); 
      });
    }, 2000);
  }
  
  function clearFormAlert(){
    $(".alert").alert('close');
  }



});


