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
    <div class="loading" style="display: none;">
      <div class="loading_content">
          <p>Transaction is on process...</p>
      </div>
    </div>
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
                            <img src="{{ asset('pre_payment/img/'.$receipts_img) }}" alt="No Image Inserted" style="height: 75px; width: 49%; display: inline-block; margin-top: 2px;" id="budget_image" class="modal-trigger" loading="lazy">
                          @endif
                        @endforeach
                        <div class="modal">
                          <div class="modal-content">
                            <img src="" alt="" loading="lazy">
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
                <input class="read_only" type="number" id="remaining_balance" value="{{ $row->balance_amount }}" name="remaining_balance" readonly>
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
                <div class="request_information">
                  <label for="">Date Transmitted:</label>
                  <span>{{ date('Y-m-d', strtotime($row->transmit_date)) }}</span>
                  
                </div>
                <div class="request_information">
                    <label for="">Received by:</label>
                    <span>{{ $row->transmit_received_by }}</span>
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
      <input type="status_id" name="status_id" value="{{ $row->status_id }}" style="visibility: hidden;">
    </div>
    </form>
  </div>