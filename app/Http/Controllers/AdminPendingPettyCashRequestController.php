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
use App\PettyCashHeader;
use App\PettyCashBody;
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

	class AdminPendingPettyCashRequestController extends \crocodicstudio\crudbooster\controllers\CBController {

        public function __construct() {
			// Register ENUM type
			//$this->request = $request;
			DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping("enum", "string");
		}

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
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
			$this->table = "petty_cash_header";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Request Status","name"=>"status_id","join"=>"statuses,status_name"];
			$this->col[] = ["label"=>"Reference Number","name"=>"reference_number"];
			//$this->col[] = ["label"=>"Location","name"=>"location_id","join"=>"stores,store_name"];
			//$this->col[] = ["label"=>"Cutomer/Location Name","name"=>"customer_location_id","join"=>"customer,cutomer_name"];
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
				}else if(CRUDBooster::myPrivilegeName() == "Custodian"){
					$Approved =  RequestStatus::where('id', 2)->value('id');
					$Validated =  RequestStatus::where('id', 3)->value('id');
					$Recorded =  RequestStatus::where('id', 7)->value('id');

					$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestValidation/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Approved"];
					
					$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestRecord/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Validated"];
					
					$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestPayment/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Recorded"];
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

				$query->whereIn('petty_cash_header.department_id', explode(",",$user_data->approver_department_id))
					  ->whereIn('petty_cash_header.sub_department_id', explode(",",$user_data->approver_sub_department_id))
					  //->whereIn('petty_cash_header.customer_location_id', explode(",",$user_data->approver_customer_name_id))
					  ->where('petty_cash_header.status_id', $Entered)
					  ->whereNull('petty_cash_header.deleted_at')
					  ->orderBy('petty_cash_header.id', 'ASC');
			
			} else if(CRUDBooster::myPrivilegeName() == "Custodian"){

				$query->where(function($sub_query){

					$Approved =  RequestStatus::where('id', 2)->value('id');
					$Validated =  RequestStatus::where('id', 3)->value('id');

					$Recorded =  RequestStatus::where('id', 7)->value('id');

					$sub_query->where('petty_cash_header.status_id', $Approved)->whereNull('petty_cash_header.deleted_at'); 
					$sub_query->orwhere('petty_cash_header.status_id', $Validated)->whereNull('petty_cash_header.deleted_at'); 
					$sub_query->orwhere('petty_cash_header.status_id', $Recorded)->whereNull('petty_cash_header.deleted_at'); 
				});

				$query->orderBy('petty_cash_header.status_id', 'DESC')->orderBy('petty_cash_header.id', 'ASC');

			
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
			$Recorded =  RequestStatus::where('id', 7)->value('status_name');

			if($column_index == 2){
				if($column_value == $Entered){
					$column_value = '<span class="label label-warning">'.$Entered.'</span>';
				}else if($column_value == $Approved){
					$column_value = '<span class="label label-info">'.$Approved.'</span>';
				}else if($column_value == $Validated){
					$column_value = '<span class="label label-primary">'.$Validated.'</span>';
				}else if($column_value == $Recorded){
					$column_value = '<span class="label label-primary">'.$Recorded.'</span>';
				}else if($column_value == $Printed){
					$column_value = '<span class="label label-info">'.$Printed.'</span>';
				}else if($column_value == $Paid){
					$column_value = '<span class="label label-success">'.$Paid.'</span>';
				}else if($column_value == $Rejected){
					$column_value = '<span class="label label-danger">'.$Rejected.'</span>';
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

			$petty_cash_header = PettyCashHeader::where(['id' => $id])->first();
			       
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

			}else if(CRUDBooster::myPrivilegeName() == "Custodian"){

				if($petty_cash_header->status_id == 3){

					$fields = Input::all();

					$si_or_number 	= $fields['si_or_number'];
					$si_or_date 	= $fields['si_or_date'];
					$address 	= $fields['address'];
					$tin_number 	= $fields['tin_number'];
					$payee 	= $fields['payee'];
					$vat_amount 	= $fields['vat_amount'];

					$postdata['si_or_number'] 	= $si_or_number;
					$postdata['si_or_date'] 	= $si_or_date;
					$postdata['address'] 		= $address;
					$postdata['tin_number'] 	= $tin_number;
					$postdata['payee'] 			= $payee;
					$postdata['vat_amount'] 	= $vat_amount;

					$postdata['status_id'] 		= RequestStatus::where('id', 7)->value('id');
					$postdata['recorded_by'] 	= CRUDBooster::myId();
					$postdata['recorded_at'] 	= date('Y-m-d H:i:s');
					


				}else if($petty_cash_header->status_id == 7){

					$fields = Input::all();

					$paid_date 	= $fields['paid_date'];

					$postdata['paid_date'] 	= $paid_date;
					$postdata['status_id'] 		= RequestStatus::where('id', 4)->value('id');
					$postdata['paid_by'] 	= CRUDBooster::myId();
					$postdata['paid_at'] 	= date('Y-m-d H:i:s');
					
					//$location = PettyCashBody::where('id', $petty_cash_header->customer_location_id)->first;
			

				}else{

					$fields = Input::all();

					$interco_id 	= $fields['interco_id'];
					$item_id 		= $fields['item_id'];
					$invoice_type_id 	= $fields['invoice_type_id'];
					$payment_status_id 	= $fields['payment_status_id'];
					$vat_type_id 		= $fields['vat_type_id'];
					$product_id 		= $fields['product_id'];
		
					$department_id 	= $fields['department_id'];
					$sub_department_id 	= $fields['sub_department_id'];
					$total_value_order 	= $fields['total_value_order'];	
					$requestor_name 	= $fields['requestor_name'];

					//$item_id 		= $fields['item_id'];
					$account_id 	= $fields['account_id'];
					$brand_id 		= $fields['brand_id'];
					$currency_id 	= $fields['currency_id'];
					$category_id 	= $fields['category_id'];
					$particulars 	= $fields['particulars'];
					$quantity 		= $fields['quantity'];
					$line_value 	= $fields['line_value'];
					$total_value 	= $fields['total_value'];
					$location_id 	= $fields['location_id'];

					$si_or_number 	= $fields['si_or_number'];
					$si_or_date 	= $fields['si_or_date'];

					$add_items 	= $fields['add_items'];

					//$postdata['invoice_type_id'] 	= $invoice_type_id;
					//$postdata['payment_status_id'] 	= $payment_status_id;
					//$postdata['vat_type_id'] 	= $vat_type_id;

					$postdata['department_id'] 			= $department_id;
					$postdata['sub_department_id'] 		= $sub_department_id;
					$postdata['total_value_order'] 		= $total_value_order;				
					$postdata['requestor_name'] = $requestor_name;

					$postdata['interco_id'] 	= $interco_id;
					$postdata['status_id'] 		= RequestStatus::where('id', 3)->value('id');
					$postdata['validated_by'] 	= CRUDBooster::myId();
					$postdata['validated_at'] 	= date('Y-m-d H:i:s');


					for($x=0; $x < count((array)$item_id); $x++) {

						PettyCashBody::where('id', $item_id[$x])
						->update([
							'invoice_type_id' => $invoice_type_id[$x],
							'payment_status_id' => $payment_status_id[$x],
							'vat_type_id'		   => $vat_type_id[$x],
							'si_or_number' => $si_or_number[$x],
							'si_or_date' => $si_or_date[$x],
							'product_id'	   => $product_id[$x],
							'account_id' => $account_id[$x],
							'brand_id' => $brand_id[$x],
							'category_id' => $category_id[$x],
							'particulars' => $particulars[$x],
							'currency_id' => $currency_id[$x],
							'quantity'		   => $quantity[$x],
							'line_value'	   => $line_value[$x],
							'total_value'	   => $total_value[$x],
							'location_id'	   => $location_id[$x],		
							'updated_by'	   => CRUDBooster::myId(),
							'updated_at'	   => date('Y-m-d H:i:s')					
						]);
		
					}

					$dataLines = array();

					if($add_items == 0){

						$item_id_add 		= $fields['item_id_add'];
						$invoice_type_id_add 	= $fields['invoice_type_id_add'];
						$vat_type_id_add 	= $fields['vat_type_id_add'];
						$payment_status_id_add 	= $fields['payment_status_id_add'];
						$product_id_add 	= $fields['product_id_add'];
						$si_or_number_add 	= $fields['si_or_number_add'];
						$si_or_date_add 	= $fields['si_or_date_add'];
						$particulars_add 	= $fields['particulars_add'];
						$brand_id_add 	= $fields['brand_id_add'];
						$location_id_add 	= $fields['location_id_add'];
						$category_id_add 	= $fields['category_id_add'];
						$account_id_add 	= $fields['account_id_add'];
						$currency_id_add 	= $fields['currency_id_add'];
						$quantity_add 	= $fields['quantity_add'];
						$line_value_add 	= $fields['line_value_add'];
						$total_value_add 	= $fields['total_value_add'];


						for($x=0; $x < count((array)$item_id_add); $x++) {


							$dataLines[$x]['petty_cash_header_id'] 	= $petty_cash_header->id;
							$dataLines[$x]['invoice_type_id'] 	= $invoice_type_id_add[$x];
							$dataLines[$x]['vat_type_id'] 	= $vat_type_id_add[$x];
							$dataLines[$x]['payment_status_id'] 	= $payment_status_id_add[$x];
							$dataLines[$x]['product_id'] 	= $product_id_add[$x];
							$dataLines[$x]['si_or_number'] 	= $si_or_number_add[$x];
							$dataLines[$x]['si_or_date'] 	= $si_or_date_add[$x];
							$dataLines[$x]['particulars'] 	= $particulars_add[$x];
							$dataLines[$x]['brand_id'] 	= $brand_id_add[$x];
							$dataLines[$x]['location_id'] 	= $location_id_add[$x];
							$dataLines[$x]['category_id'] 	= $category_id_add[$x];
							$dataLines[$x]['account_id'] 	= $account_id_add[$x];
							$dataLines[$x]['currency_id'] 	= $currency_id_add[$x];
							$dataLines[$x]['quantity'] 	= $quantity_add[$x];
							$dataLines[$x]['line_value'] 	= $line_value_add[$x];
							$dataLines[$x]['total_value'] 	= $total_value_add[$x];
							$dataLines[$x]['created_by'] 	= CRUDBooster::myId();
							$dataLines[$x]['created_at'] 	= date('Y-m-d H:i:s');


						}
	

						DB::beginTransaction();
		
						try {
							PettyCashBody::insert($dataLines);
							DB::commit();
							//CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_pullout_data_success",['mps_reference'=>$pullout_header->reference]), 'success');
						} catch (\Exception $e) {
							DB::rollback();
							CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_database_error",['database_error'=>$e]), 'danger');
						}
						


					}



					$customer_location = CustomerLocation::where('id', $petty_cash_header->customer_location_id)->first(); 

					$company = 10;

					$location = Store::where('id', $petty_cash_header->location_id)->first();

					$department = SubDepartment::where('id', $petty_cash_header->sub_department_id)->value('coa_id');

					$customer = Channel::where('id', $location->channels_id)->value('coa_id');

					$interco = Interco::where('id', $interco_id)->value('coa_id');

					$Items = PettyCashBody::where('petty_cash_header_id', $petty_cash_header->id)->get();


					foreach($Items as $Item){


						$account = Account::where('id', $Item->account_id)->value('coa_id');
				
						$brand = Brand::where('id', $Item->brand_id)->value('coa_id');
		
						$location = Store::where('id', $Item->location_id)->first();
		
						$customer = Channel::where('id', $location->channels_id)->value('coa_id');
		
						$product = $Item->product_id;

 
						$coa_value = $company.".".$location->coa_id.".".$department.".".$account.".".$customer.".".$brand.".".$product.".".$interco;

						//dd($coa_value);

						PettyCashBody::where('id', $Item->id)
						->update([
							'coa' => $coa_value,
						]);

					}

				}

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
			$petty_cash_header = PettyCashHeader::where(['id' => $id])->first();

			if(CRUDBooster::myPrivilegeName() == "Approver"){
				$fields = Input::all();
				$approval_action 	= $fields['approval_action'];

				if($approval_action  == 1){
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_approve_success",['reference_number'=>$petty_cash_header->reference_number]), 'info');
				}else{
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_reject_success",['reference_number'=>$petty_cash_header->reference_number]), 'danger');
				}
			}else if(CRUDBooster::myPrivilegeName() == "Custodian"){

				if($petty_cash_header->status_id == 4){
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_paid_success",['reference_number'=>$petty_cash_header->reference_number]), 'success');
				}else if($petty_cash_header->status_id == 7){
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_record_success",['reference_number'=>$petty_cash_header->reference_number]), 'info');
				}else{
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_validate_success",['reference_number'=>$petty_cash_header->reference_number]), 'info');
				}
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


			$data['page_title'] = 'Approve Petty Cash Request';

			$data['Header'] = PettyCashHeader::
							  leftjoin('department', 'petty_cash_header.department_id', '=', 'department.id')
							  ->leftjoin('customer', 'petty_cash_header.customer_location_id', '=', 'customer.id')
							  ->leftjoin('sub_department', 'petty_cash_header.sub_department_id', '=', 'sub_department.id')
							  ->leftjoin('stores', 'petty_cash_header.location_id', '=', 'stores.id')
							  ->leftjoin('cms_users as requestor', 'petty_cash_header.created_by','=', 'requestor.id')
							  ->leftjoin('statuses', 'petty_cash_header.status_id','=', 'statuses.id')
							  ->select(
								'department.*',
								'customer.*',
								'sub_department.*',
								'stores.*',
								'requestor.name as requestorlevel',
								'statuses.*',
								'petty_cash_header.*',
								'petty_cash_header.created_at as requested_date'
							  )
							  ->where('petty_cash_header.id', $id)->first();

			$data['Body'] = PettyCashBody::
							  leftjoin('category', 'petty_cash_body.category_id', '=', 'category.id')
							  ->leftjoin('account', 'petty_cash_body.account_id', '=', 'account.id')
							  ->leftjoin('brand', 'petty_cash_body.brand_id', '=', 'brand.id')
							  ->leftjoin('currency', 'petty_cash_body.currency_id', '=', 'currency.id')
							  ->leftjoin('invoice_type', 'petty_cash_body.invoice_type_id','=', 'invoice_type.id')
							  ->leftjoin('payment_status', 'petty_cash_body.payment_status_id','=', 'payment_status.id')
							  ->leftjoin('vat_type', 'petty_cash_body.vat_type_id','=', 'vat_type.id')
							  ->leftjoin('stores', 'petty_cash_body.location_id', '=', 'stores.id')
							  ->select(
								'category.*',
								'account.*',
								'brand.*',
								'currency.*',
								'petty_cash_body.*',
								'invoice_type.*',
								'payment_status.*',
								'stores.*',
								'vat_type.*'
							  )
							  ->where('petty_cash_body.petty_cash_header_id', $id)
							  ->where('petty_cash_body.row_deleted', null)
							  ->get();

			$data['department'] = Department::select('id', 'department_name')->where('status', 'ACTIVE')->get();

			$data['sub_department'] = SubDepartment::select('id', 'sub_department_name')->where('status', 'ACTIVE')->get();
			

			$this->cbView("petty-cash.approval", $data);

		}

		public function getRequestValidation($id){
			$this->cbLoader();
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}  

			$data = array();

			$data['page_title'] = 'Validate Petty Cash Request';

			$data['CustomerLocation'] = CustomerLocation::
										leftjoin('stores', 'customer.location_id', '=', 'stores.id')
							 			->select( 'customer.*', 'stores.id as locationid', 'stores.store_name as location_name')
							 			->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();
										//->whereIn('customer.id', explode(",",$user_data->customer_name_id))->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();
            
            $data['Location'] = Store::where('store_status', 'ACTIVE')->orderby('store_name', 'ASC')->get();



			$data['Categories'] = category::where('status', 'ACTIVE')->orderby('category_name', 'ASC')->get();

			$data['Accounts'] = Account::where('status', 'ACTIVE')->orderby('account_name', 'ASC')->get();

			$data['Brands'] = Brand::where('status', 'ACTIVE')->orderby('brand_name', 'ASC')->get();

			$data['Currencies'] = Currency::where('status', 'ACTIVE')->where('id', 1)->orderby('currency_name', 'ASC')->get();			

			$data['Header'] = PettyCashHeader::
							  leftjoin('department', 'petty_cash_header.department_id', '=', 'department.id')
							  ->leftjoin('customer', 'petty_cash_header.customer_location_id', '=', 'customer.id')
							  ->leftjoin('sub_department', 'petty_cash_header.sub_department_id', '=', 'sub_department.id')
							  ->leftjoin('stores', 'petty_cash_header.location_id', '=', 'stores.id')
							  ->leftjoin('cms_users as requestor', 'petty_cash_header.created_by','=', 'requestor.id')
							  ->leftjoin('statuses', 'petty_cash_header.status_id','=', 'statuses.id')
							  ->leftjoin('cms_users as approver', 'petty_cash_header.approved_by','=', 'approver.id')
							  ->leftjoin('invoice_type', 'petty_cash_header.invoice_type_id','=', 'invoice_type.id')
							  ->leftjoin('payment_status', 'petty_cash_header.payment_status_id','=', 'payment_status.id')
							  ->leftjoin('vat_type', 'petty_cash_header.vat_type_id','=', 'vat_type.id')
							  ->leftjoin('cms_users as validator', 'petty_cash_header.validated_by','=', 'validator.id')
							  ->select(					
								'department.*',
								'customer.*',
								'sub_department.*',
								'stores.*',
								'requestor.name as requestorlevel',
								'statuses.*',
								'approver.name as approverlevel',
								'invoice_type.*',
								'payment_status.*',
								'vat_type.*',
								'validator.name as validatorlevel',
								'petty_cash_header.*',
								'petty_cash_header.created_at as requested_date'
							  )
							  ->where('petty_cash_header.id', $id)->first();

			$data['Body'] = PettyCashBody::
							  leftjoin('category', 'petty_cash_body.category_id', '=', 'category.id')
							  ->leftjoin('account', 'petty_cash_body.account_id', '=', 'account.id')
							  ->leftjoin('brand', 'petty_cash_body.brand_id', '=', 'brand.id')
							  ->leftjoin('currency', 'petty_cash_body.currency_id', '=', 'currency.id')
							  ->select(
								'category.*',
								'account.*',
								'brand.*',
								'currency.*',
								'petty_cash_body.*'
							  )
							  ->where('petty_cash_body.petty_cash_header_id', $id)
							  ->where('petty_cash_body.row_deleted', null)
							  ->get();

			$user_data = Users::where('id', $data['Header']->created_by)->first();

			$data['Departments'] = Department::whereIn('id', explode(",",$user_data->department_id))->where('status', 'ACTIVE')->orderby('department_name', 'ASC')->get();
							  
			$data['SubDepartments'] = SubDepartment::whereIn('id', explode(",",$user_data->sub_department_id))->where('status', 'ACTIVE')->orderby('sub_department_name', 'ASC')->get();				  

			$data['Interco'] = Interco::where('status', 'ACTIVE')->orderby('interco_name', 'ASC')->get();
			$data['InvoiceType'] = InvoiceType::where('status', 'ACTIVE')->orderby('invoice_type_name', 'ASC')->get();
			$data['PaymentStatus'] = PaymentStatus::where('status', 'ACTIVE')->orderby('payment_status_name', 'ASC')->get();
			$data['VatType'] = VatType::where('status', 'ACTIVE')->orderby('vat_type_name', 'ASC')->get();				  
			
			$this->cbView("petty-cash.validation", $data);

		}

		public function getRequestPayment($id){
			$this->cbLoader();
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}  

			$data = array();


			$data['page_title'] = 'Payment Petty Cash Request';

			$data['Header'] = PettyCashHeader::
							  leftjoin('department', 'petty_cash_header.department_id', '=', 'department.id')
							  ->leftjoin('customer', 'petty_cash_header.customer_location_id', '=', 'customer.id')
							  ->leftjoin('sub_department', 'petty_cash_header.sub_department_id', '=', 'sub_department.id')
							  ->leftjoin('stores', 'petty_cash_header.location_id', '=', 'stores.id')
							  ->leftjoin('cms_users as requestor', 'petty_cash_header.created_by','=', 'requestor.id')
							  ->leftjoin('statuses', 'petty_cash_header.status_id','=', 'statuses.id')
							  ->leftjoin('cms_users as approver', 'petty_cash_header.approved_by','=', 'approver.id')
							  ->leftjoin('invoice_type', 'petty_cash_header.invoice_type_id','=', 'invoice_type.id')
							  ->leftjoin('payment_status', 'petty_cash_header.payment_status_id','=', 'payment_status.id')
							  ->leftjoin('vat_type', 'petty_cash_header.vat_type_id','=', 'vat_type.id')
							  ->leftjoin('cms_users as validator', 'petty_cash_header.validated_by','=', 'validator.id')
							  ->leftjoin('cms_users as recorded', 'petty_cash_header.recorded_by','=', 'recorded.id')
							  ->select(
								'department.*',
								'customer.*',
								'sub_department.*',
								'stores.*',
								'requestor.name as requestorlevel',
								'statuses.*',
								'petty_cash_header.*',
								'approver.name as approverlevel',
								'invoice_type.*',
								'payment_status.*',
								'vat_type.*',
								'validator.name as validatorlevel',
								'recorded.name as recordedlevel',
								'petty_cash_header.created_at as requested_date',
								'petty_cash_header.id as requested_id'
							  )
							  ->where('petty_cash_header.id', $id)->first();

			$data['Body'] = PettyCashBody::
							  leftjoin('category', 'petty_cash_body.category_id', '=', 'category.id')
							  ->leftjoin('account', 'petty_cash_body.account_id', '=', 'account.id')
							  ->leftjoin('brand', 'petty_cash_body.brand_id', '=', 'brand.id')
							  ->leftjoin('currency', 'petty_cash_body.currency_id', '=', 'currency.id')
							  ->leftjoin('invoice_type', 'petty_cash_body.invoice_type_id','=', 'invoice_type.id')
							  ->leftjoin('payment_status', 'petty_cash_body.payment_status_id','=', 'payment_status.id')
							  ->leftjoin('vat_type', 'petty_cash_body.vat_type_id','=', 'vat_type.id')
							  ->leftjoin('stores', 'petty_cash_body.location_id', '=', 'stores.id')
							  ->select(
								'category.*',
								'account.*',
								'brand.*',
								'currency.*',
								'petty_cash_body.*',
								'invoice_type.*',
								'payment_status.*',
								'stores.*',
								'vat_type.*'
							  )
							  ->where('petty_cash_body.petty_cash_header_id', $id)
							  ->where('petty_cash_body.row_deleted', null)
							  ->get();

			$data['InvoiceType'] = InvoiceType::where('status', 'ACTIVE')->orderby('invoice_type_name', 'ASC')->get();
			$data['PaymentStatus'] = PaymentStatus::where('status', 'ACTIVE')->orderby('payment_status_name', 'ASC')->get();
			$data['VatType'] = VatType::where('status', 'ACTIVE')->orderby('vat_type_name', 'ASC')->get();				  
			
			$this->cbView("petty-cash.payment", $data);

		}


		public function getRequestRecord($id){
			$this->cbLoader();
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}  

			$data = array();


			$data['page_title'] = 'Record Petty Cash Request';

			$data['Header'] = PettyCashHeader::
							  leftjoin('department', 'petty_cash_header.department_id', '=', 'department.id')
							  ->leftjoin('customer', 'petty_cash_header.customer_location_id', '=', 'customer.id')
							  ->leftjoin('sub_department', 'petty_cash_header.sub_department_id', '=', 'sub_department.id')
							  ->leftjoin('stores', 'petty_cash_header.location_id', '=', 'stores.id')
							  ->leftjoin('cms_users as requestor', 'petty_cash_header.created_by','=', 'requestor.id')
							  ->leftjoin('statuses', 'petty_cash_header.status_id','=', 'statuses.id')
							  ->leftjoin('cms_users as approver', 'petty_cash_header.approved_by','=', 'approver.id')
							  ->leftjoin('invoice_type', 'petty_cash_header.invoice_type_id','=', 'invoice_type.id')
							  ->leftjoin('payment_status', 'petty_cash_header.payment_status_id','=', 'payment_status.id')
							  ->leftjoin('vat_type', 'petty_cash_header.vat_type_id','=', 'vat_type.id')
							  ->leftjoin('cms_users as validator', 'petty_cash_header.validated_by','=', 'validator.id')
							  ->select(
								'department.*',
								'customer.*',
								'sub_department.*',
								'stores.*',
								'requestor.name as requestorlevel',
								'statuses.*',
								'petty_cash_header.*',
								'approver.name as approverlevel',
								'invoice_type.*',
								'payment_status.*',
								'vat_type.*',
								'validator.name as validatorlevel',
								'petty_cash_header.created_at as requested_date',
								'petty_cash_header.id as requested_id'
							  )
							  ->where('petty_cash_header.id', $id)->first();

			$data['Body'] = PettyCashBody::
							  leftjoin('category', 'petty_cash_body.category_id', '=', 'category.id')
							  ->leftjoin('account', 'petty_cash_body.account_id', '=', 'account.id')
							  ->leftjoin('brand', 'petty_cash_body.brand_id', '=', 'brand.id')
							  ->leftjoin('currency', 'petty_cash_body.currency_id', '=', 'currency.id')
							  ->leftjoin('invoice_type', 'petty_cash_body.invoice_type_id','=', 'invoice_type.id')
							  ->leftjoin('payment_status', 'petty_cash_body.payment_status_id','=', 'payment_status.id')
							  ->leftjoin('vat_type', 'petty_cash_body.vat_type_id','=', 'vat_type.id')
							  ->leftjoin('stores', 'petty_cash_body.location_id', '=', 'stores.id')
							  ->select(
								'category.*',
								'account.*',
								'brand.*',
								'currency.*',
								'petty_cash_body.*',
								'invoice_type.*',
								'payment_status.*',
								'stores.*',
								'vat_type.*'
							  )
							  ->where('petty_cash_body.petty_cash_header_id', $id)
							  ->where('petty_cash_body.row_deleted', null)
							  ->get();

			$data['InvoiceType'] = InvoiceType::where('status', 'ACTIVE')->orderby('invoice_type_name', 'ASC')->get();
			$data['PaymentStatus'] = PaymentStatus::where('status', 'ACTIVE')->orderby('payment_status_name', 'ASC')->get();
			$data['VatType'] = VatType::where('status', 'ACTIVE')->orderby('vat_type_name', 'ASC')->get();				  
			
			$this->cbView("petty-cash.record", $data);

		}

	}