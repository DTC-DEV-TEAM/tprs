@extends('crudbooster::admin_template')
@section('content')
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

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label require">*Recorded Date</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type='date' name='paid_date' id="datepicker" onkeydown="return false" required
                                    autocomplete="off" class='form-control' placeholder="yyyy-mm-dd" />
                            </div>
                        </div>

                    </div>

                </div>

                <hr />

                <div class="row">
                    <label class="control-label col-md-2">{{ trans('message.form-label.created_by') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->requestor_name }}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.created_at') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->requested_date }}</p>
                    </div>
                </div>

                <div class="row">

                    <label class="control-label col-md-2">{{ trans('message.form-label.reference_number') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->reference_number }}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.status_id') }}:</label>
                    <div class="col-md-4">
                        <b>{{ $Header->status_name }}</b>
                    </div>
                </div>

                <div class="row">
                    <label class="control-label col-md-2">{{ trans('message.form-label.department_id') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->department_name }}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.sub_department_id') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->sub_department_name }}</p>
                    </div>
                </div>

                <div class="row">
                    <label class="control-label col-md-2">{{ trans('message.table.note') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->requestor_comments }}</p>
                    </div>
                </div>


                <hr />

                <div class="row">

                    <div class="col-md-12">
                        <div class="box-header text-center">
                            <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <div class="container-fluid">
                                    <div class="hack1"
                                        style="  display: table;
                                    table-layout: fixed;
                                    width: 100%;">
                                        <div class="hack2"
                                            style="  display: table-cell;
                                    overflow-x: auto;
                                    width: 100%;">
                                            <table class="table" id="requestTable"
                                                style=" background-color: rgb(255, 250, 250); width: 100%;
                                    border-collapse: collapse; box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;">
                                                <tbody id="bodyTable">

                                                    <tr class="tbl_header_color dynamicRows">
                                                        <th width="12%" class="text-center">
                                                            {{ trans('message.table.invoice_type_id') }}</th>
                                                        <th width="12%" class="text-center">
                                                            {{ trans('message.table.vat_type_id') }}</th>
                                                        <th width="12%" class="text-center">
                                                            {{ trans('message.table.payment_status_id') }}</th>

                                                        <th width="8%" class="text-center">
                                                            {{ trans('message.table.si_or_number') }}</th>
                                                        <th width="8%" class="text-center">
                                                            {{ trans('message.table.si_or_date') }}</th>

                                                        <th width="20%" class="text-center">
                                                            {{ trans('message.table.particulars_text') }}</th>
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.concept') }}</th>

                                                        <th width="15%" class="text-center">
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
                                                                {{ $rowresult->invoice_type_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->vat_type_name }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->payment_status_name }}</td>

                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->si_or_number }}</td>
                                                            <td style="text-align:center" height="10">
                                                                {{ $rowresult->si_or_date }}</td>

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


                                                        <td colspan="13" align="right">
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
                        </div>

                    </div>

                </div>

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
                    <label class="control-label col-md-2">{{ trans('message.table.approver_comments') }}:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->approver_comments }}</p>
                    </div>
                </div>

                {{-- <hr/>
                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.recorded_by') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->recordedlevel}}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.recorded_at') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->recorded_at}}</p>
                    </div>
                </div>

                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.si_or_number') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->si_or_number}}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.si_or_date') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->si_or_date}}</p>
                    </div>
                </div>

                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.address') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->address}}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.tin_number') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->tin_number}}</p>
                    </div>
                </div>

                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.payee') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->payee}}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.vat_amount') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->vat_amount}}</p>
                    </div>
                </div>

                <hr/>
                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.validated_by') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->validatorlevel}}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.validated_at') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->validated_at}}</p>
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

                <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save"></i>
                    Release</button>
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

        // $("#datepicker").datepicker({
        //     maxDate: 0,
        //     dateFormat: 'yy-mm-dd'
        // });

        // calendar that can only select current date and 4 previous dates
        document.addEventListener('DOMContentLoaded', (event) => {
            const datePicker = document.getElementById('datepicker');
            const today = new Date();
            const todayStr = today.toISOString().split('T')[0];

            // Set the max date to today
            datePicker.setAttribute('max', todayStr);

            // Calculate the min date (4 days before today)
            const minDate = new Date();
            minDate.setDate(today.getDate() - 4);
            const minDateStr = minDate.toISOString().split('T')[0];

            // Set the min date to 4 days before today
            datePicker.setAttribute('min', minDateStr);

        });
    </script>
@endpush
