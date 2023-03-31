<?php namespace App\Http\Controllers;

use Session;
//use Request;
use DB;
use CRUDBooster;
use App\Category;
use App\Department;
use App\SubDepartment;
use App\Store;
use App\ApprovalMatrix;
use App\PRFHeader;
use App\PRFBody;
use App\RequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Excel;
use Carbon\Carbon;
use App\InvoiceType;
use App\PaymentStatus;
use App\VatType;
use App\Users;
use App\Interco;
use App\CustomerLocation;
use App\Account;
use App\Brand;
use App\Channel;
use App\Currency;
use App\ModeOfPayment;

	class AdminPaymentRequestHistoryController extends \crocodicstudio\crudbooster\controllers\CBController {

        public function __construct() {
			// Register ENUM type
			//$this->request = $request;
			DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping("enum", "string");
		}

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "bank_name";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = true;
			$this->button_detail = false;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "prf_header";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Request Status","name"=>"status_id","join"=>"statuses,status_name"];
			$this->col[] = ["label"=>"Reference Number","name"=>"reference_number"];
			//$this->col[] = ["label"=>"Location","name"=>"location_id","join"=>"stores,store_name"];
			$this->col[] = ["label"=>"Department","name"=>"department_id","join"=>"department,department_name"];
			$this->col[] = ["label"=>"Sub Department","name"=>"sub_department_id","join"=>"sub_department,sub_department_name"];
			
			$this->col[] = ["label"=>"Requested By","name"=>"requestor_name"];
			$this->col[] = ["label"=>"Requested Date","name"=>"created_at"];
			$this->col[] = ["label"=>"Approved By","name"=>"approved_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Approved Date","name"=>"approved_at"];
			$this->col[] = ["label"=>"Rejected Date","name"=>"rejected_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			

			

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();
			if(CRUDBooster::isUpdate()) {

				$Validated =  RequestStatus::where('id', 3)->value('id');
				$Printed =  RequestStatus::where('id', 5)->value('id');
				$Paid =  RequestStatus::where('id', 4)->value('id');
				$Closed =  RequestStatus::where('id', 8)->value('id');

				$this->addaction[] = ['title'=>'View','url'=>CRUDBooster::mainpath('getRequestDetail/[id]'),'icon'=>'fa fa-eye'];
			
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestEdit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Validated or [status_id] == $Printed or [status_id] == $Paid or [status_id] == $Closed"];
				
			}

	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();
			if(CRUDBooster::isUpdate())
	        {
				$this->button_selected[] = ['label'=>'Cancel',
											'icon'=>'fa fa-times',
											'name'=>'set_cancel'];
											
				
	        }
	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();
			if (CRUDBooster::getCurrentMethod() == 'getIndex') {
				$this->index_button[] = [
					"title" => "Export",
					"label" => "Export",
					"icon" => "fa fa-download", "url" => CRUDBooster::adminpath('export-prf') . '?' . urldecode(http_build_query(@$_GET))
				];
				
			}


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	        if($button_name == 'set_cancel') {

				$checker = PRFHeader::whereIn('id',	$id_selected)->get();


				

				foreach($checker as $check){

				
						if($check->status_id != 9 ){

							if($check->status_id != 8 ){

								if($check->status_id != 6 ){

									PRFHeader::where('id',	$check->id)->update([
										'status_id'=> 9, 
										'updated_at' => date('Y-m-d H:i:s'), 
										'updated_by' => CRUDBooster::myId()]);

								}

							}

						}
					
				}
				
			}
				            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
			if(CRUDBooster::myPrivilegeName() == "Approver"){

				$Entered =  RequestStatus::where('id', 1)->value('id');

				/*
				$approvalMatrix = ApprovalMatrix::where('approval_matrices.cms_users_id', CRUDBooster::myId())->get();
				$approval_array = array();
				foreach($approvalMatrix as $matrix){
					array_push($approval_array, $matrix->sub_department_id);
				}
				$approval_string = implode(",",$approval_array);
				$SubDepartmentList = array_map('intval',explode(",",$approval_string)); */

				$user_data = Users::where('id', CRUDBooster::myId())->first();

				$query->whereIn('prf_header.department_id', explode(",",$user_data->approver_department_id))
					  ->whereIn('prf_header.sub_department_id', explode(",",$user_data->approver_sub_department_id))
					  //->whereIn('prf_header.customer_location_id', explode(",",$user_data->approver_customer_name_id))
					  ->where('prf_header.status_id','!=', $Entered)
					  ->whereNull('prf_header.deleted_at')
					  ->orderBy('prf_header.id', 'ASC');
			
			} else if(CRUDBooster::myPrivilegeName() == "AP Checker"){

				//$query->whereNotNull('prf_header.validated_by')->whereNull('prf_header.deleted_at')->orderBy('prf_header.id', 'ASC');
				$query->whereNull('prf_header.deleted_at')->orderBy('prf_header.id', 'ASC');
			} else if(CRUDBooster::myPrivilegeName() == "Treasury"){
				$query->whereNotNull('prf_header.paid_by')->whereNull('prf_header.deleted_at')->orderBy('prf_header.id', 'ASC');
			}
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
			$Entered =  RequestStatus::where('id', 1)->value('status_name');
			$Approved =  RequestStatus::where('id', 2)->value('status_name');
			$Validated =  RequestStatus::where('id', 3)->value('status_name');
			$Printed =  RequestStatus::where('id', 5)->value('status_name');
			$Paid =  RequestStatus::where('id', 4)->value('status_name');
			$Rejected =  RequestStatus::where('id', 6)->value('status_name');

			$Closed =  RequestStatus::where('id', 8)->value('status_name');

			$Cancelled =  RequestStatus::where('id', 9)->value('status_name');

			if($column_index == 2){
				if($column_value == $Entered){
					$column_value = '<span class="label label-warning">'.$Entered.'</span>';
				}else if($column_value == $Approved){
					$column_value = '<span class="label label-info">'.$Approved.'</span>';
				}else if($column_value == $Validated){
					$column_value = '<span class="label label-primary">'.$Validated.'</span>';
				}else if($column_value == $Printed){
					$column_value = '<span class="label label-primary">'.$Printed.'</span>';
				}else if($column_value == $Paid){
					$column_value = '<span class="label label-primary">'.$Paid.'</span>';
				}else if($column_value == $Rejected){
					$column_value = '<span class="label label-danger">'.$Rejected.'</span>';
				}else if($column_value == $Closed){
					$column_value = '<span class="label label-success">'.$Closed.'</span>';
				}else if($column_value == $Cancelled){
					$column_value = '<span class="label label-danger">'.$Cancelled.'</span>';
				}
			}

	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here

				$prf_header = PRFHeader::where(['id' => $id])->first();

				$fields = Input::all();
				$customer_location_id 	= $fields['customer_location_id'];
				$department_id 	= $fields['department_id'];
				$sub_department_id 	= $fields['sub_department_id'];
				$location_id 	= $fields['location_id'];
				$total_value_order 	= $fields['total_value_order'];
				$requestor_comments 	= $fields['requestor_comments'];
				$requestor_name 	= $fields['requestor_name'];
				$bank_name 	= $fields['bank_name'];
				$bank_branch_name 	= $fields['bank_branch_name'];
				$bank_account_name 	= $fields['bank_account_name'];
				$bank_account_number 	= $fields['bank_account_number'];
				$gcash_number 	= $fields['gcash_number'];
				$payee_name 	= $fields['payee_name'];
				$mode_of_payment_id 	= $fields['mode_of_payment_id'];
				$interco_id 	= $fields['interco_id'];
				$item_id 		= $fields['item_id'];
				$invoice_type_id 	= $fields['invoice_type_id'];
				$payment_status_id 	= $fields['payment_status_id'];
				$vat_type_id 		= $fields['vat_type_id'];
				$product_id 		= $fields['product_id'];
				
				$invoice_number 		= $fields['invoice_number'];
				$invoice_date 		= $fields['invoice_date'];

				//$requestor_name 	= $fields['requestor_name'];



				$files 	= $fields['receipt'];

				if (!empty($files)) {

					


					ini_set('post_max_size', '64M');
					ini_set('upload_max_filesize', '64M');
					
					//ini_set('post_max_size', '2000M');
					//ini_set('upload_max_filesize', '2000M');
					
					$images=array();
					$counter = 0;
					
						foreach($files as $file){
							$counter++;
							$extension1 =  $counter.time() . '.' .$file->getClientOriginalExtension();
							$filename = $extension1;
							$file->move('vendor/crudbooster/',$filename);
							$images[]='vendor/crudbooster/'.$filename;
						}
		
					$postdata['receipt'] = implode("|",$images);

				}

				$postdata['bank_name'] = $bank_name;
				$postdata['bank_branch_name'] = $bank_branch_name;
				$postdata['bank_account_name'] = $bank_account_name;
				$postdata['bank_account_number'] = $bank_account_number;
				$postdata['gcash_number'] = $gcash_number;
				$postdata['payee_name'] = $payee_name;
				$postdata['mode_of_payment_id'] = $mode_of_payment_id;
				
				$postdata['customer_location_id'] = $customer_location_id;
				$postdata['department_id'] 			= $department_id;
				$postdata['sub_department_id'] 		= $sub_department_id;
				//$postdata['location_id'] 			= $location_id;
				$postdata['total_value_order'] 		= $total_value_order;
				$postdata['requestor_comments'] 	= $requestor_comments;
				$postdata['requestor_name'] 		= $requestor_name;
			
				$postdata['updated_by'] 			= CRUDBooster::myId();
				$postdata['updated_at'] 			= date('Y-m-d H:i:s');	


				$postdata['invoice_number'] 	= $invoice_number;
				$postdata['invoice_date'] 	= $invoice_date;
				
				$postdata['interco_id'] 	= $interco_id;
		
				$postdata['validated_by'] 	= CRUDBooster::myId();
				$postdata['validated_at'] 	= date('Y-m-d H:i:s');

				$account_id 		= $fields['account_id'];

				for($x=0; $x < count((array)$item_id); $x++) {

					PRFBody::where('id', $item_id[$x])
					->update([
						'invoice_type_id' => $invoice_type_id[$x],
						'payment_status_id' => $payment_status_id[$x],
						'vat_type_id'		   => $vat_type_id[$x],
						'account_id'		   => $account_id[$x],
						'product_id'	   => $product_id[$x]
					]);
	
				}



	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

			$fields = Input::all();
			$dataLines = array();

			$prf_header = PRFHeader::where(['id' => $id])->first();

			$item_id		= $fields['item_id'];
			$account_id 	= $fields['account_id'];
			$brand_id 		= $fields['brand_id'];
			$currency_id 	= $fields['currency_id'];
			$category_id 	= $fields['category_id'];
			$particulars 	= $fields['particulars'];
			$quantity 		= $fields['quantity'];
			$line_value 	= $fields['line_value'];
			$total_value 	= $fields['total_value'];
			$location_id 	= $fields['location_id'];

			$add_items 	= $fields['add_items'];

			for($x=0; $x < count((array)$particulars); $x++) {

				PRFBody::where('id', $item_id[$x])
				->update([
					'account_id' => $account_id[$x],
					'brand_id' => $brand_id[$x],
					'category_id' => $category_id[$x],
					'particulars' => $particulars[$x],
					'currency_id' => $currency_id[$x],
					'quantity'		   => $quantity[$x],
					'line_value'	   => $line_value[$x],
					'total_value'	   => $total_value[$x],
					'location_id'	   => $location_id[$x]
				]);

			}





			$customer_location = CustomerLocation::where('id', $prf_header->customer_location_id)->first(); 

			$company = 10;

			//$location = Store::where('id', $prf_header->location_id)->first();

			$department = SubDepartment::where('id', $prf_header->sub_department_id)->value('coa_id');

			

			$interco = Interco::where('id', $prf_header->interco_id)->value('coa_id');

			$Items = PRFBody::where('prf_header_id', $prf_header->id)->get();
 

			foreach($Items as $Item){


				$account = Account::where('id', $Item->account_id)->value('coa_id');

		
				
				$brand = Brand::where('id', $Item->brand_id)->value('coa_id');

				$location = Store::where('id', $Item->location_id)->first();

				$customer = Channel::where('id', $location->channels_id)->value('coa_id');

				$product = $Item->product_id;


				$coa_value = $company.".".$location->coa_id.".".$department.".".$account.".".$customer.".".$brand.".".$product.".".$interco;

				//dd($coa_value);

				PRFBody::where('id', $Item->id)
				->update([
					'coa' => $coa_value,
				]);

			}


			CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_edit_success",['reference_number'=>$prf_header->reference_number]), 'success');


	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 

		public function getRequestDetail($id){
			$this->cbLoader();
            if(!CRUDBooster::isRead() && $this->global_privilege==FALSE) {    
                CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
            }   

			$data = array();


			$data['page_title'] = 'View Payment Request';

			$data['Header'] = PRFHeader::
							  leftjoin('department', 'prf_header.department_id', '=', 'department.id')
							  ->leftjoin('customer', 'prf_header.customer_location_id', '=', 'customer.id')
							  ->leftjoin('sub_department', 'prf_header.sub_department_id', '=', 'sub_department.id')
							  ->leftjoin('stores', 'prf_header.location_id', '=', 'stores.id')
							  ->leftjoin('cms_users as requestor', 'prf_header.created_by','=', 'requestor.id')
							  ->leftjoin('statuses', 'prf_header.status_id','=', 'statuses.id')
							  ->leftjoin('cms_users as approver', 'prf_header.approved_by','=', 'approver.id')
							  ->leftjoin('invoice_type', 'prf_header.invoice_type_id','=', 'invoice_type.id')
							  ->leftjoin('payment_status', 'prf_header.payment_status_id','=', 'payment_status.id')
							  ->leftjoin('vat_type', 'prf_header.vat_type_id','=', 'vat_type.id')
							  ->leftjoin('cms_users as validator', 'prf_header.validated_by','=', 'validator.id')
							  ->leftjoin('cms_users as paidby', 'prf_header.paid_by','=', 'paidby.id')
							  ->leftjoin('cms_users as printed', 'prf_header.printed_by','=', 'printed.id')
							  ->leftjoin('cms_users as closed', 'prf_header.closed_by','=', 'closed.id')
							  ->leftjoin('mode_of_payment', 'prf_header.mode_of_payment_id','=', 'mode_of_payment.id')
							  ->select(
								'department.*',
								'customer.*',
								'sub_department.*',
								'stores.*',
								'requestor.name as requestorlevel',
								'statuses.*',
								'prf_header.*',
								'approver.name as approverlevel',
								'invoice_type.*',
								'payment_status.*',
								'vat_type.*',
								'validator.name as validatorlevel',
								'prf_header.created_at as requested_date',
								'prf_header.id as requested_id',
								'paidby.name as paidlevel',
								'printed.name as printedlevel',
								'mode_of_payment.mode_of_payment_name as mode_of_payment_name',
								'closed.name as closedlevel'
							  )
							  ->where('prf_header.id', $id)->first();

			$data['Body'] = PRFBody::
							  leftjoin('category', 'prf_body.category_id', '=', 'category.id')
							  ->leftjoin('account', 'prf_body.account_id', '=', 'account.id')
							  ->leftjoin('brand', 'prf_body.brand_id', '=', 'brand.id')
							  ->leftjoin('currency', 'prf_body.currency_id', '=', 'currency.id')
							  ->leftjoin('invoice_type', 'prf_body.invoice_type_id','=', 'invoice_type.id')
							  ->leftjoin('payment_status', 'prf_body.payment_status_id','=', 'payment_status.id')
							  ->leftjoin('vat_type', 'prf_body.vat_type_id','=', 'vat_type.id')

							  ->leftjoin('stores', 'prf_body.location_id', '=', 'stores.id')

							  ->select(
								'category.*',
								'account.*',
								'brand.*',
								'currency.*',
								'prf_body.*',
								'invoice_type.*',
								'payment_status.*',
								'stores.*',
								'vat_type.*'
							  )
							  ->where('prf_body.prf_header_id', $id)
							  ->where('prf_body.row_deleted', null)
							  ->get();

							  


			$this->cbView("prf.detail", $data);

		}

		public function getRequestEdit($id){
			$this->cbLoader();
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}

			$data = array();

			$customer_location = array();

			$department_array = array();

			$sub_department_array = array();

			$location_array = array();

			$data['page_title'] = 'Edit Payment Request Form';

			

	
			$data['CustomerLocation'] = CustomerLocation::
										leftjoin('stores', 'customer.location_id', '=', 'stores.id')
							 			->select( 'customer.*', 'stores.id as locationid', 'stores.store_name as location_name')
							 			->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();
										//->whereIn('customer.id', explode(",",$user_data->customer_name_id))->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();

            $data['Location'] = Store::where('store_status', 'ACTIVE')->orderby('store_name', 'ASC')->get();



			$data['Header'] = PRFHeader::
							  leftjoin('department', 'prf_header.department_id', '=', 'department.id')
							  ->leftjoin('sub_department', 'prf_header.sub_department_id', '=', 'sub_department.id')
							  ->leftjoin('stores', 'prf_header.location_id', '=', 'stores.id')
							  ->leftjoin('cms_users as requestor', 'prf_header.created_by','=', 'requestor.id')
							  ->leftjoin('statuses', 'prf_header.status_id','=', 'statuses.id')
							  ->select(
								'department.*',
								'sub_department.*',
								'stores.*',
								'requestor.name as requestorlevel',
								'statuses.*',
								'prf_header.*'
							  )
							  ->where('prf_header.id', $id)->first();

			$data['Body'] = PRFBody::
							  leftjoin('category', 'prf_body.category_id', '=', 'category.id')
							  ->select(
								'category.*',
								'prf_body.*'
							  )
							  ->where('prf_body.prf_header_id', $id)
							  ->where('prf_body.row_deleted', null)
							  ->get();

			$user_data = Users::where('id', $data['Header']->created_by)->first();


			$data['Departments'] = Department::whereIn('id', explode(",",$user_data->department_id))->where('status', 'ACTIVE')->orderby('department_name', 'ASC')->get();
			
			$data['SubDepartments'] = SubDepartment::whereIn('id', explode(",",$user_data->sub_department_id))->where('status', 'ACTIVE')->orderby('sub_department_name', 'ASC')->get();


			$data['Categories'] = category::where('status', 'ACTIVE')->orderby('category_name', 'ASC')->get();

			$data['Accounts'] = Account::where('status', 'ACTIVE')->orderby('account_name', 'ASC')->get();
				  
			$data['Brands'] = Brand::where('status', 'ACTIVE')->orderby('brand_name', 'ASC')->get();
				  
			$data['Currencies'] = Currency::where('status', 'ACTIVE')->orderby('currency_name', 'ASC')->get();
				  
			$data['ModeOfPayments'] = ModeOfPayment::where('status', 'ACTIVE')->orderby('mode_of_payment_name', 'ASC')->get();

			$data['Interco'] = Interco::where('status', 'ACTIVE')->orderby('interco_name', 'ASC')->get();
			$data['InvoiceType'] = InvoiceType::where('status', 'ACTIVE')->orderby('invoice_type_name', 'ASC')->get();
			$data['PaymentStatus'] = PaymentStatus::where('status', 'ACTIVE')->orderby('payment_status_name', 'ASC')->get();
			$data['VatType'] = VatType::where('status', 'ACTIVE')->orderby('vat_type_name', 'ASC')->get();

			$this->cbView("prf.edit_history", $data);

		}
		

		public function HistoryExport()
		{
	
			$filename = 'PRF - ' . date("d M Y - h.i.sa");
			$sheetname = 'PRF' . date("d-M-Y");
	        ini_set('memory_limit', '512M');
			Excel::create($filename, function ($excel){
				$excel->sheet('prf-request', function ($sheet){
					// Set auto size for sheet
					$sheet->setAutoSize(true);
					// $sheet->setColumnFormat(array(
					// 	'E' => '0.00',		//for line value
					// 	'F' => '0.00'		//for total value
					// ));
					// $sheet->setCellValue('B5','=SUM(B2:B4)');
	
	
					$reimbursedData = DB::table('prf_header')
					->leftjoin('prf_body', 'prf_header.id', '=', 'prf_body.prf_header_id')
					->leftjoin('department', 'prf_header.department_id', '=', 'department.id')
					->leftjoin('customer', 'prf_header.customer_location_id', '=', 'customer.id')
					->leftjoin('mode_of_payment', 'prf_header.mode_of_payment_id', '=', 'mode_of_payment.id')
					->leftjoin('sub_department', 'prf_header.sub_department_id', '=', 'sub_department.id')
					
					->leftjoin('cms_users as requestor', 'prf_header.created_by','=', 'requestor.id')
					->leftjoin('statuses', 'prf_header.status_id','=', 'statuses.id')
					->leftjoin('cms_users as approver', 'prf_header.approved_by','=', 'approver.id')
					->leftjoin('cms_users as validator', 'prf_header.validated_by','=', 'validator.id')
					->leftjoin('cms_users as printed', 'prf_header.printed_by','=', 'printed.id')
					->leftjoin('cms_users as paidby', 'prf_header.paid_by','=', 'paidby.id')
					->leftjoin('cms_users as closed', 'prf_header.closed_by','=', 'closed.id')
					->leftjoin('stores', 'prf_body.location_id', '=', 'stores.id')
					->leftjoin('category', 'prf_body.category_id', '=', 'category.id')
					->leftjoin('account', 'prf_body.account_id', '=', 'account.id')
					->leftjoin('brand', 'prf_body.brand_id', '=', 'brand.id')
					->leftjoin('currency', 'prf_body.currency_id', '=', 'currency.id')
					->leftjoin('invoice_type', 'prf_body.invoice_type_id','=', 'invoice_type.id')
					->leftjoin('payment_status', 'prf_body.payment_status_id','=', 'payment_status.id')
					->leftjoin('vat_type', 'prf_body.vat_type_id','=', 'vat_type.id')
						->select(
							'department.department_name',
							'customer.*',
							'mode_of_payment.mode_of_payment_name',
							'sub_department.sub_department_name',
							'stores.*',
							'prf_header.requestor_name as requestorlevel',
							'statuses.*',
							'prf_header.*',
							'prf_header.interco_id as interco',
							'approver.name as approverlevel',
							'invoice_type.invoice_type_name',
							'payment_status.payment_status_name',
							'validator.name as validatorlevel',
							'prf_header.created_at as requested_date',
							'prf_header.id as requested_id',
							'printed.name as printedlevel',
							'paidby.name as paidlevel',
							'category.category_name',
							'account.account_name',
							'brand.brand_name',
							'currency.currency_name',
							'prf_body.*',
							'vat_type.vat_type_name',
							'closed.name as closedlevel'
						);
						if(\Request::get('filter_column')) {

							$filter_column = \Request::get('filter_column');
		
							$reimbursedData->where(function($w) use ($filter_column,$fc) {
								foreach($filter_column as $key=>$fc) {
		
									$value = @$fc['value'];
									$type  = @$fc['type'];
									
									if($type == 'empty') {
										$w->whereNull($key)->orWhere($key,'');
										continue;
									}
									
									if($value=='' || $type=='') continue;
									
									if($type == 'between') continue;
									
									switch($type) {
										default:
											if($key && $type && $value) $w->where($key,$type,$value);
										break;
										case 'like':
										case 'not like':
											$value = '%'.$value.'%';
											if($key && $type && $value) $w->where($key,$type,$value);
										break;
										case 'in':
										case 'not in':
											if($value) {
												$value = explode(',',$value);
												if($key && $value) $w->whereIn($key,$value);
											}
										break;
									}
								}
							});
		
							foreach($filter_column as $key=>$fc) {
								$value = @$fc['value'];
								$type  = @$fc['type'];
								$sorting = @$fc['sorting'];
								
								if($sorting!='') {
									if($key) {
										$reimbursedData->orderby($key,$sorting);
										$filter_is_orderby = true;
									}
								}
		
								if ($type=='between') {
									if($key && $value) $reimbursedData->whereBetween($key,$value);
								}
		
								else {
									continue;
								}
							}
						}
						$reimbursedData->where('prf_header.deleted_at', null)->orderBy('prf_header.id','ASC');
						$result = $reimbursedData->get();
	
					foreach ($result as $orderRow) {
						$customer_location = CustomerLocation::where('id', $orderRow->customer_location_id)->first(); 
						$company = 10;
						$location = Store::where('id', $orderRow->location_id)->first();
						$department = SubDepartment::where('id', $orderRow->sub_department_id)->value('coa_id');
						$account = Account::where('id', $orderRow->account_id)->value('coa_id');
						$customer = Channel::where('id', $location->channels_id)->value('coa_id');
						$brand = Brand::where('id', $orderRow->brand_id)->value('coa_id');
						$product = $orderRow->product_id;
						$interco = Interco::where('id', $orderRow->interco)->value('coa_id');
						// $item = Item::where('digits_code', $orderRow->digits_code)->first();
						// $itemBrand = Brand::where('id', $item->brand_id)->first();
						// $itemStoreCategory = StoreCategory::where('id', $item->store_category_id)->first();
						// $itemCategory = Category::where('id', $item->category_id)->first();
						// $itemWarehouseCategory = WarehouseCategory::where('id', $item->warehouse_category_id)->first();
	
						$orderItems[] = array(
							// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toDateString(),	//'APPROVED DATE',
							// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toTimeString(), //'APPROVED TIME',
							$orderRow->reference_number, 				//'REPLENISHMENT REF#',
							$orderRow->status_name, 
							$orderRow->paid_date,
							//$orderRow->cutomer_name,				//'CHANNEL',
							//$orderRow->store_name,					//'STORE',
							//$itemStoreCategory->store_category_description,	//'STORE CATEGORY',
							$orderRow->department_name,    //'CATEGORY'
							$orderRow->sub_department_name,
							$orderRow->mode_of_payment_name,

							$orderRow->bank_name,
							$orderRow->bank_branch_name,
							$orderRow->bank_account_name,
							$orderRow->bank_account_number,

							$orderRow->gcash_number,
							$orderRow->payee_name,
							
						    $orderRow->invoice_number,
							$orderRow->invoice_date,
							

							$orderRow->particulars,
							$orderRow->brand_name,			// 	'BRAND',

							$orderRow->store_name,

							$orderRow->category_name,					//'UPC CODE',
						//	$orderRow->account_name,

						
							$orderRow->account_name,

							$orderRow->currency_name,					//'UPC CODE',
							$orderRow->quantity,			//'ITEM DESCRIPTION',
							$orderRow->line_value,		//'SKU LEGEND',
							$orderRow->total_value,
							
							$company,
							$location->coa_id,
							$department,
							$account,
							$customer,
							$brand,

							

							$product,
							$interco,

							$orderRow->coa,
							$orderRow->requestorlevel,
							$orderRow->requested_date,
							$orderRow->approverlevel,
							$orderRow->approved_at,
							$orderRow->validatorlevel,
							$orderRow->validated_at,
							$orderRow->printedlevel,
							$orderRow->printed_at,
							$orderRow->paidlevel,
							$orderRow->paid_at,

							$orderRow->closedlevel,
							$orderRow->closed_at,
						);
					}
	
					$headings = array(
						'REFERENCE NUMBER',
						'STATUS',
						'PAID DATE',
						//'CUSTOMER/LOCATION NAME',
						
						'DEPARTMENT NAME',
						'SUB DEPARTMENT NAME',
						'MODE OF PAYMENT',
						'BANK NAME',
						'BANK BRANCH NAME',
						'BANK ACCOUNT NAME',
						'BANK ACCOUNT NUMBER',

						'GCASH#',
						'PAYEE NAME',
						
						'Invoice#',
						'Invoice Date',

						'ITEM DESCRIPTION',
						'BRAND',
						'LOCATION',

						'CATEGORY',

						'ACCOUNT',

						'CURRENCY',
						'QUANTITY',
						'VALUE',
						'TOTAL VALUE',
						'COMPANY COA',
						'LOCATION COA',
						'DEPARTMENT COA',
						'ACCOUNT COA',
						'CUSTOMER COA',
						'BRAND COA',
						'PRODUCT COA',
						'INTERCO COA',
						'CHART OF ACCOUNT',
						'REQUESTED BY',
						'REQUESTED DATE',
						'APPROVED BY',
						'APPROVED DATE',
						'VALIDATED BY',
						'VALIDATED DATE',
						'PRINTED BY',
						'PRINTED DATE',
						'TRANSACTED BY',
						'TRANSACTED DATE',
						'CLOSED BY',
						'CLOSED DATE',
	
					);
	
					$sheet->fromArray($orderItems, null, 'A1', false, false);
					$sheet->prependRow(1, $headings);
					$sheet->row(1, function ($row) {
						$row->setBackground('#FFFF00');
						$row->setAlignment('center');
					});

					$sheet->cell('V' . 1 . ':' . 'AC' . 1, function ($row) {
						$row->setBackground('#6998a3');
						$row->setAlignment('center');
					});

					$sheet->cell('AD' . 1 . ':' . 'AD' . 1, function ($row) {
						$row->setBackground('#00CCCC');
						$row->setAlignment('center');
					});


					//$i = 2;
					/*if($orderItems != null)
					{
						foreach ($orderItems as $key => $item) {
						
							$sheet->cell('N' . $i . ':' . 'O' . $i, function ($row) {
								$row->setBackground('#6998a3');
								$row->setAlignment('center');
							});
		
							//$i++;
						}
					}*/
					// $sheet->getStyle('M1')->applyFromArray(array(
					// 	'fill' => array(
					// 		'type'  => PHPExcel_Style_Fill::FILL_SOLID,
					// 		'color' => array('rgb' => '76933C') //118,147,60->76933C
					// 	)
					// ));
					// $sheet->getStyle('O1')->applyFromArray(array(
					// 	'fill' => array(
					// 		'type'  => PHPExcel_Style_Fill::FILL_SOLID,
					// 		'color' => array('rgb' => '8DB4E2') //141,180,226->8DB4E2
					// 	)
					// ));
				});
			})->export('xlsx');
		}
	}