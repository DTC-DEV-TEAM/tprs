@extends('crudbooster::admin_template')
@section('content')

@if(g('return_url'))
	<p class="noprint"><a title='Return' href='{{g("return_url")}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
@else
	<p class="noprint"><a title='Main Module' href='{{CRUDBooster::mainpath()}}'><i class='fa fa-chevron-circle-left '></i> &nbsp; {{trans("crudbooster.form_back_to_list",['module'=>CRUDBooster::getCurrentModule()->name])}}</a></p>       
@endif
<div class='panel panel-default'>
    <div class='panel-heading'>
        Petty Cash Form
    </div>
    <form method='post' id="myform" action='{{CRUDBooster::mainpath('edit-save/'.$Header->id)}}'>
    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <div class='panel-body'>

            <div class="row">                           
                <label class="control-label col-md-2">{{ trans('message.form-label.created_by') }}:</label>
                <div class="col-md-4">
                        <p>{{$Header->requestor_name}}</p>
                </div>

                <label class="control-label col-md-2">{{ trans('message.form-label.created_at') }}:</label>
                <div class="col-md-4">
                        <p>{{$Header->requested_date}}</p>
                </div>
            </div>

            <div class="row">  

                <label class="control-label col-md-2">{{ trans('message.form-label.reference_number') }}:</label>
                <div class="col-md-4">
                        <p>{{$Header->reference_number}}</p>
                </div>

                <label class="control-label col-md-2">{{ trans('message.form-label.status_id') }}:</label>
                <div class="col-md-4">
                        <b>{{$Header->status_name}}</b>
                </div>
            </div>           

            <div class="row">                           
                <label class="control-label col-md-2">{{ trans('message.form-label.department_id') }}:</label>
                <div class="col-md-4">
                        <p>{{$Header->department_name}}</p>
                </div>

                <label class="control-label col-md-2">{{ trans('message.form-label.sub_department_id') }}:</label>
                <div class="col-md-4">
                        <p>{{$Header->sub_department_name}}</p>
                </div>
            </div>
            
            <!--
            <div class="row">                           
                <label class="control-label col-md-2">{{ trans('message.form-label.location_id') }}:</label>
                <div class="col-md-4">
                        <p>{{$Header->store_name}}</p>
                </div>
            </div> -->
            

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
                                width: 100%;">
                                <div class="hack2" style="  display: table-cell;
                                overflow-x: auto;
                                width: 100%;">
                            <table class="table table-bordered" id="requestTable">
                                <tbody id="bodyTable">

                                    <tr class="tbl_header_color dynamicRows">
                                            <th width="15%" class="text-center">{{ trans('message.table.invoice_type_id') }}</th>
                                            <th width="15%" class="text-center">{{ trans('message.table.vat_type_id') }}</th>
                                            <th width="15%" class="text-center">{{ trans('message.table.payment_status_id') }}</th>
                                           
                                            <th width="8%" class="text-center">{{ trans('message.table.si_or_number') }}</th>
                                            <th width="8%" class="text-center">{{ trans('message.table.si_or_date') }}</th>                                            


                                        <th width="20%" class="text-center">{{ trans('message.table.particulars_text') }}</th>
                                        <th width="15%" class="text-center">{{ trans('message.table.brand_id_text') }}</th>

                                        <th width="14%" class="text-center">{{ trans('message.table.location_id_text') }}</th>

                                        <th width="15%" class="text-center">{{ trans('message.table.category_id_text') }}</th>
                                        <th width="15%" class="text-center">{{ trans('message.table.account_id_text') }}</th>
                                        <th width="10%" class="text-center">{{ trans('message.table.currency_id_text') }}</th>
                                        <th width="7%" class="text-center">{{ trans('message.table.quantity_text') }}</th>
                                        <th width="8%" class="text-center">{{ trans('message.table.line_value_text') }}</th>
                                        <th width="15%" class="text-center">{{ trans('message.table.total_value_text') }}</th>
                                       
                                    </tr>


                                    @foreach($Body as $rowresult)
                                        <tr>
                                                <td style="text-align:center" height="10">{{$rowresult->invoice_type_name}}</td>
                                                <td style="text-align:center" height="10">{{$rowresult->vat_type_name}}</td>
                                                <td style="text-align:center" height="10">{{$rowresult->payment_status_name}}</td>  
                                                
                                                <td style="text-align:center" height="10">{{$rowresult->si_or_number}}</td>
                                                <td style="text-align:center" height="10">{{$rowresult->si_or_date}}</td> 

                                            <td style="text-align:center" height="10">{{$rowresult->particulars}}</td>
                                            <td style="text-align:center" height="10">{{$rowresult->brand_name}}</td>

                                            <td style="text-align:center" height="10">{{$rowresult->store_name}}</td>

                                            <td style="text-align:center" height="10">{{$rowresult->category_name}}</td>
                                            <td style="text-align:center" height="10">{{$rowresult->account_name}}</td>
                                            <td style="text-align:center" height="10">{{$rowresult->currency_name}}</td>
                                            <td style="text-align:center" height="10">{{$rowresult->quantity}}</td>
                                            <td style="text-align:center" height="10">{{$rowresult->line_value}}</td>
                                            <td style="text-align:center" height="10">{{$rowresult->total_value	}}</td>                    
                                        </tr>
                                    @endforeach

                                </tbody>

                                <tfoot>

                                    <tr id="tr-table1" class="bottom">


                                        <td colspan="13" align="right"><strong>{{ trans('message.table.total_value_order_text') }}</strong></td>
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
            
            @if($Header->approved_at != null)
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
            @endif


            @if($Header->validated_at != null)
                <hr/>
                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.validated_by') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->validatorlevel}}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.validated_at') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->validated_at}}</p>
                    </div>
                </div>

              <!--  <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.invoice_type_id') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->invoice_type_name}}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.payment_status_id') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->payment_status_name}}</p>
                    </div>
                </div>
                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.vat_type_id') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->vat_type_name}}</p>
                    </div>

                    
                </div> -->
            @endif


            @if($Header->paid_at != null)
                <hr/>
                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.paid_by') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->paidlevel}}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.paid_at') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->paid_at}}</p>
                    </div>
                </div>

                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.paid_date') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->paid_date}}</p>
                    </div>
                </div>

            @endif

        </div>
        <div class='panel-footer'>
            <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.back') }}</a>
        </div>
    </form>

</div>

@endsection