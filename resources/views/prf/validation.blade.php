@extends('crudbooster::admin_template')
@section('content')
@push('head')
<style type="text/css">  
* {box-sizing: border-box}
.mySlides1, .mySlides2 {display: none}
img {vertical-align: middle;}

/* Slideshow container */
.slideshow-container {
  max-width: 800px;
  position: relative;
  margin: auto;
}

/* Next & previous buttons */
.prev, .next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -22px;
  color: black;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a grey background color */
.prev:hover, .next:hover {
  background-color: #f1f1f1;
  color: black;
}
</style>
@endpush
@if(g('return_url'))
	<p class="noprint"><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
@else
	<p class="noprint"><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
@endif

<div class='panel panel-default'>
    <div class='panel-heading'>
        Petty Cash Form
    </div>
        <form action='{{CRUDBooster::mainpath('edit-save/'.$Header->id)}}' method="POST" id="PettyCashForm" enctype="multipart/form-data">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="hidden" value="{{$Header->mode_of_payment_id}}" name="mode" id="mode">
            <div class='panel-body'>

                <table width="100%">
                        <tr>
                                <td  width="17%"><label>{{ trans('message.form-label.created_by') }}:</label></td>
        
                                <td width="34%"> <p>{{$Header->requestor_name}}</p></td>
        
                                <td width="17%"><label >{{ trans('message.form-label.created_at') }}:</label> </td>
        
                                <td> <p>{{$Header->created_at}}</p> </td>
        
        
                        </tr>

                        <tr>
                                <td  width="17%"><label >{{ trans('message.form-label.reference_number') }}:</label></td>
        
                                <td width="34%"> <p>{{$Header->reference_number}}</p></td>
        
                                <td width="17%"><label >{{ trans('message.form-label.status_id') }}:</label> </td>
        
                                <td> <p>{{$Header->status_name}}</p> </td>
        
        
                        </tr>

                </table>

                <hr />


                <table width="100%">

                    <tr>
                        <!-- 
                        <td width="55%">
                            
                               <div class="form-group">
                                    <label class="control-label require">*{{ trans('message.form-label.location_id') }}</label>
                                    <div class="input-group date">
                                        <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                        <select class="form-control select2" style="width: 90%;" required name="location_id" id="location_id">
                                            <option value="">-- Select Location --</option>
                                            @foreach($Location as $data)

                                                @if($Header->location_id == $data->id)
                                                        <option value="{{$data->id}}" selected>{{$data->store_name}}</option>
                                                    @else
                                                        <option value="{{$data->id}}" >{{$data->store_name}}</option>
                                                @endif

                                               
                                            @endforeach

                                        </select>
                                    </div>
                                </div>                       
                        </td> -->
                        

                        <td width="55%">
                            

                        </td>

                        <td rowspan="5" style="vertical-align: top;" >

                                <!--
                                <label class="control-label require">{{ trans('message.form-label.receipt') }}</label>
                               

                                  <input type="file" name="receipt[]" id="image" class="image" style="width: 100%;"   accept="application/pdf,image/*" multiple> -->
                                    
                                    @if(strpos( $Header->receipt , '.pdf'))
                                        @foreach(explode('|', $Header->receipt) as $info)
                                        
                                                <embed  style="margin-top:30px; border: 2px solid #ddd;" src="{{asset("$info")}}" width="500" height="400" />
                                                
                                        @endforeach
                                    @else
                                                        
                    

                                        <div class="slideshow-container"  style="border: 2px solid #ddd;" >
                                            @foreach(explode('|', $Header->receipt) as $infos)
                                                <div class="mySlides1" >
                                                    <img src="{{asset("$infos")}}" style="width:100%;height:400px;">
                                                </div>
                                            @endforeach
                                            
                                            <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                                            <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
                                        </div>  
                                
                                
                                    @endif
                                    
                                
                            
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.department_id') }}</label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                        <select class="form-control select2" style="width: 90%;" required name="department_id" id="department_id">
                                            <!--<option value="">-- Select Department --</option>-->
                                            @foreach($Departments as $data)

                                                @if($Header->department_id == $data->id)
                                                        <option value="{{$data->id}}"  selected >{{$data->department_name}}</option>
                                                    @else
                                                        <option value="{{$data->id}}" >{{$data->department_name}}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                </div>
                            </div>                                
                        </td>
                    </tr>

                    <tr>
                        <td>

                            <?php   $sub_departmentID = $Header->sub_department_id; ?>

                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.sub_department_id') }}</label>
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                        <select class="form-control select2" style="width: 90%;" required name="sub_department_id" id="sub_department_id">
                                         
                                        </select>
                                </div>
                            </div>                               
                        </td>

                        <td>
                            
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.requestor_name') }}</label>
                                <input type="text" class="form-control"  id="requestor_name" name="requestor_name"  required style="width: 90%;" value="{{$Header->requestor_name}}">                                   
                            </div>                               
                        </td>

                        <td>
                            
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.mode_of_payment_id') }}</label>
                           
                                <select class="form-control select2" style="width: 90%;" required name="mode_of_payment_id" id="mode_of_payment_id">
                                    <option value="">-- Select Mode Of Payment --</option>
                                    @foreach($ModeOfPayments as $data)

                                        @if($Header->mode_of_payment_id == $data->id)
                                                <option value="{{$data->id}}"  selected >{{$data->mode_of_payment_name}}</option>
                                            @else
                                                <option value="{{$data->id}}" >{{$data->mode_of_payment_name}}</option>
                                        @endif

                                        

                                    @endforeach
                                </select>
                                 
                            </div>     
                            <br>                             
                        </td>

                        <td>

                        </td>
                    </tr>

                   
                    <tr id="bank_details_1">
                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.bank_name') }}</label>
                                <input type="text" class="form-control"  id="bank_name" name="bank_name" value="{{$Header->bank_name}}" required style="width: 90%;">                                   
                            </div>                                
                        </td>

                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.bank_branch_name') }}</label>
                                <input type="text" class="form-control"  id="bank_branch_name" name="bank_branch_name" value="{{$Header->bank_branch_name}}" required style="width: 90%;">                                   
                            </div>  
                        </td>
                    </tr>

                    <tr id="bank_details_2">

                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.bank_account_name') }}</label>
                                <input type="text" class="form-control"  id="bank_account_name" name="bank_account_name" value="{{$Header->bank_account_name}}"  required style="width: 90%;">                                   
                            </div>                                
                        </td>

                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.bank_account_number') }}</label>
                                <input type="text" class="form-control"  id="bank_account_number" name="bank_account_number" value="{{$Header->bank_account_number}}" required style="width: 90%;">                                   
                            </div>  
                        </td>

                    </tr>


                    <tr id="gcash_div">

                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.gcash_number') }}</label>
                                <input type="text" class="form-control"  id="gcash_number" name="gcash_number" value="{{$Header->gcash_number}}" required style="width: 90%;">                                   
                            </div>                                
                        </td>

                    </tr>


                    <tr id="check_payment_div">

                        <td>
                            <div class="form-group">
                                <label class="control-label require">*{{ trans('message.form-label.payee_name') }}</label>
                                <input type="text" class="form-control"  id="payee_name" name="payee_name"  value="{{$Header->payee_name}}" required style="width: 90%;">                                   
                            </div>                                
                        </td>

                    </tr>


                    <tr id="credit_card_div">

                        <td>
                            <div class="form-group" >
                                <label class="control-label require">*{{ trans('message.form-label.credit_card') }}:</label>
                               <P style="background-color: #3c8dbc; color:white; width: 90%;  text-align: center;">PLEASE COORDINATE TO ACCOUNTING MANAGER</P>                                   
                            </div>                                
                        </td>

                    </tr>
                 

                </table>

                <hr/>
                
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.invoice_number') }}</label>
                            <input type="text" class="form-control"  id="invoice_number" name="invoice_number"  required  value="{{$Header->invoice_number}}">   
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.invoice_date') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type='input' name='invoice_date' id="datepicker" onkeydown="return false" required  autocomplete="off"  class='form-control' placeholder="yyyy-mm-dd"  value="{{$Header->invoice_date}}"/>     
                            </div>
                        </div>

                    </div>

                </div> 

                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.interco_id') }}</label>
                            
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                                <select class="form-control select2"  required name="interco_id" id="interco_id">
                                    <option value="">-- {{ trans('message.form-label.interco_id') }} --</option>
                                    @foreach($Interco as $data)
                                        

                                                @if($Header->interco_id == $data->id)
                                                        <option value="{{$data->id}}" selected>{{$data->interco_name}}</option>
                                                    @else
                                                        <option value="{{$data->id}}">{{$data->interco_name}}</option>
                                                @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                </div>

                    <hr/>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="box-header text-center">
                            <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <div class="container">
                                        <div class="hack1" style="  display: table;
                                        table-layout: fixed;
                                        width: 200%;">
                                        <div class="hack2" style="  display: table-cell;
                                        overflow-x: auto;
                                        width: 200%;"> 
                                        <table class="table table-bordered" id="requestTable" style="  width: 200%;
                                        border-collapse: collapse;">
                                        <tbody id="bodyTable">

                                            <tr class="tbl_header_color dynamicRows">

                                                <th width="8%" class="text-center">{{ trans('message.table.invoice_type_id') }}</th>
                                                <th width="7%" class="text-center">{{ trans('message.table.vat_type_id') }}</th>
                                                <th width="7%" class="text-center">{{ trans('message.table.payment_status_id') }}</th>
                                                <!-- <th width="15%" class="text-center">{{ trans('message.table.product_id') }}</th> -->

                                                <th width="15%" class="text-center">{{ trans('message.table.particulars_text') }}</th>
                                                <th width="10%" class="text-center">{{ trans('message.table.brand_id_text') }}</th>

                                                <th width="14%" class="text-center">{{ trans('message.table.location_id_text') }}</th>

                                                <th width="10%" class="text-center">{{ trans('message.table.category_id_text') }}</th>
                                                <th width="12%" class="text-center">{{ trans('message.table.account_id_text') }}</th>
                                                <th width="4%" class="text-center">{{ trans('message.table.currency_id_text') }}</th>
                                                <th width="4%" class="text-center">{{ trans('message.table.quantity_text') }}</th>
                                                <th width="5%" class="text-center">{{ trans('message.table.line_value_text') }}</th>
                                                <th width="5%" class="text-center">{{ trans('message.table.total_value_text') }}</th>
                                               
                                            </tr>

                                            <tr id="tr-table">
                                                 <?php   $tableRow = 1; ?>
                                                <tr>
                                                    @foreach($Body as $rowresult)

                                                        <?php   $tableRow++; ?>

                                                        <tr>

                                                        <td style="text-align:center" height="10">
                                                            <select class="form-control select2" style="width: 100%;" required name="invoice_type_id[]" id="invoice_type_id">
                                                                <option value="">-- {{ trans('message.form-label.invoice_type_id') }} --</option>
                                                                @foreach($InvoiceType as $data)
                                                                    


                                                                    @if($rowresult->invoice_type_id == $data->id)
                                                                            <option value="{{$data->id}}" selected >{{$data->invoice_type_name}}</option>
                                                                        @else
                                                                            <option value="{{$data->id}}">{{$data->invoice_type_name}}</option>
                                                                    @endif

                                                                @endforeach
                                                                
                                                            </select>
                                                        </td>
                                                        <td style="text-align:center" height="10">
                                                            <select class="form-control select2" style="width: 100%;" required name="vat_type_id[]" id="vat_type_id">
                                                                <option value="">-- {{ trans('message.form-label.vat_type_id') }} --</option>
                                                                @foreach($VatType as $data)
                                                                    

                                                                    @if($rowresult->vat_type_id == $data->id)

                                                                            <option value="{{$data->id}}" selected>{{$data->vat_type_name}}</option>

                                                                        @else
                                                                            <option value="{{$data->id}}">{{$data->vat_type_name}}</option>
                                                                    @endif

                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td style="text-align:center" height="10">
                                                            <select class="form-control select2" style="width: 100%;" required name="payment_status_id[]" id="payment_status_id">
                                                                <option value="">-- {{ trans('message.form-label.payment_status_id') }} --</option>
                                                                @foreach($PaymentStatus as $data)
                                                                    

                                                                    @if($rowresult->payment_status_id == $data->id)

                                                                        <option value="{{$data->id}}" selected>{{$data->payment_status_name}}</option>

                                                                    @else
                                                                        <option value="{{$data->id}}">{{$data->payment_status_name}}</option>
                                                                    @endif
                                                                    
                                                                @endforeach

                                                            </select>
                                                            <input type="hidden" class="form-control quantityNew text-center"  id="product_id" step="any" name="product_id[]" min="0" required maxlength="100" value="000">
                                                        </td>                 

                                                            <td >
                                                                <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="{{$tableRow}}" id="itemDesc{{$tableRow}}"  name="particulars[]"  required maxlength="100" value="{{$rowresult->particulars}}">
                                                            </td>



                                                            <td>
                                                                <select class="form-control" name="brand_id[]" id="brand_id" required>
                                                                    <option value="">-Please Select Brand-</option>
                                                                        @foreach($Brands as $data)
                                                                            @if($rowresult->brand_id == $data->id)
                                                                                    <option selected value="{{$data->id}}">{{$data->brand_name}}</option>
                                                                                @else
                                                                                    <option value="{{$data->id}}">{{$data->brand_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                </select> 
                                                            </td>

                                                            <td>

                                                                <select class="form-control" name="location_id[]" id="location_id" required>
                                                                  <option value="">- Select Location -</option>
                                                                        @foreach($Location as $data)

                                                                            @if($rowresult->location_id == $data->id)
                                                                                    <option value="{{$data->id}}" selected>{{$data->store_name}}</option>
                                                                                @else
                                                                                    <option value="{{$data->id}}">{{$data->store_name}}</option>
                                                                            @endif 

                                                                        @endforeach
                                                                </select>

                                                            </td>

                                                            <td>
                                                                <select class="form-control drop"  data-id="{{$tableRow}}" name="category_id[]" id="category_id" required>
                                                                            <option value="">-Please Select Category-</option>
                                                                        @foreach($Categories as $data)
                                                                            @if($rowresult->category_id == $data->id)
                                                                                    <option selected value="{{$data->id}}">{{$data->category_name}}</option>
                                                                                @else
                                                                                    <option value="{{$data->id}}">{{$data->category_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                </select>
                                                            </td>

                                                            <td>
                                                                <input type="hidden"  class="form-control"  name="item_id[]"  required  value="{{$rowresult->id}}">
                                                                <input type="hidden"  class="form-control"  name="item_action[]" id="item_action{{$rowresult->id}}"  required  value="EDIT">
                                                                
                                                                <select class="form-control account{{$tableRow}}" name="account_id[]" id="account_id" required>
                                                                    <option value="">-Please Select Account-</option>
                                                                        @foreach($Accounts->where('category_id', $rowresult->category_id) as $data)
                                                                            @if($rowresult->account_id == $data->id)
                                                                                    <option selected value="{{$data->id}}">{{$data->account_name}}</option>
                                                                                @else
                                                                                    <option value="{{$data->id}}">{{$data->account_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                </select>                                                           
                                                            </td>



                                                            <td>
                                                                <select class="form-control valcurrency" name="currency_id[]" id="currency_id" required>
                                                                    <option value="">-Please Select Brand-</option>
                                                                        @foreach($Currencies as $data)
                                                                            @if($rowresult->currency_id == $data->id)
                                                                                    <option selected value="{{$data->id}}">{{$data->currency_name}}</option>
                                                                                @else
                                                                                    <option value="{{$data->id}}">{{$data->currency_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                </select> 
                                                            </td>

                                                            <td>
                                                                <input type="number" class="form-control quantity text-center" data-id="{{$tableRow}}" id="quantity{{$tableRow}}" step="any" name="quantity[]" min="0" required maxlength="100" value="{{$rowresult->quantity}}">
                                                            </td>   
                                                            
                                                            <td>
                                                                <input type="number" class="form-control vvalue text-center" data-id="{{$tableRow}}" id="value{{$tableRow}}" name="line_value[]" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" required maxlength="100" value="{{$rowresult->line_value}}">
                                                            </td>

                                                            <td>
                                                                <input type="text" class="form-control totalV text-center" id="totalValue{{$tableRow}}" name="total_value[]" readonly="readonly" step="0.01" required maxlength="100" value="{{$rowresult->total_value}}">
                                                            </td>

                                                                               
                                                        </tr>
                                                    @endforeach
                                
                                                </tr>
                                                
                                            </tr>

                                        </tbody>

                                        <tfoot>

                                            <tr id="tr-table1" class="bottom">

                                                <td>
                                                
                                                </td>

                                                <td colspan="10" align="right"><strong>{{ trans('message.table.total_value_order_text') }}</strong></td>
                                                <td align="left" colspan="1">
                                                    <input type='text' name="total_value_order" class="form-control text-center" id="tValue2" readonly value="{{$Header->total_value_order}}"></td>
                                                </td>
                                               
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
                                <label>{{ trans('message.table.note') }}:</label>
                                <p>{{ $Header->requestor_comments }}</p>
                            </div>
                        </div>
                
                    </div>

                    <hr/>

                    <div class="row">                           
                        <label class="control-label col-md-2">{{ trans('message.form-label.approved_by') }}:</label>
                        <div class="col-md-4">
                                <p>{{$Header->approverlevel}}</p>
                        </div>

                        <label class="control-label col-md-2">{{ trans('message.form-label.approved_at') }}:</label>
                        <div class="col-md-4">
                                <p>{{$Header->approved_at}}</p>
                        </div>
                    </div>

                    <div class="row">  
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ trans('message.table.approver_comments') }}:</label>
                                <p>{{ $Header->approver_comments }}</p>
                            </div>
                        </div>
                    </div>
                    

            </div>

            <div class='panel-footer'>
                <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>
                <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save" ></i> {{ trans('message.form.save') }}</button>
            </div>
        </form>
</div>
@endsection

@push('bottom')
<script type="text/javascript">
    
var sub_departmentID = <?php echo json_encode($sub_departmentID); ?>;

$('#department_id').change(function() {
    
    var department = $('#department_id').val();
    

    //var id_data = $(this).attr("data-id");

   // $('.account'+id_data).prop("disabled", false);



    $.ajax
    ({ 
        url: "{{ URL::to('/subdepartment')}}",
        type: "POST",
        data: {
            'department': department,
            _token: '{!! csrf_token() !!}'
            },
            
         
             
        success: function(result)
        {
            
     
     
            var i;
            var showData = [];

            for (i = 0; i < result.length; ++i) {
                var j = i + 1;
                showData[i] = "<option value='"+result[i].id+"'>"+result[i].sub_department_name+"</option>";
            }
            //$('.account'+id_data).find('option').remove();
            //jQuery('.account'+id_data).html(showData);          
            
            jQuery('#sub_department_id').html(showData);
        }
        
       
    });

}); 

$( "#datepicker" ).datepicker( { maxDate: 0, dateFormat: 'yy-mm-dd' } );

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

$('#mode_of_payment_id').change(function(){

    if(this.value == 1){
        $('#bank_details_1, #bank_details_2').hide();
        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').removeAttr('required');
    
        $('#check_payment_div').hide();
        $('#payee_name').removeAttr('required');

        $('#credit_card_div').hide();

        $('#gcash_div').show();
        $('#gcash_number').attr('required', 'required');

    }else if(this.value == 2){

        $('#gcash_div').hide();
        $('#gcash_number').removeAttr('required');

        $('#check_payment_div').hide();
        $('#payee_name').removeAttr('required');

        $('#credit_card_div').hide();

        $('#bank_details_1, #bank_details_2').show();
        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').attr('required', 'required');
    }else if(this.value == 3){
        $('#bank_details_1, #bank_details_2').hide();
        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').removeAttr('required');

        $('#gcash_div').hide();
        $('#gcash_number').removeAttr('required');

        $('#credit_card_div').hide();

        $('#check_payment_div').show();
        $('#payee_name').attr('required', 'required');

    }else if(this.value == 4){


        $('#bank_details_1, #bank_details_2').hide();
        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').removeAttr('required');

        $('#gcash_div').hide();
        $('#gcash_number').removeAttr('required');

        $('#check_payment_div').hide();
        $('#payee_name').removeAttr('required');


        $('#credit_card_div').show();
    }else{

        $('#bank_details_1, #bank_details_2').hide();
        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').removeAttr('required');

        $('#gcash_div').hide();
        $('#gcash_number').removeAttr('required');

        $('#check_payment_div').hide();
        $('#payee_name').removeAttr('required');


        $('#credit_card_div').hide();

        }

    });


if($('#mode_of_payment_id').val() == 1){
        $('#bank_details_1, #bank_details_2').hide();
        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').removeAttr('required');
    
        $('#check_payment_div').hide();
        $('#payee_name').removeAttr('required');

        $('#credit_card_div').hide();

        $('#gcash_div').show();
        $('#gcash_number').attr('required', 'required');

    }else if($('#mode_of_payment_id').val() == 2){

        $('#gcash_div').hide();
        $('#gcash_number').removeAttr('required');

        $('#check_payment_div').hide();
        $('#payee_name').removeAttr('required');

        $('#credit_card_div').hide();

        $('#bank_details_1, #bank_details_2').show();
        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').attr('required', 'required');
    }else if($('#mode_of_payment_id').val() == 3){
        $('#bank_details_1, #bank_details_2').hide();
        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').removeAttr('required');

        $('#gcash_div').hide();
        $('#gcash_number').removeAttr('required');

        $('#credit_card_div').hide();

        $('#check_payment_div').show();
        $('#payee_name').attr('required', 'required');

    }else if($('#mode_of_payment_id').val() == 4){


        $('#bank_details_1, #bank_details_2').hide();
        $('#bank_name, #bank_branch_name, #bank_account_name, #bank_account_number').removeAttr('required');

        $('#gcash_div').hide();
        $('#gcash_number').removeAttr('required');

        $('#check_payment_div').hide();
        $('#payee_name').removeAttr('required');


        $('#credit_card_div').show();
    }

  function preventBack() {
    window.history.forward();
  }
  window.onunload = function() {
    null;
  };
  setTimeout("preventBack()", 0);


  var tableRow = <?php echo json_encode($tableRow); ?>;
  $(document).ready(function() {


    $("#add-Row").click(function() {
      tableRow++;
      var newrow = '<tr>' +
        '<td>' +
        '  <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control itemDesc" data-id="' + tableRow + '" id="itemDesc' + tableRow + '"  name="particulars_add[]"  required maxlength="100">' +
        '</td>' +

        '<td>'+
            '<select class="form-control" name="brand_id_add[]" id="brand_id_add" required>' +
            '  <option value="">-Please Select Brand-</option>' +
            '        @foreach($Brands as $data)'+
            '        <option value="{{$data->id}}">{{$data->brand_name}}</option>'+
            '         @endforeach'+
            '</select>'+   
        '</td>'+

        '<td>'+
            '<select class="form-control drop'+ tableRow + '" name="category_id_add[]" data-id="' + tableRow + '"  id="category_id" required>' +
        '  <option value="">-Please Select Category-</option>' +
        '        @foreach($Categories as $data)'+
        '        <option value="{{$data->id}}">{{$data->category_name}}</option>'+
        '         @endforeach'+
        '</select>'+
        '</td>' +

        '<td>'+
            '<input type="hidden"  class="form-control"  name="add_items"  required  value="0">'+ 
            '<input type="hidden"  class="form-control"  name="item_action[]" id="item_action' + tableRow + '"  required  value="ADD">'+

            '<select class="form-control account'+ tableRow + '" name="account_id_add[]" id="account_id_add" required>' +

            '</select>'+            
        '</td>'+

        '<td>'+
            '<select class="form-control valcurrency" name="currency_id_add[]" id="currency_id_add" required>' +
            '  <option value="">-Please Select Currency-</option>' +
            '        @foreach($Currencies as $data)'+
            '        <option value="{{$data->id}}">{{$data->currency_name}}</option>'+
            '         @endforeach'+
            '</select>'+ 
        '</td>'+



        '<td>' +
        '  <input type="number" class="form-control quantity text-center" data-id="' + tableRow + '" id="quantity' + tableRow + '" step="any" name="quantity_add[]" min="0" required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="number" class="form-control vvalue text-center" data-id="' + tableRow + '" id="value' + tableRow + '" name="line_value_add[]" step="0.01" min="0" onchange="setTwoNumberDecimal(this)" required maxlength="100">' +
        '</td>' +
        '<td>' +
        '  <input type="text" class="form-control totalV text-center" id="totalValue' + tableRow + '" name="total_value_add[]" readonly="readonly" step="0.01" required maxlength="100">' +
        '</td>' +
        '<td>' +


        '<button id="deleteRow" name="removeRow1" class="btn btn-danger removeRow1" data-id="' + tableRow + '" ><i class="glyphicon glyphicon-trash"></i></button>' +
        '</td>' +
        '</tr>';
      $(newrow).insertBefore($('table tr#tr-table1:last'));


      $('.drop'+tableRow).change(function(){
            
            var category = this.value;
            var id_data = $(this).attr("data-id");

            $('.account'+id_data).prop("disabled", false);

            $.ajax
            ({ 
                url: "{{ URL::to('/category')}}",
                type: "POST",
                data: {
                    'category': category,
                    _token: '{!! csrf_token() !!}'
                    },
                success: function(result)
                {
                    var i;
                    var showData = [];

                    showData[0] = "<option value='' selected disabled>-Please Select Account-</option>";
                    for (i = 1; i < result.length; ++i) {
                        var j = i + 1;
                        showData[i] = "<option value='"+result[i].id+"'>"+result[i].account_name+"</option>";
                    }
                    //$('.account'+id_data).find('option').remove();
                    jQuery('.account'+id_data).html(showData);               
                }
            });

        });

    });
    //deleteRow
    $(document).on('click', '.removeRow', function() {

      var RowID = $(this).attr("data-id");
    
      //alert($('#item_action'+RowID).val());

      if($('#item_action'+RowID).val() == "EDIT"){

                    var token = $("#token").val();

                    
                    
                        $.ajax({
                        type: "POST",
                        url: "{{route('delete-prf-request')}}",
                        dataType: "JSON",
                        data: {
                            "_token": token,
                            "row_id": RowID,
                        
                        },
                        success: function(data) {
                            //alert(data);
                        },
                        error: function(xhr, status, error) {
                            //alert(error);
                        }
                        });
      }

      if ($('#requestTable tbody tr').length != 1) { //check if not the first row then delete the other rows

        $(this).closest('tr').remove();
        $("#tQuantity").val(calculateTotalQuantity());
        $("#tValue2").val(calculateTotalValue2());
        return false;
      }


    });



    $(document).on('click', '.removeRow1', function() {

        var RowID = $(this).attr("data-id");

        //alert($('#item_action'+RowID).val());


        if ($('#requestTable tbody tr').length != 1) { //check if not the first row then delete the other rows

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


});

$(document).on('keyup', '.vvalue', function(ev) {

var id = $(this).attr("data-id");
var rate = parseFloat($(this).val());
var qty = $("#quantity" + id).val();
var price = calculatePrice(qty, rate).toFixed(2); // this is for total Value in row

$("#totalValue" + id).val(price);
$("#tQuantity").val(calculateTotalQuantity());
$("#tValue").val(calculateTotalValue());
$("#tValue2").val(calculateTotalValue2());
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

           

            $.ajax
            ({ 
                url: "{{ URL::to('/subdepartment')}}",
                type: "POST",
                data: {
                    'department': department,
                    _token: '{!! csrf_token() !!}'
                    },
                    
                 
                     
                success: function(result)
                {
                    
             
             
                    var i;
                    var showData = [];

                    for (i = 0; i < result.length; ++i) {
                        var j = i + 1;

                        if(sub_departmentID == result[i].id){

                            showData[i] = "<option value='"+result[i].id+"' selected>"+result[i].sub_department_name+"</option>";

                        }else{

                            showData[i] = "<option value='"+result[i].id+"'>"+result[i].sub_department_name+"</option>";

                        }
                          


                    }
                    //$('.account'+id_data).find('option').remove();
                    //jQuery('.account'+id_data).html(showData);          
                    
                    jQuery('#sub_department_id').html(showData);
                }
                
               
            });
});


$("#btnSubmit").click(function(event) {

    var countRow = $('#requestTable tr').length - 4;
    // var value = $('.vvalue').val();
  
    if (countRow == 0) {
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
                if($("#tValue2").val() < 1000 ){
                    //alert("Below 1000 total value is valid !!");
                    alert("Payment Request should not be less than P1,000.00 in value!");
                    event.preventDefault();
                }
        }
    });
    
});


jQuery( document ).delegate('#image', 'change', function() {
    ext = jQuery(this).val().split('.').pop().toLowerCase();
    if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
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
});

function resetFormElement(e) {
    e.wrap('<form>').closest('form').get(0).reset();
    e.unwrap();
}




$('.drop').change(function(){
            
            var category = this.value;
            var id_data = $(this).attr("data-id");

            $('.account'+id_data).prop("disabled", false);

            $.ajax
            ({ 
                url: "{{ URL::to('/category')}}",
                type: "POST",
                data: {
                    'category': category,
                    _token: '{!! csrf_token() !!}'
                    },
                success: function(result)
                {
                    var i;
                    var showData = [];

                    showData[0] = "<option value='' selected disabled>-Please Select Account-</option>";
                    for (i = 1; i < result.length; ++i) {
                        var j = i + 1;
                        showData[i] = "<option value='"+result[i].id+"'>"+result[i].account_name+"</option>";
                    }
                    //$('.account'+id_data).find('option').remove();
                    jQuery('.account'+id_data).html(showData);               
                }
            });

});


var slideIndex = [1,1];
        var slideId = ["mySlides1", "mySlides2"]
        showSlides(1, 0);
        showSlides(1, 1);

        function plusSlides(n, no) {
          showSlides(slideIndex[no] += n, no);
        }

        function showSlides(n, no) {
          var i;
          var x = document.getElementsByClassName(slideId[no]);
          if (n > x.length) {slideIndex[no] = 1}    
          if (n < 1) {slideIndex[no] = x.length}
          for (i = 0; i < x.length; i++) {
             x[i].style.display = "none";  
          }
          x[slideIndex[no]-1].style.display = "block";  
        }


       

</script>
@endpush