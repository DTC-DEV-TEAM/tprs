@extends('crudbooster::admin_template')
@section('content')

<div id='box_main' class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Upload a File</h3>
        <div class="box-tools"></div>
    </div>

    <form method='post' id="form" enctype="multipart/form-data" action="{{ route('upload.fulfillment') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">

            <div class='callout callout-success'>
                <h4>Order Fulfillment Uploader</h4>
                Before uploading a file, please read below instructions : <br/>
                * File format should be : CSV file format<br/>
                
            </div>
            <div class="row">
                <label class='col-sm-1 control-label'>Import Template: </label>
                <div class='col-sm-2'>
                    @if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeName() == "SIM")
                    <a href='{{ CRUDBooster::mainpath() }}/download-fulfillment-template' class="btn btn-primary" role="button">Download DR Template</a><br/><br/>
                    <a href='{{ CRUDBooster::mainpath() }}/download-st-template' class="btn btn-info" role="button">Download ST Template</a><br/><br/>
                    @elseif(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeName() == "MCB")
                    <a href='{{ CRUDBooster::mainpath() }}/download-po-template' class="btn btn-primary" role="button">Download PO Template</a><br/><br/>
                    @endif
                </div>
                
                <label class='col-sm-1 control-label'>Upload Type: </label>
                <div class='col-sm-3'>
                    <select class="form-control select2" style="width: 100%;" required name="upload_type" id="upload_type">
                        <option value="">Select Upload Type</option>
                        @if(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeName() == "SIM")
                        <option value="dr">DR</option>
                        <option value="st">ST</option>
                        @elseif(CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeName() == "MCB")
                        <option value="po">PO</option>
                        @endif
                    </select>
                    
                </div>
                
                <label class='col-sm-1 control-label'>Import Excel File: </label>
                <div class='col-sm-4'>
                    <input type='file' name='import_file' class='form-control' required accept=".csv"/>
                    <div class='help-block'>File type supported only : CSV</div>
                </div>
            </div>
            <div class="row">
                
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <div class='pull-right'>
                <a href='{{ CRUDBooster::mainpath() }}' class='btn btn-default'>Cancel</a>
                <input type='submit' class='btn btn-primary' name='submit' value='Upload'/>
            </div>
        </div><!-- /.box-footer-->
    </form>
</div><!-- /.box -->

@endsection