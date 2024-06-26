<?php
namespace App\Http\Controllers;

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
use App\Users;
use App\CustomerLocation;
use App\Account;
use App\Brand;
use App\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Excel;
use Carbon\Carbon;
use App\ModeOfPayment;

class AdminPrfHeaderController extends \crocodicstudio\crudbooster\controllers\CBController
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
		$this->col = [];
		$this->col[] = ["label" => "Request Status", "name" => "status_id", "join" => "statuses,status_name"];
		$this->col[] = ["label" => "Reference Number", "name" => "reference_number"];
		//$this->col[] = ["label"=>"Location","name"=>"location_id","join"=>"stores,store_name"];
		$this->col[] = ["label" => "Department", "name" => "department_id", "join" => "department,department_name"];
		$this->col[] = ["label" => "Sub Department", "name" => "sub_department_id", "join" => "sub_department,sub_department_name"];
		$this->col[] = ["label" => "Requested By", "name" => "requestor_name"];
		$this->col[] = ["label" => "Requested Date", "name" => "created_at"];
		$this->col[] = ["label" => "Approved By", "name" => "approved_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Approved Date", "name" => "approved_at"];
		$this->col[] = ["label" => "Rejected Date", "name" => "rejected_at"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
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
		if (CRUDBooster::isUpdate()) {
			$Rejected = RequestStatus::where('id', 6)->value('id');

			$this->addaction[] = ['title' => 'View', 'url' => CRUDBooster::mainpath('getRequestDetail/[id]'), 'icon' => 'fa fa-eye'];
			//$this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestEdit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Rejected"]; //, "showIf"=>"[status_level1] == $inwarranty"
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
		$this->index_button = array();
		if (CRUDBooster::getCurrentMethod() == 'getIndex') {
			$this->index_button[] = ["label" => "Add Request", "icon" => "fa fa-files-o", "url" => CRUDBooster::mainpath('add-payment-request'), "color" => "success"];
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
		$this->index_statistic[] = ['label' => 'Request may take up to 3 to 5 working days before release of funds.', 'label1' => 'Use this for transactions above P1,000.00 in total value.', 'color' => 'light-blue', 'width' => 'col-sm-12', 'icon' => 'fa fa-file-text-o'];



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
		if (CRUDBooster::myPrivilegeName() == "Approver") {
			$query->where('prf_header.created_by', CRUDBooster::myId())->whereNull('prf_header.deleted_at')->orderBy('prf_header.status_id', 'DESC')->orderBy('prf_header.id', 'DESC');
		} else {
			$query->where('prf_header.created_by', CRUDBooster::myId())->whereNull('prf_header.deleted_at')->orderBy('prf_header.status_id', 'DESC')->orderBy('prf_header.id', 'DESC');
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
		$Entered = RequestStatus::where('id', 1)->value('status_name');
		$Approved = RequestStatus::where('id', 2)->value('status_name');
		$Validated = RequestStatus::where('id', 3)->value('status_name');
		$Printed = RequestStatus::where('id', 5)->value('status_name');
		$Paid = RequestStatus::where('id', 4)->value('status_name');
		$Rejected = RequestStatus::where('id', 6)->value('status_name');
		$Transmitted = RequestStatus::where('id', 11)->value('status_name');

		$Closed = RequestStatus::where('id', 8)->value('status_name');

		$Cancelled = RequestStatus::where('id', 9)->value('status_name');

		if ($column_index == 2) {
			if ($column_value == $Entered) {
				$column_value = '<span class="label label-warning">' . $Entered . '</span>';
			} else if ($column_value == $Approved) {
				$column_value = '<span class="label label-info">' . $Approved . '</span>';
			} else if ($column_value == $Validated) {
				$column_value = '<span class="label label-primary">' . $Validated . '</span>';
			} else if ($column_value == $Printed) {
				$column_value = '<span class="label label-primary">' . $Printed . '</span>';
			} else if ($column_value == $Paid) {
				$column_value = '<span class="label label-primary">' . $Paid . '</span>';
			} else if ($column_value == $Rejected) {
				$column_value = '<span class="label label-danger">' . $Rejected . '</span>';
			} else if ($column_value == $Closed) {
				$column_value = '<span class="label label-success">' . $Closed . '</span>';
			} else if ($column_value == $Cancelled) {
				$column_value = '<span class="label label-danger">' . $Cancelled . '</span>';
			} else if ($column_value == $Transmitted) {
				$column_value = '<span style="background-color: #8a2be2; color: white;" class="label">' . $Transmitted . '</span>';
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
	public function hook_before_add(&$postdata)
	{


		//ini_set('post_max_size', '4M');
		//ini_set('upload_max_filesize', '8M');
		//Your code here
		/*$fields = Input::all();
																						 $dataLines = array();

																						 $department_id 	= $fields['department_id'];
																						 $sub_department_id 	= $fields['sub_department_id'];
																						 $location_id 	= $fields['location_id'];
																						 $total_value_order 	= $fields['total_value_order'];
																						 $requestor_comments 	= $fields['requestor_comments'];

																						 $files 	= $fields['receipt'];

																						 $count_header = PRFHeader::count();
																						 $header_ref   =  str_pad($count_header + 1, 7, '0', STR_PAD_LEFT);			
																						 $reference_number	= "REF-".$header_ref;
																					 
																						 $extension1 =  time(). '.' .$files->getClientOriginalExtension();
																						 $filename = $extension1;
																						 $files->move('vendor/crudbooster/',$filename);
																						 $images ='vendor/crudbooster/'.$filename;
																							 
																						 $postdata['receipt'] = $images;

																						 $postdata['reference_number'] = $reference_number;
																						 $postdata['department_id'] = $department_id;
																						 $postdata['sub_department_id'] = $sub_department_id;
																						 $postdata['location_id'] = $location_id;
																						 $postdata['total_value_order'] = $total_value_order;
																						 $postdata['requestor_comments'] = $requestor_comments;
																						 $postdata['status_id'] = 1;
																						 $postdata['created_by'] 					= CRUDBooster::myId();
																						 $postdata['created_at'] 					= date('Y-m-d H:i:s');
																						 */


		$fields = Input::all();
		$dataLines = array();

		$customer_location_id = $fields['customer_location_id'];
		$department_id = $fields['department_id'];
		$sub_department_id = $fields['sub_department_id'];
		$location_id = $fields['location_id'];
		$total_value_order = $fields['total_value_order'];
		$requestor_comments = $fields['requestor_comments'];
		$requestor_name = $fields['requestor_name'];

		$mode_of_payment_id = $fields['mode_of_payment_id'];
		$bank_name = $fields['bank_name'];
		$bank_branch_name = $fields['bank_branch_name'];
		$bank_account_name = $fields['bank_account_name'];
		$bank_account_number = $fields['bank_account_number'];

		$gcash_number = $fields['gcash_number'];
		$payee_name = $fields['payee_name'];


		$count_header = PRFHeader::count();
		$header_ref = str_pad($count_header + 1, 7, '0', STR_PAD_LEFT);
		$reference_number = "PRF-" . $header_ref;

		/*$files 	= $fields['receipt'];
																						 $extension1 =  time(). '.' .$files->getClientOriginalExtension();
																						 $filename = $extension1;
																						 $files->move('vendor/crudbooster/',$filename);
																						 $images ='vendor/crudbooster/'.$filename;
																							 
																						 $postdata['receipt'] = $images;*/

		$files = $fields['receipt'];

		ini_set('post_max_size', '64M');
		ini_set('upload_max_filesize', '64M');

		//ini_set('post_max_size', '2000M');
		//ini_set('upload_max_filesize', '2000M');

		$images = array();
		$counter = 0;

		foreach ($files as $file) {
			$counter++;
			$extension1 = $counter . time() . '.' . $file->getClientOriginalExtension();
			$filename = $extension1;
			$file->move('vendor/crudbooster/', $filename);
			$images[] = 'vendor/crudbooster/' . $filename;
		}


		$postdata['receipt'] = implode("|", $images);

		$postdata['reference_number'] = $reference_number;
		$postdata['customer_location_id'] = $customer_location_id;
		$postdata['department_id'] = $department_id;
		$postdata['sub_department_id'] = $sub_department_id;
		//$postdata['location_id'] = $location_id;
		$postdata['total_value_order'] = $total_value_order;
		$postdata['requestor_comments'] = $requestor_comments;
		$postdata['requestor_name'] = $requestor_name;
		$postdata['status_id'] = 1;
		$postdata['created_by'] = CRUDBooster::myId();
		$postdata['created_at'] = date('Y-m-d H:i:s');

		$postdata['mode_of_payment_id'] = $mode_of_payment_id;
		$postdata['bank_name'] = $bank_name;
		$postdata['bank_branch_name'] = $bank_branch_name;
		$postdata['bank_account_name'] = $bank_account_name;
		$postdata['bank_account_number'] = $bank_account_number;

		$postdata['gcash_number'] = $gcash_number;
		$postdata['payee_name'] = $payee_name;

		$postdata['cc_payee_name'] = $fields['cc_payee_name'];
		$postdata['cc_last_card_number'] = $fields['cc_credit_card'];

		$postdata['need_by_date'] = $fields['need_by_date'];
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
		$fields = Input::all();
		$dataLines = array();

		$prf_header = PRFHeader::where(['created_by' => CRUDBooster::myId()])->orderBy('id', 'desc')->first();

		$account_id = $fields['account_id'];
		$brand_id = $fields['brand_id'];
		$category_id = $fields['category_id'];
		$particulars = $fields['particulars'];
		$currency_id = $fields['currency_id'];
		$quantity = $fields['quantity'];
		$line_value = $fields['line_value'];
		$total_value = $fields['total_value'];
		$location_id = $fields['location_id'];


		for ($x = 0; $x < count((array) $particulars); $x++) {

			$dataLines[$x]['prf_header_id'] = $prf_header->id;
			$dataLines[$x]['account_id'] = $account_id[$x];
			$dataLines[$x]['brand_id'] = $brand_id[$x];
			$dataLines[$x]['category_id'] = $category_id[$x];
			$dataLines[$x]['particulars'] = $particulars[$x];
			$dataLines[$x]['currency_id'] = $currency_id[$x];
			$dataLines[$x]['quantity'] = $quantity[$x];
			$dataLines[$x]['line_value'] = $line_value[$x];
			$dataLines[$x]['total_value'] = $total_value[$x];
			$dataLines[$x]['location_id'] = $location_id[$x];
			$dataLines[$x]['created_at'] = date('Y-m-d H:i:s');

		}

		DB::beginTransaction();

		try {
			PRFBody::insert($dataLines);
			DB::commit();
			//CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_pullout_data_success",['mps_reference'=>$pullout_header->reference]), 'success');
		} catch (\Exception $e) {
			DB::rollback();
			CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_database_error", ['database_error' => $e]), 'danger');
		}


		CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_add_success", ['reference_number' => $prf_header->reference_number]), 'success');
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


		/*$department_id 	= $fields['department_id'];
																						 $sub_department_id 	= $fields['sub_department_id'];
																						 $location_id 	= $fields['location_id'];
																						 $total_value_order 	= $fields['total_value_order'];
																						 $requestor_comments 	= $fields['requestor_comments'];
																						 
																						 $postdata['department_id'] 			= $department_id;
																						 $postdata['sub_department_id'] 		= $sub_department_id;
																						 $postdata['location_id'] 			= $location_id;
																						 $postdata['total_value_order'] 		= $total_value_order;
																						 $postdata['requestor_comments'] 	= $requestor_comments;
																						 $postdata['status_id'] 		= 1;
																						 $postdata['updated_by'] 	= CRUDBooster::myId();
																						 $postdata['updated_at'] 	= date('Y-m-d H:i:s'); */

		$fields = Input::all();
		$customer_location_id = $fields['customer_location_id'];
		$department_id = $fields['department_id'];
		$sub_department_id = $fields['sub_department_id'];
		$location_id = $fields['location_id'];
		$total_value_order = $fields['total_value_order'];
		$requestor_comments = $fields['requestor_comments'];
		$requestor_name = $fields['requestor_name'];

		$files = $fields['receipt'];



		if (!empty($files)) {




			ini_set('post_max_size', '64M');
			ini_set('upload_max_filesize', '64M');

			//ini_set('post_max_size', '2000M');
			//ini_set('upload_max_filesize', '2000M');

			$images = array();
			$counter = 0;

			foreach ($files as $file) {
				$counter++;
				$extension1 = $counter . time() . '.' . $file->getClientOriginalExtension();
				$filename = $extension1;
				$file->move('vendor/crudbooster/', $filename);
				$images[] = 'vendor/crudbooster/' . $filename;
			}

			$postdata['receipt'] = implode("|", $images);

		}

		$postdata['customer_location_id'] = $customer_location_id;
		$postdata['department_id'] = $department_id;
		$postdata['sub_department_id'] = $sub_department_id;
		$postdata['location_id'] = $location_id;
		$postdata['total_value_order'] = $total_value_order;
		$postdata['requestor_comments'] = $requestor_comments;
		$postdata['requestor_name'] = $requestor_name;
		$postdata['status_id'] = 1;
		$postdata['updated_by'] = CRUDBooster::myId();
		$postdata['updated_at'] = date('Y-m-d H:i:s');

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

		$fields = Input::all();
		$dataLines = array();

		$prf_header = PRFHeader::where(['id' => $id])->first();

		$item_id = $fields['item_id'];
		$account_id = $fields['account_id'];
		$brand_id = $fields['brand_id'];
		$currency_id = $fields['currency_id'];
		$category_id = $fields['category_id'];
		$particulars = $fields['particulars'];
		$quantity = $fields['quantity'];
		$line_value = $fields['line_value'];
		$total_value = $fields['total_value'];
		$location_id = $fields['location_id'];

		$add_items = $fields['add_items'];


		for ($x = 0; $x < count((array) $particulars); $x++) {

			PRFBody::where('id', $item_id[$x])
				->update([
					'account_id' => $account_id[$x],
					'brand_id' => $brand_id[$x],
					'category_id' => $category_id[$x],
					'particulars' => $particulars[$x],
					'currency_id' => $currency_id[$x],
					'quantity' => $quantity[$x],
					'line_value' => $line_value[$x],
					'total_value' => $total_value[$x],
					'location_id' => $location_id
				]);

		}

		if ($add_items == 0) {

			$account_id = $fields['account_id_add'];
			$brand_id = $fields['brand_id_add'];
			$currency_id = $fields['currency_id_add'];
			$category_id = $fields['category_id_add'];
			$particulars = $fields['particulars_add'];
			$quantity = $fields['quantity_add'];
			$line_value = $fields['line_value_add'];
			$total_value = $fields['total_value_add'];
			$location_id = $fields['location_id'];

			for ($x = 0; $x < count((array) $particulars); $x++) {
				$dataLines[$x]['prf_header_id'] = $prf_header->id;
				$dataLines[$x]['account_id'] = $account_id[$x];
				$dataLines[$x]['brand_id'] = $brand_id[$x];
				$dataLines[$x]['category_id'] = $category_id[$x];
				$dataLines[$x]['particulars'] = $particulars[$x];
				$dataLines[$x]['currency_id'] = $currency_id[$x];
				$dataLines[$x]['quantity'] = $quantity[$x];
				$dataLines[$x]['line_value'] = $line_value[$x];
				$dataLines[$x]['total_value'] = $total_value[$x];
				$dataLines[$x]['location_id'] = $location_id;
				$dataLines[$x]['created_at'] = date('Y-m-d H:i:s');
			}

			DB::beginTransaction();

			try {
				PRFBody::insert($dataLines);
				DB::commit();
				//CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_pullout_data_success",['mps_reference'=>$pullout_header->reference]), 'success');
			} catch (\Exception $e) {
				DB::rollback();
				CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_database_error", ['database_error' => $e]), 'danger');
			}

		}

		CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_edit_success", ['reference_number' => $prf_header->reference_number]), 'success');


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


	public function AddRequest()
	{

		$this->cbLoader();
		if (!CRUDBooster::isCreate() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = array();

		$customer_location = array();

		$department_array = array();

		$sub_department_array = array();

		$location_array = array();

		$data['page_title'] = 'Add Payment Request';

		$user_data = Users::where('id', CRUDBooster::myId())->first();


		$data['CustomerLocation'] = CustomerLocation::
			leftjoin('stores', 'customer.location_id', '=', 'stores.id')
			->select('customer.*', 'stores.id as locationid', 'stores.store_name as location_name')
			->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();
		//->whereIn('customer.id', explode(",",$user_data->customer_name_id))->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();

		$data['Location'] = Store::where('store_status', 'ACTIVE')->orderby('store_name', 'ASC')->get();

		$data['Departments'] = Department::whereIn('id', explode(",", $user_data->department_id))->where('status', 'ACTIVE')->orderby('department_name', 'ASC')->get();

		//$data['SubDepartments'] = SubDepartment::whereIn('id', explode(",",$user_data->sub_department_id))->where('status', 'ACTIVE')->orderby('sub_department_name', 'ASC')->get();


		//$data['Locations'] = Store::whereIn('id', $location_list)->where('store_status', 'ACTIVE')->orderby('store_name', 'ASC')->get();

		//dd($data['SubDepartments']);
		/*
																						 $approval_search = ApprovalMatrix::where('cms_users_id', CRUDBooster::myId())->get();

																						 foreach($approval_search as $approval_value){

																							 if(!in_array($approval_value->department_id,$department_array)){
																								 array_push($department_array, $approval_value->department_id);
																							 }
																						 }

																						 $approval_string = implode(",",$department_array);
																						 $department_list = array_map('intval',explode(",",$approval_string));


																						 $data['Departments'] = Department::whereIn('id', $department_list)->where('status', 'ACTIVE')->orderby('department_name', 'ASC')->get();

																						 foreach($data['Departments'] as $approval_value){

																							 if(!in_array($approval_value->id, $sub_department_array)){
																								 array_push($sub_department_array, $approval_value->id);
																							 }

																						 }

																						 $approval_string1 = implode(",",$sub_department_array);
																						 $sub_department_list = array_map('intval',explode(",",$approval_string1));


																						 $data['SubDepartments'] = SubDepartment::whereIn('department_id', $sub_department_list)->where('status', 'ACTIVE')->orderby('sub_department_name', 'ASC')->get();
																						 

																						 foreach($approval_search as $approval_value){

																							 if(!in_array($approval_value->store_list,$location_array)){
																								 array_push($location_array, $approval_value->store_list);
																							 }
																						 }

																						 $approval_string2 = implode(",",$location_array);
																						 $location_list = array_map('intval',explode(",",$approval_string2));

																						 $data['Locations'] = Store::whereIn('id', $location_list)->where('store_status', 'ACTIVE')->orderby('store_name', 'ASC')->get();
																						 */


		$data['Categories'] = category::where('status', 'ACTIVE')->orderby('category_name', 'ASC')->get();

		$data['Accounts'] = Account::where('status', 'ACTIVE')->orderby('account_name', 'ASC')->get();

		$data['Brands'] = Brand::where('status', 'ACTIVE')->orderby('brand_name', 'ASC')->get();

		$data['Currencies'] = Currency::where('status', 'ACTIVE')->orderby('currency_name', 'ASC')->get();

		$data['ModeOfPayments'] = ModeOfPayment::where('status', 'ACTIVE')->orderby('mode_of_payment_name', 'ASC')->get();

		return view("prf.add", $data);
	}


	public function getRequestDetail($id)
	{
		$this->cbLoader();
		if (!CRUDBooster::isRead() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = array();


		$data['page_title'] = 'View Payment Request';

		$data['Header'] = PRFHeader::
			leftjoin('department', 'prf_header.department_id', '=', 'department.id')
			->leftjoin('customer', 'prf_header.customer_location_id', '=', 'customer.id')
			->leftjoin('sub_department', 'prf_header.sub_department_id', '=', 'sub_department.id')
			->leftjoin('stores', 'prf_header.location_id', '=', 'stores.id')
			->leftjoin('cms_users as requestor', 'prf_header.created_by', '=', 'requestor.id')
			->leftjoin('statuses', 'prf_header.status_id', '=', 'statuses.id')
			->leftjoin('cms_users as approver', 'prf_header.approved_by', '=', 'approver.id')
			->leftjoin('invoice_type', 'prf_header.invoice_type_id', '=', 'invoice_type.id')
			->leftjoin('payment_status', 'prf_header.payment_status_id', '=', 'payment_status.id')
			->leftjoin('vat_type', 'prf_header.vat_type_id', '=', 'vat_type.id')
			->leftjoin('cms_users as validator', 'prf_header.validated_by', '=', 'validator.id')
			->leftjoin('cms_users as paidby', 'prf_header.paid_by', '=', 'paidby.id')
			->leftjoin('cms_users as printed', 'prf_header.printed_by', '=', 'printed.id')
			->leftjoin('cms_users as closed', 'prf_header.closed_by', '=', 'closed.id')
			->leftjoin('mode_of_payment', 'prf_header.mode_of_payment_id', '=', 'mode_of_payment.id')
			->leftjoin('interco as company', 'prf_header.interco_id', '=', 'company.id')
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
				'prf_header.need_by_date as need_by_date',
				'paidby.name as paidlevel',
				'printed.name as printedlevel',
				'mode_of_payment.mode_of_payment_name as mode_of_payment_name',
				'closed.name as closedlevel',
				'company.interco_name as companylevel',
			)
			->where('prf_header.id', $id)->first();

		$data['Body'] = PRFBody::
			leftjoin('category', 'prf_body.category_id', '=', 'category.id')
			->leftjoin('account', 'prf_body.account_id', '=', 'account.id')
			->leftjoin('brand', 'prf_body.brand_id', '=', 'brand.id')
			->leftjoin('currency', 'prf_body.currency_id', '=', 'currency.id')
			->leftjoin('invoice_type', 'prf_body.invoice_type_id', '=', 'invoice_type.id')
			->leftjoin('payment_status', 'prf_body.payment_status_id', '=', 'payment_status.id')
			->leftjoin('vat_type', 'prf_body.vat_type_id', '=', 'vat_type.id')

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




		return view("prf.detail", $data);

	}

	public function getRequestEdit($id)
	{
		$this->cbLoader();
		if (!CRUDBooster::isUpdate() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = array();

		$customer_location = array();

		$department_array = array();

		$sub_department_array = array();

		$location_array = array();

		$data['page_title'] = 'Edit Payment Request Form';

		$user_data = Users::where('id', CRUDBooster::myId())->first();


		$data['CustomerLocation'] = CustomerLocation::
			leftjoin('stores', 'customer.location_id', '=', 'stores.id')
			->select('customer.*', 'stores.id as locationid', 'stores.store_name as location_name')
			->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();
		//->whereIn('customer.id', explode(",",$user_data->customer_name_id))->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();

		$data['Location'] = Store::where('store_status', 'ACTIVE')->orderby('store_name', 'ASC')->get();

		$data['Departments'] = Department::whereIn('id', explode(",", $user_data->department_id))->where('status', 'ACTIVE')->orderby('department_name', 'ASC')->get();

		$data['SubDepartments'] = SubDepartment::whereIn('id', explode(",", $user_data->sub_department_id))->where('status', 'ACTIVE')->orderby('sub_department_name', 'ASC')->get();

		$data['Header'] = PRFHeader::
			leftjoin('department', 'prf_header.department_id', '=', 'department.id')
			->leftjoin('sub_department', 'prf_header.sub_department_id', '=', 'sub_department.id')
			->leftjoin('stores', 'prf_header.location_id', '=', 'stores.id')
			->leftjoin('cms_users as requestor', 'prf_header.created_by', '=', 'requestor.id')
			->leftjoin('statuses', 'prf_header.status_id', '=', 'statuses.id')
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


		$data['Categories'] = category::where('status', 'ACTIVE')->orderby('category_name', 'ASC')->get();

		$data['Accounts'] = Account::where('status', 'ACTIVE')->orderby('account_name', 'ASC')->get();

		$data['Brands'] = Brand::where('status', 'ACTIVE')->orderby('brand_name', 'ASC')->get();

		$data['Currencies'] = Currency::where('status', 'ACTIVE')->orderby('currency_name', 'ASC')->get();

		$data['ModeOfPayments'] = ModeOfPayment::where('status', 'ACTIVE')->orderby('mode_of_payment_name', 'ASC')->get();


		return view("prf.edit", $data);

	}


	public function setDeleteItem(Request $request)
	{
		$RowID = $request->row_id;
		// \Log::info(json_encode($request->line_id));
		PRFBody::where('id', $RowID)
			->update([
				'row_deleted' => '1',
				'deleted_at' => date('Y-m-d H:i:s')
			]);
		return "success!";
	}


	public function Category(Request $request)
	{
		$account = Account::where('status', 'ACTIVE')->where('category_id', $request->category)->orderBy('account_name', 'ASC')->get();

		return ($account);
	}


	public function CustomerLocation(Request $request)
	{
		$location = CustomerLocation::leftjoin('stores', 'customer.location_id', '=', 'stores.id')
			->select('customer.*', 'stores.id as locationid', 'stores.store_name as location_name')
			//->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();
			->where('customer.id', $request->customer_location_id)->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();

		return ($location);
	}

	public function SubDepartment(Request $request)
	{
		$subdepartment = SubDepartment::where('department_id', $request->department)->where('status', 'ACTIVE')->orderby('sub_department_name', 'ASC')->get();

		return ($subdepartment);
	}


}