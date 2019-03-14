<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\AgencyModel;
use App\Models\Common\MapUserAgencyModel;
use App\Models\Users\UserInfoModel;
use App\Models\Users\UserModel;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Crypt;

//Models
use App\Models\Auth\LoginModel;
use App\Models\Users\UserTypeModel;
use App\Models\Common\UrlModel;
use App\Models\Common\BusinessKeyDetailsModel;
use App\Models\Common\Streams\StreamsModel;
use App\Models\Common\GalleryModel;
use App\Models\Common\Courses\CategoryModel;
use App\Models\Common\Courses\CoursesModel;



//Utilities
use App\Classes\MessageUtilities;
use App\Classes\DBUtilities;
use App\Classes\FileUploadUtilities;
use App\Classes\AuditUtilities;

class UserController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }


    public function showAddUser(Request $request){

        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();
        $gender     =   DBUtilities::genderList();
        $countries  =   DBUtilities::countryList();
        $states     =   DBUtilities::stateList();
        $cities     =   DBUtilities::cityList();
        $status     =   DBUtilities::status();
        $userType   =   DBUtilities::userTypes();



        if(isset($request->id_user)){
            $userInfo   =   UserInfoModel::where('id_user_info','=',$request->id_user)->first();

            if(!empty($userInfo)){

                $paramData  =   [
                    'id_user_info'  =>  $request->id_user,
                    'first_name'    =>  $userInfo->first_name,
                    'last_name'     =>  $userInfo->last_name,
                    'email'         =>  $userInfo->email,
                    'phone'         =>  $userInfo->phone,
                    'gender'        =>  $userInfo->gender,
                    'status'        =>  $userInfo->status,
                    'country'       =>  $userInfo->country,
                    'state'         =>  $userInfo->state,
                    'city'          =>  $userInfo->city,
                    'user_type'     =>  $userInfo->id_user_type,
                ];
            }
            else{
                $paramData  =   [
                    'id_user_info'  =>  "",
                    'first_name'    =>  "",
                    'last_name'     =>  "",
                    'email'         =>  "",
                    'phone'         =>  "",
                    'gender'        =>  "",
                    'status'        =>  "",
                    'country'       =>  "",
                    'state'         =>  "",
                    'city'          =>  "",
                    'user_type'     =>  3,
                ];
            }
        }
        else{
            $paramData  =   [
                'id_user_info'  =>  "",
                'first_name'    =>  "",
                'last_name'     =>  "",
                'email'         =>  "",
                'phone'         =>  "",
                'gender'        =>  "",
                'status'        =>  "",
                'country'       =>  "",
                'state'         =>  "",
                'city'          =>  "",
                'user_type'     =>  3,
            ];
        }





        $paramArray         =   [
            'pageBase'     =>   'Home',
            'pageTitle'    =>   'Add User',
            'browserTitle' =>   'User Management',
            'roleKey'      =>   $roleKey,
            'idRole'       =>   $idRole,
            'urlData'      =>   "admin/add_user",
            'userData'     =>   $userData,
            'userType'     =>   $userType,
            'gender'       =>   $gender,
            'status'       =>   $status,
            'countries'    =>   $countries,
            'states'       =>   $states,
            'cities'       =>   $cities,
            'data'         =>   $paramData,
            'screenData'   =>   $screenData,
            'idScreen'     =>   5
        ];

        //dd($paramArray);

        return view('admin.user.add',$paramArray);
    }

    public function handleAddUser(Request $request){


        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();


        $firstName  =   $request->first_name;
        $lastName   =   $request->last_name;
        $password   =   $request->password;
        $cPassword  =   $request->cpassword;
        $email      =   $request->email;
        $phone      =   $request->phone;
        $gender     =   $request->gender;
        $country    =   $request->country;
        $state      =   $request->state;
        $city       =   $request->city;
        $status     =   $request->status;
        $userType   =   $request->user_type;



        $successSaveMsg     =   MessageUtilities::dataSaveSuccessMessage();
        $errorSaveMsg       =   MessageUtilities::dataSaveFailedMessage();
        $successUpdateMsg   =   MessageUtilities::dataUpdateSuccessMessage();
        $errorUpdateMsg     =   MessageUtilities::dataUpdateFailedMessage();
        $nothingUpdateMsg   =   MessageUtilities::nothingToUpdate();



        if(!empty($firstName) && !empty($email) && !empty($phone)) {

            if(!empty($request->id_user_info)){

                $userExist  =   UserInfoModel::where('id_user_info','=',$request->id_user_info)->first();

                if(!empty($userExist)) {


                        $paramArray = [
                            'id_user_type'  =>  $userType,
                            'id_user_role'  =>  2,
                           /* 'id_agency'     =>  $agency,*/
                            'first_name'    =>  ucwords($firstName),
                            'last_name'     =>  ucwords($lastName),
                            'gender'        =>  $gender,
                            'email'         =>  $email,
                            'phone'         =>  $phone,
                            'country'       =>  $country,
                            'state'         =>  $state,
                            'city'          =>  $city,
                            'status'        =>  $status,
                            'id_user_type'  =>  $userType,
                            'edited_by'     =>  $idUser,
                            'edited_date'   =>  date('Y-m-d H:i:s')
                        ];


                        UserInfoModel::where('id_user_info','=',$request->id_user_info)->update($paramArray);

                        if(!empty($password) && !empty($cPassword)){
                            $password   =   $request->password;

                            $param  =   ['username'=>$email, 'password' => Hash::make($password)];

                            UserInfoModel::where('id_user_info','=',$request->id)->update($param);
                        }
                        else{
                            $password   =   $userExist['password'];
                        }



                }

                return Redirect::route('addUser')->withInput()->with($successUpdateMsg);

            }
            else {

                $emailExistCheck = UserInfoModel::where('email', '=', $email)->first();

                if (empty($emailExistCheck)) {
                    if ($password == $cPassword) {
                        $paramArray = [
                            'id_user_type'  =>  $userType,
                            'id_user_role'  =>  2,
                            'first_name'    =>  ucwords($firstName),
                            'last_name'     =>  ucwords($lastName),
                            'gender'        =>  $gender,
                            'email'         =>  $email,
                            'phone'         =>  $phone,
                            'country'       =>  $country,
                            'state'         =>  $state,
                            'city'          =>  $city,
                            'status'        =>  $status,
                            'id_user_type'  =>  $userType,
                            'created_by'    =>  $idUser,
                            'created_date'  =>  date('Y-m-d H:i:s')
                        ];

                        $data = UserInfoModel::insertGetId($paramArray);

                        if ($data) {
                            $userData = [
                                'username' => $email,
                                'password' => Hash::make($password),
                                'id_user_info' => $data,

                            ];
                            $userDataSave = UserModel::insert($userData);

                            if ($userDataSave) {

                                if(isset($request->agency)){
                                    //MapUserAgencyModel::insert('id_user_info','=',)
                                }


                                return Redirect::route('addUser')->with($successSaveMsg)->withInput();
                            } else {
                                return Redirect::route('addUser')->with($errorSaveMsg)->withInput();
                            }
                        } else {
                            return Redirect::route('addUser')->with($errorSaveMsg)->withInput();
                        }
                    } else {
                        $msgString = MessageUtilities::passwordAndConfirmPasswordNotMatch();
                        return Redirect::route('addUser')->withInput()->with($msgString);
                    }
                } else {
                    $msgString = MessageUtilities::alreadyExistMessages($email);
                    return Redirect::route('addUser')->withInput()->with($msgString);
                }
            }




        }

        else{
                if(empty($firstName)){
                    $msgString  =   MessageUtilities::emptyFiledsMessage('First Name');
                }
                elseif(empty($email)){
                    $msgString  =   MessageUtilities::emptyFiledsMessage('Email');
                }
                elseif(empty($phone)){
                    $msgString  =   MessageUtilities::emptyFiledsMessage('Phone');
                }
                else{
                    $msgString  =   "";
                }

                return Redirect::route('addUser')->withInput()->with($msgString);

            }










    }

    public function showManageUser(Request $request){
        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $fullData       =   UserModel::leftJoin('user_info As ui','user.id_user_info','=','ui.id_user_info')
            ->select('ui.*')
            ->get();





        $screenDataArray    =   [];
        if(!empty($screenData)){
            foreach($screenData as $index=>$val){
                $idScreen   =   $val['id_user_screen'];
                array_push($screenDataArray, $idScreen);
            }
        }



        //dd($screenDataArray);


        $paramArray         =   [
            'pageBase'          =>   'Home',
            'pageTitle'         =>   'Manage User',
            'browserTitle'      =>   'User Management',
            'roleKey'           =>   $roleKey,
            'idRole'            =>   $idRole,
            'urlData'           =>   "admin/manage_user",
            'userData'          =>   $userData,
            'screenData'        =>   $screenData,
            'screenDataArray'   =>   $screenDataArray,
            'fullData'          =>   $fullData,
            'idScreen'          =>   5
        ];

        return view('admin.user.manage',$paramArray);
    }


    //Ajax Requests
    public function loadUser(Request $request){

        $data       =   UserModel::leftJoin('user_info As ui','user.id_user_info','=','ui.id_user_info')
            ->select('ui.*')
            ->get();


            $jsonData = array(
                "draw"            => intval( $_REQUEST['draw'] ),
                "recordsTotal"    => count($data),
                "recordsFiltered" => 5,
                "data"            => $data
            );


            dd($jsonData);

            return json_encode($jsonData);

    }

    public function handleUserStatusChange(Request $request){

        $id         =   $request->id;
        $status     =   $request->status;

        if(isset($id)){
            switch($status){
                case 0:
                    $dataArray  =   ['status'=>1];
                    UserInfoModel::where('id_user_info','=',$id)->update($dataArray);

                    break;
                case 1:
                    $dataArray  =   ['status'=>0];
                    UserInfoModel::where('id_user_info','=',$id)->update($dataArray);

                    break;

            }

            return json_encode("success");
        }
        else{
            return json_encode("invalid_user");
        }
    }

    public function handleAddUserFromAgency(Request $request){
        $idUser =   Session::get('users.idUser')[0];
        $email  =   $request->email;
        $name   =   $request->name;
        $phone  =   $request->phone;



        if(!empty($email) && !empty($name)){

            $userExistCheck =   UserInfoModel::where('email','=',$email)->first();

            if(!empty($userExistCheck)){
                $msgString  =   [
                    'status'    =>  'error',
                    'msg'       =>  'User already exists',
                    'username'  =>  '',
                    'password'  =>  ''
                ];
                return json_encode($msgString);
            }
            else{
                $paramArray =   [
                    'email'         =>  $email,
                    'first_name'    =>  $name,
                    'phone'         =>  $phone,
                    'id_user_type'  =>  3,
                    'id_user_role'  =>  2,
                    'created_by'    =>  $idUser,
                    'created_date'  =>  date('Y-m-d H:i:s')
                ];

                $userInfoSave   =   UserInfoModel::insertGetId($paramArray);

                if(!empty($userInfoSave)){
                    $dataArray  =   [
                        'id_user_info'  =>  $userInfoSave,
                        'username'      =>  $email,
                        'password'      =>  Hash::make(str_random(8)),
                    ];

                    if(UserModel::insert($dataArray)){
                        $msgString = [
                            'status'    =>  'success',
                            'msg'       =>  'User added successfully. ',
                            'username'  =>  $email,
                            'password'  =>  str_random(8)
                        ];

                        return json_encode($msgString);
                    }
                    else{
                        $msgString  =   ['status'   =>  'error','msg'=>'Something went wrong'];
                        return json_encode($msgString);
                    }

                    /*$emailParam =   ['name'=>$name,'username'=>$email, 'password'=>str_random(8)];

                    if(UserModel::insert($dataArray)){
                        Mail::send('emails.welcomeuser',$emailParam, function ($message) {
                            $message->from('vyshakh@spiderworks.in','Company Name');
                            $message->to('vyshakh@spiderworks.in ');
                            $message->subject('Contact form submitted on domainname.com ');
                        });

                        $msgString  =   ['status'=>'success','msg'=>'User added successfully'];

                        return json_encode($msgString);
                    }*/
                }
                else{
                    $msgString  =   ['status'   =>  'error','msg'=>'Something went wrong'];
                    return json_encode($msgString);
                }

            }




        }
        else{
            $msgString  =   ['status'=>'error','msg'=>'Please check the empty fields'];
            return json_encode($msgString);
        }


    }

    public function showAgencySelectionPage(Request $request){
        $idUser =   Session::get('users.idUser')[0];

        echo $idUser;
    }


}
