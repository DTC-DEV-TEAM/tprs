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
    <form method='post' action="" id="approvalForm" >
      <!-- <form method='post' action="{{route('approval')}}" id="approvalForm" onsubmit="event.preventDefault(); validate();"> -->
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

        <div class="col-md-8">
       
          <h4><b>STORES:</b></h4>
          <select name="store" class="form-control col-md-">
            <!-- <option value="-----">-Please Select Store-</option> -->
            @foreach($stores as $store)
            @if($store_names->store_name == $store->store_name)
            <option selected value="{{$store->store_name}}">{{$store->store_name}}</option>

            @endif

            @endforeach
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
                <th>Remarks</th>
              </tr>
              @foreach($datas as $data)
              <tr>
                <td>
                  <div class="col-md-12">

                    <!-- <option value="-----">-Please Select Category-</option> -->

                    <input type="hidden" class="form-control" name="status" value="{{$data->status}}">
                    <input type="hidden" class="form-control" name="requested_by" value="{{$data->requested_by}}">
                    <input type="hidden" class="form-control" name="referencenumberTF" value="{{$data->reference_number}}">
                    <input type="hidden" class="form-control" name="storeTF" value="{{$data->store_id}}">
                    <input type="text" class="form-control" name="categorydescriptionTF" readonly value="{{$data->category_description}}" required maxlength="100">

                  </div>

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
                <!-- <td>
                  @if($data->error == 1)
                  <img src="{{asset($errorpic)}}" alt="" height=30px width=30px>
                  @else
                  <div class="chk">
                    <label><input type="checkbox" id="{{$data->id}}" class="chk1"></label>
                  </div>
                  @endif


                </td> -->
                @if($data->error == 1)
                <td>
                  <img src="{{asset($errorpic)}}" alt="" height=30px width=30px>
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

                <!-- <input type="text" class="form-control totalQ" id="tQuantity" name="totalQuantity" readonly="readonly" required maxlength="100"> -->

              </td>

              <td></td>
              <!-- <input type="text" class="form-control totalV" id="tValue" name="totalValue" readonly="readonly" required maxlength="100"> -->


              <td>

                <input type="text" class="form-control totalV2" id="tValue2" name="totalValue2" readonly="readonly" required maxlength="100">

              </td>
              <!-- <td>

                <input type="text" class="form-control totalSKU" id="totalSKU" name="totalSKU" readonly="readonly" required maxlength="100">

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
        @if($datas[0]->status == "DISAPPROVED")
        <div class="row">
          <div class="col-md-12">
            <!--Textarea with icon prefix-->
            <div class="form-group">
              <label>Comments</label>
              <textarea rows="3" class="form-control" readonly placeholder="{{$datas[0]->comment}}" name="comments"></textarea>
            </div>
          </div>
        </div>
        @elseif($datas[0]->status != "DISAPPROVED")
        <div class="row">
          <div class="col-md-12">
            <!--Textarea with icon prefix-->
            <div class="form-group">
              <label>Comments</label>
              <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" onkeyup="this.value = this.value.replace(/[&^*</>@$]/g,'')" class="form-control" name="comments">{{$datas[0]->comment}}</textarea>
            </div>
          </div>
        </div>

        @endif




        <div class="col-md-12">

          @if($datas[0]->status != "DISAPPROVED")
          <button type="submit" class="btn btn-danger disapprovedB" id="disapprovedButton" name="submitB" value="disapprovedB" style="float: left;">Reject</button>
          <button type="submit" class="btn btn-info approvedB" id="approvedButton" name="submitB" value="approvedB" style="float: right;">Approve</button>
        </div>
        @endif

    </form>

  </div>

</div>
@endsection
@push('bottom')

<script type="text/javascript">
  var token = $("#token").val();
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



  $(document).ready(function() {
    $(function() {

      $("input:checkbox").on("change", function() {
        var chk_id = $(this).attr("id");
        var value1 = $(this).is(':checked') ? 1 : 0;
        //alert(chk_id);
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


  // function check_checkbox() {

  //   $("#disapprovedButton").click(function(e) {
  //         if ($('.chk1').is(':checked')) {

  //         return true;
  //       }
  //   });

  //   $("#approvedButton").click(function(e) {
  //         if ($('.chk1').is(':checked')) {
  //         alert("Please unchecked the errors before approve!!");
  //         return false;
  //       } else {

  //         return true;
  //       }
  //   });

  // }

  // var form = document.getElementById('approvalForm');
  // form.onsubmit = function() {

  //   if ($("#disapprovedButton").data('clicked')) {
  //     alert("yeah");
  //     return true;

  //   }else if ($(".approvedB").data('clicked')) {
  //     alert("d2");
  //     if ($('.chk1').is(':checked')) {

  //       alert("Please unchecked the errors before approve!!");
  //       return false;
  //     } else {

  //       return true;
  //     }
  //   }
  // };

  // if ($("#disapprovedButton").data('clicked')) {
  //   function check_checkbox() {
  //     if ($('.chk1').is(':checked')) {

  //       alert("Please unchecked the errors before approve!!");
  //       return false;
  //     } else {

  //       return true;
  //     }
  //   }
  // }

  $("#approvedButton").click(function(event) {
    if ($('.chk1').is(':checked')) {

      alert("Please unchecked the errors before approve!!");
      event.preventDefault(); // cancel default behavior
    } else {

      return true;
    }

  });

  $("#disapprovedButton").click(function(event) {
    if ($('.chk1').is(':checked')) {

     return true
    } else {

      alert("Please check the errors before disapprove!!");
      event.preventDefault(); // cancel default behavior
    }

  });

  // function check_checkbox() {

  //   if ($('.chk1').is(':checked')) {

  //     alert("Please unchecked the errors before approve!!");
  //     return false;
  //   } else {

  //     return true;
  //   }
  // }


  //
  // $(document).on('click', '#approvedButton', function (ev) {
  // //function validate() {
  //       // if (document.getElementsByClassName('chk1').checked) {
  //       //     alert("Please unchecked the items before approve!!");
  //       // }else{
  //       //   alert("asd");
  //       // }

  //       $('.chk1').each(function () {
  //       var chk_bx = $(this).is(':checked');

  //       if(chk_bx){
  //         chk_counter++;
  //       }

  //       if(chk_counter == 0){
  //         $(this).unbind('#approvedButton').submit()
  //         return true;
  //       }else if(chk_counter > 0){
  //         ev.preventDefault();
  //         alert("Please unchecked the items before approve!!");


  //         return false;
  //       }
  //     });

  //     $(this).attr('disabled','disabled');
  //       $('#approvalForm').submit();
  // });

  // function validate() {
  //   var chk_counter = 0;
  //   // if (document.getElementsByClassName('chk1').checked) {
  //   //   alert("Please unchecked the items before approve!!");
  //   // } else {
  //   //   alert("asd");
  //   // }
  //           $('.chk1').each(function (ev) {
  //       var chk_bx = $(this).is(':checked');

  //       if(chk_bx){
  //         chk_counter++;
  //       }

  //       if(chk_counter == 0){
  //         $(this).unbind('submit').submit()
  //         return true;
  //       }else{
  //         ev.preventDefault();
  //         alert("Please unchecked the items before approve!!");
  //         return false;
  //       }
  //     });


  // }


  //}
  // $(document).ready(function() {
  //   //$(function() {

  //     $("input:checkbox").on("change", function() {
  //       var chk_id = $(this).attr("id");
  //       var value = $(this).is(':checked') ? 1 : 0;

  //       $.ajax({
  //         type: "POST",
  //         url: "/rejected-receipt/" + chk_id,
  //         dataType: "json",
  //         data: {},
  //         success: function(data) {
  //           alert(data);
  //         },
  //         error: function(xhr, status, error) {
  //           alert(error);
  //         }
  //       });

  //     });














  // $('input[type="checkbox"]').click(function() {
  //   if ($(this).is(":checked")) {
  //     var chk_id = $('.chk').val();
  //     $.ajax({
  //       url: "{{ route('reject') }}",
  //       cache: true,
  //       dataType: "json",
  //       type: "POST",
  //       data: {
  //         "lines_id": chk_id,
  //           "value": "1"
  //       },

  //     });
  //   } else if ($(this).is(":not(:checked)")) {
  //     var chk_id = $('.chk').val();
  //     $.ajax({
  //       url: "{{ route('reject') }}",
  //       cache: true,
  //       dataType: "json",
  //       type: "POST",
  //       data: {
  //           "lines_id": chk_id,
  //           "value" : "0"
  //       },

  //     });
  //   }
  //});

  //});

  $(document).ready(function() {
    $('#tQuantity').val(calculateTotalQuantity());
    $('#tValue').val(calculateTotalValue());
    $('#tValue2').val(calculateTotalValue2());
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