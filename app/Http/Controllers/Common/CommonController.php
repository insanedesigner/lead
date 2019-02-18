<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Common\CitiesModel;
use App\Models\Common\StatesModel;
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

    public function loadCoursesDetails(){
        $coursesData    =   CoursesModel::join('courses_categories As c','c.id','=','courses.id_courses_category')
            ->select('c.category_name','courses.course_name')
            ->orderBy('c.category_name','ASC')
            ->get();

        $coursesArray   =   [];
            foreach($coursesData as $index=>$key){
                $categoryName   =   $key['category_name'];
                $courseName     =   $key['course_name'];
                $courses        =   $categoryName." - ".$courseName;
                    array_push($coursesArray, $courses);
            }
        return json_encode($coursesArray);
    }

    public function loadStateOnCountries(Request $request){
        $idCountry  =   $request->id_country;
        $states     =   "";

        if(isset($idCountry)){
            $states =   StatesModel::where('country_id','=',$idCountry)->select('id','name')->get();
            return json_encode($states);
        }
        else{
            return json_encode('error');
        }


    }
    public function loadCityOnStates(Request $request){
        $idState  =   $request->id_state;
        $cities   =   "";

        if(isset($idState)){
            $cities =   CitiesModel::where('state_id','=',$idState)->select('id','name')->get();
            return json_encode($cities);
        }
        else{
            return json_encode('error');
        }


    }
}
