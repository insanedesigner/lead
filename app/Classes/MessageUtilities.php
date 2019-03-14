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
    public static function nothingToUpdate(){
        $message    =   ['error' => 'No changes to update.'];
        return $message;
    }
    public static function emptyFiledsMessage($filedNames){
        $message    =   ['error' => 'Please fill '.$filedNames];

        return $message;
    }
    public static function invalidMessages($filedNames){
        $message    =   ['error' => 'Invalid '.$filedNames];

        return $message;
    }

    public static function uploadFailed(){
        $message    =   ['error' => 'Failed to upload data.'];
        return $message;
    }

    public static function invalidMediaCategory(){
        $message    =   ['error' => 'Invalid Media Category.'];
        return $message;
    }

    public static function alreadyExistMessages($fieldName){
        $message    =   ['error' => $fieldName.' already exists.'];
        return $message;
    }

    public static function passwordAndConfirmPasswordNotMatch(){
        $message    =   ['error' => "Password and Confirm Password does not matching."];
        return $message;
    }



}



?>
