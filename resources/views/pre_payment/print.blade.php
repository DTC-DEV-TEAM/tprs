@extends('crudbooster::admin_template')
@push('head')
    <style type="text/css">
    </style>
@endpush
@section('content')
    <!-- link -->
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
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <form method='' id="myform" action="">
                        <input type="hidden" value="{{ $Header->id }}" name="id">
                        <input type='submit' class='btn btn-primary' id="save"
                            onclick="printDivision('printableArea')" value='Print as PDF' />
                    </form>
                </div>
            </div>
        </div>
        <div class='panel-body'>
            <div id="printableArea">
                <table width="100%">
                    <tr>
                        <td colspan="4">
                            <h4 align="center"><strong>CASH ADVANCE REQUEST FORM</strong></h4>

                            <hr />
                        </td>

                    </tr>

                    <tr style="font-size: 13px;">
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Requested Date:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{ $Header->requested_date }}</p>
                        </td>
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Requested By:</strong></label>
                        </td>
                        <td>
                            <p>{{ $Header->requestorlevel }}</p>
                        </td>
                    </tr>

                    <tr style="font-size: 13px;">
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Company:<strong></label>
                        </td>
                        <td width="40%">
                            <p>DIGITS TRADING CORP.</p>
                        </td>
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Amount:</strong></label>
                        </td>
                        <td>
                            <p>{{ $Header->requested_amount }}</p>
                        </td>
                    </tr>

                    <tr style="font-size: 13px;">
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Department:<strong></label>
                        </td>
                        <td width="40%">
                            <p>{{ $Header->department_name }}</p>
                        </td>
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Sub Department:</strong></label>
                        </td>
                        <td>
                            <p>{{ $Header->sub_department_name }}</p>
                        </td>
                    </tr>


                    <tr style="font-size: 13px;">
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Start:<strong></label>
                        </td>
                        <td width="40%">
                            <p>____________________</p>
                        </td>
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>End:</strong></label>
                        </td>
                        <td>
                            <p>____________________</p>
                        </td>
                    </tr>

                    <tr style="font-size: 13px;">
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Note:<strong></label>
                        </td>
                        <td width="40%" colspan="3">

                            <p style="margin-top: 10px;"> Maximum allowable date needed is 15 working days from date
                                of request, liquidation is on or before 5 working days after
                                completion of purpose.
                            </p>
                        </td>

                    </tr>


                    <tr style="font-size: 13px;">
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Detailed Purpose:<strong></label>
                        </td>
                        <td width="40%" colspan="3">
                            <p>_____________________________________________________________________________________
                                _____________________________________________________________________________________
                            </p>
                        </td>

                    </tr>

                    <tr style="font-size: 13px;">
                        <td width="20%">
                            <label class="control-label col-md-12"><strong>Attachment:<strong><br>(please specify)</label>

                        </td>
                        <td width="40%" colspan="3">
                            <p>_____________________________________________________________________________________
                                _____________________________________________________________________________________
                            </p>

                        </td>

                    </tr>

                    <tr style="font-size: 13px;">

                        <td width="20%">
                            <br>
                            <label class="control-label col-md-12" style="margin-top: 2px;"><strong>Mode of
                                    Payment:<strong></label>
                        </td>
                        <td width="40%">
                            <br>
                            {{ $Header->mode_of_payment_name }}
                        </td>

                    </tr>

                    @if ($Header->mode_of_payment_id == 2)
                        <tr style="font-size: 13px;">
                            <td width="20%">
                                <label class="control-label col-md-12"><strong>Bank Name:<strong></label>
                            </td>
                            <td width="40%">
                                <p>{{ $Header->bank_name }}</p>
                            </td>
                            <td width="20%">
                                <label class="control-label col-md-12"><strong>Branch Name:</strong></label>
                            </td>
                            <td>
                                <p>{{ $Header->bank_branch_name }}</p>
                            </td>
                        </tr>

                        <tr style="font-size: 13px;">
                            <td width="20%">
                                <label class="control-label col-md-12"><strong>Account Name:<strong></label>
                            </td>
                            <td width="40%">
                                <p>{{ $Header->bank_account_name }}</p>
                            </td>
                            <td width="20%">
                                <label class="control-label col-md-12"><strong>Account Number:</strong></label>
                            </td>
                            <td>
                                <p>{{ $Header->bank_account_number }}</p>
                            </td>
                        </tr>
                    @elseif($Header->mode_of_payment_id == 1)
                        <tr style="font-size: 13px;">
                            <td width="20%">
                                <label class="control-label col-md-12"><strong>GCash#:<strong></label>
                            </td>
                            <td width="40%">
                                <p>{{ $Header->gcash_number }}</p>
                            </td>
                            <td width="20%">

                            </td>
                            <td>

                            </td>
                        </tr>
                    @elseif($Header->mode_of_payment_id == 3)
                        <tr style="font-size: 13px;">
                            <td width="20%">
                                <label class="control-label col-md-12"><strong>Payee Name:<strong></label>
                            </td>
                            <td width="40%">
                                <p>{{ $Header->payee_name }}</p>
                            </td>
                            <td width="20%">

                            </td>
                            <td>

                            </td>
                        </tr>
                    @elseif($Header->mode_of_payment_id == 4)
                        <tr style="font-size: 13px;">
                            <td width="20%">
                                <label class="control-label col-md-12"><strong>Note:<strong></label>
                            </td>
                            <td width="40%">
                                <p>PLEASE COORDINATE TO ACCOUNTING MANAGER</p>
                            </td>
                            <td width="20%">

                            </td>
                            <td>

                            </td>
                        </tr>
                    @endif


                    <tr style="font-size: 13px;">
                        <td width="20%">
                            <br><br>
                            <label class="control-label col-md-12"><strong>Requested By:<strong></label>
                        </td>
                        <td width="40%">
                            <br><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $Header->requestorlevel }}

                        </td>
                        <td width="20%">
                            <br><br>
                            <label class="control-label col-md-12"><strong>Approved By:</strong></label>
                        </td>
                        <td>
                            <br><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $Header->approverlevel }}
                        </td>
                    </tr>

                    <tr style="font-size: 13px;">
                        <td width="20%">

                        </td>
                        <td width="40%">
                            <p style="font-size: 7px;">&nbsp;&nbsp;&nbsp;&nbsp;(SIGNATURE OVER PRINTED NAME)</p>

                        </td>
                        <td width="20%">

                        </td>
                        <td>
                            <p style="font-size: 7px;">&nbsp;&nbsp;&nbsp;&nbsp;(SIGNATURE OVER PRINTED NAME)</p>
                        </td>
                    </tr>


                    <tr style="font-size: 13px;">
                        <td width="20%">

                        </td>
                        <td width="40%">

                        </td>
                        <td width="20%">

                        </td>
                        <td>
                            <br>
                            ____________________
                        </td>
                    </tr>

                    <tr style="font-size: 13px;">
                        <td width="20%">

                        </td>
                        <td width="40%">

                        </td>
                        <td width="20%">

                        </td>
                        <td>
                            <p style="font-size: 7px;">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;EXECUTIVE (IF APPLICABLE)
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <hr />
                        </td>

                    </tr>

                    <tr style="font-size: 13px;">

                        <td width="40%" colspan="4">

                            <p> <strong>Note:</strong>&nbsp;&nbsp;Accounting Department process payables is 1 to 3 working
                                days upon received of original Cash Advance Form. Please attached
                                approved quotation or any proof that can support your request. This form will be used for
                                NON P.O item such as contract & permits,
                                meal allowance, transportation and etc.
                            </p>
                        </td>

                    </tr>

                </table>
            </div>
        </div>
        <div class='panel-footer'>
            <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.back') }}</a>
        </div>

    </div>
@endsection
@push('bottom')
    <script type="text/javascript">
        $("#save").on('click', function() {
            //var strconfirm = confirm("Are you sure you want to approve this pull-out request?");
            event.preventDefault();

            var data = $('#myform').serialize();

            $.ajax({
                type: 'GET',
                url: "{{ url('admin/pre_payment/PrePaymentUpdateStatus') }}",
                data: data,
                success: function(response) {
                    console.log("success: " + response);

                },
                error: function(e) {
                    console.log("error: " + e);
                }
            });
            return true;
        });

        function printDivision(divName) {
            alert('Please print 1 copies!');
            var generator = window.open(",'printableArea,");
            var layertext = document.getElementById(divName);
            generator.document.write(layertext.innerHTML.replace("Print Me"));
            generator.document.close();
            generator.print();
            generator.close();
        }
    </script>
@endpush
