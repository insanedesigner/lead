<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Webpatser\Uuid\Uuid;


//Models
use App\Models\Auth\LoginModel;
use App\Models\Users\UserTypeModel;

//Utilities
use App\Classes\MessageUtilities;
use App\Classes\AuditUtilities;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function showLogin(){

        /*$pass   =   Hash::make("admin");
        echo $pass;

        dd();*/

        return view('auth.login');
    }
    public function logout(){
        Session::flush();
        return Redirect::route('login');
    }
    public function handleLogin(Request $request){
        $request->session()->flush();
        $ipaddress = $_SERVER['SERVER_ADDR'];

        if($request->has('username') && $request->has('password')){
            $username   =   $request->username;
            $password   =   $request->password;

            /*$userAuth   =   LoginModel::where('username','=',$username)
                ->leftJoin('users_info As ui','users.id_users_info','=','ui.id_users_info')
                ->leftJoin('user_roles As r','ui.id_roles','=','r.id_roles')
                ->select('users.id_user','users.username','users.password','ui.id_roles','ui.first_name','ui.last_name','r.name As role_name','r.title As role')
                ->first();*/

            $userAuth   =   LoginModel::where('username','=',$username)
                ->select('users.id','users.username','users.password')
                ->first();


            if(!empty($userAuth->username)){

                if(password_verify($password, $userAuth->password )){
                    /*$role   =   $userAuth->role;
                    $idRole =   $userAuth->id_roles;
                    $idUser =   $userAuth->id;
                    Session::put('role',$role);


                    $request->session()->push('users.role', $role);
                    $request->session()->push('users.idRole', $idRole);
                    $request->session()->push('users.idUser', $idUser);

                    switch($role){
                        case 'ad':
                            return Redirect::route('adminDashboard');
                            //return view('admin.dashboard');
                            break;

                        default:

                    }


                    return Redirect::route('adminDashboard');*/


                    $idUser =   $userAuth->id;
                    $request->session()->push('users.idUser', $idUser);

                    //Audit Entry
                    //------------------------------------------------------------------
                    $paramArray =   [
                        'id_user'       =>  $idUser,
                        'audit_event'   =>  'LOGIN',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('adminDashboard');



                }
                else{
                    $message        =   MessageUtilities::loginFailedMessage();
                    $paramArray     =   ['error' => $message];

                    return Redirect::route('login')->with($paramArray);
                }


            }
            else{
                $message        =   MessageUtilities::loginFailedMessage();
                $paramArray     =   ['error' => $message];

                return Redirect::route('login')->with($paramArray);
            }


        }

    }
}
