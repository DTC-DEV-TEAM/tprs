@extends('crudbooster::admin_template')
@section('content')

@if(g('return_url'))
	<p class="noprint"><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
@else
	<p class="noprint"><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
@endif

<div class='panel panel-default'>
    <div class='panel-heading'>
        Petty Cash Form
    </div>
        <form action='{{CRUDBooster::mainpath('edit-save/'.$Header->id)}}' method="POST" id="PettyCashForm" enctype="multipart/form-data">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            <div class='panel-body'>
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.location_id') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                <select class="form-control select2" style="width: 100%;" required name="location_id" id="location_id">
                                    <!--<option value="">-- Select Location --</option>-->
                                    @foreach($Location as $data)
                                    
                                        @if($Header->location_id == $data->id)
                                                <option value="{{$data->id}}" selected>{{$data->store_name}}</option>
                                            @else
                                                <option value="{{$data->id}}" >{{$data->store_name}}</option>
                                        @endif
                                        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.requestor_name') }}</label>
                                <input type="text" class="form-control"  id="requestor_name" name="requestor_name"  required value="{{$Header->requestor_name}}">                                   
                            </div>
                    </div>
                    
                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.department_id') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                    <select class="form-control select2" style="width: 100%;" required name="department_id" id="department_id">
                                        <!--<option value="">-- Select Department --</option>-->
                                        @foreach($Departments as $data)
                                        
                                        @if($Header->department_id == $data->id)
                                                <option value="{{$data->id}}" selected >{{$data->department_name}}</option>
                                            @else
                                                <option value="{{$data->id}}" >{{$data->department_name}}</option>
                                        @endif
                                        
                                            
                                            
                                        @endforeach
                                    </select>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.sub_department_id') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                    <select class="form-control select2" style="width: 100%;" required name="sub_department_id" id="sub_department_id">
                                        <option value="">-- Select Sub Department --</option>
                                        @foreach($SubDepartments as $data)
                                        @if($Header->sub_department_id == $data->id)
                                                <option value="{{$data->id}}" selected >{{$data->sub_department_name}}</option>   
                                            @else
                                                <option value="{{$data->id}}" >{{$data->sub_department_name}}</option>
                                        @endif
                                            
                                        @endforeach
                                    </select>
                            </div>
                        </div>
                    </div>


                </div>
                    <hr/>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="box-header text-center">
                            <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <div class="container">
                                        <div class="hack1" style="  display: table;
                                        table-layout: fixed;
                                        width: 130%;">
                                        <div class="hack2" style="  display: table-cell;
                                        overflow-x: auto;
                                        width: 130%;"> 
                                        <table class="table table-bordered" id="requestTable" style="  width: 130%;
                                        border-collapse: collapse;">
                                        <tbody id="bodyTable">

                                            <tr class="tbl_header_color dynamicRows">
                                                <th width="20%" class="text-center">{{ trans('message.table.particulars_text') }}</th>
                                                <th width="12%" class="text-center">{{ trans('message.table.brand_id_text') }}</th>
                                                <th width="12%" class="text-center">{{ trans('message.table.category_id_text') }}</th>
                                                <th width="22%" class="text-center">{{ trans('message.table.account_id_text') }}</th>
                                                <th width="9%" class="text-center">{{ trans('message.table.currency_id_text') }}</th>
                                                <th width="7%" class="text-center">{{ trans('message.table.quantity_text') }}</th>
                                                <th width="8%" class="text-center">{{ trans('message.table.line_value_text') }}</th>
                                                <th width="15%" class="text-center">{{ trans('message.table.total_value_text') }}</th>
                                                <th width="" class="text-center">{{ trans('message.table.action') }}</th>
                                            </tr>

                                            <tr id="tr-table">
                                                 <?php   $tableRow = 1; ?>
                                                <tr>
                                                    @foreach($Body as $rowresult)

                                                        <?php   $tableRow++; ?>

                                                        <tr>

                                                            <td >
                                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="{{$tableRow}}" id="itemDesc{{$tableRow}}"  name="particulars[]"  required maxlength="100" value="{{$rowresult->particulars}}">
                                                            </td>



                                                            <td>
                                                                <select class="form-control" name="brand_id[]" id="brand_id" required>
                                                                    <option value="">-Please Select Brand-</option>
                                                                        @foreach($Brands as $data)
                                                                            @if($rowresult->brand_id == $data->id)
                                                                                    <option selected value="{{$data->id}}">{{$data->brand_name}}</option>
                                                                                @else
                                                                                    <option value="{{$data->id}}">{{$data->brand_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                </select> 
                                                            </td>

                                                            <td>
                                                                <select class="form-control drop{{$tableRow}}"  data-id="{{$tableRow}}"  name="category_id[]" id="category_id" required>
                                                                            <option value="">-Please Select Category-</option>
                                                                        @foreach($Categories as $data)
                                                                            @if($rowresult->category_id == $data->id)
                                                                                    <option selected value="{{$data->id}}">{{$data->category_name}}</option>
                                                                                @else
                                                                                    <option value="{{$data->id}}">{{$data->category_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <input type="hidden"  class="form-control"  name="item_id[]"  required  value="{{$rowresult->id}}">
                                                                <input type="hidden"  class="form-control"  name="item_action[]" id="item_action{{$rowresult->id}}"  required  value="EDIT">
                                                                
                                                                <select class="form-control account{{$tableRow}}" name="account_id[]" id="account_id" required>
                                                                    <option value="">-Please Select Account-</option>
                                                                        @foreach($Accounts->where('category_id', $rowresult->category_id) as $data)
                                                                            @if($rowresult->account_id == $data->id)
                                                                                    <option selected value="{{$data->id}}">{{$data->account_name}}</option>
                                                                                @else
                                                                                    <option value="{{$data->id}}">{{$data->account_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                </select>                                                           
                                                            </td>



                                                            <td>
                                                                <select class="form-control" name="currency_id[]" id="currency_id" required>
                                                                    <option value="">-Please Select Brand-</option>
                                                                        @foreach($Currencies as $data)
                                                                            @if($rowresult->currency_id == $data->id)
                                                                                    <option selected value="{{$data->id}}">{{$data->currency_name}}</option>
                                                                                @else
                                                                                    <option value="{{$data->id}}">{{$data->currency_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                </select> 
                                                            </td>

                                                            <td>
                                                                <input type="number" class="form-control quantity text-center" data-id="{{$tableRow}}" id="quantity{{$tableRow}}" step="any" name="quantity[]" min="0" required maxlength="100" value="{{$rowresult->quantity}}">
                                                            </td>   
                                                            
                                                            <td>
                                                                <input type="number" class="form-control vvalue text-center" data-id="{{$tableRow}}" id="value{{$tableRow}}" name="line_value[]" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" required maxlength="100" value="{{$rowresult->line_value}}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control totalV text-center" id="totalValue{{$tableRow}}" name="total_value[]" readonly="readonly" step="0.01" required maxlength="100" value="{{$rowresult->total_value}}">
                                                            </td>

                                                            <td>


                                                                <button id="deleteRow" name="removeRow" class="btn btn-danger removeRow"  data-id="{{$rowresult->id}}" ><i class="glyphicon glyphicon-trash"></i></button>
                                                            </td>                            
                                                        </tr>
                                                    @endforeach
                                
                                                </tr>
                                                
                                            </tr>

                                        </tbody>

                                        <tfoot>

                                            <tr id="tr-table1" class="bottom">

                                                <td>
                                                    <input type="button" id="add-Row" name="add-Row" class="btn btn-primary add" value='Add' />
                                                </td>

                                                <td colspan="6" align="right"><strong>{{ trans('message.table.total_value_order_text') }}</strong></td>
                                                <td align="left" colspan="1">
                                                    <input type='text' name="total_value_order" class="form-control text-center" id="tValue2" readonly value="{{$Header->total_value_order}}"></td>
                                                </td>
                                               
                                            </tr>

                                        </tfoot>
                                    
                                    </table>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                
                        </div>
                
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('message.table.note') }}</label>
                                <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" class="form-control" name="requestor_comments">{{$Header->requestor_comments}}</textarea>
                            </div>
                        </div>
                
                    </div>

                    <hr/>
                    <div class="row">  
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('message.table.approver_comments') }}:</label>
                                <p>{{ $Header->approver_comments }}</p>
                            </div>
                        </div>
                    </div>

            </div>

            <div class='panel-footer'>
                <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>
                <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save" ></i> {{ trans('message.form.save') }}</button>
            </div>
        </form>
</div>
@endsection

@push('bottom')
<script type="text/javascript">


$('#customer_location_id').change(function() {
    
    var customer_location_id = this.value;
    

        $.ajax
            ({ 
                url: "{{ URL::to('/customer_location_id')}}",
                type: "POST",
                data: {
                    'customer_location_id': customer_location_id,
                    _token: '{!! csrf_token() !!}'
                    },
                success: function(result)
                {
                   
                    var i;
                    var showData = [];
          
                    //showData[0] = "<option value='' selected disabled>-Please Select Account-</option>";
                    for (i = 0; i < result.length; ++i) {
                        var j = i + 1;
                        if(result[i].location_name == null || result[i].location_name == ""){
                            showData[i] = "<option value=''></option>";
                        }else{
                            showData[i] = "<option value='"+result[i].locationid+"'>"+result[i].location_name+"</option>";
                        }
                        
                    }
                    //$('.account'+id_data).find('option').remove();
                    jQuery('#location_id').html(showData);               
                }
        });
    
});

$('#requestor_name').keyup(function() {
	this.value = this.value.toLocaleUpperCase();
});

  function preventBack() {
    window.history.forward();
  }
  window.onunload = function() {
    null;
  };
  setTimeout("preventBack()", 0);


  var tableRow = <?php echo json_encode($tableRow); ?>;
  $(document).ready(function() {


    $("#add-Row").click(function() {
      tableRow++;
      var newrow = '<tr>' +
        '<td>' +
        '  <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="' + tableRow + '" id="itemDesc' + tableRow + '"  name="particulars_add[]"  required maxlength="100">' +
        '</td>' +

        '<td>'+
            '<select class="form-control" name="brand_id_add[]" id="brand_id_add" required>' +
            '  <option value="">-Please Select Brand-</option>' +
            '        @foreach($Brands as $data)'+
            '        <option value="{{$data->id}}">{{$data->brand_name}}</option>'+
            '         @endforeach'+
            '</select>'+   
        '</td>'+

        '<td>'+
        '<select class="form-control drop'+ tableRow + '" name="category_id_add[]" data-id="' + tableRow + '"  id="category_id" required>' +
        '  <option value="">-Please Select Category-</option>' +
        '        @foreach($Categories as $data)'+
        '        <option value="{{$data->id}}">{{$data->category_name}}</option>'+
        '         @endforeach'+
        '</select>'+
        '</td>' +

        '<td>'+
            '<input type="hidden"  class="form-control"  name="add_items"  required  value="0">'+ 
            '<input type="hidden"  class="form-control"  name="item_action[]" id="item_action' + tableRow + '"  required  value="ADD">'+

            '<select class="form-control account'+ tableRow + '" name="account_id_add[]" id="account_id_add" required>' +

            '</select>'+            
        '</td>'+

        '<td>'+
            '<select class="form-control" name="currency_id_add[]" id="currency_id_add" required>' +
            '  <option value="">-Please Select Currency-</option>' +
            '        @foreach($Currencies as $data)'+
            '        <option value="{{$data->id}}">{{$data->currency_name}}</option>'+
            '         @endforeach'+
            '</select>'+ 
        '</td>'+



        '<td>' +
        '  <input type="number" class="form-control quantity text-center" data-id="' + tableRow + '" id="quantity' + tableRow + '" step="any" name="quantity_add[]" min="0" required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="number" class="form-control vvalue text-center" data-id="' + tableRow + '" id="value' + tableRow + '" name="line_value_add[]" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="text" class="form-control totalV text-center" id="totalValue' + tableRow + '" name="total_value_add[]" readonly="readonly" step="0.01" required maxlength="100">' +
        '</td>' +
        '<td>' +


        '<button id="deleteRow" name="removeRow1" class="btn btn-danger removeRow1" data-id="' + tableRow + '" ><i class="glyphicon glyphicon-trash"></i></button>' +
        '</td>' +
        '</tr>';
      $(newrow).insertBefore($('table tr#tr-table1:last'));

        $('.account'+tableRow).prop("disabled", true);

        $('.drop'+tableRow).change(function(){
            
            var category = this.value;
            var id_data = $(this).attr("data-id");

            $('.account'+id_data).prop("disabled", false);

            $.ajax
            ({ 
                url: "{{ URL::to('/category')}}",
                type: "POST",
                data: {
                    'category': category,
                    _token: '{!! csrf_token() !!}'
                    },
                success: function(result)
                {
                    var i;
                    var showData = [];

                    showData[0] = "<option value='' selected disabled>-Please Select Account-</option>";
                    for (i = 1; i < result.length; ++i) {
                        var j = i + 1;
                        showData[i] = "<option value='"+result[i].id+"'>"+result[i].account_name+"</option>";
                    }
                    //$('.account'+id_data).find('option').remove();
                    jQuery('.account'+id_data).html(showData);               
                }
            });

        });
    });
    //deleteRow
    $(document).on('click', '.removeRow', function() {

      var RowID = $(this).attr("data-id");
    
      //alert($('#item_action'+RowID).val());

      if($('#item_action'+RowID).val() == "EDIT"){

                    var token = $("#token").val();

                    
                    
                        $.ajax({
                        type: "POST",
                        url: "{{route('delete-petty-cash-request')}}",
                        dataType: "JSON",
                        data: {
                            "_token": token,
                            "row_id": RowID,
                        
                        },
                        success: function(data) {
                            //alert(data);
                        },
                        error: function(xhr, status, error) {
                            //alert(error);
                        }
                        });
      }

      if ($('#requestTable tbody tr').length != 1) { //check if not the first row then delete the other rows

        $(this).closest('tr').remove();
        $("#tQuantity").val(calculateTotalQuantity());
        $("#tValue2").val(calculateTotalValue2());
        return false;
      }


    });



    $(document).on('click', '.removeRow1', function() {

        var RowID = $(this).attr("data-id");

        //alert($('#item_action'+RowID).val());


        if ($('#requestTable tbody tr').length != 1) { //check if not the first row then delete the other rows

        $(this).closest('tr').remove();
        $("#tQuantity").val(calculateTotalQuantity());
        $("#tValue2").val(calculateTotalValue2());
        return false;
        }


    });

  });

  function setTwoNumberDecimal(el) {
    el.value = parseFloat(el.value).toFixed(2);

  };

  $(document).on('keyup', '.quantity', function(ev) {

var id = $(this).attr("data-id");
var rate = parseFloat($(this).val());
var qty = $("#value" + id).val();



var price = calculatePrice(rate, qty).toFixed(2); // this is for total Value in row

$("#totalValue" + id).val(price);
$("#tQuantity").val(calculateTotalQuantity());
$("#tValue").val(calculateTotalValue());
$("#tValue2").val(calculateTotalValue2());


});

$(document).on('keyup', '.vvalue', function(ev) {

var id = $(this).attr("data-id");
var rate = parseFloat($(this).val());
var qty = $("#quantity" + id).val();
var price = calculatePrice(qty, rate).toFixed(2); // this is for total Value in row

$("#totalValue" + id).val(price);
$("#tQuantity").val(calculateTotalQuantity());
$("#tValue").val(calculateTotalValue());
$("#tValue2").val(calculateTotalValue2());
});


function calculateTotalValue2() {
var totalQuantity = 0;
var newTotal = 0;
$('.totalV').each(function() {
  totalQuantity += parseFloat($(this).val());

});
newTotal = totalQuantity.toFixed(2);
return newTotal;
}

function calculateTotalQuantity() {
var totalQuantity = 0;
$('.quantity').each(function() {
  totalQuantity += parseFloat($(this).val());
});
return totalQuantity;
}

function calculateTotalValue() {
var totalQuantity = 0;
$('.value').each(function() {
  totalQuantity += parseFloat($(this).val().toFixed(2));
});
return totalQuantity;
}

function calculatePrice(qty, rate) {
if (qty != 0) {
  var price = (qty * rate);
  return price;
} else {
  return '0';
}
}

$(document).ready(function() {
    $("#PettyCashForm").submit(function() {
      $("#btnSubmit").attr("disabled", true);
      return true;
    });
});


$("#btnSubmit").click(function(event) {

    var countRow = $('#requestTable tr').length - 4;
    // var value = $('.vvalue').val();
  
    if (countRow == 0) {
        alert("Please add an item!");
        event.preventDefault(); // cancel default behavior
    }

    var qty = 0;
    $('.quantity').each(function() {
    qty = $(this).val();
    if (qty == 0) {
        alert("Quantity cannot be empty or zero!");
        event.preventDefault(); // cancel default behavior
    } else if (qty < 0) {
        alert("Negative Value is not allowed!");
        event.preventDefault(); // cancel default behavior
    }
    });

    var lineval = 0;
    $('.vvalue').each(function() {
    lineval = $(this).val();
    if (lineval < 0) {
        alert("Negative Value is not allowed!");
        event.preventDefault(); // cancel default behavior
    }
    });

    if($("#tValue2").val() > 1000 ){
        alert("Below 1000 total value is valid !!");
        event.preventDefault();
    }
    
});



$('.drop').change(function(){
            
            var category = this.value;
            var id_data = $(this).attr("data-id");

            $('.account'+id_data).prop("disabled", false);

            $.ajax
            ({ 
                url: "{{ URL::to('/category')}}",
                type: "POST",
                data: {
                    'category': category,
                    _token: '{!! csrf_token() !!}'
                    },
                success: function(result)
                {
                    var i;
                    var showData = [];

                    showData[0] = "<option value='' selected disabled>-Please Select Account-</option>";
                    for (i = 1; i < result.length; ++i) {
                        var j = i + 1;
                        showData[i] = "<option value='"+result[i].id+"'>"+result[i].account_name+"</option>";
                    }
                    //$('.account'+id_data).find('option').remove();
                    jQuery('.account'+id_data).html(showData);               
                }
            });

});

</script>
@endpush