<!-- First, extends to the CRUDBooster Layout -->
@push('head')
{{-- Jquery --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
{{-- Select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<style>
  .request_content{
    /* margin: 0 50px; */
  }

  .request_content_department{
    width: 100%;
  }
 

  .required{
    color: red;
  }

  .request_department{
    margin-bottom: 10px;
    margin-right: 30px;
    width: 100%;
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

  .budget{
    display: flex;
    justify-content: center;
    height: 100%;
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
    align-items: center;
    overflow-x: auto;
    margin-top: 10px;

  }

  /* .budget:hover{
    box-shadow: rgba(255, 255, 255, 0.2) 0px 0px 0px 1px inset, rgba(0, 0, 0, 0.9) 0px 0px 0px 1px;
  } */

  .budget_description{
    width: 100%;
    margin: 10px 10px;
    height: 100%;
  }

  .budget_description label{
    display: block;
    text-align: center;
    font-size: 15px;
  }

  .budget_description input{
    width: 100%;
    height: 35px;
    text-align: center;
    border-radius: 5px;
    border: 1px solid #aaa;
    outline-color: #007bff;
  }

  .add_row{
    padding: 8px 15px;
    background-color: rgb(32, 120, 208);
    color: white;
    border-radius: 5px;
    border: none;
  }

  .delete_row{
    padding: 8px 15px;
    background-color: rgb(226, 71, 71);
    color: white;
    border-radius: 5px;
    border: none;
  }

  .budget_description_btns{
    position: relative;
    top: 13px;
    border-left: 1px solid #aaa;
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
  }

  .total_amount_content input{
    height: 35px;
    border-radius: 5px;
    outline: none;
    border: 1px solid #aaa;
    text-align: center;
    margin-right: 10px;
  }

  .request_information label{
    font-size: 15px;
    margin-right: 10px;
    width: 150px;
  }

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

  #upload_img{
    padding-top: 5px; 
    border: none;
  }

  #budget_justification{
    text-align: center;
  }
  
</style>
@endpush

@extends('crudbooster::admin_template')



@section('content')
  <!-- Your html goes here -->
    <p class="noprint"><a title="Main Module" href="{{ CRUDBooster::mainpath() }}"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Pre Payment</a></p> 
    <div class='panel panel-default'>
        <div class='panel-heading'>Request Budget</div>
        <div class='panel-body'>
            {{-- <form method='POST' action='{{CRUDBooster::mainpath('add-save')}}'> --}}
            
            {{ csrf_field() }}
            <div class='form-group'>
                <div class="request_content">
                    <div class="flex">
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
                        <div class="request_department">
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
                              <label for="">Project Name</label>
                              <input type="text" value="{{ $budget->project_name }}" name="project_name[]" readonly>
                            </div>
                            <div class="budget_description">
                              <label for="">Budget Category</label>
                              <input type="text" value="{{ $budget->budget_category }}" name="budget_category[]" readonly>
                            </div>
                            <div class="budget_description">
                              <label for="">Budget Description</label>
                              <input type="text" value="{{ $budget->budget_description }}" name="budget_description[]" readonly>
                            </div>
                            <div class="budget_description">
                              <label for="">Location</label>
                              <input type="text" value="{{ $budget->budget_location }}" name="budget_location[]" readonly>
                            </div>
                            <div class="budget_description">
                              <label for="">Amount</label>
                              <input type="number" name="amount[]" value="{{ $budget->budget_amount }}" class="budget_amount" readonly>
                            </div>
                            <div class="budget_description" id="budget_justification">
                              <label for="">Budget Justification</label>
                              {{-- <input type="file" required name="budget_justification[]" accept="image/png, image/gif, image/jpeg" id="upload_img"> --}}
                              <img src="{{ asset('pre_payment/img/'.$budget->budget_justification) }}" alt="No Image Inserted" style="height: 100%; width: 100%;" id="budget_image" class="modal-trigger">
                              <div class="modal">
                                <div class="modal-content">
                                  <img src="" alt="">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endforeach
                    </div>
                    <hr>
                    <div class="total_amount_content">
                        <label for="">Reference Number:</label>
                        <span>{{ $row->reference_number }}</span>
                    </div>
                    <div class="flex">
                      <div class="total_amount_content">
                        <label for="">Requested Amount:</label>
                        <input type="number" id="requested_amount" value="{{ $row->requested_amount }}" readonly>
                      </div>
                      <div class="total_amount_content">
                        <label for="">Total Amount:</label>
                        <input type="number" id="total_amount" value="{{ $row->total_amount }}" readonly>
                      </div>
                      <div class="total_amount_content">
                        <label for="">Balance:</label>
                        <input type="number" id="balance_amount" value="{{ $row->balance_amount }}" readonly>
                      </div>
                    </div>
                    <div class="total_amount_content">
                        <label for="">Status: 
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
                                <span style="color: green; font-style: bold;">Receipt Validation</span>
                            @endif
                            @if ($row->status_id == 5)
                                <span style="color: green; font-style: bold;">Transaction closed</span>
                            @endif
                            @if ($row->status_id == 6)
                                <span style="color: red; font-style: bold;">Rejected</span>
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
                              <label for="">Budget Information:</label>
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
                            <label for="">Budget Approval Date:</label>
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

  function get_sum(){
    var total = 0;
    $('.budget_amount').each(function(){
      var value = parseFloat($(this).val() || 0)
      total += value;
    })     

    $('#total_amount').val(total);   
  }

  $('#req_full_name').on('keyup', function() {
    var val = $(this).val().toLowerCase().replace(/\b[a-z]/g, function(letter) {
          return letter.toUpperCase();
        });
        $(this).val(val);
  });

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

</script>
@endsection