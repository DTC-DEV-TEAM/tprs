<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@push('head')
<style type="text/css">
  #image_preview {
    display: none;
    width: 200px;
  }

  .chk1 {
    top: 8;
    width: 20px;
    height: 20px;
    position: relative;
    -webkit-appearance: none;
    outline: none;
    transition: .5s;
  }


  .chk1:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 2px solid #262626;
    box-sizing: border-box;
    transition: .5s
  }


  .chk1:checked:before {
    right: 2px;
    border-left: none;
    border-top: none;
    width: 10px;
    border-color: #ff0000;
    transform: rotate(45deg)translate(5px, -10px);
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
    <form method='post' action="{{route('approval')}}" id="approvalForm">
      <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
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

        <div class="col-md-4">
          <h4><b>Invoice Date:</b></h4>
          <div class="form-group">
            <!-- unhide this after covid-19 -->
              <!-- @if($datas[0]->status == 'RECEIPTED' || $datas[0]->status == 'AUDITED' || $datas[0]->status == 'PROCESSED')
              <div class="input-group date">
                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                <input type="date" name="dateReceipt" class="form-control col-md-6" readonly value="{{$datas[0]->date_receipt}}">
              </div>
              @else
              @endif -->
            <!--  -->

            <!-- use this for covid-19 -->
                @if($datas[0]->status == 'AUDITED' || $datas[0]->status == 'PROCESSED')
                <div class="input-group date">
                  <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                  <input type="date" name="dateReceipt" class="form-control col-md-6" readonly value="{{$datas[0]->date_receipt}}">
                </div>
                @else
                @endif
            <!--  -->
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
                <th>Remarks</th>
              </tr>
              @foreach($datas as $data)
              <tr>
                <td>


                  <!-- <option value="-----">-Please Select Category-</option> -->
                  <input type="hidden" class="form-control" name="headerID" id="{{$data->request_header_id}}" value="{{$data->request_header_id}}">
                  <input type="hidden" class="form-control" name="status" value="{{$data->status}}">
                  <input type="hidden" class="form-control" name="requested_at" value="{{$data->requested_at}}">
                  <input type="hidden" class="form-control" name="date_receipt" value="{{$data->date_receipt}}">
                  <input type="hidden" class="form-control" name="checker_processed" value="{{$data->processed_by}}">
                  <input type="hidden" class="form-control" name="receiver_received" value="{{$data->receipt_by}}">
                  <input type="hidden" class="form-control" name="oic_approved" value="{{$data->approved_by_oic}}">
                  <input type="hidden" class="form-control" name="request_header_id" value="{{$data->request_header_id}}">
                  <input type="hidden" class="form-control" name="status" value="{{$data->status}}">
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
                @if($data->error == 1 && $data->status == 'DISAPPROVED')
                <td>
                  <img src="{{asset($errorpic)}}" alt="" height=30px width=30px>
                </td>
                @elseif($data->error == 0 || $data->error == null)
                <td>
                  <!-- <div class="chk">
                    <label><input type="checkbox" id="{{$data->id}}"  class="chk1"></label>
                  </div>
                </td> -->
                  <div class="chk">
                    <label><input type="radio" id="{{$data->id}}" class="yrem" required name="{{$data->id}}error[]" checked>&check;</label> &nbsp;
                    <label><input type="radio" id="{{$data->id}}" class="nrem" required name="{{$data->id}}error[]">X</label>
                  </div>
                </td>
                @else
                <td>
                  <!-- <div class="chk">
                    <label><input type="checkbox" id="{{$data->id}}"  class="chk1"></label>
                  </div>
                </td> -->
                  <div class="chk">
                    <label><input type="radio" id="{{$data->id}}" class="yrem" required name="{{$data->id}}error[]" checked>&check;</label> &nbsp;
                    <label><input type="radio" id="{{$data->id}}" class="nrem" required name="{{$data->id}}error[]">X</label>
                  </div>
                </td>
                @endif

              </tr>
              @endforeach
            </thead>
            <tfoot>
              <td></td>
              <td>
                <h4 style="text-align: right;">TOTAL:</h4>
              </td>
              <td>

                <!-- <input type="text" class="form-control total" id="totQuantity" name="totalQuantity" readonly="readonly" required maxlength="100"> -->

              </td>
              <td>

                <!-- <input type="text" class="form-control total" id="totValue" name="totalValue" readonly="readonly" required maxlength="100"> -->

              </td>
              <td>

                <input type="text" class="form-control total" id="totValue2" name="totalValue2" readonly="readonly" required maxlength="100">

              </td>
              <!-- <td>
             
                    <input type="text" class="form-control total" id="totalSKU" name="totalSKU" readonly="readonly" required maxlength="100">
             
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


        <div class="row">
          <div class="col-md-12">
            <!--Textarea with icon prefix-->
            <div class="form-group">
              <label>Comments</label>
              <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" onkeyup="this.value = this.value.replace(/[&^*</>@$]/g,'')" class="form-control" name="comments">{{$datas[0]->comment}}</textarea>
            </div>
          </div>
        </div>

        <div class="col-md-12">
          <br>
          <!-- unhide this after covid-19 -->
          <!-- @if(($datas[0]->status == 'AUDITED') && ($privilege_name == 'AP Receiver' || $privilege_name == 'Admin' || $privilege_name == 'Super Administrator'))


          <button type="submit" class="btn btn-info disapprovedB" id="receiptButton" name="submitB" value="receiptB" style="float: right;">Receipt</button>
          <button type="submit" class="btn btn-danger disapprovedB" id="disapprovedButton" name="submitB" value="disapprovedB" style="float: left;">Reject</button>
          @elseif($datas[0]->status == 'RECEIPTED' && ($privilege_name == 'AP Checker' || $privilege_name == 'Admin' || $privilege_name == 'Super Administrator'))
          <button type="submit" class="btn btn-info disapprovedB" id="processedButton" name="submitB" value="processB" style="float: right;">For Process</button>
          <button type="submit" class="btn btn-danger disapprovedB" id="disapprovedButton" name="submitB" value="disapprovedB" style="float: left;">Reject</button>
          @elseif($datas[0]->status == 'PROCESSED' && ($privilege_name == 'Treasury' || $privilege_name == 'Admin' || $privilege_name == 'Super Administrator'))
          <button type="submit" class="btn btn-danger disapprovedB" id="disapprovedButton" name="submitB" value="disapprovedB" style="float: left;">Reject</button>
          <button type="submit" class="btn btn-primary approvedB" id="reimbursedButton" name="submitB" value="approvedB" style="float: right;">Reimbursed</button>
          @endif -->
          <!--  -->

          <!-- use this for covid-19 -->
          @if($datas[0]->status == 'AUDITED' && ($privilege_name == 'AP Checker' || $privilege_name == 'Admin' || $privilege_name == 'Super Administrator'))
          <button type="submit" class="btn btn-info disapprovedB" id="processedButton" name="submitB" value="processB" style="float: right;">For Process</button>
          <button type="submit" class="btn btn-danger disapprovedB" id="disapprovedButton" name="submitB" value="disapprovedB" style="float: left;">Reject</button>
          @elseif($datas[0]->status == 'PROCESSED' && ($privilege_name == 'Treasury' || $privilege_name == 'Admin' || $privilege_name == 'Super Administrator'))
          <button type="submit" class="btn btn-danger disapprovedB" id="disapprovedButton" name="submitB" value="disapprovedB" style="float: left;">Reject</button>
          <button type="submit" class="btn btn-primary approvedB" id="reimbursedButton" name="submitB" value="approvedB" style="float: right;">Reimbursed</button>
          @endif
          <!--  -->
        </div>

    </form>

  </div>

</div>
@endsection
@push('bottom')

<script type="text/javascript">
  var token = $("#token").val();
  //-------this is for add row and delete row------------------------
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


  $(document).ready(function() {
    $(function() {
      //for X radio button
      var name = "nrem";
      $("input:radio[class=" + name + "]").on("change", function() {
        var chk_id = $(this).attr("id");
        var value1 = $(this).is(':checked') ? 1 : 0;
        // alert(value1);
        $.ajax({
          type: "POST",
          url: "{{route('reject')}}",
          dataType: "JSON",
          data: {
            "_token": token,
            "line_id": chk_id,
            "value": value1,
          },
          success: function(data) {
            //alert(data);
          },
          error: function(xhr, status, error) {
            //alert(error);
          }
        });

      });
      //for fafa-check radio button
      var name1 = "yrem";
      $("input:radio[class=" + name1 + "]").on("change", function() {
        var chk_id = $(this).attr("id");
        var value1 = $(this).is(':checked') ? 0 : 0;
        // alert(value1);
        $.ajax({
          type: "POST",
          url: "{{route('reject')}}",
          dataType: "JSON",
          data: {
            "_token": token,
            "line_id": chk_id,
            "value": value1,
          },
          success: function(data) {
            //alert(data);
          },
          error: function(xhr, status, error) {
            //alert(error);
          }
        });

      });

    });
  });

  $("#receiptButton, #processedButton, #reimbursedButton").click(function(event) {

    var checker = $('input[type="radio"]:checked')

    if (checker.length == 0) { // check if wala lahat na click na radio button



      alert("Please choose remarks!!");
      event.preventDefault(); // cancel default behavior

    } else if ($('.nrem').is(':checked')) {

      alert("Please unchecked the X button before approve!!");
      event.preventDefault(); // cancel default behavior
    } else {

        swal({
            title: "Are you sure?",
            text: "Proceed if you want to process this request.",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#5CB85C",
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                  $("#receiptButton, #processedButton, #reimbursedButton").unbind('click').click();
                } else {
                  event.preventDefault();
                }
            }
        );
        event.preventDefault();    //   return true;
    }

  });

  $("#disapprovedButton").click(function(event) {
    var counter = 0;
    $(".nrem").each(function() {

      if ($(this).is(':checked')) {
        counter++;
      }
    });

    if (document.querySelector('input[type="radio"]:checked') == null) {
      alert("You need to choose an option!");
      event.preventDefault(); // cancel default behavior

    } else if (counter == 0) {
      alert('Please select atleast one X remarks!')
      return false;
      event.preventDefault(); // cancel default behavior
    } else {

      return true;
    }


  });

    //----prevent to submit twice when clicking button-----
    $('#approvalForm').on('submit', function(e) {
      if (!$(this).data('submitted')) {
        $(this).data('submitted', true).addClass('disabled');

      } else {
        e.preventDefault();
      }
    });
    //--------------------------------------------------


  // $("#approvedButton").click(function(event) {
  //   if ($('.nrem').is(':checked')) {

  //     alert("Please unchecked the X button before approve!!");
  //     event.preventDefault(); // cancel default behavior
  //   } else {

  //     return true;
  //   }

  // });



  // $("#disapprovedButton").click(function(event) {
  //   if ($('.yrem').is(':checked')) {

  //     alert("Please check X button before disapprove!!");
  //     event.preventDefault(); // cancel default behavior
  //   } else {


  //     return true
  //   }

  // });


  $(document).ready(function() {
    $('#totQuantity').val(calculateTotalQuantity());
    $('#totValue').val(calculateTotalValue());
    $('#totValue2').val(calculateTotalValue2());

  });

  function calculateTotalValue2() {
    var totalQuantity = 0;
    $('.val2').each(function() {
      totalQuantity += parseFloat($(this).val());
    });
    return totalQuantity;
  }

  function calculateTotalQuantity() {
    var totalQuantity = 0;
    $('.qty').each(function() {
      totalQuantity += parseFloat($(this).val());
    });
    return totalQuantity;
  }

  function calculateTotalValue() {
    var totalQuantity = 0;
    $('.val').each(function() {
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