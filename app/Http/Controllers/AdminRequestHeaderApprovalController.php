<?php

namespace App\Http\Controllers;

use Session;
use DB;
use CRUDBooster;
use Excel;
//use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Input as Input;
//use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;


class AdminRequestHeaderApprovalController extends \crocodicstudio\crudbooster\controllers\CBController
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

        //---unhide this after covid-19---
        // 		if (CRUDBooster::myPrivilegeName() == 'Requestor') {
        // 			// $this->addaction[] = ['title'=>'Edit','url'=>'request_header_approval/detail/[id]','icon'=>'fa fa-eye',"showIf"=>"[oic-status] == 'APPROVED' || [oic-status] == 'PENDING'"];
        // 			$this->addaction[] = ['title' => 'Edit', 'url' => 'request_header_approval/edit/[id]', 'icon' => 'fa fa-pencil', "showIf" => "[oic-status] == 'REJECTED' || [oic-status] == 'PENDING' || [acctg-status] == 'REJECTED'"];
        // 			// $this->addaction[] = ['title' => 'Delete', 'url' => 'request_header_approval/delete/[id]', 'icon' => 'fa fa-trash', "confirmation" => true, "showIf" => "[oic-status] == 'REJECTED' || [oic-status] == 'PENDING' || [acctg-status] == 'REJECTED'"];
        // 			$this->addaction[] = ['title' => 'View', 'url' => 'request_header_approval/detail/[id]', 'icon' => 'fa fa-eye'];
        // 		}
        // 		if (CRUDBooster::myPrivilegeName() == 'AP Receiver' || CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
        // 			// $this->addaction[] = ['title' => 'Receipt Received', 'url' => 'request_header_approval/receipt/[id]', "confirmation"=>true,"confirmation_title"=>"CONFIRMATION","confirmation_text"=>"Are you sure you want to receive this request?", 'icon' => 'fa fa-file-text-o', "showIf" => "[oic-status] == 'APPROVED' && [acctg-status] == 'PENDING'"];
        // 			$this->addaction[] = ['title' => 'Approval', 'url' => 'request_header_approval/approval/[id]', 'icon' => 'fa fa-thumbs-up', "showIf" => "[oic-status] == 'APPROVED' && [acctg-status] == 'PENDING'"];
        // 			// $this->addaction[] = ['title' => 'View', 'url' => 'request_header_approval/detail/[id]', 'icon' => 'fa fa-eye', "showIf" => "[oic-status] == 'APPROVED' && [acctg-status] == 'RECEIVED'"];
        // 		} else if (CRUDBooster::myPrivilegeName() == 'OIC') {
        // 			$this->addaction[] = ['title' => 'Approval', 'url' => 'request_header_approval/approval/[id]', 'icon' => 'fa fa-thumbs-up'];
        // 		} else if (CRUDBooster::myPrivilegeName() == 'AP Checker' || CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
        // 			$this->addaction[] = ['title' => 'Approval', 'url' => 'request_header_approval/approval/[id]', 'icon' => 'fa fa-thumbs-up', "showIf" => "[oic-status] == 'APPROVED' && [acctg-status] == 'RECEIVED'"];
        // 		} else if (CRUDBooster::myPrivilegeName() == 'Treasury' || CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
        // 			$this->addaction[] = ['title' => 'Approval', 'url' => 'request_header_approval/approval/[id]', 'icon' => 'fa fa-thumbs-up', "showIf" => "[oic-status] == 'APPROVED' && [acctg-status] == 'PROCESSED'"];
        // 		}
        //---added by cris 20200806------------------------------------------------------
		// if(CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperAdmin())
		// 	{
		// 		$this->addaction[] = ['title' => 'Approval', 'url' => 'request_header_approval/approval/[id]', 'icon' => 'fa fa-thumbs-up', "showIf" => "[oic-status] == 'APPROVED' && [acctg-status] == 'PROCESSED'"];
		// 	}
		//	//---------------------------------------------------------------------------------
		//------------------------------------
		
		//---use this for covid-19---
			//---edited by cris 20200824-----
			if (CRUDBooster::myPrivilegeName() == 'Requestor') {
				
        			$this->addaction[] = ['title' => 'Edit', 'url' => 'request_header_approval/edit/[id]', 'icon' => 'fa fa-pencil', "showIf" => "[oic-status] == 'REJECTED' || [oic-status] == 'PENDING' || [acctg-status] == 'REJECTED'"];
        			$this->addaction[] = ['title' => 'View', 'url' => 'request_header_approval/detail/[id]', 'icon' => 'fa fa-eye'];
			}
			else if (CRUDBooster::myPrivilegeName() == 'OIC') {
					$this->addaction[] = ['title' => 'Approval', 'url' => 'request_header_approval/approval/[id]', 'icon' => 'fa fa-thumbs-up'];
			}
			else if (CRUDBooster::myPrivilegeName() == 'AP Checker' ) {//|| CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()
				$this->addaction[] = ['title' => 'Approval', 'url' => 'request_header_approval/approval/[id]', 'icon' => 'fa fa-thumbs-up', "showIf" => "[oic-status] == 'APPROVED' && [acctg-status] == 'PENDING'"];
			}
			else if (CRUDBooster::myPrivilegeName() == 'Treasury') {
				
				$this->addaction[] = ['title' => 'Approval', 'url' => 'request_header_approval/approval/[id]', 'icon' => 'fa fa-thumbs-up', "showIf" => "[oic-status] == 'APPROVED' && [acctg-status] == 'PROCESSED'"];
			}
			// if(CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperAdmin())
			// {
			// 	$this->addaction[] = ['title' => 'Approval', 'url' => 'request_header_approval/approval/[id]', 'icon' => 'fa fa-thumbs-up', "showIf" => "[oic-status] == 'APPROVED' && [acctg-status] == 'PROCESSED'"];
			// }
			//---------------------------------
		//----------------------------

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
		if (CRUDBooster::getCurrentMethod() == 'getIndex') {
			$this->index_button[] = [
				"title" => "Export",
				"label" => "Export Approval",
				"icon" => "fa fa-download", "url" => CRUDBooster::adminpath('export-approval') . '?' . urldecode(http_build_query(@$_GET))
			];
			
			$this->index_button[] = [
				"title" => "Export",
				"label" => "Export Filtered Approval",
				"icon" => "fa fa-download", "url" => CRUDBooster::adminpath('export-filtered-approval') . '?' . urldecode(http_build_query(@$_GET))
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

			$query->whereIn('stores.id', $storeList)
				->where('request_header.status', 'REQUESTED')
				->where('request_header.deleted', '0');
		} else if (CRUDBooster::myPrivilegeName() == 'AP Receiver') {
			$query->where('request_header.status', 'AUDITED')
				->where('request_header.deleted', '0');
		}
		// //----unhide this after covid-19------------------------
        // 		else if (CRUDBooster::myPrivilegeName() == 'AP Checker') {
        // 			$query->where('request_header.status', 'RECEIPTED')
        // 				->where('request_header.deleted', '0');
        // 		} 
		// //-------------------------------------------------------
		
		// //----use this for covid-19---------------------------
			//---edited by cris 20200824---------------------------
			else if (CRUDBooster::myPrivilegeName() == 'AP Checker') {
				$checker_storeid = DB::table('approval_matrices')
				->where('status', 'ACTIVE')
				->where('cms_users_id', CRUDBooster::myId())->get();
				// dd($oic_storeid);
				$approval_array = array();
				foreach ($checker_storeid as $matrix) {
					array_push($approval_array, $matrix->store_list);
				}
				$approval_string = implode(",", $approval_array);
				$storeList = array_map('intval', explode(",", $approval_string));

				$query->whereIn('stores.id', $storeList)
					->where('request_header.oic-status', 'APPROVED')
					->where('request_header.status', 'AUDITED')
					->where('request_header.deleted', '0');
			} 
			//-----------------------------------------------------
		// // ---------------------------------------------------
		else if (CRUDBooster::myPrivilegeName() == 'Treasury') {
			$treasury_storeid = DB::table('approval_matrices')
				->where('status', 'ACTIVE')
				->where('cms_users_id', CRUDBooster::myId())->get();
				// dd($oic_storeid);
				$approval_array = array();
				foreach ($treasury_storeid as $matrix) {
					array_push($approval_array, $matrix->store_list);
				}
				$approval_string = implode(",", $approval_array);
				$storeList = array_map('intval', explode(",", $approval_string));
				$query->whereIn('stores.id', $storeList)
				->where('request_header.status', 'PROCESSED')
				->where('request_header.deleted', '0');
		} else if (CRUDBooster::myPrivilegeName() == 'Requestor') {
			//-----edited by cris 20200824-----------
			// $query->where('request_header.requested_by', CRUDBooster::myId())
			// 	->where('request_header.deleted', '0')
			// 	->where('request_header.status', 'REQUESTED')
			// 	->orWhere('request_header.status', 'DISAPPROVED');
			
			$query->join('approval_matrices', 'request_header.store_id', '=', 'approval_matrices.store_list')
				->where('approval_matrices.cms_users_id', CRUDBooster::myId())
				->where('request_header.id', '!=', '0')
				->where('approval_matrices.status', 'ACTIVE')
				->where('request_header.deleted', '0')
				->where('request_header.status', '!=','REIMBURSED');
			//-----------------------------------------
		} else if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
			$query->where('request_header.deleted', '0');
			 //   ->where('request_header.status', 'REQUESTED')
				// ->orWhere('request_header.status', 'DISAPPROVED')
				// ->orWhere('request_header.status', 'AUDITED')
				// ->orWhere('request_header.status', 'RECEIPTED')
				// //--------added by cris 20200806-----------------------
				// ->orWhere('request_header.status', 'PROCESSED');
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
	
	public function getDelete($id)
	{
		DB::table('request_header')
			->where('id', $id)
			->update([
				'deleted' => '1'
			]);

		// return redirect('admin/request_header_approval')->with('message', 'You have successfully delete a request!!');
		CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully delete a request!!', 'success')->send();
	}

	public function getApproval($id)
	{
		$this->cbLoader();
		// if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperAdmin() || CRUDBooster::myPrivilegeName() == 'OIC') {
		$data = [];
		$data['page_title'] = 'Requested Receipt';
		$data['errorpic'] = 'vendor/crudbooster/cancel.png';

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
			->select(
				'request_lines.*',
				'category.category_description',
				'request_header.date_receipt',
				'request_header.reference_number',
				'request_header.store_id',
				'request_header.requested_by',
				'request_header.status',
				'request_header.receipt_photo',
				'request_header.approved_by_oic',
				'request_header.receipt_by',
				'request_header.processed_by',
				'request_header.comment',
				'request_header.requested_at',
				'request_header.version',
				'request_header.invoice_no'
			)
			->join('category', 'category.id', '=', 'request_lines.category_id')
			->join('request_header', 'request_lines.request_header_id', '=', 'request_header.id')
			->where('request_lines.request_header_id', '=', $id)
			->where('request_lines.is_row_deleted', '=', '0')->get();

		$data['privilege_name'] = CRUDBooster::myPrivilegeName();
		// dd(($data['datas']));

		//Please use cbView method instead view method from laravel
		if (CRUDBooster::myPrivilegeName() == 'Requestor') {
			return View('customview.request-details', $data)->render();
		} else if (CRUDBooster::myPrivilegeName() == 'OIC') {
			return View('customview.request_approve', $data)->render();
		} else if (in_array(CRUDBooster::myPrivilegeName(), ["AP Receiver", "AP Checker", "Treasury"])) {
			// dd($data);
			return View('customview.request_approve_accounting', $data)->render();
		} else if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
			$status = $data['datas'];

			for ($i = 0; $i < $status; $i++) {
				if ($status[$i]->status === 'REQUESTED' || $status[$i]->status === 'DISAPPROVED') {

					return View('customview.request_approve', $data)->render();
				} 
				// //----unhide this after covid-19--------------------------
				// else if ($status[$i]->status === 'AUDITED' || $status[$i]->status === 'RECEIPTED') {
				// 	return View('customview.request_approve_accounting', $data)->render();
				// }
				//---------------------------------------------------------------
				
				// //----use this for covid-19--------------------------------------------------
				else if ($status[$i]->status === 'PROCESSED') {
					return View('customview.request_approve_accounting', $data)->render();
				}
				// //-------------------------------------------------------------------------------
			}
		}
	}

	public function getDetail($id) //we dont use this because we have getApproval method
	{

		$this->cbLoader();
		// if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperAdmin() || CRUDBooster::myPrivilegeName() == 'OIC') {
		$data = [];
		$data['page_title'] = 'Requested Receipt';
		$data['errorpic'] = 'vendor/crudbooster/cancel.png';

		$data['stores'] = DB::table('stores')->where('store_status', 'ACTIVE')->orderby('store_name')->get();

		$data['store_names'] = DB::table('stores')
			->select('stores.store_name')
			->join('request_lines', 'stores.id', '=', 'request_lines.store_id')
			->where('stores.store_status', 'ACTIVE')
			->where('request_lines.request_header_id', '=', $id)->first();


		// $data['categories'] = DB::table('category')->select('category_description')->get();
		// ->join('request_lines','category.id', '=', 'request_lines.category_id')
		// ->where('request_lines.request_header_id', '=',$id)->pluck('category.category_description');

		$data['privilege_name'] = CRUDBooster::myPrivilegeName();

		$data['datas'] = DB::table('request_lines')
			->select(
				'request_lines.*',
				'category.category_description',
				'request_header.date_receipt',
				'request_header.reference_number',
				'request_header.store_id',
				'request_header.requested_by',
				'request_header.status',
				'request_header.receipt_photo',
				'request_header.approved_by_oic',
				'request_header.receipt_by',
				'request_header.processed_by',
				'request_header.comment',
				'request_header.requested_at',
				'request_header.version',
				'request_header.invoice_no'
			)
			->join('category', 'category.id', '=', 'request_lines.category_id')
			->join('request_header', 'request_lines.request_header_id', '=', 'request_header.id')
			->where('request_lines.request_header_id', '=', $id)
			->where('request_lines.is_row_deleted', '=', '0')->get();
		// dd($data['datas']);


		//Please use cbView method instead view method from laravel
		if (CRUDBooster::myPrivilegeName() == 'Requestor') {
			return View('customview.request-details', $data)->render();
		} else if (CRUDBooster::myPrivilegeName() == 'OIC') {
			return View('customview.request_approve', $data)->render();
		} else if (in_array(CRUDBooster::myPrivilegeName(), ["AP Receiver", "AP Checker", "Treasury"])) {
			return View('customview.request_approve_accounting', $data)->render();
		} else if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
			$status = $data['datas'];

			for ($i = 0; $i < $status; $i++) {
				if ($status[$i]->status === 'REQUESTED' || $status[$i]->status === 'DISAPPROVED') {

					return View('customview.request_approve', $data)->render();
				} else if ($status[$i]->status === 'AUDITED' || $status[$i]->status === 'RECEIPTED') {
					return View('customview.request_approve_accounting', $data)->render();
				}
			}
		}
	}

	public function receiptDetail($id)
	{
		$this->cbLoader();
		// if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperAdmin() || CRUDBooster::myPrivilegeName() == 'OIC') {
		$data = [];
		$data['page_title'] = 'Requested Receipt';
		$data['errorpic'] = 'vendor/crudbooster/cancel.png';

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
			->select('request_lines.*', 'category.category_description', 'request_header.date_receipt', 'request_header.reference_number', 'request_header.store_id', 'request_header.requested_by', 'request_header.status', 'request_header.receipt_photo', 'request_header.approved_by_oic', 'request_header.comment', 'request_header.version', 'request_header.invoice_no')
			->join('category', 'category.id', '=', 'request_lines.category_id')
			->join('request_header', 'request_lines.request_header_id', '=', 'request_header.id')
			->where('request_lines.request_header_id', '=', $id)
			->where('request_lines.is_row_deleted', '=', '0')->get();
		// dd($data['datas']);


		return View('customview.request_receiptview', $data)->render();
		// $this->cbView("customview.request_receiptview", $data);

	}

	public function getEdit($id)
	{
		$this->cbLoader();
		$data = [];
		$data['page_title'] = 'Edit Receipt';


		$data['stores'] = DB::table('stores')->where('store_status', 'ACTIVE')->orderby('store_name')->get();
		$data['categorys'] = DB::table('category')->where('category_status', 'ACTIVE')->orderby('category_description', 'ASC')->get();

		

		$data['store_names'] = DB::table('stores')
			->select('stores.store_name')
			->join('request_lines', 'stores.id', '=', 'request_lines.store_id')
			->where('stores.store_status', 'ACTIVE')
			->where('request_lines.request_header_id', '=', $id)->first();

		$data['datas'] = DB::table('request_lines')
			->select('request_lines.*', 'category.category_description', 'request_header.date_receipt', 'request_header.reference_number', 'request_header.store_id', 'request_header.requested_by', 'request_header.requested_at', 'request_lines.request_header_id', 'request_header.receipt_photo', 'request_header.comment', 'request_header.status', 'request_header.date_receipt', 'request_header.requested_by', 'request_header.version', 'request_header.invoice_no')
			->join('category', 'category.id', '=', 'request_lines.category_id')
			->join('request_header', 'request_lines.request_header_id', '=', 'request_header.id')
			->where('request_lines.request_header_id', '=', $id)
			->where('request_lines.is_row_deleted', '=', '0')->get();
		//   dd(count($data['datas']));

		// $getstatus = $data['datas'];
		// for ($i = 0; $i < $getstatus; $i++) {
		// 	if ($getstatus[$i]->status == 'DISAPPROVED') {
		// 		DB::table('request_lines')->where('request_header_id', $id)
		// 			->update([
		// 				'is_row_deleted' => 0
		// 			]);
		// 	}
		// }

		// dd($data['datas']);
		return view("customview.request-edit", $data);
		//return cbview('customview.request-edit', $data)->render();

	}

	public function update(Request $request)
	{
		$data = $request->all();

		// dd($data);
		$category_name = $data['category'];
		$item_description = $data['itemdescriptionTF'];
		$quantity = $data['quantityTF'];
		$value = $data['valueTF'];
		$total_value = $data['totalvalueTF'];
		$created_at = $data['requested_at'];
		$new_store = $data['store']; //this is the new store
		$date_receipt = $data['dateReceipt'];
		$image = $data['image'];
		$old_ids = $data['id_row'];
		$computed_totalvalue = $data['totalValue2'];

		//for new data
		$new_category_name = $data['new-category'];
		$new_item_description = $data['new-itemdescriptionTF'];
		$new_quantity = $data['new-quantityTF'];
		$new_value = $data['new-valueTF'];
		$new_total_value = $data['new-totalvalueTF'];

		//select storeid FROM stores where store_name 
		$newstore_id = DB::table('stores')
			->where('store_name', $new_store)
			->where('store_status', 'ACTIVE')
			->value('id');

		// //delete
		// DB::table('request_lines')
		// 	->where('request_header_id', $data['request_header_id'])
		// 	->where('store_id', $data['storeTF']) //this is the previous store
		// 	->delete();

		

		//check the invoice# if already exist store_id,invoice_date,total_value
		$invoice = DB::table('request_header')
			->where('deleted', '0')
			->where('id', '!=', $data['request_header_id'])
			->where('invoice_no', $data['invoice_number'])
			->where('total_value', $computed_totalvalue)->first();

		if ($invoice->id != null || $invoice->id != 0) {
			CRUDBooster::redirect(CRUDBooster::mainpath(), 'invoice# already exist!!', 'danger')->send();
		}

		$checks = DB::table('request_header')->where('invoice_no', $data['invoice_number'])
			->where('id', '!=', $data['request_header_id'])
			->where('date_receipt', $date_receipt)->get(['id']);

		foreach ($checks as $check) {
			// if ($check->id != null || $check->id != 0) {
			// 	$check_if_exist = DB::table('request_lines')
			// 		->where('request_header_id', $check->id)
			// 		->where('category_id', '63')->first();

			// 	if ($check_if_exist->item_description != null || !empty($check_if_exist->item_description)) {

			// 		foreach($new_item_description as $new)
			// 		{
			// 			if ($check_if_exist->item_description == $new) {

			// 				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Transportation fee already exist!!', 'danger')->send();
			// 			}
			// 		}

			// 		foreach ($item_description as $item) {
			// 			if ($check_if_exist->item_description == $item) {

			// 				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Transportation fee already exist!!', 'danger')->send();
			// 			}
			// 		}


			// 	}
			// }
			if ($check->id != null || !empty($check->id)) {
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Invoice# and Invoice date exist!!', 'danger')->send();
			}
		}

		DB::beginTransaction();

		try {

			if ($image != null) {
				if (Input::hasFile('image')) {
					$file = Input::file('image');
					$extension = $file->getClientOriginalExtension();
					$extension1 =  time() . '.' . $file->getClientOriginalExtension();
					$filename = $extension1;
					$file->move('storage/images/', $filename);

					//update request header
					$receipt_photo = 'storage/images/' . $extension1;
					$header_status = 'REQUESTED';

					//---unhide this after covid-19-----------------
					DB::table('request_header')
						->where('id', $data['request_header_id'])
						->update([

							'store_id' => $newstore_id,
							'date_receipt' => $date_receipt,
							'receipt_photo' => $receipt_photo,
							'status' => $header_status,
							'oic-status' => 'PENDING',
							'acctg-status' => null,
							'comment'	=> $data['comments'],
							'date_approved_oic' => null,
							'date_disapproved_oic' => null,
							'approved_by_oic' => '0',
							'disapproved_by_oic' => '0',
							'date_approved_acctg' => null,
							'date_disapproved_acctg' => null,
							'approved_by_acctg' => '0',
							'disapproved_by_acctg' => '0',
							'receipt_by' => '0',
							'receipt_at' => null,
							'version' => $data['requestversion'],
							'invoice_no' => $data['invoice_number'],
							'total_value' => $computed_totalvalue
						]);
					//------------------------------------------------

					//---use this for covid-19-----------------------
					// DB::table('request_header')
					// 	->where('id', $data['request_header_id'])
					// 	->update([

					// 		'store_id' => $newstore_id,
					// 		'date_receipt' => $date_receipt,
					// 		'receipt_photo' => $receipt_photo,
					// 		'status' => $header_status,
					// 		'oic-status' => 'APPROVED',
					// 		'acctg-status' => 'PENDING',

					// 		'date_approved_oic' => date('Y-m-d H:i:s'),
					// 		'date_disapproved_oic' => null,
					// 		'approved_by_oic' => CRUDBooster::myId(),
					// 		'disapproved_by_oic' => '0',
					// 		'date_approved_acctg' => null,
					// 		'date_disapproved_acctg' => null,
					// 		'approved_by_acctg' => '0',
					// 		'disapproved_by_acctg' => '0',
					// 		'receipt_by' => '0',
					// 		'receipt_at' => null,
					// 		'version' => $data['requestversion'],
					// 		'invoice_no' => $data['invoice_number'],
					// 		'total_value' => $computed_totalvalue
					// 	]);
					//--------------------------------------------

					//update the old data
					for ($i = 0; $i < count($old_ids); $i++) {
						$category_id[$i] = DB::table('category')
							->where('category_status', 'ACTIVE')
							->where('category_description', $category_name[$i])->value('id');

						DB::table('request_lines')
							->where('id', $old_ids[$i])
							->update([
								'category_id' => $category_id[$i],
								'item_description' => $item_description[$i],
								'quantity'		   => $quantity[$i],
								'line_value'	   => $value[$i],
								'total_value'	   => $total_value[$i]
							]);
					}


					//insert the new data for request lines
					$insert_into_lines = array();
					for ($i = 0; $i < count($new_item_description); $i++) {
						//select categoryid FROM category
						$category_id[$i] = DB::table('category')
							->where('category_status', 'ACTIVE')
							->where('category_description', $new_category_name[$i])->value('id');
						$insert_into_lines[$i]['item_description'] = $new_item_description[$i];
						$insert_into_lines[$i]['quantity'] = $new_quantity[$i];
						$insert_into_lines[$i]['line_value'] = $new_value[$i];
						$insert_into_lines[$i]['total_value'] = $new_total_value[$i];
						$insert_into_lines[$i]['request_header_id'] =  $data['request_header_id'];
						$insert_into_lines[$i]['store_id'] = $newstore_id;
						$insert_into_lines[$i]['category_id'] = $category_id[$i];
						$insert_into_lines[$i]['created_at'] = $created_at;
					}
					DB::table('request_lines')->insert($insert_into_lines);

					//get the store of requestor
					$requestor_storeid = DB::table('stores')->where('store_status', 'ACTIVE')
						->leftjoin('approval_matrices', 'stores.id', '=', 'approval_matrices.store_list')
						->where('approval_matrices.status', 'ACTIVE')
						->where('approval_matrices.cms_users_id', CRUDBooster::myId())->first();

					// // --unhide this after covid-19-------------------	
					//get the id of all the approver
					$oics = DB::table('approval_matrices')
						->select('id', 'cms_users_id')
						->where('id_cms_privileges', '11')->get();
					// // ------------------------------------------------

					//---use this for covid-19-----
					// get the id of all the accounting checker
					// $acc_checker = DB::table('cms_users')
					// 	->select('id')
					// 	->where('id_cms_privileges', '14')->get();


					//----------------------------

					//create ids of array for sending notification
					$ids_to_send = array();

					// //--unhide this after covid-19-------------------
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
					// //----------------------------------------------------------



					//insert into transaction_logs
					$insert_in_logs = array();
					$insert_in_logs['reference_number'] = $data['referencenumberTF'];
					$insert_in_logs['invoice_date'] = $data['dateReceipt'];
					$insert_in_logs['created_by'] = $data['requested_by'];
					$insert_in_logs['created_date'] = $data['requested_at'];
					$insert_in_logs['edited_date'] = date('Y-m-d H:i:s');
					// //----use this for covid-19-------------------------------
					// $insert_in_logs['approved_date'] = date('Y-m-d H:i:s');
					// $insert_in_logs['approved_by'] = $data['requested_by'];
					// //--------------------------------------------------------
					$insert_in_logs['request_header_id'] = $data['request_header_id'];
					DB::table('request_transaction_logs')->insert($insert_in_logs);

					// //---unhide this after covid-19--------------
					foreach ($ids_to_send as $id_to_send) {

						$config['content'] = CRUDBooster::myName() . " has edited the receipt with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check the details before approve!";
						$config['to'] = CRUDBooster::adminPath('request_header_approval/approval/' . $data['request_header_id']);
						$config['id_cms_users'] = [$id_to_send];
						CRUDBooster::sendNotification($config);
					}
					//-----------------------------------------------

					// //---use this for covid-19----------------------
					// foreach ($acc_checker as $checker) {

					// 	$config['content'] = CRUDBooster::myName() . " has edited the receipt with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please get the receipt and check the details before approve!";
					// 	$config['to'] = CRUDBooster::adminPath('request_header_approval/approval/' . $data['request_header_id']);
					// 	$config['id_cms_users'] = [$checker->id];
					// 	CRUDBooster::sendNotification($config);
					// }
					// //---------------------------------------------

				} else {
					return $request;
					// $employee->image = '';
				}
			} else if ($image == null) {

				// //select storeid FROM stores where store_name 
				// $newstore_id = DB::table('stores')
				// 	->where('store_name', $new_store)
				// 	->where('store_status', 'ACTIVE')
				// 	->value('id');

				// //delete
				// // DB::table('request_lines')
				// // 	->where('request_header_id', $data['request_header_id'])
				// // 	->where('store_id', $data['storeTF']) //this is the previous store
				// // 	->delete();

				// //update request header

				$header_status = 'REQUESTED';

				// //check the invoice# if already exist store_id,invoice_date,total_value
				// $invoice = DB::table('request_header')
				// 	->where('deleted', '0')
				// 	->where('id', '!=', $data['request_header_id'])
				// 	->where('invoice_no', $data['invoice_number'])
				// 	->where('total_value', $computed_totalvalue)->first();
				// // dd($invoice->id);
				// if ($invoice->id != null || $invoice->id != 0) {
				// 	CRUDBooster::redirect(CRUDBooster::mainpath(), 'invoice# already exist!!', 'danger')->send();
				// }

				// $checks = DB::table('request_header')->where('invoice_no', $data['invoice_number'])
				// 	->where('id', '!=', $data['request_header_id'])
				// 	->where('date_receipt', $date_receipt)->get(['id']);

				// foreach ($checks as $check) {
				// 	// if ($check->id != null || $check->id != 0) {
				// 	// 	$check_if_exist = DB::table('request_lines')
				// 	// 		->where('request_header_id', $check->id)
				// 	// 		->where('category_id', '63')->first();

				// 	// 	if ($check_if_exist->item_description != null || !empty($check_if_exist->item_description)) {

				// 	// 		foreach($new_item_description as $new)
				// 	// 		{
				// 	// 			if ($check_if_exist->item_description == $new) {

				// 	// 				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Transportation fee already exist!!', 'danger')->send();
				// 	// 			}
				// 	// 		}

				// 	// 		foreach ($item_description as $item) {
				// 	// 			if ($check_if_exist->item_description == $item) {

				// 	// 				CRUDBooster::redirect(CRUDBooster::mainpath(), 'Transportation fee already exist!!', 'danger')->send();
				// 	// 			}
				// 	// 		}


				// 	// 	}
				// 	// }
				// 	if ($check->id != null || !empty($check->id)) {
				// 		CRUDBooster::redirect(CRUDBooster::mainpath(), 'Invoice# and Invoice date exist!!', 'danger')->send();
				// 	}
				// }

				// //---unhide this after covid-19--------------
				DB::table('request_header')
					->where('id', $data['request_header_id'])
					->update([

						'store_id' => $newstore_id,
						'date_receipt' => $date_receipt,
						// 'receipt_photo' => $receipt_photo,
						'status' => $header_status,
						'oic-status' => 'PENDING',
						'acctg-status' => null,
						'comment'	=> $data['comments'],
						'date_approved_oic' => null,
						'date_disapproved_oic' => null,
						'approved_by_oic' => '0',
						'disapproved_by_oic' => '0',
						'date_approved_acctg' => null,
						'date_disapproved_acctg' => null,
						'approved_by_acctg' => '0',
						'disapproved_by_acctg' => '0',
						'receipt_by' => '0',
						'receipt_at' => null,
						'version' => $data['requestversion'],
						'total_value' => $computed_totalvalue
					]);
				// //--------------------------------------------

				//----use this for covid-19---------------------
				// DB::table('request_header')
				// 	->where('id', $data['request_header_id'])
				// 	->update([

				// 		'store_id' => $newstore_id,
				// 		'date_receipt' => $date_receipt,
				// 		// 'receipt_photo' => $receipt_photo,
				// 		'status' => $header_status,
				// 		'oic-status' => 'APPROVED',
				// 		'acctg-status' => 'PENDING',

				// 		'date_approved_oic' => date('Y-m-d H:i:s'),
				// 		'date_disapproved_oic' => null,
				// 		'approved_by_oic' => CRUDBooster::myId(),
				// 		'disapproved_by_oic' => '0',
				// 		'date_approved_acctg' => null,
				// 		'date_disapproved_acctg' => null,
				// 		'approved_by_acctg' => '0',
				// 		'disapproved_by_acctg' => '0',
				// 		'receipt_by' => '0',
				// 		'receipt_at' => null,
				// 		'version' => $data['requestversion'],
				// 		'total_value' => $computed_totalvalue
				// 	]);
				//----------------------------------------------

				//update the old data
				for ($i = 0; $i < count($old_ids); $i++) {
					$category_id[$i] = DB::table('category')
						->where('category_status', 'ACTIVE')
						->where('category_description', $category_name[$i])->value('id');

					DB::table('request_lines')
						->where('id', $old_ids[$i])
						->update([
							'category_id' => $category_id[$i],
							'item_description' => $item_description[$i],
							'quantity'		   => $quantity[$i],
							'line_value'	   => $value[$i],
							'total_value'	   => $total_value[$i]
						]);
				}


				//insert the new data for request lines
				$insert_into_lines = array();
				for ($i = 0; $i < count($new_item_description); $i++) {
					//select categoryid FROM category
					$category_id[$i] = DB::table('category')
						->where('category_status', 'ACTIVE')
						->where('category_description', $new_category_name[$i])->value('id');
					$insert_into_lines[$i]['item_description'] = $new_item_description[$i];
					$insert_into_lines[$i]['quantity'] = $new_quantity[$i];
					$insert_into_lines[$i]['line_value'] = $new_value[$i];
					$insert_into_lines[$i]['total_value'] = $new_total_value[$i];
					$insert_into_lines[$i]['request_header_id'] =  $data['request_header_id'];
					$insert_into_lines[$i]['store_id'] = $newstore_id;
					$insert_into_lines[$i]['category_id'] = $category_id[$i];
					$insert_into_lines[$i]['created_at'] = $created_at;
				}
				DB::table('request_lines')->insert($insert_into_lines);

				//get the store of requestor
				$requestor_storeid = DB::table('stores')->where('store_status', 'ACTIVE')
					->leftjoin('approval_matrices', 'stores.id', '=', 'approval_matrices.store_list')
					->where('approval_matrices.status', 'ACTIVE')
					->where('approval_matrices.cms_users_id', CRUDBooster::myId())->first();

				// // --unhide this after covid-19-------------------	
				//get the id of all the approver
				$oics = DB::table('approval_matrices')
					->select('id', 'cms_users_id')
					->where('id_cms_privileges', '11')->get();
				// // ------------------------------------------------

				//---use this for covid-19-----
				// get the id of all the accounting checker
				// $acc_checker = DB::table('cms_users')
				// 	->select('id')
				// 	->where('id_cms_privileges', '14')->get();


				//----------------------------

				//create ids of array for sending notification
				$ids_to_send = array();

				// //--unhide this after covid-19-------------------
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
				// //----------------------------------------------------------

				//insert into transaction_logs
				$insert_in_logs = array();
				$insert_in_logs['reference_number'] = $data['referencenumberTF'];
				$insert_in_logs['invoice_date'] = $data['dateReceipt'];
				$insert_in_logs['created_by'] = $data['requested_by'];
				$insert_in_logs['created_date'] = $data['requested_at'];
				$insert_in_logs['edited_date'] = date('Y-m-d H:i:s');
				// //----use this for covid-19-------------------------------
				// $insert_in_logs['approved_date'] = date('Y-m-d H:i:s');
				// $insert_in_logs['approved_by'] = $data['requested_by'];
				// //--------------------------------------------------------
				$insert_in_logs['request_header_id'] = $data['request_header_id'];
				DB::table('request_transaction_logs')->insert($insert_in_logs);


				// // --unhide this after covid-19-------------------
				foreach ($ids_to_send as $id_to_send) {
					$config['content'] = CRUDBooster::myName() . " has edited the receipt with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check the details before approve!";
					$config['to'] = CRUDBooster::adminPath('request_header_approval/approval/' . $data['request_header_id']);
					$config['id_cms_users'] = [$id_to_send];
					CRUDBooster::sendNotification($config);
				}
				// //--------------------------------------------------

				//---use this for covid-19-------------
				// foreach ($acc_checker as $checker) {
				// 	$config['content'] = CRUDBooster::myName() . " has edited the receipt with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please get the receipt and check the details before approve!";
				// 	$config['to'] = CRUDBooster::adminPath('request_header_approval/approval/' . $data['request_header_id']);
				// 	$config['id_cms_users'] = [$checker->id];
				// 	CRUDBooster::sendNotification($config);
				// }
				//--------------------------------------
			}

			DB::commit();
		} catch (\Exception $e) {
			dd($e);
			DB::rollback();
		}


		// return redirect('admin/request_header_approval')->with('message', 'You have successfully edited the request!!');
		CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully edited the request!!', 'success')->send();
	}

	// public function receiptReceive($id)
	// {
	// 	//update header status // receipt with date

	// 	DB::table('request_header')->where('id', $id)
	// 	->update([
	// 		'status' => "RECEIPTED",
	// 		'acctg-status' => "RECEIVED",
	// 		'receipt_by' => CRUDBooster::myId(),
	// 		'receipt_at' => date('Y-m-d H:i:s')
	// 	]);
	// 	return redirect('admin/request_header_approval')->with('message', 'You have successfully received the request!!');
	// }

	public function Rejected(Request $request)
	{
		\Log::info(json_encode($request->line_id));
		$chk_id = $request->line_id;
		$val = $request->value;

		DB::table('request_lines')
			->where('id', $chk_id)
			->update([
				'error' => $val
			]);
		return "success!";
	}


	public function DeleteRow(Request $request)
	{

		$rowid = $request->row_id;

		// \Log::info(json_encode($request->line_id));
		DB::table('request_lines')
			->where('id', $rowid)
			->update([
				'is_row_deleted' => '1',
				'deleted_at' => date('Y-m-d H:i:s')
			]);
		return "success!";
	}

	public function Refresh($id)
	{
		// \Log::info(json_encode($request->line_id));


		DB::table('request_lines')
			->where('request_header_id', $id)
			->update([
				'error' => 0
			]);
		return "success!";
	}

	// public function Rejected($id)
	// {
	// 	// $chk_id = $request->chk_id;
	// 	// $val = $request->value;

	// 	DB::table('request_lines')
	// 				->where('id', $id)
	// 				->update([
	// 					'error' => $val
	// 				]);	
	// }

	public function approval(Request $request)
	{
		$data = $request->all();


		if ($data['submitB'] === 'approvedB') {
			if (CRUDBooster::myPrivilegeName() == 'OIC') {

				$id = DB::table('request_header')
					->select('id')
					->where('reference_number', $data['referencenumberTF'])
					->where('store_id', $data['storeTF'])
					->where('deleted', '0')
					->first();

				DB::table('request_header')
					->where('id', $id->id)
					->update([
						'date_approved_oic' => date('Y-m-d H:i:s'),
						'approved_by_oic' => CRUDBooster::myId(),
						'status' => "AUDITED",
						'oic-status' => "APPROVED",
						'acctg-status' => "PENDING"

					]);
				DB::table('request_lines')->where('request_header_id', $id->id)
					->update([
						'error' => 0
					]);



				$requestor =  $data['requested_by'];

				//insert into transaction_logs
				$insert_in_logs = array();
				$insert_in_logs['reference_number'] = $data['referencenumberTF'];
				$insert_in_logs['invoice_date'] = $data['date_receipt'];
				$insert_in_logs['created_by'] = $requestor;
				$insert_in_logs['created_date'] = $data['requested_at'];
				$insert_in_logs['approved_by'] = CRUDBooster::myId();
				$insert_in_logs['approved_date'] = date('Y-m-d H:i:s');
				$insert_in_logs['request_header_id'] = $data['headerID'];
				DB::table('request_transaction_logs')->insert($insert_in_logs);


				//----unhide this after covid-19------------
				// $receivers = DB::table('cms_users')
				// 	->where('id_cms_privileges', '13')->get();

				// $config['content'] = CRUDBooster::myName() . " has approved your request, please wait for accounting to check the details";
				// $config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
				// $config['id_cms_users'] = [$requestor];
				// CRUDBooster::sendNotification($config);


				// foreach ($receivers as $receiver) {
				// 	$config['content'] = CRUDBooster::myName() . " has approved the requested receipt with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . " Please check the details before received";
				// 	$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
				// 	$config['id_cms_users'] = [$receiver->id];
				// 	CRUDBooster::sendNotification($config);
				// }
				//-------------------------------------------

				//----use this for covid-19------------
				// get the id of all the approver
				$acc_checker = DB::table('cms_users')
					->select('id')
					->where('id_cms_privileges', '14')->get();
				
					foreach ($acc_checker as $checker) {

						$config['content'] = CRUDBooster::myName() . " has approved the requested receipt with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . " Please check the details before approved!";
						$config['to'] = CRUDBooster::adminPath('request_header_approval/approval/' . $data['headerID']);
						$config['id_cms_users'] = [$checker->id];
						CRUDBooster::sendNotification($config);
					}

				$config['content'] = CRUDBooster::myName() . " has approved your request, please wait for accounting to check the details";
				$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
				$config['id_cms_users'] = [$requestor];
				CRUDBooster::sendNotification($config);
				// //---------------------------------------------

				
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully approved a request!!', 'success')->send();
			} else if (CRUDBooster::myPrivilegeName() == 'Treasury') {

				if ($data['status'] === 'PROCESSED') {
					$id = DB::table('request_header')
						->select('id')
						->where('reference_number', $data['referencenumberTF'])
						->where('store_id', $data['storeTF'])
						->where('deleted', '0')
						->first();

					DB::table('request_header')
						->where('id', $id->id)
						->update([
							'date_approved_acctg' => date('Y-m-d H:i:s'),
							'approved_by_acctg' => CRUDBooster::myId(),
							'status' => "REIMBURSED",
							'acctg-status' => "REIMBURSED",

							'date_disapproved_oic' => null,
							'disapproved_by_oic' => 0,
							'date_disapproved_acctg' => null,
							'disapproved_by_acctg' => 0,
						]);

					DB::table('request_lines')->where('request_header_id', $id->id)
						->update([
							'error' => 0
						]);


					$requestor =  $data['requested_by'];

					//insert into transaction_logs
					$insert_in_logs = array();
					$insert_in_logs['reference_number'] = $data['referencenumberTF'];
					$insert_in_logs['invoice_date'] = $data['date_receipt'];
					$insert_in_logs['created_by'] = $requestor;
					$insert_in_logs['created_date'] = $data['requested_at'];
					$insert_in_logs['reimbursed_by'] = CRUDBooster::myId();
					$insert_in_logs['reimbursed_date'] = date('Y-m-d H:i:s');
					$insert_in_logs['request_header_id'] = $data['headerID'];
					DB::table('request_transaction_logs')->insert($insert_in_logs);

					// $oic = DB::table('cms_users')
					// ->select('id')
					// ->where('id', $data['oic_approved'])->first();

					// $receiver = DB::table('cms_users')
					// ->select('id')
					// ->where('id', $data['receiver_received'])->first();

					// $checker = DB::table('cms_users')
					// ->select('id')
					// ->where('id', $data['checker_processed'])->first();


					$config['content'] = CRUDBooster::myName() . " has reimbursed your request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
					$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
					$config['id_cms_users'] = [$requestor];
					CRUDBooster::sendNotification($config);

					// $config['content'] = CRUDBooster::myName() . " has reimbursed the request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
					// $config['to'] = CRUDBooster::adminPath('request_header/');
					// $config['id_cms_users'] = [$oic->id];
					// CRUDBooster::sendNotification($config);

					// $config['content'] = CRUDBooster::myName() . " has reimbursed the request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
					// $config['to'] = CRUDBooster::adminPath('request_header/');
					// $config['id_cms_users'] = [$receiver->id];
					// CRUDBooster::sendNotification($config);

					// $config['content'] = CRUDBooster::myName() . " has reimbursed the request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
					// $config['to'] = CRUDBooster::adminPath('request_header/');
					// $config['id_cms_users'] = [$checker->id];
					// CRUDBooster::sendNotification($config);

					// return redirect('admin/request_header_approval')->with('message', 'You have successfully reimbursed a request!!');

					CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully reimbursed a request!!', 'success')->send();
				}
			} else if (CRUDBooster::isSuperadmin() || CRUDBooster::myPrivilegeName() == 'Admin') {
				if ($data['status'] === 'REQUESTED' || $data['status'] === 'DISAPPROVED') {
					$id = DB::table('request_header')
						->select('id')
						->where('reference_number', $data['referencenumberTF'])
						->where('store_id', $data['storeTF'])
						->where('deleted', '0')
						->first();

                    // //---unhide this after covid-19--------
					DB::table('request_header')
						->where('id', $id->id)
						->update([
							'date_approved_oic' => date('Y-m-d H:i:s'),
							'approved_by_oic' => CRUDBooster::myId(),
							'status' => "AUDITED",
							'oic-status' => "APPROVED",
							'acctg-status' => "PENDING"
						]);
					// //---------------------------------------

    
                // //---use this for covid-19-------------

					// 	DB::table('request_header')
					// ->where('id', $id->id)
					// ->update([
					// 	'processed_at' => date('Y-m-d H:i:s'),
					// 	'processed_by' => CRUDBooster::myId(),
					// 	'receipt_at' => date('Y-m-d H:i:s'),
					// 	'receipt_by' => CRUDBooster::myId(),
					// 	'status' => "PROCESSED",
					// 	'acctg-status' => "PROCESSED"
					// ]);
				// //------------------------------------
        
					DB::table('request_lines')->where('request_header_id', $id->id)
						->update([
							'error' => 0
						]);

					$requestor =  $data['requested_by'];
					
					//----added by cris 20200806-------------------------
    					//insert into transaction_logs
    					$insert_in_logs = array();
    					$insert_in_logs['reference_number'] = $data['referencenumberTF'];
    					$insert_in_logs['invoice_date'] = $data['date_receipt'];
    					$insert_in_logs['created_by'] = $requestor;
    					$insert_in_logs['created_date'] = $data['requested_at'];
						
						//---edited by cris 20200824---------------------
    					$insert_in_logs['approved_date'] = date('Y-m-d H:i:s');
						$insert_in_logs['approved_by'] = CRUDBooster::myId();
						//-----------------------------------------------
    					
    					$insert_in_logs['processed_by'] = CRUDBooster::myId();
    					$insert_in_logs['processed_date'] = date('Y-m-d H:i:s');
    					$insert_in_logs['request_header_id'] = $data['headerID'];
    					DB::table('request_transaction_logs')->insert($insert_in_logs);
    				//----------------------------------------------------------

                    // //---unhide this after covid-19,---------------------
    				// 	$acc = DB::table('cms_users')
    				// 		->select('id')
    				// 		->where('id_cms_privileges', '12')->first();
    
    				// 	$config['content'] = CRUDBooster::myName() . " has approved your request, please wait for accounting to check the details";
    				// 	$config['to'] = CRUDBooster::adminPath('request_header_approval/');
    				// 	$config['id_cms_users'] = [$requestor];
    				// 	CRUDBooster::sendNotification($config);
    
    				// 	$config['content'] = CRUDBooster::myName() . " has approved the requested receipt with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
    				// 	$config['to'] = CRUDBooster::adminPath('request_header_approval/');
    				// 	$config['id_cms_users'] = [$acc->id];
    				// 	CRUDBooster::sendNotification($config);
					// //-------------------------------------------------------
					
					// //---use this for covid-19-----------------------------------
					$treasurys = DB::table('cms_users')
					->where('id_cms_privileges', '15')->get();

					$config['content'] = CRUDBooster::myName() . " has processed this reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please wait for Treasury to reimbursed this receipt";
					$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
					$config['id_cms_users'] = [$requestor];
					CRUDBooster::sendNotification($config);

					foreach ($treasurys as $treasury) {
						$config['content'] = CRUDBooster::myName() . " has processed this reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check before reimbursed this receipt";
						$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
						$config['id_cms_users'] = [$treasury->id];
						CRUDBooster::sendNotification($config);
					}
					// //-------------------------------------------------------------

					// return redirect('admin/request_header_approval')->with('message', 'You have successfully approved a request!!');
					CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully approved a request!!', 'success')->send();
				} 
				// //----unhide this after covid-19---------------------------------------------
				// else if ($data['status'] === 'AUDITED' || $data['status'] === 'RECEIPTED') {
				// 	if ($data['status'] === 'AUDITED') {
				// 		// echo "<script>alert('Please click receipt before reimbursed!');</script>";
				// 		DB::table('request_lines')->where('request_header_id', $id->id)
				// 			->update([
				// 				'error' => 0
				// 			]);
				// 		return redirect('admin/request_header_approval/detail/' . $data['request_header_id'])->with('message', 'Please click receipt before reimbursed!!');
				// 		// CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully approved a request!!', 'success')->send();
				// 	} else if ($data['status'] === 'RECEIPTED') {
				// 		$id = DB::table('request_header')
				// 			->select('id')
				// 			->where('reference_number', $data['referencenumberTF'])
				// 			->where('store_id', $data['storeTF'])
				// 			->where('deleted', '0')
				// 			->first();

				// 		DB::table('request_header')
				// 			->where('id', $id->id)
				// 			->update([
				// 				'date_approved_acctg' => date('Y-m-d H:i:s'),
				// 				'approved_by_acctg' => CRUDBooster::myId(),
				// 				'status' => "REIMBURSED",
				// 				'acctg-status' => "REIMBURSED",

				// 				'date_disapproved_oic' => null,
				// 				'disapproved_by_oic' => 0,
				// 				'date_disapproved_acctg' => null,
				// 				'disapproved_by_acctg' => 0,
				// 			]);

				// 		DB::table('request_lines')->where('request_header_id', $id->id)
				// 			->update([
				// 				'error' => 0
				// 			]);


				// 		$requestor =  $data['requested_by'];
						
						
    					
    					
                        
				// 		$acc = DB::table('cms_users')
				// 			->select('id')
				// 			->where('id_cms_privileges', '12')->first();

				// 		$config['content'] = CRUDBooster::myName() . " has reimbursed your request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
				// 		$config['to'] = CRUDBooster::adminPath('request_header/');
				// 		$config['id_cms_users'] = [$requestor];
				// 		CRUDBooster::sendNotification($config);
					
						


				// 		// return redirect('admin/request_header_approval')->with('message', 'You have successfully reimbursed a request!!');
				// 		CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully reimbursed a request!!', 'success')->send();
				// 	}
				// }
				// //----------------------------------------------------------------------------------------
				
				// //---use this for covid-19---------------------------------------------------------
				else if ($data['status'] === 'PROCESSED') {
						$id = DB::table('request_header')
							->select('id')
							->where('reference_number', $data['referencenumberTF'])
							->where('store_id', $data['storeTF'])
							->where('deleted', '0')
							->first();

						DB::table('request_header')
							->where('id', $id->id)
							->update([
								'date_approved_acctg' => date('Y-m-d H:i:s'),
								'approved_by_acctg' => CRUDBooster::myId(),
								'status' => "REIMBURSED",
								'acctg-status' => "REIMBURSED",

								'date_disapproved_oic' => null,
								'disapproved_by_oic' => 0,
								'date_disapproved_acctg' => null,
								'disapproved_by_acctg' => 0,
							]);

						DB::table('request_lines')->where('request_header_id', $id->id)
							->update([
								'error' => 0
							]);


							$requestor =  $data['requested_by'];

							//insert into transaction_logs
							$insert_in_logs = array();
							$insert_in_logs['reference_number'] = $data['referencenumberTF'];
							$insert_in_logs['invoice_date'] = $data['date_receipt'];
							$insert_in_logs['created_by'] = $requestor;
							$insert_in_logs['created_date'] = $data['requested_at'];
							$insert_in_logs['reimbursed_by'] = CRUDBooster::myId();
							$insert_in_logs['reimbursed_date'] = date('Y-m-d H:i:s');
							$insert_in_logs['request_header_id'] = $data['headerID'];
							DB::table('request_transaction_logs')->insert($insert_in_logs);
			
							$config['content'] = CRUDBooster::myName() . " has reimbursed your request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
							$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
							$config['id_cms_users'] = [$requestor];
							CRUDBooster::sendNotification($config);
		
							CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully reimbursed a request!!', 'success')->send();
					
				}
				//-------------------------------------------------------------------------------------------
				
			}
		} else if ($data['submitB'] === 'disapprovedB') {

			if (CRUDBooster::myPrivilegeName() == 'OIC') {


				$id = DB::table('request_header')
					->select('id')
					->where('reference_number', $data['referencenumberTF'])
					->where('store_id', $data['storeTF'])
					->where('deleted', '0')
					->first();

				DB::table('request_header')
					->where('id', $id->id)
					->update([
						'date_disapproved_oic' => date('Y-m-d H:i:s'),
						'disapproved_by_oic' => CRUDBooster::myId(),
						'status' => "DISAPPROVED",
						'oic-status' => 'REJECTED',
						'comment' => $data['comments'],

						'date_approved_oic' => null,
						'approved_by_oic' => 0,
						'date_approved_acctg' => null,
						'approved_by_acctg' => 0,
						'date_disapproved_acctg' => null,
						'disapproved_by_acctg' => 0,
						'receipt_at' => null,
						'receipt_by' => 0
					]);

				$requestor =  $data['requested_by'];
				date('Y-m-d H:i:s');

				//insert into transaction_logs
				$insert_in_logs = array();
				$insert_in_logs['reference_number'] = $data['referencenumberTF'];
				$insert_in_logs['invoice_date'] = $data['date_receipt'];
				$insert_in_logs['created_by'] = $data['requested_by'];
				$insert_in_logs['created_date'] = $data['requested_at'];
				$insert_in_logs['rejected_by'] = CRUDBooster::myId();
				$insert_in_logs['rejected_date'] = date('Y-m-d H:i:s');
				$insert_in_logs['request_header_id'] = $data['headerID'];
				DB::table('request_transaction_logs')->insert($insert_in_logs);


				// $acc = DB::table('cms_users')
				// 			->select('id')
				// 			->where('id_cms_privileges', '12')->first();

				$config['content'] = CRUDBooster::myName() . " has disapproved your request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check the details before request";
				$config['to'] = CRUDBooster::adminPath('request_header_approval/edit/' . $data['headerID']);
				$config['id_cms_users'] = [$requestor];
				CRUDBooster::sendNotification($config);

				// $config['content'] = CRUDBooster::myName(). " has approved the requested receipt with reference number ".$data['referencenumberTF']." at ".date('Y-m-d H:i:s')."";
				// $config['to'] = CRUDBooster::adminPath('request_header/');
				// $config['id_cms_users'] = [$acc->id];
				// CRUDBooster::sendNotification($config);


				// return redirect('admin/request_header_approval')->with('message', 'You have successfully disapproved a request!!');
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully disapproved a request!!', 'success')->send();
			} else if (in_array(CRUDBooster::myPrivilegeName(), ["AP Receiver", "AP Checker", "Treasury"])) {
				$id = DB::table('request_header')
					->select('id')
					->where('reference_number', $data['referencenumberTF'])
					->where('store_id', $data['storeTF'])
					->where('deleted', '0')
					->first();

				DB::table('request_header')
					->where('id', $id->id)
					->update([
						'date_disapproved_acctg' => date('Y-m-d H:i:s'),
						'disapproved_by_acctg' => CRUDBooster::myId(),
						'status' => "DISAPPROVED",
						'oic-status' => null,
						'acctg-status' => "REJECTED",
						'comment' => $data['comments'],

						'date_approved_oic' => null,
						'approved_by_oic' => 0,
						'date_approved_acctg' => null,
						'approved_by_acctg' => 0,
						'receipt_at' => null,
						'receipt_by' => 0
					]);

				$requestor =  $data['requested_by'];

				// dd($data['requested_at']);

				//insert into transaction_logs
				$insert_in_logs = array();
				$insert_in_logs['reference_number'] = $data['referencenumberTF'];
				$insert_in_logs['invoice_date'] = $data['date_receipt'];
				$insert_in_logs['created_by'] = $requestor;
				$insert_in_logs['created_date'] = $data['requested_at'];
				$insert_in_logs['rejected_by'] = CRUDBooster::myId();
				$insert_in_logs['rejected_date'] = date('Y-m-d H:i:s');
				$insert_in_logs['request_header_id'] = $data['headerID'];
				DB::table('request_transaction_logs')->insert($insert_in_logs);
				
                
				$oic = DB::table('cms_users')
					->select('id')
					->where('id', $data['oic_approved'])->first();
				// //---unhide this after covid-19-----
				// $receiver = DB::table('cms_users')
				// 	->select('id')
				// 	->where('id', $data['receiver_received'])->first();
				// //--------------------------------------

				$checker = DB::table('cms_users')
					->select('id')
					->where('id', $data['checker_processed'])->first();

				//store them into array
				$ids = array();
				
				array_push($ids, $oic->id);
				// //---unhide this after covid-19-----
				// array_push($ids, $receiver->id);
				// //--------------------------------------
				array_push($ids, $checker->id);
				$approval_string = implode(",", $ids);
				array_map('intval', explode(",", $approval_string));



				$config['content'] = CRUDBooster::myName() . " has disapproved your request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check the details before request";
				$config['to'] = CRUDBooster::adminPath('request_header_approval/edit/' . $data['headerID']);
				$config['id_cms_users'] = [$requestor];
				CRUDBooster::sendNotification($config);


				foreach ($ids as $id) {
					$config['content'] = CRUDBooster::myName() . " has disapproved this request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
					// $config['to'] = CRUDBooster::adminPath('request-details/'.$data['request_header_id']);//request_header_id
					$config['to'] = CRUDBooster::adminPath('receipt-details/' . $data['headerID']); //request_header_id	
					$config['id_cms_users'] = [$id];
					CRUDBooster::sendNotification($config);
				}


				// return redirect('admin/request_header_approval')->with('message', 'You have successfully disapproved a request!!');
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully disapproved a request!!', 'success')->send();
			} else if (CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::isSuperadmin()) {
				if ($data['status'] === 'REQUESTED' || $data['status'] === 'DISAPPROVED') {
					$id = DB::table('request_header')
						->select('id')
						->where('reference_number', $data['referencenumberTF'])
						->where('store_id', $data['storeTF'])
						->where('deleted', '0')
						->first();

					DB::table('request_header')
						->where('id', $id->id)
						->update([
						    // //----unhide this after covid-19------
							'date_disapproved_oic' => date('Y-m-d H:i:s'),
							'disapproved_by_oic' => CRUDBooster::myId(),
							// //-------------------------------------
							
							// //---use this for covid-19--------------------
							// 'date_disapproved_acctg' => date('Y-m-d H:i:s'),
							// 'disapproved_by_acctg' => CRUDBooster::myId(),
							// //---------------------------------------------
							
							'status' => "DISAPPROVED",
							'oic-status' => null,
							'acctg-status' => "REJECTED",
							'comment' => $data['comments'],

							'date_approved_oic' => null,
							'approved_by_oic' => 0,
							'date_approved_acctg' => null,
							'approved_by_acctg' => 0,
							// //----unhide this after covid-19------
							'date_disapproved_acctg' => null,
							'disapproved_by_acctg' => 0,
							// //-------------------------------------
							'receipt_at' => null,
							'receipt_by' => 0
						]);

					$requestor =  $data['requested_by'];
					
					//---added by cris 20200806----------------------
					//insert into transaction_logs
					$insert_in_logs = array();
					$insert_in_logs['reference_number'] = $data['referencenumberTF'];
					$insert_in_logs['invoice_date'] = $data['date_receipt'];
					$insert_in_logs['created_by'] = $requestor;
					$insert_in_logs['created_date'] = $data['requested_at'];
					$insert_in_logs['rejected_by'] = CRUDBooster::myId();
					$insert_in_logs['rejected_date'] = date('Y-m-d H:i:s');
					$insert_in_logs['request_header_id'] = $data['headerID'];
					DB::table('request_transaction_logs')->insert($insert_in_logs);
					//-------------------------------------------------------

                    // //----unhide this after covid-19------
					$oic = DB::table('cms_users')
						->select('id')
						->where('id', $data['oic_approved'])->first();
					// //---------------------------------------

					$config['content'] = CRUDBooster::myName() . " has disapproved your request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check the details before request";
					$config['to'] = CRUDBooster::adminPath('request_header_approval/');
					$config['id_cms_users'] = [$requestor];
					CRUDBooster::sendNotification($config);
					
                    // //----unhide this after covid-19------
					$config['content'] = CRUDBooster::myName() . " has disapproved this request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
					// $config['to'] = CRUDBooster::adminPath('request-details/'.$data['request_header_id']);//request_header_id
					$config['to'] = CRUDBooster::adminPath('receipt-details/' . $data['request_header_id']); //request_header_id
					$config['id_cms_users'] = [$oic->id];
					CRUDBooster::sendNotification($config);
					// //---------------------------------------

					// $config['content'] = CRUDBooster::myName(). " has approved the requested receipt with reference number ".$data['referencenumberTF']." at ".date('Y-m-d H:i:s')."";
					// $config['to'] = CRUDBooster::adminPath('request_header/');
					// $config['id_cms_users'] = [$acc->id];
					// CRUDBooster::sendNotification($config);

					// return redirect('admin/request_header_approval')->with('message', 'You have successfully disapproved a request!!');
					CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully disapproved a request!!', 'success')->send();
				} 
                // //--unhide this after covid-19------------------------------------------------
				// else if ($data['status'] === 'AUDITED' || $data['status'] === 'RECEIPTED') {
				// 	$id = DB::table('request_header')
				// 		->select('id')
				// 		->where('reference_number', $data['referencenumberTF'])
				// 		->where('store_id', $data['storeTF'])
				// 		->where('deleted', '0')
				// 		->first();

				// 	DB::table('request_header')
				// 		->where('id', $id->id)
				// 		->update([
				// 			'date_disapproved_acctg' => date('Y-m-d H:i:s'),
				// 			'disapproved_by_acctg' => CRUDBooster::myId(),
				// 			'status' => "DISAPPROVED",

				// 			'date_approved_oic' => null,
				// 			'approved_by_oic' => 0,
				// 			'date_approved_acctg' => null,
				// 			'approved_by_acctg' => 0,
				// 			'receipt_at' => null,
				// 			'receipt_by' => 0
				// 		]);

				// 	$requestor =  $data['requested_by'];

				// 	// $acc = DB::table('cms_users')
				// 	// 			->select('id')
				// 	// 			->where('id_cms_privileges', '12')->first();

				// 	$config['content'] = CRUDBooster::myName() . " has disapproved your request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check the details before request";
				// 	$config['to'] = CRUDBooster::adminPath('request_header_approval/');
				// 	$config['id_cms_users'] = [$requestor];
				// 	CRUDBooster::sendNotification($config);

				// 	// return redirect('admin/request_header_approval')->with('message', 'You have successfully disapproved a request!!');
				// 	CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully disapproved a request!!', 'success')->send();
				// }
				// //-----------------------------------------------------------------------------------------
				
				// //----use this for covid-19------------------------------------------------
				else if ($data['status'] === 'PROCESSED' || $data['status'] === 'AUDITED') {
					$id = DB::table('request_header')
						->select('id')
						->where('reference_number', $data['referencenumberTF'])
						->where('store_id', $data['storeTF'])
						->where('deleted', '0')
						->first();

					DB::table('request_header')
						->where('id', $id->id)
						->update([
							'date_disapproved_acctg' => date('Y-m-d H:i:s'),
							'disapproved_by_acctg' => CRUDBooster::myId(),
							'status' => "DISAPPROVED",
							'oic-status' => null,
							'acctg-status' => "REJECTED",
							'comment' => $data['comments'],

							'date_approved_oic' => null,
							'approved_by_oic' => 0,
							'date_approved_acctg' => null,
							'approved_by_acctg' => 0,
							'receipt_at' => null,
							'receipt_by' => 0
						]);

					$requestor =  $data['requested_by'];

					//insert into transaction_logs
					$insert_in_logs = array();
					$insert_in_logs['reference_number'] = $data['referencenumberTF'];
					$insert_in_logs['invoice_date'] = $data['date_receipt'];
					$insert_in_logs['created_by'] = $requestor;
					$insert_in_logs['created_date'] = $data['requested_at'];
					$insert_in_logs['rejected_by'] = CRUDBooster::myId();
					$insert_in_logs['rejected_date'] = date('Y-m-d H:i:s');
					$insert_in_logs['request_header_id'] = $data['headerID'];
					DB::table('request_transaction_logs')->insert($insert_in_logs);

					$oic = DB::table('cms_users')
					->select('id')
					->where('id', $data['oic_approved'])->first();

					$checker = DB::table('cms_users')
						->select('id')
						->where('id', $data['checker_processed'])->first();

					//store them into array
					$ids = array();
					array_push($ids, $oic->id);
					array_push($ids, $checker->id);
					$approval_string = implode(",", $ids);
					array_map('intval', explode(",", $approval_string));

					$config['content'] = CRUDBooster::myName() . " has disapproved your request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check the details before request";
					$config['to'] = CRUDBooster::adminPath('request_header_approval/edit/' . $data['headerID']);
					$config['id_cms_users'] = [$requestor];
					CRUDBooster::sendNotification($config);

					foreach ($ids as $id) {
						$config['content'] = CRUDBooster::myName() . " has disapproved this request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
						// $config['to'] = CRUDBooster::adminPath('request-details/'.$data['request_header_id']);//request_header_id
						$config['to'] = CRUDBooster::adminPath('receipt-details/' . $data['headerID']); //request_header_id	
						$config['id_cms_users'] = [$id];
						CRUDBooster::sendNotification($config);
					}

					// return redirect('admin/request_header_approval')->with('message', 'You have successfully disapproved a request!!');
					CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully disapproved a request!!', 'success')->send();
				}
				//-----------------------------------------------------------------------------------
				
			}
		} else if ($data['submitB'] === 'receiptB') { // AP Receiver

			// if ($data['status'] == 'RECEIPTED') {
			// 	// echo "<script>alert('Please click approve button to reimbursed this receipt!');</script>";
			// 	return redirect('admin/request_header_approval/detail/' . $data['request_header_id'])->with('message', 'Please click approve button to reimbursed this receipt!!');
			// } else 
			if ($data['status'] == 'AUDITED') {

				$id = DB::table('request_header')
					->select('id')
					->where('reference_number', $data['referencenumberTF'])
					->where('store_id', $data['storeTF'])
					->where('deleted', '0')
					->first();

				DB::table('request_header')
					->where('id', $id->id)
					->update([
						'receipt_at' => date('Y-m-d H:i:s'),
						'receipt_by' => CRUDBooster::myId(),
						'status' => "RECEIPTED",
						'acctg-status' => "RECEIVED"
					]);


				$requestor =  $data['requested_by'];

				//insert into transaction_logs
				$insert_in_logs = array();
				$insert_in_logs['reference_number'] = $data['referencenumberTF'];
				$insert_in_logs['invoice_date'] = $data['date_receipt'];
				$insert_in_logs['created_by'] = $requestor;
				$insert_in_logs['created_date'] = $data['requested_at'];
				$insert_in_logs['received_by'] = CRUDBooster::myId();
				$insert_in_logs['received_date'] = date('Y-m-d H:i:s');
				$insert_in_logs['request_header_id'] = $data['headerID'];
				DB::table('request_transaction_logs')->insert($insert_in_logs);

				// $oic = DB::table('cms_users')
				// 	->select('id')
				// 	->where('id', $data['oic_approved'])->first();

				$checkers = DB::table('cms_users')
					->where('id_cms_privileges', '14')->get();

				$config['content'] = CRUDBooster::myName() . " has received this reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please wait for Checker to check this receipt";
				$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
				$config['id_cms_users'] = [$requestor];
				CRUDBooster::sendNotification($config);

				foreach ($checkers as $checker) {

					$config['content'] = CRUDBooster::myName() . " has received this reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check the details!";
					$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
					$config['id_cms_users'] = [$checker->id];
					CRUDBooster::sendNotification($config);
				}

				// $config['content'] = CRUDBooster::myName() . " has received this request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
				// // $config['to'] = CRUDBooster::adminPath('request-details/'.$data['request_header_id']);//request_header_id
				// $config['to'] = CRUDBooster::adminPath('approval/'. $data['request_header_id']); //request_header_id
				// $config['id_cms_users'] = [$oic];
				// CRUDBooster::sendNotification($config);

				// $config['content'] = CRUDBooster::myName(). " has approved the requested receipt with reference number ".$data['referencenumberTF']." at ".date('Y-m-d H:i:s')."";
				// $config['to'] = CRUDBooster::adminPath('request_header/');
				// $config['id_cms_users'] = [$acc->id];
				// CRUDBooster::sendNotification($config);
				// return redirect('admin/request_header_approval')->with('message', 'You have successfully received this request!!');
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully received this request!!', 'success')->send();
			}
		} else if ($data['submitB'] === 'processB') // AP Checker
		{
		    // //----unhide this after covid-19----------------------------
// 			if ($data['status'] == 'RECEIPTED') {

// 				$id = DB::table('request_header')
// 					->select('id')
// 					->where('reference_number', $data['referencenumberTF'])
// 					->where('store_id', $data['storeTF'])
// 					->where('deleted', '0')
// 					->first();

// 				DB::table('request_header')
// 					->where('id', $id->id)
// 					->update([
// 						'processed_at' => date('Y-m-d H:i:s'),
// 						'processed_by' => CRUDBooster::myId(),
// 						'status' => "PROCESSED",
// 						'acctg-status' => "PROCESSED"
// 					]);


// 				$requestor =  $data['requested_by'];

// 				//insert into transaction_logs
// 				$insert_in_logs = array();
// 				$insert_in_logs['reference_number'] = $data['referencenumberTF'];
// 				$insert_in_logs['invoice_date'] = $data['date_receipt'];
// 				$insert_in_logs['created_by'] = $requestor;
// 				$insert_in_logs['created_date'] = $data['requested_at'];
// 				$insert_in_logs['processed_by'] = CRUDBooster::myId();
// 				$insert_in_logs['processed_date'] = date('Y-m-d H:i:s');
// 				$insert_in_logs['request_header_id'] = $data['headerID'];
// 				DB::table('request_transaction_logs')->insert($insert_in_logs);

// 				$treasurys = DB::table('cms_users')
// 					->where('id_cms_privileges', '15')->get();

// 				$oic = DB::table('cms_users')
// 					->select('id')
// 					->where('id', $data['oic_approved'])->first();

// 				$receiver = DB::table('cms_users')
// 					->select('id')
// 					->where('id', $data['receiver_received'])->first();

// 				$config['content'] = CRUDBooster::myName() . " has processed this reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please wait for Treasury to reimbursed this receipt";
// 				$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
// 				$config['id_cms_users'] = [$requestor];
// 				CRUDBooster::sendNotification($config);

// 				// $config['content'] = CRUDBooster::myName() . " has processed this request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
// 				// // $config['to'] = CRUDBooster::adminPath('request-details/'.$data['request_header_id']);//request_header_id
// 				// $config['to'] = CRUDBooster::adminPath('approval/'. $data['request_header_id']); //'receipt-details/' . $data['request_header_id']
// 				// $config['id_cms_users'] = [$oic->id];
// 				// CRUDBooster::sendNotification($config);

// 				// $config['content'] = CRUDBooster::myName() . " has processed this request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
// 				// // $config['to'] = CRUDBooster::adminPath('request-details/'.$data['request_header_id']);//request_header_id
// 				// $config['to'] = CRUDBooster::adminPath('approval/'. $data['request_header_id']); //request_header_id
// 				// $config['id_cms_users'] = [$receiver->id];
// 				// CRUDBooster::sendNotification($config);

// 				foreach ($treasurys as $treasury) {
// 					$config['content'] = CRUDBooster::myName() . " has processed this reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check before reimbursed this receipt";
// 					$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
// 					$config['id_cms_users'] = [$treasury->id];
// 					CRUDBooster::sendNotification($config);
// 				}

// 				// $config['content'] = CRUDBooster::myName(). " has approved the requested receipt with reference number ".$data['referencenumberTF']." at ".date('Y-m-d H:i:s')."";
// 				// $config['to'] = CRUDBooster::adminPath('request_header/');
// 				// $config['id_cms_users'] = [$acc->id];
// 				// CRUDBooster::sendNotification($config);
// 				// return redirect('admin/request_header_approval')->with('message', 'You have successfully processed this request!!');
// 				CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully processed this request!!', 'success')->send();
// 			}
			// //----------------------------------------------------------------
			
			// //--use this for covid-19-----------------------------------------
			if ($data['status'] == 'AUDITED') {

				$id = DB::table('request_header')
					->select('id')
					->where('reference_number', $data['referencenumberTF'])
					->where('store_id', $data['storeTF'])
					->where('deleted', '0')
					->first();

				DB::table('request_header')
					->where('id', $id->id)
					->update([
						'processed_at' => date('Y-m-d H:i:s'),
						'processed_by' => CRUDBooster::myId(),
						'receipt_at' => date('Y-m-d H:i:s'),
						'receipt_by' => CRUDBooster::myId(),
						'status' => "PROCESSED",
						'acctg-status' => "PROCESSED"
					]);


				$requestor =  $data['requested_by'];

				//insert into transaction_logs
				$insert_in_logs = array();
				$insert_in_logs['reference_number'] = $data['referencenumberTF'];
				$insert_in_logs['invoice_date'] = $data['date_receipt'];
				$insert_in_logs['created_by'] = $requestor;
				$insert_in_logs['created_date'] = $data['requested_at'];
				// //----use this for covid-19-------------------------------
				$insert_in_logs['received_date'] = date('Y-m-d H:i:s');
				$insert_in_logs['received_by'] = CRUDBooster::myId();
				// //--------------------------------------------------------
				$insert_in_logs['processed_by'] = CRUDBooster::myId();
				$insert_in_logs['processed_date'] = date('Y-m-d H:i:s');
				$insert_in_logs['request_header_id'] = $data['headerID'];
				DB::table('request_transaction_logs')->insert($insert_in_logs);

				$treasurys = DB::table('cms_users')
					->where('id_cms_privileges', '15')->get();

				$oic = DB::table('cms_users')
					->select('id')
					->where('id', $data['oic_approved'])->first();

				$receiver = DB::table('cms_users')
					->select('id')
					->where('id', $data['receiver_received'])->first();

				$config['content'] = CRUDBooster::myName() . " has processed this reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please wait for Treasury to reimbursed this receipt";
				$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
				$config['id_cms_users'] = [$requestor];
				CRUDBooster::sendNotification($config);

				// $config['content'] = CRUDBooster::myName() . " has processed this request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
				// // $config['to'] = CRUDBooster::adminPath('request-details/'.$data['request_header_id']);//request_header_id
				// $config['to'] = CRUDBooster::adminPath('approval/'. $data['request_header_id']); //'receipt-details/' . $data['request_header_id']
				// $config['id_cms_users'] = [$oic->id];
				// CRUDBooster::sendNotification($config);

				// $config['content'] = CRUDBooster::myName() . " has processed this request with reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . "";
				// // $config['to'] = CRUDBooster::adminPath('request-details/'.$data['request_header_id']);//request_header_id
				// $config['to'] = CRUDBooster::adminPath('approval/'. $data['request_header_id']); //request_header_id
				// $config['id_cms_users'] = [$receiver->id];
				// CRUDBooster::sendNotification($config);

				foreach ($treasurys as $treasury) {
					$config['content'] = CRUDBooster::myName() . " has processed this reference number " . $data['referencenumberTF'] . " at " . date('Y-m-d H:i:s') . ", please check before reimbursed this receipt";
					$config['to'] = CRUDBooster::adminPath('request_header_approval/detail/' . $data['headerID']);
					$config['id_cms_users'] = [$treasury->id];
					CRUDBooster::sendNotification($config);
				}

				// $config['content'] = CRUDBooster::myName(). " has approved the requested receipt with reference number ".$data['referencenumberTF']." at ".date('Y-m-d H:i:s')."";
				// $config['to'] = CRUDBooster::adminPath('request_header/');
				// $config['id_cms_users'] = [$acc->id];
				// CRUDBooster::sendNotification($config);
				// return redirect('admin/request_header_approval')->with('message', 'You have successfully processed this request!!');
				CRUDBooster::redirect(CRUDBooster::mainpath(), 'You have successfully processed this request!!', 'success')->send();
			}
			//---------------------------------------------------------------------------------------
		}
	}

	public function ExportApproval()
	{

		$filename = 'Pending Request - ' . date("d M Y - h.i.sa");
		$sheetname = 'Pending Request' . date("d-M-Y");

		Excel::create($filename, function ($excel) {
			$excel->sheet('pending-request', function ($sheet) {
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
					$store = DB::table('cms_users')->where('id', CRUDBooster::myId())->first();
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
						->where('request_header.requested_by', CRUDBooster::myId())
						->where('stores.store_status', 'ACTIVE')
						->where('request_header.deleted', '0')
						->where('request_header.status', 'REQUESTED')
						->orWhere('request_header.status', 'DISAPPROVED')
						->get();
				} else if (CRUDBooster::myPrivilegeName() == 'OIC') {

					// $oic_storeid = DB::table('cms_users')->where('id', CRUDBooster::myId())->get();
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
						->where('request_header.status', 'REQUESTED')
						->get();
				} else if (CRUDBooster::myPrivilegeName() == 'AP Receiver') {

					// $oic_storeid = DB::table('cms_users')->where('id', CRUDBooster::myId())->get();
					// // dd($oic_storeid);
					// $approval_array = array();
					// foreach ($oic_storeid as $matrix) {
					// 	array_push($approval_array, $matrix->stores_id);
					// }
					// $approval_string = implode(",", $approval_array);
					// $storeList = array_map('intval', explode(",", $approval_string));

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
						->where('request_header.status', 'AUDITED')
						->get();
				} else if (CRUDBooster::myPrivilegeName() == 'AP Checker') {

					$checker_storeid = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->get();
					// dd($oic_storeid);
					$approval_array = array();
					foreach ($checker_storeid as $matrix) {
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
						// //---unhide this after covid-19-------------
				// 		->where('request_header.status', 'RECEIPTED')
						// //------------------------------------------
						
						//--use this for covid-19--------
						->where('request_header.status', 'AUDITED')
						//-----------------------------------
						->get();
						
				} else if (CRUDBooster::myPrivilegeName() == 'Treasury') {

					$treasury_storeid = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->get();
					// dd($oic_storeid);
					$approval_array = array();
					foreach ($treasury_storeid as $matrix) {
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
						->where('request_header.status', 'PROCESSED')
						->get();
				} else {
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

					$request_version = "VERSION: " + $orderRow->version;


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
						$orderRow->receipt_at,				//'REORDER QTY'
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
	
	public function ExportfilteredApproval()
	{

		$filename = 'Pending Request Filtered - ' . date("d M Y - h.i.sa");
		$sheetname = 'Pending Request Filtered' . date("d-M-Y");

		Excel::create($filename, function ($excel) {
			$excel->sheet('pending-request', function ($sheet) {
				// Set auto size for sheet
				$sheet->setAutoSize(true);
				$sheet->setColumnFormat(array(
					'K' => '0.00',		//for line value
					'L' => '0.00'		//for total value
				));
		

                $result = array();


				if (CRUDBooster::myPrivilegeName() == 'Requestor') {
					$store = DB::table('cms_users')->where('id', CRUDBooster::myId())->first();
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
						->where('request_header.requested_by', CRUDBooster::myId())
						->where('stores.store_status', 'ACTIVE')
						->where('request_header.deleted', '0')
						->whereIn('request_header.status', ['REQUESTED','DISAPPROVED']);
						
						
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
						$reimbursedData->orderBy('request_header.reference_number','ASC');
						$result = $reimbursedData->get();
						
				} else if (CRUDBooster::myPrivilegeName() == 'OIC') {

					// $oic_storeid = DB::table('cms_users')->where('id', CRUDBooster::myId())->get();
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
						->where('request_header.status', 'REQUESTED');
						
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
						
						$reimbursedData->orderBy('request_header.reference_number','ASC');
						$result = $reimbursedData->get();
						
				} else if (CRUDBooster::myPrivilegeName() == 'AP Receiver') {

					// $oic_storeid = DB::table('cms_users')->where('id', CRUDBooster::myId())->get();
					// // dd($oic_storeid);
					// $approval_array = array();
					// foreach ($oic_storeid as $matrix) {
					// 	array_push($approval_array, $matrix->stores_id);
					// }
					// $approval_string = implode(",", $approval_array);
					// $storeList = array_map('intval', explode(",", $approval_string));

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
						->where('request_header.status', 'AUDITED');
						
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
						
						$reimbursedData->orderBy('request_header.reference_number','ASC');
						$result = $reimbursedData->get();
						
						
				} else if (CRUDBooster::myPrivilegeName() == 'AP Checker') {

					$checker_storeid = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->get();
					// dd($oic_storeid);
					$approval_array = array();
					foreach ($checker_storeid as $matrix) {
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
						->whereIn('stores.id',$storeList)
						->where('request_header.deleted', '0')
						// //---unhide this after covid-19-------------
				// 		->where('request_header.status', 'RECEIPTED');
						// //------------------------------------------
						
						//--use this for covid-19--------
						->where('request_header.status', 'AUDITED');
						//-----------------------------------
						
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
						
						$reimbursedData->orderBy('request_header.reference_number','ASC');
						$result = $reimbursedData->get();
						
						
				} else if (CRUDBooster::myPrivilegeName() == 'Treasury') {

					$treasury_storeid = DB::table('approval_matrices')->where('cms_users_id', CRUDBooster::myId())->get();
					// dd($oic_storeid);
					$approval_array = array();
					foreach ($treasury_storeid as $matrix) {
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
						->whereIn('stores.id',$storeList)
						->where('request_header.deleted', '0')
						->where('request_header.status', 'PROCESSED');
						
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
						
						$reimbursedData->orderBy('request_header.reference_number','ASC');
						$result = $reimbursedData->get();
						
				} else {
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
						)
						->where('request_header.deleted', '0');
						
						
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
						
						$reimbursedData->orderBy('request_header.reference_number','ASC');
						$result = $reimbursedData->get();
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

					$request_version = "VERSION: " + $orderRow->version;


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
						$orderRow->receipt_at,				//'REORDER QTY'
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
