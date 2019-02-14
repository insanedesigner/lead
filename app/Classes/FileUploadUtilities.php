<?php
namespace App\Classes;
//Models
//use App\Models\VehicleModels;

class FileUploadUtilities{
    public static function imageUploader($targetDir, $image, $category, $scriptType){



        $imageName      =   $image['name'];
        $targetFile     =   $targetDir.basename($imageName);
        $imgExt         =   strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        $tmpFilename    =   $image['tmp_name'];
        $imgExtArray    =   ["jpg","JPG","jpeg","JPEG","png","PNG","gif","GIF"];

        if(isset($image['image_new_name'])){
            $imageName  =   $image['image_new_name'].".".$imgExt;
            $targetFile =   $targetDir . $imageName;
        }


        if(in_array($imgExt,$imgExtArray)){
            if(move_uploaded_file($tmpFilename, $targetFile)){
                if($scriptType  ==  'pscript'){
                    return ["status"=>"upload_success",'filename'=>$imageName];
                }
                else{
                    return json_encode(array('location' => $targetFile,'status' => 'upload_success'));
                }

                //return json_encode("upload_success");
            }
            else{
                if($scriptType  ==  'pscript'){
                    return ["status"=>"upload_failed"];

                }
                else{
                    return json_encode(array('location' => $targetFile,'status' => 'upload_failed'));
                }

            }
        }
        else{
            if($scriptType  ==  'pscript'){
                return ["status"=>"invalid_image_format"];
            }
            else{
                return json_encode(array('location' => $targetFile,'status' => 'invalid_image_format'));
            }
        }



        /*$imageName              =   $image['file']['name'];
        $targetFile             =   $targetDir . basename($imageName);
        $imgExt                 =   strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        $tmpFilename            =   $image['file']['tmp_name'];
        $imageExtensionArray    =   ["jpg","JPG","jpeg","JPEG","png","PNG","gif","GIF","image/png"];
        //$targetFile             =   $targetDir . basename($imageName);

        if(isset($image['file']['input_image_name'])){
            $imageName  =   $image['file']['input_image_name'].".".$imgExt;
            $targetFile =   $targetDir . $imageName;
        }

        if(in_array($imgExt,$imageExtensionArray)){
            if(move_uploaded_file($tmpFilename, $targetFile)){
                return json_encode(array('location' => $targetFile,'status' => 'upload_success'));
                //return json_encode("upload_success");
            }
            else{
                return json_encode(array('location' => $targetFile,'status' => 'upload_failed'));
                //return json_encode("upload_failed");
            }
        }
        else{
            return json_encode(array('location' => $targetFile,'status' => 'invalid_image_format'));
            //return json_encode("invalid_image_format");
        }*/
    }
}
?>
