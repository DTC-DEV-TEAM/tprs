@extends('crudbooster::admin_template')
@section('content')

@if(CRUDBooster::getCurrentMethod() == 'getDetail')
    @if(g('return_url'))
        <p><a title='Return' href='{{g("return_url")}}' class="noprint"><i class='fa fa-chevron-circle-left'></i>
                &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
    @else
        <p><a title='Main Module' href='{{CRUDBooster::mainpath()}}' class="noprint"><i class='fa fa-chevron-circle-left'></i>
                &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>
    @endif
@endif

<div class='panel panel-default'>
    <div class='panel-heading'>
        <div style="font-size:30px; font-weight:bold; display: inline;" class="col-md-8">Replenishment Order</div>

        <div class="col-md-4" style="display: inline;">
            <a href="#" style="vertical-align: top;">
            <img src="{!! asset("$store_logo->store_img_logo") !!}" class="img-responsive pull-right" alt="Digits Trading" width="170" height="70">
            </a>
        </div>
        
        <div style="clear:both;"></div>
    </div>
    <div class='panel-body'>

        <table class="table table-borderless order-detail width="100%">
            <tbody>
                <tr>
                    <td width="15%"><b>REQUESTOR:</b></td>
                    <td width="20%">{{$purchase_header->user_name}}</td>
                    <td width="40%"></td>
                    <td width="15%"><b>REFERENCE #:</b></td>
                    <td width="10%">{{$purchase_header->po_reference}}</td>    
                </tr>
                <tr>
                    <td width="15%"><b>STORE:</b></td>
                    <td width="20%">{{$purchase_header->store_code}}</td>
                    <td width="40%"></td>
                    <td width="15%"><b></b></td>
                    <td width="10%"></td>    
                </tr>
                <tr>
                    <td width="15%"><b>STORE NAME:</b></td>
                    <td width="20%">{{$purchase_header->store_name}}</td>
                    <td width="40%"></td>
                    <td width="15%"><b>REQUEST DATE:</b></td>
                    <td width="10%">{{ date('Y-m-d',strtotime($purchase_header->order_date)) }}</td>    
                </tr>
            </tbody>
        </table>

        <br/>
        <br/>

        <table id="table_dashboard" class='table table-hover table-striped table-bordered table_dashboard' width="100%">
            <thead>
                <tr>
                    <th width="10%" style="vertical-align: top" class="text-center">DIGITS CODE</th>
                    <th width="10%" style="vertical-align: top" class="text-center">UPC CODE</th>
                    <th width="50%" style="vertical-align: top" class="text-center">ITEM DESCRIPTION</th>
                    <th width="5%" style="vertical-align: top" class="text-center">PROPOSED QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">APPROVED QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">FOR REPLENISHMENT QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">FOR REORDER QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">FULFILLED QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">PREVIOUS ORDER QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">LINE STATUS</th>
                    @if($channel == 3)
                        <th width="5%" style="vertical-align: top" class="text-center">CURRENT SRP</th>
                    @else
                        <th width="5%" style="vertical-align: top" class="text-center">STORE COST</th>
                    @endif
                    <th width="5%" style="vertical-align: top" class="text-center">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($purchase_lines as $row)
                <tr>
                    <td>{{$row->digits_code}}</td>
                    <td>{{$row->upc_code}}</td>
                    <td>{{$row->item_description}}</td>
                    <td class="text-center">{{$row->quantity_pre_ordered}}</td>
                    <td class="text-center">{{$row->quantity_ordered}}</td>
                    <td class="text-center">{{$row->quantity_reserved}}</td>
                    <td class="text-center">{{$row->quantity_reorder}}</td>
                    <td class="text-center">{{$row->quantity_received}}</td>
                    <td class="text-center">{{$row->quantity_balance}}</td>
                    <td class="text-center">{{$row->line_status}}</td>
                    @if($channel == 3)
                        <td>{{ number_format($row->current_srp, 2) }}</td>
                    @else
                        <td>{{ number_format($row->dtp_rf, 2) }}</td>
                    @endif
                    <td>{{ number_format($row->final_purchase_line_amount, 2) }}</td>
                    
                </tr>
                @endforeach

                <tr>
                    <td colspan="4" class="text-right"><b>Total Quantity</b></td>
                    <td colspan="1" class="text-center">{{ $lines_approved_total_qty }}</td>
                    <td colspan="1" class="text-center">{{ $lines_replenishment_qty }}</td>
                    <td colspan="1" class="text-center">{{ $lines_reorder_qty }}</td>
                    
                    <td colspan="1" class="text-center">{{ $lines_received_qty }}</td>
                    <td colspan="1" class="text-center">{{ $lines_balance_qty }}</td>
                    <td colspan="1" class="text-center"></b></td>  
                    <td colspan="1" class="text-center"><b>Grand Total</b></td>
                    <td colspan="1">{{ number_format($purchase_header->final_total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <br/>
        <div class="col-md-12">
             <p><b>Notes: </b>{{$purchase_header->comments}}</p>

        </div>
        <br/>

        <table class="table table-borderless order-detail">
            <tbody>
                <tr>
                    <td width="15%"><b>APPROVED BY:</b></td>
                    <td width="85%"><b>{{ $purchase_header->approver_name }}</b> / {{ $purchase_header->approved_at != null ? date('M d, Y',strtotime($purchase_header->approved_at)) : "" }}</td>
                        
                </tr>
            </tbody>
        </table>
        
    </div>

    <div class="panel-footer noprint">
            <div class="pull-left noprint">
                <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">Cancel</a> &nbsp; 
                <a href="#" class="btn btn-primary" id="print-po"><i class="fa fa-print"></i> Print</a>
                <a href="{{ route('purchase_order.pdf', [$purchase_header->po_header_id]) }}" class="btn btn-primary" id="pdf-po"><i class="fa fa-file-pdf-o"></i> PDF</a>
            </div>
            
            <div style="clear:both;"></div>
        
    </div>

</div>

<div class="modal fade" id="confirmReject" role="dialog" aria-labelledby="confirmRejectLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Reject Order</h4>
        </div>
        <div class="modal-body">
            <p>Are you sure about this ?</p>
            <textarea rows="4" cols="90" name="message_reject_info">Message</textarea>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirm"><i class="fa fa-thumbs-down"></i> Reject</button>
        </div>
        </div>
    </div>
</div>

@endsection

@push('bottom')

<script>
    $('#print-po').click(function() {
        window.print();
    });

    $('#confirmApprove').on('show.bs.modal', function(e){
        var aform = $(e.relatedTarget).closest('form');
        $(this).find('.modal-footer #confirm').data('aform',aform);
    });

    $('#confirmReject').on('show.bs.modal', function(e){
        var rform = $(e.relatedTarget).closest('form');
        $(this).find('.modal-footer #confirm').data('rform',rform);
    });

    $('#confirmApprove').find('.modal-footer #confirm').on('click', function(){
        $(this).data('aform').submit();
    });

    $('#confirmReject').find('.modal-footer #confirm').on('click', function(){
        $(this).data('rform').submit();
    });

</script>

@endpush