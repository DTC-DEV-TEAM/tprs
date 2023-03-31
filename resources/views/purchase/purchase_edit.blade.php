@extends('crudbooster::admin_template')
@section('content')

<section class="content">

    <div class="box box-default">

        <!-- /.box-header -->
        <div class="box-body">
            <form action="{{ CRUDBooster::mainpath('edit-save/'.$purchase_header->po_header_id) }}" method="POST" id="purchaseEditForm">
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

                    <div class="col-md-3" style="display:none;">
                        <div class="form-group">
                            <label class="require control-label">{{ trans('message.form-label.channel') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="channels_id" id="channels_id">
                                @foreach($channelData as $data)
                                    <option value="{{$data->id}}">{{$data->channel_name}}</option>
                                @endforeach
                            </select>
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
                                <div class="input-group-addon">#</div>
                                <input id="reference_read" class="form-control" readonly value="{{ $purchase_header->po_reference }}" type="text">
                                <input type="hidden" name="po_reference" id="reference_write" value="{{ $purchase_header->po_reference }}">
                            </div>
                            <span id="error-msg" class="text-danger"></span>
                        </div>
                    </div>

                </div><!-- /.row -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">{{ trans('message.form-label.add_item') }}</label>
                            <input class="form-control auto" placeholder="Search Item" id="search">
                            <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-2" tabindex="0" style="display: none; top: 60px; left: 15px; width: 520px;">
                                <li>Loading...</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">{{ trans('message.form-label.timer') }}<span class="text-danger"></span></label>
                            <div class="input-group">
                                <div class="input-group-addon"> <i class="fa fa-clock-o"></i> </div>
                                <input id="timer" class="form-control" tabindex="-1" readonly type="text">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="box-header text-center">
                        <h3 class="box-title"><b>{{ trans('message.form-label.purchase_items') }}</b></h3>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="purchase-items">
                                    <tbody>

                                        <tr class="tbl_header_color dynamicRows">
                                            <th width="15%" class="text-center">{{ trans('message.table.digits_code') }}</th>
                                            <th width="15%" class="text-center">{{ trans('message.table.upc_code') }}</th>
                                            <th width="30%" class="text-center">{{ trans('message.table.item_description') }}</th>
                                            <th width="10%" class="text-center">{{ trans('message.table.reservable_quantity') }} </th>
                                            <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                                            <th width="10%" class="text-center">{{ trans('message.table.store_quantity') }}</th>
                                            <th width="10%" class="text-center" style="display: none;">{{ trans('message.table.store_margin') }}</th>
                                            <th width="10%" class="text-center" style="display: none;">{{ trans('message.table.sku_status') }}</th>
                                            <th width="10%" class="text-center">{{ trans('message.table.segmentation') }}</th>
                                            <th width="5%" class="text-center">{{ trans('message.table.action') }}</th>
                                        </tr>

                                        @foreach ($purchase_lines as $data)
                                            @if($data->sku_legend_description == 'X')
                                            <tr id="rowid{{$data->item_id}}" bgcolor="red">
                                                <td align="center">
                                                    <input type="text" tabindex="-1" class="form-control text-center" name="digits_code[]" readonly value="{{$data->digits_code}}">
                                                </td>
                                                <td align="center">
                                                    <input type="text" tabindex="-1" class="form-control" name="upc_code[]" readonly value="{{$data->upc_code}}">
                                                </td>
                                                <td>
                                                    <input type="text" tabindex="-1"  class="form-control" name="item_description[]" readonly value="{{$data->item_description}}">
                                                    <input type="hidden" name="item_id[]" value="{{ $data->item_id }}">
                                                </td>
                                                <td align="center">
                                                    <input type="text" tabindex="-1" class="form-control text-center" readonly name="quantity_reservable[]" id="ajax_{{ $data->item_id }}" value="{{$data->quantity_reservable}}">
                                                </td>
                                                <td align="center">
                                                    <input type="number" class="form-control text-center no_units item_quantity" min="0" oninput="validity.valid||(value=0);" name="quantity_pre_ordered[]" id="qty_{{$data->item_id}}" data-id="{{$data->item_id}}" data-rate="{{$data->dtp_rf}}" value="{{$data->quantity_pre_ordered}}">
                                                </td>
                                                 <td align="center">
                                                    <input type="number" class="form-control text-center item_store_quantity" min="0" oninput="validity.valid||(value=0);" name="quantity_store_inventory[]" id="qty_store_{{$data->item_id}}" data-id="{{$data->item_id}}" data-rate="{{$data->dtp_rf}}" value="{{$data->quantity_store_inventory}}">
                                                </td>
                                                @if($channel != 3)
                                                    <td align="center" style="display: none;">
                                                        <input type="text" class="form-control text-center unitprice" readonly name="dtp_rf[]" data-id="{{$data->item_id}}" id="rate_id_{{$data->item_id}}" value="{{$data->dtp_rf}}">
                                                    </td>
                                                @else
                                                    <td align="center" style="display: none;">
                                                        <input type="text" class="form-control text-center unitprice" readonly name="current_srp[]" data-id="{{$data->item_id}}" id="rate_id_{{$data->item_id}}" value="{{$data->current_srp}}">
                                                    </td>
                                                @endif
                                                <td align="center" style="display: none;">
                                                    <input type="text" class="form-control text-center amount" readonly name="purchase_line_amount[]" size="4" id="amount_{{$data->item_id}}" value="{{$data->quantity_pre_ordered * $data->dtp_rf}}">
                                                </td>
                                                <td align="center" style="display: none;">
                                                    {{ $data->sku_status_description }}
                                                    <input class="form-control text-center" type="hidden" readonly name="skustatus_id[]" value="{{ $data->skustatus_id }}">
                                                </td>
                                                <td align="center">
                                                    @if(in_array($data->skulegend_id,$view_skulegend))
                                                    {{ $data->sku_legend_description }}
                                                    @endif
                                                    <input class="form-control text-center" type="hidden" readonly name="skulegend_id[]" value="{{ $data->skulegend_id }}">
                                                </td>
                                                <td align="center">
                                                    <button id="{{$data->item_id}}" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button>
                                                </td>
    
                                            </tr>
                                            @else
                                            <tr id="rowid{{$data->item_id}}">
                                                <td align="center">
                                                    <input type="text" tabindex="-1" class="form-control text-center" name="digits_code[]" readonly value="{{$data->digits_code}}">
                                                </td>
                                                <td align="center">
                                                    <input type="text" tabindex="-1" class="form-control" name="upc_code[]" readonly value="{{$data->upc_code}}">
                                                </td>
                                                <td>
                                                    <input type="text" tabindex="-1" class="form-control" name="item_description[]" readonly value="{{$data->item_description}}">
                                                    <input type="hidden" name="item_id[]" value="{{ $data->item_id }}">
                                                </td>
                                                <td align="center">
                                                    <input type="text" tabindex="-1" class="form-control text-center" readonly name="quantity_reservable[]" id="ajax_{{ $data->item_id }}" value="{{$data->quantity_reservable}}">
                                                </td>
                                                <td align="center">
                                                    <input type="number" class="form-control text-center no_units item_quantity" min="0" oninput="validity.valid||(value=0);" name="quantity_pre_ordered[]" id="qty_{{$data->item_id}}" data-id="{{$data->item_id}}" data-rate="{{$data->dtp_rf}}" value="{{$data->quantity_pre_ordered}}">
                                                </td>
                                                 <td align="center">
                                                    <input type="number" class="form-control text-center item_store_quantity" min="0" oninput="validity.valid||(value=0);" name="quantity_store_inventory[]" id="qty_store_{{$data->item_id}}" data-id="{{$data->item_id}}" data-rate="{{$data->dtp_rf}}" value="{{$data->quantity_store_inventory}}">
                                                </td>
                                                @if($channel != 3)
                                                    <td align="center" style="display: none;">
                                                        <input type="text" class="form-control text-center unitprice" readonly name="dtp_rf[]" data-id="{{$data->item_id}}" id="rate_id_{{$data->item_id}}" value="{{$data->dtp_rf}}">
                                                    </td>
                                                @else
                                                    <td align="center" style="display: none;">
                                                        <input type="text" class="form-control text-center unitprice" readonly name="current_srp[]" data-id="{{$data->item_id}}" id="rate_id_{{$data->item_id}}" value="{{$data->current_srp}}">
                                                    </td>
                                                @endif
                                                <td align="center" style="display: none;">
                                                    <input type="text" class="form-control text-center amount" readonly name="purchase_line_amount[]" size="4" id="amount_{{$data->item_id}}" value="{{$data->quantity_pre_ordered * $data->dtp_rf}}">
                                                </td>
                                                <td align="center" style="display: none;">
                                                    {{ $data->sku_status_description }}
                                                    <input class="form-control text-center" type="hidden" readonly name="skustatus_id[]" value="{{ $data->skustatus_id }}">
                                                </td>
                                                <td align="center" class="skulegend">
                                                    @if(in_array($data->skulegend_id,$view_skulegend))
                                                    {{ $data->sku_legend_description }}
                                                    @endif
                                                    <input class="form-control text-center" type="hidden" readonly name="skulegend_id[]" value="{{ $data->skulegend_id }}">
                                                </td>
                                                <td align="center">
                                                    <button id="{{$data->item_id}}" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button>
                                                </td>
    
                                            </tr>
                                            @endif
                                        
                                        <?php $stack[] = $data->item_id; ?>
                                        @endforeach

                                        <tr class="tableInfo">

                                            <td colspan="4" align="right"><strong>{{ trans('message.table.total_quantity') }}</strong></td>
                                            <td align="left" colspan="1">
                                                <input type='text' tabindex="-1" name="total_quantity" value="{{ $lines_total_qty }}" class="form-control text-center" id="totalQuantity" readonly></td>
                                                <input type='hidden' name="total_amount" value="P {{ number_format($purchase_header->total_amount, 2) }}" class="form-control" id="grandTotal" readonly>
                                            </td>
                                            <td colspan="1" align="right"><strong>{{ trans('message.table.total_skus') }}</strong></td>
                                            <td align="left" colspan="1">
                                                <input type='text' tabindex="-1" class="form-control text-center" id="totalSKUS" value="0" readonly></td>
                                            </td>
                                            <td colspan="1"></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <br><br>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <p style="color: red;">*Prioritization of orders will be based on approval matrix.</p>
                            <p style="color: red;">*Items with red background color are not part of your product segmentation.</p>
                            <p style="color: red;">*Send blank order if you have no orders for the week.</p>
                            <p style="color: red;">*Please limit your items to "<b>90</b>" SKUs per upload.</p>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('message.table.note') }}</label>
                            <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" onkeyup="this.value = this.value.replace(/[&^*</>@$]/g,'')" class="form-control" name="comments">{{$purchase_header->comments}}</textarea>
                        </div>

                        <div class="box-footer">
                            <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>
                            <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save" ></i> {{ trans('message.form.save') }}</button>
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

var stack = [];

$(document).ready(function () {
    //$(".select2").select2();
    refreshAt();
    timeRemaining();
    console.log(stack);

    $('#datepicker').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd/mm/yy'
    });

    $('#datepicker').datepicker('setDate', new Date());

    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    $(document).on('click', '#btnSubmit', function () {
        var rowCount = $('#purchase-items tr').length;
        var totalQty = $("#totalQuantity").val();
        var nullsku = 0;
        var p_qty = 0;
        var sto_invqty = 0;
        
        $('.skulegend').each(function () {
            var sku = $(this).text();
            console.log(sku);
            if(sku == 'null'){
                //return false;
                nullsku++;
            }
            
        });
        
        $('.item_quantity').each(function () {
            var proposed_qty = $(this).val();
            
            if(proposed_qty < 0 || proposed_qty == 0){
                p_qty++;
            }
            if(proposed_qty == ''){
                p_qty++;
            }
            if(proposed_qty == null){
                p_qty++;
            }
            
        });
        
        $('.skuh-legend').each(function () {
            var skuhlegend = $(this).val();
            
            if(skuhlegend == 'null' || skuhlegend == '' || skuhlegend == null || skuhlegend == "null"){
                //return false;
                nulledsku++;
            }
            
        });
        
        $('.item-reservable').each(function () {
            var blank_rsv = $(this).val();
            
            if(blank_rsv == 'null' || blank_rsv == '' || blank_rsv == null || blank_rsv == "null"){
                blankrsv++;
            }
            
        });
        
        $('.item-storeinventory').each(function () {
            var sto_qty = $(this).val();
            
            if(sto_qty < 0){
                sto_invqty++;
            }
            if(sto_qty == ''){
                sto_invqty++;
            }
            if(sto_qty == null){
                sto_invqty++;
            }
            
        });
        
        if(p_qty > 0){
            return false;
        }
        
        if(sto_invqty > 0){
            return false;
        }
        
        if(nullsku > 0){
            return false;
        }
        //console.log(rowCount);
        if(rowCount <= 2){
            return false;
        }
        if(totalQty == 'NaN') {
            return false;
        }
        
    });
});


function in_array(search, array) {
  if(!(array === null)){
    console.log('length: '+array.length);  
  }
  
  var trowCount = $('#purchase-items tr').length;
  var item_table = document.getElementById('purchase-items');
  
  if((item_table.rows.length > 2 || trowCount > 2) && !(array === null)) {
      for (i = 0; i < array.length; i++) {
        if (array[i] == search) {
          return true;
        }
      }
  }
  return false;
}

var stack = <?php echo json_encode($stack); ?>;
var token = $("#token").val();
var cnt_entered_items = 0;

$(document).ready(function(){
    $(function(){
        
        var store_id = $('#stores_id').val();
        var item_segmentation = '';
        var channel_id = $('#channels_id').val();
        var obj_skulegend = {!! json_encode($viewable_skulegend) !!};
        
        $.ajax({
                url: "{{ route('purchase.item.segmentation') }}",
                cache: true,
                dataType: "json",
                type: "POST",
                data: {
                    "_token": token,
                    "segment": store_id
                },
                success: function (data) {
                    item_segmentation = data.segmentation_column;
                }
        });
        
        $("#search").autocomplete({
            source: function (request, response) {
            $.ajax({
                url: "{{ route('purchase.item.search') }}",
                cache: true,
                dataType: "json",
                type: "POST",
                data: {
                    "_token": token,
                    "search": request.term,
                    "segment": item_segmentation
                },
                success: function (data) {

                    if (data.status_no == 1) {
                        $("#val_item").html();
                        var data = data.items;
                        $('#ui-id-2').css('display', 'none');
                        response($.map(data, function (item) {
                            return {
                            id: item.id,
                            stock_code: item.digits_code,
                            stock_upc: item.upc_code,
                            value: item.item_description,
                            stock_price: item.dtp_rf,
                            stock_current_price: item.current_srp,
                            sku_status: item.sku_status,
                            sku_status_id: item.sku_status_id,
                            sku_legend: item.sku_legend,
                            sku_legend_id: item.sku_legend_id
                            }
                        }));
                    } else {
                        $('.ui-menu-item').remove();
                        $('.addedLi').remove();
                        //$("#ui-id-1").append($("<li class='addedLi'>").text(data.message));
                        $("#ui-id-2").append("<li class='addedLi'>"+data.message+"</li>");
                        var searchVal = $("#search").val();
                        if (searchVal.length > 0) {
                            $("#ui-id-2").css('display', 'block');
                        } else {
                            $("#ui-id-2").css('display', 'none');
                        }
                    }
                }
            })
        },
        select: function (event, ui) {
            var e = ui.item;
            if (e.id) {
                //var trowCount = $('#purchase-items tr').length;
                var item_table = document.getElementById('purchase-items');
                if (!in_array(e.id, stack) || item_table >=2 || stack === null) {
                    
                    if(item_table.rows.length > 2) {
                        if(stack === null) {
                            stack = [];
                            stack.push(e.id);
                        }
                        else{
                            stack.push(e.id); 
                        }
                        console.log('current stack: '+stack);
                    }
                    if (e.sku_legend_id == 4 && channel_id != 3){
                        
                        var new_row = '<tr class="nr" bgcolor="red" id="rowid' + e.id + '">' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="new_digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                '<td><input class="form-control" type="text" tabindex="-1" name="new_upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                '<td><input class="form-control" type="text" tabindex="-1" name="new_item_description[]" readonly value="' + e.value + '"></td>' +
                                '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="new_quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="new_quantity_pre_ordered[]" value="0">' +
                                '<input type="hidden" name="new_item_id[]" value="' + e.id + '"></td>' +
                                '<td><input class="form-control text-center item_store_quantity" data-id="' + e.id + '" data-rate="' + e.stock_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_store_' + e.id + '" name="new_quantity_store_inventory[]" required>' +
                                '<td style="display: none;"><input min="0" type="text" class="form-control text-center unitprice" name="new_dtp_rf[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_price + '"></td>' +
                                '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_price+'" name="new_purchase_line_amount[]" readonly></td>' +
                                '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="new_skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+
                                '<td class="text-center skulegend">'+e.sku_legend+' <input type="hidden" class="skuh-legend" name="new_skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                '</tr>';
                    }
                    else if (e.sku_legend_id == 4 && channel_id == 3){
                        var new_row = '<tr class="nr" bgcolor="red" id="rowid' + e.id + '">' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="new_digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                '<td><input class="form-control" type="text" tabindex="-1" name="new_upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                '<td><input class="form-control" type="text" tabindex="-1" name="new_item_description[]" readonly value="' + e.value + '"></td>' +
                                '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="new_quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_current_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="new_quantity_pre_ordered[]" value="0">' +
                                '<input type="hidden" name="new_item_id[]" value="' + e.id + '"></td>' +
                                '<td><input class="form-control text-center item_store_quantity" data-id="' + e.id + '" data-rate="' + e.stock_current_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_store_' + e.id + '" name="new_quantity_store_inventory[]" required>' +
                                '<td style="display: none;"><input min="0" type="text" class="form-control text-center unitprice" name="new_current_srp[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_current_price + '"></td>' +
                                '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_current_price+'" name="new_purchase_line_amount[]" readonly></td>' +
                                '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="new_skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+
                                '<td class="text-center skulegend">'+e.sku_legend+' <input type="hidden" class="skuh-legend" name="new_skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                '</tr>';
                        
                    }
                    else if (e.sku_legend_id != 4 && channel_id == 3){
                        if(obj_skulegend.some( obj_skulegends => obj_skulegends['id'] === e.sku_legend_id )) {
                            var new_row = '<tr class="nr" id="rowid' + e.id + '">' +
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="new_digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="new_upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="new_item_description[]" readonly value="' + e.value + '"></td>' +
                                    '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="new_quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                    '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_current_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="new_quantity_pre_ordered[]" value="0">' +
                                    '<input type="hidden" name="new_item_id[]" value="' + e.id + '"></td>' +
                                    '<td><input class="form-control text-center item_store_quantity" data-id="' + e.id + '" data-rate="' + e.stock_current_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_store_' + e.id + '" name="new_quantity_store_inventory[]" required>' +
                                    '<td style="display: none;"><input min="0" type="text" class="form-control text-center unitprice" name="new_current_srp[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_current_price + '"></td>' +
                                    '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_current_price+'" name="new_purchase_line_amount[]" readonly></td>' +
                                    '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="new_skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+
                                    '<td class="text-center skulegend">'+e.sku_legend+' <input type="hidden" class="skuh-legend" name="new_skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                    '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                    '</tr>';
                        }
                        else {
                            var new_row = '<tr class="nr" id="rowid' + e.id + '">' +
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="new_digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="new_upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="new_item_description[]" readonly value="' + e.value + '"></td>' +
                                    '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="new_quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                    '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_current_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="new_quantity_pre_ordered[]" value="0">' +
                                    '<input type="hidden" name="new_item_id[]" value="' + e.id + '"></td>' +
                                    '<td><input class="form-control text-center item_store_quantity" data-id="' + e.id + '" data-rate="' + e.stock_current_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_store_' + e.id + '" name="new_quantity_store_inventory[]" required>' +
                                    '<td style="display: none;"><input min="0" type="text" class="form-control text-center unitprice" name="new_current_srp[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_current_price + '"></td>' +
                                    '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_current_price+'" name="new_purchase_line_amount[]" readonly></td>' +
                                    '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="new_skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+
                                    '<td class="text-center skulegend"><input type="hidden" class="skuh-legend" name="new_skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                    '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                    '</tr>';
                        }
                        
                    }
                    else {
                        if(obj_skulegend.some( obj_skulegends => obj_skulegends['id'] === e.sku_legend_id )) {
                            var new_row = '<tr class="nr" id="rowid' + e.id + '">' +
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="new_digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="new_upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="new_item_description[]" readonly value="' + e.value + '"></td>' +
                                    '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="new_quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                    '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="new_quantity_pre_ordered[]" value="0">' +
                                    '<input type="hidden" name="new_item_id[]" value="' + e.id + '"></td>' +
                                    '<td><input class="form-control text-center item_store_quantity" data-id="' + e.id + '" data-rate="' + e.stock_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_store_' + e.id + '" name="new_quantity_store_inventory[]" required>' +
                                    '<td style="display: none;"><input min="0" type="text" class="form-control text-center unitprice" name="new_dtp_rf[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_price + '"></td>' +
                                    '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_price+'" name="new_purchase_line_amount[]" readonly></td>' +
                                    '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="new_skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+
                                    '<td class="text-center skulegend">'+e.sku_legend+' <input type="hidden" class="skuh-legend" name="new_skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                    '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                    '</tr>'; 
                        }
                        else {
                            var new_row = '<tr class="nr" id="rowid' + e.id + '">' +
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="new_digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="new_upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="new_item_description[]" readonly value="' + e.value + '"></td>' +
                                    '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="new_quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                    '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="new_quantity_pre_ordered[]" value="0">' +
                                    '<input type="hidden" name="new_item_id[]" value="' + e.id + '"></td>' +
                                    '<td><input class="form-control text-center item_store_quantity" data-id="' + e.id + '" data-rate="' + e.stock_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_store_' + e.id + '" name="new_quantity_store_inventory[]" required>' +
                                    '<td style="display: none;"><input min="0" type="text" class="form-control text-center unitprice" name="new_dtp_rf[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_price + '"></td>' +
                                    '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_price+'" name="new_purchase_line_amount[]" readonly></td>' +
                                    '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="new_skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+
                                    '<td class="text-center skulegend"><input type="hidden" class="skuh-legend" name="new_skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                    '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                    '</tr>';
                        }
                    }
                    
                    $(new_row).insertAfter($('table tr.dynamicRows:last'));

                    // For tax select option
                    $(function () {
                        var itm = $("#search").val();
                        if(itm != '' || itm.length > 0) {
                            var lastRow = 0;

                            setInterval(function() { 
                                var item_table = document.getElementById('purchase-items');
                                var rowCount = item_table.rows.length - 1; //header
                                var cellcode = '';

                                for (var r = 1, n = rowCount; r < n; r++) {
                                    for (var c = 0, m = item_table.rows[r].cells.length; c < 1; c++) {
                                        var cellval = item_table.rows[r].cells[c].innerHTML;
                                        var celltemp = cellval.substr(-10);
                                        cellcode = celltemp.substr(0,8);
                                    }

                                    if(r == (n-1)) { //footer
                                        lastRow = 1;
                                    }
                                    if(lastRow == 0) {
                                        setOnHandQty(cellcode, '#ajax_'+cellcode);
                                    }
                                    if(rowCount == 2){
                                        setOnHandQty(cellcode, '#ajax_'+cellcode);
                                    }
                                }
                            }, 1000);
                        }
                    });

                    // Calculate subtotal
                    var subTotal = calculateSubTotal();
                    $("#grandTotal").val(subTotal);
                    var total_Quantity = calculateTotalQuantity();
                    $("#totalQuantity").val(total_Quantity);
                    var skuCount = document.getElementById('purchase-items').rows.length - 2;
                    $("#totalSKUS").val(skuCount);
                    $('.tableInfo').show();

                } else {
                    $('#qty_' + e.id).val(function (i, oldval) {
                    return ++oldval;
                    });
                    var q = $('#qty_' + e.id).val();
                    var r = $("#rate_id_" + e.id).val();

                    $('#amount_' + e.id).val(function (i, amount) {
                    if (q != 0) {
                        var itemPrice = (q * r);
                        return itemPrice;
                    } else {
                        return 0;
                    }
                    });

                    // Calculate subTotal
                    var subTotal = calculateSubTotal();
                    $("#grandTotal").val(subTotal);
                    var total_Quantity = calculateTotalQuantity();
                    $("#totalQuantity").val(total_Quantity);
                    var skuCount = document.getElementById('purchase-items').rows.length - 2;
                    $("#totalSKUS").val(skuCount);
                }

                $(this).val('');
                $('#val_item').html('');
                return false;
            }
        },
        minLength: 1,
        autoFocus: true
        });
    });
});

$(document).on('keyup', '.no_units', function (ev) {

    var id = $(this).attr("data-id");
    var qty = parseInt($(this).val());
    var rate = $("#rate_id_" + id).val();
    var price = calculatePrice(qty, rate);

    $("#amount_" + id).val(price);

    // Calculate subTotal
    var subTotal = calculateSubTotal();
    $("#grandTotal").val(subTotal);

    var totalQuantity = calculateTotalQuantity();
    $("#totalQuantity").val(totalQuantity);
    
    var skuCount = document.getElementById('purchase-items').rows.length - 2;
    $("#totalSKUS").val(skuCount);

});

// calculate amount with unit price
$(document).on('keyup', '.unitprice', function (ev) {

    var unitprice = parseFloat($(this).val());
    var id = $(this).attr("data-id");
    var qty = $("#qty_" + id).val();
    var rate = $("#rate_id_" + id).val();
    var price = calculatePrice(qty, rate);

    $("#amount_" + id).val(price);

    // Calculate subTotal
    var subTotal = calculateSubTotal();
    $("#grandTotal").val(subTotal);

});

// Delete item row
$(document).ready(function (e) {
  $('#purchase-items').on('click', '.delete_item', function () {
    var v = $(this).attr("id");
    stack = jQuery.grep(stack, function (value) {
      return value != v;
    });

    $(this).closest("tr").remove();

    var subTotal = calculateSubTotal();
    $("#grandTotal").val(subTotal);
    
    var totalQuantity = calculateTotalQuantity();
    $("#totalQuantity").val(totalQuantity);
    
    var skuCount = document.getElementById('purchase-items').rows.length - 2;
    $("#totalSKUS").val(skuCount);

  });
});

function pushToStack() {
  $('.delete_item').each(function () {
      var $input = $(this);
    stack.push($input.attr('id'));
  });
}

function calculateSubTotal() {
  var subTotal = 0;
  $('.amount').each(function () {
    subTotal += parseInt($(this).val());
  });
  return currencyFormat(subTotal);
}

function calculatePrice(qty, rate) {
  if (qty != 0) {
    var price = (qty * rate);
    return price;
  } else {
    return '0';
  }
}

$("#search").on('keyup', function () {
  var searchVal = $("#search").val();
  if (searchVal.length > 0) {
    $("#ui-id-2").css('display', 'block');
  } else {
    $("#ui-id-2").css('display', 'none');
  }
});

function setOnHandQty(itemcode, display_rsv) {
  var channelval = $('#channels_id').val();
  //console.log(display_rsv);
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

function calculateTotalQuantity() {
  var totalQuantity = 0;
  $('.item_quantity').each(function () {
    totalQuantity += parseInt($(this).val());
  });
  return totalQuantity;
}

function refreshAt() {
    var now = new Date();
    var then = new Date("{{ $schedule }}");
    console.log(then);

    if(then <= now){
        then = now;
    }

    var timeout = (then.getTime() - now.getTime());
    setTimeout(function() { 
        window.location.reload(true); 
    }, timeout);
}

function timeRemaining() {
    var endDate = new Date("{{ $schedule }}").getTime();

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