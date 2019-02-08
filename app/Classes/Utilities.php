<?php
namespace App\Classes;

use Webpatser\Uuid\Uuid;



class Utilities{
    public static function generateUUID(){
        $uuid   =   Uuid::generate();
        return $uuid;
    }

}



?>