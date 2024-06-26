@extends('crudbooster::admin_template')
@push('head')
    <style type="text/css">
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

        #image_preview {
            display: none;
        }

        #galeria {
            display: flex;
        }

        #galeria img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
            opacity: 85%;
        }

        /* Select2 */
        .select2 {
            height: 35px;
            border: 1px solid #aaa;
        }

        /* End of Select2 */

        .input-group-addon {
            border: 1px solid #aaa !important;
        }

        /* Required */
        .required {
            color: red;
        }

        /* End of Required */

        input,
        textarea {
            border: 1px solid #aaa !important;
        }

        textarea:focus {
            border: 1px solid black !important;
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
        <form action="{{ CRUDBooster::mainpath('add-save') }}" method="POST" id="PettyCashForm"
            enctype="multipart/form-data">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
            <div class='panel-body'>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.department_id') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                <select class="form-control select2" required name="department_id" id="department_id">
                                    <!--<option value="">-- Select Department --</option>-->
                                    @foreach ($Departments as $data)
                                        <option value="{{ $data->id }}">{{ $data->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label
                                class="control-label require">*{{ trans('message.form-label.sub_department_id') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                <select class="form-control select2" required name="sub_department_id"
                                    id="sub_department_id">
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.requestor_name') }}</label>
                            <input type="text" class="form-control" id="requestor_name" name="requestor_name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label
                                class="control-label require">*{{ trans('message.form-label.mode_of_payment_id') }}</label>
                            <select class="form-control select2" required name="mode_of_payment_id" id="mode_of_payment_id">
                                <option value="">-- Select Mode Of Payment --</option>
                                @foreach ($ModeOfPayments as $data)
                                    <option value="{{ $data->id }}">{{ $data->mode_of_payment_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row hide" id="mop-check-payment">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.payee_name') }}</label>
                            <input type="text" class="form-control mop-input" id="payee_name" name="payee_name">
                        </div>
                    </div>
                </div>

                <div class="row hide" id="mop-cc">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*Payee Name:</label>
                            <input type="text" class="form-control mop-input" id="cc_payee_name" name="cc_payee_name">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*Last 4 digits of card</label>
                            <input type="text" class="form-control mop-input" id="cc_credit_card" name="cc_credit_card">
                        </div>
                    </div>
                </div>

                <div class="hide" id="mop-direct-deposit">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.bank_name') }}</label>
                                <input type="text" class="form-control mop-input" id="bank_name" name="bank_name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label
                                    class="control-label require">*{{ trans('message.form-label.bank_branch_name') }}</label>
                                <input type="text" class="form-control mop-input" id="bank_branch_name"
                                    name="bank_branch_name">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label
                                    class="control-label require">*{{ trans('message.form-label.bank_account_name') }}</label>
                                <input type="text" class="form-control mop-input" id="bank_account_name"
                                    name="bank_account_name">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label
                                    class="control-label require">*{{ trans('message.form-label.bank_account_number') }}</label>
                                <input type="text" class="form-control mop-input" id="bank_account_number"
                                    name="bank_account_number">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row hide" id="mop-gcash">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.gcash_number') }}</label>
                            <input type="text" class="form-control mop-input" id="gcash_number" name="gcash_number">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*Need By Date</label>
                            <input type="date" class="form-control" id="need_by_date" name="need_by_date" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p style="color:red; font-weight: bold;">*IF PDF, LIMIT TO 1 FILE.</p>
                        <p style="color:red; font-weight: bold;">*IF PNG/JPEG, UNLIMITED NUMBER OF FILES.</p>
                        <div class="" style="margin-top: 15px;">
                            <label class="control-label require">*{{ trans('message.form-label.receipt') }}</label>
                            <div class="date">
                                <input type="file" name="receipt[]" id="image" class="form-control image"
                                    required accept="application/pdf,image/*" onchange="previewMultiple(event)" multiple>
                                <div style="margin: 1rem 0;">
                                    <div id="pdf"><img src="{{ asset('vendor/crudbooster/pdf.png') }}"
                                            style="width:100px;height:100px;"></div>
                                    <div id="galeria"
                                        style="width: 100%; overflow: auto; overflow-y: hidden; margin: 0 auto; white-space: nowrap">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />
                <div class="row">

                    <div class="col-md-12">

                        <p style="color:red;">Please limit request to 100 lines.</p>

                        <div class="box-header text-center">
                            <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                        </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive">
                                <div class="container-fluid">
                                    <div class="hack1" style=" display: table; table-layout: fixed; width: 100%;">
                                        <div class="hack2" style=" display: table-cell; overflow-x: auto;">
                                            <table class="table" id="requestTable"
                                                style=" background-color: rgb(255, 250, 250); width: 100%;
                                    border-collapse: collapse; box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;">
                                                <tbody id="bodyTable">

                                                    <tr class="tbl_header_color dynamicRows" style="font-size: 15px;">
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.particulars_text') }}</th>
                                                        <th width="10%" class="text-center">
                                                            {{ trans('message.table.concept_id_text') }}</th>

                                                        <th width="12%" class="text-center">
                                                            {{ trans('message.table.location_id_text') }}</th>

                                                        <th width="12%" class="text-center">
                                                            {{ trans('message.table.category_id_text') }}</th>
                                                        <th width="15%" class="text-center">
                                                            {{ trans('message.table.account_id_text') }}</th>
                                                        <th width="11.5%" class="text-center">
                                                            {{ trans('message.table.currency_id_text') }}</th>
                                                        <th width="7%" class="text-center">
                                                            {{ trans('message.table.quantity_text') }}</th>
                                                        <th width="7%" class="text-center">
                                                            {{ trans('message.table.line_value_text') }}</th>
                                                        <th width="7%" class="text-center">
                                                            {{ trans('message.table.total_value_text') }}</th>
                                                        {{-- <th width="" class="text-center">{{ trans('message.table.action') }}</th> --}}
                                                    </tr>

                                                    <tr id="tr-table">
                                                    <tr>

                                                    </tr>
                                                    </tr>

                                                </tbody>

                                                <tfoot>

                                                    <tr id="tr-table1" class="bottom">

                                                        <td>
                                                            <input type="button" id="add-Row" name="add-Row"
                                                                class="btn btn-primary add" value='Add Row' />
                                                        </td>

                                                        <td colspan="6" align="right"
                                                            style="vertical-align: middle;">
                                                            <strong>{{ trans('message.table.total_value_order_text') }}</strong>
                                                        </td>
                                                        <td align="left" colspan="1">
                                                            <input type='number' name="total_value_order"
                                                                class="form-control text-center" id="tValue2" readonly>
                                                        </td>
                                                        </td>
                                                        <td colspan="1"></td>
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

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>{{ trans('message.table.note') }}</label>
                            <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" class="form-control"
                                name="requestor_comments"></textarea>
                        </div>
                    </div>

                </div>

            </div>

            <div class='panel-footer'>
                <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>
                <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save"></i>
                    {{ trans('message.form.save') }}</button>
            </div>
        </form>
    </div>
@endsection

@push('bottom')
    <script type="text/javascript">
        $('#pdf').hide();

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

        $('#bank_details_1, #bank_details_2').hide();

        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').removeAttr('required');

        $('#gcash_div').hide();

        $('#gcash_number').removeAttr('required');

        $('#check_payment_div').hide();

        $('#payee_name').removeAttr('required');

        $('#credit_card_div').hide();

        $('#requestor_name, #bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').keyup(function() {
            this.value = this.value.toLocaleUpperCase();
        });

        $('#mode_of_payment_id').change(function() {

            if ($(this).val() == 1) {
                resetMop();
                $('#mop-gcash').removeClass('hide');
                $('#mop-gcash').find('input').attr('required', true);
            } else if ($(this).val() == 2) {
                resetMop();
                $('#mop-direct-deposit').removeClass('hide');
                $('#mop-direct-deposit').find('input').attr('required', true);
            } else if ($(this).val() == 3) {
                resetMop();
                $('#mop-check-payment').removeClass('hide');
                $('#mop-check-payment').find('input').attr('required', true);
            } else if ($(this).val() == 7 || $(this).val() == 8) {
                resetMop();
                $('#mop-cc').removeClass('hide');
                $('#mop-cc').find('input').attr('required', true);
            } else {
                resetMop();
            }

        });

        function preventBack() {
            window.history.forward();
        }
        window.onunload = function() {
            null;
        };
        setTimeout("preventBack()", 0);


        var tableRow = 1;
        $(document).ready(function() {

            $("#add-Row").click(function() {
                $('#requestTable').css('box-shadow', 'none');
                tableRow++;
                var newrow =
                    '<tr style="box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;">' +
                    '<td >' +
                    '  <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="' +
                    tableRow + '" id="itemDesc' + tableRow +
                    '"  name="particulars[]"  required maxlength="100" style="border-radius: 5px;">' +
                    '</td>' +
                    '<td>' +
                    '<select class="form-control" name="brand_id[]" id="brand_id" required>' +
                    '  <option value="">- Select Brand -</option>' +
                    '        @foreach ($Brands as $data)' +
                    '        <option value="{{ $data->id }}">{{ $data->brand_name }}</option>' +
                    '         @endforeach' +
                    '</select></td>' +

                    '<td>' +
                    '<select class="form-control" name="location_id[]" id="location_id" required>' +
                    '  <option value="">- Select Location -</option>' +
                    '        @foreach ($Location as $data)' +
                    '        <option value="{{ $data->id }}">{{ $data->store_name }}</option>' +
                    '         @endforeach' +
                    '</select></td>' +

                    '<td>' +
                    '<select class="form-control drop' + tableRow + '" name="category_id[]" data-id="' +
                    tableRow + '" id="category_id" required>' +
                    '  <option value="">- Select Category -</option>' +
                    '        @foreach ($Categories as $data)' +
                    '        <option value="{{ $data->id }}">{{ $data->category_name }}</option>' +
                    '         @endforeach' +
                    '</select></td>' +
                    '<td>' +
                    '<select class="form-control account' + tableRow +
                    '" name="account_id[]" id="account_id" required>' +

                    '</select></td>' +
                    '<td>' +
                    '<select class="form-control" name="currency_id[]" id="currency_id" required>' +
                    '  <option value="">- Select Currency -</option>' +
                    '        @foreach ($Currencies as $data)' +
                    '        <option value="{{ $data->id }}">{{ $data->currency_name }}</option>' +
                    '         @endforeach' +
                    '</select></td>' +
                    '<td>' +
                    '  <input type="number" class="form-control quantity text-center" data-id="' +
                    tableRow + '" id="quantity' + tableRow +
                    '" step="any" name="quantity[]" min="0" required maxlength="100" style="border-radius: 5px;">' +
                    '</td>' +
                    '<td>' +
                    '  <input type="number" class="form-control vvalue text-center" data-id="' + tableRow +
                    '" id="value' + tableRow +
                    '" name="line_value[]" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" required maxlength="100" style="border-radius: 5px;">' +
                    '</td>' +
                    '<td>' +
                    '  <input type="text" class="form-control totalV text-center" id="totalValue' +
                    tableRow +
                    '" name="total_value[]" readonly="readonly" step="0.01" required maxlength="100" style="border-radius: 5px;">' +
                    '</td>' +
                    '<td>' +
                    '<button id="deleteRow" name="removeRow" class="btn btn-danger removeRow"><i class="glyphicon glyphicon-trash"></i></button>' +
                    '</td>' +
                    '</tr>';
                $(newrow).insertBefore($('table tr#tr-table1:last'));

                $('.account' + tableRow).prop("disabled", true);

                $('.drop' + tableRow).change(function() {

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
                                "<option value='' selected disabled>- Select Account-</option>";
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

            /*
            var total_checker = $("#tValue2").val();

            if(total_checker > 1000){

                alert("Maximum value reached:1000 !!");

                $('#value' + id).val('0');

                $('#totalValue'+id).val('0');



                $("#tValue2").val(calculateTotalValue2());


            }
            */
        });

        $(document).on('keyup', '.vvalue', function(ev) {

            /*    
            var price_checker = $('#value' + id).val();

            if(price_checker > 1000){

                alert("Maximum value reached:1000 !!");

                $('#value' + id).val('0');
            }
            */
            var id = $(this).attr("data-id");
            var rate = parseFloat($(this).val());
            var qty = $("#quantity" + id).val();
            var price = calculatePrice(qty, rate).toFixed(2); // this is for total Value in row

            $("#totalValue" + id).val(price);
            $("#tQuantity").val(calculateTotalQuantity());
            $("#tValue").val(calculateTotalValue());
            $("#tValue2").val(calculateTotalValue2());

            var total_checker = $("#tValue2").val();

            /*
            if(total_checker > 1000){

                alert("Maximum value reached:1000 !!");

                $('#value' + id).val('0');

                $('#totalValue'+id).val('0');



                $("#tValue2").val(calculateTotalValue2());


            }
            */

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

                        showData[i] = "<option value='" + result[i].id + "'>" + result[i]
                            .sub_department_name + "</option>";
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

            var countRow = $('#requestTable tfoot tr').length;
            // var value = $('.vvalue').val();
            if (countRow == 1) {
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


            $('.valcurrency').each(function() {
                linecurrency = $(this).val();
                if (linecurrency == 1) {
                    if ($("#tValue2").val() < 1000) {
                        //alert("Below 1000 total value is valid !!");
                        alert("Payment Request should not be less than P1,000.00 in value!");
                        event.preventDefault();
                    }
                }
            });

        });


        /*
        jQuery( document ).delegate('#image', 'change', function() {
            ext = jQuery(this).val().split('.').pop().toLowerCase();
            if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg', 'pdf']) == -1) {
                resetFormElement(jQuery(this));
                window.alert('Not an image!');
            } else {
                var reader = new FileReader();
                var image_holder = jQuery("#"+jQuery(this).attr('class')+"-preview");
                image_holder.empty();

                reader.onload = function (e) {
                    jQuery(image_holder).attr('src', e.target.result);
                }

                reader.readAsDataURL((this).files[0]);
                jQuery('#image_preview').slideDown();
                jQuery(this).slideUp();
            }
        });

        jQuery('#image_preview a').bind('click', function () {
            resetFormElement(jQuery('#image')   );
            jQuery('#image').slideDown();
            jQuery(this).parent().slideUp();
            return false;
        });*/

        function resetFormElement(e) {
            e.wrap('<form>').closest('form').get(0).reset();
            e.unwrap();
        }



        function previewMultiple(event) {
            var saida = document.getElementById("image");
            var quantos = saida.files.length;



            // alert($('#image').val());

            if ($('#image').val().includes(".pdf")) {

                $('#pdf').show();

            } else {

                $('#pdf').hide();

                for (i = 0; i < quantos; i++) {
                    var urls = URL.createObjectURL(event.target.files[i]);
                    document.getElementById("galeria").innerHTML += '<img src="' + urls + '">';
                }

            }

        }

        function resetMop() {
            $('[id^="mop-"]').find('input').attr('required', false);
            $('[id^="mop-"]').find('input').val('');
            $('[id^="mop-"]').addClass('hide');
        }
    </script>
@endpush
