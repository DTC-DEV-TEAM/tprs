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

class AdminPettyCashHistoryController extends \crocodicstudio\crudbooster\controllers\CBController
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
		$this->col[] = ["label" => "Request Status", "name" => "status_id", "join" => "statuses,status_name"];
		$this->col[] = ["label" => "Reference Number", "name" => "reference_number"];
		//$this->col[] = ["label"=>"Location","name"=>"location_id","join"=>"stores,store_name"];
		//$this->col[] = ["label"=>"Cutomer/Location Name","name"=>"customer_location_id","join"=>"customer,cutomer_name"];
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
		/*$this->form[] = ['label'=>'Reference Number','name'=>'reference_number','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
				 //$this->form[] = ['label'=>'Status Id','name'=>'status_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'status,id'];
				 $this->form[] = ['label'=>'Location Id','name'=>'location_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'location,id'];
				 $this->form[] = ['label'=>'Department Id','name'=>'department_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'department,department_name'];
				 $this->form[] = ['label'=>'Sub Department Id','name'=>'sub_department_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'sub_department,sub_department_name'];
				 //$this->form[] = ['label'=>'Invoice Type Id','name'=>'invoice_type_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'invoice_type,invoice_type_name'];
				 $this->form[] = ['label'=>'Payment Status Id','name'=>'payment_status_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'payment_status,payment_status_name'];
				 $this->form[] = ['label'=>'Vat Type Id','name'=>'vat_type_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-10','datatable'=>'vat_type,vat_type_name'];
				 $this->form[] = ['label'=>'Padate','name'=>'paid_date','type'=>'date','validation'=>'required|date','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Total Value Order','name'=>'total_value_order','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Total Quantity Order','name'=>'total_quantity_order','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Requestor Comments','name'=>'requestor_comments','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Approver Comments','name'=>'approver_comments','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Approved By','name'=>'approved_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Approved At','name'=>'approved_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Rejected At','name'=>'rejected_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Validated By','name'=>'validated_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Validated At','name'=>'validated_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Paby','name'=>'paid_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Paat','name'=>'paid_at','type'=>'datetime','validation'=>'required|date_format:Y-m-d H:i:s','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Created By','name'=>'created_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
				 $this->form[] = ['label'=>'Updated By','name'=>'updated_by','type'=>'number','validation'=>'required|integer|min:0','width'=>'col-sm-10'];
				 */# END FORM DO NOT REMOVE THIS LINE

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

			$Validated = RequestStatus::where('id', 3)->value('id');
			$Printed = RequestStatus::where('id', 5)->value('id');
			$Paid = RequestStatus::where('id', 4)->value('id');
			$Closed = RequestStatus::where('id', 8)->value('id');

			$Recorded = RequestStatus::where('id', 7)->value('id');

			$this->addaction[] = ['title' => 'View', 'url' => CRUDBooster::mainpath('getRequestDetail/[id]'), 'icon' => 'fa fa-eye'];

			// $this->addaction[] = ['title'=>'Edit','url'=>CRUDBooster::mainpath('getRequestEdit/[id]'),'icon'=>'fa fa-pencil', "showIf"=>"[status_id] == $Validated or [status_id] == $Printed or [status_id] == $Recorded or [status_id] == $Paid"];

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
		if (CRUDBooster::isUpdate()) {
			$this->button_selected[] = [
				'label' => 'Cancel',
				'icon' => 'fa fa-times',
				'name' => 'set_cancel'
			];


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
		if (CRUDBooster::getCurrentMethod() == 'getIndex') {
			$this->index_button[] = [
				"title" => "Export",
				"label" => "Export",
				"icon" => "fa fa-download",
				"url" => CRUDBooster::adminpath('export-petty-cash') . '?' . urldecode(http_build_query(@$_GET))
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

		if ($button_name == 'set_cancel') {

			/*PettyCashHeader::whereIn('id',$id_selected)->update([
							'status_id'=> 9, 
							'updated_at' => date('Y-m-d H:i:s'), 
							'updated_by' => CRUDBooster::myId()]);*/


			$checker = PettyCashHeader::whereIn('id', $id_selected)->get();




			foreach ($checker as $check) {


				if ($check->status_id != 9) {

					if ($check->status_id != 4) {

						if ($check->status_id != 6) {

							PettyCashHeader::where('id', $check->id)->update([
								'status_id' => 9,
								'updated_at' => date('Y-m-d H:i:s'),
								'updated_by' => CRUDBooster::myId()
							]);

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
	public function hook_query_index(&$query)
	{
		//Your code here
		if (CRUDBooster::myPrivilegeName() == "Approver") {

			$Entered = RequestStatus::where('id', 1)->value('id');

			/*$approvalMatrix = ApprovalMatrix::where('approval_matrices.cms_users_id', CRUDBooster::myId())->get();
						$approval_array = array();
						foreach($approvalMatrix as $matrix){
							array_push($approval_array, $matrix->sub_department_id);
						}
						$approval_string = implode(",",$approval_array);
						$SubDepartmentList = array_map('intval',explode(",",$approval_string));
			
						$query->whereIn('petty_cash_header.sub_department_id', $SubDepartmentList)->where('petty_cash_header.status_id','!=', $Entered)->whereNull('petty_cash_header.deleted_at')->orderBy('petty_cash_header.id', 'ASC');
						*/
			$user_data = Users::where('id', CRUDBooster::myId())->first();

			$query->whereIn('petty_cash_header.department_id', explode(",", $user_data->approver_department_id))
				->whereIn('petty_cash_header.sub_department_id', explode(",", $user_data->approver_sub_department_id))
				//->whereIn('petty_cash_header.customer_location_id', explode(",",$user_data->approver_customer_name_id))
				->where('petty_cash_header.status_id', '!=', $Entered)
				->whereNull('petty_cash_header.deleted_at')
				->orderBy('petty_cash_header.id', 'ASC');

		} else if (CRUDBooster::myPrivilegeName() == "Custodian") {
			//$query->whereNotNull('petty_cash_header.validated_by')->whereNull('petty_cash_header.deleted_at')->orderBy('petty_cash_header.id', 'ASC');

			$query->whereNull('petty_cash_header.deleted_at')->orderBy('petty_cash_header.id', 'ASC');
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
		$Closed = RequestStatus::where('id', 8)->value('status_name');
		$Cancelled = RequestStatus::where('id', 9)->value('status_name');
		$Recorded = RequestStatus::where('id', 7)->value('status_name');
		$Released = RequestStatus::where('id', 10)->value('status_name');

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
				$column_value = '<span class="label label-success">' . $Paid . '</span>';
			} else if ($column_value == $Rejected) {
				$column_value = '<span class="label label-danger">' . $Rejected . '</span>';
			} else if ($column_value == $Closed) {
				$column_value = '<span class="label label-success">' . $Closed . '</span>';
			} else if ($column_value == $Cancelled) {
				$column_value = '<span class="label label-danger">' . $Cancelled . '</span>';
			} else if ($column_value == $Recorded) {
				$column_value = '<span class="label label-primary">' . $Recorded . '</span>';
			} else if ($column_value == $Released) {
				$column_value = '<span class="label label-primary">' . $Released . '</span>';
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

		$fields = Input::all();
		$customer_location_id = $fields['customer_location_id'];
		$department_id = $fields['department_id'];
		$sub_department_id = $fields['sub_department_id'];
		$location_id = $fields['location_id'];
		$total_value_order = $fields['total_value_order'];
		$requestor_comments = $fields['requestor_comments'];
		$requestor_name = $fields['requestor_name'];

		$si_or_number = $fields['si_or_number'];
		$si_or_date = $fields['si_or_date'];
		$address = $fields['address'];
		$tin_number = $fields['tin_number'];
		$payee = $fields['payee'];
		$vat_amount = $fields['vat_amount'];

		$paid_date = $fields['paid_date'];


		$interco_id = $fields['interco_id'];
		$item_id = $fields['item_id'];
		$invoice_type_id = $fields['invoice_type_id'];
		$payment_status_id = $fields['payment_status_id'];
		$vat_type_id = $fields['vat_type_id'];
		$product_id = $fields['product_id'];


		$postdata['customer_location_id'] = $customer_location_id;
		$postdata['department_id'] = $department_id;
		$postdata['sub_department_id'] = $sub_department_id;
		//$postdata['location_id'] 			= $location_id;
		$postdata['total_value_order'] = $total_value_order;
		$postdata['requestor_comments'] = $requestor_comments;
		$postdata['requestor_name'] = $requestor_name;
		//$postdata['status_id'] 		= 1;
		$postdata['updated_by'] = CRUDBooster::myId();
		$postdata['updated_at'] = date('Y-m-d H:i:s');



		$postdata['address'] = $address;
		$postdata['tin_number'] = $tin_number;
		$postdata['payee'] = $payee;
		$postdata['vat_amount'] = $vat_amount;

		$postdata['paid_date'] = $paid_date;

		$postdata['interco_id'] = $interco_id;

		//$postdata['status_id'] 		= RequestStatus::where('id', 7)->value('id');
		//$postdata['recorded_by'] 	= CRUDBooster::myId();
		//$postdata['recorded_at'] 	= date('Y-m-d H:i:s');

		for ($x = 0; $x < count((array) $item_id); $x++) {

			PettyCashBody::where('id', $item_id[$x])
				->update([
					'invoice_type_id' => $invoice_type_id[$x],
					'payment_status_id' => $payment_status_id[$x],
					'vat_type_id' => $vat_type_id[$x],
					'product_id' => $product_id[$x]
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
	public function hook_after_edit($id)
	{
		//Your code here 

		$fields = Input::all();
		$dataLines = array();

		$petty_cash_header = PettyCashHeader::where(['id' => $id])->first();

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

		$si_or_number = $fields['si_or_number'];
		$si_or_date = $fields['si_or_date'];

		$add_items = $fields['add_items'];



		for ($x = 0; $x < count((array) $particulars); $x++) {

			PettyCashBody::where('id', $item_id[$x])
				->update([
					'si_or_number' => $si_or_number[$x],
					'si_or_date' => $si_or_date[$x],
					'account_id' => $account_id[$x],
					'brand_id' => $brand_id[$x],
					'category_id' => $category_id[$x],
					'particulars' => $particulars[$x],
					'currency_id' => $currency_id[$x],
					'quantity' => $quantity[$x],
					'line_value' => $line_value[$x],
					'total_value' => $total_value[$x],
					'location_id' => $location_id[$x]
				]);

		}



		$customer_location = CustomerLocation::where('id', $petty_cash_header->customer_location_id)->first();

		$company = 10;



		$department = SubDepartment::where('id', $petty_cash_header->sub_department_id)->value('coa_id');

		$customer = Channel::where('id', $location->channels_id)->value('coa_id');

		$interco = Interco::where('id', $petty_cash_header->interco_id)->value('coa_id');

		$Items = PettyCashBody::where('petty_cash_header_id', $petty_cash_header->id)->get();


		foreach ($Items as $Item) {


			$account = Account::where('id', $Item->account_id)->value('coa_id');

			$brand = Brand::where('id', $Item->brand_id)->value('coa_id');

			$location = Store::where('id', $Item->location_id)->first();

			$customer = Channel::where('id', $location->channels_id)->value('coa_id');

			$product = $Item->product_id;




			$coa_value = $company . "." . $location->coa_id . "." . $department . "." . $account . "." . $customer . "." . $brand . "." . $product . "." . $interco;

			//dd($coa_value);

			PettyCashBody::where('id', $Item->id)
				->update([
					'coa' => $coa_value,
				]);

		}

		CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_petty_cash_edit_success", ['reference_number' => $petty_cash_header->reference_number]), 'success');

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

	public function getRequestDetail($id)
	{
		$this->cbLoader();
		if (!CRUDBooster::isRead() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = array();


		$data['page_title'] = 'View Petty Cash Request';

		$data['Header'] = PettyCashHeader::
			leftjoin('department', 'petty_cash_header.department_id', '=', 'department.id')
			->leftjoin('customer', 'petty_cash_header.customer_location_id', '=', 'customer.id')
			->leftjoin('sub_department', 'petty_cash_header.sub_department_id', '=', 'sub_department.id')
			->leftjoin('stores', 'petty_cash_header.location_id', '=', 'stores.id')
			->leftjoin('cms_users as requestor', 'petty_cash_header.created_by', '=', 'requestor.id')
			->leftjoin('cms_users as paid_by', 'petty_cash_header.paid_by', '=', 'paid_by.id')
			->leftjoin('cms_users as recorded_by', 'petty_cash_header.recorded_by', '=', 'recorded_by.id')
			->leftjoin('statuses', 'petty_cash_header.status_id', '=', 'statuses.id')
			->leftjoin('cms_users as approver', 'petty_cash_header.approved_by', '=', 'approver.id')
			->leftjoin('invoice_type', 'petty_cash_header.invoice_type_id', '=', 'invoice_type.id')
			->leftjoin('payment_status', 'petty_cash_header.payment_status_id', '=', 'payment_status.id')
			->leftjoin('vat_type', 'petty_cash_header.vat_type_id', '=', 'vat_type.id')
			->leftjoin('cms_users as validator', 'petty_cash_header.validated_by', '=', 'validator.id')
			->leftjoin('cms_users as paidby', 'petty_cash_header.paid_by', '=', 'paidby.id')
			->select(
				'department.*',
				'customer.*',
				'sub_department.*',
				'stores.*',
				'requestor.name as requestorlevel',
				'paid_by.name as paidbylevel',
				'recorded_by.name as recordedbylevel',
				'statuses.*',
				'petty_cash_header.*',
				'approver.name as approverlevel',
				'invoice_type.*',
				'payment_status.*',
				'vat_type.*',
				'validator.name as validatorlevel',
				'petty_cash_header.created_at as requested_date',
				'petty_cash_header.id as requested_id',
				'paidby.name as paidlevel'
			)
			->where('petty_cash_header.id', $id)->first();

		$data['Body'] = PettyCashBody::
			leftjoin('category', 'petty_cash_body.category_id', '=', 'category.id')
			->leftjoin('account', 'petty_cash_body.account_id', '=', 'account.id')
			->leftjoin('brand', 'petty_cash_body.brand_id', '=', 'brand.id')
			->leftjoin('currency', 'petty_cash_body.currency_id', '=', 'currency.id')
			->leftjoin('invoice_type', 'petty_cash_body.invoice_type_id', '=', 'invoice_type.id')
			->leftjoin('payment_status', 'petty_cash_body.payment_status_id', '=', 'payment_status.id')
			->leftjoin('vat_type', 'petty_cash_body.vat_type_id', '=', 'vat_type.id')
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




		return view("petty-cash.detail", $data);

	}



	public function getRequestEdit($id)
	{
		$this->cbLoader();
		if (!CRUDBooster::isUpdate() && $this->global_privilege == FALSE) {
			CRUDBooster::redirect(CRUDBooster::adminPath(), trans("crudbooster.denied_access"));
		}

		$data = array();

		$department_array = array();
		$sub_department_array = array();
		$location_array = array();

		$data['page_title'] = 'Edit Petty Cash Request';
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

				 $data['Categories'] = category::where('status', 'ACTIVE')->orderby('category_name', 'ASC')->get();
				 */



		$data['CustomerLocation'] = CustomerLocation::
			leftjoin('stores', 'customer.location_id', '=', 'stores.id')
			->select('customer.*', 'stores.id as locationid', 'stores.store_name as location_name')
			->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();
		//->whereIn('customer.id', explode(",",$user_data->customer_name_id))->where('customer.status_id', 1)->orderby('customer.cutomer_name', 'ASC')->get();

		$data['Location'] = Store::where('store_status', 'ACTIVE')->orderby('store_name', 'ASC')->get();



		$data['Categories'] = category::where('status', 'ACTIVE')->orderby('category_name', 'ASC')->get();

		$data['Accounts'] = Account::where('status', 'ACTIVE')->orderby('account_name', 'ASC')->get();

		$data['Brands'] = Brand::where('status', 'ACTIVE')->orderby('brand_name', 'ASC')->get();

		$data['Currencies'] = Currency::where('status', 'ACTIVE')->where('id', 1)->orderby('currency_name', 'ASC')->get();

		$data['Header'] = PettyCashHeader::
			leftjoin('department', 'petty_cash_header.department_id', '=', 'department.id')
			->leftjoin('sub_department', 'petty_cash_header.sub_department_id', '=', 'sub_department.id')
			->leftjoin('stores', 'petty_cash_header.location_id', '=', 'stores.id')
			->leftjoin('cms_users as requestor', 'petty_cash_header.created_by', '=', 'requestor.id')
			->leftjoin('statuses', 'petty_cash_header.status_id', '=', 'statuses.id')
			->select(
				'department.*',
				'sub_department.*',
				'stores.*',
				'requestor.name as requestorlevel',
				'statuses.*',
				'petty_cash_header.*'
			)
			->where('petty_cash_header.id', $id)->first();

		$data['Body'] = PettyCashBody::
			leftjoin('category', 'petty_cash_body.category_id', '=', 'category.id')
			->select(
				'category.*',
				'petty_cash_body.*'
			)
			->where('petty_cash_body.petty_cash_header_id', $id)
			->where('petty_cash_body.row_deleted', null)
			->get();

		$user_data = Users::where('id', $data['Header']->created_by)->first();

		$data['Departments'] = Department::whereIn('id', explode(",", $user_data->department_id))->where('status', 'ACTIVE')->orderby('department_name', 'ASC')->get();

		$data['SubDepartments'] = SubDepartment::whereIn('id', explode(",", $user_data->sub_department_id))->where('status', 'ACTIVE')->orderby('sub_department_name', 'ASC')->get();


		$data['Interco'] = Interco::where('status', 'ACTIVE')->orderby('interco_name', 'ASC')->get();
		$data['InvoiceType'] = InvoiceType::where('status', 'ACTIVE')->orderby('invoice_type_name', 'ASC')->get();
		$data['PaymentStatus'] = PaymentStatus::where('status', 'ACTIVE')->orderby('payment_status_name', 'ASC')->get();
		$data['VatType'] = VatType::where('status', 'ACTIVE')->orderby('vat_type_name', 'ASC')->get();

		return view("petty-cash.edit_history", $data);

	}




	public function HistoryExport()
	{

		$filename = 'Petty Cash Requests - ' . date("d M Y - h.i.sa");
		$sheetname = 'Petty Cash Requests' . date("d-M-Y");
		ini_set('memory_limit', '512M');
		Excel::create($filename, function ($excel) {
			$excel->sheet('petty-cash-request', function ($sheet) {
				// Set auto size for sheet
				$sheet->setAutoSize(true);
				// $sheet->setColumnFormat(array(
				// 	'E' => '0.00',		//for line value
				// 	'F' => '0.00'		//for total value
				// ));
				// $sheet->setCellValue('B5','=SUM(B2:B4)');


				$reimbursedData = DB::table('petty_cash_header')
					->leftjoin('petty_cash_body', 'petty_cash_header.id', '=', 'petty_cash_body.petty_cash_header_id')
					->leftjoin('department', 'petty_cash_header.department_id', '=', 'department.id')
					->leftjoin('customer', 'petty_cash_header.customer_location_id', '=', 'customer.id')
					->leftjoin('sub_department', 'petty_cash_header.sub_department_id', '=', 'sub_department.id')

					->leftjoin('cms_users as requestor', 'petty_cash_header.created_by', '=', 'requestor.id')
					->leftjoin('statuses', 'petty_cash_header.status_id', '=', 'statuses.id')
					->leftjoin('cms_users as approver', 'petty_cash_header.approved_by', '=', 'approver.id')
					->leftjoin('cms_users as validator', 'petty_cash_header.validated_by', '=', 'validator.id')
					->leftjoin('cms_users as recordedby', 'petty_cash_header.recorded_by', '=', 'recordedby.id')
					->leftjoin('cms_users as paidby', 'petty_cash_header.paid_by', '=', 'paidby.id')
					->leftjoin('category', 'petty_cash_body.category_id', '=', 'category.id')
					->leftjoin('account', 'petty_cash_body.account_id', '=', 'account.id')
					->leftjoin('brand', 'petty_cash_body.brand_id', '=', 'brand.id')
					->leftjoin('currency', 'petty_cash_body.currency_id', '=', 'currency.id')
					->leftjoin('invoice_type', 'petty_cash_body.invoice_type_id', '=', 'invoice_type.id')
					->leftjoin('payment_status', 'petty_cash_body.payment_status_id', '=', 'payment_status.id')
					->leftjoin('vat_type', 'petty_cash_body.vat_type_id', '=', 'vat_type.id')
					->leftjoin('stores', 'petty_cash_body.location_id', '=', 'stores.id')
					->select(
						'department.department_name',
						'customer.*',
						'sub_department.sub_department_name',
						'stores.*',
						'petty_cash_header.requestor_name as requestorlevel',
						'statuses.*',
						'petty_cash_header.*',
						'petty_cash_header.interco_id as interco',
						'approver.name as approverlevel',
						'invoice_type.invoice_type_name',
						'payment_status.payment_status_name',
						'validator.name as validatorlevel',
						'petty_cash_header.created_at as requested_date',
						'petty_cash_header.id as requested_id',
						'recordedby.name as recordedlevel',
						'paidby.name as paidlevel',
						'category.category_name',
						'account.account_name',
						'brand.brand_name',
						'currency.currency_name',
						'petty_cash_body.*',
						'vat_type.vat_type_name'
					);
				if (\Request::get('filter_column')) {

					$filter_column = \Request::get('filter_column');

					$reimbursedData->where(function ($w) use ($filter_column, $fc) {
						foreach ($filter_column as $key => $fc) {

							$value = @$fc['value'];
							$type = @$fc['type'];

							if ($type == 'empty') {
								$w->whereNull($key)->orWhere($key, '');
								continue;
							}

							if ($value == '' || $type == '')
								continue;

							if ($type == 'between')
								continue;

							switch ($type) {
								default:
									if ($key && $type && $value)
										$w->where($key, $type, $value);
									break;
								case 'like':
								case 'not like':
									$value = '%' . $value . '%';
									if ($key && $type && $value)
										$w->where($key, $type, $value);
									break;
								case 'in':
								case 'not in':
									if ($value) {
										$value = explode(',', $value);
										if ($key && $value)
											$w->whereIn($key, $value);
									}
									break;
							}
						}
					});

					foreach ($filter_column as $key => $fc) {
						$value = @$fc['value'];
						$type = @$fc['type'];
						$sorting = @$fc['sorting'];

						if ($sorting != '') {
							if ($key) {
								$reimbursedData->orderby($key, $sorting);
								$filter_is_orderby = true;
							}
						}

						if ($type == 'between') {
							if ($key && $value)
								$reimbursedData->whereBetween($key, $value);
						} else {
							continue;
						}
					}
				}
				if (CRUDBooster::myPrivilegeId() == 4) {
					$reimbursedData->where('petty_cash_body.row_deleted', null)->where('petty_cash_header.approved_by', CRUDBooster::myId())->where('petty_cash_header.deleted_at', null)->orderBy('petty_cash_header.id', 'ASC');
				} else {
					$reimbursedData->where('petty_cash_body.row_deleted', null)->where('petty_cash_header.deleted_at', null)->orderBy('petty_cash_header.id', 'ASC');
				}
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
						$orderRow->paid_date,
						//$orderRow->cutomer_name,				//'CHANNEL',
						//'STORE',
						//$itemStoreCategory->store_category_description,	//'STORE CATEGORY',
						$orderRow->department_name,    //'CATEGORY'
						$orderRow->sub_department_name,


						$orderRow->address,
						$orderRow->tin_number,
						$orderRow->payee,
						$orderRow->vat_amount,


						$orderRow->si_or_number,
						$orderRow->si_or_date,

						$orderRow->particulars,
						$orderRow->brand_name,			// 	'BRAND',

						$orderRow->store_name,

						$orderRow->category_name,					//'UPC CODE',

						$orderRow->account_name,

						//	$orderRow->account_name,
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

						$orderRow->recordedlevel,
						$orderRow->recorded_at,

						$orderRow->paidlevel,
						$orderRow->paid_at,
					);
				}

				$headings = array(
					'REFERENCE NUMBER',
					'PAID DATE',
					//'CUSTOMER/LOCATION NAME',

					'DEPARTMENT NAME',
					'SUB DEPARTMENT NAME',


					'ADDRESS',
					'TIN#',
					'PAYEE',
					'VAT AMOUNT',

					'SI/OR#',
					'SI/OR Date',


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

					'RECORDED BY',
					'RECORDED DATE',


					'TRANSACTED BY',
					'TRANSACTED DATE',

				);

				$sheet->fromArray($orderItems, null, 'A1', false, false);
				$sheet->prependRow(1, $headings);
				$sheet->row(1, function ($row) {
					$row->setBackground('#FFFF00');
					$row->setAlignment('center');
				});

				$sheet->cell('S' . 1 . ':' . 'Z' . 1, function ($row) {
					$row->setBackground('#6998a3');
					$row->setAlignment('center');
				});

				$sheet->cell('AA' . 1 . ':' . 'AA' . 1, function ($row) {
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