@extends('crudbooster::admin_template')
@section('content')

@push('head')
    <style>
         /* Select2 */
        .select2 {
            height: 35px;
            border: 1px solid #aaa;
        }
        /* End of Select2 */

        .input-group-addon{
            border: 1px solid #aaa !important;
        }
        
        /* Required */
        .required{
            color: red;
        }
        /* End of Required */

        table{
            border: 1px solid #ddd !important;
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

            <div class="row">                           
                <div class="col-md-6">
                    {{-- <p>{{$Header->department_name}}</p> --}}
                    <div class="form-group">
                        <label class="control-label">{{ trans('message.form-label.department_id') }}</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                            <select class="form-control select2" required name="sub_department_id" id="sub_department_id" disabled>
                                <option value="">-- Select Sub Department --</option>
                                @foreach($department as $data)
                                    <option {{ $Header->department_name == $data->department_name ? 'selected' : ''}}  value="{{$data->id}}">{{$data->department_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    {{-- <p>{{$Header->sub_department_name}}</p> --}}
                    <div class="form-group">
                        <label class="control-label">{{ trans('message.form-label.sub_department_id') }}</label>
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-sticky-note"></i></div>
                            <select class="form-control select2" required name="sub_department_id" id="sub_department_id" disabled>
                                <option value="">-- Select Sub Department --</option>
                                @foreach($sub_department as $data)
                                    {{-- <option {{ $Header->subdepartment_name == $data->sub_department_name ? 'selected' : ''}}  value="{{$data->id}}">{{$data->sub_department_name}}</option> --}}
                                    <option {{ $Header->sub_department_name == $data->sub_department_name ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->sub_department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">                           
                <label class="control-label col-md-3">{{ trans('message.form-label.created_by') }}:</label>
                <div class="col-md-3">
                        <p>{{$Header->requestor_name}}</p>
                </div>

                <label class="control-label col-md-3">{{ trans('message.form-label.created_at') }}:</label>
                <div class="col-md-3">
                        <p>{{$Header->requested_date}}</p>
                </div>
            </div>

            <div class="row">  
                <label class="control-label col-md-3">{{ trans('message.form-label.reference_number') }}:</label>
                <div class="col-md-3">
                        <p>{{$Header->reference_number}}</p>
                </div>

                <label class="control-label col-md-3">{{ trans('message.form-label.status_id') }}:</label>
                <div class="col-md-3">
                        <b>{{$Header->status_name}}</b>
                </div>
            </div>   

            <div class="row">
                <label class="control-label col-md-3">Need by Date:</label>
                <div class="col-md-3">
                        <p>{{$Header->need_by_date}}</p>
                </div>

                <label class="control-label col-md-3">{{ trans('message.table.note') }}:</label>
                <div class="col-md-3">
                    <p>{{ $Header->requestor_comments }}</p>
                </div>
            </div>

            <hr>

            <div class="row">

                <div class="col-md-12">
                    <div class="box-header text-center">
                    <h3 class="box-title"><b>{{ trans('message.form-label.items') }}</b></h3>
                    </div>
                        <div class="box-body no-padding">
                            <div class="table-responsive" >
                                <div class="container-fluid" style="padding-left: 0; padding-right: 0;">
                                <div class="hack1" style=" display: table; table-layout: fixed; width: 100%;">
                                <div class="hack2" style=" display: table-cell; overflow-x: auto;"> 
                                <table class="table" id="requestTable" style=" background-color: rgb(255, 250, 250); width: 100%;
                                border-collapse: collapse; box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;">
                                    <tbody id="bodyTable">

                                    <tr class="tbl_header_color dynamicRows" style="font-size: 15px;">
                                        <th width="15%" class="text-center">{{ trans('message.table.particulars_text') }}</th>
                                        <th width="10%" class="text-center">{{ trans('message.table.brand_id_text') }}</th>

                                        <th width="12%" class="text-center">{{ trans('message.table.location_id_text') }}</th>

                                        <th width="12%" class="text-center">{{ trans('message.table.category_id_text') }}</th>
                                        <th width="15%" class="text-center">{{ trans('message.table.account_id_text') }}</th>
                                        <th width="11.5%" class="text-center">{{ trans('message.table.currency_id_text') }}</th>
                                        <th width="7%" class="text-center">{{ trans('message.table.quantity_text') }}</th>
                                        <th width="7%" class="text-center">{{ trans('message.table.line_value_text') }}</th>
                                        <th width="7%" class="text-center">{{ trans('message.table.total_value_text') }}</th>
                                        {{-- <th width="" class="text-center">{{ trans('message.table.action') }}</th> --}}
                                    </tr>


                                    @foreach($Body as $rowresult)
                                        <tr>
                                            {{-- <td style="text-align:center; border: 1px solid #ddd;" height="10">{{$rowresult->particulars}}</td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">{{$rowresult->brand_name}}</td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">{{$rowresult->store_name}}</td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">{{$rowresult->category_name}}</td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">{{$rowresult->account_name}}</td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">{{$rowresult->currency_name}}</td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">{{$rowresult->quantity}}</td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">{{$rowresult->line_value}}</td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">{{$rowresult->total_value	}}</td>                     --}}
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">
                                            <input type="text" class="form-control itemDesc" value="{{$rowresult->particulars}}" style="border-radius: 5px; text-align: center; min-width: 215px;" readonly></td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">
                                            <input type="text" class="form-control itemDesc" value="{{$rowresult->brand_name}}" style="text-align: center; min-width: 127px;" readonly>
                                            </td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">
                                            <input type="text" class="form-control itemDesc" value="{{$rowresult->store_name}}" style="text-align: center; min-width: 210px;" readonly>                                          
                                            </td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">
                                            <input type="text" class="form-control itemDesc" value="{{$rowresult->category_name}}" style="text-align: center; min-width: 160px;" readonly> 
                                            </td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">
                                            <input type="text" class="form-control itemDesc" value="{{$rowresult->account_name}}" style="text-align: center; min-width: 245px;" readonly> 
                                            </td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">
                                            <input type="text" class="form-control itemDesc" value="{{$rowresult->currency_name}}" style="text-align: center; min-width: 100px;" readonly> 
                                            </td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">
                                            <input type="text" class="form-control itemDesc" value="{{$rowresult->quantity}}" style="border-radius: 5px; text-align: center; min-width: 50px;" readonly>
                                            </td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">
                                            <input type="text" class="form-control itemDesc" value="{{$rowresult->line_value}}" style="border-radius: 5px; text-align: center; min-width: 50px;" readonly>
                                            </td>
                                            <td style="text-align:center; border: 1px solid #ddd;" height="10">
                                            <input type="text" class="form-control itemDesc" value="{{$rowresult->total_value}}" style="border-radius: 5px; text-align: center; min-width: 50px;" readonly>
                                            </td>                    
                                        </tr>
                                    @endforeach

                                </tbody>

                                <tfoot>

                                    <tr id="tr-table1" class="bottom">


                                        <td colspan="7" align="right"><strong>{{ trans('message.table.total_value_order_text') }}</strong></td>
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
        
            </div>

            <div class="row">  
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('message.table.comments') }}:</label>
                        <textarea placeholder="{{ trans('message.table.comments') }} ..." rows="3" class="form-control" name="approver_comments">{{$Header->approver_comments}}</textarea>
                    </div>
                </div>
            </div>

            </div>

            <div class='panel-footer'>
                <a href="{{ CRUDBooster::mainpath() }}" class="btn btn-default">{{ trans('message.form.cancel') }}</a>
               
                <button class="btn btn-danger pull-right" type="button" id="btnReject" style="margin-left: 5px;"><i class="fa fa-thumbs-down" ></i> Reject</button>
                <button class="btn btn-success pull-right" type="button" id="btnApprove"><i class="fa fa-thumbs-up" ></i> Approve</button>
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

  $('#btnApprove').click(function() {

        var strconfirm = confirm("Are you sure you want to approve this request?");
        if (strconfirm == true) {

            $(this).attr('disabled','disabled');
            $('#approval_action').val('1');
            $('#PettyCashApprovalForm').submit(); 
            
        }else{
            return false;
            window.stop();
        }

    });

    $('#btnReject').click(function() {

        var strconfirm = confirm("Are you sure you want to reject this request?");
        if (strconfirm == true) {

            $(this).attr('disabled','disabled');
            $('#approval_action').val('0');
            $('#PettyCashApprovalForm').submit(); 
            
        }else{
            return false;
            window.stop();
        }
        
    });


</script>
@endpush