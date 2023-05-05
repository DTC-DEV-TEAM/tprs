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
    width: 35%;
    margin-bottom: 10px;
    margin-right: 30px;

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

  .mode_of_payment_dropdown{
    width: 35%;
  }

  .mode_of_payment_dropdown label{
    display: block;
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
    background-color: #363e4732;
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
    padding: 10px;
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
    height: 100px;
    box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
    align-items: center;
    overflow-x: auto;
    margin-top: 10px;
  }

  /* .budget:hover{
    box-shadow: rgba(255, 255, 255, 0.2) 0px 0px 0px 1px inset, rgba(0, 0, 0, 0.9) 0px 0px 0px 1px;
  } */

  .budget_description{
    width: 14.4%;
    margin: 0px 10px;

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
    width: 130px;
  }

  .total_amount_content input{
    height: 35px;
    border-radius: 5px;
    outline: none;
    border: 1px solid #aaa;
    text-align: center;
  }

</style>
@endpush

@extends('crudbooster::admin_template')


@section('content')
  <!-- Your html goes here -->
  <p class="noprint"><a title="Main Module" href="{{ CRUDBooster::mainpath() }}"><i class="fa fa-chevron-circle-left "></i> &nbsp; Back To List Data Pre Payment</a></p> 
  <div class='panel panel-default'>
    <div class='panel-heading'>Request Cash Advance</div>
    <div class='panel-body'>
      {{-- <form method='POST' action='{{CRUDBooster::mainpath('add-save')}}'> --}}
        <form method="POST" action="{{ route('add_request') }}" autocomplete="off">
        {{ csrf_field() }}
        <div class='form-group'>
          <div class="request_content">
            <div class="flex">
              <div class="request_department">
                <label for="">Department <span class="required">*</span></label>
                <select class="js-example-basic-single" name="department" class="department" id="req_department" required>
                </select>   
                </div>       
                <div class="request_department sub_dpt" style="display: none;">
                  <label for="">Sub Department <span class="required">*</span></label>
                  <select class="js-example-basic-single" name="sub_department" class="department" id="sub_department" required>
                  </select>                           
                </div>   
            </div>
            <div class="requestor_name">
              <label for="">Requestor Full Name <span class="required">*</span></label>
              <input type="text" id="req_full_name" name="full_name" required>
            </div>
            <div class="requestor_name">
              <label for="">Mode of Payment <span class="required">*</span></label>
              <select class="js-example-basic-single" id="mode_of_payment" name="mode_of_payment" required>
              </select>            
            </div>
            <div class="mode_of_payment_dropdown">
              <div class="mode_of_payment_content" id="check_payment" style="display: none;">
                <label for="">Payee Name <span class="required">*</span></label>
                <input type="text" name="payee_name">   
              </div>
              <div class="mode_of_payment_content" id="credit_card" style="display: none;">
                <label for="">Note  <span class="required">*</span></label>
                <input type="text" placeholder="PLEASE COORDINATE TO ACCOUNTING MANAGER" disabled>   
              </div>
              <div class="mode_of_payment_content" id="gcash" style="display: none;">
                <label for="">Gcash#  <span class="required">*</span></label>
                <input type="text" name="gcash_number">   
              </div>
              <div id="mode_of_payment_direct_deposit" style="display: none;">
                <div class="flex mode_of_payment_input">
                  <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                    <label for="">Bank Name  <span class="required">*</span></label>
                    <input type="text" name="bank_name" oninput="this.value = this.value.toUpperCase()">   
                  </div>
                  <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                    <label for="">Bank Branch Name  <span class="required">*</span></label>
                    <input type="text" name="bank_branch_name">   
                  </div>
                </div>
                <div class="flex" style="margin-top: 10px;">
                  <div class="mode_of_payment_content direct_deposit" style="margin-right: 5px;">
                    <label for="">Bank Account Name  <span class="required">*</span></label>
                    <input type="text" name="bank_account_name">   
                  </div>
                  <div class="mode_of_payment_content direct_deposit" style="margin-left: 5px;">
                    <label for="">Bank Account Number  <span class="required">*</span></label>
                    <input type="text" name="bank_account_number">   
                  </div>
                </div>
              </div>
            </div>
            <hr>
            <div class="total_amount_content">
              <label for=""><span class="required">*</span> Request Amount:</label>
              <input type="number" id="total_amount" name="requested_amount" value="0" min="1" required>
            </div>
            <div class="additional_notes">
              <label for="">Comment: </label>
              <textarea name="additional_notes" id="additional_notes" required></textarea>
            </div>
          </div>
        </div>        
      {{-- </form> --}}
    </div>
    <div class='panel-footer'>
      <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'>Cancel</a>
      <input type='submit' class='btn btn-primary' value='Request'/>
    </div>
    </form>
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
                      console.log(item);
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
  }).on('change', function (e) {

      $('.sub_dpt').show();
      var departmentId = e.target.value;
      if (!departmentId) {
          $('#sub_department').empty().trigger('change');
          return;
      }
      // load the sub_department select2 options based on the selected department
      $('#sub_department').empty().select2({
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
                      department_id: departmentId,
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

</script>
@endsection