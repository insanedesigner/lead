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

class AdminController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    //Starts: Dashboard Management Section
    //-----------------------------------------------------------------------------
    public function showDashboard(Request $request){

        $idUser     =   Session::get('users.idUser')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $roleKey    =   Session::get('users.roleKey')[0];

        $userData   =   DBUtilities::getUserInformation($idUser);
        $screenData =   DBUtilities::getScreenRole($idRole)->toArray();

        $paramArray         =   [
            'pageBase'     =>   'Home',
            'pageTitle'    =>   'Dashboard',
            'browserTitle' =>   'Dashboard',
            'roleKey'      =>   $roleKey,
            'idRole'       =>   $idRole,
            'urlData'      =>   "admin/dashboard",
            'userData'     =>   $userData,
            'screenData'   =>   $screenData,
            'idScreen'     =>   1
        ];

        //dd($paramArray);

        return view('admin.dashboard',$paramArray);




    }
    //-----------------------------------------------------------------------------
    //Ends: Dashboard Management Section
}
