@extends('crudbooster::admin_template')
@section('content')
    @push('head')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <style type="text/css">
            * {
                box-sizing: border-box
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

            .table-responsive {
                padding: 0;
            }

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

            .row-eq-height {
                display: flex;
                flex-wrap: wrap;
            }

            .row-eq-height [class*="col-"] {
                display: flex;
                flex-direction: column;
            }

            /* detail-container, receipt-container and closed-receipt */
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

            .receipt-container,
            .closed-receipt-container {
                position: relative;
                overflow: hidden;
            }

            .receipt-container .carousel-inner,
            .status-container .carousel-inner {
                height: 100%;
                text-align: center;
            }

            .receipt-container .carousel-inner .item,
            .status-container .carousel-inner .item {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }

            .receipt-container img,
            .status-container img {
                max-width: 100%;
                max-height: 300px;
                width: auto;
                height: auto;
                object-fit: contain;
                cursor: pointer;
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
                padding-right: 15px;
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

            .downloadPdfBtn {
                width: auto;
                margin-top: 20px;
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
        <form method='post' id="myform" action='{{ CRUDBooster::mainpath('edit-save/' . $Header->id) }}'>
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
            <div class='panel-body'>

                <div class="container-fluid mt-4">
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
                                    <label>Mode Of Payment:</label>
                                    <span>{{ $Header->mode_of_payment_name }}</span>
                                </div>
                                @if ($Header->mode_of_payment_id == 1)
                                    <div class="detail-row">
                                        <label>GCash#:</label>
                                        <span>
                                            <p>{{ $Header->gcash_number }}</p>
                                        </span>
                                    </div>
                                @elseif ($Header->mode_of_payment_id == 2)
                                    <div class="detail-row">
                                        <div class="bank-details-group">
                                            <div class="bank-detail">
                                                <label>Bank Name:</label>
                                                <span>{{ $Header->bank_name }}</span>
                                            </div>
                                            <div class="bank-detail">
                                                <label>Bank Branch Name:</label>
                                                <span>{{ $Header->bank_branch_name }}</span>
                                            </div>
                                        </div>
                                        <div class="bank-details-group">
                                            <div class="bank-detail">
                                                <label>Bank Account Name:</label>
                                                <span>{{ $Header->bank_account_name }}</span>
                                            </div>
                                            <div class="bank-detail">
                                                <label>Bank Account Number:</label>
                                                <span>{{ $Header->bank_account_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($Header->mode_of_payment_id == 3)
                                    <div class="detail-row">
                                        <div class="payee-details-group">
                                            <div class="payee-detail">
                                                <label>Payee Name:</label>
                                                <span>{{ $Header->payee_name }}</span>
                                            </div>
                                            <div class="payee-detail">
                                                <label>Bank Account Number:</label>
                                                <span>{{ $Header->bank_account_number }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="detail-row">
                                    <label>{{ trans('message.form-label.company_id') }}:</label>
                                    <span>{{ $Header->companylevel }}</span>
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
                                            <embed style="" class="receipt-embed" src="{{ asset("$info") }}" />
                                        @endforeach
                                    </div>
                                @else
                                    <div class="slideshow-container" style="border: 2px solid #ddd;">
                                        @foreach (explode('|', $Header->receipt) as $infos)
                                            <div class="mySlides1">
                                                <a href="{{ asset("$infos") }}" target="_blank">
                                                    <img src="{{ asset("$infos") }}">
                                                </a>
                                            </div>
                                        @endforeach

                                        <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                                        <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
                                    </div>
                                    <div>
                                        <button type="button" class="downloadPdfBtn btn btn-primary"
                                            onclick="printImageAsPDF(0)">Print as PDF</button>
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

                        </tr> --}}


                <!--
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <tr>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td  width="17%"><label>{{ trans('message.form-label.location_id') }}:</label></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td width="34%">  <p>{{ $Header->store_name }}</p></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td width="17%"> </td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <td></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </tr> -->

                {{-- <tr>
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

                            <td width="17%"><label>Mode Of Payment:</label></td>

                            <td width="34%">
                                <p>{{ $Header->mode_of_payment_name }}</p>
                            </td>

                        </tr>

                        @if ($Header->mode_of_payment_id == 1)
                            <tr>

                                <td width="17%"><label>GCash#:</label></td>

                                <td width="34%">
                                    <p>{{ $Header->gcash_number }}</p>
                                </td>

                            </tr>
                        @elseif($Header->mode_of_payment_id == 2)
                            <tr>
                                <td width="17%"><label>Bank Name:</label></td>

                                <td width="34%">{{ $Header->bank_name }}</td>

                                <td width="17%"><label>Bank Branch Name:</label></td>

                                <td>{{ $Header->bank_branch_name }}</td>
                            </tr>

                            <tr>
                                <td width="17%"><label>Bank Account Name:</label></td>

                                <td width="34%">{{ $Header->bank_account_name }}</td>

                                <td width="17%"><label>Bank Account Number:</label></td>

                                <td>{{ $Header->bank_account_number }}</td>
                            </tr>
                        @elseif($Header->mode_of_payment_id == 3)
                            <tr>
                                <td width="17%"><label>Payee Name:</label></td>

                                <td width="34%">{{ $Header->payee_name }}</td>

                            </tr>
                        @endif

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

                        <div class="items-container col-md-12">

                            {{-- <div class="box-header text-center">
                                <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                            </div>
                            <div class="box-body no-padding">
                                 <div class="table-container">
                                    <table class="table table-bordered" id="requestTable">
                                        <thead>
                                            <tr class="dynamicRows">
                                                <th class="text-center">{{ trans('message.table.invoice_number') }}</th>
                                                <th class="text-center">{{ trans('message.table.invoice_date') }}</th>
                                                <th class="text-center">{{ trans('message.table.invoice_type_id') }}</th>
                                                <th class="text-center">{{ trans('message.table.vat_type_id') }}</th>
                                                <th class="text-center">{{ trans('message.table.payment_status_id') }}</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyTable">
                                            @foreach ($Body as $rowresult)
                                                <tr>
                                                    <td class="text-center">{{ $rowresult->invoice_number }}</td>
                                                    <td class="text-center">{{ $rowresult->invoice_date }}</td>
                                                    <td class="text-center">{{ $rowresult->invoice_type_name }}</td>
                                                    <td class="text-center">{{ $rowresult->vat_type_name }}</td>
                                                    <td class="text-center">{{ $rowresult->payment_status_name }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-primary view-details-btn"
                                                            data-invoice-number="{{ $rowresult->invoice_number }}"
                                                            data-invoice-date="{{ $rowresult->invoice_date }}"
                                                            data-invoice-type="{{ $rowresult->invoice_type_name }}"
                                                            data-vat-type="{{ $rowresult->vat_type_name }}"
                                                            data-payment-status="{{ $rowresult->payment_status_name }}"
                                                            data-particulars="{{ $rowresult->particulars }}"
                                                            data-brand="{{ $rowresult->brand_name }}"
                                                            data-location="{{ $rowresult->store_name }}"
                                                            data-category="{{ $rowresult->category_name }}"
                                                            data-account="{{ $rowresult->account_name }}"
                                                            data-currency="{{ $rowresult->currency_name }}"
                                                            data-quantity="{{ $rowresult->quantity }}"
                                                            data-line-value="{{ $rowresult->line_value }}"
                                                            data-total-value="{{ $rowresult->total_value }}">
                                                            View Details
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal for View Details -->
                                <div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog"
                                    aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="{{ trans('message.button.close') }}"><span
                                                        aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="viewDetailsModalLabel">
                                                    Details</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div id="detailsContent">
                                                    <!-- Details content will be dynamically filled by jQuery -->
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div> --}}


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
                </div>

                {{-- STATUS --}}

                <div class="container-fluid">

                    <div class="row">
                        @if ($Header->approved_at != null)
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
                        @endif

                        @if ($Header->validated_at != null)
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
                                        <span class="status-label">Comments:</span> {{ $Header->ap_checker_comments }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>




                    <div class="row">
                        @if ($Header->validated_at != null)
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
                        @endif

                        @if ($Header->supervisor_approval_date != null)
                            <div class="col-xs-12 col-sm-6 col-md-6 col-flex">
                                <div class="status-container">
                                    <div class="status-header">Transmittal Details</div>
                                    <div class="status-item">
                                        <span class="status-label">Transmitted By:</span>
                                        {{ $Header->transmittedlevel }}
                                    </div>
                                    {{-- <div class="status-item">
                                        <span class="status-label">Confirmed Date:</span>
                                        {{ $Header->supervisor_approval_date }}
                                    </div> --}}
                                    <div class="status-item">
                                        <span class="status-label">Transmittal Date:</span>
                                        {{ $Header->transmittal_date }}
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>

                    {{--  --}}
                    <div class="row">
                        @if ($Header->paid_at != null)
                            <div class="col-xs-12 col-sm-6 col-md-6 col-flex">
                                <div class="status-container ">
                                    <div class="status-header">Transaction Details</div>
                                    <div class="status-item">
                                        <span class="status-label">{{ trans('message.form-label.paid_by') }}:</span>
                                        {{ $Header->paidlevel }}
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">{{ trans('message.form-label.paid_at') }}:</span>
                                        {{ $Header->paid_at }}
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">{{ trans('message.form-label.release_date') }}:</span>
                                        {{ $Header->paid_date }}
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">{{ trans('message.form-label.check_number') }}:</span>
                                        {{ $Header->check_number }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if ($Header->closedlevel != null)
                            <div class="col-xs-12 col-sm-6 col-md-6 col-flex">
                                <div class="status-container">
                                    <div class="status-header">Closure Details</div>
                                    <div class="status-item">
                                        <span class="status-label">{{ trans('message.form-label.closed_by') }}:</span>
                                        {{ $Header->closedlevel }}
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">{{ trans('message.form-label.closed_at') }}:</span>
                                        {{ $Header->closed_at }}
                                    </div>

                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="row">
                        @if ($Header->closedlevel != null)
                            <div class="col-xs-12 col-sm-6 col-md-6 col-flex">
                                <div class="status-container closed-receipt-container">
                                    <div class="status-header">{{ trans('message.form-label.receipt') }}:</div>

                                    <div class="slideshow-container">
                                        @foreach (explode('|', $Header->close_receipt) as $info)
                                            <div class="mySlides2">
                                                <a href="{{ asset("$info") }}" target="_blank">
                                                    <img src="{{ asset("$info") }}">
                                                </a>
                                            </div>
                                        @endforeach

                                        <a class="prev" onclick="plusSlides(-1, 1)">&#10094;</a>
                                        <a class="next" onclick="plusSlides(1, 1)">&#10095;</a>
                                    </div>
                                    <div>
                                        <button type="button" class="downloadPdfBtn btn btn-primary"
                                            onclick="printImageAsPDF(1)">Print as
                                            PDF</button>
                                    </div>


                                </div>

                            </div>
                        @endif
                    </div>


                </div>



                {{-- @if ($Header->approved_at != null)
                    <hr />
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
                @endif 


                @if ($Header->validated_at != null)
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
                    </div> 

                    <!--  <div class="row">
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
                @endif 


                @if ($Header->paid_at != null)
                    <hr />
                    <div class="row">
                        <label class="control-label col-md-2">{{ trans('message.form-label.paid_by') }}:</label>
                        <div class="col-md-4">
                            <p>{{ $Header->paidlevel }}</p>
                        </div>

                        <label class="control-label col-md-2">{{ trans('message.form-label.paid_at') }}:</label>
                        <div class="col-md-4">
                            <p>{{ $Header->paid_at }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <label class="control-label col-md-2">{{ trans('message.form-label.paid_date') }}:</label>
                        <div class="col-md-4">
                            <p>{{ $Header->paid_date }}</p>
                        </div>
                    </div>
                @endif


                @if ($Header->closedlevel != null)
                    <hr />
                    <div class="row">
                        <label class="control-label col-md-2">{{ trans('message.form-label.closed_by') }}:</label>
                        <div class="col-md-4">
                            <p>{{ $Header->closedlevel }}</p>
                        </div>

                        <label class="control-label col-md-2">{{ trans('message.form-label.closed_at') }}:</label>
                        <div class="col-md-4">
                            <p>{{ $Header->closed_at }}</p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="control-label col-md-2">{{ trans('message.form-label.close_receipt') }}:</label>
                        <div class="col-md-4">
                            <div class="slideshow-container">
                                @foreach (explode('|', $Header->close_receipt) as $info)
                                    <div class="mySlides2">
                                        <img src="{{ asset("$info") }}" style="width:100%;height:400px">
                                    </div>
                                @endforeach

                                <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                                <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
                            </div>
                        </div>
                    </div>
                @endif

                --}}

            </div>
            <div class='panel-footer'>
                <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.back') }}</a>
            </div>
        </form>





    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <script>
        function printImageAsPDF(id) {
            window.jsPDF = window.jspdf.jsPDF;

            // Get all image elements with class 'mySlides1' or 'mySlides2'
            var slides = id === 0 ? document.getElementsByClassName("mySlides1") : document.getElementsByClassName(
                "mySlides2");

            if (!slides.length) {
                console.error("No image elements found with specified class.");
                return;
            }

            if (typeof jsPDF !== 'undefined') {
                var pdf = new jsPDF();
                var counter = 0;

                function processSlide(slide) {
                    return new Promise((resolve, reject) => {
                        var image = slide.querySelector('img');

                        if (!image) {
                            console.error("Image element not found in slide.");
                            reject("Image element not found in slide.");
                            return;
                        }

                        var imageURL = image.src;

                        // Load image as base64
                        var img = new Image();
                        img.crossOrigin = "Anonymous";
                        img.onload = function() {
                            var canvas = document.createElement('canvas');
                            canvas.width = img.width;
                            canvas.height = img.height;
                            var ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0);

                            var imgData = canvas.toDataURL('image/jpeg');

                            var pdfWidth = pdf.internal.pageSize.getWidth();
                            var pdfHeight = pdf.internal.pageSize.getHeight();

                            // Calculate dimensions to maintain aspect ratio
                            var imgWidth = pdfWidth - 20; // Adjusted based on margins or padding
                            var imgHeight = img.height * (imgWidth / img.width);

                            // Add a new page for each image, except the first one
                            if (counter > 0) {
                                pdf.addPage();
                            }

                            // Add the image to the PDF document on the new page
                            pdf.addImage(imgData, 'JPEG', 10, 10, imgWidth, imgHeight);

                            // Increment counter for next image ID
                            counter++;

                            resolve();
                        };
                        img.onerror = function() {
                            console.error("Failed to load image:", imageURL);
                            reject("Failed to load image.");
                        };
                        img.src = imageURL;
                    });
                }

                var slidePromises = Array.prototype.map.call(slides, processSlide);

                Promise.all(slidePromises).then(() => {
                    // After all images are loaded into the PDF, open print window
                    var pdfDataUri = pdf.output('datauristring');
                    var printWindow = window.open('', '_blank');
                    if (!printWindow) {
                        console.error("Failed to open new window for printing.");
                        return;
                    }
                    printWindow.document.write('<html><head><title>Print Preview</title></head><body>');
                    printWindow.document.write('<embed width="100%" height="100%" name="plugin" src="' +
                        pdfDataUri + '" type="application/pdf" />');
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();

                    // Allow user to print manually
                    setTimeout(function() {
                        printWindow.print();
                        printWindow.focus(); // Ensure the print dialog is in focus
                    }, 1000); // Adjust timing as needed
                }).catch(error => {
                    console.error("Error processing slides:", error);
                });
            } else {
                console.error("jsPDF library is not loaded or available.");
            }
        }


        $(document).ready(function() {
            $('.view-details-btn').click(function() {
                var invoiceNumber = $(this).data('invoice-number');
                var invoiceDate = $(this).data('invoice-date');
                var invoiceType = $(this).data('invoice-type');
                var vatType = $(this).data('vat-type');
                var paymentStatus = $(this).data('payment-status');
                var particulars = $(this).data('particulars');
                var brand = $(this).data('brand');
                var location = $(this).data('location');
                var category = $(this).data('category');
                var account = $(this).data('account');
                var currency = $(this).data('currency');
                var quantity = $(this).data('quantity');
                var lineValue = $(this).data('line-value');
                var totalValue = $(this).data('total-value');

                var detailsHtml = '<ul class="list-unstyled">';
                detailsHtml += '<li><strong>{{ trans('message.table.invoice_number') }}:</strong> ' +
                    invoiceNumber + '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.invoice_date') }}:</strong> ' +
                    invoiceDate + '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.invoice_type_id') }}:</strong> ' +
                    invoiceType + '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.vat_type_id') }}:</strong> ' +
                    vatType +
                    '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.payment_status_id') }}:</strong> ' +
                    paymentStatus + '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.particulars_text') }}:</strong> ' +
                    particulars + '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.brand_id_text') }}:</strong> ' +
                    brand +
                    '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.location_id_text') }}:</strong> ' +
                    location +
                    '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.category_id_text') }}:</strong> ' +
                    category +
                    '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.account_id_text') }}:</strong> ' +
                    account +
                    '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.currency_id_text') }}:</strong> ' +
                    currency +
                    '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.quantity_text') }}:</strong> ' +
                    quantity +
                    '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.line_value_text') }}:</strong> ' +
                    lineValue + '</li>';
                detailsHtml += '<li><strong>{{ trans('message.table.total_value_text') }}:</strong> ' +
                    totalValue + '</li>';
                detailsHtml += '</ul>';

                $('#detailsContent').html(detailsHtml);
                $('#viewDetailsModal').modal('show');
            });
        });
    </script>

@endsection

@push('bottom')
    <script type="text/javascript">
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
