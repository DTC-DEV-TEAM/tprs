@extends('crudbooster::admin_template')
@section('content')

<section class="content">

    <div class="box box-default">

        <!-- /.box-header -->
        <div class="box-body">
            <form action="{{ CRUDBooster::mainpath('cancel-save/'.$purchase_header->po_header_id) }}" method="POST" id="purchaseCancelForm">
                <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">

                <div class="row">
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="require control-label">{{ trans('message.form-label.store') }}</label>
                            <select class="form-control select2" style="width: 100%;" name="stores_id" id="stores_id">
                                    <option value="{{$purchase_header->stores_id}}">{{$purchase_header->store_name}}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label require">{{ trans('message.form-label.orderdate') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input class="form-control" readonly disabled id="datepicker" type="text" value="{{ date('Y-m-d', strtotime($purchase_header->order_date)) }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label">{{ trans('message.form-label.reference') }}</label>
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
                    <div class="col-md-12">
                        <div class="box-header text-center">
                        <h3 class="box-title"><b>{{ trans('message.form-label.purchase_items') }}</b></h3>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="purchase-items-cancel">
                                    <tbody>

                                        <tr class="tbl_header_color dynamicRows">
                                            <th width="3%" style="vertical-align: top" class="text-center"><input type="checkbox" id="cancelall"></th>
                                            <th width="10%" style="vertical-align: top" class="text-center">{{ trans('message.table.digits_code') }}</th>
                                            <th width="10%" style="vertical-align: top" class="text-center">{{ trans('message.table.upc_code') }}</th>
                                            <th width="30%" style="vertical-align: top" class="text-center">{{ trans('message.table.item_description') }}</th>
                                            <th width="5%" style="vertical-align: top" class="text-center">APPROVED QTY</th>
                                            <th width="5%" style="vertical-align: top" class="text-center">FOR REPLENISHMENT QTY</th>
                                            <th width="5%" style="vertical-align: top" class="text-center">FOR REORDER QTY</th>
                                            <th width="5%" style="vertical-align: top" class="text-center">FULFILLED QTY</th>
                                            <th width="5%" style="vertical-align: top" class="text-center">BALANCE QTY</th>
                                            <th width="5%" style="vertical-align: top" class="text-center">LINE STATUS</th>
                                            @if(CRUDBooster::myPrivilegeName() == "SIM")
                                            <th width="10%" style="vertical-align: top" class="text-center">SDM CANCEL REASON</th>
                                            @elseif(CRUDBooster::myPrivilegeName() == "MCB")
                                            <th width="10%" style="vertical-align: top" class="text-center">MCB CANCEL REASON</th>
                                            @endif
                                        </tr>

                                        @foreach ($purchase_lines as $data)
                                            @if($data->sku_legend_description == 'X')
                                            <tr id="rowid{{$data->item_id}}" bgcolor="red">
                                                <td align="center">
                                                    @if(CRUDBooster::myPrivilegeName() == "SIM" && $data->line_status != 'CLOSED' && $data->quantity_reserved > 0  && is_null($data->replenish_cancel_reason) && $data->quantity_received < $data->quantity_reserved)
                                                    <input type="checkbox" class="checkbox" tabindex="-1" name="cancel[]" value="{{$data->item_id}}">
                                                    @elseif(CRUDBooster::myPrivilegeName() == "MCB" && $data->line_status != 'CLOSED' && $data->quantity_reorder > 0  && is_null($data->reorder_cancel_reason) )
                                                    <input type="checkbox" class="checkbox" tabindex="-1" name="cancel[]" value="{{$data->item_id}}">
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    {{$data->digits_code}}
                                                </td>
                                                <td align="center">
                                                    {{$data->upc_code}}
                                                </td>
                                                <td>
                                                    {{$data->item_description}}
                                                    <input type="hidden" name="item_id[]" value="{{ $data->item_id }}">
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_ordered}}
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_reserved}}
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_reorder}}
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_received}}
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_balance}}
                                                </td>
                                                <td align="center">
                                                    {{$data->line_status}}
                                                    <input type="hidden" class="line-status" id="line_status_{{$data->item_id}}" value="{{ $data->line_status }}">
                                                </td>
                                                <td>
                                                    @if(CRUDBooster::myPrivilegeName() == "SIM" && $data->line_status != 'CLOSED' && $data->quantity_reserved > 0 && is_null($data->replenish_cancel_reason) && $data->quantity_received < $data->quantity_reserved)
                                                    <input type="text" class="form-control" id="status_{{$data->item_id}}" data-id="{{$data->item_id}}" name="replenish_cancel_reason[]">
                                                    @elseif(CRUDBooster::myPrivilegeName() == "MCB" && $data->line_status != 'CLOSED' && $data->quantity_reorder > 0 && is_null($data->reorder_cancel_reason) )
                                                    <input type="text" class="form-control" id="status_{{$data->item_id}}" data-id="{{$data->item_id}}" name="reorder_cancel_reason[]">
                                                    @else
                                                        @if(CRUDBooster::myPrivilegeName() == "SIM")
                                                            {{$data->replenish_cancel_reason}}
                                                        @elseif(CRUDBooster::myPrivilegeName() == "MCB")
                                                            {{$data->reorder_cancel_reason}}
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                            @else
                                            <tr id="rowid{{$data->item_id}}">
                                            <td align="center">
                                                    @if(CRUDBooster::myPrivilegeName() == "SIM" && $data->line_status != 'CLOSED' && $data->quantity_reserved > 0  && is_null($data->replenish_cancel_reason) && $data->quantity_received < $data->quantity_reserved)
                                                    <input type="checkbox" tabindex="-1" class="checkbox" name="cancel[]" value="{{$data->item_id}}">
                                                    @elseif(CRUDBooster::myPrivilegeName() == "MCB" && $data->line_status != 'CLOSED' && $data->quantity_reorder > 0  && is_null($data->reorder_cancel_reason) )
                                                    <input type="checkbox" tabindex="-1" class="checkbox" name="cancel[]" value="{{$data->item_id}}">
                                                    @endif
                                                </td>
                                                <td align="center">
                                                    {{$data->digits_code}}
                                                </td>
                                                <td align="center">
                                                    {{$data->upc_code}}
                                                </td>
                                                <td>
                                                    {{$data->item_description}}
                                                    <input type="hidden" name="item_id[]" value="{{ $data->item_id }}">
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_ordered}}
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_reserved}}
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_reorder}}
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_received}}
                                                </td>
                                                <td align="center">
                                                    {{$data->quantity_balance}}
                                                </td>
                                                <td align="center">
                                                    {{$data->line_status}}
                                                    <input type="hidden" class="line-status" id="line_status_{{$data->item_id}}" value="{{ $data->line_status }}">
                                                </td>
                                                <td>
                                                    @if(CRUDBooster::myPrivilegeName() == "SIM" && $data->line_status != 'CLOSED' && $data->quantity_reserved > 0 && is_null($data->replenish_cancel_reason) && $data->quantity_received < $data->quantity_reserved)
                                                    <input type="text" class="form-control" id="status_{{$data->item_id}}" data-id="{{$data->item_id}}" name="replenish_cancel_reason[]">
                                                    @elseif(CRUDBooster::myPrivilegeName() == "MCB" && $data->line_status != 'CLOSED' && $data->quantity_reorder > 0 && is_null($data->reorder_cancel_reason) )
                                                    <input type="text" class="form-control" id="status_{{$data->item_id}}" data-id="{{$data->item_id}}" name="reorder_cancel_reason[]">
                                                    @else
                                                        @if(CRUDBooster::myPrivilegeName() == "SIM")
                                                            {{$data->replenish_cancel_reason}}
                                                        @elseif(CRUDBooster::myPrivilegeName() == "MCB")
                                                            {{$data->reorder_cancel_reason}}
                                                        @endif
                                                    @endif
                                                </td>
    
                                            </tr>
                                            @endif
                                        @endforeach

                                        <tr class="tableInfo">

                                            <td colspan="4" align="right"><strong>{{ trans('message.table.total_quantity') }}</strong></td>
                                            <td colspan="1" class="text-center">{{ $lines_approved_total_qty == "" ? "0" : $lines_approved_total_qty }}</td>
                                            <td colspan="1" class="text-center">{{ $lines_replenishment_qty == "" ? "0" : $lines_replenishment_qty }}</td>
                                            <td colspan="1" class="text-center">{{ $lines_reorder_qty == "" ? "0" : $lines_reorder_qty }}</td>
                                            <td colspan="1" class="text-center">{{ $lines_received_qty == "" ? "0" : $lines_received_qty }}</td>
                                            <td colspan="1" class="text-center">{{ $lines_balance_qty == "" ? "0" : $lines_balance_qty }}</td>
                                            
                                            <td colspan="2"></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <br><br>
                        </div>
                    </div>

                    <div class="col-md-12">

                        <div class="box-footer">
                            <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">Back</a>
                            <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save" ></i> Order Cancel</button>
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
    $(function(){
        var line_status = 0;
        var store_id = $('#stores_id').val();
        $('body').addClass("sidebar-collapse");

        line_status = lineStatusAllClose();
        if(line_status == 0){
            $('#btnSubmit').attr("disabled","disabled");
        }
        else{
            $('#btnSubmit').removeAttr("disabled");
        }
    });

    $("#purchase-items-cancel #cancelall").click(function(){
        var is_cancel_order = $(this).is(":checked");
        $("#purchase-items-cancel .checkbox").prop("checked", !is_cancel_order).trigger("click");
    })

    $(document).on('click', '#btnSubmit', function () {
        var lineChecker = 0;

        lineChecker = lineStatusChecker();
        if(lineChecker > 0){
            return false;
        }
    })
});

function lineStatusAllClose() {
    var line_counter = 0;
    $('.line-status').each(function () {
        if($(this).val() != 'CLOSE'){
            line_counter++;
        }
    });
    return line_counter;
}

function lineStatusChecker() {
    var line_checkCounter = 0;
    $('.line-status').each(function () {
        if($(this).is(":checked")){
            var check_lineval = $(this).val();
            var cancel_lineval = $('#status_'+check_lineval).val();

            if(cancel_lineval.length == 0){
                line_checkCounter++;
            }
        }
    });
    return line_checkCounter;
}

</script>
@endpush