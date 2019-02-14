<?php
namespace App\Classes;


class MessageUtilities{
    public static function loginFailedMessage(){
        $message    =   "Login Failed!!! Invalid user or password.";
        return $message;
    }

    public static function dataSaveSuccessMessage(){
        $message    =   ['success' => 'Data saved successfully.'];
        return $message;
    }
    public static function dataSaveFailedMessage(){
        $message    =   ['error' => 'Failed to save data.'];
        return $message;
    }
    public static function dataUpdateSuccessMessage(){
        $message    =   ['success' => 'Data updated successfully.'];
        return $message;
    }
    public static function dataUpdateFailedMessage(){
        $message    =   ['error' => 'Failed to update data.'];
        return $message;
    }
    public static function emptyFiledsMessage($filedNames){
        $message    =   ['error' => 'Please fill '.$filedNames];

        return $message;
    }
}



?>