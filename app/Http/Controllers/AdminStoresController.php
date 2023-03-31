<?php namespace App\Http\Controllers;

	use Session;
	use Illuminate\Http\Request;
	use DB;
	use CRUDBooster;
	use Excel;

	class AdminStoresController extends \crocodicstudio\crudbooster\controllers\CBController {

		public function __construct() {
			// Register ENUM type
			DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
		}

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "store_name";
			$this->limit = "20";
			$this->orderby = "store_name,asc";
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
			if(CRUDBooster::isSuperadmin()) {
			   $this->button_import = true; 
			}else {
			   $this->button_import = false; 
			}
			$this->button_export = true;
			$this->table = "stores";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
	
			//$this->col[] = ["label"=>"Channel","name"=>"channels_id","join"=>"channels,channel_name"];
			//$this->col[] = ["label"=>"Segmentation Code","name"=>"store_code", "join"=>"segmentation,segmentation_code"];//, "join"=>"segmentation,segmentation_code"
			$this->col[] = ["label"=>"Customer COA Name","name"=>"channels_id","join"=>"channels,customer_name"];
			$this->col[] = ["label"=>"Location Name","name"=>"store_name"];
			$this->col[] = ["label"=>"COA ID","name"=>"coa_id"];
			$this->col[] = ["label"=>"Status","name"=>"store_status"];
			$this->col[] = ["label"=>"Created By","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Created Date","name"=>"created_at"];
			$this->col[] = ["label"=>"Updated By","name"=>"updated_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Updated Date","name"=>"updated_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
//			$this->form[] = ['label'=>'Channel','name'=>'channels_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-5','datatable'=>'channels,channel_name','datatable_where'=>"channel_status='ACTIVE'"];
// 			$this->form[] = ['label'=>'Segmentation Code','name'=>'store_code','type'=>'select','validation'=>'required','width'=>'col-sm-5',
// 				'dataenum'=>'BASEUS;BEYOND_THE_BOX;DIGITAL_WALKER;OMG;ONLINE;DISTRI-CON;DISTRI-OUT;GUAM'];
//            $this->form[] = ['label'=>'Segmentation Code','name'=>'store_code','type'=>'select','validation'=>'required','width'=>'col-sm-5','datatable'=>"segmentation,segmentation_code",'datatable_where'=>"segmentation_status='ACTIVE'"];
			
			$this->form[] = ['label'=>'Customer COA Name','name'=>'channels_id','type'=>'select','validation'=>'required|integer|min:0','width'=>'col-sm-5','datatable'=>'channels,customer_name','datatable_where'=>"status='ACTIVE'"];
			
			$this->form[] = ['label'=>'Location Name','name'=>'store_name','type'=>'text','validation'=>'required|min:5|max:150','width'=>'col-sm-5'];
			
			$this->form[] = ['label'=>'COA ID','name'=>'coa_id','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-5'];
			
			if(CRUDBooster::getCurrentMethod() == 'getEdit' || CRUDBooster::getCurrentMethod() == 'postEditSave' || CRUDBooster::getCurrentMethod() == 'getDetail') {
				$this->form[] = ['label'=>'Status','name'=>'store_status','type'=>'select','validation'=>'required','width'=>'col-sm-5','dataenum'=>'ACTIVE;INACTIVE'];
			}
			if(CRUDBooster::getCurrentMethod() == 'getDetail'){
				$this->form[] = ["label"=>"Created By","name"=>"created_by",'type'=>'select',"datatable"=>"cms_users,name"];
				$this->form[] = ['label'=>'Created Date','name'=>'created_at', 'type'=>'date'];
				$this->form[] = ["label"=>"Updated By","name"=>"updated_by",'type'=>'select',"datatable"=>"cms_users,name"];
				$this->form[] = ['label'=>'Updated Date','name'=>'updated_at', 'type'=>'date'];
			}
			# END FORM DO NOT REMOVE THIS LINE
			

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
            if(CRUDBooster::isUpdate() && CRUDBooster::isSuperadmin())
	        {
	            $this->button_selected[] = ['label'=>'Set Segment Code BASEUS','icon'=>'fa fa-check-circle','name'=>'set_segmentation_code_BASEUS'];
	            $this->button_selected[] = ['label'=>'Set Segment Code BEYOND_THE_BOX','icon'=>'fa fa-check-circle','name'=>'set_segmentation_code_BEYOND_THE_BOX'];
	            $this->button_selected[] = ['label'=>'Set Segment Code DIGITAL_WALKER','icon'=>'fa fa-check-circle','name'=>'set_segmentation_code_DIGITAL_WALKER'];
	            $this->button_selected[] = ['label'=>'Set Segment Code OMG','icon'=>'fa fa-check-circle','name'=>'set_segmentation_code_OMG'];
	            $this->button_selected[] = ['label'=>'Set Segment Code ONLINE','icon'=>'fa fa-check-circle','name'=>'set_segmentation_code_ONLINE'];
	        	$this->button_selected[] = ['label'=>'Set Segment Code DISTRI-CON','icon'=>'fa fa-check-circle','name'=>'set_segmentation_code_DISTRICON'];
				$this->button_selected[] = ['label'=>'Set Segment Code DISTRI-OUT','icon'=>'fa fa-check-circle','name'=>'set_segmentation_code_DISTRIOUT'];
				$this->button_selected[] = ['label'=>'Set Segment Code GUAM','icon'=>'fa fa-check-circle','name'=>'set_segmentation_code_GUAM'];
	        }
	                
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



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          
            $this->table_row_color[] = ["condition"=>"[store_status] == INACTIVE","color"=>"danger"];
	        
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
			$this->script_js = "
					$(document).ready(function() {
						$('#store_name').keyup(function() {
							this.value = this.value.toLocaleUpperCase();
						});
					});
			";

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
	        if($button_name == 'set_segmentation_code_BASEUS') {
				DB::table('stores')->whereIn('id',$id_selected)->update(['store_code'=>'BASEUS', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => CRUDBooster::myId()]);
				
			}
			else if($button_name == 'set_segmentation_code_BEYOND_THE_BOX') {
				DB::table('stores')->whereIn('id',$id_selected)->update(['store_code'=>'BEYOND_THE_BOX', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => CRUDBooster::myId()]);
				
			}
			else if($button_name == 'set_segmentation_code_DIGITAL_WALKER') {
				DB::table('stores')->whereIn('id',$id_selected)->update(['store_code'=>'DIGITAL_WALKER', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => CRUDBooster::myId()]);
				
			}
			else if($button_name == 'set_segmentation_code_OMG') {
				DB::table('stores')->whereIn('id',$id_selected)->update(['store_code'=>'OMG', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => CRUDBooster::myId()]);
				
			}
			else if($button_name == 'set_segmentation_code_ONLINE') {
				DB::table('stores')->whereIn('id',$id_selected)->update(['store_code'=>'ONLINE', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => CRUDBooster::myId()]);
				
			}
			else if($button_name == 'set_segmentation_code_DISTRICON') {
				DB::table('stores')->whereIn('id',$id_selected)->update(['store_code'=>'DISTRI-CON', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => CRUDBooster::myId()]);
				
			}
			else if($button_name == 'set_segmentation_code_DISTRIOUT') {
				DB::table('stores')->whereIn('id',$id_selected)->update(['store_code'=>'DISTRI-OUT', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => CRUDBooster::myId()]);
				
			}
			else if($button_name == 'set_segmentation_code_GUAM') {
				DB::table('stores')->whereIn('id',$id_selected)->update(['store_code'=>'GUAM', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => CRUDBooster::myId()]);
				
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
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	  
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
// 			dd($postdata);
			//$postdata['groups_id']=$postdata['channels_id'];
			$postdata['created_by']=CRUDBooster::myId();
		//	$code = DB::table('segmentation')->where('id', $postdata['store_code'])->first();
			
		//	$postdata['store_code'] = $code->segmentation_code;
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
			
		//	$code = DB::table('segmentation')->where('id', $postdata['store_code'])->first();
			
		//	$postdata['store_code'] = $code->segmentation_code;
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

		public function importTemplate() {
			Excel::create('stores-import-submaster-'.date("Ymd").'-'.date("h.i.sa"), function ($excel) {
				$excel->sheet('stores', function ($sheet) {
					$sheet->row(1, array('Channel', 'Store Code', 'Store Name', 'Status'));
				});
			})->download('csv');
		}
		
		

	}