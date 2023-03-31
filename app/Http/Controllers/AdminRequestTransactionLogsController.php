<?php

namespace App\Http\Controllers;

use Session;
use Request;
use DB;
use CRUDBooster;
use Excel;

class AdminRequestTransactionLogsController extends \crocodicstudio\crudbooster\controllers\CBController
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
		$this->button_edit = true;
		$this->button_delete = true;
		$this->button_detail = true;
		$this->button_show = true;
		$this->button_filter = true;
		$this->button_import = false;
		$this->button_export = false;
		$this->table = "request_transaction_logs";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		$this->col[] = ["label" => "Reference Number", "name" => "reference_number"];
		$this->col[] = ["label" => "Invoice Date", "name" => "invoice_date"];
		$this->col[] = ["label" => "Created By", "name" => "created_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Created Date", "name" => "created_date"];
		$this->col[] = ["label" => "Edited Date", "name" => "edited_date"];
		$this->col[] = ["label" => "Approved By", "name" => "approved_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Approved Date", "name" => "approved_date"];
		$this->col[] = ["label" => "Rejected By", "name" => "rejected_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Rejected Date", "name" => "rejected_date"];
		$this->col[] = ["label" => "Received By", "name" => "received_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Received Date", "name" => "received_date"];
		$this->col[] = ["label" => "Processed By", "name" => "processed_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Processed Date", "name" => "processed_date"];
		$this->col[] = ["label" => "Reimbursed By", "name" => "reimbursed_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Reimbursed Date", "name" => "reimbursed_date"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ['label' => 'Reference Number', 'name' => 'reference_number', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Invoice Date', 'name' => 'invoice_date', 'type' => 'date', 'validation' => 'required|date', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Created By', 'name' => 'created_by', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Created Date', 'name' => 'created_date', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Approved By', 'name' => 'approved_by', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Approved Date', 'name' => 'approved_date', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Rejected By', 'name' => 'rejected_by', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Rejected Date', 'name' => 'rejected_date', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Received By', 'name' => 'received_by', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Received Date', 'name' => 'received_date', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Processed By', 'name' => 'processed_by', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Processed Date', 'name' => 'processed_date', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Reimbursed By', 'name' => 'reimbursed_by', 'type' => 'number', 'validation' => 'required|integer|min:0', 'width' => 'col-sm-10'];
		$this->form[] = ['label' => 'Reimbursed Date', 'name' => 'reimbursed_date', 'type' => 'datetime', 'validation' => 'required|date_format:Y-m-d H:i:s', 'width' => 'col-sm-10'];
		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ["label"=>"Reference Number","name"=>"reference_number","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Invoice Date","name"=>"invoice_date","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
		//$this->form[] = ["label"=>"Created By","name"=>"created_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Created Date","name"=>"created_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
		//$this->form[] = ["label"=>"Approved By","name"=>"approved_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Approved Date","name"=>"approved_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
		//$this->form[] = ["label"=>"Rejected By","name"=>"rejected_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Rejected Date","name"=>"rejected_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
		//$this->form[] = ["label"=>"Received By","name"=>"received_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Received Date","name"=>"received_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
		//$this->form[] = ["label"=>"Processed By","name"=>"processed_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Processed Date","name"=>"processed_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
		//$this->form[] = ["label"=>"Reimbursed By","name"=>"reimbursed_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
		//$this->form[] = ["label"=>"Reimbursed Date","name"=>"reimbursed_date","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
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
		if (CRUDBooster::getCurrentMethod() == 'getIndex') {
			$this->index_button[] = [
				"title" => "Export",
				"label" => "Export Transactions Logs",
				"icon" => "fa fa-download", "url" => CRUDBooster::adminpath('export-transaction-logs') . '?' . urldecode(http_build_query(@$_GET))
			];
			
			$this->index_button[] = [
				"title" => "Export",
				"label" => "Export Filtered Transactions Logs",
				"icon" => "fa fa-download", "url" => CRUDBooster::adminpath('export-filtered-transaction-logs') . '?' . urldecode(http_build_query(@$_GET))
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
	public function transactionLogsExport()
	{

		$filename = 'Request Transactions Logs - ' . date("d M Y - h.i.sa");
		$sheetname = 'Request Transactions Logs' . date("d-M-Y");

		Excel::create($filename, function ($excel) {
			$excel->sheet('request-transactions-logs', function ($sheet) {
				// Set auto size for sheet
				$sheet->setAutoSize(true);
				// $sheet->setColumnFormat(array(
				// 	'E' => '0.00',		//for line value
				// 	'F' => '0.00'		//for total value
				// ));
				// $sheet->setCellValue('B5','=SUM(B2:B4)');


				$reimbursedData = DB::table('request_transaction_logs')
					->join('cms_users AS createdby', 'request_transaction_logs.created_by', '=', 'createdby.id')
					->leftjoin('cms_users AS appby', 'request_transaction_logs.approved_by', '=', 'appby.id')
					->leftjoin('cms_users AS rejby', 'request_transaction_logs.rejected_by', '=', 'rejby.id')
					->leftjoin('cms_users AS recby', 'request_transaction_logs.received_by', '=', 'recby.id')
					->leftjoin('cms_users AS procby', 'request_transaction_logs.processed_by', '=', 'procby.id')
					->leftjoin('cms_users AS reimby', 'request_transaction_logs.reimbursed_by', '=', 'reimby.id')
					->select(
						'request_transaction_logs.reference_number',
						'request_transaction_logs.invoice_date',
						'createdby.name as created_by',
						'request_transaction_logs.created_date',
						'appby.name as approved_by',
						'request_transaction_logs.approved_date',
						'rejby.name as rejected_by',
						'request_transaction_logs.rejected_date',
						'recby.name as received_by',
						'request_transaction_logs.received_date',
						'procby.name as processed_by',
						'request_transaction_logs.processed_date',
						'reimby.name as reimbursed_by',
						'request_transaction_logs.reimbursed_date',
						'request_transaction_logs.edited_date'
					)->get();


				foreach ($reimbursedData as $orderRow) {
					// $item = Item::where('digits_code', $orderRow->digits_code)->first();
					// $itemBrand = Brand::where('id', $item->brand_id)->first();
					// $itemStoreCategory = StoreCategory::where('id', $item->store_category_id)->first();
					// $itemCategory = Category::where('id', $item->category_id)->first();
					// $itemWarehouseCategory = WarehouseCategory::where('id', $item->warehouse_category_id)->first();

					$orderItems[] = array(
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toDateString(),	//'APPROVED DATE',
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toTimeString(), //'APPROVED TIME',
						$orderRow->reference_number, 				//'REPLENISHMENT REF#',
						$orderRow->invoice_date,				//'CHANNEL',
						$orderRow->created_by,					//'STORE',
						//$itemStoreCategory->store_category_description,	//'STORE CATEGORY',
						$orderRow->created_date,    //'CATEGORY'
						$orderRow->edited_date,
						$orderRow->approved_by,
						$orderRow->approved_date,			// 	'BRAND',
						$orderRow->rejected_by,					//'UPC CODE',
						$orderRow->rejected_date,
						$orderRow->received_by,					//'UPC CODE',
						$orderRow->received_date,			//'ITEM DESCRIPTION',
						$orderRow->processed_by,		//'SKU LEGEND',
						$orderRow->processed_date,		//'ORDERED QTY',
						$orderRow->reimbursed_by,			//'APPROVED QTY',
						$orderRow->reimbursed_date			//'REPLENISHMENT QTY',

					);
				}

				$headings = array(
					'REFERENCE NUMBER',
					'INVOICE DATE',
					'CREATED BY',
					'CREATED DATE',
					'EDITED DATE',
					'APPROVED BY',
					'APPROVED DATE',
					'REJECTED BY',
					'REJECTED DATE',
					'RECEIVED BY',
					'RECEIVED DATE',
					'PROCESSED BY',
					'PROCESSED DATE',
					'REIMBURSED BY',
					'REIMBURSED DATE'

				);

				$sheet->fromArray($orderItems, null, 'A1', false, false);
				$sheet->prependRow(1, $headings);
				$sheet->row(1, function ($row) {
					$row->setBackground('#FFFF00');
					$row->setAlignment('center');
				});
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
	
	public function filteredtransactionLogsExport()
	{

		$filename = 'Request Filtered Transactions Logs - ' . date("d M Y - h.i.sa");
		$sheetname = 'Request Filtered Transactions Logs' . date("d-M-Y");

		Excel::create($filename, function ($excel) {
			$excel->sheet('request-transactions-logs', function ($sheet) {
				// Set auto size for sheet
				$sheet->setAutoSize(true);
				// $sheet->setColumnFormat(array(
				// 	'E' => '0.00',		//for line value
				// 	'F' => '0.00'		//for total value
				// ));
				// $sheet->setCellValue('B5','=SUM(B2:B4)');

                $result = array();

				$reimbursedData = DB::table('request_transaction_logs')
					->join('cms_users', 'request_transaction_logs.created_by', '=', 'cms_users.id')
					->leftjoin('cms_users AS cms_users1', 'request_transaction_logs.approved_by', '=', 'cms_users1.id')
					->leftjoin('cms_users AS cms_users2', 'request_transaction_logs.rejected_by', '=', 'cms_users2.id')
					->leftjoin('cms_users AS cms_users3', 'request_transaction_logs.received_by', '=', 'cms_users3.id')
					->leftjoin('cms_users AS cms_users4', 'request_transaction_logs.processed_by', '=', 'cms_users4.id')
					->leftjoin('cms_users AS cms_users5', 'request_transaction_logs.reimbursed_by', '=', 'cms_users5.id')
					->select(
						'request_transaction_logs.reference_number',
						'request_transaction_logs.invoice_date',
						'cms_users.name as created_by',
						'request_transaction_logs.created_date',
						'cms_users1.name as approved_by',
						'request_transaction_logs.approved_date',
						'cms_users2.name as rejected_by',
						'request_transaction_logs.rejected_date',
						'cms_users3.name as received_by',
						'request_transaction_logs.received_date',
						'cms_users4.name as processed_by',
						'request_transaction_logs.processed_date',
						'cms_users5.name as reimbursed_by',
						'request_transaction_logs.reimbursed_date',
						'request_transaction_logs.edited_date'
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
						$reimbursedData->orderBy('request_transaction_logs.id','ASC');
						$result = $reimbursedData->get();


				foreach ($result as $orderRow) {
					// $item = Item::where('digits_code', $orderRow->digits_code)->first();
					// $itemBrand = Brand::where('id', $item->brand_id)->first();
					// $itemStoreCategory = StoreCategory::where('id', $item->store_category_id)->first();
					// $itemCategory = Category::where('id', $item->category_id)->first();
					// $itemWarehouseCategory = WarehouseCategory::where('id', $item->warehouse_category_id)->first();

					$orderItems[] = array(
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toDateString(),	//'APPROVED DATE',
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toTimeString(), //'APPROVED TIME',
						$orderRow->reference_number, 				//'REPLENISHMENT REF#',
						$orderRow->invoice_date,				//'CHANNEL',
						$orderRow->created_by,					//'STORE',
						//$itemStoreCategory->store_category_description,	//'STORE CATEGORY',
						$orderRow->created_date,    //'CATEGORY'
						$orderRow->edited_date,
						$orderRow->approved_by,
						$orderRow->approved_date,			// 	'BRAND',
						$orderRow->rejected_by,					//'UPC CODE',
						$orderRow->rejected_date,
						$orderRow->received_by,					//'UPC CODE',
						$orderRow->received_date,			//'ITEM DESCRIPTION',
						$orderRow->processed_by,		//'SKU LEGEND',
						$orderRow->processed_date,		//'ORDERED QTY',
						$orderRow->reimbursed_by,			//'APPROVED QTY',
						$orderRow->reimbursed_date			//'REPLENISHMENT QTY',

					);
				}

				$headings = array(
					'REFERENCE NUMBER',
					'INVOICE DATE',
					'CREATED BY',
					'CREATED DATE',
					'EDITED DATE',
					'APPROVED BY',
					'APPROVED DATE',
					'REJECTED BY',
					'REJECTED DATE',
					'RECEIVED BY',
					'RECEIVED DATE',
					'PROCESSED BY',
					'PROCESSED DATE',
					'REIMBURSED BY',
					'REIMBURSED DATE'

				);

				$sheet->fromArray($orderItems, null, 'A1', false, false);
				$sheet->prependRow(1, $headings);
				$sheet->row(1, function ($row) {
					$row->setBackground('#FFFF00');
					$row->setAlignment('center');
				});
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
