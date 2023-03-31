<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use Excel;
use CRUDBooster;

class AdminCategoryController extends \crocodicstudio\crudbooster\controllers\CBController
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
		$this->orderby = "category_name,asc";
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
		$this->table = "category";
		# END CONFIGURATION DO NOT REMOVE THIS LINE

		# START COLUMNS DO NOT REMOVE THIS LINE
		$this->col = [];
		//$this->col[] = ["label" => "Category Code", "name" => "category_code"];
		$this->col[] = ["label" => "Category Name", "name" => "category_name"];
		$this->col[] = ["label" => "Status", "name" => "status"];
		$this->col[] = ["label" => "Created By", "name" => "created_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Created At", "name" => "created_at"];
		$this->col[] = ["label" => "Updated By", "name" => "updated_by", "join" => "cms_users,name"];
		$this->col[] = ["label" => "Updated At", "name" => "updated_at"];
		# END COLUMNS DO NOT REMOVE THIS LINE

		# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		//$this->form[] = ['label' => 'Category Code', 'name' => 'category_code', 'type' => 'text', 'validation' => 'required|min:3|max:3', 'width' => 'col-md-5'];
		$this->form[] = ['label' => 'Category Name', 'name' => 'category_name', 'type' => 'text', 'validation' => 'required|min:1|max:255', 'width' => 'col-md-5'];
		//$this->form[] = ['label'=>'Accounting Description','name'=>'accounting_category_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-5','datatable'=>'accounting_category,description'];

		if(CRUDBooster::getCurrentMethod() == 'getEdit' || CRUDBooster::getCurrentMethod() == 'postEditSave' || CRUDBooster::getCurrentMethod() == 'getDetail') {
			$this->form[] = ['label'=>'Status','name'=>'status','type'=>'select','validation'=>'required','width'=>'col-sm-5','dataenum'=>'ACTIVE;INACTIVE'];
		}

		if(CRUDBooster::getCurrentMethod() == 'getDetail'){
			$this->form[] = ["label"=>"Created By","name"=>"created_by",'type'=>'select',"datatable"=>"cms_users,name"];
			$this->form[] = ['label'=>'Created Date','name'=>'created_at', 'type'=>'datetime'];
			$this->form[] = ["label"=>"Updated By","name"=>"updated_by",'type'=>'select',"datatable"=>"cms_users,name"];
			$this->form[] = ['label'=>'Updated Date','name'=>'updated_at', 'type'=>'datetime'];
		}

		# END FORM DO NOT REMOVE THIS LINE

		# OLD START FORM
		//$this->form = [];
		//$this->form[] = ['label'=>'Category Code','name'=>'category_code','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Category Description','name'=>'category_description','type'=>'text','validation'=>'required|min:1|max:255','width'=>'col-sm-10'];
		//$this->form[] = ['label'=>'Status','name'=>'category_status','type'=>'select','validation'=>'required','width'=>'col-sm-10','dataenum'=>'ACTIVE;INACTIVE'];
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
		/*if(CRUDBooster::getCurrentMethod() == 'getIndex') {
		$this->index_button[] = [
			"title" => "Upload Category",
			"label" => "Upload Category",
			"icon" => "fa fa-file-excel-o",
			"url" => CRUDBooster::mainpath('excel-upload')
		];

		$this->index_button[] = [
			"title" => "Export",
			"label" => "Export Category",
			"icon" => "fa fa-download", "url" => CRUDBooster::mainpath('export-category') . '?' . urldecode(http_build_query(@$_GET))
		];
	}*/
		// $this->index_button[] = ['label' => 'Upload Category', 'url'=>CRUDBooster::mainpath('excel-upload'), "icon" => "fa fa-file-excel-o"];


		/* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
		$this->table_row_color = array();
            $this->table_row_color[] = ["condition"=>"[status] == INACTIVE","color"=>"danger"];

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
			$('#category_code, #category_name').keyup(function() {
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
		$postdata['created_by'] = CRUDBooster::myId();
	
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
		$postdata['updated_by'] = CRUDBooster::myId();
	
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

	public function CategoryUpload(Request $request)
	{
		$file = $request->file('import_file');

		$validator = \Validator::make(
			[
				'file' => $file,
				'extension' => strtolower($file->getClientOriginalExtension()),
			],
			[
				'file' => 'required',
				'extension' => 'required|in:csv',
			]
		);

		if ($validator->fails()) {
			CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_uploadskulegend_data_failed"), 'danger');
		}

		if (Input::hasFile('import_file')) {
			$path = Input::file('import_file')->getRealPath();

			$csv = array_map('str_getcsv', file($path));
			$dataExcel = Excel::load($path, function ($reader) {
			})->get();

			$unMatch = [];
			$header = array('CATEGORY CODE', 'CATEGORY DESCRIPTION', 'CATEGORY STATUS');

			for ($i = 0; $i < sizeof($csv[0]); $i++) {
				if (!in_array($csv[0][$i], $header)) {
					$unMatch[] = $csv[0][$i];
				}
			}

			if (!empty($unMatch)) {
				CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_uploadskulegend_data_failed"), 'danger');
			}

			$data = array();

			if (!empty($dataExcel) && $dataExcel->count()) {
				//success counter
				$cnt_success = 0;
				$cnt_fail = 0;

				foreach ($dataExcel as $key => $value) {
					$check_upload = false;

					// $skugends = SKULegend::where('sku_legend_description', $value->sku_legend)->first();

					if ($value->category_code != '') {

						$category_code = strtoupper($value->category_code);//to uppercase
						$category_description = strtoupper($value->category_description);
						$category_status = strtoupper($value->category_status);
						if(strlen($category_code) != 3)
						{
							return redirect('admin/category/excel-upload')->with('message', 'Category code must be 3 letters!!');
						}else{
							$data = [
								'category_code' => $category_code,
								'category_description' => $category_description,
								'category_status' => $category_status,
								'created_by' => CRUDBooster::myId(),
								'created_at' => date('Y-m-d H:i:s'),
							];
							// $categorycode = $value->category_code;
							// $categorydesc = $value->category_description;
							// $categorystats = $value->category_status;
	
							DB::beginTransaction();
	
							try {
	
								// $isItemUpload = DB::table('category')->where('digits_code', intval($value->digits_code))->update($data);
								// 	$insert_into_lines = array();
								// 	for ($i = 0; $i < count($categorycode); $i++) {
								// 		//select categoryid FROM category
								// 		dd($categorycode);
								// 		$insert_into_lines[$i]['category_code'] = $categorycode[$i];
								// 		$insert_into_lines[$i]['category_description'] = $categorydesc[$i];
								// 		// $insert_into_lines[$i]['category_status'] = $categorystats[$i];
								// 		$insert_into_lines[$i]['created_by'] = CRUDBooster::myId();
								// 		$insert_into_lines[$i]['created_at'] = date('Y-m-d H:i:s');
								// 	}
	
								$isItemUpload =	DB::table('category')->insert($data);
	
	
								DB::commit();
							} catch (\Exception $e) {
	
								DB::rollback();
								return redirect('admin/category/excel-upload')->with('message', 'You cannot upload duplicate data!!');
							}
						}

						

						
					}

					if ($isItemUpload) {
						$check_upload = true;
						$cnt_success++;
					} else {
						$check_upload = false;
						$cnt_fail++;
					}
				}

				if ($check_upload) {
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_uploadskulegend_data_success", ['total_row' => count($dataExcel), 'success' => $cnt_success, 'fail' => $cnt_fail]), 'success');
				} else {
					CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_uploadskulegend_data_success", ['total_row' => count($dataExcel), 'success' => $cnt_success, 'fail' => $cnt_fail]), 'success');
				}
			}
		}
	}

	public function uploadCategoryTemplate()
	{
		Excel::create('Category-' . date("Ymd") . '-' . date("h.i.sa"), function ($excel) {
			$excel->sheet('category-upload', function ($sheet) {
				$sheet->row(1, array('CATEGORY CODE', 'CATEGORY DESCRIPTION', 'CATEGORY STATUS'));
				// $sheet->row(2, array('80000001', 'CORE', 'CORE', 'CORE', 'CORE', 'CORE', 'CORE', 'CORE', 'CORE', 'CORE'));
			});
		})->download('csv');
	}

	public function uploadCategory()
	{
		// $this->cbLoader();
		$data['page_title'] = 'Category Upload';

		// $this->cbView("customview.request_uploadexcel", $data);
		return view('customview.request_uploadexcel', $data)->render();
	}

	// public function UploadCategory(Request $request)
	// {
	// 	$file = $request->file('import_file');

	// 		$validator = \Validator::make(
	// 			[
	// 				'file' => $file,
	// 				'extension' => strtolower($file->getClientOriginalExtension()),
	// 			],
	// 			[
	// 				'file' => 'required',
	// 				'extension' => 'required|in:csv',
	// 			]
	// 		);

	// 		if ($validator->fails()) {
	// 			CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_excelorder_data_failed"), 'danger');
	// 		}

	// 		if (Input::hasFile('import_file')) {
	// 			$path = Input::file('import_file')->getRealPath();

	// 			$excel_datas = array();

	// 			$csv = array_map('str_getcsv', file($path));
	// 			$dataExcel = Excel::load($path, function($reader) {
	//             })->get();

	// 			$unMatch = [];
	// 			$header = array('CATEGORY CODE', 'CATEGORY DESCRIPTION', 'CATEGORY STATUS');

	// 			for ($i=0; $i < sizeof($csv[0]); $i++) {
	// 				if (! in_array($csv[0][$i], $header)) {
	// 					$unMatch[] = $csv[0][$i];
	// 				}
	// 			}

	// 			if(!empty($unMatch)) {
	// 				CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_excelorder_data_failed"), 'danger');
	// 			}
	// 			//dd($dataExcel);
	// 			if(!empty($dataExcel) && $dataExcel->count()) {

	// 			    // foreach($dataExcel->toArray() as $row){

	// 				// }
	// 				dd($dataExcel);
	// 				$cnt_success = 0;
	// 			    $cnt_fail = 0;

	// 				foreach ($dataExcel as $key => $value) {

	// 				    $check_upload = false;
	// 				    $skugends = SKULegend::where('sku_legend_description', $value->sku_legend)->first();

	// 				    if($value->digits_code !=''){

	// 				       $data = [
	// 					    'skulegend_id' => $skugends->id,
	// 						'btb_segmentation' => $value->btb,
	// 						'baseus_segmentation' => $value->baseus,
	// 						'dw_segmentation' => $value->dw,
	// 						'omg_segmentation' => $value->omg,
	// 						'online_segmentation' => $value->online,
	// 						'guam_segmentation' => $value->guam,
	// 						'districon_segmentation' => $value->distri_con,
	// 						'distriout_segmentation' => $value->distri_out,
	// 						];

	// 						DB::beginTransaction();

	// 						try {
	// 							$isItemUpload = DB::table('items')->where('digits_code', intval($value->digits_code))->update($data);
	// 							DB::commit();
	// 						} catch (\Exception $e) {
	// 							DB::rollback();
	// 						} 
	// 				    }

	// 					if ($isItemUpload) {
	//                         $check_upload = true;
	//                         $cnt_success++;
	//                     }
	//                     else{
	//                         $check_upload = false;
	//                         $cnt_fail++;
	//                     }
	// 				}

	// 				if($check_upload){
	//                     CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_uploadskulegend_data_success", ['total_row'=>count($dataExcel),'success'=>$cnt_success,'fail'=>$cnt_fail]), 'success');
	//                 }
	//                 else{
	//                     CRUDBooster::redirect(CRUDBooster::mainpath(), trans("crudbooster.alert_uploadskulegend_data_success", ['total_row'=>count($dataExcel),'success'=>$cnt_success,'fail'=>$cnt_fail]), 'success');
	//                 }
	// 			}
	// 		}

	// 		// return $excelorders;


	// }


	public function ExportCategory()
	{
		$filename = 'Export Category - ' . date("d M Y - h.i.sa");
		$sheetname = 'Export Category' . date("d-M-Y");

		Excel::create($filename, function ($excel) {
			$excel->sheet('export-category', function ($sheet) {
				// Set auto size for sheet
				$sheet->setAutoSize(true);
				$sheet->setColumnFormat(array(
					// 'E' => '0.00',		//for line value
					// 'F' => '0.00'		//for total value
				));
				
					$reimbursedData = DB::table('category')
						->leftjoin('accounting_category as ac', 'ac.id', '=', 'category.accounting_category_id')
						->leftjoin('cms_users AS createdby', 'category.created_by', '=', 'createdby.id')
						->leftjoin('cms_users AS updatedby', 'category.updated_by', '=', 'updatedby.id')
						
						->select(
							'category.*',
							'ac.description as accounting_description',
							'createdby.name as created_by',
							'updatedby.name as updated_by'
							
						)
						->orderby('category.category_description', 'ASC')
						->get();

				




				foreach ($reimbursedData as $orderRow) {
					


					$orderItems[] = array(
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toDateString(),	//'APPROVED DATE',
						// is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toTimeString(), //'APPROVED TIME',
						$orderRow->category_code,
						$orderRow->category_description,
						$orderRow->accounting_description, 				//'REPLENISHMENT REF#',
						$orderRow->category_status,				//'CHANNEL',
						$orderRow->created_by,					//'STORE',
						$orderRow->created_at,
						$orderRow->updated_by,
						//$itemStoreCategory->store_category_description,	//'STORE CATEGORY',
						$orderRow->updated_at   //'CATEGORY'
						
					);
				}

				$headings = array(
					'CATEGORY CODE',
					'CATEGORY DESCRIPTION',
					'ACCOUNTING DESCRIPTION',
					'CATEGORY STATUS',
					'CREATED BY',
					'CREATED AT',
					'UPDATED BY',
					'UPDATED AT'
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
}
