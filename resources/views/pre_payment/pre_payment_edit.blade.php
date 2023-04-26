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

  .request_content{
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

  .required{
    color: red;
  }

  .request_information_contents{
    margin-bottom: 10px;
    margin-right: 30px;
    width: 31.4%;  
  }

  .flex{
    display: flex;
  }

  .requestor_name{
    width: 35%;
    margin-bottom: 10px;
  }

  .requestor_name label{
    display: block;
    font-size: 15px;
  }

  .requestor_name input{
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
    
  }
  /* End of Select2 */

  .additional_notes{
    width: 100%;
  }

  .additional_notes label{
    display: block;
    font-size: 15px;
  }

  .additional_notes textarea{
    width: 100%;
    height: 100px;
    padding: 10px 15px;
    font-size: 15px;
  }

  .request_note{
    margin-left: 25px;
    margin-bottom: 10px;
  }

  .budget_info{
    text-align: center;
    width: 100%;
    font-weight: bold;
    font-size: 20px;
  }

  .budget_block{
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

  .budget:hover{
    box-shadow: 0px 0px 10px rgba(0,0,0,0.5);

  }

  .circ_delete{
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

  .circ_delete:hover{
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

  .budget_description{
    /* width: 100%; */
    margin: 15px 4px;
    height: 100%;
    align-items: center;
  }

  .budget_description label{
    display: block;
    text-align: center;
    font-size: 15px;
  }

  .budget_description input{
    height: 35px;
    text-align: center;
    border-radius: 5px;
    border: 1px solid #aaa;
    outline-color: #007bff;
  }

  .input_description{
    width: 100%;
    /* width: 500px; */
  }

  .add_row{
    /* padding: 8px 45px; */
    width: 100px;
    height: 35px;
    background-color: rgb(32, 120, 208);
    color: white;
    border-radius: 5px;
    border: none;
  }

  .add_row_receipt{
    width: 100px;
    height: 35px;
    background-color: rgb(32, 120, 208);
    color: white;
    border-radius: 5px;
    border: none;
  }

  .delete_row{
    width: 100px;
    height: 35px;
    background-color: rgb(226, 71, 71);
    color: white;
    border-radius: 5px;
    border: none;
  }

  .add_row:hover, .delete_row:hover{
    opacity: 0.8;
  }

  .total_amount_content{
    margin-bottom: 10px;
  }

  .total_amount_content label{
    font-size: 15px;
    margin-right: 10px;
    width: 150px;
  }

  .total_amount_content input{
    height: 35px;
    border-radius: 5px;
    outline: none;
    border: 1px solid #aaa;
    text-align: center;
    margin-right: 10px;
    width: 150px;
  }

  /* AP Recording */
  .ap_recording{
    display: flex;
    width: 100%;
  }

  .ap_recording_content{
    min-width: 31.9%;
    margin-right: 30px;
  }
  /* End of AP Recording */

  /* Request Information */
  .request_information{
    display: flex;
  }

  .request_information label{
    font-size: 15px;
    margin-right: 10px;
    width: 150px;
  }

  .request_information span{
    font-size: 15px;
    margin-right: 10px;
    width: 150px;
  }
  /* End of Request Information  */

  .start{
    margin-top: 20px;
  }

  .r_full_name label{
    display: block;
  }

  #req_full_name{
    width: 100%;
    height: 35px;
    text-align: center;
    background-color: #eee;
    border: 1px solid #aaa;
    border-radius: 5px;
  }


  #budget_image:hover{
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
    max-width:  600px;
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

  #upload_img{
    padding-top: 5px;
    border: none;
    width: 100%;
  }

  .budget_qty, .budget_value, .budget_amount{
    width: 95px;
  }

  .upload_img_parent {
    text-align-last: center;
    margin: 0;
    padding: 0;
  }

  .requestor_name{
    width: 35%;
    margin-bottom: 10px;
  }

  .requestor_name label{
    display: block;
    font-size: 15px;
  }

  .requestor_name input{
    width: 100%;
    height: 35px;
    border: 1px solid #aaa;
    border-radius: 5px;
    text-align: center;
  }

  .mode_of_payment_{
    width: 100%;  
  }

  .mode_of_payment_dropdown{
    width: 100%;
  }

  .mode_of_payment_dropdown label{
    display: block;
    width: 150px;
  }

  #check_payment input{
    width: 100%;
    height: 35px;
    border: 1px solid #aaa;
    border-radius: 5px;
    text-align: center;
  }

  #credit_card input{
    width: 100%;
    height: 35px;
    border: 1px solid #aaa;
    border-radius: 5px;
    text-align: center;
    background-color: #eeeeee;
  }

  #gcash input{
    width: 100%;
    height: 35px;
    border: 1px solid #aaa;
    border-radius: 5px;
    text-align: center;
  }


  .direct_deposit{
    width: 50%;
  }

  .direct_deposit input{
    width: 100%;
    height: 35px;
    border: 1px solid #aaa;
    border-radius: 5px;
    text-align: center;
  }

  .mode_of_payment_section{
    display: flex;
    flex-wrap: wrap;
    width: 100%;
  }

  .mode_of_payment_section1{
    width: 31.9%;
    margin-right: 30px;
  }

  .mode_of_payment_section2{
    width: 31.9%;
  }

  /* Receipts Validation */
  .receipts_per_department{
    display: flex;
    flex-wrap: wrap;
  }

  .receipts_request_department{
    width: 365px;
    padding-right: 10px;
  }

  .receipts_comments{
    display: flex;
    flex-wrap: wrap;
  }

  .receipts_amount_contents{
    display: flex;
    flex-wrap: wrap;
  }

  .receipts_total_amount{
    width: 365px;
    padding-right: 10px;
  }

  .receipts_amount_contents:nth-child(2) input{
    background-color: #eeeeee;
  }

  /* End of Receipts Validation */

  .read_only{
    background-color: #eee;
  }

  #remaining_balance{
    color:  #d32f2f;
    font-weight: bold;
  }

</style>

@endpush

@extends('crudbooster::admin_template')


@section('content')
  <!-- Your html goes here -->
    <p class="noprint"><a title="Main Module" href="{{ CRUDBooster::mainpath() }}"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Pre Payment</a></p> 
    
    {{-- Approver Privilege --}}
    @if ($row->status_id == 1) 
        <form method='post' action='{{CRUDBooster::mainpath('edit-save/'.$row->id)}}' id="approve_budget">
            <div class='panel panel-default'>
                <div class='panel-heading'>Request Approval</div>
                <div class='panel-body'>
                    {{-- <form method='POST' action='{{CRUDBooster::mainpath('add-save')}}'> --}}
                    {{ csrf_field() }}
                    <div class='form-group'>
                      <div class="request_content">
                        <div class="by_department">
                          <div class="request_department">
                            <label for="">Department <span class="required">*</span></label>
                            <select class="js-example-basic-single" name="department" class="department" id="req_department" disabled required>
                                <option selected value="{{ $department->id }}">{{ $department->department_name }}</option>
                            </select>   
                          </div>       
                          <div class="request_department">
                                <label for="">Sub Department <span class="required">*</span></label>
                                <select class="js-example-basic-single" name="sub_department" class="department" id="sub_department" disabled required>
                                    <option value="{{ $sub_department->id }}" selected>{{ $sub_department->sub_department_name }}</option>
                                </select>                           
                          </div> 
                          <div class="request_department r_full_name">
                                <label for="">Requestor Full Name <span class="required">*</span></label>
                                <input type="text" id="req_full_name" name="full_name" disabled value="{{ $row->full_name }}" required>
                          </div> 
                        </div>
                          <div class="mode_of_payment_section">
                            <div class="mode_of_payment_section1">
                              <div class="mode_of_payment_">
                                <label for="">Mode of Payment <span class="required">*</span></label>
                                <select class="js-example-basic-single" id="mode_of_payment" name="mode_of_payment" required>
                                    <option value="{{ $mode_of_payment->id }}" selected>{{ $mode_of_payment->mode_of_payment_name }}</option>
                                </select>            
                              </div>
                              <div class="request_information start">
                                <label for="">Requested Date:</label>
                                <span>{{ $row->created_at }}</span>
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
                            <div class="mode_of_payment_section2">
                              <div class="mode_of_payment_dropdown">
                                  <div class="mode_of_payment_content" id="check_payment" style="display: none;">
                                    <label for="">Payee Name <span class="required">*</span></label>
                                    <input type="text" name="payee_name" value="{{ $row->payee_name }}">   
                                  </div>
                                  <div class="mode_of_payment_content" id="credit_card" style="display: none;">
                                    <label for="">Note  <span class="required">*</span></label>
                                    <input type="text" placeholder="PLEASE COORDINATE TO ACCOUNTING MANAGER" disabled>   
                                  </div>
                                  <div class="mode_of_payment_content" id="gcash" style="display: none;">
                                    <label for="">Gcash#  <span class="required">*</span></label>
                                    <input type="text" name="gcash_number" value="{{ $row->gcash_number }}">   
                                  </div>
                                  <div id="mode_of_payment_direct_deposit" style="display: none;">
                                    <div class="flex mode_of_payment_input">
                                      <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                                        <label for="">Bank Name  <span class="required">*</span></label>
                                        <input type="text" name="bank_name" oninput="this.value = this.value.toUpperCase()" value="{{ $row->bank_name }}">   
                                      </div>
                                      <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                                        <label for="">Bank Branch Name  <span class="required">*</span></label>
                                        <input type="text" name="bank_branch_name" value="{{ $row->bank_branch_name }}">   
                                      </div>
                                    </div>
                                    <div class="flex" style="margin-top: 10px;">
                                      <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                                        <label for="">Bank Account Name  <span class="required">*</span></label>
                                        <input type="text" name="bank_account_name" value="{{ $row->bank_account_name }}">   
                                      </div>
                                      <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                                        <label for="">Bank Account Number  <span class="required">*</span></label>
                                        <input type="text" name="bank_account_number" value="{{ $row->bank_account_number }}">   
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div> 
                          <hr>
                          <div class="total_amount_content">
                              <label for="">Reference Number:</label>
                              <span>{{ $row->reference_number }}</span>
                          </div>
                          <div class="total_amount_content">
                            <label for="">Amount Requested:</label>
                            <input type="number" value="{{ $row->requested_amount }}"  style="background-color: #eeeeee;" readonly>
                          </div>
                          <div class="additional_notes">
                              <label for="">Additional Notes: </label>
                              <textarea name="additional_notes" id="additional_notes" required></textarea>
                          </div>
                      </div>
                    </div>        
                </div>
                <div class='panel-footer'>
                    <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'>Cancel</a>
                    <input type='submit' class='btn btn-danger' name="submit" value='Reject'/>
                    <input type='submit' class='btn btn-primary' name="submit" value='Approve'/>
                    <input type="id" name="returns_id" value="{{ $row->id }}" style="visibility: hidden;">
                    <input type="status_id" name="status_id" value="{{ $row->status_id }}" style="visibility: hidden;">
                </div>
            </div>
        </form>
    @endif

    {{-- Approver Privilege --}}
    @if ($row->status_id == 7) 
        <form method='post' action='{{CRUDBooster::mainpath('edit-save/'.$row->id)}}' id="approve_budget">
            <div class='panel panel-default'>
                <div class='panel-heading'>AP Recording</div>
                <div class='panel-body'>
                    {{ csrf_field() }}
                    <div class='form-group'>
                      <div class="request_content">
                        <div class="by_department">
                          <div class="request_department">
                            <label for="">Department <span class="required">*</span></label>
                            <select class="js-example-basic-single" name="department" class="department" id="req_department" disabled required>
                                <option selected value="{{ $department->id }}">{{ $department->department_name }}</option>
                            </select>   
                          </div>       
                          <div class="request_department">
                                <label for="">Sub Department <span class="required">*</span></label>
                                <select class="js-example-basic-single" name="sub_department" class="department" id="sub_department" disabled required>
                                    <option value="{{ $sub_department->id }}" selected>{{ $sub_department->sub_department_name }}</option>
                                </select>                           
                          </div> 
                          <div class="request_department r_full_name">
                                <label for="">Requestor Full Name <span class="required">*</span></label>
                                <input type="text" id="req_full_name" name="full_name" disabled value="{{ $row->full_name }}" required>
                          </div> 
                        </div>
                        <div class="mode_of_payment_section">
                          <div class="mode_of_payment_section1">
                            <div class="mode_of_payment_">
                              <label for="">Mode of Payment <span class="required">*</span></label>
                              <select class="js-example-basic-single" id="mode_of_payment" name="mode_of_payment" required>
                                  <option value="{{ $mode_of_payment->id }}" selected>{{ $mode_of_payment->mode_of_payment_name }}</option>
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
                                  <label for="">Note  <span class="required">*</span></label>
                                  <input type="text" placeholder="PLEASE COORDINATE TO ACCOUNTING MANAGER" disabled>   
                                </div>
                                <div class="mode_of_payment_content" id="gcash" style="display: none;">
                                  <label for="">Gcash#  <span class="required">*</span></label>
                                  <input type="text" name="gcash_number" value="{{ $row->gcash_number }}">   
                                </div>
                                <div id="mode_of_payment_direct_deposit" style="display: none;">
                                  <div class="flex mode_of_payment_input">
                                    <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                                      <label for="">Bank Name  <span class="required">*</span></label>
                                      <input type="text" name="bank_name" oninput="this.value = this.value.toUpperCase()" value="{{ $row->bank_name }}">   
                                    </div>
                                    <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                                      <label for="">Bank Branch Name  <span class="required">*</span></label>
                                      <input type="text" name="bank_branch_name" value="{{ $row->bank_branch_name }}">   
                                    </div>
                                  </div>
                                  <div class="flex" style="margin-top: 10px;">
                                    <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                                      <label for="">Bank Account Name  <span class="required">*</span></label>
                                      <input type="text" name="bank_account_name" value="{{ $row->bank_account_name }}">   
                                    </div>
                                    <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                                      <label for="">Bank Account Number  <span class="required">*</span></label>
                                      <input type="text" name="bank_account_number" value="{{ $row->bank_account_number }}">   
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
                                <input type="text" style="border: 1px solid #fff;" value="{{ $row->reference_number }}" readonly>
                            </div>
                            <div class="total_amount_content">
                              <label for="">Amount Requested:</label>
                              <input type="number" value="{{ $row->requested_amount }}"  style="background-color: #eeeeee;" readonly>
                            </div>
                          </div>
                          <div class="ap_recording_content">
                            <div class="total_amount_content">
                              <label for="">BEACH pre-payment#:</label>
                              <input type="text" placeholder="Enter ref#" name="system_reference_number" required>
                            </div>
                            <div class="total_amount_content">
                              <label for="">Cheque Date: </label>
                              <input type="date" name="check_date" required>
                            </div>
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
                    <input type='submit' class='btn btn-danger' name="submit" value='Reject'/>
                    <input type='submit' class='btn btn-primary' name="submit" value='Save'/>
                    <input type="id" name="returns_id" value="{{ $row->id }}" style="visibility: hidden;">
                    <input type="status_id" name="status_id" value="{{ $row->status_id }}" style="visibility: hidden;">
                </div>
            </div>
        </form>
    @endif

    {{-- Accounting Approval --}}
    {{-- Accounting Budget Releasing --}}
    @if ($row->status_id == 2)
        <form method='post' action='{{CRUDBooster::mainpath('edit-save/'.$row->id)}}'>
            <div class='panel panel-default'>
                <div class='panel-heading'>Request Cash Advance</div>
                <div class='panel-body'>
                    {{-- <form method='POST' action='{{CRUDBooster::mainpath('add-save')}}'> --}}
                    
                    {{ csrf_field() }}
                    <div class='form-group'>
                      <div class="request_content">
                        <div class="by_department">
                          <div class="request_department">
                            <label for="">Department <span class="required">*</span></label>
                            <select class="js-example-basic-single" name="department" class="department" id="req_department" disabled required>
                                <option selected value="{{ $department->id }}">{{ $department->department_name }}</option>
                            </select>   
                          </div>       
                          <div class="request_department">
                                <label for="">Sub Department <span class="required">*</span></label>
                                <select class="js-example-basic-single" name="sub_department" class="department" id="sub_department" disabled required>
                                    <option value="{{ $sub_department->id }}" selected>{{ $sub_department->sub_department_name }}</option>
                                </select>                           
                          </div> 
                          <div class="request_department r_full_name">
                                <label for="">Requestor Full Name <span class="required">*</span></label>
                                <input type="text" id="req_full_name" name="full_name" disabled value="{{ $row->full_name }}" required>
                          </div> 
                        </div>
                          <div class="mode_of_payment_section">
                            <div class="mode_of_payment_section1">
                              <div class="mode_of_payment_">
                                <label for="">Mode of Payment <span class="required">*</span></label>
                                <select class="js-example-basic-single" id="mode_of_payment" name="mode_of_payment" required>
                                    <option value="{{ $mode_of_payment->id }}" selected>{{ $mode_of_payment->mode_of_payment_name }}</option>
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
                                  <label for="">Note  <span class="required">*</span></label>
                                  <input type="text" placeholder="PLEASE COORDINATE TO ACCOUNTING MANAGER" disabled>   
                                </div>
                                <div class="mode_of_payment_content" id="gcash" style="display: none;">
                                  <label for="">Gcash#  <span class="required">*</span></label>
                                  <input type="text" name="gcash_number" value="{{ $row->gcash_number }}">   
                                </div>
                                <div id="mode_of_payment_direct_deposit" style="display: none;">
                                  <div class="flex mode_of_payment_input">
                                    <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                                      <label for="">Bank Name  <span class="required">*</span></label>
                                      <input type="text" name="bank_name" oninput="this.value = this.value.toUpperCase()" value="{{ $row->bank_name }}">   
                                    </div>
                                    <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                                      <label for="">Bank Branch Name  <span class="required">*</span></label>
                                      <input type="text" name="bank_branch_name" value="{{ $row->bank_branch_name }}">   
                                    </div>
                                  </div>
                                  <div class="flex" style="margin-top: 10px;">
                                    <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                                      <label for="">Bank Account Name  <span class="required">*</span></label>
                                      <input type="text" name="bank_account_name" value="{{ $row->bank_account_name }}">   
                                    </div>
                                    <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                                      <label for="">Bank Account Number  <span class="required">*</span></label>
                                      <input type="text" name="bank_account_number" value="{{ $row->bank_account_number }}">   
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div> 
                      <hr>
                      <div class="total_amount_content">
                          <label for="">Reference Number:</label>
                          <span>{{ $row->reference_number }}</span>
                      </div>
                      <div class="total_amount_content">
                          <label for="">Amount Requested:</label>
                          <input type="number" value="{{ $row->requested_amount }}"  style="background-color: #eeeeee;" readonly>
                      </div>
                      <div class="additional_notes">
                          <label for="">Additional Notes: </label>
                          <textarea name="additional_notes" id="additional_notes" required></textarea>
                      </div>                        
                      <div class="ap_recording">
                        <div class="ap_recording_content">
                          <div class="request_information start">
                              <label for="">Requested Date:</label>
                              <span>{{ $row->created_at }}</span>
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
                        <div class="ap_recording_content">
                            <div class="request_information start">
                                <label for="">Approved Date:</label>
                                <span>{{ $row->approver_date }}</span>
                            </div>
                            <div class="request_information">
                                <label for="">Approved by:</label>
                                <span>{{ $row->approver_name }}</span>
                            </div>
                            <div class="request_information">
                                <label for="">Approver Note:</label>
                                <span>
                                    {{ $row->approver_note }}
                                </span>
                            </div>
                            <div class="request_information">
                                <label for="">Cheque Date:</label>
                                <span>
                                    {{ date('Y-m-d', strtotime($row->check_date)) }}
                                </span>
                            </div>
                          </div>
                        </div>
                        <br>
                        <div>
                          <span style="font-size: 15px;"><span style="color: red; font-weight: bold;">Note: </span>Click Release button after the requestor received his/her Cash Advance.</span>
                        </div>
                      </div>
                    </div>        
                </div>
                <div class='panel-footer'>
                    <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'>Cancel</a>
                    <input type='submit' class='btn btn-danger' name="submit" value='Reject'/>
                    <input type='submit' class='btn btn-primary' name="submit" value='Release'/>
                    <input type="id" name="returns_id" value="{{ $row->id }}" style="visibility: hidden;">
                    <input type="status_id" name="status_id" value="{{ $row->status_id }}" style="visibility: hidden;">
                </div>
            </div>
        </form>
    @endif

    {{-- Receipts Information Breakdown --}}
    {{-- Requestor Privilege --}}
    @if ($row->status_id == 3)
      {{-- <hr> --}}
      <div class="budget_content" style="display: none;">
        <div class="budget_block">
          <div class="circ_delete">
            <i class="fa fa-close"></i>
          </div>
          <div class="budget">
            <div class="budget_description">
              <label for="">Description</label>
              <input class="input_description" type="text"  name="description[]" required>
            </div>
            <div class="budget_description">
              <label for="">Brand</label>
              <select class="js-example-basic-single brand" name="brand[]" required>
                <option value="" selected disabled>Select Brand</option>
                @foreach ($brands as $brand)
                  <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                @endforeach
              </select>       
            </div>
            <div class="budget_description">
              <label for="">Location</label>
              <select class="js-example-basic-single location" name="location[]" required>
                <option value="" selected disabled>Select Category</option>
                @foreach ($locations as $location)
                  <option value="{{ $location->id }}">{{ $location->store_name }}</option>
                @endforeach
              </select>   
            </div>
            <div class="budget_description">
              <label for="">Category</label>
              <select class="js-example-basic-single category" name="category[]" required>
                <option value="" selected disabled>Select Category</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
              </select> 
            </div>
            <div class="budget_description" id="select_account">
              <label for="">Account</label>
              <select class="js-example-basic-single account" name="account[]" required>
                <option value="">Account</option>
              </select>
            </div>
            <div class="budget_description">
              <label for="">Currency</label >
              <select class="js-example-basic-single currency" name="currency[]" required>
                <option value="" selected disabled>Select Currency</option>
                @foreach ($currencies as $currency)
                  @if ($currency->id == '1')
                      <option value="{{ $currency->id }}" selected>{{ $currency->currency_name }}</option>
                    @else
                      <option value="{{ $currency->id }}">{{ $currency->currency_name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="budget_description">
              <label for="">Qty</label >
              <input type="number" name="qty[]" min="0" class="budget_qty" required>
            </div>
            <div class="budget_description">
              <label for="">Value</label >
              <input type="number" name="value[]" min="0" class="budget_value" required>
            </div>
            <div class="budget_description">
              <label for="">Total Value</label >
              <input type="number" name="amount[]" min="0" class="budget_amount" style="background-color: #eeeeee" readonly>
            </div>
            <div class="budget_description" id="step3_budget_justification">
              <label for="">Receipts</label>
              <div class="upload_img_parent">
                <input type="file" name="budget_justification[]" accept="image/png, image/gif, image/jpeg" id="upload_img" multiple required>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class='panel panel-default'>
        <form method="POST" action="{{CRUDBooster::mainpath('edit-save/'.$row->id)}}" enctype="multipart/form-data" id="receipts_validation">
        <div class='panel-heading'>Receipts Validation</div>
        <div class='panel-body'>
          {{-- <form method='POST' action='{{CRUDBooster::mainpath('add-save')}}'> --}}
            {{ csrf_field() }}
            <div class='form-group'>
              <div class="request_content">
                <div class="receipts_per_department">
                  <div class="receipts_request_department">
                      <label for="">Department <span class="required">*</span></label>
                      <select class="js-example-basic-single" name="department" class="department" id="req_department" disabled required>
                          <option selected value="{{ $department->id }}">{{ $department->department_name }}</option>
                      </select>   
                  </div>       
                  <div class="receipts_request_department">
                      <label for="">Sub Department <span class="required">*</span></label>
                      <select class="js-example-basic-single" name="sub_department" class="department" id="sub_department" disabled required>
                          <option value="{{ $sub_department->id }}" selected>{{ $sub_department->sub_department_name }}</option>
                      </select>                           
                  </div>   
                  <div class="receipts_request_department r_full_name">
                      <label for="">Requestor Full Name <span class="required">*</span></label>
                      <input type="text" id="req_full_name" name="full_name" disabled value="{{ $row->full_name }}" required>
                  </div>
                  <div class="receipts_request_department">
                      <label for="">Mode of Payment <span class="required">*</span></label>
                      <select class="js-example-basic-single" id="mode_of_payment" name="mode_of_payment" disabled required>
                          <option value="{{ $mode_of_payment->id }}" selected>{{ $mode_of_payment->mode_of_payment_name }}</option>
                      </select>            
                  </div>
              </div>
              <div class="receipts_comments">
                  <div class="receipts_request_department">
                    <div class="request_information start">
                        <label for="">Requested Date:</label>
                        <span>{{ $row->created_at }}</span>
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
                  <div class="receipts_request_department">
                    <div class="request_information start">
                        <label for="">Approved Date:</label>
                        <span>{{ $row->approver_date }}</span>
                    </div>
                    <div class="request_information">
                        <label for="">Approved by:</label>
                        <span>{{ $row->approver_name }}</span>
                    </div>
                    <div class="request_information">
                        <label for="">Approver Note:</label>
                        <span>{{ $row->approver_note }}</span>
                    </div>
                  </div>
                  <div class="receipts_request_department">
                      <div class="request_information start">
                          <label for="">Date Released:</label>
                          <span>{{ $row->accounting_date_release }}</span>
                      </div>
                      <div class="request_information">
                          <label for="">Accounting Name:</label>
                          <span>{{ $row->accounting_name }}</span>
                      </div>
                      <div class="request_information">
                          <label for="">Accounting Note:</label>
                          <span>{{ $row->accounting_note }}</span>
                      </div>
                  </div>
                </div>
                <hr>
                <div class="budget_info">
                  <p>Items Breakdown</p>
                </div>
                <div class="budget_content">
                  <div class="budget_block">
                    <div class="budget">
                      <div class="budget_description">
                        <label for="">Description</label>
                        <input class="input_description" type="text" value="UNUSED AMOUNT" name="description[]" style="background-color: #eeeeee;" readonly>
                      </div>
                      <div class="budget_description">
                        <label for="">Brand</label>
                        <select class="js-example-basic-single brand" id="brand" name="brand[]" disabled>
                          <option value="" selected disabled>Select Brand</option>
                          @foreach ($brands as $brand)
                            <option {{ ($brand->id == 53) ? "selected": "" }} value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                          @endforeach
                        </select>       
                      </div>
                      <div class="budget_description">
                        <label for="">Location</label>
                        <select class="js-example-basic-single location" name="location[]" disabled>
                          <option value="" selected disabled>Select Category</option>
                          @foreach ($locations as $location)
                            <option {{ ($location->id == 115) ? "selected": "" }} value="{{ $location->id }}">{{ $location->store_name }}</option>
                          @endforeach
                        </select>   
                      </div>
                      <div class="budget_description">
                        <label for="">Category</label>
                        <select class="js-example-basic-single category" name="category[]" disabled>
                          {{-- <option value="" selected disabled>Select Category</option> --}}
                          @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                          @endforeach
                        </select> 
                      </div>
                      <div class="budget_description" id="select_account">
                        <label for="">Account</label>
                        <select class="js-example-basic-single account" name="account[]" disabled>
                          <option value="2" selected>CASH IN BANK</option>
                        </select>
                      </div>
                      <div class="budget_description">
                        <label for="">Currency</label >
                        <select class="js-example-basic-single currency" name="currency[]" required>
                          <option value="" selected disabled>Select Currency</option>
                          @foreach ($currencies as $currency)
                            @if ($currency->id == '1')
                                <option value="{{ $currency->id }}" selected>{{ $currency->currency_name }}</option>
                              @else
                                <option value="{{ $currency->id }}">{{ $currency->currency_name }}</option>
                            @endif
                          @endforeach
                        </select>
                      </div>
                      <div class="budget_description">
                        <label for="">Qty</label >
                        <input type="number" name="qty[]" min="0" value="1" class="budget_qty" required>
                      </div>
                      <div class="budget_description">
                        <label for="">Value</label >
                        <input type="number" name="value[]" min="1" value="0" class="budget_value" required>
                      </div>
                      <div class="budget_description">
                        <label for="">Total Value</label >
                        <input type="number" name="amount[]" min="0" class="budget_amount" value="0" id="cash_in_bank_total_value" style="background-color: #eeeeee" readonly>
                      </div>
                      <div class="budget_description" id="step3_budget_justification">
                        <label for="">Receipts</label>
                        <div class="upload_img_parent">
                          <input type="file" name="budget_justification[]" accept="image/png, image/gif, image/jpeg" id="upload_img" class="receipts_upload_img" multiple>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="budget_description">
                  <div class="budget_description_btns">
                    <button type="button" class="add_row">Add Row</button>
                  </div>
                </div>
                <hr>
                <div class="receipts_amount_comments">
                  <div class="receipts_amount_contents">
                    <div class="total_amount_content receipts_total_amount">
                      <label for="">Reference Number:</label>
                      <input style="border: none;" value="{{ $row->reference_number }}" readonly>
                    </div>
                    <div class="total_amount_content receipts_total_amount">
                      <label for="">Cheque Date:</label>
                      <input style="border: none;" value="{{ date('Y-m-d', strtotime($row->check_date)) }}" readonly>
                    </div>
                    <div class="total_amount_content receipts_total_amount">
                      <label for="">BEACH pre-payment#:</label>
                      <input style="border: none;" value="{{ $row->system_reference_number }}" readonly>
                    </div>
                  </div>
                  <div class="receipts_amount_contents">
                    <div class="total_amount_content receipts_total_amount">
                      <label for="">Requested Amount:</label>
                      <input class="read_only" type="number" id="requested_amount" value="{{ $row->requested_amount }}" readonly>
                    </div>
                    <div class="total_amount_content receipts_total_amount">
                      <label for="">Used Amount:</label>
                      <input class="read_only" type="number" id="total_amount" value="0" name="total_amount" readonly>
                    </div>
                    <div class="total_amount_content receipts_total_amount">
                      <label for="">Unused Amount:</label>
                      <input class="read_only" type="number" id="unused_amount" value="0" name="unused_amount" readonly>
                    </div>
                    <div class="total_amount_content receipts_total_amount">
                      <label for="">Remaining Balance:</label>
                      <input class="read_only" type="number" id="remaining_balance" value="0" name="remaining_blance" readonly>
                    </div>
                  </div>
                </div>
                <div class="additional_notes">
                  <label for="">Additional Notes: </label>
                  <textarea name="additional_notes" id="additional_notes" required></textarea>
                </div>
                <br>
                <div>
                  <span style="font-size: 15px;"><span style="color: red; font-weight: bold;">Notes: </span>"After submitting the form", you can now return the receipts and unused balance along with your reference number."</span>
                  <br>
                  <span style="font-size: 15px;"><span style="color: rgb(255, 255, 255); font-weight: bold; visibility: hidden;">Notes: </span>"For uploading of multiple receipts press <span style="color: green;">ctrl left click to the image</span>. <span style="color: green;">Accepts Image only</span>"</span>
                </div>
              </div>
            </div>        
          {{-- </form> --}}
        </div>
        <div class='panel-footer'>
          <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'>Cancel</a>
          <input type='submit' class='btn btn-primary' name="submit" id="submit_approve" value='Liquidate' disabled/>
          <input type="id" name="returns_id" value="{{ $row->id }}" style="visibility: hidden;">
          <input type="status_id" name="status_id" value="{{ $row->status_id }}" style="visibility: hidden;">
        </div>
        </form>
      </div>
      
      {{-- <script>
          $('body').addClass('sidebar-collapse');
      </script> --}}
    @endif

    {{-- Accounting Validating Budget Information --}}
    @if ($row->status_id == 4)
      <div class="budget_content" style="display: none;">
        <div class="budget_block">
          <div class="circ_delete">
            <i class="fa fa-close"></i>
          </div>
          <div class="budget">
            <div class="budget_description">
              <label for="">Description</label>
              <input class="input_description" type="text"  name="description[]" required>
            </div>
            <div class="budget_description">
              <label for="">Brand</label>
              <select class="js-example-basic-single brand" name="brand[]" required>
                <option value="" selected disabled>Select Brand</option>
                @foreach ($brands as $brand)
                  <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                @endforeach
              </select>       
            </div>
            <div class="budget_description">
              <label for="">Location</label>
              <select class="js-example-basic-single location" name="location[]" required>
                <option value="" selected disabled>Select Category</option>
                @foreach ($locations as $location)
                  <option value="{{ $location->id }}">{{ $location->store_name }}</option>
                @endforeach
              </select>   
            </div>
            <div class="budget_description">
              <label for="">Category</label>
              <select class="js-example-basic-single category" name="category[]" required>
                <option value="" selected disabled>Select Category</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                @endforeach
              </select> 
            </div>
            <div class="budget_description" id="select_account">
              <label for="">Account</label>
              <select class="js-example-basic-single account" name="account[]" required>
                <option value="">Account</option>
              </select>
            </div>
            <div class="budget_description">
              <label for="">Currency</label >
              <select class="js-example-basic-single currency" name="currency[]" required>
                <option value="" selected disabled>Select Currency</option>
                @foreach ($currencies as $currency)
                  @if ($currency->id == '1')
                      <option value="{{ $currency->id }}" selected>{{ $currency->currency_name }}</option>
                    @else
                      <option value="{{ $currency->id }}">{{ $currency->currency_name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="budget_description">
              <label for="">Qty</label >
              <input type="number" name="qty[]" min="0" class="budget_qty" required>
            </div>
            <div class="budget_description">
              <label for="">Value</label >
              <input type="number" name="value[]" min="0" class="budget_value" required>
            </div>
            <div class="budget_description">
              <label for="">Total Value</label >
              <input type="number" name="amount[]" min="0" class="budget_amount" style="background-color: #eeeeee" readonly>
            </div>
            <div class="budget_description" id="step3_budget_justification">
              <label for="">Receipts</label>
              <div class="upload_img_parent">
                <input style="" type="file" name="budget_justification[]" accept="image/png, image/gif, image/jpeg" id="upload_img" disabled>
              </div>
            </div>
            <div class="budget_description" style="display: none;">
              <div class="budget_description_btns">
                {{-- <button type="button" class="add_row_receipt" style="width: 100px;">Add Row</button>
                <button type="button" class="delete_row" style="display: none;">Delete</button> --}}
                <input type="id" name="returns_id[]" value="{{ $budget->id }}" style="display: none;">
                <input type="id" name="project_id[]" value="{{ $row->id }}" style="display: none;">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class='panel panel-default'>
        <form id="close" method="POST" action="{{CRUDBooster::mainpath('edit-save/'.$row->id)}}" enctype="multipart/form-data">
        <div class='panel-heading'>Validate Receipts</div>
        <div class='panel-body'>
          {{-- <form method='POST' action='{{CRUDBooster::mainpath('add-save')}}'> --}}
            {{ csrf_field() }}
            <div class='form-group'>
              <div class="request_content">
                <div class="receipts_per_department">
                  <div class="receipts_request_department">
                      <label for="">Department <span class="required">*</span></label>
                      <select class="js-example-basic-single" name="department" class="department" id="req_department" disabled required>
                          <option selected value="{{ $department->id }}">{{ $department->department_name }}</option>
                      </select>   
                  </div>       
                  <div class="receipts_request_department">
                      <label for="">Sub Department <span class="required">*</span></label>
                      <select class="js-example-basic-single" name="sub_department" class="department" id="sub_department" disabled required>
                          <option value="{{ $sub_department->id }}" selected>{{ $sub_department->sub_department_name }}</option>
                      </select>                           
                  </div>   
                  <div class="receipts_request_department r_full_name">
                      <label for="">Requestor Full Name <span class="required">*</span></label>
                      <input type="text" id="req_full_name" name="full_name" disabled value="{{ $row->full_name }}" required>
                  </div>
                  <div class="receipts_request_department">
                      <label for="">Mode of Payment <span class="required">*</span></label>
                      <select class="js-example-basic-single" id="mode_of_payment" name="mode_of_payment" disabled required>
                          <option value="{{ $mode_of_payment->id }}" selected>{{ $mode_of_payment->mode_of_payment_name }}</option>
                      </select>            
                  </div>
                </div>
                <hr>
                <div class="budget_info">
                  <p>Items Breakdown</p>
                </div>
                <div class="budget_content">
                  @foreach ($pre_payment_body as $budget)
                    <div class="budget_block">
                      <div class="budget">
                        <div class="budget_description">
                          <label for="">Description</label>
                          <input class="input_description" type="text"  value="{{ $budget->description }}" name="description[]" required>
                        </div>
                        <div class="budget_description">
                          <label for="">Brand</label>
                          <select class="js-example-basic-single brand" name="brand[]">
                            <option value="" selected disabled>Select Brand</option>
                            @foreach ($brands as $brand)
                              @if ($budget->brand_name == $brand->brand_name)
                                <option value="{{ $brand->id }}" selected>{{ $brand->brand_name }}</option>
                              @endif
                              <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                            @endforeach
                          </select>       
                        </div>
                        <div class="budget_description">
                          <label for="">Location</label>
                          <select class="js-example-basic-single location" name="location[]">
                            <option value="" selected disabled>Select Location</option>
                            @foreach ($locations as $location)
                              @if ($budget->store_name == $location->store_name)
                                <option value="{{ $location->id }}" selected>{{ $location->store_name }}</option>
                              @endif
                              <option value="{{ $location->id }}">{{ $location->store_name }}</option>
                            @endforeach
                          </select>   
                        </div>
                        <div class="budget_description">
                          <label for="">Category</label>
                          <select class="js-example-basic-single category" name="category[]">
                            <option value="" selected disabled>Select Category</option>
                            @foreach ($categories as $category)
                              @if ($budget->category_name == $category->category_name)
                                <option value="{{ $category->id }}" selected>{{ $category->category_name }}</option>
                              @endif
                              <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                          </select> 
                        </div>
                        <div class="budget_description" id="select_account">
                          <label for="">Account</label>
                          <select class="js-example-basic-single account" name="account[]">
                                <option value="{{ $budget->account_id }}" selected="selected">{{ $budget->account_name }}</option>
                          </select>
                        </div>
                        <div class="budget_description">
                          <label for="">Currency</label >
                          <select class="js-example-basic-single currency" name="currency[]">
                            <option value="" selected disabled>Select Currency</option>
                            @foreach ($currencies as $currency)
                              @if ($budget->currency_name == $currency->currency_name)
                              <option value="{{ $currency->id }}" selected>{{ $currency->currency_name }}</option>
                              @endif
                              <option value="{{ $currency->id }}">{{ $currency->currency_name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="budget_description">
                          <label for="">Qty</label >
                          <input type="number" name="qty[]" min="0" class="budget_qty" value="{{ $budget->qty }}">
                        </div>
                        <div class="budget_description">
                          <label for="">Value</label >
                          <input type="number" name="value[]" min="0" class="budget_value" value="{{ $budget->value }}">
                        </div>
                        <div class="budget_description">
                          <label for="">Total Value</label >
                          <input type="number" name="amount[]" min="0" class="budget_amount" id="cash_in_bank_total_value" value="{{ $budget->amount }}" style="background-color: #eeeeee" readonly>
                        </div>
                        <div class="budget_description" id="budget_justification" style="width: 200px;">
                          <div style="width: 200px;">
                            <label for="">Receipts</label>
                            @php
                              $img = explode(", ",$budget->budget_justification);
                            @endphp
                            @foreach ($img as $receipts_img)
                              @if ($receipts_img == null)
                                <p>No Image Inserted</p>
                              @else
                                <img src="{{ asset('pre_payment/img/'.$receipts_img) }}" alt="No Image Inserted" style="height: 75px; width: 49%; display: inline-block; margin-top: 2px;" id="budget_image" class="modal-trigger">
                              @endif
                            @endforeach
                            <div class="modal">
                              <div class="modal-content">
                                <img src="" alt="">
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="budget_description" style="text-align: center;">
                          <div class="budget_description_btns">
                            {{-- <button type="button" class="add_row_receipt" style="width: 100px;">Add Row</button>
                            <button type="button" class="delete_row" style="display: none;">Delete</button> --}}
                            <input type="id" name="returns_id[]" value="{{ $budget->id }}" style="display: none;">
                            <input type="id" name="project_id[]" value="{{ $row->id }}" style="display: none;">
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
                <div class="budget_description">
                  <div class="budget_description_btns">
                    <button type="button" class="add_row_receipt">Add Row</button>
                  </div>
                </div>
                <hr>
                <div class="receipts_amount_contents">
                  <div class="total_amount_content receipts_total_amount">
                    <label for="">Reference Number:</label>
                    <input style="border: none;" value="{{ $row->reference_number }}" readonly>
                  </div>
                  <div class="total_amount_content receipts_total_amount">
                    <label for="">AR reference#:</label>
                    <input type="text" name="ar_reference_number" placeholder="Input AR#" required>
                  </div>
                </div>
                <div class="receipts_amount_contents">
                  <div class="total_amount_content receipts_total_amount">
                    <label for="">Requested Amount:</label>
                    <input class="read_only" type="number" id="requested_amount" value="{{ $row->requested_amount }}" readonly>
                  </div>
                  <div class="total_amount_content receipts_total_amount">
                    <label for="">Used Amount:</label>
                    <input class="read_only" type="number" id="total_amount" value="{{ $row->total_amount }}" name="total_amount" readonly>
                  </div>
                  <div class="total_amount_content receipts_total_amount">
                    <label for="">Unused Amount:</label>
                    <input class="read_only" type="number" id="unused_amount" value="{{ $row->unused_amount }}" name="unused_amount" readonly>
                  </div>
                  <div class="total_amount_content receipts_total_amount">
                    <label for="">Remaining Balance:</label>
                    <input class="read_only" type="number" id="remaining_balance" value="{{ $row->balance_amount }}" name="remaining_blance" readonly>
                  </div>
                </div>
                <div class="additional_notes">
                  <label for="">Additional Notes: </label>
                  <textarea name="additional_notes" id="additional_notes" required></textarea>
                </div>
                <hr>
                <div>
                  <span style="font-size: 15px;" ><span style="color: red; font-weight: bold;">Notes: </span>"Please turnover all physical / digital receipts, and unused balance to the accounting department"</span>
                </div>
                <div class="flex">
                  <div class="request_department">
                      <div class="request_information start">
                          <label for="">Requested Date:</label>
                          <span>{{ $row->created_at }}</span>
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
                  <div class="request_department">
                      <div class="request_information start">
                          <label for="">Approved Date:</label>
                          <span>{{ $row->approver_date }}</span>
                      </div>
                      <div class="request_information">
                          <label for="">Approved by:</label>
                          <span>{{ $row->approver_name }}</span>
                      </div>
                      <div class="request_information">
                          <label for="">Approver Note:</label>
                          <span>
                              {{ $row->approver_note }}
                          </span>
                      </div>
                  </div>
                  <div class="request_department">
                    <div class="request_information start">
                        <label for="">RCT. Breakdown Date:</label>
                        <span>{{ $pre_payment_body_date->created_at }}</span>
                    </div>
                    <div class="request_information">
                      <label for="">Breakdown Note:</label>
                      <span>{{ $row->budget_information_notes }}</span>
                    </div>  
                  </div>            
                </div>
              </div>
            </div>        
          {{-- </form> --}}
        </div>
        <div class='panel-footer'>
          <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'>Cancel</a>
          <input id="close_transaction" type='submit' class='btn btn-primary' name="submit" value='Close'/>
        </div>
        </form>
      </div>
    @endif

<script>
  
  

  // Budget Information Breakdown Computation
  function get_all_sum(){
    let total = 0;
    let remaining_balance = 0;

    $('.budget_amount:not(:eq(1))').each(function(){
      total += parseFloat($(this).val() || 0);
    });

    $('.budget_amount').each(function(){
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
      $('#submit_approve').click(function(){
        $('.brand').attr('disabled', false);
        $('.location').attr('disabled', false);
        $('.category').attr('disabled', false);
        $('.account').attr('disabled', false);
      })
      $('#submit_approve').attr('disabled', false);
      $('#submit_approve').removeAttr('title');
    }else {
      $('#remaining_balance').css('color', '#d32f2f');
      $('#submit_approve').attr('title', 'Please ensure that the remaining balance is zero before proceeding.');
      $('#submit_approve').attr('disabled', true);
    }

  }

  function get_sum(row){

    const qty = row.find('.budget_qty').val();
    const value = row.find('.budget_value').val();
    const total = qty * value;
    row.find('.budget_amount').val(total);

    get_all_sum();
  }

  $(document).on('keyup', '.budget_qty', function() {

    let b_description = $(this).parents('.budget');
    get_sum(b_description);
  });

  $(document).on('keyup', '.budget_value', function() {

    let b_description = $(this).parents('.budget');
    get_sum(b_description);
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
  $(document).on('click', '.add_row', function(){
    // $(this).parents().find('.delete_row').css('display', 'inline-block');
    $('.budget_content').eq(0).find('.delete_row').css('display', 'inline-block');
    let clone_budget = $('.budget_content').eq(0).clone().css('box-shadow', '').css('display','');
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

  $(document).on('click', '.add_row_receipt', function(){
    $('.budget_content').eq(0).find('.delete_row').css('display', 'inline-block');
    let clone_budget = $('.budget_content').eq(0).clone().css('box-shadow', '').css('display','');
    // clone_budget.find('input[name="budget_justification[]"]').parents().attr("disabled", 'disabled');
    add_select2(clone_budget);

    $('.budget_content').last().after(clone_budget);
  });

  // Delete Row
  $(document).on('click', '.circ_delete', function(){
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
  $(document).on('click', '.budget', function(){
    $('.budget').css('box-shadow', '');
    $(this).css('box-shadow', 'rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset');
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
        url: '{{ route('department') }}',
        dataType: 'json',
        delay: 250,
        type: 'POST',
        data: function (params) {
        return {
            q: params.term,
            _token: '{!! csrf_token() !!}'
        };
        },
        processResults: function (data) {
        return {
            results: $.map(data, function (item) {
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
        url: '{{ route('sub_department') }}',
        dataType: 'json',
        delay: 250,
        type: 'POST',
        data: function (params) {
        return {
            q: params.term,
            _token: '{!! csrf_token() !!}'
        };
        },
        processResults: function (data) {
        return {
            results: $.map(data, function (item) {
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
  let direct_deposit = $('#mode_of_payment_direct_deposit').find('input').val();
  let check_payment = $('#check_payment').find('input').val();
  let gcash = $('#gcash').find('input').val();
  if(direct_deposit){
    $('#mode_of_payment_direct_deposit').show()
    $('#mode_of_payment_direct_deposit').find('input').attr('required', true);
  }else if(check_payment){
    $('#check_payment').show();
    $('#check_payment').find('input').attr('required', true);
  }else if(gcash){
    $('#gcash').show();
    $('#gcash').find('input').attr('required', true);
  }


  $('#mode_of_payment').select2({
    placeholder: "Select mode of payment",
    dropdownAutoWidth: true,
    width: '100%',
    ajax: {
        url: '{{ route('payment') }}',
        dataType: 'json',
        delay: 250,
        type: 'POST',
        data: function (params) {
        return {
            q: params.term,
            _token: '{!! csrf_token() !!}'
        };
        },
        processResults: function (data) {
        return {
            results: $.map(data, function (item) {
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
  }).on('change', function(){
    let mode_of_payment_val = $('#mode_of_payment').val()
    // Check Payment
    if (mode_of_payment_val == '3'){
      $('#check_payment').show();
      $('#check_payment').find('input').attr('required', true);
      $('#credit_card').hide();
      $('#mode_of_payment_direct_deposit').hide();
      $('#mode_of_payment_direct_deposit').find('input').attr('required', false);
      $('#mode_of_payment_direct_deposit').find('input').val('');
      $('#gcash').hide();
      $('#gcash').find('input').attr('required', false);
      

    // Credit Card
    }else if(mode_of_payment_val == '4'){
      $('#credit_card').show();
      $('#check_payment').hide();
      $('#check_payment').find('input').attr('required', false);
      $('#check_payment').find('input').val('');
      $('#mode_of_payment_direct_deposit').hide();
      $('#mode_of_payment_direct_deposit').find('input').attr('required', false);
      $('#mode_of_payment_direct_deposit').find('input').val('');
      $('#gcash').hide();
      $('#gcash').find('input').attr('required', false);
      $('#gcash').find('input').val('');
      

    // Direct Deposit
    }else if(mode_of_payment_val == '2'){
      $('#mode_of_payment_direct_deposit').show();
      $('#mode_of_payment_direct_deposit').find('input').attr('required', true);
      $('#check_payment').hide();
      $('#check_payment').find('input').attr('required', false);
      $('#check_payment').find('input').val('');
      $('#credit_card').hide();
      $('#gcash').hide();
      $('#gcash').find('input').attr('required', false);
      $('#gcash').find('input').val('');

    // Gcash
    }else if(mode_of_payment_val == '1'){
      $('#gcash').show();
      $('#gcash').find('input').attr('required', true);
      $('#mode_of_payment_direct_deposit').hide();
      $('#mode_of_payment_direct_deposit').find('input').attr('required', false);
      $('#mode_of_payment_direct_deposit').find('input').val('');
      $('#check_payment').hide();
      $('#check_payment').find('input').attr('required', false);
      $('#check_payment').find('input').val('');
      $('#credit_card').hide();
    }else{
      $('#check_payment').hide();
      $('#check_payment').find('input').attr('required', false);
      $('#check_payment').find('input').val('');
      $('#credit_card').hide();
      $('#mode_of_payment_direct_deposit').hide();
      $('#mode_of_payment_direct_deposit').find('input').attr('required', false);
      $('#mode_of_payment_direct_deposit').find('input').val('');
      $('#gcash').hide();
      $('#gcash').find('input').attr('required', false);
      $('#gcash').find('input').val('');

    };
  });

  // End of Mode of Payment

  // Image modal
  $(".modal-trigger").click(function(){
    var imgSrc = $(this).attr('src');
    $(".modal").fadeIn();
    $(".modal-content img").attr("src", imgSrc);
  });

  function add_select2(row){
    row.find(".brand").select2({
      placeholder: "Select Brand",
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
        url: "{{ route('account') }}",
        dataType: "json",
        delay: 250,
        type: "POST",
        data: function (params) {
          return {
            q: params.term,
            category_id: row.find(".category").val(),
            _token: '{!! csrf_token() !!}',
          };
        },
        error: function (error){
          console.log(error);
        },
        processResults: function (data) {
          // console.log($('.budget_content').index(row));
          // data = data.filter(account=>account.account_name!='CASH IN BANK')
          return {
            results: $.map(data, function (item) {
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
    row.find(".category").on("change", function () {
      row.find(".account").val(null).trigger("change"); 
      row.find(".account").empty();
    });
  }

  let budget_length = $('.budget').length;
  for(i=0; i<budget_length; i++){
    add_select2($('.budget').eq(i+1));
  }
  
  $(document).click(function(e) {
    if ($(e.target).is('.modal')) {
      $(".modal").fadeOut();
    }
  });
  // End of Image modal

</script>
@endsection