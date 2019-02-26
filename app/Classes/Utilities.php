<?php
namespace App\Classes;

use Webpatser\Uuid\Uuid;



class Utilities{
    public static function generateUUID(){
        $uuid   =   Uuid::generate();
        return $uuid;
    }



    public static function folderExistCheck($paramArray){
        $targetPath =   "";
        $basePath   =   $paramArray['base_path'];
        $bucketName =   $paramArray['bucket_name'];

        if(!empty($basePath) && !empty($bucketName)){
            $targetPath =   $basePath.$bucketName;
        }


        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);

        }



        return $bucketName;

    }

}



?>
