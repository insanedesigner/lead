<?php
namespace App\Classes;

use Webpatser\Uuid\Uuid;



class Utilities{
    public static function generateUUID(){
        $uuid   =   Uuid::generate();
        return $uuid;
    }

    public static function folderExistCheck($targetPath){
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

    }

}



?>
