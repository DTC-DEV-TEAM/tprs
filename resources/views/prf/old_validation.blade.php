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
        <form action='{{CRUDBooster::mainpath('edit-save/'.$Header->id)}}' method="POST" id="PettyCashApprovalForm" enctype="multipart/form-data">
        <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <input type="hidden" value="" name="approval_action" id="approval_action">
            <div class='panel-body'>

                <div style="overflow-x:auto;">
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
        
                            <td width="17%"  >
                                <label >{{ trans('message.form-label.receipt') }}:</label>
                            </td>
        
                            <td rowspan="5" >

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
                            <td  width="17%"><label >{{ trans('message.form-label.department_id') }}:</label></td>
        
                            <td width="34%"> <p>{{$Header->department_name}}</p></td>
        
                            <td width="17%"> </td>
        
                            <td></td>
                        </tr>
        
                        <tr>
                            <td  width="17%"><label >{{ trans('message.form-label.sub_department_id') }}:</label></td>
        
                            <td width="34%"><p>{{$Header->sub_department_name}}</p></td>
        
                            <td width="17%"> </td>
        
                            <td></td>
                        </tr>
        
                        <tr>
                            <td  width="17%"><label>{{ trans('message.form-label.status_id') }}:</label></td>
        
                            <td width="34%"><b>{{$Header->status_name}}</b></td>
        
                            <td width="17%"> </td>
        
                            <td></td>
                        </tr>
        
        
                        <tr>
                            <td  width="17%"><label>{{ trans('message.form-label.mode_of_payment_id') }}:</label></td>
        
                            <td width="34%">{{$Header->mode_of_payment_name}}</td>
        
                            <td width="17%"> </td>
        
                            <td></td>
                        </tr>
                        
                        
                        @if($Header->mode_of_payment_id == 1)
                        
                        <tr>
                            <td  width="17%"><label>{{ trans('message.form-label.gcash_number') }}:</label></td>
        
                            <td width="34%">{{$Header->gcash_number}}</td>
        
                            <td width="17%"> </td>
        
                            <td></td>
                        </tr>    
                        
                        @elseif($Header->mode_of_payment_id == 2)
                        <tr>
                            <td  width="17%"><label>{{ trans('message.form-label.bank_name') }}:</label></td>
        
                            <td width="34%">{{$Header->bank_name}}</td>
        
                            <td width="17%"><label>{{ trans('message.form-label.bank_branch_name') }}:</label></td>
        
                            <td>{{$Header->bank_branch_name}}</td>
                        </tr>       
                        
                        <tr>
                            <td  width="17%"><label>{{ trans('message.form-label.bank_account_name') }}:</label></td>
        
                            <td width="34%">{{$Header->bank_account_name}}</td>
        
                            <td width="17%"><label>{{ trans('message.form-label.bank_account_number') }}:</label></td>
        
                            <td>{{$Header->bank_account_number}}</td>
                        </tr>  
                        
                        @elseif($Header->mode_of_payment_id == 3)
                        <tr>
                            <td  width="17%"><label>{{ trans('message.form-label.payee_name') }}:</label></td>
        
                            <td width="34%">{{$Header->payee_name}}</td>
        
                            <td width="17%"><label></label></td>
        
                            <td></td>
                        </tr>       
                        @else
                          <tr>
                            <td  width="17%"><label></label></td>
        
                            <td width="34%"><P style="background-color: #3c8dbc; color:white; width: 70%;  text-align: center;">PLEASE COORDINATE TO ACCOUNTING MANAGER</P>  </td>
        
                            <td width="17%"><label></label></td>
        
                            <td></td>
                        </tr>           
                        
                        @endif
                        
                    </table>
                </div>

                <hr/>
                
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.invoice_number') }}</label>
                            <input type="text" class="form-control"  id="invoice_number" name="invoice_number"  required >   
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label require">*{{ trans('message.form-label.invoice_date') }}</label>
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type='input' name='invoice_date' id="datepicker" onkeydown="return false" required  autocomplete="off"  class='form-control' placeholder="yyyy-mm-dd"  />     
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
                                        <option value="{{$data->id}}">{{$data->interco_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                </div>

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
                                    width: 160%;">
                                    <div class="hack2" style="  display: table-cell;
                                    overflow-x: auto;
                                    width: 160%;">
                                <table class="table table-bordered" id="requestTable">
                                    <tbody id="bodyTable">

                                        <tr class="tbl_header_color dynamicRows">
                                            <th width="11%" class="text-center">{{ trans('message.table.invoice_type_id') }}</th>
                                            <th width="11%" class="text-center">{{ trans('message.table.vat_type_id') }}</th>
                                            <th width="11%" class="text-center">{{ trans('message.table.payment_status_id') }}</th>
                                           <!-- <th width="15%" class="text-center">{{ trans('message.table.product_id') }}</th> -->

                                            <th width="20%" class="text-center">{{ trans('message.table.particulars_text') }}</th>
                                            <th width="10%" class="text-center">{{ trans('message.table.brand_id_text') }}</th>

                                            <th width="14%" class="text-center">{{ trans('message.table.location_id_text') }}</th>

                                            <th width="10%" class="text-center">{{ trans('message.table.category_id_text') }}</th>
                                            <th width="30%" class="text-center">{{ trans('message.table.account_id_text') }}</th>
                                            <th width="5%" class="text-center">{{ trans('message.table.currency_id_text') }}</th>
                                            <th width="7%" class="text-center">{{ trans('message.table.quantity_text') }}</th>
                                            <th width="8%" class="text-center">{{ trans('message.table.line_value_text') }}</th>
                                            <th width="10%" class="text-center">{{ trans('message.table.total_value_text') }}</th>
                                        </tr>


                                        @foreach($Body as $rowresult)
                                            <input type="hidden"  class="form-control"  name="item_id[]"  required  value="{{$rowresult->id}}">
                                            <tr>
                                                <td style="text-align:center" height="10">
                                                    <select class="form-control select2" style="width: 100%;" required name="invoice_type_id[]" id="invoice_type_id">
                                                        <option value="">-- {{ trans('message.form-label.invoice_type_id') }} --</option>
                                                        @foreach($InvoiceType as $data)
                                                            <option value="{{$data->id}}">{{$data->invoice_type_name}}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                </td>
                                                <td style="text-align:center" height="10">
                                                    <select class="form-control select2" style="width: 100%;" required name="vat_type_id[]" id="vat_type_id">
                                                        <option value="">-- {{ trans('message.form-label.vat_type_id') }} --</option>
                                                        @foreach($VatType as $data)
                                                            <option value="{{$data->id}}">{{$data->vat_type_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td style="text-align:center" height="10">
                                                    <select class="form-control select2" style="width: 100%;" required name="payment_status_id[]" id="payment_status_id">
                                                        <option value="">-- {{ trans('message.form-label.payment_status_id') }} --</option>
                                                        @foreach($PaymentStatus as $data)
                                                            <option value="{{$data->id}}">{{$data->payment_status_name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" class="form-control quantity text-center"  id="product_id" step="any" name="product_id[]" min="0" required maxlength="100" value="000">
                                                </td>
                                               <!-- <td style="text-align:center" height="10">
                                                    <input type="number" class="form-control quantity text-center"  id="product_id" step="any" name="product_id[]" min="0" required maxlength="100" value="000">
                                                </td> -->
                                                <td style="text-align:center" height="10">{{$rowresult->particulars}}</td>
                                                <td style="text-align:center" height="10">{{$rowresult->brand_name}}</td>

                                                <td style="text-align:center" height="10">{{$rowresult->store_name}}</td>


                                                <td style="text-align:center" height="10">{{$rowresult->category_name}}</td>
                                                <td style="text-align:center" height="10">
                                                    
                                                    <!-- {{$rowresult->account_name}} -->
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
                                                <td style="text-align:center" height="10">{{$rowresult->currency_name}}</td>
                                                <td style="text-align:center" height="10">{{$rowresult->quantity}}</td>
                                                <td style="text-align:center" height="10">{{$rowresult->line_value}}</td>
                                                <td style="text-align:center" height="10">{{$rowresult->total_value	}}</td>                    
                                            </tr>
                                        @endforeach

                                    </tbody>

                                    <tfoot>

                                        <tr id="tr-table1" class="bottom">


                                            <td colspan="11" align="right"><strong>{{ trans('message.table.total_value_order_text') }}</strong></td>
                                            <td align="center" colspan="1">
                                                <b>{{ $Header->total_value_order }}</b>
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
               
                <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save" ></i> {{ trans('message.form.new') }}</button>
            </div>
        </form>
</div>
@endsection

@push('bottom')
<script type="text/javascript">

  function preventBack() {
    window.history.forward();
  }
  window.onunload = function() {
    null;
  };
  setTimeout("preventBack()", 0);

  $( "#datepicker" ).datepicker( { maxDate: 0, dateFormat: 'yy-mm-dd' } );
  



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