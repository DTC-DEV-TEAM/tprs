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

        <table class="table table-borderless order-detail">
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

        <table id="table_dashboard" class='table table-hover table-striped table-bordered table_dashboard'>
            <thead>
                <tr>
                    <th width="10%" style="vertical-align: top" class="text-center">DIGITS CODE</th>
                    <th width="10%" style="vertical-align: top" class="text-center">UPC CODE</th>
                    <th width="30%" style="vertical-align: top" class="text-center">ITEM DESCRIPTION</th>
                    <th width="5%" style="vertical-align: top" class="text-center">PROPOSED QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">APPROVED QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">FOR REPLENISH QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">FOR REORDER QTY</th>
                    <!--additional code 20200117-->
                    <th width="5%" style="vertical-align: top" class="text-center">FULFILLED QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">UNSERVED QTY</th>
                    
                    <th width="5%" style="vertical-align: top" class="text-center">DR QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">ST QTY</th>
                    <th width="5%" style="vertical-align: top" class="text-center">PO QTY</th>
                    
                    <th width="5%" style="vertical-align: top" class="text-center">DR #</th>
                    <th width="5%" style="vertical-align: top" class="text-center">ST #</th>
                    <th width="5%" style="vertical-align: top" class="text-center">PO #</th>
                    <th width="5%" style="vertical-align: top" class="text-center">LINE STATUS</th>
                    <!--end-additional code 20200117-->
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
                    <!--additional code 20200117-->
                    <td class="text-center">{{$row->quantity_received}}</td>
                    <td class="text-center">{{$row->quantity_balance}}</td>
                    <td class="text-center">{{$row->dr_qty}}</td>
                    <td class="text-center">{{$row->st_qty}}</td>
                    <td class="text-center">{{$row->po_qty}}</td>
                    <td class="text-center">{{$row->dr_reference}}</td>
                    <td class="text-center">{{$row->st_reference}}</td>
                    <td class="text-center">{{$row->po_reference}}</td>
                    <td class="text-center">{{$row->line_status}}</td>
                    <!--end-additional code 20200117-->
                    
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" class="text-right"><b>Total Quantity</b></td>
                    <td colspan="1" class="text-center">{{ $lines_total_qty }}</td>
                    <td colspan="1" class="text-center">{{ $lines_approved_total_qty == "" ? "0" : $lines_approved_total_qty }}</td>
                    <td colspan="1" class="text-center">{{ $lines_replenishment_qty == "" ? "0" : $lines_replenishment_qty }}</td>
                    <td colspan="1" class="text-center">{{ $lines_reorder_qty == "" ? "0" : $lines_reorder_qty }}</td>
                    <!--additional code 20200117-->
                    <td colspan="1" class="text-center">{{ $lines_received_qty == "" ? "0" : $lines_received_qty }}</td>
                    <td colspan="1" class="text-center">{{ $lines_balance_qty == "" ? "0" : $lines_balance_qty }}</td>
                    
                    <td colspan="1" class="text-center">{{ $lines_dr_qty == "" ? "0" : $lines_dr_qty }}</td>
                    <td colspan="1" class="text-center">{{ $lines_st_qty == "" ? "0" : $lines_st_qty }}</td>
                    <td colspan="1" class="text-center">{{ $lines_po_qty == "" ? "0" : $lines_po_qty }}</td>
                    
                    <td colspan="1" class="text-center"></td>
                    <td colspan="1" class="text-center"></td>
                    <td colspan="1" class="text-center"></td>
                    <td colspan="1" class="text-center"></td>
                    <!--end-additional code 20200117-->
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
</div>

@endsection