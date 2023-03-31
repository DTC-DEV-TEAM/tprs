<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminCustomerAndLocationController extends \crocodicstudio\crudbooster\controllers\CBController {

        public function __construct() {
			// Register ENUM type
			//$this->request = $request;
			DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping("enum", "string");
		}

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "cutomer_name";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "customer";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Cutomer/Location Name","name"=>"cutomer_name"];
			//$this->col[] = ["label"=>"Department","name"=>"department_id","join"=>"department,department_name"];
			$this->col[] = ["label"=>"Location","name"=>"location_id","join"=>"stores,store_name"];
			$this->col[] = ["label"=>"Customer COA ID","name"=>"customer_coa_id"];
			
			$this->col[] = ["label"=>"Status","name"=>"status_id"];
			$this->col[] = ["label"=>"Created By","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Created Date","name"=>"created_at"];
			$this->col[] = ["label"=>"Updated By","name"=>"updated_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Updated Date","name"=>"updated_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];

			$this->form[] = ['label'=>'Cutomer/Location','name'=>'cutomer_name','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-5','readonly'=>true];
		//	$this->form[] = ['label'=>'Department','name'=>'department_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-5','datatable'=>'department,department_name'];
			//$this->form[] = ['label'=>'Sub Department','name'=>'sub_department_id','type'=>'select','validation'=>'required','width'=>'col-sm-5','datatable'=>'sub_department,sub_department_name','relationship_table'=>'sub_department','parent_select'=>'department_id'];
			$this->form[] = ['label'=>'Location','name'=>'location_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-5','datatable'=>'stores,store_name'];
			$this->form[] = ['label'=>'Customer COA ID','name'=>'customer_coa_id','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-5'];
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Action Type","name"=>"action_type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Approval Status Id","name"=>"approval_status_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"approval_status,id"];
			//$this->form[] = ["label"=>"Customer Code","name"=>"customer_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Channel Id","name"=>"channel_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"channel,id"];
			//$this->form[] = ["label"=>"Channel Code Id","name"=>"channel_code_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"channel_code,id"];
			//$this->form[] = ["label"=>"Note","name"=>"note","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Cutomer Name","name"=>"cutomer_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Length","name"=>"length","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Concept","name"=>"concept","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Trade Name","name"=>"trade_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Mall","name"=>"mall","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Branch","name"=>"branch","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Branch Onl","name"=>"branch_onl","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Bill To","name"=>"bill_to","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tin No","name"=>"tin_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tax Country Id","name"=>"tax_country_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"tax_country,id"];
			//$this->form[] = ["label"=>"Ship To Address","name"=>"ship_to_address","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Building No","name"=>"building_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Lot Blk No Streetname","name"=>"lot_blk_no_streetname","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Barangay","name"=>"barangay","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"City Id","name"=>"city_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"city,id"];
			//$this->form[] = ["label"=>"State Id","name"=>"state_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"state,id"];
			//$this->form[] = ["label"=>"Area Code Zip Code","name"=>"area_code_zip_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Country Id","name"=>"country_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"country,id"];
			//$this->form[] = ["label"=>"Contact Person","name"=>"contact_person","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Contact Person Ln","name"=>"contact_person_ln","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Contact Person Fn","name"=>"contact_person_fn","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Contact Designation Id","name"=>"contact_designation_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"contact_designation,id"];
			//$this->form[] = ["label"=>"Contact Department Id","name"=>"contact_department_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"contact_department,id"];
			//$this->form[] = ["label"=>"Account Person","name"=>"account_person","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Account Person Ln","name"=>"account_person_ln","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Account Person Fn","name"=>"account_person_fn","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Account Designation Id","name"=>"account_designation_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"account_designation,id"];
			//$this->form[] = ["label"=>"Account Department Id","name"=>"account_department_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"account_department,id"];
			//$this->form[] = ["label"=>"Contact Landline No","name"=>"contact_landline_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"International Country Code 1","name"=>"international_country_code_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Area Code 1","name"=>"area_code_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Number 1","name"=>"number_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Mobile Number","name"=>"mobile_number","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"International Country Code 2","name"=>"international_country_code_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Area Code 2","name"=>"area_code_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Number 2","name"=>"number_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Email Address","name"=>"email_address","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:customer","placeholder"=>"Please enter a valid email address"];
			//$this->form[] = ["label"=>"Bank Details","name"=>"bank_details","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Beneficiary Name","name"=>"beneficiary_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Account Number","name"=>"account_number","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Beneficiary Address","name"=>"beneficiary_address","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Bank Beneficiary","name"=>"bank_beneficiary","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Bank Address","name"=>"bank_address","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Bank Code","name"=>"bank_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Switf Code","name"=>"switf_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Bic","name"=>"bic","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Iban","name"=>"iban","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Aba","name"=>"aba","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Currency Id","name"=>"currency_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"currency,currency_name"];
			//$this->form[] = ["label"=>"Credit Limit","name"=>"credit_limit","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Payment Terms Id","name"=>"payment_terms_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"payment_terms,id"];
			//$this->form[] = ["label"=>"Payment Mode Id","name"=>"payment_mode_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"payment_mode,id"];
			//$this->form[] = ["label"=>"Bea Pricelist Id","name"=>"bea_pricelist_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"bea_pricelist,id"];
			//$this->form[] = ["label"=>"Bea Staging Location Id","name"=>"bea_staging_location_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"bea_staging_location,id"];
			//$this->form[] = ["label"=>"Pos Name Id","name"=>"pos_name_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"pos_name,id"];
			//$this->form[] = ["label"=>"Ref","name"=>"ref","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Status Id","name"=>"status_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"status,id"];
			//$this->form[] = ["label"=>"Status As Date","name"=>"status_as_date","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"Encoder Privilege Id","name"=>"encoder_privilege_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"encoder_privilege,id"];
			//$this->form[] = ["label"=>"Approved By 1","name"=>"approved_by_1","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Approved At 1","name"=>"approved_at_1","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Disapproved At 1","name"=>"disapproved_at_1","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Approved By 2","name"=>"approved_by_2","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Approved At 2","name"=>"approved_at_2","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Disapproved At 2","name"=>"disapproved_at_2","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Created By","name"=>"created_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Updated By","name"=>"updated_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Open Date","name"=>"open_date","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Close Date","name"=>"close_date","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Reason","name"=>"reason","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Owner Name","name"=>"owner_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Department Id","name"=>"department_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"department,department_name"];
			//$this->form[] = ["label"=>"Sub Department Id","name"=>"sub_department_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"sub_department,sub_department_name"];
			//$this->form[] = ["label"=>"Location Id","name"=>"location_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"location,id"];
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
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
			if($column_index == 5){
				switch ($column_value){
					case 2:
						$column_value = '<span stye="display: block;" class="label label-danger">INACTIVE</span><br>';
						break;
					default:
						$column_value = '<span stye="display: block;" class="label label-info">ACTIVE</span><br>';
						break;
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
			$postdata['created_by']=CRUDBooster::myId();

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
			$postdata['updated_by']=CRUDBooster::myId();
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


	}