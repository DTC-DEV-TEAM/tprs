<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@push('head')
<style type="text/css">
  #image_preview {
    display: none;
    width: 200px;
  }

  #requestTable td,
  #requestTable th {
    border: 1px solid #ddd;
    padding: 8px;
  }

  #requestTable tr:nth-child(even) {
    background-color: #f2f2f2;
  }

  #requestTable tr:hover {
    background-color: #ddd;
  }

  #requestTable th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #222d32;
    color: white;
  }

  .nbsp {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #222d32;
    color: white;
  }

  thead {
    // Accessibly hide <thead> on narrow viewports
    position: absolute;
    clip: rect(1px 1px 1px 1px);
    /* IE6, IE7 */
    padding: 0;
    border: 0;
    height: 1px;
    width: 1px;
    overflow: hidden;

    @media (min-width: $bp-bart) {
      // Unhide <thead> on wide viewports
      position: relative;
      clip: auto;
      height: auto;
      width: auto;
      overflow: auto;
    }

    th {
      background-color: rgba(29, 150, 178, 1);
      border: 1px solid rgba(29, 150, 178, 1);
      font-weight: normal;
      text-align: center;
      color: white;

      &:first-of-type {
        text-align: left;
      }
    }
  }

  // Set these items to display: block for narrow viewports
  tbody,
  tr,
  th,
  td {
    display: block;
    padding: 0;
    text-align: left;
    white-space: normal;
  }

  tr {
    @media (min-width: $bp-bart) {
      // Undo display: block 
      display: table-row;
    }
  }

  th,
  td {
    padding: .5em;
    vertical-align: middle;

    @media (min-width: $bp-lisa) {
      padding: .75em .5em;
    }

    @media (min-width: $bp-bart) {
      // Undo display: block 
      display: table-cell;
      padding: .5em;
    }

    @media (min-width: $bp-marge) {
      padding: .75em .5em;
    }

    @media (min-width: $bp-homer) {
      padding: .75em;
    }
  }

  caption {
    margin-bottom: 1em;
    font-size: 1em;
    font-weight: bold;
    text-align: center;

    @media (min-width: $bp-bart) {
      font-size: 1.5em;
    }
  }

  tfoot {
    font-size: .8em;
    font-style: italic;

    @media (min-width: $bp-marge) {
      font-size: .9em;
    }
  }

  tbody {
    @media (min-width: $bp-bart) {
      // Undo display: block 
      display: table-row-group;
    }

    tr {
      margin-bottom: 1em;

      @media (min-width: $bp-bart) {
        // Undo display: block 
        display: table-row;
        border-width: 1px;
      }

      &:last-of-type {
        margin-bottom: 0;
      }

      &:nth-of-type(even) {
        @media (min-width: $bp-bart) {
          background-color: rgba(94, 93, 82, .1);
        }
      }

      .button {
        background-color: #008CBA;
        /* Blue */
        border: none;
        color: white;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
      }

      #addRow {
        background-color: #4CAF50;
        /* Green */
        border: none;
        color: white;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
      }

      #deleteRow {
        background-color: #f44336;
        /* RED */
        border: none;
        color: white;
        padding: 10px 15px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
      }

      .requestB {
        background-color: white;
        color: black;
        border: 2px solid #008CBA;
      }

      .requestB:hover {
        background-color: #008CBA;
        color: white;
      }
</style>
@endpush
@section('content')
<!-- Your html goes here -->
<div class='panel panel-default'>
  <div class='panel-body'>
  <h4 style="color: red"><b>Request Version: {{$datas[0]->version}}</b></h4>

   


      <!-- <meta name="csrf-token" content="{{ csrf_token() }}" /> -->


      <div class='form-group'>

        <div class="col-md-12" style="border-bottom: 2px solid black;">
          <div class="col-md-4">

          </div>
          <div class="col-md-4">
            <h1 style="text-align: center;" class="col-md-12"><strong>RECEIPT FORM</strong></h1>
          </div>

          <div class="col-md-4">

          </div>
        </div>
      </div>
      <br><br><br>
      <br>

      <div class="row">

        <div class="col-md-8">
         
          <h4><b>STORES:</b></h4>
          <select name="store" class="form-control col-md-">
            <!-- <option value="-----">-Please Select Store-</option> -->

            <option selected value="{{$store_names->store_name}}">{{$store_names->store_name}}</option>



            <!-- <h1 style="text-align: center;"><strong>{{$store_names->store_name}}</strong></h1> -->

          </select>

          <h4><b>Invoice #:</b></h4>
          <div class="form-group">

            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-hashtag"></i></div>
              <input type="text" readonly name="invoice_number" id="invoice" value="{{$datas[0]->invoice_no}}" class="form-control col-md-12" required>
            </div>
          </div>
        </div>
        </div>
        
        <div class="col-md-4">
          <h4><b>Invoice Date:</b></h4>
          <div class="form-group">

            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>

              <input type="date" name="dateReceipt" class="form-control col-md-6" readonly value="{{$datas[0]->date_receipt}}">
            </div>
          </div>
        </div>

      </div>

      <!-- end receipt form -->
      <div class="row">
      <div class="col-md-8">
          <table id="requestTable" class="table table-bordered
                    table-condensed table-striped">
            <thead>
              <tr>
              <th width="30%">Category</th>
                <th width="30%">Item Description</th>
                <th width="10%">Qty</th>
                <th width="15%">Value</th>
                <th width="15%">Total Value</th>
           
            
              </tr>
              @foreach($datas as $data)
              <tr>
                <td>
            

                    <!-- <option value="-----">-Please Select Category-</option> -->
                    <input type="hidden" class="form-control" name="requested_by" value="{{$data->requested_by}}">
                    <input type="hidden" class="form-control" name="referencenumberTF" value="{{$data->reference_number}}">
                    <input type="hidden" class="form-control" name="storeTF" value="{{$data->store_id}}">
                    <input type="text" class="form-control" name="categorydescriptionTF" readonly value="{{$data->category_description}}" required maxlength="100">

              

                </td>
                <td>
                
                    <input type="text" class="form-control" name="itemdescriptionTF" readonly value="{{$data->item_description}}" required maxlength="100">
                
                </td>
                <td>
                
                    <input type="number" class="form-control qty" id="quantity" name="quantityTF" readonly value="{{$data->quantity}}" required maxlength="100">
              
                </td>
                <td>
               
                    <input type="number" class="form-control val" id="value" name="valueTF" readonly value="{{$data->line_value}}" required maxlength="100">
              

                </td>
                <td>
              
                    <input type="text" class="form-control val2" id="totalValue" name="totalvalueTF" readonly="readonly" readonly value="{{$data->total_value}}" required maxlength="100">
              
                </td>

              </tr>
              @endforeach
            </thead>
            <tfoot>
              <td></td>
              <td>
                <h4 style="text-align: right;">TOTAL:</h4>
              </td>
              <td>
           
                  <!-- <input type="text" class="form-control total" id="totalQuantity" name="totalQuantity" readonly="readonly" required maxlength="100"> -->
          
              </td>
              <td></td>
              <!-- <td>
                <div class="col-md-12">
                  <input type="text" class="form-control total" id="totalValue" name="totalValue" readonly="readonly" required maxlength="100">
                </div>
              </td> -->
              <td>
          
                  <input type="text" class="form-control total" id="totalValue2" name="totalValue2" readonly="readonly" required maxlength="100">
            
              </td>
              <!-- <td>
                <div class="col-md-12">
                  <input type="text" class="form-control total" id="totalSKU" name="totalSKU" readonly="readonly" required maxlength="100">
                </div>
              </td> -->
            </tfoot>
          </table>


        </div>

        <div class="col-md-4">
          <div class="form-group">
            <input type="hidden" value="{{$row->id}}" name="id">
            <div class="scrollable">
              <h4><strong>Receipt:</strong></h4>
              <table class="table table-striped mytable">
                <thead>


                  <td colspan="3">
                    <!-- <input type="file" name="image" id="image" class="image" style="width:250px;"  accept="image/*"> -->

                    <img src="{{asset($datas[0]->receipt_photo)}}" width="330px" height="500px" alt="receipt">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div id="image_preview">
                      <img src="#" id="image-preview" style="width:330px;height:500px;" /><br />
                      <a id="image_remove" href="#">Remove</a>
                    </div>

                  </td>



                </thead>
              </table>

            </div>
          </div>


        </div>
        
         <div class="col-md-8">
            <!--Textarea with icon prefix-->
            <div class="form-group">
              <label>Comments</label>
              <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" onkeyup="this.value = this.value.replace(/[&^*</>@$]/g,'')" class="form-control" readonly name="comments">{{$datas[0]->comment}}</textarea>
            </div>
          </div>

    
  </div>

</div>
@endsection
@push('bottom')

<script type="text/javascript">

$(document).ready(function()
  {
    $('#totalQuantity').val(calculateTotalQuantity());
    $('#totValue').val(calculateTotalValue());
    $('#totalValue2').val(calculateTotalValue2());
    
  });
  
  function calculateTotalValue2() {
  var totalQuantity = 0;
  $('.val2').each(function () {
    totalQuantity += parseFloat($(this).val());
  });
  return totalQuantity;
}

  function calculateTotalQuantity() {
  var totalQuantity = 0;
  $('.qty').each(function () {
    totalQuantity += parseFloat($(this).val());
  });
  return totalQuantity;
}

function calculateTotalValue() {
  var totalQuantity = 0;
  $('.val').each(function () {
    totalQuantity += parseFloat($(this).val());
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

  // //-------this is for add row and delete row------------------------
  // $(document).ready(function() {
  //   $(document).on('click', '#requestTable .add', function() {

  //     var row = $(this).closest('tr');
  //     var clone = row.clone();
  //     var tr = clone.closest('tr');
  //     tr.find('input[type=text]').val('');
  //     $(this).closest('tr').after(clone);
  //     var $span = $("#requestTable tr");

  //   });

  //   $(document).on('click', '#requestTable .removeRow', function() {
  //     if ($('#requestTable .add').length > 1) {
  //       $(this).closest('tr').remove();
  //     }

  //   });
  // });
  // //--------------------------------------------------------------

  // //-----this is for auto compute quantity * value = totalvalue---------
  // $(document).ready(function() {
  //   $('#quantity, #value').keyup(function() {
  //     var quantity = parseFloat($('#quantity').val()) || 0;
  //     var value = parseFloat($('#value').val()) || 0;

  //     $('#totalValue').val(quantity * value);
  //   });
  // });
  // //---------------------------------------------------------------





  //---for UploadPhoto---------
  function preventBack() {
    window.history.forward();
  }
  window.onunload = function() {
    null;
  };
  setTimeout("preventBack()", 0);

  jQuery(document).delegate('#image', 'change', function() {
    ext = jQuery(this).val().split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
      resetFormElement(jQuery(this));
      window.alert('Not an image!');
    } else {
      var reader = new FileReader();
      var image_holder = jQuery("#" + jQuery(this).attr('class') + "-preview");
      image_holder.empty();

      reader.onload = function(e) {
        jQuery(image_holder).attr('src', e.target.result);
      }

      reader.readAsDataURL((this).files[0]);
      jQuery('#image_preview').slideDown();
      jQuery(this).slideUp();
    }
  });

  jQuery('#image_preview a').bind('click', function() {
    resetFormElement(jQuery('#image'));
    jQuery('#image').slideDown();
    jQuery(this).parent().slideUp();
    return false;
  });

  function resetFormElement(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
  }
  //-------------------------------
</script>
@endpush