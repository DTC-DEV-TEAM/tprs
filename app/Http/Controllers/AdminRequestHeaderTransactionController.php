<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Excel;
use CRUDBooster;
use PHPExcel_Style_Fill;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as Input;
// use \Datetime;

class AdminRequestHeaderTransactionController extends \crocodicstudio\crudbooster\controllers\CBController
{

	public function __construct()
	{
		// Register ENUM type
		//$this->request = $request;
		DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping("enum", "string");
	}

	public function cbInit()
	{

		# START CONFIGURATION DO NOT REMOVE THIS LINE
		$this->title_field = "id";
		$this->limit = "20";
		$this->orderby = "id,desc";
		$this->global_privilege = false;
		$this->button_table_action = true;
		$this->button_bulk_action = true;
		$this->button_action_style = "button_icon";
		$this->button_add = true;
		$this->button_edit = false;
		$this->button_delete = false;
		$this->button_detail = false;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "request_header";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Reference Number", "name" => "reference_number"];
		$this->col[] = ["label" => "Receipt Photo", "name" => "receipt_photo", "image" => true];
		$this->col[] = ["label" => "Invoice Number", "name" => "invoice_no"];
		$this->col[] = ["label" => "Invoice Date", "name" => "date_receipt"];
		$this->col[] = ["label" => "Store", "name" => "store_id", "join" => "stores,store_name"];
		$this->col[] = ["label" => "Requested By", "name" => "requested_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Requested At", "name" => "requested_at"];
		$this->col[] = ["label" => "Approved Date(Area Manager)", "name" => "date_approved_oic"];
		$this->col[] = ["label" => "Rejected Date(Area Manager)", "name" => "date_disapproved_oic"];
		$this->col[] = ["label" => "Approved By(Area Manager)", "name" => "approved_by_oic", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Rejected By(Area Manager)", "name" => "disapproved_by_oic", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Rejected Date(ACCTG)", "name" => "date_disapproved_acctg"];
		$this->col[] = ["label" => "Approved By(ACCTG)", "name" => "approved_by_acctg", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Rejected By(ACCTG)", "name" => "disapproved_by_acctg", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Received By", "name" => "receipt_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Received Date", "name" => "receipt_at"];
		$this->col[] = ["label" => "AM Status", "name" => "oic-status"];
		$this->col[] = ["label" => "ACCTG Status", "name" => "acctg-status"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];

		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//// $this->form[] = ['label'=>'Reference Number','name'=>'reference_number','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Receipt Photo','name'=>'receipt_photo','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Date Receipt','name'=>'date_receipt','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Store Id','name'=>'store_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'store,id'];
		//// $this->form[] = ['label'=>'Request Lines Id','name'=>'request_lines_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'request_lines,id'];
		//// $this->form[] = ['label'=>'Requested By','name'=>'requested_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Requested At','name'=>'requested_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Date Approved Oic','name'=>'date_approved_oic','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Date Disapproved Oic','name'=>'date_disapproved_oic','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Approved By Oic','name'=>'approved_by_oic','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Disapproved By Oic','name'=>'disapproved_by_oic','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Date Approved Acctg','name'=>'date_approved_acctg','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Date Disapproved Acctg','name'=>'date_disapproved_acctg','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Approved By Acctg','name'=>'approved_by_acctg','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Disapproved By Acctg','name'=>'disapproved_by_acctg','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Receipt By','name'=>'receipt_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Receipt At','name'=>'receipt_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
		//// $this->form[] = ['label'=>'Status','name'=>'status','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
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
		$this->addaction[] = ['title' => 'View', 'url' => 'request_header_transaction/detail/[id]', 'icon' => 'fa fa-eye'];

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
		if (CRUDBooster::getCurrentMethod() == 'getIndex') { // means sa first page lang makikita
			if (CRUDBooster::myPrivilegeName() == 'Requestor' || CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
				$this->index_button[] = [
					"title" => "Request",
					"label" => "Add Request",
					"icon" => "fa fa-file-text-o", "color" => "success", "url" => CRUDBooster::adminpath('getAdd') . '?' . urldecode(http_build_query(@$_GET))
				];
			}


			$this->index_button[] = [
				"title" => "Export",
				"label" => "Export Transactions",
				"icon" => "fa fa-download", "url" => CRUDBooster::mainpath('export-transaction') . '?' . urldecode(http_build_query(@$_GET))
			];
			
			$this->index_button[] = [
				"title" => "Export",
				"label" => "Export Filtered Transactions",
				"icon" => "fa fa-download", "url" => CRUDBooster::mainpath('export-filtered-transaction') . '?' . urldecode(http_build_query(@$_GET))
			];

			if (CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeName() == 'Admin') {
				$this->index_button[] = [
					"title" => "Export",
					"label" => "Export Deleted Request",
					"icon" => "fa fa-download", "url" => CRUDBooster::mainpath('export-deleted') . '?' . urldecode(http_build_query(@$_GET))
				];
			}
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
	public function actionButtonSelected($id_selected, $button_name)
	{
		//Your code here

	}


	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	public function hook_query_index(&$query)
	{
		//Your code here

		if (CRUDBooster::myPrivilegeName() == 'OIC') {

			// $oic_storeid = DB::table('cms_users')->where('id', CRUDBooster::myId())->get();
			$oic_storeid = DB::table('approval_matrices')
				->where('status', 'ACTIVE')
				->where('cms_users_id', CRUDBooster::myId())->get();
			// dd($oic_storeid);
			$approval_array = array();
			foreach ($oic_storeid as $matrix) {
				array_push($approval_array, $matrix->store_list);
			}
			$approval_string = implode(",", $approval_array);
			$storeList = array_map('intval', explode(",", $approval_string));


			// dd($oic_storeid);
			$query->whereIn('stores.id', $storeList)
				->where('request_header.deleted', '0');

			// $oic_storeid = DB::table('cms_users')->where('id', CRUDBooster::myId())->get();
			// // dd($oic_storeid);
			// $approval_array = array();
			// foreach ($oic_storeid as $matrix) {
			// 	array_push($approval_array, $matrix->stores_id);
			// }
			// $approval_string = implode(",", $approval_array);
			// $storeList = array_map('intval', explode(",", $approval_string));


			// // dd($oic_storeid);
			// $query->whereIn('stores.id', $storeList)
			// 	->where('request_header.deleted', '0');
		} elseif (in_array(CRUDBooster::myPrivilegeName(), ["AP Receiver", "AP Checker", "Treasury"])) {
			$_storeid = DB::table('approval_matrices')
				->where('status', 'ACTIVE')
				->where('cms_users_id', CRUDBooster::myId())->get();
			// dd($oic_storeid);
			$approval_array = array();
			foreach ($_storeid as $matrix) {
				array_push($approval_array, $matrix->store_list);
			}
			$approval_string = implode(",", $approval_array);
			$storeList = array_map('intval', explode(",", $approval_string));


			// dd($oic_storeid);
			$query->whereIn('stores.id', $storeList)
				->where('stores.store_status', 'ACTIVE')
				->where('request_header.deleted', '0');
		} else if (CRUDBooster::myPrivilegeName() == 'Requestor') {

			// $query->where('request_header.requested_by', CRUDBooster::myId())
			// 	->where('request_header.deleted', '0')
			// 	->where('approval_matrices.status', 'ACTIVE');

			$query->join('approval_matrices', 'request_header.store_id', '=', 'approval_matrices.store_list')
				->where('approval_matrices.cms_users_id', CRUDBooster::myId())
				->where('request_header.id', '!=', '0')
				->where('approval_matrices.status', 'ACTIVE')
				->where('request_header.deleted', '0');
		} else if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
			$query->where('request_header.deleted', '0');
			 //   ->where('request_header.status', 'REQUESTED')
				// ->orWhere('request_header.status', 'DISAPPROVED')
				// ->orWhere('request_header.status', 'AUDITED')
				// ->orWhere('request_header.status', 'RECEIPTED');
		}
	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */
	public function hook_row_index($column_index, &$column_value)
	{
		//Your code here
		if($column_index == 5){//column order
			$storeLists = $this->storeListing($column_value);
			
		
			foreach ($storeLists as $value) {
				
				$col_values .= '<span stye="display: block;" class="label label-info">'.$value.'</span><br>';
			}
			$column_value = $col_values;
		}

		// if($column_index == 17)
		// {
		// 	if($column_value == "APPROVED")
		// 	{
		// 		$column_value .= '<span class="label label-success">'.$column_value.'</span>';
		// 	}
		// }
	}

	/*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	public function hook_before_add(&$postdata)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	public function hook_after_add($id)
	{
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
	public function hook_before_edit(&$postdata, $id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_edit($id)
	{
		//Your code here 

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_before_delete($id)
	{
		//Your code here

	}

	/* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	public function hook_after_delete($id)
	{
		//Your code here

	}



	//By the way, you can still create your own method in here... :) 

	public function storeListing($ids) {
		$stores = explode(",", $ids);
		return DB::table('stores')->whereIn('store_name', $stores)->pluck('store_name');
	}

	public function getAdd()
	{
		$data = [];
		$data['page_title'] = 'Request Receipt';

		$data['store'] = DB::table('stores')->where('store_status', 'ACTIVE')
			->leftjoin('approval_matrices', 'stores.id', '=', 'approval_matrices.store_list')
			->where('approval_matrices.status', 'ACTIVE')
			->where('approval_matrices.cms_users_id', CRUDBooster::myId())
			->orderby('stores.store_name')->get();
		$data['categorys'] = DB::table('category')->where('category_status', 'ACTIVE')->orderby('category_description', 'ASC')->get();

		//Please use cbView method instead view method from laravel
		$this->cbView('customview.request', $data);
	}





	public function getData(Request $request)
	{
		$data = $request->all();
		$dataLines = array();
		$store_name = $data['store'];
		$category_name = $data['category'];
		$item_description = $data['itemdescriptionTF'];
		$quantity = $data['quantityTF'];
		$value = $data['valueTF'];
		$total_value = $data['totalvalueTF'];
		$date_receipt = $data['dateReceipt'];
		$computed_totalvalue = $data['totalValue2'];
		$image = $data['image'];

		$store_id = DB::table('stores')
				->where('store_name', $store_name)
				->where('store_status', 'ACTIVE')
				->value('id');

			//check the invoice# if already exist store_id,invoice_date,total_value
			$invoice = DB::table('request_header')
				->where('invoice_no', $data['invoice_number'])
				->where('total_value', $computed_totalvalue)
				->where('deleted', '0')->first();
			
			if ($invoice->id != null || $invoice->id != 0) {
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'invoice# already exist!!', 'danger')->send();
			}

			//check if user has store in approval matrix
			if ($store_id == null || $store_id == 0) {
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'You do not have a store yet!!', 'danger')->send();
			}

			$checks = DB::table('request_header')->where('invoice_no', $data['invoice_number'])
				->where('date_receipt', $date_receipt)->get(['id']);

			foreach ($checks as $check) {
				if($check->id != null || !empty($check->id))
				{
					CRUDBooster::redirect(CRUDBooster::mainpath(), 'Invoice# and Invoice date exist!!', 'danger')->send();
				}
			}


		if (Input::hasFile('image')) {
			$file = Input::file('image');
			$extension = $file->getClientOriginalExtension();
			$extension1 =  time() . '.' . $file->getClientOriginalExtension();
			$filename = $extension1;
			$file->move('storage/images/', $filename);
			
			DB::beginTransaction();

			try {
				
				DB::table('tbl_counter')->where('id',7)->increment('code_1');
                $new_reference_number = DB::table('tbl_counter')
						->where('status', 'ACTIVE')
						->value('code_1');


				//insert
				$date = date('Y-m-d H:i:s');
				$data_to_insert = array();
				$data_to_insert['reference_number'] = $new_reference_number;
				$data_to_insert['store_id'] = $store_id;
				$data_to_insert['requested_by'] = CRUDBooster::myId();
				$data_to_insert['requested_at'] = $date;
				$data_to_insert['date_receipt'] = $date_receipt;
				$data_to_insert['receipt_photo'] = 'storage/images/' . $extension1;
			
				$data_to_insert['status'] = 'REQUESTED';
				$data_to_insert['oic-status'] = 'PENDING';
				
				$data_to_insert['version'] = "1";
				$data_to_insert['invoice_no'] = $data['invoice_number'];
				$data_to_insert['total_value'] = $computed_totalvalue;
				$data_to_insert['comment'] = $data['comments'];

				DB::table('request_header')->insert($data_to_insert);


				//SELECT id
				$request_header_id = DB::table('request_header')
					->where('reference_number', $new_reference_number)
					->where('store_id', $store_id)
					->where('requested_at', $date)
					->where('deleted', '0')
					->value('id');

				
				// INSERT into request_lines
				$insert_into_lines = array();
				for ($i = 0; $i < count($item_description); $i++) {
					//select categoryid FROM category
					$category_id[$i] = DB::table('category')
						->where('category_status', 'ACTIVE')
						->where('category_description', $category_name[$i])->value('id');
					$insert_into_lines[$i]['item_description'] = $item_description[$i];
					$insert_into_lines[$i]['quantity'] = $quantity[$i];
					$insert_into_lines[$i]['line_value'] = $value[$i];
					$insert_into_lines[$i]['total_value'] = $total_value[$i];
					$insert_into_lines[$i]['request_header_id'] =  $request_header_id;
					$insert_into_lines[$i]['store_id'] = $store_id;
					$insert_into_lines[$i]['category_id'] = $category_id[$i];
					$insert_into_lines[$i]['created_at'] = date('Y-m-d H:i:s');
				}

				DB::table('request_lines')->insert($insert_into_lines);

				//insert into transaction_logs
				$insert_in_logs = array();
				$insert_in_logs['reference_number'] = $new_reference_number;
				$insert_in_logs['invoice_date'] = $date_receipt;
				$insert_in_logs['created_by'] = CRUDBooster::myId();
				$insert_in_logs['created_date'] = $date;
			
				$insert_in_logs['request_header_id'] = $request_header_id;
				DB::table('request_transaction_logs')->insert($insert_in_logs);

				//get the store of requestor
				$requestor_storeid = DB::table('stores')->where('store_status', 'ACTIVE')
					->leftjoin('approval_matrices', 'stores.id', '=', 'approval_matrices.store_list')
					->where('approval_matrices.status', 'ACTIVE')
					->where('approval_matrices.cms_users_id', CRUDBooster::myId())->first();
					
					
				//get the id of all the approver
				$oics = DB::table('approval_matrices')
					->select('id','cms_users_id')
					->where('id_cms_privileges', '11')->get();

				//create ids of array for sending notification
				$ids_to_send = array();

				//loop all ids
				foreach ($oics as $oic) {

					$o = null;
					$o = DB::table('approval_matrices')
						->select('store_list')
						->where('status', 'ACTIVE')
						->where('id', $oic->id)->first();

					//create array for store_id per iteration
					$arrayList = array();


					//store id into arrayList
					array_push($arrayList, $o->store_list);
					$approval_strings = implode(",", $arrayList);
					$list = array_map('intval', explode(",", $approval_strings));
					//check if requestor store_id is on oic user store_id	
					$check = in_array($requestor_storeid->store_list, $list);
					
					//if requestor store_id is on oic-user store_id, store this id on ids_to_send
					if ($check == true) {
						array_push($ids_to_send, $oic->cms_users_id);
						$approval_strings = implode(",", $ids_to_send);
						$list = array_map('intval', explode(",", $approval_strings));
					}
				}
				foreach ($ids_to_send as $id_to_send) {

					$config['content'] = CRUDBooster::myName() . " has requested receipt on store " . $store_name . " with reference number " . $new_reference_number . " at " . date('Y-m-d H:i:s') . ", please check the details before approve!";
					$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $request_header_id);
					$config['id_cms_users'] = [$id_to_send];
					CRUDBooster::sendNotification($config);
				}

				DB::commit();
			} catch (\Exception $e) {
			    dd($e);
				DB::rollback();
			}
		} else {
			return $request;
			// $employee->image = '';
		}

		// return redirect('admin/request_header_approval')->with('message', 'New receipt has been requested!!');
		CRUDBooster::redirect(CRUDBooster::mainpath(), 'New receipt has been requested!!', 'success')->send();
	}

	public function getDetail($id)
	{
		$this->cbLoader();
		// if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperAdmin() || CRUDBooster::myPrivilegeName() == 'OIC') {
		$data = [];
		$data['page_title'] = 'Requested Receipt';
		$data['errorpic'] = DB::table('request_header')->where('id', '1')->first();

		$data['stores'] = DB::table('stores')->where('store_status', 'ACTIVE')->orderby('store_name')->get();

		$data['store_names'] = DB::table('stores')
			->select('stores.store_name')
			->join('request_lines', 'stores.id', '=', 'request_lines.store_id')
			->where('stores.store_status', 'ACTIVE')
			->where('request_lines.request_header_id', '=', $id)->first();


		// $data['categories'] = DB::table('category')->select('category_description')->get();
		// ->join('request_lines','category.id', '=', 'request_lines.category_id')
		// ->where('request_lines.request_header_id', '=',$id)->pluck('category.category_description');



		$data['datas'] = DB::table('request_lines')
			->select('request_lines.*', 'category.category_description', 'request_header.version', 'request_header.date_receipt', 'request_header.reference_number', 'request_header.store_id', 'request_header.requested_by', 'request_header.status', 'request_header.receipt_photo', 'request_header.approved_by_oic', 'request_header.comment', 'request_header.invoice_no')
			->join('category', 'category.id', '=', 'request_lines.category_id')
			->join('request_header', 'request_lines.request_header_id', '=', 'request_header.id')

			->where('request_lines.request_header_id', '=', $id)
			->where('request_lines.is_row_deleted', '=', '0')->get();
		// dd($data['datas']);


		//Please use cbView method instead view method from laravel
		if (CRUDBooster::myPrivilegeName() == 'Requestor') {
			$this->cbView('customview.request_transaction', $data);
		} else if (CRUDBooster::myPrivilegeName() == 'OIC') {
			$this->cbView('customview.request_transaction', $data);
		} else if (in_array(CRUDBooster::myPrivilegeName(), ["AP Receiver", "AP Checker", "Treasury"])) {
			$this->cbView('customview.request_transaction', $data);
		} else if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
			$status = $data['datas'];

			for ($i = 0; $i < $status; $i++) {
				if ($status[$i]->status === 'REQUESTED' || $status[$i]->status === 'DISAPPROVED') {

					$this->cbView('customview.request_transaction', $data);
				} else if ($status[$i]->status === 'AUDITED' || $status[$i]->status === 'RECEIPTED') {
					$this->cbView('customview.request_transaction', $data);
				}
			}
		}
	}

	public function deletedExport()
	{
		$filename = 'Reimbursement Deleted Request - ' . date("d M Y - h.i.sa");
		$sheetname = 'Reimbursement Deleted Request' . date("d-M-Y");

		Excel::create($filename, function ($excel) {
			$excel->sheet('deleted', function ($sheet) {
				// Set auto size for sheet
				$sheet->setAutoSize(true);
				$sheet->setColumnFormat(array(
					'E' => '0.00',		//for line value
					'F' => '0.00'		//for total value
				));

				// $orderData = DB::table('purchase_lines')
				// 			->join('purchase_headers', 'purchase_lines.purchase_headers_id', '=', 'purchase_headers.id')
				// 			->join('channels', 'purchase_headers.channels_id', '=', 'channels.id')
				// 			->join('stores', 'purchase_headers.stores_id', '=', 'stores.id')
				// 			->join('order_statuses', 'purchase_headers.approval_status', '=', 'order_statuses.id')
				// 			->join('skustatus', 'purchase_lines.skustatus_id', '=', 'skustatus.id')
				// 			->leftJoin('skulegend', 'purchase_lines.skulegend_id', '=', 'skulegend.id')
				// 			->select('purchase_lines.*', 
				// 				'purchase_headers.*', 
				// 				'channels.*', 
				// 				'stores.*', 
				// 				'skustatus.*',
				// 				'skulegend.*');
				// $check = DB::table('request_header')->select('request_header.*')->first();

				$reimbursedData = DB::table('request_header')
					->join('request_lines', 'request_header.id', '=', 'request_lines.request_header_id')
					->join('stores', 'request_header.store_id', '=', 'stores.id')
					->join('category', 'request_lines.category_id', '=', 'category.id')
					->leftjoin('cms_users AS req', 'request_header.requested_by', '=', 'req.id')
					->leftjoin('cms_users AS app_oic', 'request_header.approved_by_oic', '=', 'app_oic.id')
					->leftjoin('cms_users AS rec_acctg', 'request_header.receipt_by', '=', 'rec_acctg.id')
					->leftjoin('cms_users AS app_acctg', 'request_header.approved_by_acctg', '=', 'app_acctg.id')
					->leftjoin('cms_users AS disapp_oic', 'request_header.disapproved_by_oic', '=', 'disapp_oic.id')
					->leftjoin('cms_users AS disapp_acctg', 'request_header.disapproved_by_acctg', '=', 'disapp_acctg.id')
					->select(
						'request_header.*',
						'request_lines.*',
						'stores.store_name',
						'category.category_description',
						'req.name AS requested_name',
						'request_header.oic-status AS oic_status',
						'request_header.acctg-status AS acctg_status',
						'app_oic.name AS oic_name',
						'rec_acctg.name AS receipt_name',
						'app_acctg.name AS acctg_name',
						'disapp_oic.name AS disappoic_name',
						'disapp_acctg.name AS disappacctg_name',
						'request_header.date_receipt AS dateOfReceipt'
					)
					->where('request_header.deleted', '1')
					->get();

				foreach ($reimbursedData as $orderRow) {

					$orderItems[] = array(
						$orderRow->reference_number, 				//'REPLENISHMENT REF#',
						$orderRow->store_name,				//'CHANNEL',
						$orderRow->item_description,					//'STORE'
						$orderRow->quantity,    //'CATEGORY'
						$orderRow->line_value,
						$orderRow->total_value,			// 	'BRAND',
						$orderRow->dateOfReceipt,					//'UPC CODE',
						$orderRow->requested_name,			//'ITEM DESCRIPTION',
						$orderRow->requested_at,		//'SKU LEGEND',
						$orderRow->oic_name,
						$orderRow->date_approved_oic,
						$orderRow->disappoic_name,
						$orderRow->date_disapproved_oic,
						$orderRow->receipt_name,
						$orderRow->receipt_at,
						$orderRow->acctg_name,
						$orderRow->date_approved_acctg,
						$orderRow->disappacctg_name,
						$orderRow->date_disapproved_acctg,
						$orderRow->comment,
						$orderRow->oic_status,
						$orderRow->acctg_status

					);
				}

				$headings = array(
					'REFERENCE NUMBER',
					'STORE',
					'ITEM DESCRIPTION',
					'QUANTITY',
					'LINE VALUE',
					'TOTAL VALUE',
					'DATE OF RECEIPT',
					'REQUESTED BY',
					'REQUESTED DATE',
					'APPROVED BY OIC',
					'APPROVE DATE OIC',
					'REJECTED BY OIC',
					'REJECTED DATE OIC',
					'RECEIVED BY',
					'RECEIVED DATE',
					'APPROVED BY ACCTG',
					'APPROVE DATE ACCTG',
					'REJECTED BY ACCTG',
					'REJECTED DATE ACCTG',
					'COMMENT',
					'OIC STATUS',
					'ACCTG STATUS'
				);

				$sheet->fromArray($orderItems, null, 'A1', false, false);
				$sheet->prependRow(1, $headings);
				$sheet->row(1, function ($row) {
					$row->setBackground('#FFFF00');
					$row->setAlignment('center');
				});
			});
		})->export('xlsx');
	}


	public function transactionExport()
	{

		$filename = 'Request Transactions - ' . date("d M Y - h.i.sa");
		$sheetname = 'Request Transactions' . date("d-M-Y");

		Excel::create($filename, function ($excel) {
			$excel->sheet('request-transactions', function ($sheet) {
				// Set auto size for sheet
				$sheet->setAutoSize(true);
				$sheet->setColumnFormat(array(
					'K' => '0.00',		//for line value
					'L' => '0.00'		//for total value
				));
				// $sheet->setCellValue('B5','=SUM(B2:B4)');

				// $orderData = DB::table('purchase_lines')
				// 			->join('purchase_headers', 'purchase_lines.purchase_headers_id', '=', 'purchase_headers.id')
				// 			->join('channels', 'purchase_headers.channels_id', '=', 'channels.id')
				// 			->join('stores', 'purchase_headers.stores_id', '=', 'stores.id')
				// 			->join('order_statuses', 'purchase_headers.approval_status', '=', 'order_statuses.id')
				// 			->join('skustatus', 'purchase_lines.skustatus_id', '=', 'skustatus.id')
				// 			->leftJoin('skulegend', 'purchase_lines.skulegend_id', '=', 'skulegend.id')
				// 			->select('purchase_lines.*', 
				// 				'purchase_headers.*', 
				// 				'channels.*', 
				// 				'stores.*', 
				// 				'skustatus.*',
				// 				'skulegend.*');




				if (CRUDBooster::myPrivilegeName() == 'Requestor') {
                    
					$store = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->first();
					$reimbursedData = DB::table('request_header')
						->join('request_lines', 'request_header.id', '=', 'request_lines.request_header_id')
						->join('stores', 'request_header.store_id', '=', 'stores.id')
						->join('cms_users AS req', 'request_header.requested_by', '=', 'req.id')
						->join('category AS cat', 'request_lines.category_id', '=', 'cat.id')
						->leftjoin('accounting_category as ac', 'ac.id', '=', 'cat.accounting_category_id')
						->leftjoin('cms_users AS oic', 'request_header.approved_by_oic', '=', 'oic.id')
						->leftjoin('cms_users AS rec', 'request_header.receipt_by', '=', 'rec.id')
						->leftjoin('cms_users AS proc', 'request_header.processed_by', '=', 'proc.id')
						->leftjoin('cms_users AS acctg', 'request_header.approved_by_acctg', '=', 'acctg.id')
						->select(
							'request_header.*',
							'request_lines.*',
							'stores.store_name',
							'cat.category_description',
							'req.name AS requested_name',
							'request_header.oic-status AS oic_status',
							'request_header.acctg-status AS acctg_status',
							'oic.name AS oic_name',
							'rec.name AS receipt_name',
							'acctg.name AS acctg_name',
							'request_header.date_receipt AS dateOfReceipt',
							'ac.description as accounting_description',
							'proc.name AS processed_name',
							'request_lines.deleted_at AS delete_date'
						)

						->where('stores.id', $store->store_list)
						->where('stores.store_status', 'ACTIVE')
						->where('request_header.deleted', '0')
						->get();
						
					
				} else if (CRUDBooster::myPrivilegeName() == 'OIC') {

					$oic_storeid = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->get();
					$approval_array = array();
					foreach ($oic_storeid as $matrix) {
						array_push($approval_array, $matrix->store_list);
					}
					$approval_string = implode(",", $approval_array);
					$storeList = array_map('intval', explode(",", $approval_string));

					$reimbursedData = DB::table('request_header')
						->join('request_lines', 'request_header.id', '=', 'request_lines.request_header_id')
						->join('stores', 'request_header.store_id', '=', 'stores.id')
						->join('cms_users AS req', 'request_header.requested_by', '=', 'req.id')
						->join('category AS cat', 'request_lines.category_id', '=', 'cat.id')
						->leftjoin('accounting_category as ac', 'ac.id', '=', 'cat.accounting_category_id')
						->leftjoin('cms_users AS oic', 'request_header.approved_by_oic', '=', 'oic.id')
						->leftjoin('cms_users AS rec', 'request_header.receipt_by', '=', 'rec.id')
						->leftjoin('cms_users AS proc', 'request_header.processed_by', '=', 'proc.id')
						->leftjoin('cms_users AS acctg', 'request_header.approved_by_acctg', '=', 'acctg.id')
						->select(
							'request_header.*',
							'request_lines.*',
							'stores.store_name',
							'cat.category_description',
							'req.name AS requested_name',
							'request_header.oic-status AS oic_status',
							'request_header.acctg-status AS acctg_status',
							'oic.name AS oic_name',
							'rec.name AS receipt_name',
							'acctg.name AS acctg_name',
							'request_header.date_receipt AS dateOfReceipt',
							'ac.description as accounting_description',
							'proc.name AS processed_name',
							'request_lines.deleted_at AS delete_date'
						)

						->whereIn('stores.id', $storeList)
						->where('request_header.deleted', '0')
						->get();
				} else {
					

					$_storeid = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->get();
					$approval_array = array();
					foreach ($_storeid as $matrix) {
						array_push($approval_array, $matrix->store_list);
					}

					$approval_string = implode(",", $approval_array);
					$storeList = array_map('intval', explode(",", $approval_string));

                    if( CRUDBooster::myId() == 437)
					{
						$reimbursedData = DB::table('request_header')
						->join('request_lines', 'request_header.id', '=', 'request_lines.request_header_id')
						->join('stores', 'request_header.store_id', '=', 'stores.id')
						->join('cms_users AS req', 'request_header.requested_by', '=', 'req.id')
						->join('category AS cat', 'request_lines.category_id', '=', 'cat.id')
						->leftjoin('accounting_category as ac', 'ac.id', '=', 'cat.accounting_category_id')
						->leftjoin('cms_users AS oic', 'request_header.approved_by_oic', '=', 'oic.id')
						->leftjoin('cms_users AS rec', 'request_header.receipt_by', '=', 'rec.id')
						->leftjoin('cms_users AS proc', 'request_header.processed_by', '=', 'proc.id')
						->leftjoin('cms_users AS acctg', 'request_header.approved_by_acctg', '=', 'acctg.id')
						->select(
							'request_header.*',
							'request_lines.*',
							'stores.store_name',
							'cat.category_description',
							'req.name AS requested_name',
							'request_header.oic-status AS oic_status',
							'request_header.acctg-status AS acctg_status',
							'oic.name AS oic_name',
							'rec.name AS receipt_name',
							'acctg.name AS acctg_name',
							'request_header.date_receipt AS dateOfReceipt',
							'ac.description as accounting_description',
							'proc.name AS processed_name',
							'request_lines.deleted_at AS delete_date'
						)
						->where('request_header.deleted', '0')
						->get();

					}else{
                        $reimbursedData = DB::table('request_header')
                            ->join('request_lines', 'request_header.id', '=', 'request_lines.request_header_id')
                            ->join('stores', 'request_header.store_id', '=', 'stores.id')
                            ->join('cms_users AS req', 'request_header.requested_by', '=', 'req.id')
                            ->join('category AS cat', 'request_lines.category_id', '=', 'cat.id')
                            ->leftjoin('accounting_category as ac', 'ac.id', '=', 'cat.accounting_category_id')
                            ->leftjoin('cms_users AS oic', 'request_header.approved_by_oic', '=', 'oic.id')
                            ->leftjoin('cms_users AS rec', 'request_header.receipt_by', '=', 'rec.id')
                            ->leftjoin('cms_users AS proc', 'request_header.processed_by', '=', 'proc.id')
                            ->leftjoin('cms_users AS acctg', 'request_header.approved_by_acctg', '=', 'acctg.id')
                            ->select(
                                'request_header.*',
                                'request_lines.*',
                                'stores.store_name',
                                'cat.category_description',
                                'req.name AS requested_name',
                                'request_header.oic-status AS oic_status',
                                'request_header.acctg-status AS acctg_status',
                                'oic.name AS oic_name',
                                'rec.name AS receipt_name',
                                'acctg.name AS acctg_name',
                                'request_header.date_receipt AS dateOfReceipt',
                                'ac.description as accounting_description',
                                'proc.name AS processed_name',
                                'request_lines.deleted_at AS delete_date'
                            )
                            ->whereIn('stores.id', $storeList)
                            ->where('request_header.deleted', '0')
                            ->get();
                    }
				}




				// dd($reimbursedData);
				// if(\Request::get('filter_column')) {

				// 	$filter_column = \Request::get('filter_column');

				// 	$reimbursedData->where(function($w) use ($filter_column,$fc) {
				// 		foreach($filter_column as $key=>$fc) {

				// 			$value = @$fc['value'];
				// 			$type  = @$fc['type'];

				// 			if($type == 'empty') {
				// 				$w->whereNull($key)->orWhere($key,'');
				// 				continue;
				// 			}

				// 			if($value=='' || $type=='') continue;

				// 			if($type == 'between') continue;

				// 			switch($type) {
				// 				default:
				// 					if($key && $type && $value) $w->where($key,$type,$value);
				// 				break;
				// 				case 'like':
				// 				case 'not like':
				// 					$value = '%'.$value.'%';
				// 					if($key && $type && $value) $w->where($key,$type,$value);
				// 				break;
				// 				case 'in':
				// 				case 'not in':
				// 					if($value) {
				// 						$value = explode(',',$value);
				// 						if($key && $value) $w->whereIn($key,$value);
				// 					}
				// 				break;
				// 			}
				// 		}
				// 	});

				// 	foreach($filter_column as $key=>$fc) {
				// 		$value = @$fc['value'];
				// 		$type  = @$fc['type'];
				// 		$sorting = @$fc['sorting'];

				// 		if($sorting!='') {
				// 			if($key) {
				// 				$orderData->orderby($key,$sorting);
				// 				$filter_is_orderby = true;
				// 			}
				// 		}

				// 		if ($type=='between') {
				// 			if($key && $value) $orderData->whereBetween($key,$value);
				// 		}

				// 		else {
				// 			continue;
				// 		}
				// 	}
				// }

				// $ordeDataLines = $orderData->orderBy('approved_at','asc')->get();
  
				foreach ($reimbursedData as $orderRow) {
				      
					// $item = Item::where('digits_code', $orderRow->digits_code)->first();
					// $itemBrand = Brand::where('id', $item->brand_id)->first();
					// $itemStoreCategory = StoreCategory::where('id', $item->store_category_id)->first();
					// $itemCategory = Category::where('id', $item->category_id)->first();
					// $itemWarehouseCategory = WarehouseCategory::where('id', $item->warehouse_category_id)->first();


					// $requestedDate = substr($orderRow->requested_at,0,10);
					// $reqDate = $requestedDate;	
					// $receiptDate = $orderRow->dateOfReceipt;
					// // dd($reqDate);
					// $reqqDate  = \Carbon\Carbon::parse($reqDate);
					// $recDate = \Carbon\Carbon::parse($receiptDate);
					
				

					if ($orderRow->is_row_deleted != 0) {
					  
						$orderRow->is_row_deleted = "Deleted Line";
					} else {
					   
						$orderRow->is_row_deleted = "";
					}

					if ($orderRow->receipt_at != null) {
						$receivedDate = substr($orderRow->receipt_at, 0, 10);
						$receiveDate = $receivedDate;
						$receiptDate = $orderRow->dateOfReceipt;
						// dd($reqDate);
						$recvDate  = \Carbon\Carbon::parse($receiveDate);
						$recDate = \Carbon\Carbon::parse($receiptDate);

						$minusdate = $recDate->diffInDays($recvDate, false);

						if ($minusdate == 0) {
							$minusdate = "0";
						}
					} else {
						$minusdate = "0";
					}

					// // dd($minusdate);
					// if($minusdate == 0)
					// {
					// 	$minusdate = "0";
					// }

					$request_version = "VERSION: ".$orderRow->version;

					$orderItems[] = array(
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toDateString(),	//'APPROVED DATE',
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toTimeString(), //'APPROVED TIME',
						$orderRow->is_row_deleted,
						$orderRow->delete_date,
						$request_version,
						$orderRow->invoice_no,
						$orderRow->reference_number, 				//'REPLENISHMENT REF#',
						$orderRow->store_name,				//'CHANNEL',
						$orderRow->item_description,					//'STORE',
						$orderRow->category_description,
						$orderRow->accounting_description,
						//$itemStoreCategory->store_category_description,	//'STORE CATEGORY',
						$orderRow->quantity,    //'CATEGORY'
						$orderRow->line_value,
						$orderRow->total_value,			// 	'BRAND',
						$orderRow->dateOfReceipt,					//'UPC CODE',
						$orderRow->requested_name,			//'ITEM DESCRIPTION',
						$orderRow->requested_at,		//'SKU LEGEND',
						$orderRow->oic_name,		//'ORDERED QTY',
						$orderRow->date_approved_oic,			//'APPROVED QTY',
						$orderRow->receipt_name,			//'REPLENISHMENT QTY',
						$orderRow->receipt_at,				//'REORDER QTY',
						$orderRow->processed_name,
						$orderRow->processed_at,
						$orderRow->acctg_name,
						$orderRow->date_approved_acctg,
						$orderRow->oic_status,
						$orderRow->acctg_status
						// $minusdate

					);
				}

				$headings = array(
					'DELETED LINES',
					'DELETED DATE',
					'REQUEST VERSION',
					'INVOICE NO',
					'REFERENCE NUMBER',
					'STORE',
					'ITEM DESCRIPTION',
					'CATEGORY DESCRIPTION',
					'ACCOUNTING DESCRIPTION',
					'QUANTITY',
					'LINE VALUE',
					'TOTAL VALUE',
					'INVOICE DATE',
					'REQUESTED BY',
					'REQUESTED DATE',
					'APPROVED BY OIC',
					'APPROVED DATE OIC',
					'RECEIVED BY',
					'RECEIVED DATE',
					'PROCESSED BY',
					'PROCESSED AT',
					'REIMBURSED BY',
					'REIMBURSED AT',
					'OIC STATUS',
					'ACCTG STATUS'
					// 'DATE RANGE'
				);

				$sheet->fromArray($orderItems, null, 'A1', false, false);
				$sheet->prependRow(1, $headings);
				$sheet->row(1, function ($row) {
					$row->setBackground('#FFFF00');
					$row->setAlignment('center');
				});
				// $cell = $sheet->getCell('X1')->getValue();

				// $sheet->getStyle('X1')->applyFromArray(array(
				// 	'fill' => array(
				// 		'type'  => PHPExcel_Style_Fill::FILL_SOLID,
				// 		'color' => array('rgb' => '76933C') //118,147,60->76933C
				// 	)
				// ));

				$i = 2;
				if($orderItems != null)
				{
				    foreach ($orderItems as $key => $item) {
				    
					$sheet->cell('N' . $i . ':' . 'O' . $i, function ($row) {
						$row->setBackground('#6998a3');
						$row->setAlignment('center');
					});

					$sheet->cell('P' . $i . ':' . 'Q' . $i, function ($row) {
						$row->setBackground('#a4e6f4');
						$row->setAlignment('center');
					});

					$sheet->cell('R' . $i . ':' . 'S' . $i, function ($row) {
						$row->setBackground('#d3c9c4');
						$row->setAlignment('center');
					});

					$sheet->cell('T' . $i . ':' . 'U' . $i, function ($row) {
						$row->setBackground('#f3bac3');
						$row->setAlignment('center');
					});

					$sheet->cell('V' . $i . ':' . 'W' . $i, function ($row) {
						$row->setBackground('#c47179');
						$row->setAlignment('center');
					});

					$i++;
				}
				}
				

				// $i = 2;
				// foreach($orderItems as $key=> $item)
				// {

				// 	if($item[24] == "REIMBURSED")
				// 	{

				// 		// $sheet->row($i, function($row){
				// 		// 	$row->setBackground('#78a847');
				// 		// 	$row->setAlignment('center');
				// 		//   });
				// 		$sheet->cell('X'.$i.':'.'Y'.$i, function($row){
				// 				$row->setBackground('#78a847');
				// 				$row->setAlignment('center');
				// 			  });
				// 	}else if($item[23] == "PENDING" || $item[24] == "PENDING")
				// 	{

				// 		$sheet->cell('X'.$i.':'.'Y'.$i, function($row){
				// 			$row->setBackground('#fbff93');#fbff93
				// 			$row->setAlignment('center');
				// 		  });
				// 	}
				// 	else if($item[24] == "RECEIVED")
				// 	{

				// 		$sheet->cell('X'.$i.':'.'Y'.$i, function($row){
				// 			$row->setBackground('#e0e4a6');
				// 			$row->setAlignment('center');
				// 		  });
				// 	}
				// 	else if($item[24] == "PROCESSED")
				// 	{

				// 		$sheet->cell('X'.$i.':'.'Y'.$i, function($row){
				// 			$row->setBackground('#9ad75d');
				// 			$row->setAlignment('center');
				// 		  });
				// 	}

				// 	$i++;

				// }

			});
		})->export('xlsx');
	}
	

    public function filteredtransactionExport()
	{

		$filename = 'Request Filtered Transactions - ' . date("d M Y - h.i.sa");
		$sheetname = 'Request Filtered Transactions' . date("d-M-Y");

		Excel::create($filename, function ($excel) {
			$excel->sheet('request-transactions', function ($sheet) {
				// Set auto size for sheet
				$sheet->setAutoSize(true);
				$sheet->setColumnFormat(array(
					'K' => '0.00',		//for line value
					'L' => '0.00'		//for total value
				));

				$result = array();
				if (CRUDBooster::myPrivilegeName() == 'Requestor') {
                    
					$store = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->first();
					
                    $reimbursedData = DB::table('request_header')
						->join('request_lines', 'request_header.id', '=', 'request_lines.request_header_id')
						->join('stores', 'request_header.store_id', '=', 'stores.id')
						->join('cms_users', 'request_header.requested_by', '=', 'cms_users.id')
						->join('category AS cat', 'request_lines.category_id', '=', 'cat.id')
						->leftjoin('accounting_category as ac', 'ac.id', '=', 'cat.accounting_category_id')
						->leftjoin('cms_users AS cms_users1', 'request_header.approved_by_oic', '=', 'cms_users1.id')
						->leftjoin('cms_users AS cms_users2', 'request_header.receipt_by', '=', 'cms_users2.id')
						->leftjoin('cms_users AS cms_users3', 'request_header.processed_by', '=', 'cms_users3.id')
						->leftjoin('cms_users AS cms_users4', 'request_header.approved_by_acctg', '=', 'cms_users4.id')
						->select(
							'request_header.*',
							'request_lines.*',
							'stores.store_name',
							'cat.category_description',
							'cms_users.name AS requested_name',
							'request_header.oic-status AS oic_status',
							'request_header.acctg-status AS acctg_status',
							'cms_users1.name AS oic_name',
							'cms_users2.name AS receipt_name',
							'cms_users4.name AS acctg_name',
							'request_header.date_receipt AS dateOfReceipt',
							'ac.description as accounting_description',
							'cms_users3.name AS processed_name',
							'request_lines.deleted_at AS delete_date'
						)->where('stores.id', $store->store_list)
						->where('stores.store_status', 'ACTIVE');

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
						
						$reimbursedData->where('request_header.deleted', '0');
						$reimbursedData->orderBy('request_header.reference_number','ASC');
						$result = $reimbursedData->get();
						
					
				} else if (CRUDBooster::myPrivilegeName() == 'OIC') {

					$oic_storeid = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->get();
					// dd($oic_storeid);
					$approval_array = array();
					foreach ($oic_storeid as $matrix) {
						array_push($approval_array, $matrix->store_list);
					}
					$approval_string = implode(",", $approval_array);
					$storeList = array_map('intval', explode(",", $approval_string));

					$reimbursedData = DB::table('request_header')
						->join('request_lines', 'request_header.id', '=', 'request_lines.request_header_id')
						->join('stores', 'request_header.store_id', '=', 'stores.id')
						->join('cms_users', 'request_header.requested_by', '=', 'cms_users.id')
						->join('category AS cat', 'request_lines.category_id', '=', 'cat.id')
						->leftjoin('accounting_category as ac', 'ac.id', '=', 'cat.accounting_category_id')
						->leftjoin('cms_users AS cms_users1', 'request_header.approved_by_oic', '=', 'cms_users1.id')
						->leftjoin('cms_users AS cms_users2', 'request_header.receipt_by', '=', 'cms_users2.id')
						->leftjoin('cms_users AS cms_users3', 'request_header.processed_by', '=', 'cms_users3.id')
						->leftjoin('cms_users AS cms_users4', 'request_header.approved_by_acctg', '=', 'cms_users4.id')
						->select(
							'request_header.*',
							'request_lines.*',
							'stores.store_name',
							'cat.category_description',
							'cms_users.name AS requested_name',
							'request_header.oic-status AS oic_status',
							'request_header.acctg-status AS acctg_status',
							'cms_users1.name AS oic_name',
							'cms_users2.name AS receipt_name',
							'cms_users4.name AS acctg_name',
							'request_header.date_receipt AS dateOfReceipt',
							'ac.description as accounting_description',
							'cms_users3.name AS processed_name',
							'request_lines.deleted_at AS delete_date'
						)->whereIn('stores.id', $storeList);

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

						$reimbursedData->where('request_header.deleted', '0');
						$reimbursedData->orderBy('request_header.reference_number','ASC');
						$result = $reimbursedData->get();

				} else {

					$_storeid = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->get();
					// dd($oic_storeid);
					$approval_array = array();
					foreach ($_storeid as $matrix) {
						array_push($approval_array, $matrix->store_list);
					}
					$approval_string = implode(",", $approval_array);
					$storeList = array_map('intval', explode(",", $approval_string));

                    if( CRUDBooster::myId() == 437)
					{
                        $reimbursedData = DB::table('request_header')
                        ->join('request_lines', 'request_header.id', '=', 'request_lines.request_header_id')
                        ->join('stores', 'request_header.store_id', '=', 'stores.id')
                        ->join('cms_users', 'request_header.requested_by', '=', 'cms_users.id')
                        ->join('category AS cat', 'request_lines.category_id', '=', 'cat.id')
                        ->leftjoin('accounting_category as ac', 'ac.id', '=', 'cat.accounting_category_id')
                        ->leftjoin('cms_users AS cms_users1', 'request_header.approved_by_oic', '=', 'cms_users1.id')
                        ->leftjoin('cms_users AS cms_users2', 'request_header.receipt_by', '=', 'cms_users2.id')
                        ->leftjoin('cms_users AS cms_users3', 'request_header.processed_by', '=', 'cms_users3.id')
                        ->leftjoin('cms_users AS cms_users4', 'request_header.approved_by_acctg', '=', 'cms_users4.id')
                        ->select(
                            'request_header.*',
                            'request_lines.*',
                            'stores.store_name',
                            'cat.category_description',
                            'cms_users.name AS requested_name',
                            'request_header.oic-status AS oic_status',
                            'request_header.acctg-status AS acctg_status',
                            'cms_users1.name AS oic_name',
                            'cms_users2.name AS receipt_name',
                            'cms_users4.name AS acctg_name',
                            'request_header.date_receipt AS dateOfReceipt',
                            'ac.description as accounting_description',
                            'cms_users3.name AS processed_name',
                            'request_lines.deleted_at AS delete_date'
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

                        $reimbursedData->where('request_header.deleted', '0');
                        $reimbursedData->orderBy('request_header.reference_number','ASC');
                        $result = $reimbursedData->get();
                    }else{

                        $reimbursedData = DB::table('request_header')
                        ->join('request_lines', 'request_header.id', '=', 'request_lines.request_header_id')
                        ->join('stores', 'request_header.store_id', '=', 'stores.id')
                        ->join('cms_users', 'request_header.requested_by', '=', 'cms_users.id')
                        ->join('category AS cat', 'request_lines.category_id', '=', 'cat.id')
                        ->leftjoin('accounting_category as ac', 'ac.id', '=', 'cat.accounting_category_id')
                        ->leftjoin('cms_users AS cms_users1', 'request_header.approved_by_oic', '=', 'cms_users1.id')
                        ->leftjoin('cms_users AS cms_users2', 'request_header.receipt_by', '=', 'cms_users2.id')
                        ->leftjoin('cms_users AS cms_users3', 'request_header.processed_by', '=', 'cms_users3.id')
                        ->leftjoin('cms_users AS cms_users4', 'request_header.approved_by_acctg', '=', 'cms_users4.id')
                        ->select(
                            'request_header.*',
                            'request_lines.*',
                            'stores.store_name',
                            'cat.category_description',
                            'cms_users.name AS requested_name',
                            'request_header.oic-status AS oic_status',
                            'request_header.acctg-status AS acctg_status',
                            'cms_users1.name AS oic_name',
                            'cms_users2.name AS receipt_name',
                            'cms_users4.name AS acctg_name',
                            'request_header.date_receipt AS dateOfReceipt',
                            'ac.description as accounting_description',
                            'cms_users3.name AS processed_name',
                            'request_lines.deleted_at AS delete_date'
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

                        $reimbursedData->whereIn('stores.id', $storeList)->where('request_header.deleted', '0');
                        $reimbursedData->orderBy('request_header.reference_number','ASC');
                        $result = $reimbursedData->get();
                    }
                }
				
  
				foreach ($result as $orderRow) {
				

					if ($orderRow->is_row_deleted != 0) {
					  
						$orderRow->is_row_deleted = "Deleted Line";
					} else {
					   
						$orderRow->is_row_deleted = "";
					}

					if ($orderRow->receipt_at != null) {
						$receivedDate = substr($orderRow->receipt_at, 0, 10);
						$receiveDate = $receivedDate;
						$receiptDate = $orderRow->dateOfReceipt;
						// dd($reqDate);
						$recvDate  = \Carbon\Carbon::parse($receiveDate);
						$recDate = \Carbon\Carbon::parse($receiptDate);

						$minusdate = $recDate->diffInDays($recvDate, false);

						if ($minusdate == 0) {
							$minusdate = "0";
						}
					} else {
						$minusdate = "0";
					}

					// // dd($minusdate);
					// if($minusdate == 0)
					// {
					// 	$minusdate = "0";
					// }

					$request_version = "VERSION: ".$orderRow->version;

					$orderItems[] = array(
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toDateString(),	//'APPROVED DATE',
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toTimeString(), //'APPROVED TIME',
						$orderRow->is_row_deleted,
						$orderRow->delete_date,
						$request_version,
						$orderRow->invoice_no,
						$orderRow->reference_number, 				//'REPLENISHMENT REF#',
						$orderRow->store_name,				//'CHANNEL',
						$orderRow->item_description,					//'STORE',
						$orderRow->category_description,
						$orderRow->accounting_description,
						//$itemStoreCategory->store_category_description,	//'STORE CATEGORY',
						$orderRow->quantity,    //'CATEGORY'
						$orderRow->line_value,
						$orderRow->total_value,			// 	'BRAND',
						$orderRow->dateOfReceipt,					//'UPC CODE',
						$orderRow->requested_name,			//'ITEM DESCRIPTION',
						$orderRow->requested_at,		//'SKU LEGEND',
						$orderRow->oic_name,		//'ORDERED QTY',
						$orderRow->date_approved_oic,			//'APPROVED QTY',
						$orderRow->receipt_name,			//'REPLENISHMENT QTY',
						$orderRow->receipt_at,				//'REORDER QTY',
						$orderRow->processed_name,
						$orderRow->processed_at,
						$orderRow->acctg_name,
						$orderRow->date_approved_acctg,
						$orderRow->oic_status,
						$orderRow->acctg_status
						// $minusdate

					);
				}

				$headings = array(
					'DELETED LINES',
					'DELETED DATE',
					'REQUEST VERSION',
					'INVOICE NO',
					'REFERENCE NUMBER',
					'STORE',
					'ITEM DESCRIPTION',
					'CATEGORY DESCRIPTION',
					'ACCOUNTING DESCRIPTION',
					'QUANTITY',
					'LINE VALUE',
					'TOTAL VALUE',
					'INVOICE DATE',
					'REQUESTED BY',
					'REQUESTED DATE',
					'APPROVED BY OIC',
					'APPROVED DATE OIC',
					'RECEIVED BY',
					'RECEIVED DATE',
					'PROCESSED BY',
					'PROCESSED AT',
					'REIMBURSED BY',
					'REIMBURSED AT',
					'OIC STATUS',
					'ACCTG STATUS'
					// 'DATE RANGE'
				);

				$sheet->fromArray($orderItems, null, 'A1', false, false);
				$sheet->prependRow(1, $headings);
				$sheet->row(1, function ($row) {
					$row->setBackground('#FFFF00');
					$row->setAlignment('center');
				});

				$i = 2;
				if($orderItems != null)
				{
				    foreach ($orderItems as $key => $item) {
				    
					$sheet->cell('N' . $i . ':' . 'O' . $i, function ($row) {
						$row->setBackground('#6998a3');
						$row->setAlignment('center');
					});

					$sheet->cell('P' . $i . ':' . 'Q' . $i, function ($row) {
						$row->setBackground('#a4e6f4');
						$row->setAlignment('center');
					});

					$sheet->cell('R' . $i . ':' . 'S' . $i, function ($row) {
						$row->setBackground('#d3c9c4');
						$row->setAlignment('center');
					});

					$sheet->cell('T' . $i . ':' . 'U' . $i, function ($row) {
						$row->setBackground('#f3bac3');
						$row->setAlignment('center');
					});

					$sheet->cell('V' . $i . ':' . 'W' . $i, function ($row) {
						$row->setBackground('#c47179');
						$row->setAlignment('center');
					});

					$i++;
				}
				}
			

			});
		})->export('xlsx');
	}
}
