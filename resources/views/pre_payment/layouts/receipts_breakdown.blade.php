  <style>
    .typewriter {
      --blue: #5C86FF;
      --blue-dark: #275EFE;
      --key: #fff;
      --paper: #EEF0FD;
      --text: #D3D4EC;
      --tool: #FBC56C;
      --duration: 3s;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 9999;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4); /* add a semi-transparent background */
    }

    .typewriter_middle{
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }


    .typewriter .slide {
      width: 92px;
      height: 20px;
      border-radius: 3px;
      margin-left: 14px;
      transform: translateX(14px);
      background: linear-gradient(var(--blue), var(--blue-dark));
      -webkit-animation: slide05 var(--duration) ease infinite;
      animation: slide05 var(--duration) ease infinite;
    }

    .typewriter .slide:before, .typewriter .slide:after,
    .typewriter .slide i:before {
      content: "";
      position: absolute;
      background: var(--tool);
    }

    .typewriter .slide:before {
      width: 2px;
      height: 8px;
      top: 6px;
      left: 100%;
    }

    .typewriter .slide:after {
      left: 94px;
      top: 3px;
      height: 14px;
      width: 6px;
      border-radius: 3px;
    }

    .typewriter .slide i {
      display: block;
      position: absolute;
      right: 100%;
      width: 6px;
      height: 4px;
      top: 4px;
      background: var(--tool);
    }

    .typewriter .slide i:before {
      right: 100%;
      top: -2px;
      width: 4px;
      border-radius: 2px;
      height: 14px;
    }

    .typewriter .paper {
      position: absolute;
      left: 24px;
      top: -26px;
      width: 40px;
      height: 46px;
      border-radius: 5px;
      background: var(--paper);
      transform: translateY(46px);
      -webkit-animation: paper05 var(--duration) linear infinite;
      animation: paper05 var(--duration) linear infinite;
    }

    .typewriter .paper:before {
      content: "";
      position: absolute;
      left: 6px;
      right: 6px;
      top: 7px;
      border-radius: 2px;
      height: 4px;
      transform: scaleY(0.8);
      background: var(--text);
      box-shadow: 0 12px 0 var(--text), 0 24px 0 var(--text), 0 36px 0 var(--text);
    }

    .typewriter .keyboard {
      width: 120px;
      height: 56px;
      margin-top: -10px;
      z-index: 1;
      position: relative;
    }

    .typewriter .keyboard:before, .typewriter .keyboard:after {
      content: "";
      position: absolute;
    }

    .typewriter .keyboard:before {
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      border-radius: 7px;
      background: linear-gradient(135deg, var(--blue), var(--blue-dark));
      transform: perspective(10px) rotateX(2deg);
      transform-origin: 50% 100%;
    }

    .typewriter .keyboard:after {
      left: 2px;
      top: 25px;
      width: 11px;
      height: 4px;
      border-radius: 2px;
      box-shadow: 15px 0 0 var(--key), 30px 0 0 var(--key), 45px 0 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 10px 0 var(--key), 37px 10px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 10px 0 var(--key);
      -webkit-animation: keyboard05 var(--duration) linear infinite;
      animation: keyboard05 var(--duration) linear infinite;
    }

    @keyframes bounce05 {
      85%, 92%, 100% {
        transform: translateY(0);
      }

      89% {
        transform: translateY(-4px);
      }

      95% {
        transform: translateY(2px);
      }
    }

    @keyframes slide05 {
      5% {
        transform: translateX(14px);
      }

      15%, 30% {
        transform: translateX(6px);
      }

      40%, 55% {
        transform: translateX(0);
      }

      65%, 70% {
        transform: translateX(-4px);
      }

      80%, 89% {
        transform: translateX(-12px);
      }

      100% {
        transform: translateX(14px);
      }
    }

    @keyframes paper05 {
      5% {
        transform: translateY(46px);
      }

      20%, 30% {
        transform: translateY(34px);
      }

      40%, 55% {
        transform: translateY(22px);
      }

      65%, 70% {
        transform: translateY(10px);
      }

      80%, 85% {
        transform: translateY(0);
      }

      92%, 100% {
        transform: translateY(46px);
      }
    }

    @keyframes keyboard05 {
      5%, 12%, 21%, 30%, 39%, 48%, 57%, 66%, 75%, 84% {
        box-shadow: 15px 0 0 var(--key), 30px 0 0 var(--key), 45px 0 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 10px 0 var(--key), 37px 10px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 10px 0 var(--key);
      }

      9% {
        box-shadow: 15px 2px 0 var(--key), 30px 0 0 var(--key), 45px 0 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 10px 0 var(--key), 37px 10px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 10px 0 var(--key);
      }

      18% {
        box-shadow: 15px 0 0 var(--key), 30px 0 0 var(--key), 45px 0 0 var(--key), 60px 2px 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 10px 0 var(--key), 37px 10px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 10px 0 var(--key);
      }

      27% {
        box-shadow: 15px 0 0 var(--key), 30px 0 0 var(--key), 45px 0 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 12px 0 var(--key), 37px 10px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 10px 0 var(--key);
      }

      36% {
        box-shadow: 15px 0 0 var(--key), 30px 0 0 var(--key), 45px 0 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 10px 0 var(--key), 37px 10px 0 var(--key), 52px 12px 0 var(--key), 60px 12px 0 var(--key), 68px 12px 0 var(--key), 83px 10px 0 var(--key);
      }

      45% {
        box-shadow: 15px 0 0 var(--key), 30px 0 0 var(--key), 45px 0 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 2px 0 var(--key), 22px 10px 0 var(--key), 37px 10px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 10px 0 var(--key);
      }

      54% {
        box-shadow: 15px 0 0 var(--key), 30px 2px 0 var(--key), 45px 0 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 10px 0 var(--key), 37px 10px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 10px 0 var(--key);
      }

      63% {
        box-shadow: 15px 0 0 var(--key), 30px 0 0 var(--key), 45px 0 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 10px 0 var(--key), 37px 10px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 12px 0 var(--key);
      }

      72% {
        box-shadow: 15px 0 0 var(--key), 30px 0 0 var(--key), 45px 2px 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 10px 0 var(--key), 37px 10px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 10px 0 var(--key);
      }

      81% {
        box-shadow: 15px 0 0 var(--key), 30px 0 0 var(--key), 45px 0 0 var(--key), 60px 0 0 var(--key), 75px 0 0 var(--key), 90px 0 0 var(--key), 22px 10px 0 var(--key), 37px 12px 0 var(--key), 52px 10px 0 var(--key), 60px 10px 0 var(--key), 68px 10px 0 var(--key), 83px 10px 0 var(--key);
      }
    }
  </style>
  <div class="budget_content" style="display: none;">
    <div class="budget_block">
      <div class="circ_delete">
        <i class="fa fa-close"></i>
      </div>
      <div class="budget">
        <div class="budget_description">
          <label for="">Description</label>
          <input class="input_description" type="text"  name="description[]" oninput="this.value = this.value.toUpperCase()" required>
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
    <div class='panel-heading'>Receipts Validation</div>
    {{-- <div class="loading" style="display: none;">
      <div class="loading_content">
          <p>Transaction is on process...</p>
      </div>
    </div> --}}
    <div class="typewriter" style="display: none;">
      <div class="typewriter_middle">
        <div class="slide"></div>
        <div class="paper"></div>
        <div class="keyboard"></div>    
        <h4 style="position: absolute; left: -58px; width: 260px; color: white; font-weight: bold;">TRANSACTION IS ON PROCESS...</h4>
      </div>
    </div>
    <form method="POST" action="{{CRUDBooster::mainpath('edit-save/'.$row->id)}}" enctype="multipart/form-data" id="receipts_validation">
      <div class='panel-body'>
        {{ csrf_field() }}
        <div class='form-group'>
          <div class="request_content">
            <div class="receipts_per_department">
              <div class="receipts_request_department">
                  <label for="">Department</label>
                  <div class="select_with_icon">
                    <i class="fa fa-sticky-note select_icon"></i>
                    <select class="js-example-basic-single" name="department" class="department" id="req_department" disabled required>
                        <option selected value="{{ $department->id }}">{{ $department->department_name }}</option>
                    </select>   
                  </div>
              </div>       
              <div class="receipts_request_department">
                  <label for="">Sub Department</label>
                  <div class="select_with_icon">
                    <i class="fa fa-sticky-note select_icon"></i>
                    <select class="js-example-basic-single" name="sub_department" class="department" id="sub_department" disabled required>
                        <option value="{{ $sub_department->id }}" selected>{{ $sub_department->sub_department_name }}</option>
                    </select>  
                  </div>                         
              </div>   
              <div class="receipts_request_department r_full_name">
                  <label for="">Requestor Full Name</label>
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
                      <label for="">Released Date:</label>
                      {{-- <span>{{ $row->accounting_date_release }}</span> --}}
                      @if(!is_null($row->accounting_date_release))
                        <span>{{ date('Y-m-d', strtotime($row->accounting_date_release)) }}</span>
                      @endif
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
                    <input type="number" name="value[]" min="0" value="0" class="budget_value" required>
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