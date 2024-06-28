@extends('crudbooster::admin_template')

@push('head')
    <style>
        .table-responsive::-webkit-scrollbar {
            height: 10px !important;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* set the background color of the scrollbar track */
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background-color: #868686;
            /* set the color of the scrollbar thumb */
            border-radius: 5px;
            /* set the border radius of the scrollbar thumb */
        }
    </style>
@endpush

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
        <form action='{{ CRUDBooster::mainpath('edit-save/' . $Header->id) }}' method="POST" id="PettyCashForm"
            enctype="multipart/form-data">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
            <div class='panel-body'>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label require">{{ trans('message.form-label.department_id') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                <select class="form-control select2" style="width: 100%;" required name="department_id"
                                    id="department_id">
                                    <!--<option value="">-- Select Department --</option>-->
                                    @foreach ($Departments as $data)
                                        @if ($Header->department_id == $data->id)
                                            <option value="{{ $data->id }}" selected>{{ $data->department_name }}
                                            </option>
                                        @else
                                            <option value="{{ $data->id }}">{{ $data->department_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label
                                class="control-label require">{{ trans('message.form-label.sub_department_id') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                <select class="form-control select2" style="width: 100%;" required name="sub_department_id"
                                    id="sub_department_id">

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label require">{{ trans('message.form-label.requestor_name') }}</label>
                            <input type="text" class="form-control" id="requestor_name" name="requestor_name" required
                                value="{{ $Header->requestor_name }}">
                        </div>
                    </div>
                </div>

                <div class="row">

                </div>

                <?php $sub_departmentID = $Header->sub_department_id; ?>

                <hr />

                <div class="row">

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label require">*Company</label>

                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                <select class="form-control select2" required name="interco_id" id="interco_id">
                                    <option value="">-- Company --</option>
                                    @foreach ($Interco as $data)
                                        @if ($Header->interco_id == $data->id)
                                            <option value="{{ $data->id }}" selected>{{ $data->interco_name }}
                                            </option>
                                        @else
                                            <option value="{{ $data->id }}">{{ $data->interco_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                </div>

                @if ($Header->si_or_number != null)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label
                                    class="control-label require">*{{ trans('message.form-label.si_or_number') }}</label>
                                <input type="text" class="form-control" id="si_or_number" name="si_or_number" required
                                    value="{{ $Header->si_or_number }}">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.si_or_date') }}</label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type='input' name='si_or_date' id="datepicker" onkeydown="return false"
                                        required autocomplete="off" class='form-control' placeholder="yyyy-mm-dd"
                                        value="{{ $Header->si_or_date }}" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.address') }}</label>
                                <input type="text" class="form-control" id="address" name="address" required
                                    value="{{ $Header->address }}">
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.tin_number') }}</label>
                                <input type="text" class="form-control" id="tin_number" name="tin_number" required
                                    value="{{ $Header->tin_number }}">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.payee') }}</label>
                                <input type="text" class="form-control" id="payee" name="payee" required
                                    value="{{ $Header->payee }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.vat_amount') }}</label>
                                <input type="number" step="0.01" min="0" class="form-control"
                                    id="vat_amount" name="vat_amount" required value="{{ $Header->vat_amount }}">
                            </div>
                        </div>
                    </div>
                @endif

                @if ($Header->paid_date != null)
                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label require">*Recorded Date</label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type='date' name='paid_date' id="recordedDate" onkeydown="return false"
                                        required autocomplete="off" class='form-control' placeholder="yyyy-mm-dd"
                                        value="{{ $Header->paid_date }}" />
                                </div>
                            </div>

                        </div>

                    </div>
                @endif

                <div class="row">

                    <div class="col-md-12">

                        <p style="color:red; font-weight: bold;">Please limit request to 100 lines.</p>

                        <div class="box-header text-center">
                            <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <div class="container-fluid">
                                    <div class="hack1" style=" display: table; table-layout: fixed; width: 170%;">
                                        <div class="hack2" style=" display: table-cell;">
                                            <table class="table" id="requestTable"
                                                style=" background-color: rgb(255, 250, 250); width: 100%;
                                        border-collapse: collapse; box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;">
                                                <tbody id="bodyTable">


                                                    <tr class="tbl_header_color dynamicRows">

                                                        <th width="7%" class="text-center">
                                                            {{ trans('message.table.invoice_type_id') }}</th>
                                                        <th width="6%" class="text-center">
                                                            {{ trans('message.table.vat_type_id') }}</th>
                                                        <th width="7%" class="text-center">
                                                            {{ trans('message.table.payment_status_id') }}</th>
                                                        <!-- <th width="15%" class="text-center">{{ trans('message.table.product_id') }}</th> -->

                                                        <th width="8%" class="text-center">
                                                            {{ trans('message.table.si_or_number') }}</th>
                                                        <th width="8%" class="text-center">
                                                            {{ trans('message.table.si_or_date') }}</th>


                                                        <th width="13%" class="text-center">
                                                            {{ trans('message.table.particulars_text') }}</th>
                                                        <th width="8%" class="text-center">
                                                            {{ trans('message.table.concept') }}</th>

                                                        <th width="11%" class="text-center">
                                                            {{ trans('message.table.location_id_text') }}</th>

                                                        <th width="8%" class="text-center">
                                                            {{ trans('message.table.category_id_text') }}</th>
                                                        <th width="9%" class="text-center">
                                                            {{ trans('message.table.account_id_text') }}</th>
                                                        <th width="4%" class="text-center">
                                                            {{ trans('message.table.currency_id_text') }}</th>
                                                        <th width="3%" class="text-center">
                                                            {{ trans('message.table.quantity_text') }}</th>
                                                        <th width="4%" class="text-center">
                                                            {{ trans('message.table.line_value_text') }}</th>
                                                        <th width="5%" class="text-center">
                                                            {{ trans('message.table.total_value_text') }}</th>

                                                    </tr>

                                                    <tr id="tr-table">
                                                        <?php $tableRow = 1; ?>
                                                    <tr>
                                                        @foreach ($Body as $rowresult)
                                                            <?php $tableRow++; ?>

                                                    <tr>

                                                        <td style="text-align:center" height="10">
                                                            <select class="form-control select2" style="width: 100%;"
                                                                required name="invoice_type_id[]" id="invoice_type_id">
                                                                <option value="">--
                                                                    {{ trans('message.form-label.invoice_type_id') }} --
                                                                </option>
                                                                @foreach ($InvoiceType as $data)
                                                                    @if ($rowresult->invoice_type_id == $data->id)
                                                                        <option value="{{ $data->id }}" selected>
                                                                            {{ $data->invoice_type_name }}</option>
                                                                    @else
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->invoice_type_name }}</option>
                                                                    @endif
                                                                @endforeach

                                                            </select>
                                                        </td>
                                                        <td style="text-align:center" height="10">
                                                            <select class="form-control select2" style="width: 100%;"
                                                                required name="vat_type_id[]" id="vat_type_id">
                                                                <option value="">--
                                                                    {{ trans('message.form-label.vat_type_id') }} --
                                                                </option>
                                                                @foreach ($VatType as $data)
                                                                    @if ($rowresult->vat_type_id == $data->id)
                                                                        <option value="{{ $data->id }}" selected>
                                                                            {{ $data->vat_type_name }}</option>
                                                                    @else
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->vat_type_name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td style="text-align:center" height="10">
                                                            <select class="form-control select2" style="width: 100%;"
                                                                required name="payment_status_id[]"
                                                                id="payment_status_id">
                                                                <option value="">--
                                                                    {{ trans('message.form-label.payment_status_id') }} --
                                                                </option>
                                                                @foreach ($PaymentStatus as $data)
                                                                    @if ($rowresult->payment_status_id == $data->id)
                                                                        <option value="{{ $data->id }}" selected>
                                                                            {{ $data->payment_status_name }}</option>
                                                                    @else
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->payment_status_name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden"
                                                                class="form-control quantityNew text-center"
                                                                id="product_id" step="any" name="product_id[]"
                                                                min="0" required maxlength="100" value="000">
                                                        </td>


                                                        <td>
                                                            <input type="text" class="form-control" id="si_or_number"
                                                                name="si_or_number[]" required>
                                                        </td>

                                                        <td>

                                                            <div class="input-group date">
                                                                <div class="input-group-addon"><i
                                                                        class="fa fa-calendar"></i></div>
                                                                <input type='input' name='si_or_date[]'
                                                                    id="datepicker{{ $tableRow }}"
                                                                    onkeydown="return false" required autocomplete="off"
                                                                    class='form-control dateset'
                                                                    placeholder="yyyy-mm-dd" />
                                                            </div>

                                                        </td>

                                                        <td>
                                                            <input type="text"
                                                                onkeyup="this.value = this.value.toUpperCase();"
                                                                class="form-control itemDesc"
                                                                data-id="{{ $tableRow }}"
                                                                id="itemDesc{{ $tableRow }}" name="particulars[]"
                                                                required maxlength="100"
                                                                value="{{ $rowresult->particulars }}">
                                                        </td>



                                                        <td>
                                                            <select class="form-control" name="brand_id[]" id="brand_id"
                                                                required>
                                                                <option value="">-Please Select Concept-</option>
                                                                @foreach ($Brands as $data)
                                                                    @if ($rowresult->brand_id == $data->id)
                                                                        <option selected value="{{ $data->id }}">
                                                                            {{ $data->brand_name }}</option>
                                                                    @else
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->brand_name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td>

                                                            <select class="form-control" name="location_id[]"
                                                                id="location_id" required>
                                                                <option value="">- Select Location -</option>
                                                                @foreach ($Location as $data)
                                                                    @if ($rowresult->location_id == $data->id)
                                                                        <option value="{{ $data->id }}" selected>
                                                                            {{ $data->store_name }}</option>
                                                                    @else
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->store_name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>

                                                        </td>

                                                        <td>
                                                            <select class="form-control drop"
                                                                data-id="{{ $tableRow }}" name="category_id[]"
                                                                id="category_id" required>
                                                                <option value="">-Please Select Category-</option>
                                                                @foreach ($Categories as $data)
                                                                    @if ($rowresult->category_id == $data->id)
                                                                        <option selected value="{{ $data->id }}">
                                                                            {{ $data->category_name }}</option>
                                                                    @else
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->category_name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="hidden" class="form-control" name="item_id[]"
                                                                required value="{{ $rowresult->id }}">
                                                            <input type="hidden" class="form-control"
                                                                name="item_action[]" id="item_action{{ $rowresult->id }}"
                                                                required value="EDIT">

                                                            <select class="form-control account{{ $tableRow }}"
                                                                name="account_id[]" id="account_id" required>
                                                                <option value="">-Please Select Account-</option>
                                                                @foreach ($Accounts->where('category_id', $rowresult->category_id) as $data)
                                                                    @if ($rowresult->account_id == $data->id)
                                                                        <option selected value="{{ $data->id }}">
                                                                            {{ $data->account_name }}</option>
                                                                    @else
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->account_name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>



                                                        <td>
                                                            <select class="form-control" name="currency_id[]"
                                                                id="currency_id" required>
                                                                <option value="">- Currency -</option>
                                                                @foreach ($Currencies as $data)
                                                                    @if ($rowresult->currency_id == $data->id)
                                                                        <option selected value="{{ $data->id }}">
                                                                            {{ $data->currency_name }}</option>
                                                                    @else
                                                                        <option value="{{ $data->id }}">
                                                                            {{ $data->currency_name }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </td>

                                                        <td>
                                                            <input type="number"
                                                                class="form-control quantity text-center"
                                                                data-id="{{ $tableRow }}"
                                                                id="quantity{{ $tableRow }}" step="any"
                                                                name="quantity[]" min="0" required maxlength="100"
                                                                value="{{ $rowresult->quantity }}">
                                                        </td>

                                                        <td>
                                                            <input type="number" class="form-control vvalue text-center"
                                                                data-id="{{ $tableRow }}"
                                                                id="value{{ $tableRow }}" name="line_value[]"
                                                                step="0.01" min="0"
                                                                onchange="setTwoNumberDecimal(this)" required
                                                                maxlength="100" value="{{ $rowresult->line_value }}">
                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control totalV text-center"
                                                                id="totalValue{{ $tableRow }}" name="total_value[]"
                                                                readonly="readonly" step="0.01" required
                                                                maxlength="100" value="{{ $rowresult->total_value }}">
                                                        </td>


                                                    </tr>
                                                    @endforeach

                                                    </tr>

                                                    </tr>

                                                </tbody>

                                                <tfoot>

                                                    <tr id="tr-table1" class="bottom">

                                                        <td>
                                                            <input type="button" id="add-Row" name="add-Row"
                                                                class="btn btn-primary add" value='Add' />
                                                        </td>



                                                        <td colspan="12" align="right">
                                                            <strong>{{ trans('message.table.total_value_order_text') }}</strong>
                                                        </td>
                                                        <td align="left" colspan="1">
                                                            <input type='text' name="total_value_order"
                                                                class="form-control text-center" id="tValue2" readonly
                                                                value="{{ $Header->total_value_order }}">
                                                        </td>
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

                <div class="row">
                    <label class="control-label col-md-3">{{ trans('message.form-label.reference_number') }}:</label>
                    <div class="col-md-3">
                        <p>{{ $Header->reference_number }}</p>
                    </div>

                    <label class="control-label col-md-3">{{ trans('message.form-label.status_id') }}:</label>
                    <div class="col-md-3">
                        <b>{{ $Header->status_name }}</b>
                    </div>
                </div>

                <div class="row">
                    <label class="control-label col-md-3">{{ trans('message.form-label.created_at') }}:</label>
                    <div class="col-md-3">
                        <p>{{ $Header->requested_date }}</p>
                    </div>

                    <label class="control-label col-md-3">{{ trans('message.table.note') }}:</label>
                    <div class="col-md-3">
                        <p>{{ $Header->requestor_comments }}</p>
                    </div>
                </div>

                <div class="row">
                    <label class="control-label col-md-3">Need by Date:</label>
                    <div class="col-md-3">
                        <p>{{ $Header->need_by_date }}</p>
                    </div>
                    <label class="control-label col-md-3">{{ trans('message.table.approver_comments') }}:</label>
                    <div class="col-md-3">
                        <p>{{ $Header->approver_comments }}</p>
                    </div>
                </div>
                <hr />

                <div class="row">
                    <label class="control-label col-md-2">Transacted By</label>
                    <div class="col-md-4">
                        <p>{{ $Header->paidbylevel }}</p>
                    </div>

                    <label class="control-label col-md-2">Transacted Date:</label>
                    <div class="col-md-4">
                        <p>{{ $Header->paid_at }}</p>
                    </div>
                </div>

            </div>

            <div class='panel-footer'>
                <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>
                <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save"></i>
                    Validate</button>
            </div>
        </form>
    </div>
@endsection

@push('bottom')
    <script type="text/javascript">
        // calendar that can only select current date and 4 previous dates
        document.addEventListener('DOMContentLoaded', (event) => {
            const datePicker = document.getElementById('recordedDate');
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


        $('#customer_location_id').change(function() {

            var customer_location_id = this.value;


            $.ajax({
                url: "{{ URL::to('/customer_location_id') }}",
                type: "POST",
                data: {
                    'customer_location_id': customer_location_id,
                    _token: '{!! csrf_token() !!}'
                },
                success: function(result) {

                    var i;
                    var showData = [];

                    //showData[0] = "<option value='' selected disabled>-Please Select Account-</option>";
                    for (i = 0; i < result.length; ++i) {
                        var j = i + 1;
                        if (result[i].location_name == null || result[i].location_name == "") {
                            showData[i] = "<option value=''></option>";
                        } else {
                            showData[i] = "<option value='" + result[i].locationid + "'>" + result[i]
                                .location_name + "</option>";
                        }

                    }
                    //$('.account'+id_data).find('option').remove();
                    jQuery('#location_id').html(showData);
                }
            });

        });

        $('#requestor_name').keyup(function() {
            this.value = this.value.toLocaleUpperCase();
        });

        function preventBack() {
            window.history.forward();
        }
        window.onunload = function() {
            null;
        };
        setTimeout("preventBack()", 0);


        var tableRowtableRow = <?php echo json_encode($tableRow); ?>;
        $(document).ready(function() {


            $("#add-Row").click(function() {
                tableRowtableRow++;
                var newrow = '<tr>' +

                    '<td >' +
                    '<input type="hidden"  class="form-control"  name="item_id_add[]"  required  value="' +
                    tableRowtableRow + '">' +
                    '<select class="form-control" required name="invoice_type_id_add[]" id="invoice_type_id">' +
                    '<option value="">- Invoice Type -</option>' +
                    '@foreach ($InvoiceType as $data)' +
                    '<option value="{{ $data->id }}">{{ $data->invoice_type_name }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</td>' +

                    '<td>' +
                    '<select class="form-control" required name="vat_type_id_add[]" id="vat_type_id">' +
                    '<option value="">- VAT Type -</option>' +
                    '@foreach ($VatType as $data)' +
                    '<option value="{{ $data->id }}">{{ $data->vat_type_name }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '</td>' +

                    '<td>' +
                    '<select class="form-control" required name="payment_status_id_add[]" id="payment_status_id">' +
                    '<option value="">- Payment Status -</option>' +
                    '@foreach ($PaymentStatus as $data)' +
                    '<option value="{{ $data->id }}">{{ $data->payment_status_name }}</option>' +
                    '@endforeach' +
                    '</select>' +
                    '<input type="hidden" class="form-control quantityNew text-center"  id="product_id" step="any" name="product_id_add[]" min="0" required maxlength="100" value="000">' +
                    '</td>' +

                    '<td >' +
                    '<input type="text" class="form-control"  id="si_or_number" name="si_or_number_add[]"  required >' +
                    '</td>' +

                    '<td >' +
                    '<div class="input-group date">' +
                    '<div class="input-group-addon"><i class="fa fa-calendar"></i></div>' +
                    '<input type="input" name="si_or_date_add[]" id="datepicker' + tableRowtableRow +
                    '" onkeydown="return false" required  autocomplete="off"  class="form-control dateset" placeholder="yyyy-mm-dd" /> ' +
                    '</div>' +
                    '</td>' +

                    '<td>' +
                    '  <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="' +
                    tableRowtableRow + '" id="itemDesc' + tableRowtableRow +
                    '"  name="particulars_add[]"  required maxlength="100">' +
                    '</td>' +

                    '<td>' +
                    '<select class="form-control" name="brand_id_add[]" id="brand_id_add" required>' +
                    '  <option value="">-Please Select Concept-</option>' +
                    '        @foreach ($Brands as $data)' +
                    '        <option value="{{ $data->id }}">{{ $data->brand_name }}</option>' +
                    '         @endforeach' +
                    '</select>' +
                    '</td>' +

                    '<td>' +

                    '<select class="form-control" name="location_id_add[]" id="location_id" required>' +
                    '<option value="">- Select Location -</option>' +
                    '@foreach ($Location as $data)' +
                    '<option value="{{ $data->id }}">{{ $data->store_name }}</option>' +
                    '@endforeach' +
                    '</select>' +

                    '</td>' +

                    '<td>' +
                    '<select class="form-control drop' + tableRowtableRow +
                    '" name="category_id_add[]" data-id="' + tableRowtableRow +
                    '"  id="category_id" required>' +
                    '  <option value="">-Please Select Category-</option>' +
                    '        @foreach ($Categories as $data)' +
                    '        <option value="{{ $data->id }}">{{ $data->category_name }}</option>' +
                    '         @endforeach' +
                    '</select>' +
                    '</td>' +

                    '<td>' +
                    '<input type="hidden"  class="form-control"  name="add_items"  required  value="0">' +
                    '<input type="hidden"  class="form-control"  name="item_action_add[]" id="item_action' +
                    tableRowtableRow + '"  required  value="ADD">' +

                    '<select class="form-control account' + tableRowtableRow +
                    '" name="account_id_add[]" id="account_id_add" required>' +

                    '</select>' +
                    '</td>' +

                    '<td>' +
                    '<select class="form-control" name="currency_id_add[]" id="currency_id_add" required>' +
                    '  <option value="">-Please Select Currency-</option>' +
                    '        @foreach ($Currencies as $data)' +
                    '        <option value="{{ $data->id }}">{{ $data->currency_name }}</option>' +
                    '         @endforeach' +
                    '</select>' +
                    '</td>' +



                    '<td>' +
                    '  <input type="number" class="form-control quantity text-center" data-id="' +
                    tableRowtableRow + '" id="quantity' + tableRowtableRow +
                    '" step="any" name="quantity_add[]" min="0" required maxlength="100">' +
                    '</td>' +
                    '<td>' +
                    '  <input type="number" class="form-control vvalue text-center" data-id="' +
                    tableRowtableRow + '" id="value' + tableRowtableRow +
                    '" name="line_value_add[]" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" required maxlength="100">' +
                    '</td>' +
                    '<td>' +
                    '  <input type="text" class="form-control totalV text-center" id="totalValue' +
                    tableRowtableRow +
                    '" name="total_value_add[]" readonly="readonly" step="0.01" required maxlength="100">' +
                    '</td>' +
                    '<td>' +


                    '<button id="deleteRow" name="removeRow1" class="btn btn-danger removeRow1" data-id="' +
                    tableRowtableRow + '" ><i class="glyphicon glyphicon-trash"></i></button>' +
                    '</td>' +
                    '</tr>';
                $(newrow).insertBefore($('table tr#tr-table1:last'));

                $("#datepicker" + tableRowtableRow).datepicker({
                    maxDate: 0,
                    dateFormat: 'yy-mm-dd'
                });


                $('.account' + tableRowtableRow).prop("disabled", true);

                $('.drop' + tableRowtableRow).change(function() {

                    var category = this.value;
                    var id_data = $(this).attr("data-id");

                    $('.account' + id_data).prop("disabled", false);

                    $.ajax({
                        url: "{{ URL::to('/category') }}",
                        type: "POST",
                        data: {
                            'category': category,
                            _token: '{!! csrf_token() !!}'
                        },
                        success: function(result) {
                            var i;
                            var showData = [];

                            showData[0] =
                                "<option value='' selected disabled>-Please Select Account-</option>";
                            for (i = 1; i < result.length; ++i) {
                                var j = i + 1;
                                showData[i] = "<option value='" + result[i].id + "'>" +
                                    result[i].account_name + "</option>";
                            }
                            //$('.account'+id_data).find('option').remove();
                            jQuery('.account' + id_data).html(showData);
                        }
                    });

                });
            });
            //deleteRow
            $(document).on('click', '.removeRow', function() {

                var RowID = $(this).attr("data-id");

                //alert($('#item_action'+RowID).val());

                if ($('#item_action' + RowID).val() == "EDIT") {

                    var token = $("#token").val();



                    $.ajax({
                        type: "POST",
                        url: "{{ route('delete-petty-cash-request') }}",
                        dataType: "JSON",
                        data: {
                            "_token": token,
                            "row_id": RowID,

                        },
                        success: function(data) {
                            //alert(data);
                        },
                        error: function(xhr, status, error) {
                            //alert(error);
                        }
                    });
                }

                if ($('#requestTable tbody tr').length !=
                    1) { //check if not the first row then delete the other rows

                    $(this).closest('tr').remove();
                    $("#tQuantity").val(calculateTotalQuantity());
                    $("#tValue2").val(calculateTotalValue2());
                    return false;
                }


            });



            $(document).on('click', '.removeRow1', function() {

                var RowID = $(this).attr("data-id");

                //alert($('#item_action'+RowID).val());


                if ($('#requestTable tbody tr').length !=
                    1) { //check if not the first row then delete the other rows

                    $(this).closest('tr').remove();
                    $("#tQuantity").val(calculateTotalQuantity());
                    $("#tValue2").val(calculateTotalValue2());
                    return false;
                }


            });

        });

        function setTwoNumberDecimal(el) {
            el.value = parseFloat(el.value).toFixed(2);

        };

        $(document).on('keyup', '.quantity', function(ev) {

            var id = $(this).attr("data-id");
            var rate = parseFloat($(this).val());
            var qty = $("#value" + id).val();



            var price = calculatePrice(rate, qty).toFixed(2); // this is for total Value in row

            $("#totalValue" + id).val(price);
            $("#tQuantity").val(calculateTotalQuantity());
            $("#tValue").val(calculateTotalValue());
            $("#tValue2").val(calculateTotalValue2());


        });

        $(document).on('keyup', '.vvalue', function(ev) {

            var id = $(this).attr("data-id");
            var rate = parseFloat($(this).val());
            var qty = $("#quantity" + id).val();
            var price = calculatePrice(qty, rate).toFixed(2); // this is for total Value in row

            $("#totalValue" + id).val(price);
            $("#tQuantity").val(calculateTotalQuantity());
            $("#tValue").val(calculateTotalValue());
            $("#tValue2").val(calculateTotalValue2());
        });


        function calculateTotalValue2() {
            var totalQuantity = 0;
            var newTotal = 0;
            $('.totalV').each(function() {
                totalQuantity += parseFloat($(this).val());

            });
            newTotal = totalQuantity.toFixed(2);
            return newTotal;
        }

        function calculateTotalQuantity() {
            var totalQuantity = 0;
            $('.quantity').each(function() {
                totalQuantity += parseFloat($(this).val());
            });
            return totalQuantity;
        }

        function calculateTotalValue() {
            var totalQuantity = 0;
            $('.value').each(function() {
                totalQuantity += parseFloat($(this).val().toFixed(2));
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

        var sub_departmentID = <?php echo json_encode($sub_departmentID); ?>;

        $(document).ready(function() {
            $("#PettyCashForm").submit(function() {
                $("#btnSubmit").attr("disabled", true);
                return true;
            });

            var department = $('#department_id').val();


            //var id_data = $(this).attr("data-id");

            // $('.account'+id_data).prop("disabled", false);



            $.ajax({
                url: "{{ URL::to('/subdepartment') }}",
                type: "POST",
                data: {
                    'department': department,
                    _token: '{!! csrf_token() !!}'
                },



                success: function(result) {



                    var i;
                    var showData = [];

                    for (i = 0; i < result.length; ++i) {
                        var j = i + 1;

                        if (sub_departmentID == result[i].id) {

                            showData[i] = "<option value='" + result[i].id + "' selected>" + result[i]
                                .sub_department_name + "</option>";

                        } else {

                            showData[i] = "<option value='" + result[i].id + "'>" + result[i]
                                .sub_department_name + "</option>";

                        }

                    }
                    //$('.account'+id_data).find('option').remove();
                    //jQuery('.account'+id_data).html(showData);          

                    jQuery('#sub_department_id').html(showData);
                }


            });

        });


        $('#department_id').change(function() {

            var department = $('#department_id').val();


            //var id_data = $(this).attr("data-id");

            // $('.account'+id_data).prop("disabled", false);



            $.ajax({
                url: "{{ URL::to('/subdepartment') }}",
                type: "POST",
                data: {
                    'department': department,
                    _token: '{!! csrf_token() !!}'
                },



                success: function(result) {



                    var i;
                    var showData = [];

                    for (i = 0; i < result.length; ++i) {
                        var j = i + 1;
                        showData[i] = "<option value='" + result[i].id + "'>" + result[i]
                            .sub_department_name + "</option>";
                    }
                    //$('.account'+id_data).find('option').remove();
                    //jQuery('.account'+id_data).html(showData);          

                    jQuery('#sub_department_id').html(showData);
                }


            });

        });


        $("#btnSubmit").click(function(event) {

            var countRow = $('#requestTable tr').length - 4;
            // var value = $('.vvalue').val();

            if (countRow == 0) {
                alert("Please add an item!");
                event.preventDefault(); // cancel default behavior
            }

            var qty = 0;
            $('.quantity').each(function() {
                qty = $(this).val();
                if (qty == 0) {
                    alert("Quantity cannot be empty or zero!");
                    event.preventDefault(); // cancel default behavior
                } else if (qty < 0) {
                    alert("Negative Value is not allowed!");
                    event.preventDefault(); // cancel default behavior
                }
            });

            var lineval = 0;
            $('.vvalue').each(function() {
                lineval = $(this).val();
                if (lineval < 0) {
                    alert("Negative Value is not allowed!");
                    event.preventDefault(); // cancel default behavior
                }
            });

            if ($("#tValue2").val() > 1000) {
                alert("Below 1000 total value is valid !!");
                event.preventDefault();
            }

        });



        $('.drop').change(function() {

            var category = this.value;
            var id_data = $(this).attr("data-id");

            $('.account' + id_data).prop("disabled", false);



            $.ajax({
                url: "{{ URL::to('/category') }}",
                type: "POST",
                data: {
                    'category': category,
                    _token: '{!! csrf_token() !!}'
                },
                success: function(result) {
                    var i;
                    var showData = [];

                    showData[0] = "<option value='' selected disabled>-Please Select Account-</option>";
                    for (i = 1; i < result.length; ++i) {
                        var j = i + 1;
                        showData[i] = "<option value='" + result[i].id + "'>" + result[i].account_name +
                            "</option>";
                    }
                    //$('.account'+id_data).find('option').remove();
                    jQuery('.account' + id_data).html(showData);
                }
            });

        });

        $("#datepicker").datepicker({
            maxDate: 0,
            dateFormat: 'yy-mm-dd'
        });


        // $("#datepicker1").datepicker({
        //     maxDate: 0,
        //     dateFormat: 'yy-mm-dd'
        // });



        for (let i = 1; i < tableRowtableRow + 1; i++) {

            $("#datepicker" + i).datepicker({
                maxDate: 0,
                dateFormat: 'yy-mm-dd'
            });

        }
    </script>
@endpush
