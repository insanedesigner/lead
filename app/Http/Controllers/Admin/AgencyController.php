<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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


//Utilities
use App\Classes\MessageUtilities;
use App\Classes\DBUtilities;
use App\Classes\FileUploadUtilities;
use App\Classes\AuditUtilities;

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


        $paramArray         =   [
            'pageBase'     =>   'Home',
            'pageTitle'    =>   'Add Agency',
            'browserTitle' =>   'Agency Management',
            'roleKey'      =>   $roleKey,
            'idRole'       =>   $idRole,
            'status'       =>   $status,
            'urlData'      =>   "admin/add_agency",
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

        $status     =   BusinessKeyDetailsModel::select('id','key_value')->where('business_key','=','ED')->pluck('key_value')->toArray();
        dd($status);

        $paramArray         =   [
            'pageBase'     =>   'Home',
            'pageTitle'    =>   'Manage Agency',
            'browserTitle' =>   'Agency Management',
            'roleKey'      =>   $roleKey,
            'idRole'       =>   $idRole,
            'status'       =>   $status,
            'urlData'      =>   "admin/manage_agency",
            'userData'     =>   $userData,
            'screenData'   =>   $screenData,
            'idScreen'     =>   3
        ];



        return view('admin.agency.manage',$paramArray);




    }

    public function handleAddAgency(Request $request){
        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $agencyName =   $request->agency_name;
        $points     =   $request->points;
        $websites   =   $request->website;
        $remarks    =   $request->remarks;


        if(!empty($agencyName)){

        }
        else{
            $error =   MessageUtilities::emptyFiledsMessage('Agency Name');
            return Redirect::route('addAgency')->with($error)->withInput();
        }

    }

}
