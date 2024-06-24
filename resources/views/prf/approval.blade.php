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

            .row-eq-height {
                display: flex;
                flex-wrap: wrap;
            }

            .row-eq-height [class*="col-"] {
                display: flex;
                flex-direction: column;
            }

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
        <form action='{{ CRUDBooster::mainpath('edit-save/' . $Header->id) }}' method="POST" id="PettyCashApprovalForm"
            enctype="multipart/form-data">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
            <input type="hidden" value="" name="approval_action" id="approval_action">
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
                                <p>{{ $Header->created_at }}</p>
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
                        <!--
                            <tr>
                                <td  width="17%"><label>{{ trans('message.form-label.location_id') }}:</label></td>
            
                                <td width="34%">  <p>{{ $Header->store_name }}</p></td>
            
                                <td width="17%"> </td>
            
                                <td></td>
                            </tr>
                            -->

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
                </div>

                <hr /> --}}

                <div class="container-fluid" style="margin-top: 20px">
                    <div class="row" style="margin-top: 20px;">

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


                                                        <td colspan="8" align="right">
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
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.total_value_text') }}</th>
                                                    </tr>


                                                    @foreach ($Body as $rowresult)
                                                        <tr>
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


                                                        <td colspan="8" align="right">
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

                    <div>
                        <div class="form-group">
                            <label>{{ trans('message.table.note') }}:</label>
                            <p>{{ $Header->requestor_comments }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('message.table.comments') }}:</label>
                                <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" class="form-control"
                                    name="approver_comments">{{ $Header->approver_comments }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>


            </div>



    </div>

    <div class='panel-footer'>
        <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>

        <button class="btn btn-danger pull-right" type="button" id="btnReject" style="margin-left: 5px;"><i
                class="fa fa-thumbs-down"></i> Reject</button>
        <button class="btn btn-success pull-right" type="button" id="btnApprove"><i class="fa fa-thumbs-up"></i>
            Approve</button>
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

        $('#btnApprove').click(function() {

            var strconfirm = confirm("Are you sure you want to approve this request?");
            if (strconfirm == true) {

                $(this).attr('disabled', 'disabled');
                $('#approval_action').val('1');
                $('#PettyCashApprovalForm').submit();

            } else {
                return false;
                window.stop();
            }

        });

        $('#btnReject').click(function() {

            var strconfirm = confirm("Are you sure you want to reject this request?");
            if (strconfirm == true) {

                $(this).attr('disabled', 'disabled');
                $('#approval_action').val('0');
                $('#PettyCashApprovalForm').submit();

            } else {
                return false;
                window.stop();
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

        $(document).ready(function() {
            $('#slideshow').carousel();
        });
    </script>
@endpush
