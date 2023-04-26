<!-- First, extends to the CRUDBooster Layout -->
@push('head')
{{-- Jquery --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
{{-- Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>

  .request_content{
    width: 100%;
  }
/* 
  .request_content_department{
    width: 100%;
  } */

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
  /* background-color: rgba(0,0,0,0.5);  */
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

  input{
    background-color: #eeeeee;
  }

  /* End of Receipts Validation */
</style>

@endpush

@extends('crudbooster::admin_template')



@section('content')
  <!-- Your html goes here -->
    <p class="noprint"><a title="Main Module" href="{{ CRUDBooster::mainpath() }}"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Pre Payment</a></p> 
    <div class='panel panel-default'>
        <div class='panel-heading'>Cash Advance View Request</div>
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
                      <p>Budget Information Breakdown</p>
                    </div>
                    <div class="budget_content">
                      @foreach ($pre_payment_body as $budget)
                        <div class="budget_block">
                          <div class="budget">
                            <div class="budget_description">
                              <label for="">Description</label>
                              <input class="input_description" type="text"  value="{{ $budget->description }}" name="description[]" disabled>
                            </div>
                            <div class="budget_description">
                              <label for="">Brand</label>
                              <select class="js-example-basic-single brand" name="brand[]" disabled>
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
                              <select class="js-example-basic-single location" name="location[]" disabled>
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
                              <select class="js-example-basic-single category" name="category[]" disabled>
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
                              <select class="js-example-basic-single account" name="account[]" disabled>
                                    <option value="{{ $budget->account_id }}" selected="selected">{{ $budget->account_name }}</option>
                              </select>
                            </div>
                            <div class="budget_description">
                              <label for="">Currency</label >
                              <select class="js-example-basic-single currency" name="currency[]" disabled>
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
                              <input type="number" name="qty[]" min="0" class="budget_qty" value="{{ $budget->qty }}" disabled>
                            </div>
                            <div class="budget_description">
                              <label for="">Value</label >
                              <input type="number" name="value[]" min="0" class="budget_value" value="{{ $budget->value }}" disabled>
                            </div>
                            <div class="budget_description">
                              <label for="">Total Value</label >
                              <input type="number" name="amount[]" min="0" class="budget_amount" value="{{ $budget->amount }}" id="cash_in_bank_total_value" disabled>
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
                          </div>
                        </div>
                      @endforeach
                    </div>
                    <hr>
                    <div class="receipts_amount_contents">
                      <div class="total_amount_content receipts_total_amount">
                        <label for="">Reference Number:</label>
                        <input style="border: none; background-color: #fff;" value="{{ $row->reference_number }}" readonly>
                      </div>
                      @if (CRUDBooster::myPrivilegeName() != 'Requestor')
                        <div class="total_amount_content receipts_total_amount">
                          <label for="">Cheque Date:</label>
                          <input style="border: none; background-color: #fff;" value="{{ date('Y-m-d', strtotime($row->check_date)) }}" readonly>
                        </div>
                        <div class="total_amount_content receipts_total_amount">
                          <label for="">BEACH pre-payment#:</label>
                          <input style="border: none; background-color: #fff;" value="{{ $row->system_reference_number }}" readonly>
                        </div>
                        <div class="total_amount_content receipts_total_amount">
                          <label for="">AR reference#:</label>
                          <input style="border: none; background-color: #fff;" value="{{ $row->ar_reference_number }}" readonly>
                        </div>
                      @endif
                    </div>
                    <div class="receipts_amount_contents">
                      <div class="total_amount_content receipts_total_amount">
                        <label for="">Requested Amount:</label>
                        <input type="number" id="requested_amount" value="{{ $row->requested_amount }}" readonly>
                      </div>
                      <div class="total_amount_content receipts_total_amount">
                        <label for="">Used Amount:</label>
                        <input type="number" id="total_amount" value="{{ $row->total_amount }}" name="total_amount" readonly>
                      </div>
                      <div class="total_amount_content receipts_total_amount">
                        <label for="">Unused Amount:</label>
                        <input type="number" id="unused_amount" value="{{ $row->unused_amount }}" name="unused_amount" readonly>
                      </div>
                      <div class="total_amount_content receipts_total_amount">
                        <label for="">Remaining Balance:</label>
                        <input type="number" id="remaining_balance" value="{{ $row->balance_amount }}" name="remaining_blance" readonly>
                      </div>
                    </div>
                    <div class="total_amount_content">
                        <span style="font-weight: bold; font-size: 15px;" for="">Status: 
                            @if ($row->status_id == 1)
                                <span style="color: green; font-style: bold;">Requesting</span>
                            @endif
                            @if ($row->status_id == 2)
                                <span style="color: green; font-style: bold;">Approved</span>
                            @endif
                            @if ($row->status_id == 3)
                                <span style="color: green; font-style: bold;">Budget Justification</span>
                            @endif
                            @if ($row->status_id == 4)
                                <span style="color: green; font-style: bold;">Receipts Validation</span>
                            @endif
                            @if ($row->status_id == 5)
                                <span style="color: green; font-style: bold;">Transaction closed</span>
                            @endif
                            @if ($row->status_id == 6)
                                <span style="color: red; font-style: bold;">Rejected</span>
                            @endif
                            @if ($row->status_id == 7)
                                <span style="color: red; font-style: bold;">AP Recording</span>
                            @endif
                        </label>
                    </div>
                    <hr>
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
                            <label for="">Approval Date:</label>
                            <span>{{ $row->accounting_date_release }}</span>
                        </div>
                        <div class="request_information">
                            <label for="">Accounting Name:</label>
                            <span>{{ $row->accounting_name }}</span>
                        </div>
                        <div class="request_information">
                            <label for="">Accounting Note:</label>
                            <span>
                                {{ $row->accounting_note }}
                            </span>
                        </div>
                      </div>
                  </div>
                  <div class="flex">
                    <div class="request_department">
                      <div class="request_information start">
                          <label for="">Date Closed:</label>
                          <span>{{ $row->accounting_closed_date }}</span>
                      </div>
                      <div class="request_information">
                          <label for="">Closed By:</label>
                          <span>{{ $row->accounting_closed_by }}</span>
                      </div>
                      <div class="request_information">
                          <label for="">Closed Note:</label>
                          <span>
                              {{ $row->accounting_closed_note }}
                          </span>
                      </div>
                    </div>
                  </div>
                </div>
            </div>        
        </div>
        <div class='panel-footer'>
            <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'>Cancel</a>
        </div>
    </div>

<script>

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
      $('#submit_approve').click(function(){
        $('.brand').attr('disabled', false);
        $('.location').attr('disabled', false);
        $('.category').attr('disabled', false);
        $('.account').attr('disabled', false);
      })
      $('#submit_approve').attr('disabled', false);
      $('#submit_approve').removeAttr('title');
    } else {
      $('#submit_approve').attr('title', 'Please ensure that the remaining balance is zero before proceeding.');
      $('#submit_approve').attr('disabled', true);
    }

  }

  $('#req_full_name').on('keyup', function() {
    var val = $(this).val().toLowerCase().replace(/\b[a-z]/g, function(letter) {
          return letter.toUpperCase();
        });
        $(this).val(val);
  });

  // Add Row
  $(document).on('click', '.add_row', function(){
    $('.budget').eq(0).find('.delete_row').css('display', 'inline-block');
    let clone_budget = $('.budget').eq(0).clone().css('box-shadow', '');
    clone_budget.find('input').val('');
    clone_budget.find('.delete_row');
    $(this).parents('.budget').after(clone_budget);
  });

  $(document).on('click', '.delete_row', function(){
    $(this).parents('.budget').remove();

    if($('.budget').length == 1){
      $('.budget').find('.delete_row').eq(0).css('display', 'none');
    }
    get_sum();
  })

  $(document).on('click', '.budget', function(){
    $('.budget').css('box-shadow', '');
    $(this).css('box-shadow', 'rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset');
  })

  $(document).on('click', function(event) {
    if (!$(event.target).closest('.budget').length) {
      $('.budget').css('box-shadow', '');
    }
  });

  $(document).on('keyup', '.budget_amount', function() {
    var total = 0;
    get_sum();
  });

  // Select Department
  $('#req_department').select2({
    placeholder: "Select a department",
    dropdownAutoWidth: true,
    width: '100%',
    ajax: {
        url: '{{ route('department') }}',
        dataType: 'json',
        // contentType: "application/json; charset=utf-8",
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
        // contentType: "application/json; charset=utf-8",
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
            console.log(item.id)
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
  });

    function add_select2(row){
    row.find(".brand").select2({
      placeholder: "Select Brand",
      width: '150px',
    })

    row.find(".location").select2({
      placeholder: "Select Location",
      width: '150px',
    })

    row.find(".category").select2({
      placeholder: "Select Category",
      width: '150px',
    });

    row.find(".currency").select2({
      placeholder: "Currency",
      width: '120px',
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
      $(".account").val(null).trigger("change"); 
      $(".account").empty();
    });
  }

  let budget_length = $('.budget').length;
  for(i=0; i<budget_length; i++){
    add_select2($('.budget').eq(i));
  }

  // Image modal
  $(".modal-trigger").click(function(){
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

</script>
@endsection