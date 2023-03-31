<?php namespace crocodicstudio\crudbooster\controllers;

use CRUDBooster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\ApprovalMatrix;

class AdminController extends CBController
{
    public function __construct() {
        // Register ENUM type
        DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    function getIndex()
    {
        $data = [];
        $data['page_title'] = '<strong>Dashboard</strong>';

        return view('crudbooster::home', $data);
    }

    public function getLockscreen()
    {

        if (! CRUDBooster::myId()) {
            Session::flush();

            return redirect()->route('getLogin')->with('message', trans('crudbooster.alert_session_expired'));
        }

        Session::put('admin_lock', 1);

        return view('crudbooster::lockscreen');
    }

    public function postUnlockScreen()
    {
        $id = CRUDBooster::myId();
        $password = Request::input('password');
        $users = DB::table(config('crudbooster.USER_TABLE'))->where('id', $id)->first();

        if (\Hash::check($password, $users->password)) {
            Session::put('admin_lock', 0);

            return redirect(CRUDBooster::adminPath());
        } else {
            echo "<script>alert('".trans('crudbooster.alert_password_wrong')."');history.go(-1);</script>";
        }
    }

    public function getLogin()
    {

        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }

        return view('crudbooster::login');
    }

    public function postLogin()
    {

        $validator = Validator::make(Request::all(), [
            'email' => 'required|email|exists:'.config('crudbooster.USER_TABLE'),
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            return redirect()->back()->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
        }

        $email = Request::input("email");
        $password = Request::input("password");
        $users = DB::table(config('crudbooster.USER_TABLE'))->where("email", $email)->first();
        
        if (\Hash::check($password, $users->password)) {
            $priv = DB::table("cms_privileges")->where("id", $users->id_cms_privileges)->first();

            $roles = DB::table('cms_privileges_roles')->where('id_cms_privileges', $users->id_cms_privileges)->join('cms_moduls', 'cms_moduls.id', '=', 'id_cms_moduls')->select('cms_moduls.name', 'cms_moduls.path', 'is_visible', 'is_create', 'is_read', 'is_edit', 'is_delete')->get();
            
            if($priv->name == "Approver") {
                // $approvalMatrix = ApprovalMatrix::where('approval_matrices.cms_users_id',  $users->id)->first();
                // $storeList = '(' . $approvalMatrix->store_list . ')';
                //$approvalMatrix = ApprovalMatrix::where('approval_matrices.cms_users_id', $users->id)->get();
				
                $approvalMatrix =  DB::table("cms_users")->where('id',  $users->id)->get();
        
				$storeList_string = '';
				$storeList_string1 = '';
				
				$count=0;
				foreach($approvalMatrix as $matrix){
				    $count++;
				    if($count==1) {
				        $storeList_string = $matrix->approver_department_id;
				        $storeList_string1 = $matrix->approver_sub_department_id;
				    }
				    else {
				        $storeList_string .= ','.$matrix->approver_department_id;
				        $storeList_string1 = $matrix->approver_sub_department_id;
				    }
				}
				$storeList = '(' . $storeList_string . ')';
				$storeList1 = '(' . $storeList_string1 . ')';
				
				
                Session::put('approval_store_ids', $storeList);
                Session::put('approval_sub_ids', $storeList1);
                
            }
            
            $photo = ($users->photo) ? asset($users->photo) : asset('vendor/crudbooster/avatar.jpg');
            Session::put('admin_id', $users->id);
            Session::put('admin_is_superadmin', $priv->is_superadmin);
            Session::put('admin_name', $users->name);

            Session::put('admin_channel_id', $users->channels_id);
            Session::put('admin_group_id', $users->groups_id);
            Session::put('admin_store_id', $users->stores_id);

            Session::put('admin_photo', $photo);
            Session::put('admin_privileges_roles', $roles);
            Session::put("admin_privileges", $users->id_cms_privileges);
            Session::put('admin_privileges_name', $priv->name);
            Session::put('admin_lock', 0);
            Session::put('theme_color', $priv->theme_color);
            Session::put("appname", CRUDBooster::getSetting('appname'));

            // CRUDBooster::insertLog(trans("crudbooster.log_login", ['email' => $users->email, 'ip' => Request::server('REMOTE_ADDR')]));

            // $cb_hook_session = new \App\Http\Controllers\CBHook;
            // $cb_hook_session->afterLogin();
            
            //---added by cris 20200806-------------------
            if($users->status != 'INACTIVE') {
			    
				CRUDBooster::insertLog(trans("crudbooster.log_login",['email'=>$users->email,'ip'=>Request::server('REMOTE_ADDR')]));		
				$cb_hook_session = new \App\Http\Controllers\CBHook;
				$cb_hook_session->afterLogin();
				return redirect(CRUDBooster::adminPath());
			}
			else {
				CRUDBooster::insertLog(trans("crudbooster.try_log_login",['email'=>$users->email,'ip'=>Request::server('REMOTE_ADDR')]));
				Session::flush();
				return redirect()->route('getLogin')->with('message', trans('crudbooster.user_not_exist'));
			}
            //-------------------------------------------

            return redirect(CRUDBooster::adminPath());
        } 
        elseif($users->status == 'INACTIVE') {
			return redirect()->route('getLogin')->with('message', trans('crudbooster.user_not_exist'));
		}
        else {
            return redirect()->route('getLogin')->with('message', trans('crudbooster.alert_password_wrong'));
        }
    }

    public function getForgot()
    {
        if (CRUDBooster::myId()) {
            return redirect(CRUDBooster::adminPath());
        }

        return view('crudbooster::forgot');
    }

    public function postForgot()
    {
        $validator = Validator::make(Request::all(), [
            'email' => 'required|email|exists:'.config('crudbooster.USER_TABLE'),
        ]);

        if ($validator->fails()) {
            $message = $validator->errors()->all();

            return redirect()->back()->with(['message' => implode(', ', $message), 'message_type' => 'danger']);
        }

        $rand_string = str_random(5);
        $password = \Hash::make($rand_string);

        DB::table(config('crudbooster.USER_TABLE'))->where('email', Request::input('email'))->update(['password' => $password]);

        $appname = CRUDBooster::getSetting('appname');
        $user = CRUDBooster::first(config('crudbooster.USER_TABLE'), ['email' => g('email')]);
        $user->password = $rand_string;
        CRUDBooster::sendEmail(['to' => $user->email, 'data' => $user, 'template' => 'forgot_password_backend']);

        CRUDBooster::insertLog(trans("crudbooster.log_forgot", ['email' => g('email'), 'ip' => Request::server('REMOTE_ADDR')]));

        return redirect()->route('getLogin')->with('message', trans("crudbooster.message_forgot_password"));
    }

    public function getLogout()
    {

        $me = CRUDBooster::me();
        CRUDBooster::insertLog(trans("crudbooster.log_logout", ['email' => $me->email]));

        Session::flush();

        return redirect()->route('getLogin')->with('message', trans("crudbooster.message_after_logout"));
    }
}
