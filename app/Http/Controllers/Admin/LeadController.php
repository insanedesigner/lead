<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\AgencyModel;
use App\Models\Common\LeadModel;
use App\Models\Common\LeadTypeModel;
use App\Models\Common\MapLeadAgencyModel;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
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
use App\Models\Common\CountriesModel;
use App\Models\Common\StatesModel;
use App\Models\Common\CitiesModel;


//Utilities
use App\Classes\MessageUtilities;
use App\Classes\DBUtilities;
use App\Classes\FileUploadUtilities;
use App\Classes\AuditUtilities;
use App\Classes\ModelUtilities;

class LeadController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
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



        return view('admin.lead.add_lead_type',$paramArray);




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





        return view('admin.lead.manage_lead_type',$paramArray);




    }

    public function showAddLead(Request $request){

        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $leadTypeData   =   LeadTypeModel::select('id_lead_type','lead_type_name')->pluck('lead_type_name','id_lead_type')->toArray();
        $countries      =   CountriesModel::select('id','name')->pluck('name','id')->toArray();
        $states         =   StatesModel::select('id','name')->pluck('name','id')->toArray();
        $cities         =   CitiesModel::select('id','name')->pluck('name','id')->toArray();


        $leadTypeData[0]    =   "Select a Lead Type";
        ksort($leadTypeData);
        $countries[0] =   "Select a country";
        ksort($countries);

        $states[0] =   "Select a state";
        ksort($states);

        $cities[0] =   "Select a city";
        ksort($cities);





        if(isset($request->id_lead_hidden)){
            $leadData =   LeadModel::where('id_lead','=',$request->id_lead_hidden)->first();

            //dd($leadData);


            if(!empty($leadData)){

                $paramData  =   [
                    'leadName'      =>  $leadData->lead_name,
                    'email'         =>  $leadData->email,
                    'phone'         =>  $leadData->phone,
                    'leadType'      =>  $leadData->id_lead_type,
                    'subLeadType'   =>  $leadData->sub_lead_type,
                    'country'       =>  $leadData->country,
                    'state'         =>  $leadData->state,
                    'city'          =>  $leadData->city,
                    'remarks'       =>  $leadData->remarks,

                ];


            }
            else{
                $paramData  =   [
                    'leadName'      =>  "",
                    'email'         =>  "",
                    'phone'         =>  "",
                    'leadType'      =>  "",
                    'subLeadType'   =>  "",
                    'country'       =>  "",
                    'state'         =>  "",
                    'city'          =>  "",
                    'remarks'       =>  "",
                ];
            }

        }
        else{

            $paramData  =   [
                'leadName'      =>  "",
                'email'         =>  "",
                'phone'         =>  "",
                'leadType'      =>  "",
                'subLeadType'   =>  "",
                'country'       =>  "",
                'state'         =>  "",
                'city'          =>  "",
                'remarks'       =>  "",
            ];
        }

        $paramArray         =   [
            'pageBase'     =>   'Home',
            'pageTitle'    =>   'Add Lead',
            'browserTitle' =>   'Lead Management',
            'roleKey'      =>   $roleKey,
            'idRole'       =>   $idRole,
            'urlData'      =>   "admin/add_lead",
            'data'         =>   $paramData,
            'countries'    =>   $countries,
            'leadTypeData' =>   $leadTypeData,
            'userData'     =>   $userData,
            'screenData'   =>   $screenData,
            'idScreen'     =>   4
        ];



        return view('admin.lead.add_lead',$paramArray);




    }

    public function handleAddLead(Request $request){
        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $leadName       =   ucwords($request->name);
        $email          =   $request->email;
        $phone          =   $request->phone;
        $leadType       =   $request->lead_type;
        $subLeadType    =   $request->lead_type_sub;
        $country        =   $request->country;
        $state          =   $request->state;
        $city           =   $request->city;
        $remarks        =   $request->remarks;



        $successSaveMsg     =   MessageUtilities::dataSaveSuccessMessage();
        $errorSaveMsg       =   MessageUtilities::dataSaveFailedMessage();
        $successUpdateMsg   =   MessageUtilities::dataUpdateSuccessMessage();
        $errorUpdateMsg     =   MessageUtilities::dataUpdateFailedMessage();
        $nothingUpdateMsg   =   MessageUtilities::nothingToUpdate();



        if(!empty($leadName)){

            if(isset($request->id_lead_hidden)){
                $paramArray =   [
                    'lead_name'     =>  ucwords($leadName),
                    'email'         =>  $email,
                    'phone'         =>  $phone,
                    'id_lead_type'  =>  $leadType,
                    'sub_lead_type' =>  $subLeadType,
                    'country'       =>  $country,
                    'state'         =>  $state,
                    'city'          =>  $city,
                    'remarks'       =>  $remarks,
                    'edited_by'     =>  $idUser,
                    'edited_date'   =>  date('Y-m-d H:i:s')
                ];


                $data = LeadModel::where('id_lead','=',$request->id_lead_hidden)->update($paramArray);

                if($data){
                    return Redirect::route('addLead')->with($successUpdateMsg)->withInput();
                }
                else{
                    return Redirect::route('addLead')->with($nothingUpdateMsg)->withInput();
                }


            }
            else{
                $leadExist   =   LeadModel::where('lead_name','=',$leadName)->first();



                if(!empty($leadExist)){


                    $error =   MessageUtilities::alreadyExistMessages('Lead Name');
                    return Redirect::route('addLead')->with($error)->withInput();
                }
                else{

                    $paramArray =   [
                        'lead_name'     =>  ucwords($leadName),
                        'email'         =>  $email,
                        'phone'         =>  $phone,
                        'id_lead_type'  =>  $leadType,
                        'sub_lead_type' =>  $subLeadType,
                        'country'       =>  $country,
                        'state'         =>  $state,
                        'city'          =>  $city,
                        'remarks'       =>  $remarks,
                        'created_by'    =>  $idUser,
                        'created_date'  =>  date('Y-m-d H:i:s')
                    ];

                    $lastInsertId   =   LeadModel::insertGetId($paramArray);

                    if(!empty($lastInsertId)){
                        return Redirect::route('addLead')->with($successSaveMsg)->withInput();
                    }
                    else{
                        return Redirect::route('addLead')->with($errorSaveMsg)->withInput();
                    }
                }
            }




        }
        else{
            $error =   MessageUtilities::emptyFiledsMessage('Lead Name');
            return Redirect::route('addLead')->with($error)->withInput();
        }

    }

    public function showManageLead(Request $request){



        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $fullData       =   LeadModel::leftJoin('lead_type As lt','lt.id_lead_type','=','lead.id_lead_type')->get();



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
            'pageTitle'         =>   'Manage Lead',
            'browserTitle'      =>   'Lead Management',
            'roleKey'           =>   $roleKey,
            'idRole'            =>   $idRole,
            'urlData'           =>   "admin/manage_lead",
            'userData'          =>   $userData,
            'screenData'        =>   $screenData,
            'screenDataArray'   =>   $screenDataArray,
            'fullData'          =>   $fullData,
            'idScreen'          =>   4
        ];

        return view('admin.lead.manage_lead',$paramArray);

    }


    //Ajax Request Section
    public function loadLead(Request $request){

        $data = AgencyModel::select("id_agency","agency_name")->where("agency_name","LIKE","%{$request->input('query')}%")->get();

        //return $data;
        $dataArray  =   [];
        $paramArray =   [];
        foreach($data as $index=>$val){
            /*$dataArray['id'] =   $val['id_agency'];
            $dataArray['name'] =   $val['agency_name'];

            array_push($paramArray, $dataArray);*/

            $id     =   $val['id_agency'];
            $name   =   $val['agency_name'];

            array_push($dataArray, $id." - ".$name);



        }

        //dd($paramArray);



        return response()->json($dataArray);
    }
    public function mapLeadToAgency(Request $request){
        $lead   =   $request->lead;
        $agency =   $request->agency;
        $message    =   "";

        if(!empty($agency)){
            $agency =   explode('-', $agency);
            $idAgency   =   $agency[0];
            $agencyName =   $agency[1];
        }
        else{
            $idAgency   =   "";
            $agencyName =   "";
        }

        if(!empty($lead) && !empty($agency)){
            $mappingExist   =   MapLeadAgencyModel::where('id_lead','=',$lead)->where('id_agency','=',$idAgency)->first();

            if(!empty($mappingExist)){
                $response['status']    =   "already_mapped";
                return json_encode($response);

            }
            else{
                $param  =   [
                    'id_lead'   =>  $lead,
                    'id_agency' =>  $idAgency,
                    'agency_name'   =>  $agencyName,
                    'created_date'  =>  date('Y-m-d H:i:s')
                ];

                $data   =   MapLeadAgencyModel::insert($param);

                if($data){
                    $response['status']    =   "save_success";
                    return json_encode($response);
                }
                else{
                    $response['status']    =   "save_fail";
                    return json_encode($response);
                }
            }
        }


    }
    public function loadMapLeadAgency(Request $request){
        $idLead =   $request->id_lead;



        if(!empty($idLead)){
            $data   =   MapLeadAgencyModel::
                leftJoin('lead', 'lead.id_lead','=','mapping_lead_agency.id_lead')
                ->where('mapping_lead_agency.id_lead','=',$idLead)->get();




            $jsonData = array(
                "draw"            => intval( $_REQUEST['draw'] ),
                "recordsTotal"    => count($data),
                "recordsFiltered" => 5,
                "data"            => $data
            );


            return json_encode($jsonData);
        }
        else{
            $response['status']    =   "invalid_lead";
            return json_encode($response);
        }
    }


}
