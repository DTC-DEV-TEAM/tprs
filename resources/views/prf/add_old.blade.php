@extends('crudbooster::admin_template')
@push('head')
<style type="text/css">   
#image_preview {
    display: none;
}
</style>
@endpush
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
        <form action="{{ CRUDBooster::mainpath('add-save') }}" method="POST" id="PettyCashForm" enctype="multipart/form-data">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
            <div class='panel-body'>


               <table width="100%"> 
                    <tr >
                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.department_id') }}</label>
                            
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                        <select class="form-control select2" style="width: 90%;" required name="department_id" id="department_id">
                                            <option value="">-- Select Department --</option>
                                            @foreach($Departments as $data)
                                                <option value="{{$data->id}}">{{$data->department_name}}</option>
                                            @endforeach
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td rowspan="3" style="vertical-align: top;" height="310px">
                                <div class="form-group">
                                    <label class="control-label require">*{{ trans('message.form-label.receipt') }}</label>
                                    <div class="input-group date">
                                      <!--  <div class="input-group-addon"><i class="fa fa-file-image-o"></i></div> -->
                                        <input type="file" name="receipt" id="image" class="image" style="width:200px;" required accept="image/*">
                                        <div id="image_preview">
                                            <img src="#" id="image-preview" style="width:200px;height:250px;" /><br />
                                            <a id="image_remove" href="#">Remove</a>
                                        </div>
                                     
                                    </div>
                                </div>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.sub_department_id') }}</label>
                                
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                        <select class="form-control select2" style="width: 90%;" required name="sub_department_id" id="sub_department_id">
                                            <option value="">-- Select Sub Department --</option>
                                            @foreach($SubDepartments as $data)
                                                <option value="{{$data->id}}">{{$data->sub_department_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </td>
                      

                    </tr>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.location_id') }}</label>
                                
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                    <select class="form-control select2" style="width: 90%;" required name="location_id" id="location_id">
                                        <option value="">-- Select Location --</option>
                                        @foreach($Locations as $data)
                                            <option value="{{$data->id}}">{{$data->store_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>

                <hr/>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="box-header text-center">
                            <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="requestTable">
                                        <tbody id="bodyTable">

                                            <tr class="tbl_header_color dynamicRows">
                                                <th width="33%" class="text-center">{{ trans('message.table.category_id_text') }}</th>
                                                <th width="30%" class="text-center">{{ trans('message.table.particulars_text') }}</th>
                                                <th width="8%" class="text-center">{{ trans('message.table.quantity_text') }}</th>
                                                <th width="12%" class="text-center">{{ trans('message.table.line_value_text') }}</th>
                                                <th width="12%" class="text-center">{{ trans('message.table.total_value_text') }}</th>
                                                <th width="5%" class="text-center">{{ trans('message.table.action') }}</th>
                                            </tr>

                                            <tr id="tr-table">
                                                <tr>
                                
                                                </tr>
                                            </tr>

                                        </tbody>

                                        <tfoot>

                                            <tr id="tr-table1" class="bottom">

                                                <td>
                                                    <input type="button" id="add-Row" name="add-Row" class="btn btn-primary add" value='Add' />
                                                </td>

                                                <td colspan="3" align="right"><strong>{{ trans('message.table.total_value_order_text') }}</strong></td>
                                                <td align="left" colspan="1">
                                                    <input type='text' name="total_value_order" class="form-control text-center" id="tValue2" readonly></td>
                                                </td>
                                                <td colspan="1"></td>
                                            </tr>

                                        </tfoot>
                                    
                                    </table>
                                </div>
                                <br>
                            </div>
                
                        </div>
                
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('message.table.note') }}</label>
                                <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" class="form-control" name="requestor_comments"></textarea>
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

  function preventBack() {
    window.history.forward();
  }
  window.onunload = function() {
    null;
  };
  setTimeout("preventBack()", 0);


   var tableRow = 1;
  $(document).ready(function() {


    $("#add-Row").click(function() {
      tableRow++;
      var newrow = '<tr>' +
        '<td><div class="input-group date"><div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>'+
        '<select class="form-control" name="category_id[]" id="category_id" required>' +
        '  <option value="">-Please Select Category-</option>' +
        '        @foreach($Categories as $data)'+
        '        <option value="{{$data->id}}">{{$data->category_name}}</option>'+
        '         @endforeach'+
        '</select></div></td>' +
        '<td >' +
        '  <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="' + tableRow + '" id="itemDesc' + tableRow + '"  name="particulars[]"  required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="number" class="form-control quantity text-center" data-id="' + tableRow + '" id="quantity' + tableRow + '" step="any" name="quantity[]" min="0" required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="number" class="form-control vvalue text-center" data-id="' + tableRow + '" id="value' + tableRow + '" name="line_value[]" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="text" class="form-control totalV text-center" id="totalValue' + tableRow + '" name="total_value[]" readonly="readonly" step="0.01" required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="button" id="deleteRow" name="removeRow" class="btn btn-danger removeRow" value="Delete" />' +
        '</td>' +
        '</tr>';
      $(newrow).insertBefore($('table tr#tr-table1:last'));

    });
    //deleteRow
    $(document).on('click', '.removeRow', function() {

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

    var countRow = $('#requestTable tfoot tr').length;
    // var value = $('.vvalue').val();
    if (countRow == 1) {
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

    if($("#tValue2").val() < 1000 ){
        alert("Above 1000 total value is valid !!");
        event.preventDefault();
    }
});


jQuery( document ).delegate('#image', 'change', function() {
    ext = jQuery(this).val().split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
        resetFormElement(jQuery(this));
        window.alert('Not an image!');
    } else {
        var reader = new FileReader();
        var image_holder = jQuery("#"+jQuery(this).attr('class')+"-preview");
        image_holder.empty();

        reader.onload = function (e) {
            jQuery(image_holder).attr('src', e.target.result);
        }

        reader.readAsDataURL((this).files[0]);
        jQuery('#image_preview').slideDown();
        jQuery(this).slideUp();
    }
});

jQuery('#image_preview a').bind('click', function () {
    resetFormElement(jQuery('#image')   );
    jQuery('#image').slideDown();
    jQuery(this).parent().slideUp();
    return false;
});

function resetFormElement(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}

</script>
@endpush