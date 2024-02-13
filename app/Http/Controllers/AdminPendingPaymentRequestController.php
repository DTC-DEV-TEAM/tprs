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

	class AdminPendingPaymentRequestController extends \crocodicstudio\crudbooster\controllers\CBController {

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
				if(CRUDBooster::myPrivilegeName() == "Approver"){
					$Entered =  RequestStatus::where('id', 1)->value('id');
					$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestApproval/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Entered"];
				}else if(CRUDBooster::myPrivilegeName() == "AP Checker"){
					$Approved =  RequestStatus::where('id', 2)->value('id');
					$Validated =  RequestStatus::where('id', 3)->value('id');
					$Paid =  RequestStatus::where('id', 4)->value('id');

					$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestValidation/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Approved"];
					$this->addaction[] = ['title'=>'Print','url'=>CRUDBooster::mainpath('getRequestPrint/[id]'),'icon'=>'fa fa-print', "showIf"=>"[status_id] == $Validated"];
					
					
					$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestClose/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Paid"];
				
				}else if(CRUDBooster::myPrivilegeName() == "Treasury"){

					$Printed =  RequestStatus::where('id', 5)->value('id');
					$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestPayment/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Printed"];
				}


				
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
					  ->where('prf_header.status_id', $Entered)
					  ->whereNull('prf_header.deleted_at')
					  ->orderBy('prf_header.id', 'ASC');
			
			} else if(CRUDBooster::myPrivilegeName() == "AP Checker"){
				$query->where(function($sub_query){

					$Approved =  RequestStatus::where('id', 2)->value('id');
					$Validated =  RequestStatus::where('id', 3)->value('id');
					$Paid =  RequestStatus::where('id', 4)->value('id');

					$sub_query->where('prf_header.status_id', $Approved)->whereNull('prf_header.deleted_at'); 
					$sub_query->orwhere('prf_header.status_id', $Validated)->whereNull('prf_header.deleted_at');
					$sub_query->orwhere('prf_header.status_id', $Paid)->whereNull('prf_header.deleted_at');
				});

				$query->orderBy('prf_header.status_id', 'DESC')->orderBy('prf_header.id', 'ASC');
			}else if(CRUDBooster::myPrivilegeName() == "Treasury"){

				$Printed =  RequestStatus::where('id', 5)->value('id');

				$query->where('prf_header.status_id', $Printed)->orderBy('prf_header.status_id', 'DESC')->orderBy('prf_header.id', 'ASC');
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
			       
	        //Your code here
			if(CRUDBooster::myPrivilegeName() == "Approver"){
				$fields = Input::all();

				$approval_action 	= $fields['approval_action'];
				$approver_comments 	= $fields['approver_comments'];

				if($approval_action  == 1){

					$postdata['status_id'] 		= RequestStatus::where('id', 2)->value('id');
					$postdata['approver_comments'] 	= $approver_comments;
					$postdata['approved_by'] 	= CRUDBooster::myId();
					$postdata['approved_at'] 	= date('Y-m-d H:i:s');

				}else{

					$postdata['status_id'] 		= RequestStatus::where('id', 6)->value('id');
					$postdata['approver_comments'] 	= $approver_comments;
					$postdata['approved_by'] 	= CRUDBooster::myId();
					$postdata['rejected_at'] 	= date('Y-m-d H:i:s');
				}

			}else if(CRUDBooster::myPrivilegeName() == "AP Checker"){

				if($prf_header->status_id == 3){

				}else if($prf_header->status_id == 4){
					$fields = Input::all();

					$files 	= $fields['close_receipt'];
					
					$closed = RequestStatus::where('id', 8)->value('id');

					$images=array();
					$counter = 0;
						foreach($files as $file){
							$counter++;
							$extension1 =  $counter.time() . '.' .$file->getClientOriginalExtension();
							$filename = $extension1;
							$file->move('vendor/crudbooster/',$filename);
							$images[]='vendor/crudbooster/'.$filename;
						}

					$postdata['close_receipt'] = implode("|",$images);

					$postdata['status_id'] 	= $closed;
					$postdata['closed_by'] 	= CRUDBooster::myId();
					$postdata['closed_at'] 	= date('Y-m-d H:i:s');	

				}else{
				    
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
					
					//$postdata['invoice_type_id'] 	= $invoice_type_id;
					//$postdata['payment_status_id'] 	= $payment_status_id;
					//$postdata['vat_type_id'] 	= $vat_type_id;

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

					
					$postdata['invoice_number'] 	= $invoice_number;
					$postdata['invoice_date'] 	= $invoice_date;
					
					$postdata['interco_id'] 	= $interco_id;
					$postdata['status_id'] 		= RequestStatus::where('id', 3)->value('id');
					$postdata['validated_by'] 	= CRUDBooster::myId();
					$postdata['validated_at'] 	= date('Y-m-d H:i:s');

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

					for($x=0; $x < count((array)$item_id); $x++) {

						PRFBody::where('id', $item_id[$x])
						->update([
							'invoice_type_id' => $invoice_type_id[$x],
							'payment_status_id' => $payment_status_id[$x],
							'vat_type_id'		   => $vat_type_id[$x],
							'product_id'	   => $product_id[$x],
							
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
        
        				
        
        				$department = SubDepartment::where('id', $prf_header->sub_department_id)->value('coa_id');
        
        				
        
        				$interco = Interco::where('id', $interco_id)->value('coa_id');
        
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
        				
				
				}

			}else if(CRUDBooster::myPrivilegeName() == "Treasury"){
				$fields = Input::all();

				$paid_date 	= $fields['paid_date'];





				$postdata['paid_date'] 	= $paid_date;
				$postdata['status_id'] 		= RequestStatus::where('id', 4)->value('id');
				$postdata['paid_by'] 	= CRUDBooster::myId();
				$postdata['paid_at'] 	= date('Y-m-d H:i:s');
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
			$prf_header = PRFHeader::where(['id' => $id])->first();

			if(CRUDBooster::myPrivilegeName() == "Approver"){
				$fields = Input::all();
				$approval_action 	= $fields['approval_action'];

				if($approval_action  == 1){
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_approve_success",['reference_number'=>$prf_header->reference_number]), 'info');
				}else{
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_reject_success",['reference_number'=>$prf_header->reference_number]), 'danger');
				}
			}else if(CRUDBooster::myPrivilegeName() == "AP Checker"){

				if($prf_header->status_id == 4){

				}else if($prf_header->status_id == 8){
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_close_success",['reference_number'=>$prf_header->reference_number]), 'success');
				}else{
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_validate_success",['reference_number'=>$prf_header->reference_number]), 'info');
				}
			}else if(CRUDBooster::myPrivilegeName() == "Treasury"){
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_paid_success",['reference_number'=>$prf_header->reference_number]), 'info');
			}
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
		public function getRequestApproval($id){
			$this->cbLoader();
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}  

			$data = array();


			$data['page_title'] = 'Approve Payment Request';

			$data['Header'] = PRFHeader::
							  leftjoin('department', 'prf_header.department_id', '=', 'department.id')
							  ->leftjoin('customer', 'prf_header.customer_location_id', '=', 'customer.id')
							  ->leftjoin('sub_department', 'prf_header.sub_department_id', '=', 'sub_department.id')
							  ->leftjoin('stores', 'prf_header.location_id', '=', 'stores.id')
							  ->leftjoin('cms_users as requestor', 'prf_header.created_by','=', 'requestor.id')
							  ->leftjoin('statuses', 'prf_header.status_id','=', 'statuses.id')
							  ->leftjoin('mode_of_payment', 'prf_header.mode_of_payment_id','=', 'mode_of_payment.id')
							  ->select(
								'department.*',
								'customer.*',
								'sub_department.*',
								'stores.*',
								'requestor.name as requestorlevel',
								'statuses.*',
								'prf_header.*',
								'mode_of_payment.mode_of_payment_name as mode_of_payment_name',
								'prf_header.created_at as requested_date'
							  )
							  ->where('prf_header.id', $id)->first();

			$data['Body'] = PRFBody::
							  leftjoin('category', 'prf_body.category_id', '=', 'category.id')
							  ->leftjoin('account', 'prf_body.account_id', '=', 'account.id')
							  ->leftjoin('brand', 'prf_body.brand_id', '=', 'brand.id')
							  ->leftjoin('currency', 'prf_body.currency_id', '=', 'currency.id')

							  ->leftjoin('stores', 'prf_body.location_id', '=', 'stores.id')

							  ->select(
								'category.*',
								'account.*',
								'brand.*',
								'currency.*',
								'stores.*',
								'prf_body.*'
							  )
							  ->where('prf_body.prf_header_id', $id)
							  ->where('prf_body.row_deleted', null)
							  ->get();
							  


			return view("prf.approval", $data);

		}


		public function getRequestValidation($id){
			$this->cbLoader();
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}  

			$data = array();

			$data['page_title'] = 'Validate Payment Request';

			$data['Location'] = Store::where('store_status', 'ACTIVE')->orderby('store_name', 'ASC')->get();

			$data['Header'] = PRFHeader::
							  leftjoin('department', 'prf_header.department_id', '=', 'department.id')
							  ->leftjoin('customer', 'prf_header.customer_location_id', '=', 'customer.id')
							  ->leftjoin('mode_of_payment', 'prf_header.mode_of_payment_id', '=', 'mode_of_payment.id')
							  ->leftjoin('sub_department', 'prf_header.sub_department_id', '=', 'sub_department.id')
							  ->leftjoin('stores', 'prf_header.location_id', '=', 'stores.id')
							  ->leftjoin('cms_users as requestor', 'prf_header.created_by','=', 'requestor.id')
							  ->leftjoin('statuses', 'prf_header.status_id','=', 'statuses.id')
							  ->leftjoin('cms_users as approver', 'prf_header.approved_by','=', 'approver.id')
							  ->leftjoin('invoice_type', 'prf_header.invoice_type_id','=', 'invoice_type.id')
							  ->leftjoin('payment_status', 'prf_header.payment_status_id','=', 'payment_status.id')
							  ->leftjoin('vat_type', 'prf_header.vat_type_id','=', 'vat_type.id')
							  ->leftjoin('cms_users as validator', 'prf_header.validated_by','=', 'validator.id')
							  ->select(					
								'department.*',
								'customer.*',
								'sub_department.*',
								'stores.*',
								'requestor.name as requestorlevel',
								'mode_of_payment.mode_of_payment_name',
								'statuses.*',
								'approver.name as approverlevel',
								'invoice_type.*',
								'payment_status.*',
								'vat_type.*',
								'validator.name as validatorlevel',
								'prf_header.*',
								'prf_header.created_at as requested_date'
							  )
							  ->where('prf_header.id', $id)->first();

			$data['Body'] = PRFBody::
							  leftjoin('category', 'prf_body.category_id', '=', 'category.id')
							  ->leftjoin('account', 'prf_body.account_id', '=', 'account.id')
							  ->leftjoin('brand', 'prf_body.brand_id', '=', 'brand.id')
							  ->leftjoin('currency', 'prf_body.currency_id', '=', 'currency.id')
							  ->leftjoin('stores', 'prf_body.location_id', '=', 'stores.id')
							  ->select(
								'category.*',
								'account.*',
								'brand.*',
								'currency.*',
								'stores.*',
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
			$data['InvoiceType'] = InvoiceType::where('status', 'ACTIVE')->where('id', '!=', 1)->orderby('invoice_type_name', 'ASC')->get();
			$data['PaymentStatus'] = PaymentStatus::where('status', 'ACTIVE')->orderby('payment_status_name', 'ASC')->get();
			$data['VatType'] = VatType::where('status', 'ACTIVE')->orderby('vat_type_name', 'ASC')->get();				  
			
			return view("prf.validation", $data);

		}


		public function getRequestPrint($id){
			$this->cbLoader();
            if(!CRUDBooster::isRead() && $this->global_privilege==FALSE) {    
                CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
            }   

			$data = array();


			$data['page_title'] = 'Print Payment Request';

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
							  ->leftjoin('mode_of_payment', 'prf_header.mode_of_payment_id', '=', 'mode_of_payment.id')
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
								'mode_of_payment.mode_of_payment_name'
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
							  ->select(
								'category.*',
								'account.*',
								'brand.*',
								'currency.*',
								'prf_body.*',
								'invoice_type.*',
								'payment_status.*',
								'vat_type.*'
							  )
							  ->where('prf_body.prf_header_id', $id)
							  ->where('prf_body.row_deleted', null)
							  ->get();

							  
			return view("prf.print", $data);

		}



		public function getRequestPayment($id){
			$this->cbLoader();
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}  

			$data = array();


			$data['page_title'] = 'Payment Payment Request';

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
							  ->leftjoin('cms_users as printed', 'prf_header.printed_by','=', 'printed.id')
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
								'printed.name as printedlevel'
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

			$data['InvoiceType'] = InvoiceType::where('status', 'ACTIVE')->orderby('invoice_type_name', 'ASC')->get();
			$data['PaymentStatus'] = PaymentStatus::where('status', 'ACTIVE')->orderby('payment_status_name', 'ASC')->get();
			$data['VatType'] = VatType::where('status', 'ACTIVE')->orderby('vat_type_name', 'ASC')->get();				  
			
			return view("prf.payment", $data);

		}


		public function PRFUpdateStatus(){
			$data = Input::all();		
			$request_id = $data['id']; 

			$Printed =  RequestStatus::where('id', 5)->value('id');

			PRFHeader::where('id',$request_id)
					 ->update([
						'status_id'=> $Printed,
						'printed_by'=> CRUDBooster::myId(),
						'printed_at'=> date('Y-m-d H:i:s'),
					 ]);
		}




		public function getRequestClose($id){
			$this->cbLoader();
            if(!CRUDBooster::isRead() && $this->global_privilege==FALSE) {    
                CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
            }   

			$data = array();


			$data['page_title'] = 'Close Payment Request';

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
								'printed.name as printedlevel'
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

							  


			return view("prf.close", $data);

		}

	}