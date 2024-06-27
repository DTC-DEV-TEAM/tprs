<form method='post' action='{{ CRUDBooster::mainpath('edit-save/' . $row->id) }}' id="approve_budget">
    <div class='panel panel-default'>
        <div class='panel-heading'>AP Recording</div>
        <div class='panel-body'>
            {{ csrf_field() }}
            <div class='form-group'>
                <div class="request_content">
                    <div class="by_department">
                        <div class="request_department">
                            <label for="">Department</label>
                            <div class="select_with_icon">
                                <i class="fa fa-sticky-note select_icon"></i>
                                <select class="js-example-basic-single" name="department" class="department"
                                    id="req_department" disabled required>
                                    <option selected value="{{ $department->id }}">{{ $department->department_name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="request_department">
                            <label for="">Sub Department</label>
                            <div class="select_with_icon">
                                <i class="fa fa-sticky-note select_icon"></i>
                                <select class="js-example-basic-single" name="sub_department" class="department"
                                    id="sub_department" disabled required>
                                    <option value="{{ $sub_department->id }}" selected>
                                        {{ $sub_department->sub_department_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="request_department r_full_name">
                            <label for="">Requestor Full Name</label>
                            <input type="text" id="req_full_name" name="full_name" disabled
                                value="{{ $row->full_name }}" required>
                        </div>
                    </div>
                    <div class="mode_of_payment_section">
                        <div class="mode_of_payment_section1">
                            <div class="mode_of_payment_">
                                <label for="">Mode of Payment <span class="required">*</span></label>
                                <select class="js-example-basic-single" id="mode_of_payment" name="mode_of_payment"
                                    required>
                                    <option value="{{ $mode_of_payment->id }}" selected>
                                        {{ $mode_of_payment->mode_of_payment_name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mode_of_payment_section2">
                            <div class="mode_of_payment_dropdown">
                                <div class="mode_of_payment_content" id="check_payment" style="display: none;">
                                    <label for="">Payee Name <span class="required">*</span></label>
                                    <input type="text" name="payee_name" value="{{ $row->payee_name }}">
                                </div>
                                <div class="mode_of_payment_content" id="credit_card" style="display: none;">
                                    <label for="">Note <span class="required">*</span></label>
                                    <input type="text" placeholder="PLEASE COORDINATE TO ACCOUNTING MANAGER"
                                        disabled>
                                </div>
                                <div class="mode_of_payment_content" id="gcash" style="display: none;">
                                    <label for="">Gcash# <span class="required">*</span></label>
                                    <input type="text" name="gcash_number" value="{{ $row->gcash_number }}">
                                </div>
                                <div id="mode_of_payment_direct_deposit" style="display: none;">
                                    <div class="flex mode_of_payment_input">
                                        <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                                            <label for="">Bank Name <span class="required">*</span></label>
                                            <input type="text" name="bank_name"
                                                oninput="this.value = this.value.toUpperCase()"
                                                value="{{ $row->bank_name }}">
                                        </div>
                                        <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                                            <label for="">Bank Branch Name <span
                                                    class="required">*</span></label>
                                            <input type="text" name="bank_branch_name"
                                                value="{{ $row->bank_branch_name }}">
                                        </div>
                                    </div>
                                    <div class="flex" style="margin-top: 10px;">
                                        <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                                            <label for="">Bank Account Name <span
                                                    class="required">*</span></label>
                                            <input type="text" name="bank_account_name"
                                                value="{{ $row->bank_account_name }}">
                                        </div>
                                        <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                                            <label for="">Bank Account Number <span
                                                    class="required">*</span></label>
                                            <input type="text" name="bank_account_number"
                                                value="{{ $row->bank_account_number }}">
                                        </div>
                                    </div>
                                </div>
                                <div id="mode_of_payment_credit_card" style="display: none;">
                                    <div class="flex mode_of_payment_input">
                                        <div class="mode_of_payment_content credit_card" style="margin-right: 5px;">
                                            <label for="">Payee Name <span class="required">*</span></label>
                                            <input type="text" name="cc_payee_name"
                                                value="{{ $row->cc_payee_name }}">
                                        </div>
                                        <div class="mode_of_payment_content credit_card" style="margin-left: 5px;">
                                            <label for="">Last 4 digits of card <span
                                                    class="required">*</span></label>
                                            <input type="text" name="cc_credit_card"
                                                value="{{ $row->cc_last_card_number }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="ap_recording">
                        <div class="ap_recording_content">
                            <div class="total_amount_content">
                                <label for="">Reference Number:</label>
                                <input type="text" style="border: 1px solid #fff;"
                                    value="{{ $row->reference_number }}" readonly>
                            </div>
                            <div class="total_amount_content">
                                <label for="">Amount Requested:</label>
                                <input type="number" value="{{ $row->requested_amount }}"
                                    style="background-color: #eeeeee;" readonly>
                            </div>
                        </div>
                        <div class="ap_recording_content">
                            <div class="total_amount_content">
                                <label for="">QB Pre Payment#: <span class="required">*</span></label>
                                <input type="text" placeholder="Enter ref#" name="system_reference_number"
                                    required>
                            </div>
                            <div class="total_amount_content">
                                <label for="date">Date Recorded: <span class="required">*</span></label>
                                <input type="date" id="date" name="ap_checker_date_recorded"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>

                            {{-- <div class="total_amount_content">
                      <label for="">Cheque Date: <span class="required">*</span></label>
                      <input type="date" name="check_date" style="padding: 5px;" required>
                    </div> --}}
                        </div>
                    </div>
                    <div class="additional_notes">
                        <label for="">Additional Notes: </label>
                        <textarea name="additional_notes" id="additional_notes" required></textarea>
                    </div>
                    <div class="request_information start">
                        <label for="">Requested Date:</label>
                        <span>{{ $row->created_at }}</span>
                    </div>
                    <div class="request_information">
                        <label for="">Need by date:</label>
                        <span>{{ $row->need_by_date }}</span>
                    </div>
                    <div class="request_information">
                        <label for="">Created by:</label>
                        <span>{{ $row->cms_users_name }}</span>
                    </div>
                    <div class="request_information">
                        <label for="">Comment:</label>
                        <span>
                            {{ $row->additional_notes }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class='panel-footer'>
            <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'>Cancel</a>
            <input type='submit' class='btn btn-danger' name="submit" value='Reject' />
            <input type='submit' class='btn btn-primary' name="submit" value='Save' />
            <input type="id" name="returns_id" value="{{ $row->id }}" style="visibility: hidden;">
            <input type="status_id" name="status_id" value="{{ $row->status_id }}" style="visibility: hidden;">
        </div>
    </div>
</form>
