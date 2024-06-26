@extends('crudbooster::admin_template')
@section('content')
    @push('head')
        <style type="text/css">
            * {
                box-sizing: border-box
            }

            .mySlides1,
            .mySlides2 {
                display: none
            }

            img {
                vertical-align: middle;
            }

            /* Slideshow container */
            .slideshow-container {
                max-width: 800px;
                position: relative;
                margin: auto;
            }

            .pdf-container {
                width: 100%;
                height: 100%;
                position: relative;
                margin: auto;
            }


            .pdf-container embed {
                width: 100%;
                height: 100%;
            }

            /* Next & previous buttons */
            .prev,
            .next {
                cursor: pointer;
                position: absolute;
                top: 50%;
                width: auto;
                padding: 16px;
                margin-top: -22px;
                color: black;
                font-weight: bold;
                font-size: 18px;
                transition: 0.6s ease;
                border-radius: 0 3px 3px 0;
                user-select: none;
            }

            /* Position the "next button" to the right */
            .next {
                right: 0;
                border-radius: 3px 0 0 3px;
            }

            /* On hover, add a grey background color */
            .prev:hover,
            .next:hover {
                background-color: #f1f1f1;
                color: black;
            }

            /* Webkit-based browsers (Chrome, Safari, Edge) */
            .table-responsive::-webkit-scrollbar {
                width: 12px;
                height: 12px;
                background-color: transparent;
            }

            .table-responsive::-webkit-scrollbar-thumb {
                background-color: transparent;
                border-radius: 6px;
            }

            .table-responsive::-webkit-scrollbar-thumb:hover {
                background-color: rgba(0, 0, 0, 0.5);
            }

            .table-responsive::-webkit-scrollbar-track {
                background-color: transparent;
            }

            /* Firefox */
            .table-responsive {
                scrollbar-width: thin;
                scrollbar-color: transparent transparent;
            }

            .table-responsive:hover {
                scrollbar-color: rgba(0, 0, 0, 0.5) transparent;
            }

            /*  */
            /* Ensure equal height for detail-container and receipt-container */
            .detail-container,
            .receipt-container {
                background-color: #fff;
                border: 1px solid #ddd;
                padding: 20px;
                height: 100%;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }

            .receipt-container {
                position: relative;
                overflow: hidden;
            }

            .receipt-container .carousel-inner {
                height: 100%;
                text-align: center;
            }

            .receipt-container .carousel-inner .item {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
                /* Maintain item height */
            }

            .receipt-container img {
                max-width: 100%;
                max-height: 300px;
                width: auto;
                height: auto;
                object-fit: contain;
                cursor: pointer;
            }

            /* Custom styling for carousel controls */
            .carousel-control {
                font-size: 40px;
                color: #333;
                width: 50px;
                height: 50px;
                top: 50%;
                transform: translateY(-50%);
                opacity: 0.7;
                z-index: 10;
            }

            .carousel-control:hover {
                opacity: 1;
            }

            .carousel-control.left {
                left: 10px;
            }

            .carousel-control.right {
                right: 10px;
            }

            /* Detail row */

            .detail-row {
                margin-bottom: 15px;
            }

            .bank-details-group,
            .payee-details-group {
                display: flex;
                flex-wrap: wrap;
            }

            .bank-detail,
            .payee-detail {
                flex: 1 1 50%;
                /* Two columns for larger screens */
                padding-right: 15px;
                /* Adjust spacing between items */
            }

            .bank-detail label,
            .payee-detail label {
                font-weight: bold;
                color: #333;
                display: block;
                margin-bottom: 5px;
            }

            .bank-detail span,
            .payee-detail span {
                color: #666;
                display: block;
            }

            /* TABLE */

            .dynamicRows {
                background-color: #f0f0f0;
                color: black;
            }

            .table th,
            .table td {
                vertical-align: middle;
            }

            .view-details-btn {
                padding: 5px 10px;
                /* Adjust button padding */
            }

            .view-details-btn:hover {
                background-color: #286090;
            }

            .box-header {
                background-color: #337ab7;
                padding: 10px;
                margin-bottom: 15px;
                border-bottom: 1px solid #ddd;
                margin-bottom: 0;
                color: #fff;
                border: 1px solid #333;

            }

            /* Outer border for the table container */
            .table-container {
                border: 1px solid #333;
                padding: 0;
                background-color: #fff;
            }

            .table thead th {
                background-color: #f8f9fa;
                color: #333;
                font-weight: bold;
                text-align: center;
            }

            /*  */
            .status-container {
                border: 1px solid #ddd;
                padding: 20px;
                margin-bottom: 20px;
                background-color: #fff;
                word-wrap: break-word;
                overflow-wrap: break-word;
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .status-header {
                font-size: 1.5em;
                margin-bottom: 10px;
                color: #333;
                border-bottom: 2px solid #f0f2f5;
                padding-bottom: 10px;
            }

            .status-item,
            .comments {
                margin-bottom: 10px;
            }

            .comments {
                max-height: 100px;
                overflow-y: auto;
            }

            .status-label {
                font-weight: bold;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
                margin: -10px;
                margin-bottom: 20px;
            }
        </style>
    @endpush
    @if (g('return_url'))
        <p class="noprint"><a title='Return' href='{{ g('return_url') }}'><i class='fa fa-chevron-circle-left '></i> &nbsp;
                {{ trans('crudbooster.form_back_to_list', ['module' => CRUDBooster::getCurrentModule()->name]) }}</a></p>
    @else
        <p class="noprint"><a title='Main Module' href='{{ CRUDBooster::mainpath() }}'><i
                    class='fa fa-chevron-circle-left '></i> &nbsp;
                {{ trans('crudbooster.form_back_to_list', ['module' => CRUDBooster::getCurrentModule()->name]) }}</a></p>
    @endif

    <div class='panel panel-default'>
        <div class='panel-heading'>
            Petty Cash Form
        </div>
        <form action='{{ CRUDBooster::mainpath('edit-save/' . $Header->requested_id) }}' method="POST"
            id="PettyCashApprovalForm" enctype="multipart/form-data">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
            <input type="hidden" value="" name="approval_action" id="approval_action">
            <div class='panel-body'>




                <div class="container-fluid mt-4">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label
                                    class="control-label require">*{{ trans('message.form-label.transmittal_date') }}</label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type='input' name='transmittal_date' id="datepicker" onkeydown="return false"
                                        required autocomplete="off" class='form-control' placeholder="yyyy-mm-dd" />
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row row-eq-height">
                        <div class="col-lg-6 mb-4">
                            <div class="detail-container">
                                <div class="detail-row">
                                    <label>{{ trans('message.form-label.created_by') }}:</label>
                                    <span>{{ $Header->requestor_name }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ trans('message.form-label.created_at') }}:</label>
                                    <span>{{ $Header->requested_date }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ trans('message.form-label.reference_number') }}:</label>
                                    <span>{{ $Header->requested_date }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ trans('message.form-label.department_id') }}:</label>
                                    <span>{{ $Header->department_name }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ trans('message.form-label.sub_department_id') }}:</label>
                                    <span>{{ $Header->sub_department_name }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ trans('message.form-label.status_id') }}:</label>
                                    <span>{{ $Header->status_name }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>{{ trans('message.form-label.company_id') }}:</label>
                                    <span>{{ $Header->intercolevel }}</span>
                                </div>
                                <div class="detail-row">
                                    <label>Need By Date:</label>
                                    <span>{{ $Header->need_by_date }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <div class="receipt-container">
                                <label>{{ trans('message.form-label.receipt') }}:</label>
                                @if (strpos($Header->receipt, '.pdf'))
                                    <div class="pdf-container" style="border: 2px solid #ddd;">
                                        @foreach (explode('|', $Header->receipt) as $info)
                                            <embed class="receipt-embed" src="{{ asset("$info") }}" />
                                        @endforeach
                                    </div>
                                @else
                                    <div class="slideshow-container" style="border: 2px solid #ddd;">
                                        @foreach (explode('|', $Header->receipt) as $infos)
                                            <div class="mySlides1">
                                                <a href="{{ asset("$infos") }}" target="_blank">
                                                    <img src="{{ asset("$infos") }}" style="width:100%;height:400px;">
                                                </a>
                                            </div>
                                        @endforeach

                                        <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                                        <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div style="overflow-x:auto;">
                    <table width="100%">
                        <tr>
                            <td width="17%"><label>{{ trans('message.form-label.created_by') }}:</label></td>

                            <td width="34%">
                                <p>{{ $Header->requestor_name }}</p>
                            </td>

                            <td width="17%"><label>{{ trans('message.form-label.created_at') }}:</label> </td>

                            <td>
                                <p>{{ $Header->requested_date }}</p>
                            </td>


                        </tr>

                        <tr>
                            <td width="17%"><label>{{ trans('message.form-label.reference_number') }}:</label></td>

                            <td width="34%">
                                <p>{{ $Header->reference_number }}</p>
                            </td>

                            <td width="17%">
                                <label>{{ trans('message.form-label.receipt') }}:</label>
                            </td>

                            <td rowspan="5">

                                @if (strpos($Header->receipt, '.pdf'))
                                    @foreach (explode('|', $Header->receipt) as $info)
                                        <embed style="margin-top:30px; border: 2px solid #ddd;" src="{{ asset("$info") }}"
                                            width="500" height="400" />
                                    @endforeach
                                @else
                                    <div class="slideshow-container" style="border: 2px solid #ddd;">
                                        @foreach (explode('|', $Header->receipt) as $infos)
                                            <div class="mySlides1">
                                                <img src="{{ asset("$infos") }}" style="width:100%;height:400px;">
                                            </div>
                                        @endforeach

                                        <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                                        <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
                                    </div>
                                @endif

                            </td>

                        </tr>



                        <tr>
                            <td width="17%"><label>{{ trans('message.form-label.department_id') }}:</label></td>

                            <td width="34%">
                                <p>{{ $Header->department_name }}</p>
                            </td>

                            <td width="17%"> </td>

                            <td></td>
                        </tr>

                        <tr>
                            <td width="17%"><label>{{ trans('message.form-label.sub_department_id') }}:</label></td>

                            <td width="34%">
                                <p>{{ $Header->sub_department_name }}</p>
                            </td>

                            <td width="17%"> </td>

                            <td></td>
                        </tr>

                        <tr>
                            <td width="17%"><label>{{ trans('message.form-label.status_id') }}:</label></td>

                            <td width="34%"><b>{{ $Header->status_name }}</b></td>

                            <td width="17%"> </td>

                            <td></td>
                        </tr>

                        <tr>
                            <td width="17%"><label>Need By Date:</label></td>

                            <td width="34%">{{ $Header->need_by_date }}</td>

                            <td width="17%"> </td>

                            <td></td>
                        </tr>

                    </table>
                </div> --}}


                <div class="container-fluid" style="margin-top: 20px">

                    <div class="row">

                        <div class="col-md-12">
                            <div class="box-header text-center">
                                <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <div class="hack1" style="  display: table; table-layout: fixed; width: 100%;">
                                        <div class="table-container hack2"
                                            style="  display: table-cell; overflow-x: auto; width: 100%;">
                                            <table class="table table-bordered" id="requestTable">
                                                <tbody id="bodyTable">

                                                    <tr class="tbl_header_color dynamicRows">
                                                        <th class="text-center">
                                                            {{ trans('message.table.invoice_number') }}</th>
                                                        <th class="text-center">
                                                            {{ trans('message.table.invoice_date') }}</th>
                                                        <th class="text-center">
                                                            {{ trans('message.table.invoice_type_id') }}</th>
                                                        <th class="text-center">
                                                            {{ trans('message.table.vat_type_id') }}</th>
                                                        {{-- <th class="text-center">
                                                            {{ trans('message.table.payment_status_id') }}</th> --}}

                                                        <th class="text-center">
                                                            {{ trans('message.table.particulars_text') }}</th>
                                                        <th class="text-center">
                                                            {{ trans('message.table.concept_id_text') }}</th>

                                                        <th class="text-center">
                                                            {{ trans('message.table.location_id_text') }}</th>

                                                        <th class="text-center">
                                                            {{ trans('message.table.category_id_text') }}</th>
                                                        <th class="text-center">
                                                            {{ trans('message.table.account_id_text') }}</th>
                                                        <th class="text-center">
                                                            {{ trans('message.table.currency_id_text') }}</th>
                                                        <th class="text-center">
                                                            {{ trans('message.table.quantity_text') }}</th>
                                                        <th class="text-center">
                                                            {{ trans('message.table.line_value_text') }}</th>
                                                        <th class="text-center">
                                                            {{ trans('message.table.total_value_text') }}</th>

                                                    </tr>


                                                    @foreach ($Body as $rowresult)
                                                        <tr>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->invoice_number }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->invoice_date }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->invoice_type_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->vat_type_name }}</td>
                                                            {{-- <td style="text-align:center" height="10">
                                                                {{ $rowresult->payment_status_name }}</td> --}}
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->particulars }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->brand_name }}</td>

                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->store_name }}</td>

                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->category_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->account_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->currency_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->quantity }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->line_value }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->total_value }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                                <tfoot>

                                                    <tr id="tr-table1" class="bottom">


                                                        <td colspan="12" align="right">
                                                            <strong>{{ trans('message.table.total_value_order_text') }}</strong>
                                                        </td>
                                                        <td align="center" colspan="1">
                                                            <b>{{ $Header->total_value_order }}</b>
                                                        </td>

                                                    </tr>

                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>

                        </div>
                        {{-- <div class="box-header text-center">
                            <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <div class="container">
                                    <div class="hack1"
                                        style="  display: table;
                                    table-layout: fixed;
                                    width: 100%;">
                                        <div class="hack2"
                                            style="  display: table-cell;
                                    overflow-x: auto;
                                    width: 100%;">
                                            <table class="table table-bordered" id="requestTable">
                                                <tbody id="bodyTable">

                                                    <tr class="tbl_header_color dynamicRows">
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.invoice_number') }}</th>
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.invoice_date') }}</th>
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.invoice_type_id') }}</th>
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.vat_type_id') }}</th>
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.payment_status_id') }}</th>
                                                        <th width="20%" class="text-center">
                                                            {{ trans('message.table.particulars_text') }}</th>
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.brand_id_text') }}</th>

                                                        <th width="14%" class="text-center">
                                                            {{ trans('message.table.location_id_text') }}</th>

                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.category_id_text') }}</th>
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.account_id_text') }}</th>
                                                        <th width="10%" class="text-center">
                                                            {{ trans('message.table.currency_id_text') }}</th>
                                                        <th width="7%" class="text-center">
                                                            {{ trans('message.table.quantity_text') }}</th>
                                                        <th width="8%" class="text-center">
                                                            {{ trans('message.table.line_value_text') }}</th>
                                                        <th width="10%" class="text-center">
                                                            {{ trans('message.table.total_value_text') }}</th>
                                                    </tr>


                                                    @foreach ($Body as $rowresult)
                                                        <tr>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->invoice_number }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->invoice_date }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->invoice_type_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->vat_type_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->payment_status_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->particulars }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->brand_name }}</td>

                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->store_name }}</td>

                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->category_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->account_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->currency_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->quantity }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->line_value }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->total_value }}</td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                                <tfoot>

                                                    <tr id="tr-table1" class="bottom">


                                                        <td colspan="11" align="right">
                                                            <strong>{{ trans('message.table.total_value_order_text') }}</strong>
                                                        </td>
                                                        <td align="center" colspan="1">
                                                            <b>{{ $Header->total_value_order }}</b>
                                                        </td>

                                                    </tr>

                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div> --}}




                    </div>

                    <div class="row">
                        <div class="col-md-12 col-flex">
                            <div class="status-container">
                                <div class="status-item">
                                    <div class="status-item">
                                        <span class="status-label">{{ trans('message.table.note') }}:</span>
                                        {{ $Header->requestor_comments }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-flex">
                            <div class="status-container ">
                                <div class="status-header">Approval Details</div>
                                <div class="status-item">
                                    <span class="status-label">{{ trans('message.form-label.approved_by') }}:</span>
                                    {{ $Header->approverlevel }}
                                </div>
                                <div class="status-item">
                                    <span class="status-label">{{ trans('message.form-label.approved_at') }}:</span>
                                    {{ $Header->approved_at }}
                                </div>
                                <div class="comments">
                                    <span class="status-label">{{ trans('message.table.approver_comments') }}:</span>
                                    {{ $Header->approver_comments }}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-6 col-flex">
                            <div class="status-container ">
                                <div class="status-header">Validation Details</div>
                                <div class="status-item">
                                    <span class="status-label">{{ trans('message.form-label.validated_by') }}:</span>
                                    {{ $Header->validatorlevel }}
                                </div>
                                <div class="status-item">
                                    <span class="status-label">{{ trans('message.form-label.validated_at') }}:</span>
                                    {{ $Header->validated_at }}
                                </div>
                                <div class="comments">
                                    <span class="status-label">Comments:</span>
                                    {{ $Header->ap_checker_comments }}
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-flex">
                            <div class="status-container">
                                <div class="status-header">Print Details</div>
                                <div class="status-item">
                                    <span class="status-label">{{ trans('message.form-label.printed_by') }}:</span>
                                    {{ $Header->validatorlevel }}
                                </div>
                                <div class="status-item">
                                    <span class="status-label">{{ trans('message.form-label.printed_at') }}:</span>
                                    {{ $Header->printed_at }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- <hr />

                <div class="row">
                    <label class="control-label col-md-2">{{ trans('message.form-label.approved_by') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->approverlevel }}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.approved_at') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->approved_at }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('message.table.approver_comments') }}:</label>
                            <p>{{ $Header->approver_comments }}</p>
                        </div>
                    </div>
                </div>

                <hr />
                <div class="row">
                    <label class="control-label col-md-2">{{ trans('message.form-label.validated_by') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->validatorlevel }}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.validated_at') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->validated_at }}</p>
                    </div>
                </div>

                <hr />
                <div class="row">
                    <label class="control-label col-md-2">{{ trans('message.form-label.printed_by') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->printedlevel }}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.printed_at') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->printed_at }}</p>
                    </div>
                </div> --}}
                <!--
                                                                                                                    <div class="row">
                                                                                                                        <label class="control-label col-md-2">{{ trans('message.form-label.invoice_type_id') }}:</label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <p>{{ $Header->invoice_type_name }}</p>
                                                                                                                        </div>

                                                                                                                        <label class="control-label col-md-2">{{ trans('message.form-label.payment_status_id') }}:</label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <p>{{ $Header->payment_status_name }}</p>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="row">
                                                                                                                        <label class="control-label col-md-2">{{ trans('message.form-label.vat_type_id') }}:</label>
                                                                                                                        <div class="col-md-4">
                                                                                                                                <p>{{ $Header->vat_type_name }}</p>
                                                                                                                        </div>

                                                                                                                        
                                                                                                                    </div> -->

            </div>

            <div class='panel-footer'>
                <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>
                <button class="btn btn-primary pull-right" type="button" id="btnConfirm"><i class="fa fa-share"
                        style="margin-right: 5px;"></i>{{ trans('message.form.transmit') }}</button>
            </div>
        </form>
    </div>
@endsection

@push('bottom')
    <script type="text/javascript">
        function preventBack() {
            window.history.forward();
        }
        window.onunload = function() {
            null;
        };
        setTimeout("preventBack()", 0);

        $("#datepicker").datepicker({
            maxDate: 0,
            dateFormat: 'yy-mm-dd'
        });

        $('#btnConfirm').click(function() {

            var selectedDate = $('#datepicker').val();

            if (!selectedDate) {
                alert("Please select a date.");
            } else {
                $('#date-error').hide();

                var strconfirm = confirm("Are you sure you want to proceed?");
                if (strconfirm == true) {

                    $(this).attr('disabled', 'disabled');
                    $('#approval_action').val('1');
                    $('#PettyCashApprovalForm').submit();

                } else {
                    return false;
                    window.stop();
                }
            }



        });

        var slideIndex = [1, 1];
        var slideId = ["mySlides1", "mySlides2"]
        showSlides(1, 0);
        showSlides(1, 1);

        function plusSlides(n, no) {
            showSlides(slideIndex[no] += n, no);
        }

        function showSlides(n, no) {
            var i;
            var x = document.getElementsByClassName(slideId[no]);
            if (n > x.length) {
                slideIndex[no] = 1
            }
            if (n < 1) {
                slideIndex[no] = x.length
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            x[slideIndex[no] - 1].style.display = "block";
        }
    </script>
@endpush
