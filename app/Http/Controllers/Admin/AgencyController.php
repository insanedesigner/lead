<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\AgencyModel;
use App\Models\Common\LeadTypeModel;
use App\Models\Users\UserInfoModel;
use App\Models\Users\UserModel;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Crypt;
use App\Mail\WelcomeEmails;

//Models
use App\Models\Auth\LoginModel;
use App\Models\Users\UserTypeModel;
use App\Models\Common\UrlModel;
use App\Models\Common\BusinessKeyDetailsModel;
use App\Models\Common\Streams\StreamsModel;
use App\Models\Common\GalleryModel;
use App\Models\Common\Courses\CategoryModel;
use App\Models\Common\Courses\CoursesModel;
use App\Models\Common\MapUserAgencyModel;

//Utilities
use App\Classes\MessageUtilities;
use App\Classes\DBUtilities;
use App\Classes\FileUploadUtilities;
use App\Classes\AuditUtilities;
use App\Classes\ModelUtilities;

class AgencyController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    //Starts: Dashboard Management Section
    //-----------------------------------------------------------------------------
    public function showAddAgency(Request $request){

        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $status     =   BusinessKeyDetailsModel::select('id','key_value')->where('business_key','=','ED')->pluck('key_value')->toArray();


        if(isset($request->id_agency)){
            $agencyData =   AgencyModel::where('id_agency','=',$request->id_agency)->first();

            if(!empty($agencyData)){

                $paramData  =   [
                    'idAgency'      =>  $agencyData->id_agency,
                    'agencyName'    =>  $agencyData->agency_name,
                    'points'        =>  $agencyData->points,
                    'contactPerson' =>  $agencyData->contact_person,
                    'email'         =>  $agencyData->email,
                    'phone'         =>  $agencyData->phone,
                    'website'       =>  $agencyData->website,
                    'currentStatus' =>  $agencyData->status,
                    'remarks'       =>  $agencyData->remarks
                ];


            }
            else{
                $paramData  =   [
                    'idAgency'      =>  "",
                    'agencyName'    =>  "",
                    'points'        =>  0,
                    'contactPerson' =>  "",
                    'email'         =>  "",
                    'phone'         =>  "",
                    'website'       =>  "",
                    'currentStatus' =>  0,
                    'remarks'       =>  ""
                ];
            }

        }
        else{

            $paramData  =   [
                'idAgency'      =>  "",
                'agencyName'    =>  "",
                'points'        =>  0,
                'contactPerson' =>  "",
                'email'         =>  "",
                'phone'         =>  "",
                'website'       =>  "",
                'currentStatus' =>  0,
                'remarks'       =>  ""
            ];
        }

        $paramArray         =   [
            'pageBase'     =>   'Home',
            'pageTitle'    =>   'Add Agency',
            'browserTitle' =>   'Agency Management',
            'roleKey'      =>   $roleKey,
            'idRole'       =>   $idRole,
            'status'       =>   $status,
            'urlData'      =>   "admin/add_agency",
            'data'         =>   $paramData,
            'userData'     =>   $userData,
            'screenData'   =>   $screenData,
            'idScreen'     =>   2
        ];



        return view('admin.agency.add',$paramArray);




    }

    public function showManageAgency(Request $request){

        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $status         =   BusinessKeyDetailsModel::select('id','key_value')->where('business_key','=','ED')->pluck('key_value')->toArray();
        $fullData       =   AgencyModel::get();
        $activeData     =   AgencyModel::where('status','=',0)->get();
        $inactiveData   =   AgencyModel::where('status','=',1)->get();


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
            'pageTitle'         =>   'Manage Agency',
            'browserTitle'      =>   'Agency Management',
            'roleKey'           =>   $roleKey,
            'idRole'            =>   $idRole,
            'status'            =>   $status,
            'urlData'           =>   "admin/manage_agency",
            'userData'          =>   $userData,
            'screenData'        =>   $screenData,
            'screenDataArray'   =>   $screenDataArray,
            'fullData'          =>   $fullData,
            'activeData'        =>   $activeData,
            'inactiveData'      =>   $inactiveData,
            'idScreen'          =>   2
        ];



        return view('admin.agency.manage',$paramArray);




    }

    public function handleAddAgency(Request $request){
        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $agencyName     =   ucwords($request->name);
        $points         =   $request->points;
        $contactPerson  =   $request->contact_person;
        $email          =   $request->email;
        $phone          =   $request->phone;
        $status         =   $request->status;
        $website        =   $request->website;
        $remarks        =   $request->remarks;


        $successSaveMsg     =   MessageUtilities::dataSaveSuccessMessage();
        $errorSaveMsg       =   MessageUtilities::dataSaveFailedMessage();
        $successUpdateMsg   =   MessageUtilities::dataUpdateSuccessMessage();
        $errorUpdateMsg     =   MessageUtilities::dataUpdateFailedMessage();
        $nothingUpdateMsg   =   MessageUtilities::nothingToUpdate();



        if(!empty($agencyName)){

            if(isset($request->id_agency_hidden)){
                $paramArray =   [
                    'agency_name'       =>  $agencyName,
                    'points'            =>  $points,
                    'contact_person'    =>  ucwords($contactPerson),
                    'email'             =>  $email,
                    'phone'             =>  $phone,
                    'status'            =>  $status,
                    'website'           =>  $website,
                    'remarks'           =>  $remarks,
                    'edited_by'         =>  $idUser,
                    'edited_date'       =>  date('Y-m-d H:i:s')
                ];


                $data = AgencyModel::where('id_agency','=',$request->id_agency_hidden)->update($paramArray);

                if($data){
                    return Redirect::route('addAgency')->with($successUpdateMsg)->withInput();
                }
                else{
                    return Redirect::route('addAgency')->with($nothingUpdateMsg)->withInput();
                }


            }
            else{
                $agencyExistCheck   =   AgencyModel::where('agency_name','=',$agencyName)->first();



                if(!empty($agencyExistCheck)){


                    $error =   MessageUtilities::alreadyExistMessages('Agency Name');
                    return Redirect::route('addAgency')->with($error)->withInput();
                }
                else{

                    $paramArray =   [
                        'agency_name'       =>  $agencyName,
                        'points'            =>  $points,
                        'contact_person'    =>  ucwords($contactPerson),
                        'email'             =>  $email,
                        'phone'             =>  $phone,
                        'status'            =>  $status,
                        'website'           =>  $website,
                        'remarks'           =>  $remarks,
                        'created_by'        =>  $idUser,
                        'created_date'      =>  date('Y-m-d H:i:s')
                    ];

                    $lastInsertId   =   AgencyModel::insertGetId($paramArray);

                    if(!empty($lastInsertId)){
                        return Redirect::route('addAgency')->with($successSaveMsg)->withInput();
                    }
                    else{
                        return Redirect::route('addAgency')->with($errorSaveMsg)->withInput();
                    }
                }
            }




        }
        else{
            $error =   MessageUtilities::emptyFiledsMessage('Agency Name');
            return Redirect::route('addAgency')->with($error)->withInput();
        }

    }

    public function showAddLeadType(Request $request){

        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();



        if(isset($request->id_lead_hidden)){
            $leadTypeData =   LeadTypeModel::where('id_lead_type','=',$request->id_lead_hidden)->first();

            if(!empty($leadTypeData)){

                $paramData  =   [
                    'leadTypeName'    =>  $leadTypeData->lead_type_name,
                    'costPerLead'     =>  $leadTypeData->cost_per_lead,
                ];


            }
            else{
                $paramData  =   [
                    'leadTypeName'    =>    "",
                    'costPerLead'     =>    ""
                ];
            }

        }
        else{

            $paramData  =   [
                'leadTypeName'    =>    "",
                'costPerLead'     =>    ""
            ];
        }

        $paramArray         =   [
            'pageBase'     =>   'Home',
            'pageTitle'    =>   'Add Lead Type',
            'browserTitle' =>   'Lead Type Management',
            'roleKey'      =>   $roleKey,
            'idRole'       =>   $idRole,
            'urlData'      =>   "admin/add_leadtype",
            'data'         =>   $paramData,
            'userData'     =>   $userData,
            'screenData'   =>   $screenData,
            'idScreen'     =>   3
        ];



        return view('admin.leadtype.add',$paramArray);




    }

    public function handleAddLeadType(Request $request){
        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $leadType     =   ucwords($request->name);
        $cost         =   $request->cost_per_lead;

        $successSaveMsg     =   MessageUtilities::dataSaveSuccessMessage();
        $errorSaveMsg       =   MessageUtilities::dataSaveFailedMessage();
        $successUpdateMsg   =   MessageUtilities::dataUpdateSuccessMessage();
        $errorUpdateMsg     =   MessageUtilities::dataUpdateFailedMessage();
        $nothingUpdateMsg   =   MessageUtilities::nothingToUpdate();



        if(!empty($leadType)){

            if(isset($request->id_lead_hidden)){
                $paramArray =   [
                    'lead_type_name'    =>  ucwords($leadType),
                    'cost_per_lead'     =>  $cost,
                    'edited_by'         =>  $idUser,
                    'edited_date'       =>  date('Y-m-d H:i:s')
                ];


                $data = LeadTypeModel::where('id_lead_type','=',$request->id_lead_hidden)->update($paramArray);

                if($data){
                    return Redirect::route('addLeadType')->with($successUpdateMsg)->withInput();
                }
                else{
                    return Redirect::route('addLeadType')->with($nothingUpdateMsg)->withInput();
                }


            }
            else{
                $leadTypeExist   =   LeadTypeModel::where('lead_type_name','=',$leadType)->first();



                if(!empty($leadTypeExist)){


                    $error =   MessageUtilities::alreadyExistMessages('Lead Type Name');
                    return Redirect::route('addLeadType')->with($error)->withInput();
                }
                else{

                    $paramArray =   [
                        'lead_type_name'    =>  ucwords($leadType),
                        'cost_per_lead'     =>  $cost,
                        'created_by'        =>  $idUser,
                        'created_date'      =>  date('Y-m-d H:i:s')
                    ];

                    $lastInsertId   =   LeadTypeModel::insertGetId($paramArray);

                    if(!empty($lastInsertId)){
                        return Redirect::route('addLeadType')->with($successSaveMsg)->withInput();
                    }
                    else{
                        return Redirect::route('addLeadType')->with($errorSaveMsg)->withInput();
                    }
                }
            }




        }
        else{
            $error =   MessageUtilities::emptyFiledsMessage('Lead Type Name');
            return Redirect::route('addLeadType')->with($error)->withInput();
        }

    }

    public function showManageLeadType(Request $request){

        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $fullData       =   LeadTypeModel::get();



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
            'pageTitle'         =>   'Manage Lead Type',
            'browserTitle'      =>   'Lead Type Management',
            'roleKey'           =>   $roleKey,
            'idRole'            =>   $idRole,
            'urlData'           =>   "admin/manage_leadtype",
            'userData'          =>   $userData,
            'screenData'        =>   $screenData,
            'screenDataArray'   =>   $screenDataArray,
            'fullData'          =>   $fullData,
            'idScreen'          =>   3
        ];





        return view('admin.leadtype.manage',$paramArray);




    }


    //Ajax Request Section
    public function handleAgencyStatusChange(Request $request){

        $idUser     =   Session::get('users.idUser')[0];
        $id         =   $request->id;
        $status     =   $request->status;

        if(isset($id)){
            switch($status){
                case 0:
                    $dataArray  =   ['status'=>1];
                    AgencyModel::where('id_agency','=',$id)->update($dataArray);

                    break;
                case 1:
                    $dataArray  =   ['status'=>0];
                    AgencyModel::where('id_agency','=',$id)->update($dataArray);

                    break;

            }

            return json_encode("success");
        }
        else{
            return json_encode("invalid_user");
        }
    }

    public function handleEmailCheck(Request $request){
        $email  =   $request->email;

        if(!empty($email)){
            $checkUserExist =   UserInfoModel::where('email','=',$email)->first();

            if(!empty($checkUserExist)){
                $msgString  =   "user_exist";
                return json_encode(['status'=>$msgString,'idUserInfo'=>$checkUserExist['id_user_info']]);
            }
            else{
                $msgString  =   "user_empty";
                return json_encode(['status'=>$msgString]);
            }
        }
        else{
            $msgString  =   "invalid_email";
            return json_encode(['status'=>$msgString]);
        }

    }

    public function mapUserAgency(Request $request){
        $email      =   $request->email;
        $idAgency   =   $request->id_agency;

        if(!empty($email)){
            $userExist  =   UserInfoModel::where('email','=',$email)->first();

            if(!empty($userExist)){
                $paramArray =   [
                    'id_user_info'  => $userExist->id_user_info,
                    'id_agency'     =>  $idAgency,
                    'created_date'  =>  date('Y-m-d H:i:s')
                ];

                $mappingExist   =   MapUserAgencyModel::where('id_user_info','=',$userExist->id_user_info)->where('id_agency','=',$idAgency)->first();

                if(empty($mappingExist)){
                    MapUserAgencyModel::insert($paramArray);

                    $userCredExist  =   UserModel::where('id_user_info','=',$userExist->id_user_info)->where('username','=',$email)->first();

                    if(empty($userCredExist['password'])){
                        $paramArray =   ['password' =>  Hash::make(str_random(8))];
                        UserModel::where('id_user_info','=',$userExist->id_user_info)->where('username','=',$email)->update($paramArray);
                        $msgString  =   ['status' => 'success','msg'=>$email.' successfully added to this agency. ','username'=>$email,'password'=>str_random(8)];
                        return json_encode($msgString);
                    }
                    else{
                        $msgString  =   ['status' => 'success', 'msg'=>$email.' successfully added to this agency.'];
                        return json_encode($msgString);
                    }



                    /*$comment    =   "Hai";
                    $toEmail = "vyshakhps1988@gmail.com";
                    Mail::to($toEmail)->send(new WelcomeEmails($comment));*/


                    $msgString  =   ['status' => 'success', 'username'=>$email,'password'=>str_random(8)];
                    return json_encode($msgString);

                }
                else{
                    $msgString  =   ['status' => 'error', 'msg'=>"User already exist in this agency"];
                    return json_encode($msgString);
                }


            }

            $msgString  =   ['status' => 'success', 'msg'=>'User successfully assigned to this agency'];
            return json_encode($msgString);


        }
        else{
            $msgString  =   ['status'=>'error','msg'=>'Invalid User'];
            return json_encode($msgString);
        }


    }

}
