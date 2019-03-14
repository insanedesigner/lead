<?php
namespace App\Classes;

//Models
use App\Models\Common\BusinessKeyDetailsModel;
use App\Models\Auth\LoginModel;
use App\Models\Common\Courses\CoursesModel;
use App\Models\Users\UserInfoModel;
use App\Models\Users\UserTypeModel;
use App\Models\Common\UrlModel;
use App\Models\Common\ScreenModel;
use App\Models\Common\RolesModel;
use App\Models\Common\ScreenRolesMapModel;
use App\Models\Common\CountriesModel;
use App\Models\Common\StatesModel;
use App\Models\Common\CitiesModel;



class DBUtilities{
    public static function getUserInformation($idUser){
        if(!empty($idUser)){
           /* $userData   =   LoginModel::from('users As u')
                ->join('users_info As ui','u.id_users_info','=','ui.id_users_info')
                ->leftJoin('urls_storage As url','url.id_user','u.id_user')
                ->select('ui.first_name','ui.middle_name','ui.last_name','ui.gender','ui.email','ui.mobile','ui.id_roles','ui.uid','url.*')
                ->first();
            return $userData;*/

            $userData   =   LoginModel::from('user As u')
                ->join('user_info As ui','u.id_user_info','=','u.id_user_info')
                ->select('ui.first_name','ui.last_name')
                ->first();
            return $userData;


        }
        else{
            return $userData    =   "";
        }
    }
    public static function getScreenRole($idRole){
        if(!empty($idRole)){
            $screenRoleMapData  =   ScreenRolesMapModel::from('mapping_user_role_screen As map')
                    ->leftJoin('user_role As role','role.id_role','=','map.id_user_role')
                    ->leftJoin('screens As screen','screen.id_screen','map.id_user_screen')
                    ->where('map.id_user_role','=',$idRole)
                    /*->select('map.*','screen.*','role.*')*/
                    ->select('map.id_user_screen','screen.sub_screen')
                    ->get();


            return $screenRoleMapData;

        }
        else{
            return $screenRoleMapData = "";
        }
    }
    public static function getActiveUrl($idRole, $idScreen){
        if(!empty($idRole)){
            $urlData    = UrlModel::where('id_roles','=',$idRole)->where('id_user_screen','=',$idScreen)->first();

           return $urlData;
        }
        else{
            return $urlData =   "";
        }
    }

    public static function countryList(){
        $countries      =   CountriesModel::select('id','name')->pluck('name','id')->toArray();
        $countries[0] =   "Select a country";
        ksort($countries);

        return $countries;

    }

    public static function stateList(){
        $states         =   StatesModel::select('id','name')->pluck('name','id')->toArray();
        $states[0] =   "Select a state";
        ksort($states);

        return $states;

    }
    public static function cityList(){
        $cities         =   CitiesModel::select('id','name')->pluck('name','id')->toArray();
        $cities[0] =   "Select a city";
        ksort($cities);

        return $cities;

    }

    public static function genderList(){
        $gender     =   BusinessKeyDetailsModel::where('business_key','=','GENDER')->select('id','key_value')->pluck('key_value','key_value')->toArray();
        return $gender;

    }

    public static function status(){
        $status         =   BusinessKeyDetailsModel::select('id','key_value')->where('business_key','=','ED')->pluck('key_value')->toArray();
        return $status;

    }

    public static function  userTypes(){
        $data         =  UserTypeModel::select('id_user_type','type_name')->pluck('type_name','id_user_type')->toArray();
        return $data;

    }
}



?>
