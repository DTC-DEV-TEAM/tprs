<?php namespace App\Http\Controllers;

use App\Account;
use App\Brand;
use App\Category;
use App\Currency;
use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\Department;
	use App\ModeOfPayment;
	use App\PrePayment;
	use App\PrePaymentProcess;
use App\Store;

	class AdminPrePaymentHistoryController extends \crocodicstudio\crudbooster\controllers\CBController {

        public function __construct() {
			// Register ENUM type
			//$this->request = $request;
			DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping("enum", "string");
		}

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "full_name";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = false;
			$this->button_delete = false;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "pre_payment";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Reference Number","name"=>"reference_number"];
			$this->col[] = ["label"=>"Status Id","name"=>"status_id"];
			$this->col[] = ["label"=>"Date Created","name"=>"created_at"];
			$this->col[] = ["label"=>"Department","name"=>"department_id","join"=>"department,department_name"];
			$this->col[] = ["label"=>"Requestor","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Approver","name"=>"approver_id","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Approve Date","name"=>"approver_date"];
			$this->col[] = ["label"=>"Accounting","name"=>"accounting_id","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Cash Advance Released Date","name"=>"accounting_date_release"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Reference Number','name'=>'reference_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Status Id','name'=>'status_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'status,id'];
			$this->form[] = ['label'=>'Approver Id','name'=>'approver_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'approver,id'];
			$this->form[] = ['label'=>'Approver Note','name'=>'approver_note','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Approver Date','name'=>'approver_date','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Accounting Id','name'=>'accounting_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'accounting,id'];
			$this->form[] = ['label'=>'Accounting Note','name'=>'accounting_note','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Accounting Date Release','name'=>'accounting_date_release','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Accounting Mode Of Release','name'=>'accounting_mode_of_release','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Accounting Closed By','name'=>'accounting_closed_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Accounting Closed Date','name'=>'accounting_closed_date','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Accounting Closed Note','name'=>'accounting_closed_note','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Requestor Receipts','name'=>'requestor_receipts','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Budget Category','name'=>'budget_category','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Budget Approval','name'=>'budget_approval','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Department Id','name'=>'department_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'department,department_name'];
			$this->form[] = ['label'=>'Sub Department Id','name'=>'sub_department_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'sub_department,sub_department_name'];
			$this->form[] = ['label'=>'Full Name','name'=>'full_name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter letters only'];
			$this->form[] = ['label'=>'Additional Notes','name'=>'additional_notes','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Budget Information Notes','name'=>'budget_information_notes','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Requested Amount','name'=>'requested_amount','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Total Amount','name'=>'total_amount','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Balance Amount','name'=>'balance_amount','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Status','name'=>'status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Created By','name'=>'created_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			$this->form[] = ['label'=>'Updated By','name'=>'updated_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ['label'=>'Reference Number','name'=>'reference_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Status Id','name'=>'status_id','type'=>'select2','validation'=>'required|min:1|max:255','width'=>'col-sm-10','datatable'=>'status,id'];
			//$this->form[] = ['label'=>'Approver Id','name'=>'approver_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'approver,id'];
			//$this->form[] = ['label'=>'Approver Note','name'=>'approver_note','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Approver Date','name'=>'approver_date','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Accounting Id','name'=>'accounting_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'accounting,id'];
			//$this->form[] = ['label'=>'Accounting Note','name'=>'accounting_note','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Accounting Date Release','name'=>'accounting_date_release','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Accounting Mode Of Release','name'=>'accounting_mode_of_release','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Accounting Closed By','name'=>'accounting_closed_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Accounting Closed Date','name'=>'accounting_closed_date','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Accounting Closed Note','name'=>'accounting_closed_note','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Requestor Receipts','name'=>'requestor_receipts','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Budget Category','name'=>'budget_category','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Budget Approval','name'=>'budget_approval','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Department Id','name'=>'department_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'department,department_name'];
			//$this->form[] = ['label'=>'Sub Department Id','name'=>'sub_department_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'sub_department,sub_department_name'];
			//$this->form[] = ['label'=>'Full Name','name'=>'full_name','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-10','placeholder'=>'You can only enter letters only'];
			//$this->form[] = ['label'=>'Additional Notes','name'=>'additional_notes','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Budget Information Notes','name'=>'budget_information_notes','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Requested Amount','name'=>'requested_amount','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Total Amount','name'=>'total_amount','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Balance Amount','name'=>'balance_amount','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
			//$this->form[] = ['label'=>'Status','name'=>'status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
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
			$user = CRUDBooster::myId();
			$user_account_department_id = DB::table('cms_users')->where('id', $user)->value('approver_department_id');
			

			$requested = PrePaymentProcess::select('id')->where('id', '1')->value('id');
			$approved = PrePaymentProcess::select('id')->where('id', '2')->value('id');
			$budget_released = PrePaymentProcess::select('id')->where('id', '3')->value('id');
			$validate_receipts = PrePaymentProcess::select('id')->where('id', '4')->value('id');
			$close = PrePaymentProcess::select('id')->where('id', '5')->value('id');
			$rejected = PrePaymentProcess::select('id')->where('id', '6')->value('id');

			if(CRUDBooster::myPrivilegeName() == 'Approver'){
				$query->whereIn('pre_payment.department_id', explode(',', $user_account_department_id))->orderByDesc('reference_number');
			}else{
				$query->orderByDesc('reference_number');
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
			}
			if($column_index == '3'){

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
				}else if($column_value == '9'){
					$column_value = '<span class="label" style="background-color: #214E34; color: white; font-size: 12px;">For Printing</span>';
				}else if($column_value == '10'){
					$column_value = '<span class="label" style="background-color: #214E34; color: white; font-size: 12px;">For AP Supervisor Approval</span>';
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

		public function getDetail($id) {
			//Create an Auth
			if(!CRUDBooster::isRead() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = 'Detail Data';
			$data['row'] = DB::table('pre_payment')
				->leftJoin('cms_users', 'pre_payment.created_by', 'cms_users.id')
				->leftJoin('cms_users as approver', 'pre_payment.approver_id', 'approver.id')
				->leftJoin('cms_users as accounting', 'pre_payment.accounting_id', 'accounting.id')
				->leftJoin('cms_users as supervisor', 'pre_payment.ap_supervisor_id', 'supervisor.id')
				->leftJoin('cms_users as accounting_closed', 'pre_payment.accounting_closed_by', 'accounting_closed.id')
				->select('cms_users.name as cms_users_name',
					'approver.name as approver_name',
					'accounting.name as accounting_name',
					'supervisor.name as supervisor_name',
					'accounting_closed.name as accounting_closed_name',
					'pre_payment.*')
				->where('pre_payment.id',$id)
				->first();
			// PrePaymentBody
			$data['pre_payment_body'] = DB::table('pre_payment_body')
				->leftJoin('brand as brands' , 'pre_payment_body.brand', 'brands.id')
				->leftJoin('stores as store', 'pre_payment_body.location', 'store.id')
				->leftJoin('category as categories', 'pre_payment_body.category', 'categories.id')
				->leftJoin('account as accounts', 'pre_payment_body.account', 'accounts.id')
				->leftJoin('currency as currencies', 'pre_payment_body.currency', 'currencies.id')
				->select('pre_payment_body.*', 
					'brands.brand_name',
					'store.store_name',
					'categories.category_name',
					'accounts.account_name',
					'accounts.id as account_id',
					'currencies.currency_name')
				->where('pre_payment_id',$id)
				->get();
			// PrePaymentBodyDate
			$data['pre_payment_body_date'] = DB::table('pre_payment_body')
				->where('pre_payment_id',$id)
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
			return view("pre_payment.pre_payment_view", $data);
		}


	}