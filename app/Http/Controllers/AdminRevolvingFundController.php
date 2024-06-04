<?php namespace App\Http\Controllers;

use App\Account;
use App\Brand;
use App\Category;
use App\Currency;
use App\Department;
use App\ModeOfPayment;
use App\PrePayment;
use App\PrePaymentProcess;
use App\Store;
use App\SubDepartment;
use Session;
use Illuminate\Http\Request;
use DB;
use CRUDBooster;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;


	class AdminRevolvingFundController extends \crocodicstudio\crudbooster\controllers\CBController {

        public function __construct() {
			// Register ENUM type
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
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "revolving_fund";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Reference Number","name"=>"reference_number"];
			$this->col[] = ["label"=>"Request Status","name"=>"status_id"];
			$this->col[] = ["label"=>"Department","name"=>"department_id","join"=>"department,department_name"];
			$this->col[] = ["label"=>"Requested By","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Request Date","name"=>"created_at"];
			$this->col[] = ["label"=>"Approved By","name"=>"approver_id","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Approved Date","name"=>"approver_date"];
			$this->col[] = ["label"=>"Approved By Accounting","name"=>"accounting_id","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Revolving Fund Date Released","name"=>"accounting_date_release"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Reference Number','name'=>'reference_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Approver Id','name'=>'approver_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Approver Date','name'=>'approver_date','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Accounting Id','name'=>'accounting_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Accounting Mode Of Release','name'=>'accounting_mode_of_release','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Created By','name'=>'created_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Updated By','name'=>'updated_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Reference Number','name'=>'reference_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Approver Id','name'=>'approver_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Aprrover Note','name'=>'aprrover_note','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'approver,id'];
			//$this->form[] = ['label'=>'Approver Date','name'=>'approver_date','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Accounting Id','name'=>'accounting_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Accounting Note','name'=>'accounting_note','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'accounting,id'];
			//$this->form[] = ['label'=>'Accounting Date','name'=>'accounting_date','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Accounting Mode Of Release','name'=>'accounting_mode_of_release','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Requestor Receipts','name'=>'requestor_receipts','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Budget Approval','name'=>'budget_approval','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Created By','name'=>'created_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Updated By','name'=>'updated_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			# OLD END FORM

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
			$requested = 1; //PrePaymentProcess::select('id')->where('id', '1')->value('id');
			$approved = 2; //PrePaymentProcess::select('id')->where('id', '2')->value('id');
			$budget_released = 3; //PrePaymentProcess::select('id')->where('id', '3')->value('id');
			$validate_receipts = 4; //PrePaymentProcess::select('id')->where('id', '4')->value('id');
			$close = 5; //PrePaymentProcess::select('id')->where('id', '5')->value('id');
			$rejected = 6; // PrePaymentProcess::select('id')->where('id', '6')->value('id');
			$ap_record = 7; //PrePaymentProcess::select('id')->where('id', '7')->value('id');
			$for_transmittal = 8; //PrePaymentProcess::select('id')->where('id', '8')->value('id');
			$ap_id = CRUDBooster::myId();
			if(CRUDBooster::myPrivilegeName() == 'Requestor'){
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $budget_released"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $for_transmittal"];
			}else if(CRUDBooster::myPrivilegeName() == 'Approver'){
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $requested"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $budget_released && [created_by] == $ap_id"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $for_transmittal && [created_by] == $ap_id"];
			}else if(CRUDBooster::myPrivilegeName() == 'AP Checker'){
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $ap_record"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $validate_receipts"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $for_transmittal"];
			}else if(CRUDBooster::myPrivilegeName() == 'Treasury' || CRUDBooster::myPrivilegeName() == 'Cashier'){
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $approved"];
			}else{
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $requested"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $approved"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $budget_released"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $validate_receipts"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $ap_record"];
				$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('edit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $for_transmittal"];

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
	        $this->alert = array();

	        
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
			if((CRUDBooster::getCurrentMethod() == 'getIndex') && (CRUDBooster::myPrivilegeName() != 'Treasury')  && (CRUDBooster::myPrivilegeName() != 'AP Checker') ){
				$this->index_button[] = ['label'=>'Request Revolving Fund','url'=>CRUDBooster::mainpath("add"),"icon"=>"fa fa-plus", 'color'=>'success'];
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
			$this->index_statistic[] = ['label'=>'Request may take up to 1 to 3 working days before release of funds.', 'label1'=>'To ensure proper record keeping, all receipts should be submitted formally to the accounting department.', 'color'=>'light-blue', 'width'=>'col-sm-12', 'icon'=>'fa fa-file-text-o'];


	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = "NULL";


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
			$requested = PrePaymentProcess::select('id')->where('id', '1')->value('id');
			$approved = PrePaymentProcess::select('id')->where('id', '2')->value('id');
			$budget_released = PrePaymentProcess::select('id')->where('id', '3')->value('id');
			$validate_receipts = PrePaymentProcess::select('id')->where('id', '4')->value('id');
			$close = PrePaymentProcess::select('id')->where('id', '5')->value('id');
			$rejected = PrePaymentProcess::select('id')->where('id', '6')->value('id');
			$for_recording = PrePaymentProcess::select('id')->where('id', '7')->value('id');
			$for_transmittal = PrePaymentProcess::select('id')->where('id', '8')->value('id');
			$approver_id = DB::table('cms_users')->where('id', CRUDBooster::myId())->first();
			$approver_sub_department = explode(',',$approver_id->approver_department_id);
			
			if (CRUDBooster::myPrivilegeName() == 'Requestor'){
				$query->where('revolving_fund.created_by', CRUDBooster::myId())->orderByDesc('revolving_fund.reference_number');
			}else if (CRUDBooster::myPrivilegeName() == 'Approver'){
				$query->whereIn('revolving_fund.department_id', $approver_sub_department)->where('status_id', '!=', $close)->where('status_id', '!=', $rejected);
				// $query->where('revolving_fund.status_id', $requested)->whereIn('revolving_fund.sub_department_id', $approver_sub_department);
				// $query->orWhere('revolving_fund.status_id', $for_recording)->whereIn('revolving_fund.sub_department_id', $approver_sub_department);
				// $query->whereIn('revolving_fund.sub_department_id', $approver_sub_department);
				// $query->orWhere('status_id', $requested);
			}else if (CRUDBooster::myPrivilegeName() == 'AP Checker'){
				$query->orderByDesc('revolving_fund.reference_number')->where('status_id', '!=', $close)->where('status_id', '!=', $rejected);
			}else{
				$query->orderByDesc('revolving_fund.reference_number')->where('status_id', '!=', $close)->where('status_id', '!=', $rejected);
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
			if($column_index == '10' && $column_value){
				$column_value = date('Y-m-d', strtotime($column_value));
			}if($column_index == '3'){
				if($column_value == '1'){
					$column_value = '<span class="label" style="background-color: #2980B9; color: white; font-size: 12px;">For Approval</span>';
				}else if($column_value == '2'){
					$column_value = '<span class="label" style="background-color: #BDC581; color: white; font-size: 12px;">For Release</span>';
				}else if($column_value == '3'){
					$column_value = '<span class="label" style="background-color: #f0ad4e; color: white; font-size: 12px;">For Receipts Validation</span>';
				}else if($column_value == '4'){
					$column_value = '<span class="label" style="background-color: #2F4F4F; color: white; font-size: 12px;">For Transmittal</span>';
				}else if($column_value == '5'){
					$column_value = '<span class="label" style="background-color: #5cb85c; color: white; font-size: 12px;">Closed</span>';
				}else if($column_value == '6'){
					$column_value = '<span class="label" style="background-color: #FF6347; color: white; font-size: 12px;">Rejected</span>';
				}else if($column_value == '7'){
					$column_value = '<span class="label" style="background-color: #214E34; color: white; font-size: 12px;">For AP Recording</span>';
				}else if($column_value == '8'){
					$column_value = '<span class="label" style="background-color: #214E34; color: white; font-size: 12px;">Receipts Submitted</span>';
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
			$return_inputs = Input::all();

			$status = DB::table('revolving_fund')
				->select('status_id')
				->where('id', $id)
				->value('id');
			
			// Approving Step 2
			if($status == 1){

				$submit_btn = $return_inputs['submit'];
				$approver_note = $return_inputs['additional_notes'];
				$accounting_mode_of_release = $return_inputs['mode_of_payment'];
				if($submit_btn == 'Approve'){
					$postdata['status_id'] = 7;
					$postdata['accounting_mode_of_release'] = $accounting_mode_of_release;
					$postdata['payee_name'] = $return_inputs['payee_name'];
					$postdata['bank_name'] = $return_inputs['bank_name'];
					$postdata['bank_branch_name'] = $return_inputs['bank_branch_name'];
					$postdata['bank_account_name'] = $return_inputs['bank_account_name'];
					$postdata['bank_account_number'] = $return_inputs['bank_account_number'];
					$postdata['gcash_number'] = $return_inputs['gcash_number'];
					$postdata['cc_payee_name'] =  $return_inputs['cc_payee_name'];
					$postdata['cc_last_card_number'] = $return_inputs['cc_credit_card'];
				}else{
					$postdata['status_id'] = 6;
				}

				$postdata['approver_note'] = $approver_note;
				$postdata['approver_id'] = CRUDBooster::myId();
				$postdata['approver_date'] = date('Y-m-d H:i:s');
				
			}

			// AP recording Step 3
			if($status == 7){

				$submit_btn = $return_inputs['submit'];
				$approver_note = $return_inputs['additional_notes'];
				$accounting_mode_of_release = $return_inputs['mode_of_payment'];

				if($submit_btn == 'Save'){
					$postdata['status_id'] = 2;
					$postdata['accounting_mode_of_release'] = $accounting_mode_of_release;
					$postdata['payee_name'] = $return_inputs['payee_name'];
					$postdata['bank_name'] = $return_inputs['bank_name'];
					$postdata['bank_branch_name'] = $return_inputs['bank_branch_name'];
					$postdata['bank_account_name'] = $return_inputs['bank_account_name'];
					$postdata['bank_account_number'] = $return_inputs['bank_account_number'];
					$postdata['gcash_number'] = $return_inputs['gcash_number'];
					$postdata['system_reference_number'] = $return_inputs['system_reference_number'];
					$postdata['check_date'] = $return_inputs['check_date'];
				}else{
					$postdata['status_id'] = 6;
				}

				$postdata['ap_checker_note'] = $approver_note;
				$postdata['ap_checker_id'] = CRUDBooster::myId();
				$postdata['ap_checker_date'] = date('Y-m-d H:i:s');
				
			}

			// Releasing Step 4
			if($status == 2){

				$submit_btn = $return_inputs['submit'];
				$accounting_note = $return_inputs['additional_notes'];
				$accounting_mode_of_release = $return_inputs['mode_of_payment'];

				if($submit_btn == 'Release'){
					$postdata['status_id'] = 3;
					$postdata['accounting_mode_of_release'] = $accounting_mode_of_release;
				}else{
					$postdata['status_id'] = 6;
				}

				$postdata['accounting_note'] = $accounting_note;
				$postdata['accounting_id'] = CRUDBooster::myId();
				// $postdata['accounting_date_release'] = date('Y-m-d H:i:s');
				$postdata['accounting_date_release'] = $return_inputs['release_date'];
				
			}
			// Upload Receipts Step 5
			if($status == 3){
				
				$total_amount = $return_inputs['total_amount'];
				$balance_amount = $return_inputs['balance_amount'];
				$budget_information_notes = $return_inputs['additional_notes'];
				$unused_amount = $return_inputs['unused_amount'];

					$postdata['status_id'] = 8;
					$postdata['total_amount'] = $total_amount;
					$postdata['balance_amount'] = abs($balance_amount);
					$postdata['budget_information_notes'] = $budget_information_notes;
					$postdata['unused_amount'] = $unused_amount;

				$id = $return_inputs['returns_id'];
				$description = $return_inputs['description'];
				$brand = $return_inputs['brand'];
				$location = $return_inputs['location'];
				$category = $return_inputs['category'];
				$account = $return_inputs['account'];
				$currency = $return_inputs['currency'];
				$qty = $return_inputs['qty'];
				$receipt_value = $return_inputs['value'];
				$amount = $return_inputs['amount'];
				$budget_justification = [$return_inputs['budget_justification']];
				$requested_project = [];
				$insert_revolving_fund_body = [];
				
				$sort_return_inputs = ksort($return_inputs);
				
				$filteredArray = array_filter(
					$return_inputs,
					function($key) {
						return strpos($key, 'budget_justification') !== false;
					},
					ARRAY_FILTER_USE_KEY
				);
				
			
				for($i=0;$i<count($filteredArray);$i++){
					
					$array_file = array_values($filteredArray)[$i];
					if($array_file == null){
						$array_file = null;
					}else{
						// foreach($array_file as $key=>$value){
						
							// 	$filename = uniqid().'.'.$value->getClientOriginalExtension();
							// 	$array_file[$key] = $filename;
						// 	$value->move(public_path('revolving_fund/img'), $filename);

						// 	 // Optimize the uploaded image
						// 	// $optimizerChain = OptimizerChainFactory::create();
						// 	// $optimizerChain->optimize(public_path('revolving_fund/img/' . $filename));
						// }
						foreach ($array_file as $key => $value) {
							$filename = uniqid() . '.' . $value->getClientOriginalExtension();
							$array_file[$key] = $filename;
							
							$image = Image::make($value);
							
							// Resize the image to a maximum width of 1024 pixels and a maximum height of 768 pixels
							$image->resize(1024, 768, function ($constraint) {
								$constraint->aspectRatio();
								$constraint->upsize();
							});
							
							// Save the resized image to the public folder
							$image->save(public_path('revolving_fund/img/' . $filename));
							
							// Optimize the uploaded image
							$optimizerChain = OptimizerChainFactory::create();
							$optimizerChain->optimize(public_path('revolving_fund/img/' . $filename));
						}
					}
					array_push($requested_project, $array_file);
				}
				
				for($i=0; $i<count($description); $i++){
					
					$insert_revolving_fund_body[] = [
						'revolving_fund_id' => $id,
						'description' => $description[$i],
						'brand' => $brand[$i],
						'location' => $location[$i],
						'category' => $category[$i],
						'account' => $account[$i],
						'currency' => $currency[$i],
						'qty' => $qty[$i],
						'value' => $receipt_value[$i],
						'amount' => $amount[$i],
						'budget_justification' => $requested_project[$i] ? implode(", ",$requested_project[$i]) : null,
						'created_by' => CRUDBooster::myId(),
						'created_at' => date('Y-m-d H:i:s')
					];
				}
				
				// Insert budget information
				foreach($insert_revolving_fund_body  as $budget_information){
					DB::table('revolving_fund_body')->insert(
						$budget_information
					);
				}

			}
			// Step 6 For Trarnsmittal
			if($status == 8){

				$submit_btn = $return_inputs['submit'];
				$transmit_date = $return_inputs['transmit_date'];
				$transmit_received_by = $return_inputs['transmit_received_by'];
				$total_amount = $return_inputs['total_amount'];
				$balance_amount = $return_inputs['remaining_balance'];
				$accounting_closed_note = $return_inputs['additional_notes'];
				$ar_reference_number = $return_inputs['ar_reference_number'];

				// if($submit_btn == 'Save'){

					$postdata['status_id'] = 4;
					$postdata['transmit_date'] = $transmit_date;
					$postdata['transmit_received_by'] = $transmit_received_by;
					$postdata['transmit_submit_date'] = now();
				// }else if($submit_btn == 'Close'){
					
				// 	$postdata['status_id'] = 5;
				// 	$postdata['total_amount'] = $total_amount;
				// 	$postdata['balance_amount'] = abs($balance_amount);
				// 	$postdata['accounting_closed_note'] = $accounting_closed_note;	
				// 	$postdata['ar_reference_number'] = $ar_reference_number;
				// 	$postdata['accounting_closed_by'] = CRUDBooster::myId();
				// 	$postdata['accounting_closed_date'] = date('Y-m-d H:i:s');
					
				// 	$id = $return_inputs['returns_id'];
				// 	$description = $return_inputs['description'];
				// 	$brand = $return_inputs['brand'];
				// 	$location = $return_inputs['location'];
				// 	$category = $return_inputs['category'];
				// 	$account = $return_inputs['account'];
				// 	$currency = $return_inputs['currency'];
				// 	$qty = $return_inputs['qty'];
				// 	$receipt_value = $return_inputs['value'];
				// 	$amount = $return_inputs['amount'];
				// 	$budget_justification = [$return_inputs['budget_justification']];
				// 	$revolving_fund_id = $return_inputs['project_id'];

				// 	$requested_project = [];
				// 	$requested_id = [];
					
				// 	for($i=0; $i<count((array)$description); $i++){
				// 		$requested_project[] = [
				// 			'revolving_fund_id' => $revolving_fund_id[$i],
				// 			'description' => $description[$i],
				// 			'brand' => $brand[$i],
				// 			'location' => $location[$i],
				// 			'category' => $category[$i],
				// 			'account' => $account[$i],
				// 			'currency' => $currency[$i],
				// 			'qty' => $qty[$i],
				// 			'value' => $receipt_value[$i],
				// 			'amount' => $amount[$i],
				// 			'created_by' => CRUDBooster::myId(),
				// 			'created_at' => date('Y-m-d H:i:s')
				// 		];
						
				// 		array_push($requested_id, $id[$i]);
				// 	}

				// 	// Insert budget information
				// 	for($i=0; $i<count((array)$requested_id); $i++){
				// 		DB::table('revolving_fund_body')->updateOrInsert(['id'=>$requested_id[$i]],
				// 			$requested_project[$i]
				// 		);
				// 	}
				// }

			}
			// Closing Step 7
			if($status == 4){

				$submit_btn = $return_inputs['submit'];
				$accounting_note = $return_inputs['additional_notes'];
				$total_amount = $return_inputs['total_amount'];
				$balance_amount = $return_inputs['remaining_balance'];
				$accounting_closed_note = $return_inputs['additional_notes'];
				$ar_reference_number = $return_inputs['ar_reference_number'];

				if($submit_btn == 'Close'){
					$postdata['status_id'] = 5;
					$postdata['total_amount'] = $total_amount;
					$postdata['balance_amount'] = abs($balance_amount);
					$postdata['accounting_closed_note'] = $accounting_closed_note;	
					$postdata['ar_reference_number'] = $ar_reference_number;
					$postdata['accounting_closed_by'] = CRUDBooster::myId();
					$postdata['accounting_closed_date'] = date('Y-m-d H:i:s');
				}

				$id = $return_inputs['returns_id'];
				$description = $return_inputs['description'];
				$brand = $return_inputs['brand'];
				$location = $return_inputs['location'];
				$category = $return_inputs['category'];
				$account = $return_inputs['account'];
				$currency = $return_inputs['currency'];
				$qty = $return_inputs['qty'];
				$receipt_value = $return_inputs['value'];
				$amount = $return_inputs['amount'];
				$budget_justification = [$return_inputs['budget_justification']];
				$revolving_fund_id = $return_inputs['project_id'];

				$requested_project = [];
				$requested_id = [];
				
				for($i=0; $i<count((array)$description); $i++){
					$requested_project[] = [
						'revolving_fund_id' => $revolving_fund_id[$i],
						'description' => $description[$i],
						'brand' => $brand[$i],
						'location' => $location[$i],
						'category' => $category[$i],
						'account' => $account[$i],
						'currency' => $currency[$i],
						'qty' => $qty[$i],
						'value' => $receipt_value[$i],
						'amount' => $amount[$i],
						'created_by' => CRUDBooster::myId(),
						'created_at' => date('Y-m-d H:i:s')
					];
					
					array_push($requested_id, $id[$i]);
				}

				// Insert budget information
				for($i=0; $i<count((array)$requested_id); $i++){
					DB::table('revolving_fund_body')->updateOrInsert(['id'=>$requested_id[$i]],
						$requested_project[$i]
					);
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

			$return_inputs = Input::all();
			$status_id = $return_inputs['status_id'];
			$submit = $return_inputs['submit'];
			
			if(($status_id == '1') && ($submit != 'Reject')){
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'The request has been approved.',"success");
			}else if(($status_id == '2') && ($submit != 'Reject')){
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Revolving Fund has been released.',"success");
			}else if($status_id == '3'){
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'You may now proceed to return the receipts and any remaining balance, along with your reference number.',"success");
			}else if($status_id == '4'){
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Transaction Closed.',"success");
			}else if(($status_id == '7') && ($submit != 'Reject')){
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Transaction Recorded to the system.',"success");
			}else if($status_id == '8'){
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Transaction Saved.',"success");
			}else{
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Request Rejected.',"success");
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
		public function getAdd() {
			//Create an Auth
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}

			$data = [];
			$data['page_title'] = 'Add Data';
			//Please use view method instead view method from laravel
			return view("revolving_fund.revolving_fund", $data);
		}

		public function add_request(Request $request){
			//Your code here
			$return_inputs = Input::all();

			$department = $return_inputs['department'];
			$sub_department = $return_inputs['sub_department'];
			$full_name = $return_inputs['full_name'];
			$mode_of_payment = $return_inputs['mode_of_payment'];
			$budget_amount = $return_inputs['amount'];
			$additional_notes = $return_inputs['additional_notes'];
			$requested_amount = $return_inputs['requested_amount'];
			$payee_name = $return_inputs['payee_name'];
			$bank_name = $return_inputs['bank_name'];
			$bank_branch_name = $return_inputs['bank_branch_name'];
			$bank_account_name = $return_inputs['bank_account_name'];
			$bank_account_number = $return_inputs['bank_account_number'];
			$gcash_number = $return_inputs['gcash_number'];
			$cc_payee_name = $return_inputs['cc_payee_name'];
			$cc_last_digits = $return_inputs['cc_credit_card'];
			$need_by_date = $return_inputs['need_by_date'];
			
			$id = DB::table('revolving_fund')->insertGetId( ['department_id' => $department, 
				'status_id' => 1,
				'need_by_date' => $need_by_date,
				'sub_department_id' => $sub_department,
				'full_name' => $full_name,
				'accounting_mode_of_release' => $mode_of_payment,
				'additional_notes' => $additional_notes,
				'requested_amount' => $requested_amount,
				'payee_name' => $payee_name,
				'bank_name' => $bank_name,
				'bank_branch_name' => $bank_branch_name,
				'bank_account_name' => $bank_account_name,
				'bank_account_number' => $bank_account_number,
				'gcash_number' => $gcash_number,
				'cc_payee_name' => $cc_payee_name,
				'cc_last_card_number' => $cc_last_digits,
				'created_by' => CRUDBooster::myId(),
				'created_at' => date('Y-m-d H:i:s')
			]);

			// Update reference number
			DB::table('revolving_fund')->where('id', $id)
			->update(
				['reference_number' => 'RVF-'.str_pad($id,6,"0", STR_PAD_LEFT)]
			);

			CRUDBooster::redirect(CRUDBooster::mainpath(), 'Your request has been added',"success");

		}

		public function verify_receipt(Request $request){

			//Your code here
			$return_inputs = Input::all();

			$id = $return_inputs['returns_id'];
			$project_name = $return_inputs['project_name'];
			$budget_category = $return_inputs['budget_category'];
			$budget_description = $return_inputs['budget_description'];
			$budget_location = $return_inputs['budget_location'];
			$budget_amount = $return_inputs['amount'];
			$budget_justification = $return_inputs['budget_justification'];
			$additional_notes = $return_inputs['additional_notes'];
			
			$requested_project = [];
			
			for($i=0; $i<count((array)$project_name); $i++){

				$file = $budget_justification[$i];
				$filename = uniqid() . '.' . $file->getClientOriginalExtension();
				$file->move(public_path('revolving_fund/img'), $filename);
				$requested_project[] = [
					'revolving_fund_id' => $id,
					'project_name' => $project_name[$i],
					'budget_category' => $budget_category[$i],
					'budget_description' => $budget_description[$i],
					'budget_justification' => $filename,
					'budget_location' => $budget_location[$i],
					'budget_amount' => $budget_amount[$i],
					'created_by' => CRUDBooster::myId(),
					'created_at' => date('Y-m-d H:i:s')
				];
			}
			
			// Insert budget information
			foreach($requested_project as $projects){
				DB::table('revolving_fund_body')->insert(
					$projects
				);
			}

			CRUDBooster::redirect(CRUDBooster::mainpath(), 'Your form submitted succesfully.',"success");

		}
		

		// Department
		public function department(Request $request){

			$user_info = DB::table('cms_users')->where('id', CRUDBooster::myId())->first();
			$results = explode(',', $user_info->department_id);

			if(CRUDBooster::myPrivilegeName() == 'Requestor'){
				$results = Department::
					select('id', 'department_name')
					->where('status', 'ACTIVE')
					->whereIn('id', explode(',', $user_info->department_id))
					->where('department_name', 'LIKE', '%'. $request->input('q'). '%')
					// ->orWhere('id', 'LIKE', '%'. $request->input('q'). '%')
					->orderBy('department_name')
					->get();
			}else{
				$results = Department::
					select('id', 'department_name')
					->where('status', 'ACTIVE')
					->where('department_name', 'LIKE', '%'. $request->input('q'). '%')
					->orWhere('id', 'LIKE', '%'. $request->input('q'). '%')
					->orderBy('department_name')
					->get();
			}
						
			return response()->json($results);

		}

		// Mode of Payment
		public function mode_of_payment(Request $request){
			
			$results = ModeOfPayment::
				select('id', 'mode_of_payment_name')
				->where('status', 'ACTIVE')
				->where(function ($query) use ($request) {
					$query->where('mode_of_payment_name', 'LIKE', '%'. $request->input('q'). '%')
						->orWhere('id', 'LIKE', '%'. $request->input('q'). '%');
				})
				->orderBy('mode_of_payment_name')
				->get();
						
			return response()->json($results);
		}
    


		// Sub Department
		public function sub_department(Request $request){
			
			$results = SubDepartment::
				select('id', 'sub_department_name')
				->where('status', 'ACTIVE')
				->where('sub_department_name', 'LIKE', '%'. $request->input('q'). '%')
				->where('department_id', '=', $request->input('department_id'))
				->orderBy('sub_department_name')
				->get()->unique('sub_department_name');
						
			return response()->json($results);
		}

		// Account
		public function account(Request $request){
			
			$results = Account::
				select('id', 'account_name')
				->where('status', 'ACTIVE')
				->where('account_name', 'LIKE', '%'. $request->input('q'). '%')
				->where('category_id', 'LIKE', '%'. $request->input('category_id'). '%')
				->orderBy('account_name')
				->get()->unique('account_name');
						
			return response()->json($results);
		}
		
		// Edit
		public function getEdit($id) {
			//Create an Auth	
		
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = 'Edit Data';
			$data['row'] = DB::table('revolving_fund')
				->leftJoin('cms_users', 'revolving_fund.created_by', 'cms_users.id')
				->leftJoin('cms_users as approver', 'revolving_fund.approver_id', 'approver.id')
				->leftJoin('cms_users as accounting', 'revolving_fund.accounting_id', 'accounting.id')
				->select('cms_users.name as cms_users_name',
					'approver.name as approver_name',
					'accounting.name as accounting_name',
					'revolving_fund.status_id',
					'revolving_fund.need_by_date',
					'revolving_fund.id',
					'revolving_fund.department_id',
					'revolving_fund.sub_department_id',
					'revolving_fund.accounting_mode_of_release',
					'revolving_fund.full_name',
					'revolving_fund.additional_notes',
					'revolving_fund.requested_amount',
					'revolving_fund.created_at',
					'revolving_fund.approver_note',
					'revolving_fund.approver_date',
					'revolving_fund.reference_number',
					'revolving_fund.accounting_date_release',
					'revolving_fund.accounting_note',
					'revolving_fund.total_amount',
					'revolving_fund.reference_number',
					'revolving_fund.requested_amount',
					'revolving_fund.balance_amount',
					'revolving_fund.budget_information_notes',
					'revolving_fund.payee_name',
					'revolving_fund.bank_name',
					'revolving_fund.bank_branch_name',
					'revolving_fund.bank_account_name',
					'revolving_fund.bank_account_number',
					'revolving_fund.gcash_number',
					'revolving_fund.cc_payee_name',
					'revolving_fund.cc_last_card_number',
					'revolving_fund.check_date',
					'revolving_fund.system_reference_number',
					'revolving_fund.unused_amount',
					'revolving_fund.transmit_date',
					'revolving_fund.transmit_received_by')
				->where('revolving_fund.id',$id)
				->first();
		
			// RevolvingFundBody
			$data['revolving_fund_body'] = DB::table('revolving_fund_body')
				->leftJoin('brand as brands' , 'revolving_fund_body.brand', 'brands.id')
				->leftJoin('stores as store', 'revolving_fund_body.location', 'store.id')
				->leftJoin('category as categories', 'revolving_fund_body.category', 'categories.id')
				->leftJoin('account as accounts', 'revolving_fund_body.account', 'accounts.id')
				->leftJoin('currency as currencies', 'revolving_fund_body.currency', 'currencies.id')
				->select('revolving_fund_body.*', 
					'brands.brand_name',
					'store.store_name',
					'categories.category_name',
					'accounts.account_name',
					'accounts.id as account_id',
					'currencies.currency_name')
				->where('revolving_fund_id',$id)
				// ->orderByDesc('id')
				->get();
			// RevolvingFundBodyDate
			$data['revolving_fund_body_date'] = DB::table('revolving_fund_body')
				->where('revolving_fund_id',$id)
				->first();
			// Department
			$data['department'] = DB::table('department')
				->select('id', 'department_name')
				->where('id', $data['row']->department_id)
				->first();
			// Sub Department
			$data['sub_department'] = DB::table('sub_department')
				->select('id', 'sub_department_name')
				->where('id', $data['row']->sub_department_id)
				->first();
			// Mode of Payment
			$data['mode_of_payment'] = DB::table('mode_of_payment')
				->select('id','mode_of_payment_name')
				->where('id', $data['row']->accounting_mode_of_release)
				->first();
			// Brand
			$data['brands'] = Brand
				::where('status', 'ACTIVE')
				->orderBy('brand_name')
				->get();
			// Store
			$data['locations'] = Store
				::where('store_status', 'ACTIVE')
				->orderBy('store_name')
				->get();
			// Category
			$data['categories'] = Category
				::where('status', 'Active')
				->orderBy('category_name')
				->get();
			// Currency
			$data['currencies'] = Currency
				::where('status', 'Active')
				->orderBy('currency_name')
				->get();

			//Please use view method instead view method from laravel
			return view("revolving_fund.revolving_fund_edit", $data);

		}

		public function getDetail($id) {
			//Create an Auth
			if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = 'Detail Data';
			$data['row'] = DB::table('revolving_fund')
				->leftJoin('cms_users', 'revolving_fund.created_by', 'cms_users.id')
				->leftJoin('cms_users as approver', 'revolving_fund.approver_id', 'approver.id')
				->leftJoin('cms_users as accounting', 'revolving_fund.accounting_id', 'accounting.id')
				->leftJoin('cms_users as accounting_closed', 'revolving_fund.accounting_closed_by', 'accounting_closed.id')
				->select('cms_users.name as cms_users_name',
					'approver.name as approver_name',
					'accounting.name as accounting_name',
					'accounting_closed.name as accounting_closed_by',
					'revolving_fund.status_id',
					'revolving_fund.need_by_date',
					'revolving_fund.id',
					'revolving_fund.department_id',
					'revolving_fund.sub_department_id',
					'revolving_fund.accounting_mode_of_release',
					'revolving_fund.full_name',
					'revolving_fund.additional_notes',
					'revolving_fund.requested_amount',
					'revolving_fund.created_at',
					'revolving_fund.approver_note',
					'revolving_fund.approver_date',
					'revolving_fund.reference_number',
					'revolving_fund.accounting_date_release',
					'revolving_fund.accounting_note',
					'revolving_fund.accounting_closed_date',
					'revolving_fund.accounting_closed_note',
					'revolving_fund.total_amount',
					'revolving_fund.reference_number',
					'revolving_fund.requested_amount',
					'revolving_fund.balance_amount',
					'revolving_fund.budget_information_notes',
					'revolving_fund.payee_name',
					'revolving_fund.bank_name',
					'revolving_fund.bank_branch_name',
					'revolving_fund.bank_account_name',
					'revolving_fund.bank_account_number',
					'revolving_fund.gcash_number',
					'revolving_fund.check_date',
					'revolving_fund.system_reference_number',
					'revolving_fund.unused_amount',
					'revolving_fund.transmit_date',
					'revolving_fund.transmit_received_by')
				->where('revolving_fund.id',$id)
				->first();
			// Body
			$data['revolving_fund_body'] = DB::table('revolving_fund_body')
				->leftJoin('brand as brands' , 'revolving_fund_body.brand', 'brands.id')
				->leftJoin('stores as store', 'revolving_fund_body.location', 'store.id')
				->leftJoin('category as categories', 'revolving_fund_body.category', 'categories.id')
				->leftJoin('account as accounts', 'revolving_fund_body.account', 'accounts.id')
				->leftJoin('currency as currencies', 'revolving_fund_body.currency', 'currencies.id')
				->select('revolving_fund_body.*', 
					'brands.brand_name',
					'store.store_name',
					'categories.category_name',
					'accounts.account_name',
					'accounts.id as account_id',
					'currencies.currency_name')
				->where('revolving_fund_id',$id)
				->get();
			// RevolvingFundBodyDate
			$data['revolving_fund_body_date'] = DB::table('revolving_fund_body')
				->where('revolving_fund_id',$id)
				->first();
			// Department
			$data['department'] = DB::table('department')
				->select('id', 'department_name')
				->where('id', $data['row']->department_id)
				->first();
			// Sub Department
			$data['sub_department'] = DB::table('sub_department')
				->select('id', 'sub_department_name')
				->where('id', $data['row']->sub_department_id)
				->first();
			// Mode of Payment
			$data['mode_of_payment'] = DB::table('mode_of_payment')
				->select('id','mode_of_payment_name')
				->where('id', $data['row']->accounting_mode_of_release)
				->first();
			$data['brands'] = Brand
				::where('status', 'ACTIVE')
				->orderBy('brand_name')
				->get();
			$data['locations'] = Store
				::where('store_status', 'ACTIVE')
				->orderBy('store_name')
				->get();
			$data['categories'] = Category
				::where('status', 'Active')
				->orderBy('category_name')
				->get();
			$data['currencies'] = Currency
				::where('status', 'Active')
				->orderBy('currency_name')
				->get();
			
			//Please use view method instead view method from laravel
			return view("revolving_fund.revolving_fund_view", $data);
		}

	}