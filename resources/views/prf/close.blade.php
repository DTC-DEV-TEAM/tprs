@extends('crudbooster::admin_template')
@section('content')
@push('head')
<style type="text/css">   
#image_preview {
    display: none;
}

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
    <form method='post' id="myform" action='{{CRUDBooster::mainpath('edit-save/'.$Header->requested_id)}}'  enctype="multipart/form-data">
    <input type="hidden" value="{{csrf_token()}}" name="_token" id="token">
        <div class='panel-body'>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group" >
                        <label class="control-label require">*{{ trans('message.form-label.receipt') }}</label>
                        <div class="input-group date">
                          <!--  <div class="input-group-addon"><i class="fa fa-file-image-o"></i></div> --> 
                            <input type="file" name="close_receipt[]" id="image" class="image" style="width:200px;" required accept="image/*" multiple>
                            <div id="image_preview">
                                <img src="#" id="image-preview" style="width:200px;height:250px;" /><br />
                                <a id="image_remove" href="#">Remove</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr/>

            <div style="overflow-x:auto;">
                <table width="100%">
                    <tr>
                            <td  width="17%"><label>{{ trans('message.form-label.created_by') }}:</label></td>
    
                            <td width="34%"> <p>{{$Header->requestor_name}}</p></td>
    
                            <td width="17%"><label >{{ trans('message.form-label.created_at') }}:</label> </td>
    
                            <td> <p>{{$Header->requested_date}}</p> </td>
    
    
                    </tr>
    
                    <tr>
                        <td  width="17%"><label >{{ trans('message.form-label.reference_number') }}:</label></td>
    
                        <td width="34%"> <p>{{$Header->reference_number}}</p></td>
    
                        <td width="17%"  >
                            <label >{{ trans('message.form-label.receipt') }}:</label>
                        </td>
    
                        <td rowspan="6" >

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
    
                </table>
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
                                width: 100%;">
                                <div class="hack2" style="  display: table-cell;
                                overflow-x: auto;
                                width: 100%;">
                            <table class="table table-bordered" id="requestTable">
                                <tbody id="bodyTable">

                                    <tr class="tbl_header_color dynamicRows">
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


                                        <td colspan="8" align="right"><strong>{{ trans('message.table.total_value_order_text') }}</strong></td>
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

                <hr/>
                <div class="row">                           
                    <label class="control-label col-md-2">{{ trans('message.form-label.printed_by') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->printedlevel}}</p>
                    </div>

                    <label class="control-label col-md-2">{{ trans('message.form-label.printed_at') }}:</label>
                    <div class="col-md-4">
                            <p>{{$Header->printed_at}}</p>
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

            <button class="btn btn-primary pull-right" type="submit" id="btnSubmit"> <i class="fa fa-save" ></i> {{ trans('message.form.new') }}</button>
        </div>
    </form>

</div>

@endsection

@push('bottom')
<script type="text/javascript">

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