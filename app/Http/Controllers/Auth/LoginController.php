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
use App\Classes\DBUtilities;
use App\Classes\MessageUtilities;
use App\Classes\AuditUtilities;

class LoginController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function showLogin(){

       /* $pass   =   Hash::make("admin");
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



            $userAuth   =   LoginModel::where('username','=',$username)
                ->leftJoin('user_info As ui','user.id_user_info','=','ui.id_user_info')
                ->leftJoin('user_role As r','ui.id_user_role','=','r.id_role')
                ->leftJoin('user_type As ut','ut.id_user_type','=','ui.id_user_type')
                ->select('user.id_user','user.username','user.password','ui.id_user_role','ui.id_user_type', 'ui.first_name','ui.last_name','r.role_name','r.role_key','ut.type_name','ut.type_key')
                ->first();



            if(!empty($userAuth->username)){
                /*if (Hash::check($password, $userAuth->password))
                {
                   echo "matches";
                }
                else{
                    echo "not";
                }*/



                if(password_verify($password, $userAuth->password )){


                    //dd("ss");

                    $roleKey        =   $userAuth->role_key;
                    $idRole         =   $userAuth->id_user_role;
                    $idUser         =   $userAuth->id_user;
                    $idUserType     =   $userAuth->id_user_type;
                    $userTypeKey    =   $userAuth->type_key;
                    //Session::put('role',$role);

                    //echo "sss"; dd();



                    $request->session()->push('users.roleKey', $roleKey);
                    $request->session()->push('users.idRole', $idRole);
                    $request->session()->push('users.idUser', $idUser);
                    $request->session()->push('users.idUsersType', $idUserType);
                    $request->session()->push('users.idUserTypeKey', $userTypeKey);



                    switch($userTypeKey){
                        case 'su':
                            return Redirect::route('adminDashboard');
                            //return view('admin.superadmin');
                            break;
                        case 'user':
                            return Redirect::route('showAgencySelectionPage');
                            break;

                        default:

                    }


                    return Redirect::route('adminDashboard');


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
