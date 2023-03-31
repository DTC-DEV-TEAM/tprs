@extends('crudbooster::admin_template')
@section('content')

<section class="content">

    <div class="box box-default">

        <!-- /.box-header -->
        <div class="box-body">
            <form action="{{ route('purchase_order.approvedorder') }}" method="POST" id="purchaseApprovalForm">
                <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">

                <div class="row">
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="require control-label">{{ trans('message.form-label.store') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="stores_id" id="stores_id">
                                @foreach($storesData as $data)
                                    <option value="{{$data->id}}">{{$data->store_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="require control-label">{{ trans('message.form-label.channel') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="channels_id" id="channels_id">
                                <option value="{{$channelData->id}}">{{$channelData->channel_name}}</option>
                            </select>
                            <input type="hidden" name="stores_id" value="{{ $purchase_header->stores_id }}">
                            <input type="hidden" name="segmentation_column" value="{{ $segmentation_column }}">
                            <input type="hidden" name="segmentation_id" value="{{ $segmentation_id }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label require">{{ trans('message.form-label.orderdate') }}:</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input class="form-control" readonly disabled id="datepicker" type="text" value="{{ date('Y-m-d', strtotime($purchase_header->order_date)) }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">{{ trans('message.form-label.reference') }}<span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <div class="input-group-addon">MRS-</div>
                                <input id="reference_read" class="form-control" readonly value="{{ $purchase_header->po_reference }}" type="text">
                                <input type="hidden" name="po_reference" id="reference_write" value="{{ $purchase_header->po_reference }}">
                            </div>
                            <span id="error-msg" class="text-danger"></span>
                        </div>
                    </div>

                </div>
                
                <div class="row">
                    <div class="col-md-3 pull-right">
                        <div class="form-group">
                            <label class="control-label">{{ trans('message.form-label.timer') }}<span class="text-danger"></span></label>
                            <div class="input-group">
                                <div class="input-group-addon"> <i class="fa fa-clock-o"></i> </div>
                                <input id="timer" class="form-control" readonly type="text">
                            </div>
                        </div>
                    </div>
                </div>
                
                <br>

                <div class="row">
                    <div class="col-md-12">
                        <div class="box-header text-center">
                        <h3 class="box-title"><b>{{ trans('message.form-label.purchase_items') }}</b></h3>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-bordered table_dashboard" id="purchase-items">
                                    <thead>
                                        <tr class="active">
                                            <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.digits_code') }}</th>
                                            <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.upc_code') }}</th>
                                            <th width="20%" class="text-center" style="vertical-align: top;">{{ trans('message.table.item_description') }}</th>
                                            <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.reservable_quantity') }} </th>
                                            <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.store_quantity') }} </th>
                                            <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.prev_balance_quantity') }} </th>
                                            <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.quantity') }}</th>
                                            <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.approved_quantity') }}</th>
                                            @if($channel == 3)
                                                <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.current_srp') }}</th>
                                            @else
                                                <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.store_margin') }}</th>
                                            @endif
                                            <th width="10%" class="text-center" style="vertical-align: top;">{{ trans('message.table.line_amount') }}</th>
                                            <th width="5%" class="text-center" style="vertical-align: top;">{{ trans('message.table.segmentation') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($purchase_lines as $item)
                                            @if($item->sku_legend_description == 'X')
                                            <tr bgcolor="red">
                                                <td class="text-center">{{ $item->digits_code }}<input type="hidden" readonly name="digits_code[]" value="{{$item->digits_code}}">
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->upc_code }}
                                                </td>
                                                <td>
                                                    {{ $item->item_description }}
                                                </td>
                                                <td>
                                                    <input class="form-control text-center item-reservable" type="text" readonly id="ajax_{{$item->digits_code}}" name="quantity_reservable[]" value="NaN">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-control text-center" type="text" readonly id="quantity-store" value="{{ $item->quantity_store_inventory }}">
                                                </td>
                                                <!--additional code 20200115-->
                                                <td class="text-center">
                                                    <input class="form-control text-center" type="text" readonly id="quantity-prevbal" value="{{ $item->quantity_prev_balance }}">
                                                </td>
                                                <!--end - additional code 20200115-->
                                                <td class="text-center">
                                                    <input class="form-control text-center" type="text" readonly id="quantity-preordered" value="{{ $item->quantity_pre_ordered }}">
                                                </td>
                                                <td>
                                                    <input id="qty_{{$item->digits_code}}" data-id="{{$item->digits_code}}" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" class="form-control text-center no_units item_quantity" value="{{$item->quantity_pre_ordered}}" name="quantity_ordered[]" data-rate="{{$item->dtp_rf}}">
                                                </td>
                                                
                                                @if($channel == 3)
                                                    <td class="text-center">
                                                        {{ number_format($item->current_srp, 2) }}
                                                        <input type="hidden" class="form-control text-center unitprice" readonly data-id = "{{$item->digits_code}}" id="rate_id_{{$item->digits_code}}" name="current_srp[]" value="{{$item->current_srp}}">
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        {{ number_format($item->dtp_rf, 2) }}
                                                        <input type="hidden" class="form-control text-center unitprice" readonly data-id = "{{$item->digits_code}}" id="rate_id_{{$item->digits_code}}" name="dtp_rf[]" value="{{$item->dtp_rf}}">
                                                    </td>
                                                @endif
                                                
                                                <td class="text-center purchase_amount_txt" id="line_amount_{{$item->digits_code}}">
                                                    {{ number_format($item->purchase_line_amount, 2) }}
                                                    <input class="form-control text-center amount purchase_amount" type="hidden" id="amount_{{$item->digits_code}}" value="{{$item->purchase_line_amount}}" name="purchase_line_amount[]" readonly>
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->sku_legend_description }}
                                                    <input class="form-control text-center" type="hidden" readonly name="skustatus_id[]" value="{{ $item->skustatus_id }}">
                                                    <input class="form-control text-center" type="hidden" readonly name="skulegend_id[]" value="{{ $item->skulegend_id }}">
                                                    <input class="form-control text-center" type="hidden" readonly name="sku_legend_description[]" value="{{ $item->sku_legend_description }}">
                                                    
                                                </td>
                                            </tr>
                                            
                                            @else 
                                            <tr>
                                                <td class="text-center">{{ $item->digits_code }}<input type="hidden" readonly name="digits_code[]" value="{{$item->digits_code}}">
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->upc_code }}
                                                </td>
                                                <td>
                                                    {{ $item->item_description }}
                                                </td>
                                                <td>
                                                    <input class="form-control text-center item-reservable" type="text" readonly id="ajax_{{$item->digits_code}}" name="quantity_reservable[]" value="NaN">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-control text-center" type="text" readonly id="quantity-store" value="{{ $item->quantity_store_inventory }}">
                                                </td>
                                                <!--additional code 20200115-->
                                                <td class="text-center">
                                                    <input class="form-control text-center" type="text" readonly id="quantity-prevbal" value="{{ $item->quantity_prev_balance }}">
                                                </td>
                                                <!--end - additional code 20200115-->
                                                <td class="text-center">
                                                    <input class="form-control text-center" type="text" readonly id="quantity-preordered" value="{{ $item->quantity_pre_ordered }}">
                                                </td>
                                                <td>
                                                    <input id="qty_{{$item->digits_code}}" data-id="{{$item->digits_code}}" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" class="form-control text-center no_units item_quantity" value="{{$item->quantity_pre_ordered}}" name="quantity_ordered[]" data-rate="{{$item->dtp_rf}}">
                                                </td>
                                                
                                                @if($channel == 3)
                                                    <td class="text-center">
                                                        {{ number_format($item->current_srp, 2) }}
                                                        <input type="hidden" class="form-control text-center unitprice" readonly data-id = "{{$item->digits_code}}" id="rate_id_{{$item->digits_code}}" name="current_srp[]" value="{{$item->current_srp}}">
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        {{ number_format($item->dtp_rf, 2) }}
                                                        <input type="hidden" class="form-control text-center unitprice" readonly data-id = "{{$item->digits_code}}" id="rate_id_{{$item->digits_code}}" name="dtp_rf[]" value="{{$item->dtp_rf}}">
                                                    </td>
                                                @endif
                                                
                                                <td class="text-center purchase_amount_txt" id="line_amount_{{$item->digits_code}}">
                                                    {{ number_format($item->purchase_line_amount, 2) }}
                                                    <input class="form-control text-center amount purchase_amount" type="hidden" id="amount_{{$item->digits_code}}" value="{{$item->purchase_line_amount}}" name="purchase_line_amount[]" readonly>
                                                </td>
                                                <td class="text-center">
                                                    {{ $item->sku_legend_description }}
                                                    <input class="form-control text-center" type="hidden" readonly name="skustatus_id[]" value="{{ $item->skustatus_id }}">
                                                    <input class="form-control text-center" type="hidden" readonly name="skulegend_id[]" value="{{ $item->skulegend_id }}">
                                                    <input class="form-control text-center" type="hidden" readonly name="sku_legend_description[]" value="{{ $item->sku_legend_description }}">
                                                    
                                                </td>
                                            </tr>
                                            
                                            @endif
                                        @endforeach

                                        <tr class="tableInfo">
                                            <td colspan="6" class="text-right"><b>Total Quantity</b></td><!--additional code 20200115-->
                                            <td colspan="1" class="text-center">{{ $lines_total_qty }}</td>
                                            <td colspan="1" class="text-center total_approved_qty" id="total_approved_qty">
                                                {{ $lines_approved_total_qty }}
                                                
                                            </td>
                                            <td colspan="1" align="right" valign="middle"><strong>{{ trans('message.table.grand_total') }}</strong></td>
                                            <td align="left" colspan="2">
                                                <input type='text' name="total_amount" class="form-control" id="grandTotal" readonly value="{{ number_format($purchase_header->total_amount, 2) }}" >
                                                <input type="hidden" value="{{ $lines_approved_total_qty }}" name="total_quantity" id="total_quantity">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p style="color: red;">*Prioritization of orders will be based on approval matrix.</p>
                            <p style="color: red;">*Items with red background color are not part of your product segmentation.</p>
                        </div>

                    </div>

                    <div class="col-md-12">
                        
                        <div class="form-group">
                            <label>{{ trans('message.table.note') }}</label>
                            <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" id="comment_approver" onkeyup="this.value = this.value.replace(/[&^*</>@$]/g,'')" class="form-control comment_approver" name="comments">{{$purchase_header->comments}}</textarea>
                        </div>

                        <div class="box-footer">
                            <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>
                            <a href="{{ route('purchase_order.reject', [$purchase_header->po_reference,'comments']) }}" id="orderReject">
                                <button class="btn btn-danger pull-right" type="button" id="btnReject" style="margin-left: 5px;"><i class="fa fa-thumbs-down" ></i> Reject</button>
                                <input type="hidden" name="approver_comment" id="approver_comment" value="{{$purchase_header->comments}}">
                            </a>
                            
                            <button class="btn btn-success pull-right" type="submit" id="btnApprove"><i class="fa fa-thumbs-up" ></i> Approve</button>
                            
                        </div>

                    </div>

                </div>

            </form>
            
        </div>
    
    </div>

</section>

@endsection

@push('bottom')
<script type="text/javascript">

$(document).ready(function () {
    refreshAt();
    timeRemaining();
    $("#btnApprove").prop("disabled", true);
    setTimeout(function(){
        $("#btnApprove").prop("disabled", false);
    }, 10000);

    var getOnHand = setInterval(function() { 
        var item_table = document.getElementById('purchase-items');
        for (var r = 1, n = item_table.rows.length - 1; r < n; r++) {
            for (var c = 0, m = item_table.rows[r].cells.length; c < 1; c++) {
                
                var cellcode = item_table.rows[r].cells[c].innerHTML.substr(0,8);
                setOnHandQty(cellcode, '#ajax_'+cellcode);
            }
        }
    }, 1000);
    
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
    
    $('#btnApprove').click(function() {
        $("#comment_approver").prop("required", false);
        
        var app_qty = 0;
        var blankrsv = 0;
        
        $('.item-reservable').each(function () {
            var blank_rsv = $(this).val();
            
            if(blank_rsv == 'null' || blank_rsv == '' || blank_rsv == null || blank_rsv == "null" || blank_rsv == "NaN"){
                blankrsv++;
            }
            
        });
        
        $('.item_quantity').each(function () {
            var appr_qty = $(this).val();
            
            if(appr_qty < 0){
                app_qty++;
            }
            if(appr_qty == ''){
                app_qty++;
            }
            if(appr_qty == null){
                app_qty++;
            }
            
        });
        
        if(app_qty>0){
            return false;
        }
        if(blankrsv>0){
            return false;
        }
        
        clearInterval(getOnHand);
        $(this).attr('disabled','disabled');
        $('#purchaseApprovalForm').submit();
    });
    
    var approver_comment = "";
    $(document).on('keyup', '.comment_approver', function () {
        var comment = $(this).val();
        if(comment != ''){
            approver_comment = $('#approver_comment').val(comment);
        }
        else{
            approver_comment = "rejected!";
        }
    });
    
    $('#btnReject').click(function() {
        $("#comment_approver").prop("required", true);
        approver_comment = $('#approver_comment').val();
        if(approver_comment == ''){
           approver_comment = "rejected!"; 
        }
        $('#orderReject').attr("href", "{{ url('/admin/order_approval/reject')}}/{{$purchase_header->po_reference}}/"+approver_comment+"");
    });
});

var token = $("#token").val();

$(document).on('keyup', '.no_units', function () {

    var id = $(this).attr("data-id");
    var qty = parseInt($(this).val());
    var rate = $("#rate_id_" + id).val();
    var price = calculatePrice(qty, rate);
    
    $("#line_amount_" + id).html(price+"<input class='form-control text-center amount purchase_amount' type='hidden' id='amount_"+id+"' value='"+price+"' name='purchase_line_amount[]' readonly>");
    //$("#amount_" + id).val(price);
    
    var totalQty = calculateTotalQuantity();
    $("#total_approved_qty").html(totalQty);
    $("#total_quantity").val(totalQty);
    
    var gTotal = calculateSubTotal();
    $("#grandTotal").val(gTotal);

});

function calculateSubTotal() {
  var sTotal = 0;
    $('.purchase_amount').each(function () {
        sTotal += parseFloat($(this).val());
    });
    return currencyFormat(sTotal);
}

function calculateTotalQuantity() {
  var totalQuantity = 0;
  $('.item_quantity').each(function () {
    totalQuantity += parseInt($(this).val());
  });
  return totalQuantity;
}

function calculatePrice(qty, rate) {
  if (qty != 0) {
    var price = (qty * rate);
    
    return price.toFixed(2);
    
  } else {
    return '0';
  }
}

function setOnHandQty(itemcode, display_rsv) {
  var channelval = $('#channels_id').val();
  
  $.ajax({
    url: "{{ route('purchase.item.onhand') }}",
    dataType: "json",
    type: "POST",
    data: {
        _token: token,
        stockcode: itemcode,
        groupcode: channelval
    },
    success: function(data){
        $(display_rsv).val(data);
    }
  });
}

function currencyFormat(num) {
  return 'P ' + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
}

function refreshAt() {
    var now = new Date();
    var then = new Date("{!! $schedule !!}");
    //console.log(then);

    if(then <= now){
        then = now;
    }

    var timeout = (then.getTime() - now.getTime());
    setTimeout(function() { window.location.reload(true); }, timeout);
}

function timeRemaining() {
    var endDate = new Date("{!! $schedule !!}").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        var now = new Date().getTime();
        var remainingTime = endDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
        var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

        document.getElementById("timer").value = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

        if (remainingTime < 0) {
            clearInterval(x);
            document.getElementById("timer").value = "EXPIRED";
        }
    }, 1000);
}

</script>
@endpush