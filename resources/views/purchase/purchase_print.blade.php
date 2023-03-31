<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Replenishment Orders</title>
        {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> --}}
        <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet" type="text/css"/>
    </head>

    <style>
        body {
            font-family: Helvetica, sans-serif;
            color: #121212;
            line-height: 14px;
            font-size: 12px;
        }
        .order-detail tbody tr td{
            border: 0;
        }
        .table_dashboard thead th {
            vertical-align: top;
            font-size: 12px;
            line-height: 14px;
        }
        #table_dashboard{
            font-size: 12px;
            line-height: 14px;
        }
    </style>

    <body>
        <div class="row">
            <div style="font-size:30px; font-weight:bold; display:inline; vertical-align:middle;" class="col-md-8">Replenishment Order</div>

            <div class="col-md-4 pull-right" style="display:inline;">
                <a href="#" style="vertical-align: top;">
                <img src="{!! asset("$store_logo->store_img_logo") !!}" class="img-responsive pull-right" alt="Digits Trading" width="170" height="70">
                </a>
            </div>
            <div style="clear:both;"></div>
        </div>
        <br>
        <br>
        <br>
        <div class="row">
            <table class="table table-borderless order-detail" style="width:100%;">
                <tbody>
                    <tr>
                        <td width="15%"><b>REQUESTOR:</b></td>
                        <td width="40%">{{$purchase_header->user_name}}</td>
                        <td width="15%"></td>
                        <td width="15%"><b>REFERENCE #:</b></td>
                        <td width="15%">{{$purchase_header->po_reference}}</td>    
                    </tr>
                    <tr>
                        <td width="15%"><b>STORE:</b></td>
                        <td width="40%">{{$purchase_header->store_code}}</td>
                        <td width="15%"></td>
                        <td width="15%"><b></b></td>
                        <td width="15%"></td>    
                    </tr>
                    <tr>
                        <td width="15%"><b>STORE NAME:</b></td>
                        <td width="40%">{{$purchase_header->store_name}}</td>
                        <td width="15%"></td>
                        <td width="15%"><b>REQUEST DATE:</b></td>
                        <td width="15%">{{ date('Y-m-d',strtotime($purchase_header->order_date)) }}</td>    
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <table id="table_dashboard" class='table table-striped table-bordered table_dashboard' style="width:100%;">
                <thead>
                    <tr>
                        <th width="10%" style="vertical-align: top" class="text-center">DIGITS CODE</th>
                        <th width="15%" style="vertical-align: top" class="text-center">UPC CODE</th>
                        <th width="30%" style="vertical-align: top" class="text-center">ITEM DESCRIPTION</th>
                        <th width="10%" style="vertical-align: top" class="text-center">PROPOSED QTY</th>
                        <th width="10%" style="vertical-align: top" class="text-center">APPROVED QTY</th>
                        @if($channel == 3)
                            <th width="10%" style="vertical-align: top" class="text-center">CURRENT SRP</th>
                        @else
                            <th width="10%" style="vertical-align: top" class="text-center">STORE COST</th>
                        @endif
                        <th width="15%" style="vertical-align: top" class="text-center">AMOUNT</th>
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
                        @if($channel == 3)
                            <td>P {{ number_format($row->current_srp, 2) }}</td>
                        @else
                            <td>P {{ number_format($row->dtp_rf, 2) }}</td>
                        @endif
                        <td>P {{ number_format($row->purchase_line_amount, 2) }}</td>
                        
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="4" class="text-right"><b>Total Quantity</b></td>
                        <td colspan="1" class="text-center">{{ $lines_approved_total_qty }}</td>
                        <td colspan="1" class="text-center"><b>Grand Total</b></td>
                        <td colspan="1">P {{ number_format($purchase_header->total_amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <table class="table table-borderless order-detail">
                <tbody>
                    <tr>
                        <td width="15%"><b>APPROVED BY:</b></td>
                        <td width="85%"><b>{{ $purchase_header->approver_name }}</b> / {{ $purchase_header->approved_at != null ? date('M d, Y',strtotime($purchase_header->approved_at)) : "" }}</td>
                            
                    </tr>
                </tbody>
            </table>
        </div>
    </body>

</html>