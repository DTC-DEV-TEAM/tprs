@extends('crudbooster::admin_template')
@section('content')

<section class="content">

    <div class="box box-default">

        <!-- /.box-header -->
        <div class="box-body">
            <form action="{{ CRUDBooster::mainpath('add-save') }}" method="POST" id="purchaseForm">
                <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
                <input type="hidden" value="" name="image_file" id="image_file">

                <div class="row">

                    <div class="col-md-3" style="display:none;">
                        <div class="form-group">
                            <label class="require control-label">{{ trans('message.form-label.supplier') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="suppliers_id" id="suppliers_id">
                                @foreach($supplierData as $data)
                                    <option value="{{$data->id}}">{{$data->supplier_name}}</option>
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
                            <label class="control-label require">{{ trans('message.form-label.orderdate') }}:</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input class="form-control" readonly disabled id="datepicker" type="text" value="{{ date('Y-d-m') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">{{ trans('message.form-label.timer') }}<span class="text-danger"></span></label>
                            <div class="input-group">
                                <div class="input-group-addon"> <i class="fa fa-clock-o"></i> </div>
                                <input id="timer" class="form-control" readonly tabindex="-1" type="text">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">Upload Purchase Order Screenshot:</label>
                            <button type="button" id="image-uploader" class="btn btn-info" tabindex="-1" data-toggle="modal" data-target="#image-upload-modal" style="width: 150px;"><i class="fa fa-picture-o" aria-hidden="true"></i> Upload Image</button>
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
                            <ul class="ui-autocomplete ui-front ui-menu ui-widget ui-widget-content" id="ui-id-1" tabindex="0" style="display: none; top: 60px; left: 15px; width: 520px;">
                                <li>No Item Found!</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-md-offset-3">
                        <div class="form-group">
                            <label class="control-label">Upload Excel Order:</label>
                            <button type="button" id="excel-uploader" class="btn btn-primary" tabindex="-1" data-toggle="modal" data-target="#excel-upload-modal" style="width: 150px;"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Upload Excel</button>
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
                                            <th width="10%" class="text-center">{{ trans('message.table.prev_balance_quantity') }} </th>
                                            <th width="10%" class="text-center">{{ trans('message.table.quantity') }}</th>
                                            <th width="10%" class="text-center">{{ trans('message.table.store_quantity') }}</th>
                                            <th width="10%" style="display: none;" class="text-center">{{ trans('message.table.store_margin') }}</th>
                                            <th width="10%" style="display: none;" class="text-center">{{ trans('message.table.current_srp') }}</th>
                                            <th width="10%" style="display: none;" class="text-center">{{ trans('message.table.sku_status') }}</th>
                                            <th width="10%" class="text-center">{{ trans('message.table.segmentation') }}</th>
                                            <th width="5%" class="text-center">{{ trans('message.table.action') }}</th>
                                        </tr>

                                        <tr class="tableInfo">
                                            
                                            <td colspan="5" align="right"><strong>{{ trans('message.table.total_quantity') }}</strong></td>
                                            <td align="left" colspan="1">
                                                <input type='text' tabindex="-1" name="total_quantity" class="form-control text-center" id="totalQuantity" value="0" readonly></td>
                                                <input type='hidden' name="total_amount" class="form-control" id="grandTotal" readonly>
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
                            <br>
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
                            <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" onkeyup="this.value = this.value.replace(/[&^*</>@$]/g,'')" class="form-control" tabindex="-1" name="comments"></textarea>
                        </div>

                        <div class="box-footer">
                            <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>
                            <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save" ></i> {{ trans('message.form.save') }}</button>
                            <button class="btn btn-danger pull-right" type="button" style="margin-right:10px;" tabindex="-1" data-toggle="modal" data-target="#create-blankOrder"> <i class="fa fa-save" ></i> {{ trans('message.form.save_blank') }}</button>
                        </div>

                    </div>

                </div>

            </form>
            
        </div>
    
    </div>
    
    
    <!-- Modal -->
    <div class="modal fade" id="excel-upload-modal" role="dialog">
    	<div class="modal-dialog">
    
    		<!-- Modal content-->
    		<div class="modal-content">
    		<div class="modal-header alert-info">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
    			<h3 class="modal-title">Upload Excel</h3>
    		</div>
    		<form class="form-horizontal" id="excel-form" method="post" role="form" enctype="multipart/form-data">
        		<input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        		<div class="modal-body">
        		    <div class='callout callout-success'>
                        <h4>Welcome to Data Importer Tool</h4>
                        Before uploading a file, please read below instructions : <br/>
                        * File format should be : CSV file format<br/>
                        * Do not upload items with duplicate SKUs.<br/>
                        * Do not upload items with negative quantity.<br/>
                        * Do not upload items with decimal value in quantity.<br/>
                        * Do not upload the file with blank row in between records.<br/>
                        * Do not upload items that are not found in IMFS.<br/>
                        * Do not double click upload excel button.<br/>
                        * Do not double click submit button.<br/>
                        * Kindly delete items with "<b>red</b>" background and "<b>null</b>" segmentation.<br/>
                        * Please limit your items to "<b>90</b>" SKUs per upload.<br/>
                        
                    </div>
            
        			<div class="row" style="padding-bottom: 5px;">
        				<div class="text-center col-md-3">
        					<a href='{{ CRUDBooster::mainpath() }}/download-order-template' class="btn btn-primary" role="button">Download Order Template</a>
        				</div>
        			</div>
        
        			<div class="row">
        				<div class="col-md-12">
        					<input type='file' name='import_file' id="import_file" class='form-control' accept=".csv"/>
        					<div class='help-block'>File type supported only : CSV</div>
        				</div>
        			</div>
        		</div>
    		
        		<div class="modal-footer">
    				
        			<input type="submit" class="btn btn-success" id="upload-excel" value="Upload Excel">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
    
    		</form>
    		</div>
    	</div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="image-upload-modal" role="dialog">
    	<div class="modal-dialog">
    
    		<!-- Modal content-->
    		<div class="modal-content">
    		<div class="modal-header alert-info">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
    			<h3 class="modal-title">Upload Purchase Order Screenshot</h3>
    		</div>
    		<form class="form-horizontal" id="image-form" method="post" role="form" enctype="multipart/form-data">
        		<input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        		<div class="modal-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-block" id="message-modal">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                    </div>
                    @endif
        		    <div class='callout callout-success'>
                        <h4>Welcome to Data Importer Tool</h4>
                        Before uploading a file, please read below instructions : <br/>
                        * File format should be : JPEG or PNG file format<br/>
                        
                    </div>
        
        			<div class="row">
        				<div class="col-md-12">
        					<input type='file' name='img_file' id="img_file" class='form-control' accept="image/png, image/jpeg"/>
        					<div class='help-block'>File type supported only : JPEG or PNG</div>
        				</div>
        			</div>
        		</div>
    		
        		<div class="modal-footer">
    				
        			<input type="submit" class="btn btn-success" id="upload-image" value="Upload Image">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
    
    		</form>
    		</div>
    	</div>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="create-blankOrder" role="dialog">
    	<div class="modal-dialog">
    
    		<!-- Modal content-->
    		<div class="modal-content">
    		<div class="modal-header alert-warning">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
    			<h3 class="modal-title">Send Blank Order ?</h3>
    		</div>
    		<div class="modal-body">
    			<h4>Are you sure to send <b style="color:red">BLANK ORDER</b> ?</h4>
    		</div>
		
    		<div class="modal-footer">
    			<a href="{{ CRUDBooster::mainpath('create-blankorder') }}" class="btn btn-success pull-right"> <i class="fa fa-check" ></i> {{ trans('message.form.save_blank') }}</a>
    			<button type="button" class="btn btn-default" style="margin-right:15px;" data-dismiss="modal">Cancel</button>
    		</div>
    		</div>
    	</div>
    </div>


</section>

@endsection

@push('bottom')


<script type="text/javascript">

var stack = [];

$(document).ready(function () {
    
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = function () {
        window.history.pushState(null, "", window.location.href);
    };
    
    //$(".select2").select2();
    refreshAt();
    timeRemaining();

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
        var quantityReservable = $('.item-reservable').val();
        var totalQty = $("#totalQuantity").val();
        var timerValue = $('#timer').val();
        var nullsku = 0;
        var nulledsku = 0;
        var blankrsv = 0;
        var btnclick_cnt = 0;
        var p_qty = 0;
        var sto_invqty = 0;
        var my_channel = $('#channels_id').val();
        var my_image = $('#image_file').val();
        
        $('.skulegend').each(function () {
            var sku = $(this).text();
            
            if(sku == 'null'){
                //return false;
                nullsku++;
            }
            
        });
        
        $('.item_quantity').each(function () {
            var proposed_qty = $(this).val();
            
            if(proposed_qty < 0 || proposed_qty == 0){
                //return false;
                p_qty++;
            }
            if(proposed_qty == ''){
                //return false;
                p_qty++;
            }
            if(proposed_qty == null){
                //return false;
                p_qty++;
            }
            
        });
        
        
        $('.item-storeinventory').each(function () {
            var sto_qty = $(this).val();
            
            if(sto_qty < 0){
                //return false;
                sto_invqty++;
            }
            if(sto_qty == ''){
                //return false;
                sto_invqty++;
            }
            if(sto_qty == null){
                //return false;
                sto_invqty++;
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
        
        if(p_qty > 0){
            return false;
        }
        if(sto_invqty > 0){
            return false;
        }
        if(nullsku > 0){
            return false;
        }
        if(nulledsku > 0){
            return false;
        }
        if(blankrsv > 0){
            return false;
        }
  
        if(rowCount <= 2 && rowCount > 91){
            return false;
        }
        
        if(quantityReservable == '' || quantityReservable == null){
            return false;
        }
        if(timerValue == '' || timerValue == null){
            return false;
        }
        if(totalQty == 'NaN') {
            return false;
        }
        
        if(my_channel == 3){
            if(my_image == null || my_image == ""){
                alert("Purchase order screenshot is required.");
                return false;
            }
        }
        
        $(this).attr('disabled','disabled');
        $('#purchaseForm').submit();
    });

});

$(document).ready(function () {
 $("#excel-form").submit(function(e){
    e.preventDefault();
    $("#upload-excel").attr("disabled", true);
    var form = $("#excel-form")[0];
    var formdata = new FormData(form);

    $.ajax({
     url: "{{ route('purchase.upload.excel-order') }}",
     type: "POST",
     mimeTypes:"multipart/form-data",
     contentType: false,
     cache: false,
     processData: false,
     data: formdata,
     success: function(data){
        $('.tableInfo').show();
        $(data).insertAfter($('table tr.dynamicRows:last'));
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
                
                if(lastRow == 0) {
                    setOnHandQty(cellcode, '#ajax_'+cellcode);
                }
                if(rowCount == 2){
                    setOnHandQty(cellcode, '#ajax_'+cellcode);
                }
                if(r == (n-1)) { //footer
                    lastRow = 1;
                }
            }

        }, 5000);
        
        var sub_Total = calculateSubTotal();
        $("#grandTotal").val(sub_Total);
        var total_Quantity = calculateTotalQuantity();
        $("#totalQuantity").val(total_Quantity);
        
        $('#excel-upload-modal').modal('hide');
        pushToStack();
        
        var skuCount = document.getElementById('purchase-items').rows.length - 2;
        $("#totalSKUS").val(skuCount);
        
        $("#excel-uploader").attr("disabled", true);
        
        
     }
    });
   });
   
   $("#image-form").submit(function(e){
    e.preventDefault();
    $("#upload-image").attr("disabled", true);
    var form = $("#image-form")[0];
    var formdata = new FormData(form);

    $.ajax({
     url: "{{ route('purchase.upload.image-order') }}",
     type: "POST",
     mimeTypes:"multipart/form-data",
     contentType: false,
     cache: false,
     processData: false,
     data: formdata,
     success: function(data){
        
        $("#image_file").val(data.file_name);
        $("#image-uploader").attr("disabled", true);
        console.log(data);
        
        if(data.status == 1){
            $('#image-upload-modal').modal('hide');
            alert("Success Image file uploaded successfully.");
        }
        else if(data.status == 0){
            alert("Fail File uploaded is not supported.");
        }
        else {
            alert("Fail No file to upload.");
        }
        
     }
    });
   });
});

$(document).on('click', '#reference_read', function () {

    var po_val = $(this).val();

    if (po_val == null || po_val == '') {
        $('#error-msg').html("Reference # already exists!");
        $('#btnSubmit').attr('disabled', 'disabled');
        return;
    } else {
        $('#btnSubmit').removeAttr('disabled');
    }

    $.ajax({
        method: "POST",
        url: "{{ route('purchase.reference.validation') }}",
        data: {
            "reference": po_ref,
            "_token": token
        }
    })
    .done(function (data) {
        var data = jQuery.parseJSON(data);
        if (data.status_no == 1) {
            $("#errMsg").html('Reference # already exists!');
            $('#btnSubmit').attr('disabled', true);
        } else if (data.status_no == 0) {
            $("#errMsg").html('Reference # is available');
            $('#btnSubmit').removeAttr('disabled');
        }
    });

});

function in_array(search, array) {
  for (i = 0; i < array.length; i++) {
    if (array[i] == search) {
      return true;
    }
  }
  return false;
}


var token = $("#token").val();

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
                    "segment": item_segmentation,
                    "store_id": store_id
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
                            prev_balance: item.prev_balance,
                            sku_status_id: item.sku_status_id,
                            sku_legend: item.sku_legend,
                            sku_legend_id: item.sku_legend_id
                            }
                        }));
                    } else {
                        $('.ui-menu-item').remove();
                        $('.addedLi').remove();
                        $("#ui-id-2").append("<li class='addedLi'>"+data.message+"</li>");
                        var searchVal = $("#search").val();
                        if (searchVal.length > 0) {
                            $("#ui-id-2").css('display', 'block');
                            //$("#ui-id-1").css('display', 'block');
                        } else {
                            $("#ui-id-2").css('display', 'none');
                            //$("#ui-id-1").css('display', 'none');
                        }
                    }
                }
            })
        },
        select: function (event, ui) {
            var e = ui.item;
            if (e.id) {
                if (!in_array(e.id, stack)) {
                    stack.push(e.id);
                    $("#excel-uploader").attr("disabled", true);
                    
                    
                    if ((e.sku_legend_id == 4 && channel_id != 3) || e.sku_legend_id == 'null' || e.sku_legend_id == null){
                        var new_row = '<tr class="nr" bgcolor="red" id="rowid' + e.id + '">' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                '<td><input class="form-control" type="text" tabindex="-1" name="item_description[]" readonly value="' + e.value + '"></td>' +
                                '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="quantity_prev_balance[]" readonly value="'+e.prev_balance+'" ></td>'+
                                '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="quantity_pre_ordered[]" value="0">' +
                                '<input type="hidden" name="item_id[]" value="' + e.id + '"></td>' +
                                '<td><input class="form-control text-center item-storeinventory" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" name="quantity_store_inventory[]" required id="storeinv_'+e.stock_code+'" ></td>'+
                                '<td style="display: none;"><input min="0" type="text" tabindex="-1" class="form-control text-center unitprice" name="dtp_rf[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_price + '"></td>' +
                                '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_price+'" name="purchase_line_amount[]" readonly></td>' +
                                '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+ 
                                '<td class="text-center skulegend">'+e.sku_legend+' <input type="hidden" class="skuh-legend" name="skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                '</tr>';

                        //$(new_row).insertAfter($('table tr.dynamicRows:last'));
                        
                    }
                    else if((e.sku_legend_id == 4 && channel_id == 3) || e.sku_legend_id == 'null' || e.sku_legend_id == null){
                        var new_row = '<tr class="nr" bgcolor="red" id="rowid' + e.id + '">' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                '<td><input class="form-control" type="text" tabindex="-1" name="item_description[]" readonly value="' + e.value + '"></td>' +
                                '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="quantity_prev_balance[]" readonly value="'+e.prev_balance+'" ></td>'+
                                '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_current_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="quantity_pre_ordered[]" value="0">' +
                                '<input type="hidden" name="item_id[]" value="' + e.id + '"></td>' +
                                '<td><input class="form-control text-center item-storeinventory" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" name="quantity_store_inventory[]" required id="storeinv_'+e.stock_code+'" ></td>'+
                                '<td style="display: none;"><input min="0" type="text" tabindex="-1" class="form-control text-center unitprice" name="current_srp[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_current_price + '"></td>' +
                                '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_current_price+'" name="purchase_line_amount[]" readonly></td>' +
                                '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+ 
                                '<td class="text-center skulegend">'+e.sku_legend+' <input type="hidden" class="skuh-legend" name="skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                '</tr>';

                        //$(new_row).insertAfter($('table tr.dynamicRows:last'));
                        
                    
                    }
                    else if(e.sku_legend_id != 4 && channel_id == 3){
                        if(obj_skulegend.some( obj_skulegends => obj_skulegends['id'] === e.sku_legend_id )) {
                            var new_row = '<tr class="nr" id="rowid' + e.id + '">' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                '<td><input class="form-control" type="text" tabindex="-1" name="item_description[]" readonly value="' + e.value + '"></td>' +
                                '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="quantity_prev_balance[]" readonly value="'+e.prev_balance+'" ></td>'+
                                '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_current_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="quantity_pre_ordered[]" value="0">' +
                                '<input type="hidden" name="item_id[]" value="' + e.id + '"></td>' +
                                '<td><input class="form-control text-center item-storeinventory" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" name="quantity_store_inventory[]" required id="storeinv_'+e.stock_code+'" ></td>'+
                                '<td style="display: none;"><input min="0" type="text" tabindex="-1" class="form-control text-center unitprice" name="current_srp[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_current_price + '"></td>' +
                                '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_current_price+'" name="purchase_line_amount[]" readonly></td>' +
                                '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+ 
                                '<td class="text-center skulegend">'+e.sku_legend+' <input type="hidden" class="skuh-legend" name="skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                '</tr>';
                        }
                        else {
                            var new_row = '<tr class="nr" id="rowid' + e.id + '">' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                '<td><input class="form-control" type="text" tabindex="-1" name="item_description[]" readonly value="' + e.value + '"></td>' +
                                '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                '<td><input class="form-control text-center" type="text" tabindex="-1" name="quantity_prev_balance[]" readonly value="'+e.prev_balance+'" ></td>'+
                                '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_current_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="quantity_pre_ordered[]" value="0">' +
                                '<input type="hidden" name="item_id[]" value="' + e.id + '"></td>' +
                                '<td><input class="form-control text-center item-storeinventory" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" name="quantity_store_inventory[]" required id="storeinv_'+e.stock_code+'" ></td>'+
                                '<td style="display: none;"><input min="0" type="text" tabindex="-1" class="form-control text-center unitprice" name="current_srp[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_current_price + '"></td>' +
                                '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_current_price+'" name="purchase_line_amount[]" readonly></td>' +
                                '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+ 
                                '<td class="text-center skulegend"><input type="hidden" class="skuh-legend" name="skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                '</tr>';
                        }

                        //$(new_row).insertAfter($('table tr.dynamicRows:last'));
                        
                    
                    }
                    else {
                        if(obj_skulegend.some( obj_skulegends => obj_skulegends['id'] === e.sku_legend_id )) {
                            var new_row = '<tr class="nr" id="rowid' + e.id + '">' +
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="item_description[]" readonly value="' + e.value + '"></td>' +
                                    '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="quantity_prev_balance[]" readonly value="'+e.prev_balance+'" ></td>'+
                                    '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="quantity_pre_ordered[]" value="0">' +
                                    '<input type="hidden" name="item_id[]" value="' + e.id + '"></td>' +
                                    '<td><input class="form-control text-center item-storeinventory" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" name="quantity_store_inventory[]" required id="storeinv_'+e.stock_code+'" ></td>'+
                                    '<td style="display: none;"><input min="0" type="text" class="form-control text-center unitprice" name="dtp_rf[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_price + '"></td>' +
                                    '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_price+'" name="purchase_line_amount[]" readonly></td>' +
                                    '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+ 
                                    '<td class="text-center skulegend">'+e.sku_legend+' <input type="hidden" class="skuh-legend" name="skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                    '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                    '</tr>';
                        }
                        else {
                            var new_row = '<tr class="nr" id="rowid' + e.id + '">' +
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="digits_code[]" readonly value="' + e.stock_code + '"></td>' +
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="upc_code[]" readonly value="' + e.stock_upc + '"></td>' +
                                    '<td><input class="form-control" type="text" tabindex="-1" name="item_description[]" readonly value="' + e.value + '"></td>' +
                                    '<td><input class="form-control text-center item-reservable" type="text" tabindex="-1" name="quantity_reservable[]" readonly id="ajax_'+e.stock_code+'" ></td>'+
                                    '<td><input class="form-control text-center" type="text" tabindex="-1" name="quantity_prev_balance[]" readonly value="'+e.prev_balance+'" ></td>'+
                                    '<td><input class="form-control text-center no_units item_quantity" data-id="' + e.id + '" data-rate="' + e.stock_price + '" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" id="qty_' + e.id + '" name="quantity_pre_ordered[]" value="0">' +
                                    '<input type="hidden" name="item_id[]" value="' + e.id + '"></td>' +
                                    '<td><input class="form-control text-center item-storeinventory" type="number" min="0" max="9999" oninput="validity.valid||(value=0);" name="quantity_store_inventory[]" required id="storeinv_'+e.stock_code+'" ></td>'+
                                    '<td style="display: none;"><input min="0" type="text" class="form-control text-center unitprice" name="dtp_rf[]" readonly data-id = "' + e.id + '" id="rate_id_' + e.id + '" value="' + e.stock_price + '"></td>' +
                                    '<td style="display: none;"><input class="form-control text-center amount" type="text" id="amount_'+e.id+'" value="'+ e.stock_price+'" name="purchase_line_amount[]" readonly></td>' +
                                    '<td style="display: none;" class="text-center">'+e.sku_status+' <input type="hidden" name="skustatus_id[]" value="'+e.sku_status_id+'"> </td>'+ 
                                    '<td class="text-center skulegend"><input type="hidden" class="skuh-legend" name="skulegend_id[]" value="'+e.sku_legend_id+'"> </td>'+
                                    '<td class="text-center"><button id="'+e.id+'" class="btn btn-xs btn-danger delete_item"><i class="glyphicon glyphicon-trash"></i></button></td>' +
                                    '</tr>';
                        }
                        //$(new_row).insertAfter($('table tr.dynamicRows:last'));
                    }
                    
                    $(new_row).insertAfter($('table tr.dynamicRows:last'));
                    // For tax select option
                    $(function () {
                        var itm = $("#search").val();
                        if(itm != '' || itm.length > 0) {
                            var lastRow = 0;

                            setInterval(function() { 
                                //var current_itm = $("#search").val();
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

                            }, 5000);
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
                    
                    var total_Quantity = calculateTotalQuantity();
                    $("#totalQuantity").val(total_Quantity);
                    var subTotal = calculateSubTotal();
                    $("#grandTotal").val(subTotal);
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

$(document).ready(function () {
    $('.tableInfo').hide();

    var po_ref = 'MRS-' + $('#reference_read').val();
    $("#reference_write").val(po_ref);
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