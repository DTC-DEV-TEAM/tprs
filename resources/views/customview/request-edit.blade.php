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
    <form method='post' action="{{route('UpdateData')}}" id="requestForm" enctype="multipart/form-data" autocomplete="off">
      <!-- <meta name="csrf-token" content="{{ csrf_token() }}" /> -->
      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">

      
      <div class='form-group'>

        <div class="col-md-12" style="border-bottom: 2px solid black;">
        
          <div class="col-md-3">

          </div>
          <div class="col-md-6">
            <h1 style="text-align: center;" class="col-md-12"><strong>EDIT-RECEIPT FORM</strong></h1>
          </div>

          <div class="col-md-3">

          </div>
        </div>
      </div>
      <br><br><br>
      <br>

      <div class="row">

        <div class="col-md-8">
         
           
         
          <h4><b>STORES:</b></h4>
          <select name="store" class="form-control col-md-12">
            <!-- <option value="-----">-Please Select Store-</option> -->

            @foreach($stores as $store)
            @if($store_names->store_name == $store->store_name)
            <option selected value="{{$store->store_name}}">{{$store->store_name}}</option>

            @endif

            @endforeach
          </select>

          <h4><b>Invoice #:</b></h4>
          <div class="form-group">

            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-hashtag"></i></div>
              <input type="text" name="invoice_number" id="invoice" value="{{$datas[0]->invoice_no}}" class="form-control col-md-12" required>
            </div>
          </div>
          
        </div>

        <div class="col-md-4">
          <h4><b>Invoice Date:</b></h4>
          <div class="form-group">

            <div class="input-group date">
              <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
              <input type="text" id="date" readonly name="dateReceipt" class="form-control col-md-12" value="{{$datas[0]->date_receipt}}">
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
                <th class="nbsp">&nbsp;</th>
                <th>Error</th>
              </tr>



              @foreach($datas as $data)
              <tr id="tr-table">
                @if($data->error == 1)
                <td>
                  <!-- <script>
                    var counter = 1;
                    counter++;
                  </script> -->


                  <!-- <option value="-----">-Please Select Category-</option> -->
                  
                    <input type="hidden" class="form-control" name="requestversion" value="{{$data->version+1}}">
                    <!-- <input type="hidden" class="form-control" name="invoice_number" value="{{$datas[0]->invoice_no}}"> -->
                  <input type="hidden" class="form-control" name="headerID" value="{{$datas[0]->request_header_id}}">
                  <input type="hidden" class="form-control" name="receipt_photo" value="{{$datas[0]->receipt_photo}}">
                  <input type="hidden" class="form-control" name="request_header_id" value="{{$data->request_header_id}}">
                  <input type="hidden" class="form-control" name="requested_at" value="{{$data->requested_at}}">
                  <input type="hidden" class="form-control" name="requested_by" value="{{$data->requested_by}}">
                  <input type="hidden" class="form-control" name="referencenumberTF" value="{{$data->reference_number}}">
                  <input type="hidden" class="form-control" name="storeTF" value="{{$data->store_id}}">
                  <input type="hidden" class="form-control" name="id_row[]" value="{{$data->id}}">
                  <!-- <input type="text" class="form-control" name="categorydescriptionTF" value="{{$data->category_description}}" required maxlength="100"> -->
                  <select class="form-control" name="category[]" required>
                    @foreach($categorys as $category)
                    @if($data->category_description == $category->category_description)
                    <option selected value="{{$category->category_description}}">{{$category->category_description}}</option>
                    @else
                    <option value="{{$category->category_description}}">{{$category->category_description}}</option>
                    @endif

                    @endforeach
                  </select>


                </td>
                <td>

                  <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="itemdescriptionTF[]" value="{{$data->item_description}}" required maxlength="100">

                </td>
                <td>

                  <input type="number" class="form-control qquantity" data-id="{{$data->id}}" id="quantity{{$data->id}}" step="any" name="quantityTF[]" value="{{$data->quantity}}" required maxlength="100">

                </td>
                <td>

                  <input type="number" class="form-control value" step="0.01" data-id="{{$data->id}}" id="value{{$data->id}}" name="valueTF[]" onchange="setTwoNumberDecimal(this)" value="{{$data->line_value}}" required maxlength="100">


                </td>
                <td>

                  <input type="text" class="form-control totalV" data-id="{{$data->id}}" id="totalV{{$data->id}}" name="totalvalueTF[]" readonly="readonly" readonly value="{{$data->total_value}}" required maxlength="100">

                </td>

                <td>


                  <input type="button" id="deleteRow" data-id="{{$data->id}}" name="removeRow" class="btn btn-danger removeRow" value='Delete' />


                </td>
               
                <td>
                  <img src="{{asset('vendor/crudbooster/cancel.png')}}" alt="" height=30px width=30px>

                </td>

                @elseif($data->status == 'REQUESTED')
                <td>
                  <!-- <script>
                    var counter = 1;
                    counter++;
                  </script> -->


                  <!-- <option value="-----">-Please Select Category-</option> -->
                
                    <input type="hidden" class="form-control" name="requestversion" value="{{$data->version+1}}">
                  
                  <input type="hidden" class="form-control" name="receipt_photo" value="{{$datas[0]->receipt_photo}}">
                  <input type="hidden" class="form-control" name="request_header_id" value="{{$data->request_header_id}}">
                  <input type="hidden" class="form-control" name="requested_at" value="{{$data->requested_at}}">
                  <input type="hidden" class="form-control" name="requested_by" value="{{$data->requested_by}}">
                  <input type="hidden" class="form-control" name="referencenumberTF" value="{{$data->reference_number}}">
                  <input type="hidden" class="form-control" name="storeTF" value="{{$data->store_id}}">
                  <input type="hidden" class="form-control" name="id_row[]" value="{{$data->id}}">
                  <!-- <input type="text" class="form-control" name="categorydescriptionTF" value="{{$data->category_description}}" required maxlength="100"> -->
                  <select class="form-control" name="category[]" required>
                    @foreach($categorys as $category)
                    @if($data->category_description == $category->category_description)
                    <option selected value="{{$category->category_description}}">{{$category->category_description}}</option>
                    @else
                    <option value="{{$category->category_description}}">{{$category->category_description}}</option>
                    @endif

                    @endforeach
                  </select>


                </td>
                <td>

                  <input type="text"  onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="itemdescriptionTF[]" value="{{$data->item_description}}" required maxlength="100">

                </td>
                <td>

                  <input type="number"  class="form-control qquantity" data-id="{{$data->id}}" id="quantity{{$data->id}}" step="any" name="quantityTF[]" value="{{$data->quantity}}" required maxlength="100">

                </td>
                <td>

                  <input type="number"  class="form-control value" step="0.01" data-id="{{$data->id}}" id="value{{$data->id}}" name="valueTF[]" onchange="setTwoNumberDecimal(this)" value="{{$data->line_value}}" required maxlength="100">


                </td>
                <td>

                  <input type="text" class="form-control totalV" data-id="{{$data->id}}" id="totalV{{$data->id}}" name="totalvalueTF[]" readonly="readonly" readonly value="{{$data->total_value}}" required maxlength="100">

                </td>

                <td>


                  <input type="button" id="deleteRow" data-id="{{$data->id}}"  name="removeRow" class="btn btn-danger removeRow" value='Delete' />


                </td>
                @else
                <td>
                  <!-- <script>
                    var counter = 1;
                    counter++;
                  </script> -->


                  <!-- <option value="-----">-Please Select Category-</option> -->
              
                    <input type="hidden" class="form-control" name="requestversion" value="{{$data->version+1}}">
                 
                  <input type="hidden" class="form-control" name="dateReceipt" value="{{$datas[0]->date_receipt}}">
                  <input type="hidden" class="form-control" name="receipt_photo" value="{{$datas[0]->receipt_photo}}">
                  <input type="hidden" class="form-control" name="request_header_id" value="{{$data->request_header_id}}">
                  <input type="hidden" class="form-control" name="requested_at" value="{{$data->requested_at}}">
                  <input type="hidden" class="form-control" name="requested_by" value="{{$data->requested_by}}">
                  <input type="hidden" class="form-control" name="referencenumberTF" value="{{$data->reference_number}}">
                  <input type="hidden" class="form-control" name="storeTF" value="{{$data->store_id}}">
                  <input type="hidden" class="form-control" name="id_row[]" value="{{$data->id}}">
                  <!-- <input type="text" class="form-control" name="categorydescriptionTF" value="{{$data->category_description}}" required maxlength="100"> -->
                  <select class="form-control" name="category[]" required>
                    @foreach($categorys as $category)
                    @if($data->category_description == $category->category_description)
                    <option selected value="{{$category->category_description}}">{{$category->category_description}}</option>
                     
                    <!-- <option value="{{$category->category_description}}">{{$category->category_description}}</option> -->
                    @endif

                    @endforeach
                  </select>


                </td>
                <td>
                  

                  <input type="text" readonly onkeyup="this.value = this.value.toUpperCase();" class="form-control" name="itemdescriptionTF[]" value="{{$data->item_description}}" required maxlength="100">

                </td>
                <td>

                  <input type="number" readonly class="form-control qquantity" data-id="{{$data->id}}" id="quantity{{$data->id}}" step="any" name="quantityTF[]" value="{{$data->quantity}}" required maxlength="100">

                </td>
                <td>

                  <input type="number" readonly class="form-control value" step="0.01" data-id="{{$data->id}}" id="value{{$data->id}}" name="valueTF[]" onchange="setTwoNumberDecimal(this)" value="{{$data->line_value}}" required maxlength="100">


                </td>
                <td>

                  <input type="text" class="form-control totalV" data-id="{{$data->id}}" id="totalV{{$data->id}}" name="totalvalueTF[]" readonly="readonly" readonly value="{{$data->total_value}}" required maxlength="100">

                </td>

                <td>


                  <input type="button" id="deleteRow" disabled name="removeRow" class="btn btn-danger removeRow" value='Delete' />


                </td>
               
               
                @endif
              </tr>
              @endforeach
              </body>
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

                  <!-- <input type="text" class="form-control" id="totalQuantity" name="totalQuantity" readonly="readonly" required maxlength="100"> -->

                </td>


                <td></td>
                <!-- <td>

                  <input type="text" class="form-control total" id="totalValue" name="totalValue" readonly="readonly" required maxlength="100">

                </td> -->
                <td>

                  <input type="text" class="form-control" id="totalValue2" name="totalValue2" readonly="readonly" required maxlength="100">

                </td>

                <td></td>
                <!-- <td>

                  <input type="text" class="form-control total" id="totalSKU" name="totalSKU" readonly="readonly" required maxlength="100">

                </td> -->
              </tr>
            </tfoot>
          </table>



        </div>

        <div class="col-md-4">
          <div class="form-group">
            <input type="hidden" value="{{$row->id}}" name="id">
            <div class="scrollable">
              <h4><strong>RECEIPT:</strong></h4>
              <table class="table table-striped mytable">
                <thead>


                  <div id="myImage">
                    <input type="file" name="image" id="image" class="image" style="width:330px;"  accept="image/*">
                    <!--<input type="hidden" name="_token" value="{{ csrf_token() }}">-->
                    <img src="{{asset($datas[0]->receipt_photo)}}" id="uploadedImage" width="330px" height="500px" alt="receipt">
                    <div id="image_preview">
                      <!-- <img src="#" class="imagesticky" id="image-preview" style="width:330px; height: 500px;" /><br /> -->
                      <a id="image_remove" href="#">Remove</a>
                    </div>
                  </div>
                  <!-- <td colspan="3">
                    <div id="myImage">
                      <input type="file" name="image" id="image" class="image" style="width:330px;height:500px;" accept="image/*">
                      <img src="{{asset($datas[0]->receipt_photo)}}" id="uploadedImage" width="330px" height="100%" alt="receipt">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">

                      <div id="image_preview">
                        <img src="#" id="image-preview" style="width:330px;height:500px;" /><br />
                        <a id="image_remove" href="#">Remove</a>
                      </div>
                    </div>

                  </td> -->



                </thead>
              </table>

            </div>
          </div>


        </div>

        <div class="row">
          <div class="col-md-8">
            <!--Textarea with icon prefix-->
            <div class="form-group">
              <label>Comments</label>
              <textarea rows="3" class="form-control" name="comments">{{$datas[0]->comment}}</textarea>
            </div>
          </div>
        </div>

        @if($data->status == 'DISAPPROVED' || $data->status == 'REQUESTED')
        <div class="col-md-12">
          <button class="btn btn-info saveB" id="saveButton" style="float: right;">SAVE</button>
        </div>
        @endif
    </form>

  </div>

</div>
@endsection
@push('bottom')

<script type="text/javascript">
  $("#totalQuantity").val(calculateTotalQuantity());
  $("#totalValue2").val(calculateTotalValue2());
  var token = $("#token").val();
 
  // alert(token);
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

  // $(document).ready(function()
  // {
  //   $(document).on('click','#image', function()
  //   {
  //       $('#uploadedImage').removeAttr('src');​ // Remove the src$('#id').removeAttr('src');​ // Remove the src
  //   });
  // });

  $(document).scroll(function() {
    var scroll = $(window).scrollTop();
    if (scroll > 800) {
      $("#myImage").addClass("scroll1");
    } else {
      $("#myImage").removeClass("scroll1");
    }
  });

  $("#image").change(function() {
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#uploadedImage').attr('src', e.target.result);
      }
      reader.readAsDataURL(this.files[0]);
    }
  });


//disable button after submit
$(document).ready(function () {
    $("#requestForm").submit(function () {
        $(".saveB").attr("disabled", true);
        return true;
    });
});

  //-------this is for add row and delete row------------------------
  //addRow

  var tableRow = $('#requestTable tbody tr').length +1;
  var countRow = $('#requestTable tbody tr').length-1;
  // alert(countRow);
  // alert(countRow);
  $(document).ready(function() {
    $("#add-Row").click(function() {
      tableRow++;
      countRow++;
      var newrow = '<tr><td><select class="form-control" name="new-category[]" required><!-- <option value="">-Please Select Category-</option> -->@foreach($categorys as $category)<option name="category" value="{{$category->category_description}}">{{$category->category_description}}</option>@endforeach</select></td><td><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="' + tableRow + '" id="itemDesc' + tableRow + '" name="new-itemdescriptionTF[]" required maxlength="100"></td><td><input type="number" class="form-control qquantity" data-id="' + tableRow + '" step="any" id="quantity' + tableRow + '" name="new-quantityTF[]" required maxlength="100"></td><td><input type="number" class="form-control value" data-id="' + tableRow + '" id="value' + tableRow + '" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" name="new-valueTF[]"  required maxlength="100"></td><td><input type="text" class="form-control totalV" id="totalV' + tableRow + '" name="new-totalvalueTF[]" readonly="readonly" required maxlength="100"></td><td><input type="button" id="deleteRow" name="removeRow" class="btn btn-danger removeRow" value="Delete" /></td></tr>';
      $(newrow).insertBefore($('table tr#tr-table1:last'));

    });

    // $("#add-Row").click(function() {
    //   tableRow++;
    //   var newrow = '<tr><td><select class="form-control" name="category[]" required><option value="">-Please Select Category-</option>@foreach($categorys as $category)<option name="category" value="{{$category->category_description}}">{{$category->category_description}}</option>@endforeach</select></td><td ><input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="' + tableRow + '" id="itemDesc' + tableRow + '"  name="itemdescriptionTF[]"  required maxlength="100"></td><td ><input type="number" class="form-control qquantity" data-id="' + tableRow + '" id="quantity' + tableRow + '" step="0.01" name="quantityTF[]" min="0" required maxlength="100"></td><td><input type="number" class="form-control value" data-id="' + tableRow + '" id="value' + tableRow + '" name="valueTF[]" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" required maxlength="100"></td><td><input type="text" class="form-control totalV" id="totalValue' + tableRow + '" name="totalvalueTF[]" readonly="readonly" step="0.01" required maxlength="100"></td><td><input type="button" id="deleteRow" name="removeRow" class="btn btn-danger removeRow" value="Delete" /></td></tr>';
    //   $(newrow).insertBefore($('table tr#tr-table1:last'));

    // });
    //deleteRow
    $(document).on('click', '.removeRow', function() {
      if (countRow != 1) { //check if not the first row then delete the other rows
        countRow--;
        var rowID = $(this).attr("data-id");
       
         $.ajax({
          type: "POST",
          url: "{{route('delete')}}",
          dataType: "JSON",
          data: {
            "_token": token,
            "row_id": rowID,
           
          },
          success: function(data) {
            // alert(data);
          },
          error: function(xhr, status, error) {
            // alert(error);
          }
        });

        $(this).closest('tr').remove();
        $("#totalQuantity").val(calculateTotalQuantity());
        $("#totalValue2").val(calculateTotalValue2());
        
        return false;
       
      }
    });

  });
  //--------------------------------------------------------------

  //------multiplication of quantity and value per row-------------

  $(document).on('keyup', '.qquantity', function(ev) {

    var id = $(this).attr("data-id");
    var rate = parseFloat($(this).val());
    var qty = $("#value" + id).val();
    var price = calculatePrice(qty, rate).toFixed(2);
    
    $("#totalV" + id).val(price);
    $("#totalQuantity").val(calculateTotalQuantity());
    $("#totalValue2").val(calculateTotalValue2());
    

  });

  

  $(document).on('keyup', '.value', function(ev) {

    var id = $(this).attr("data-id");
    var rate = parseFloat($(this).val());
    var qty = $("#quantity" + id).val();
    var price = calculatePrice(qty, rate).toFixed(2);

    $("#totalV" + id).val(price);
    $("#totalQuantity").val(calculateTotalQuantity());
    $("#totalValue2").val(calculateTotalValue2());
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
    $('.qquantity').each(function() {
      totalQuantity += parseFloat($(this).val());
    });
    return totalQuantity;
  }

  function calculateTotalValue() {
    var totalQuantity = 0;
    $('.value').each(function() {
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

  function setTwoNumberDecimal(el) {
    el.value = parseFloat(el.value).toFixed(2);
  };

  //------------end---------------------------------------------------

  $(document).ready(function()
{
  var str = "{{$datas[0]->requested_at}}";//get the created date
  str = str.substr(0,10);// substring the date (yyyy-mm-dd)

  
  var maxdate = new Date(str);//set the format
  maxdate.setDate(maxdate.getDate() - 14); // minus the date
  var mindate = new Date(maxdate);//store the minimum date
 
  $("#date").datepicker({
    dateFormat: 'yy-mm-dd',
    minDate: mindate, // from date today minus 15 days
    
    // maxDate: "{{$datas[0]->requested_at}}"    // from todays date
    maxDate: str    // from todays date
  });
});


 $("#saveButton").click(function(event) {
    var qty = 0;
    $('.qquantity').each(function() {
      qty = $(this).val();
      if (qty == 0) {
        alert("Quantity cannot be empty or zero!!");
        event.preventDefault(); // cancel default behavior
      }else if(qty < 0)
      {
        alert("Negative Value is not allowed!!");
        event.preventDefault(); // cancel default behavior
      }
    });

    var lineval = 0;
    $('.value').each(function() {
      lineval = $(this).val();
       if(lineval < 0)
      {
        alert("Negative Value is not allowed!!");
        event.preventDefault(); // cancel default behavior
      }
    });


  });

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