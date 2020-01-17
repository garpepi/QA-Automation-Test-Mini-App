$(document).ready(function() {
  var id = 0;
  var role = '';
  
  var table = $('#dataTableTransactions').DataTable({
      "ajax": {
        "url":'/casetwo/datafetch',
        "dataSrc":function ( json ) {
                //Make your callback here.
                role = json.role;
                return json.data;
            }        
      },
      "order": [[ 0, "desc" ]],
      'columnDefs': [
      {
        "targets": 0, // your case first column
        "data":"id",
        "visible": false,
        "searchable": false
      },
      {
        "targets": 1,
        "data":"type",
        "className": "text-center",
        "render":function(data){
          if('plus' == data)
          {
            return '<i class="fas fa-plus text-success"></i>';
          }else{
            return '<i class="fas fa-minus text-danger"></i>';
          }
        }
      },
      {
        "targets": 2,
        "data":"amount",
        "className": "text-center",
        "render":function (data){
          return addCommas(data);
        }
      },
      {
        "targets": 3,
        "data":"description",
        "className": "text-center"
      },
      {
        "targets": 4,
        "data":"status",
        "render": function( data, type, full ) {
          if("Approved" == data)
          {
            return "<span class='text-success'>"+data+"</span>";
          }else if("Rejected" == data)
          {
            return "<span class='text-danger'>"+data+"</span>";
          }else{
            return "<span class='text-warning'>"+data+"</span>";
          }
        }
      },
      {
        "targets": -1,
        "render": function ( data, type, full ) {
          var buttonString = "";
          if('maker' == role)
          {
            buttonString = '<button class="btn btn-primary btn-icon-split editRow" '+('Pending' != full.status ? 'disabled' : "")+'>'
                      +'<span class="icon text-white">'
                        +'<i class="fas fa-edit"></i>'
                      +'</span>'
                      +'<span class="text text-white">Edit</span>'
                    +'</button>'
                    +'<button class="btn btn-danger btn-icon-split cancelRow" '+('Pending' != full.status ? 'disabled' : "")+' style="margin-left: 10px;">'
                      +'<span class="icon text-white">'
                        +'<i class="fas fa-trash"></i>'
                      +'</span>'
                      +'<span class="text text-white">Cancel</span>'
                    +'</button>';
          }else
          {
            buttonString = '<button class="btn btn-success btn-icon-split approveRow" '+('Pending' != full.status ? 'disabled' : "")+'>'
                      +'<span class="icon text-white">'
                        +'<i class="fas fa-check"></i>'
                      +'</span>'
                      +'<span class="text text-white">Approve</span>'
                    +'</button>'
                    +'<button class="btn btn-danger btn-icon-split rejectRow" '+('Pending' != full.status ? 'disabled' : "")+' style="margin-left: 10px;">'
                      +'<span class="icon text-white">'
                        +'<i class="fas fa-times"></i>'
                      +'</span>'
                      +'<span class="text text-white">Reject</span>'
                    +'</button>';
          }
           return buttonString;
        }
      }]
  });

  $('#dataTableTransactions tbody').on( 'click', 'tr td:not(:last-child)', function () {
    if('maker' == role)
    {
      var tr = $(this).closest('tr');
      var data = table.row( tr ).data();
      pushForm(data);
    }
  });
  
  $('#dataTableTransactions tbody').on( 'click', 'button.editRow', function () {
    var tr = $(this).closest('tr');
    var data = table.row( tr ).data();
    pushForm(data);
  });
  
  $('#dataTableTransactions tbody').on( 'click', 'button.cancelRow', function () {
    var tr = $(this).closest('tr');
    var data = table.row( tr ).data(); 
    id = data.id;
    $.ajax({    
        url: '/casetwo/makerDoCancel/'+id,
        success:function(data){
          //  json response
          successDiv(data.text);
          table.ajax.reload();
          id = 0;
          // Reset The Form
          $('#actionForm').trigger("reset");
          $('#collapseExample').collapse('hide');
        },
        error: function(data) { 
          // if error occured
          errorDiv(data.responseJSON);
        }
      });
  });
  
  $('#dataTableTransactions tbody').on( 'click', 'button.approveRow', function () {
    var tr = $(this).closest('tr');
    console.log( table.row( tr ).data() );
  });
  
  $('#dataTableTransactions tbody').on( 'click', 'button.rejectRow', function () {
    var tr = $(this).closest('tr');
    console.log( table.row( tr ).data() );
  });
  
  $('#newForm').click(function(){
    id = 0;
    // Reset The Form
    $('#actionForm').trigger("reset");
  });
  
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
          table.ajax.reload();
        },
        error: function(data) { 
          // if error occured
          errorDiv(data.responseJSON);
        }
      });
  });
  
  function errorDiv(message) {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
    console.log(jQuery.type(message.errorMessage));
    if('string' == jQuery.type(message.errorMessage))
    {
      let div = document.createElement("div");
        div.innerHTML = '<div class="alert alert-danger alert-dismissible show" role="alert">'
                +message.errorMessage
                +'<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                +'<span aria-hidden="true">&times;</span>'
              +'</button>'
            +'</div>';
        document.getElementById("all-alert-loc").appendChild(div);
    }else{
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
  
  function addCommas(nStr)
  {
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + ',' + '$2');
      }
      return x1 + x2;
  }
  
  function pushForm(data)
  {
    id = data.id;
    if(data.type == 'plus')
    {
      $('#addRadio').click(); 
    }else{
      $('#addExpense').click();
    }
    $('#amount').val(data.amount);
    $('#description').val(data.description);
    $('#status').val(data.status);
    
    $('#collapseExample').collapse('show');
  }



});


