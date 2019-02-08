<?php
namespace App\Classes;

//Models
use App\Models\Auth\LoginModel;
use App\Models\Users\UserInfoModel;
use App\Models\Common\AuditEventModel;
/*use App\Models\Common\UrlModel;
use App\Models\Common\ScreenModel;
use App\Models\Common\RolesModel;
use App\Models\Common\ScreenRolesMapModel;*/


class AuditUtilities{
    public static function putAuditInformation($paramArray)
    {
       AuditEventModel::insert($paramArray);
    }
}



?>
