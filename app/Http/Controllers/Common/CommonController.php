<?php

namespace App\Http\Controllers\Common;

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

class CommonController extends Controller
{
    public function descriptionImageUpload($bucketName, $category, $image, $scriptType){

        $basePath       =   "public/assets/images/";
        $targetDir      =   $basePath.$bucketName;
        $uploadStatus   =   FileUploadUtilities::imageUploader($targetDir,$image, $category,$scriptType);

        return $uploadStatus;

    }
    public function featuredImageUpload($bucketName, $category, $uid, $image)
    {
        $basePath       =   "public/assets/images/";
        $targetPath     =   $basePath . $bucketName;
        $alternative    =   $image['alt'];
        $description    =   $image['desc'];

        $featuredImgExistCheck      =    GalleryModel::where('uid','=',$uid)->where('category','=',$category)->first();
        $uploadStatus               =    FileUploadUtilities::imageUploader($targetPath, $image, $category, 'pscript');

        if ($uploadStatus['status'] == 'upload_success') {
            if(!empty($featuredImgExistCheck)){
                $dataArray = [
                    'base_path'     =>  $basePath,
                    'bucket_name'   =>  $bucketName,
                    'filename'      =>  $uploadStatus['filename'],
                    'uid'           =>  $uid,
                    'category'      =>  $category,
                    'alternative'   =>  $alternative,
                    'description'   =>  $description,
                    'edited_date'   =>  date('Y-m-d h:i:s')
                ];

                if(!empty($image['name'])){
                    GalleryModel::where('uid','=',$uid)->where('category','=',$category)->update($dataArray);
                }

            }
            else{
                $dataArray = [
                    'base_path'     =>  $basePath,
                    'bucket_name'   =>  $bucketName,
                    'filename'      =>  $uploadStatus['filename'],
                    'uid'           =>  $uid,
                    'category'      =>  $category,
                    'alternative'   =>  $alternative,
                    'description'   =>  $description,
                    'created_date'  =>  date('Y-m-d h:i:s')
                ];

                if(!empty($image['name'])){
                    GalleryModel::insert($dataArray);
                }

            }

        }
    }
    public function thumbImageUpload($bucketName, $category, $uid, $image)
    {

        $basePath       =   "public/assets/images/";
        $targetPath     =   $basePath.$bucketName;
        $alternative    =   $image['alt'];
        $description    =   $image['desc'];

        $thumbImgExistCheck =   GalleryModel::where('uid','=',$uid)->where('category','=',$category)->first();
        $uploadStatus       =   FileUploadUtilities::imageUploader($targetPath, $image, $category,'pscript');


        if ($uploadStatus['status'] == 'upload_success') {
            if(!empty($thumbImgExistCheck)){
                $dataArray = [
                    'base_path'     =>  $basePath,
                    'bucket_name'   =>  $bucketName,
                    'filename'      =>  $uploadStatus['filename'],
                    'uid'           =>  $uid,
                    'category'      =>  $category,
                    'alternative'   =>  $alternative,
                    'description'   =>  $description,
                    'edited_date'  =>  date('Y-m-d h:i:s')
                ];
                GalleryModel::where('uid','=',$uid)->where('category','=',$category)->update($dataArray);
            }
            else{
                $dataArray = [
                    'base_path'     =>  $basePath,
                    'bucket_name'   =>  $bucketName,
                    'filename'      =>  $uploadStatus['filename'],
                    'uid'           =>  $uid,
                    'category'      =>  $category,
                    'alternative'   =>  $alternative,
                    'description'   =>  $description,
                    'created_date'  =>  date('Y-m-d h:i:s')
                ];
                $save   =   GalleryModel::insert($dataArray);

            }

        }


    }
}
