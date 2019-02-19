<?php
namespace App\Classes;

//Models
use App\Models\Auth\LoginModel;
use App\Models\Users\UserInfoModel;
use App\Models\Common\UrlModel;
use App\Models\Common\ScreenModel;
use App\Models\Common\RolesModel;
use App\Models\Common\ScreenRolesMapModel;



class DBUtilities{
    public static function getUserInformation($idUser){
        if(!empty($idUser)){
           /* $userData   =   LoginModel::from('users As u')
                ->join('users_info As ui','u.id_users_info','=','ui.id_users_info')
                ->leftJoin('urls_storage As url','url.id_user','u.id_user')
                ->select('ui.first_name','ui.middle_name','ui.last_name','ui.gender','ui.email','ui.mobile','ui.id_roles','ui.uid','url.*')
                ->first();
            return $userData;*/

            $userData   =   LoginModel::from('users As u')
                ->join('users_info As ui','u.id','=','ui.id_user')
                ->select('ui.first_name','ui.middle_name','ui.last_name')
                ->first();
            return $userData;


        }
        else{
            return $userData    =   "";
        }
    }
    public static function getScreenRole($idRole){
        if(!empty($idRole)){
            $screenRoleMapData  =   ScreenRolesMapModel::from('user_screen_role_map As usrm')
                    ->leftJoin('user_roles As ur','ur.id_roles','=','usrm.id_roles')
                    ->leftJoin('user_screens As us','us.id_user_screen','usrm.id_user_screen')
                    ->where('usrm.id_roles','=',$idRole)
                    ->select('usrm.*','us.*','ur.*')
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
}



?>
