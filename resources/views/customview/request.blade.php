<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@push('head')
<style type="text/css">
  #image_preview {
    display: none;
    width: 200px;
  }

  #myImage.scroll1 {
    position: fixed;
    top: 0;
    height: 500px !important;
  }

  #box {
    height: 100%;
    max-height: 100%;
    overflow: auto;
    width: 100%;
  }


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


    <form method='post' action="{{route('RequestData')}}" id="requestForm" enctype="multipart/form-data" autocomplete="off">
      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">


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

        <!-- <div class="col-md-4">
          <h4><b>STORES:</b></h4>
          <select name="store" class="form-control col-md-">
        
            @foreach($store as $datas)
            <option value="{{$datas->store_name}}">{{$datas->store_name}}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-4">
          <h4><b>Receipt No::</b></h4>
    
 
            <input type="text" class="form-control receiptclass" id="" name="receiptnumber"  required maxlength="100">
        
        </div>

        <div class="col-md-4">
          <h4><b>Date Receipt:</b></h4>
          <div class="form-group">

            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              <input type="date" name="dateReceipt" class="form-control col-md-12" required>
            </div>
          </div>
        </div> -->



        <div class="col-md-8">
          <h4><b>STORES:</b></h4>
          <select name="store" class="form-control col-md-">
            <!-- <option value="-----">-Please Select Store-</option> -->
            @foreach($store as $datas)
            <option value="{{$datas->store_name}}">{{$datas->store_name}}</option>
            @endforeach
          </select>

          <h4><b>Invoice #:</b></h4>
          <div class="form-group">

            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-hashtag"></i></div>
              <input type="text" name="invoice_number" id="invoice" class="form-control col-md-12" required>
            </div>
          </div>
        </div>



        <div class="col-md-4">

          <h4><b>Invoice Date:</b></h4>
          <div class="form-group">

            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              <input type="text" readonly name="dateReceipt" id="date" class="form-control col-md-12" required>
            </div>
          </div>
        </div>

      </div>

      <!-- end receipt form -->
      <div class="row">

        <div class="col-md-8">
          <table id="requestTable" class="table table-bordered
                    table-condensed table-striped">
            <tbody id="bodyTable">

              <!-- <td>
                <div class="col-md-12">
                  <input type="button" id="addRow" name="addRow" class="btn btn-primary add" value='Add' />
                </div>
              </td> -->
              <tr>
                <th width="30%">Category</th>
                <th width="30%">Item Description</th>
                <th width="10%">Qty</th>
                <th width="15%">Value</th>
                <th width="15%">Total Value</th>
                <td class="nbsp">&nbsp;</td>
              </tr>



              <tr id="tr-table">
              <tr>

              </tr>

              </tr>
            </tbody>
            <tfoot>
              <tr id="tr-table1" class="bottom">
                <td>
                  <div class="col-md-12">
                    <input type="button" id="add-Row" name="add-Row" class="btn btn-primary add" value='Add' />
                  </div>
                </td>

                <td>
                  <h4 style="text-align: right;">TOTAL:</h4>
                </td>
                <td>

                  <!-- <input type="text" class="form-control total" id="tQuantity" name="totalQuantity" readonly="readonly" required maxlength="100"> -->

                </td>
                <td>

                  <!-- <input type="text" class="form-control total" id="tValue" name="totalValue" readonly="readonly" required maxlength="100"> -->

                </td>
                <td>

                  <input type="text" class="form-control total" id="tValue2" name="totalValue2" step="0.01" readonly="readonly" required maxlength="100">

                </td>
                <td>

                  <!-- <input type="text" class="form-control total" id="totalSKU" name="totalSKU" readonly="readonly" required maxlength="100"> -->

                </td>
              </tr>
            </tfoot>
          </table>


        </div>

        <div class="col-md-4">

          <input type="hidden" value="{{$row->id}}" name="id">

          <h4><strong>Receipt:</strong></h4>



          <div id="myImage">
            <input type="file" name="image" id="image" class="image" style="width:330px;" required accept="image/*">
            <!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
            <div id="image_preview">
              <img src="#" class="imagesticky" id="image-preview" style="width:330px; height: 500px;" /><br />
              <a id="image_remove" href="#">Remove</a>
            </div>
          </div>









        </div>

      </div>
      
      <div class="row">
          <div class="col-md-8">
            <!--Textarea with icon prefix-->
            <div class="form-group">
              <label>Comments</label>
              <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" onkeyup="this.value = this.value.replace(/[&^*</>@$]/g,'')" class="form-control" name="comments"></textarea>
            </div>
          </div>
        </div>


      <div class="col-md-12">
        <button class="btn btn-info requestB" id="requestButton" style="float: right;">Request Now</button>
      </div>

    </form>
  </div>
</div>


</div>

</div>
@endsection
@push('bottom')

<script type="text/javascript">
  //-------this is for add row and delete row------------------------
  //addRow
  var tableRow = 1;
  $(document).ready(function() {
    // $("#addRow").click(function() {
    //   tableRow++;
    //   var newrow = '<tr><td><select class="form-control" name="category[]" required><option value="">-Please Select Category-</option>@foreach($categorys as $category)<option name="category" value="{{$category->category_description}}">{{$category->category_description}}</option>@endforeach</select></td><td ><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="' + tableRow + '" id="itemDesc' + tableRow + '"  name="itemdescriptionTF[]"  required maxlength="100"></td><td ><input type="number" class="form-control quantity" data-id="' + tableRow + '" id="quantity' + tableRow + '" step="0.01"   name="quantityTF[]" min="0" required maxlength="100"></td><td><input type="number" class="form-control vvalue" data-id="' + tableRow + '" id="value' + tableRow + '"  name="valueTF[]" step="0.01" min="0"  onchange="setTwoNumberDecimal(this)" required maxlength="100"></td><td><input type="text" class="form-control totalV" id="totalValue' + tableRow + '"   name="totalvalueTF[]" readonly="readonly" step="0.01" required maxlength="100"></td><td><input type="button" id="deleteRow" name="removeRow" class="btn btn-danger removeRow" value="Delete" /></td></tr>';
    //   $(newrow).insertBefore($('table tr#tr-table1:last'));

    // });

    $("#add-Row").click(function() {
      tableRow++;
      var newrow = '<tr>' +
        '<td><select class="form-control" name="category[]" id="myCategory" required>' +
        '  <option value="">-Please Select Category-</option>' +
        '    @foreach($categorys as $category)' +
        '      <option name="category" value="{{$category->category_description}}">{{$category->category_description}}</option>' +
        '    @endforeach</select>' +
        '</td>' +
        '<td >' +
        '  <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="' + tableRow + '" id="itemDesc' + tableRow + '"  name="itemdescriptionTF[]"  required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="number" class="form-control quantity" data-id="' + tableRow + '" id="quantity' + tableRow + '" step="any" name="quantityTF[]" min="0" required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="number" class="form-control vvalue" data-id="' + tableRow + '" id="value' + tableRow + '" name="valueTF[]" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="text" class="form-control totalV" id="totalValue' + tableRow + '" name="totalvalueTF[]" readonly="readonly" step="0.01" required maxlength="100">' +
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
  //--------------------------------------------------------------

  //-----For scrolling kasama yung image-----------------------------
  $(document).scroll(function() {
    var scroll = $(window).scrollTop();
    if (scroll > 800) {
      $("#myImage").addClass("scroll1");
    } else {
      $("#myImage").removeClass("scroll1");
    }
  });
  //--------------------------------------------------------------

  function setTwoNumberDecimal(el) {
    el.value = parseFloat(el.value).toFixed(2);

  };


  //------multiplication of quantity and value per row-------------

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

  //------------end--------------------------------------------------


  //-------for date------------------------------------------
  $(document).ready(function() {
    $("#date").datepicker({
      dateFormat: 'yy-mm-dd',
      minDate: -14, // from date today minus 15 days
      maxDate: 0 // from todays date
    });
  });
  //---------------------------------------------------------

  //-----------disable button after submit-----------------
  $(document).ready(function() {
    $("#requestForm").submit(function() {
      $(".requestB").attr("disabled", true);
      return true;
    });
  });
  //--------------------------------------------------------

  $("#requestButton").click(function(event) {

    var countRow = $('#requestTable tfoot tr').length;
    // var value = $('.vvalue').val();
    if (countRow == 1) {
      alert("please add an item!!");
      event.preventDefault(); // cancel default behavior
    }

    var qty = 0;
    $('.quantity').each(function() {
      qty = $(this).val();
      if (qty == 0) {
        alert("Quantity cannot be empty or zero!!");
        event.preventDefault(); // cancel default behavior
      } else if (qty < 0) {
        alert("Negative Value is not allowed!!");
        event.preventDefault(); // cancel default behavior
      }
    });

    var lineval = 0;
    $('.vvalue').each(function() {
      lineval = $(this).val();
      if (lineval < 0) {
        alert("Negative Value is not allowed!!");
        event.preventDefault(); // cancel default behavior
      }
    });
  });

  // var token = $("#token").val();
  // $(document).ready(function() {
  //   $(function() {
  //     var store_id = $('#myCategory').val();

  //   });
  // });

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