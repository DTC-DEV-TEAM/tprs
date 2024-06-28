<!-- First, extends to the CRUDBooster Layout -->
@push('head')
    {{-- Jquery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    {{-- Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .request_content {
            width: 100%;
        }

        .by_department {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        .request_department {
            margin-bottom: 10px;
            margin-right: 30px;
            width: 31.9%;
        }

        .request_department:last-child {
            margin-right: 0;
        }

        .required {
            color: red;
        }

        .request_information_contents {
            margin-bottom: 10px;
            margin-right: 30px;
            width: 31.4%;
        }

        .flex {
            display: flex;
        }

        .requestor_name {
            width: 35%;
            margin-bottom: 10px;
        }

        .requestor_name label {
            display: block;
            font-size: 15px;
        }

        .requestor_name input {
            width: 100%;
            height: 35px;
            border: 1px solid #aaa;
            border-radius: 5px;
            text-align: center;
        }

        /* Select2 */
        .select2-container--default .select2-selection--single {
            height: 35px;
            text-align: center;
            border-radius: 0;
        }

        /* End of Select2 */

        .additional_notes {
            width: 100%;
        }

        .additional_notes label {
            display: block;
            font-size: 15px;
        }

        .additional_notes textarea {
            width: 100%;
            height: 100px;
            padding: 10px 15px;
            font-size: 15px;
        }

        .request_note {
            margin-left: 25px;
            margin-bottom: 10px;
        }

        .budget_info {
            text-align: center;
            width: 100%;
            font-weight: bold;
            font-size: 20px;
        }

        .budget_block {
            width: 100%;
            position: relative;
        }

        .budget {
            position: relative;
            display: flex;
            height: 100%;
            box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
            margin-top: 20px;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease-in-out;
            overflow-x: auto;
            border-radius: 5px;
        }

        .budget:hover {
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);

        }

        .circ_delete {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 25px;
            color: rgba(60, 64, 67, 1);
            margin-top: -16px;
            margin-right: -10px;
            z-index: 10;
            border-radius: 50%;
            background-color: rgb(174, 176, 177);
            height: 30px;
            width: 30px;
            display: grid;
            place-items: center;
        }

        .circ_delete:hover {
            opacity: 0.7;
            cursor: pointer;
        }

        .budget::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        .budget::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .budget::-webkit-scrollbar-thumb {
            background: #888;
        }

        .budget::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .budget_description {
            /* width: 100%; */
            margin: 15px 4px;
            height: 100%;
            align-items: center;
        }

        .budget_description label {
            display: block;
            text-align: center;
            font-size: 15px;
        }

        .budget_description input {
            height: 35px;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #aaa;
            outline-color: #007bff;
        }

        .input_description {
            width: 100%;
            padding: 5px;
        }

        .add_row {
            /* padding: 8px 45px; */
            width: 100px;
            height: 35px;
            background-color: rgb(32, 120, 208);
            color: white;
            border-radius: 5px;
            border: none;
        }

        .add_row_receipt {
            width: 100px;
            height: 35px;
            background-color: rgb(32, 120, 208);
            color: white;
            border-radius: 5px;
            border: none;
        }

        .delete_row {
            width: 100px;
            height: 35px;
            background-color: rgb(226, 71, 71);
            color: white;
            border-radius: 5px;
            border: none;
        }

        .add_row:hover,
        .delete_row:hover {
            opacity: 0.8;
        }

        .total_amount_content {
            margin-bottom: 10px;
        }

        .total_amount_content label {
            font-size: 15px;
            margin-right: 10px;
            width: 155px;
        }

        .total_amount_content input {
            height: 35px;
            border-radius: 5px;
            outline: none;
            border: 1px solid #aaa;
            text-align: center;
            margin-right: 10px;
            width: 150px;
        }

        /* AP Recording */
        .ap_recording {
            display: flex;
            width: 100%;
        }

        .ap_recording_content {
            min-width: 31.9%;
            margin-right: 30px;
        }

        /* End of AP Recording */

        /* Request Information */
        .request_information {
            display: flex;
        }

        .request_information label {
            font-size: 15px;
            margin-right: 10px;
            width: 150px;
        }

        .request_information span {
            font-size: 15px;
            margin-right: 10px;
            width: 150px;
        }

        /* End of Request Information  */

        .start {
            margin-top: 20px;
        }

        .r_full_name label {
            display: block;
        }

        #req_full_name {
            width: 100%;
            height: 35px;
            text-align: center;
            background-color: #eee;
            border: 1px solid #aaa;
            border-radius: 5px;
        }


        #budget_image:hover {
            /* opacity: 0.9; */
            box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
        }

        /* image display center */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
        }

        .modal-content {
            display: flex;
            justify-content: center;
            max-width: 600px;
            max-height: 600px;
            margin: auto;
            position: absolute;
            left: 0;
            right: 0;
            top: 53%;
            transform: translateY(-50%);
            background: transparent;
            box-shadow: none !important;
        }

        .modal-content img {
            display: block;
            max-width: 600px;
            max-height: 600px;
        }

        .modal-trigger {
            cursor: pointer;
        }

        .swal2-popup {
            font-size: 1.5rem !important;
        }

        .swal2-popup .swal2-title {
            font-size: 2.5rem !important;
        }

        .swal2-popup .swal2-content {
            font-size: 1.8rem !important;
        }

        .swal2-popup {
            margin: auto !important;
            position: absolute !important;
            left: 0 !important;
            right: 0 !important;
            top: 10 !important;
            transform: translateY(-50%) !important;
        }

        #budget_justification {
            text-align: center;
        }

        #upload_img {
            padding-top: 5px;
            border: none;
            width: 100%;
        }

        .budget_qty,
        .budget_value,
        .budget_amount {
            width: 95px;
        }

        .upload_img_parent {
            text-align-last: center;
            margin: 0;
            padding: 0;
        }

        .requestor_name {
            width: 35%;
            margin-bottom: 10px;
        }

        .requestor_name label {
            display: block;
            font-size: 15px;
        }

        .requestor_name input {
            width: 100%;
            height: 35px;
            border: 1px solid #aaa;
            border-radius: 5px;
            text-align: center;
        }

        .mode_of_payment_ {
            width: 100%;
        }

        .mode_of_payment_dropdown {
            width: 100%;
        }

        .mode_of_payment_dropdown label {
            display: block;
            width: 150px;
        }

        #check_payment input {
            width: 100%;
            height: 35px;
            border: 1px solid #aaa;
            border-radius: 5px;
            text-align: center;
        }

        #credit_card input {
            width: 100%;
            height: 35px;
            border: 1px solid #aaa;
            border-radius: 5px;
            text-align: center;
            background-color: #eeeeee;
        }

        #gcash input {
            width: 100%;
            height: 35px;
            border: 1px solid #aaa;
            border-radius: 5px;
            text-align: center;
        }


        .direct_deposit,
        .credit_card {
            width: 50%;
        }

        .direct_deposit input,
        .credit_card input {
            width: 100%;
            height: 35px;
            border: 1px solid #aaa;
            border-radius: 5px;
            text-align: center;
        }

        .mode_of_payment_section {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
        }

        .mode_of_payment_section1 {
            width: 31.9%;
            margin-right: 30px;
        }

        .mode_of_payment_section2 {
            width: 31.9%;
        }

        /* Receipts Validation */
        .receipts_per_department {
            display: flex;
            flex-wrap: wrap;
        }

        .receipts_request_department {
            width: 365px;
            padding-right: 10px;
        }

        .receipts_comments {
            display: flex;
            flex-wrap: wrap;
        }

        .receipts_amount_contents {
            display: flex;
            flex-wrap: wrap;
        }

        .receipts_total_amount {
            width: 365px;
            padding-right: 10px;
        }

        .receipts_amount_contents:nth-child(2) input {
            background-color: #eeeeee;
        }

        /* End of Receipts Validation */

        .read_only {
            background-color: #eee;
        }

        #remaining_balance {
            color: #d32f2f;
            font-weight: bold;
        }

        /* loading_submit */
        .loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            /* add a semi-transparent background */
        }

        .loading_content {
            height: 150px;
            width: 400px;
            background-color: rgba(164, 164, 164, 0.955);
            border-radius: 5px;
            font-size: 18px;
            display: grid;
            place-items: center;
            color: rgb(255, 255, 255);
            box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px, rgba(0, 0, 0, 0.23) 0px 6px 6px;

        }

        /* select with icon */
        .select_with_icon {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .select_icon {
            padding: 9.8px 12px;
            font-size: 14px;
            color: #555;
            border: 1px solid #ccc;
        }
    </style>
@endpush

@extends('crudbooster::admin_template')


@section('content')
    <!-- Your html goes here -->
    <p class="noprint"><a title="Main Module" href="{{ CRUDBooster::mainpath() }}"><i class="fa fa-chevron-circle-left "></i>
            &nbsp; Back To List Data Pre Payment</a></p>

    {{-- Approver Privilege --}}
    @if ($row->status_id == 1)
        @include('pre_payment.layouts.for_approval')
    @endif
    {{-- End of Approver Privilege --}}

    {{-- Approver Privilege --}}
    @if ($row->status_id == 7)
        @include('pre_payment.layouts.ap_recording')
    @endif
    {{-- End of Approver Privilege --}}

    {{-- AP Supervisor Privilege --}}
    @if ($row->status_id == 10)
        @include('pre_payment.layouts.for_ap_approval')
    @endif
    {{-- End of Approver Privilege --}}

    {{-- Accounting Approval --}}
    {{-- Accounting Budget Releasing --}}
    @if ($row->status_id == 2)
        @include('pre_payment.layouts.for_budget_release')
    @endif
    {{-- End of Accounting Approval --}}

    {{-- Receipts Information Breakdown --}}
    {{-- Requestor Privilege --}}
    @if ($row->status_id == 3)
        @include('pre_payment.layouts.receipts_breakdown')
        {{-- <script>
          $('body').addClass('sidebar-collapse');
      </script> --}}
    @endif
    {{-- End of Receipts Information Breakdown --}}

    {{-- For Transmittal --}}
    @if ($row->status_id == 8)
        @include('pre_payment.layouts.for_transmittal')
    @endif
    {{-- End of For Transmittal --}}

    {{-- Accounting Validating Budget Information --}}
    @if ($row->status_id == 4)
        @include('pre_payment.layouts.accounting_receipts_validation')
    @endif
    {{-- End of Accounting Validation Budget Information --}}

    <script>
        //calendar that can only select current date and 4 previous dates
        document.addEventListener('DOMContentLoaded', (event) => {
            const datePicker = document.getElementById('received_transmittal_date');
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

        // calendar with no previous date
        document.addEventListener('DOMContentLoaded', (event) => {
            console.log("DOM fully loaded and parsed");

            const setDatePickerMinDate = (elementId) => {
                const datePicker = document.getElementById(elementId);

                if (!datePicker) {
                    return;
                }

                const today = new Date();
                const todayStr = today.toISOString().split('T')[0];

                // Set the min date to today
                datePicker.setAttribute('min', todayStr);
            };

            setDatePickerMinDate('dateRecorded');
            setDatePickerMinDate('transmittalDate');
            setDatePickerMinDate('dateTransmitted');
        });


        // Budget Information Breakdown Computation
        function get_all_sum() {
            let total = 0;
            let remaining_balance = 0;

            $('.budget_amount:not(:eq(1))').each(function() {
                total += parseFloat($(this).val() || 0);
            });

            $('.budget_amount').each(function() {
                remaining_balance += parseFloat($(this).val() || 0);
            })

            const requested_amount = $('#requested_amount').val();
            const to_be_returned = requested_amount - remaining_balance;
            const cash_in_bank_total_value = $('#cash_in_bank_total_value').val();

            $('#total_amount').val(Math.abs(total));
            $('#remaining_balance').val(to_be_returned);
            $('#unused_amount').val(cash_in_bank_total_value);

            if (to_be_returned == 0) {
                $('#remaining_balance').css('color', 'green');
                $('#submit_approve').click(function() {
                    $(this).parents('form').submit(function() {
                        $('.brand').removeAttr('disabled');
                        $('.location').removeAttr('disabled');
                        $('.category').removeAttr('disabled');
                        $('.account').removeAttr('disabled');
                        $('.typewriter').show();
                    });
                })
                $('#submit_approve').attr('disabled', false);
                $('#submit_approve').removeAttr('title');
            } else {
                $('#remaining_balance').css('color', '#d32f2f');
                $('#submit_approve').attr('title', 'Please ensure that the remaining balance is zero before proceeding.');
                $('#submit_approve').attr('disabled', true);
            }

        }

        $(document).on('keyup', '.budget_amount', function() {
            get_all_sum();
        });

        get_all_sum();
        // End of Budget Information Breakdown

        // Name first letter uppercase
        $('#req_full_name').on('keyup', function() {
            var val = $(this).val().toLowerCase().replace(/\b[a-z]/g, function(letter) {
                return letter.toUpperCase();
            });
            $(this).val(val);
        });

        // Add Row
        $(document).on('click', '.add_row', function() {
            // $(this).parents().find('.delete_row').css('display', 'inline-block');
            $('.budget_content').eq(0).find('.delete_row').css('display', 'inline-block');
            let clone_budget = $('.budget_content').eq(0).clone().css('box-shadow', '').css('display', '');
            clone_budget.find('input').val('');
            // clone_budget.find('#budget_justification').remove();
            add_select2(clone_budget);
            // Get the number of existing budget justifications
            var count = $('.budget_content').length;
            // Add the current count to the name attribute of the file input
            clone_budget.find('#upload_img').attr('name', 'budget_justification' + count + '[]');

            $(this).parents('.budget_description').before(clone_budget);
            $(clone_budget).hide().fadeIn(500);
        });

        $(document).on('click', '.add_row_receipt', function() {
            $('.budget_content').eq(0).find('.delete_row').css('display', 'inline-block');
            let clone_budget = $('.budget_content').eq(0).clone().css('box-shadow', '').css('display', '');
            // clone_budget.find('input[name="budget_justification[]"]').parents().attr("disabled", 'disabled');
            add_select2(clone_budget);

            $('.budget_content').last().after(clone_budget);
        });

        // Delete Row
        $(document).on('click', '.circ_delete', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parents('.budget_content').fadeOut(500, function() {
                        $(this).remove();
                    });
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )


                }
            })

        })

        // Hover budget row
        $(document).on('click', '.budget', function() {
            $('.budget').css('box-shadow', '');
            $(this).css('box-shadow',
                'rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset'
            );
            // $(this).closest('.budget_content').find('.circ_delete').show();
            // $('.circ_delete').not($(this).closest('.budget_content').find('.circ_delete')).hide();
        });

        // Hide circ_delete element when clicking outside of budgets
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.budget').length) {
                $('.budget').css('box-shadow', '');
                // $('.circ_delete').css('display', 'none');
            }
        });
        // End of Hover budget row

        // Budget Justification
        let budget_image = $('#budget_justification').find('.budget_image');
        if (budget_image.length == 1) {
            budget_image.css('max-width', '100%');
        }

        // Select Department
        $('#req_department').select2({
            placeholder: "Select a department",
            width: '100%',
            ajax: {
                url: '{{ route('prepayment_department') }}',
                dataType: 'json',
                delay: 250,
                type: 'POST',
                data: function(params) {
                    return {
                        q: params.term,
                        _token: '{!! csrf_token() !!}'
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.department_name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            },
            id: 'id'
        });

        // Sub Department
        $('#sub_department').select2({
            placeholder: "Select sub department",
            dropdownAutoWidth: true,
            width: '100%',
            ajax: {
                url: '{{ route('prepayment_sub_department') }}',
                dataType: 'json',
                delay: 250,
                type: 'POST',
                data: function(params) {
                    return {
                        q: params.term,
                        _token: '{!! csrf_token() !!}'
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.sub_department_name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            },
            id: 'id'
        });

        // Mode Of Payment
        let mop = $('#mode_of_payment').val();
        let direct_deposit = $('#mode_of_payment_direct_deposit').find('input').val();
        let check_payment = $('#check_payment').find('input').val();
        let gcash = $('#gcash').find('input').val();

        if (direct_deposit) {
            $('#mode_of_payment_direct_deposit').show()
            $('#mode_of_payment_direct_deposit').find('input').attr('required', true);
        } else if (check_payment) {
            $('#check_payment').show();
            $('#check_payment').find('input').attr('required', true);
        } else if (gcash) {
            $('#gcash').show();
            $('#gcash').find('input').attr('required', true);
        }

        if (mop == 7 || mop == 8) {
            console.log(true)
            // clearModeOfPayment();
            $('#mode_of_payment_credit_card').show();
            $('#mode_of_payment_credit_card').find('input').attr('required', true);
        }


        // Mode Of Payment
        $('#mode_of_payment').select2({
            placeholder: "Select mode of payment",
            dropdownAutoWidth: true,
            width: '100%',
            ajax: {
                url: '{{ route('prepayment_payment') }}',
                dataType: 'json',
                delay: 250,
                type: 'POST',
                data: function(params) {
                    return {
                        q: params.term,
                        _token: '{!! csrf_token() !!}'
                    };
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.mode_of_payment_name,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            },
            id: 'id'
        }).on('change', function() {

            let mode_of_payment_val = $('#mode_of_payment').val()
            modeOfPaymentSelect(mode_of_payment_val);
        });

        function modeOfPaymentSelect(mop) {
            if (mop == 1) {
                clearModeOfPayment();
                $('#gcash').show();
                $('#gcash').find('input').attr('required', true);
            } else if (mop == 2) {
                clearModeOfPayment();
                $('#mode_of_payment_direct_deposit').show();
                $('#mode_of_payment_direct_deposit').find('input').attr('required', true);
            } else if (mop == 3) {
                clearModeOfPayment();
                $('#check_payment').show();
                $('#check_payment').find('input').attr('required', true);
            } else if (mop == 4) {
                clearModeOfPayment();
                $('#credit_card').show();
            } else if (mop == 7 || mop == 8) {
                clearModeOfPayment();
                $('#mode_of_payment_credit_card').show();
                $('#mode_of_payment_credit_card').find('input').attr('required', true);
            } else {
                clearModeOfPayment();
            }
        }

        function clearModeOfPayment() {
            $('#gcash').hide();
            $('#gcash').find('input').attr('required', false);
            $('#gcash').find('input').val('');
            $('#mode_of_payment_direct_deposit').hide();
            $('#mode_of_payment_direct_deposit').find('input').attr('required', false);
            $('#mode_of_payment_direct_deposit').find('input').val('');
            $('#check_payment').hide();
            $('#check_payment').find('input').attr('required', false);
            $('#check_payment').find('input').val('');
            $('#credit_card').hide();
            $('#mode_of_payment_direct_deposit').hide();
            $('#mode_of_payment_direct_deposit').find('input').attr('required', false);
            $('#mode_of_payment_direct_deposit').find('input').val('');
            $('#mode_of_payment_credit_card').hide();
            $('#mode_of_payment_credit_card').find('input').val('');
            $('#mode_of_payment_credit_card').find('input').attr('required', false);
        }

        // End of Mode of Payment

        // Image modal
        $(".modal-trigger").click(function() {
            var imgSrc = $(this).attr('src');
            $(".modal").fadeIn();
            $(".modal-content img").attr("src", imgSrc);
        });

        $(document).click(function(e) {
            if ($(e.target).is('.modal')) {
                $(".modal").fadeOut();
            }
        });
        // End of Image modal

        function add_select2(row) {
            row.find(".brand").select2({
                placeholder: "Select Concept",
                width: '128',
            })

            row.find(".location").select2({
                placeholder: "Select Location",
                width: '180',
            })

            row.find(".category").select2({
                placeholder: "Select Category",
                width: '145',
            });

            row.find(".currency").select2({
                placeholder: "Currency",
                width: '106.5',
            })

            row.find(".account").select2({
                placeholder: "Select an account",
                width: '150px',
                ajax: {
                    url: "{{ route('prepayment_account') }}",
                    dataType: "json",
                    delay: 250,
                    type: "POST",
                    data: function(params) {
                        return {
                            q: params.term,
                            category_id: row.find(".category").val(),
                            _token: '{!! csrf_token() !!}',
                        };
                    },
                    error: function(error) {
                        console.log(error);
                    },
                    processResults: function(data) {
                        // console.log($('.budget_content').index(row));
                        // data = data.filter(account=>account.account_name!='CASH IN BANK')
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.account_name,
                                    id: item.id,
                                };
                            }),
                        };
                    },
                    cache: true,
                },
                id: "id",
            });

            // Reset account dropdown
            row.find(".category").on("change", function() {
                row.find(".account").val(null).trigger("change");
                row.find(".account").empty();
            });
        }

        let budget_length = $('.budget').length;
        for (i = 0; i < budget_length; i++) {
            add_select2($('.budget').eq(i + 1));
        }

        $(document).ready(function() {
            $('.input_description').hover(function() {
                $(this).attr('title', $(this).val());
            });
        });
    </script>
@endsection
