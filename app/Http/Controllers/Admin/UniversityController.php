<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common\MediaCategoryModel;
use App\Models\Common\University\UniversityCourseMappingModel;
use App\Models\Common\University\UniversityModel;
use Illuminate\Auth\SessionGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Crypt;
use DB;

//Models
use App\Models\Auth\LoginModel;
use App\Models\Users\UserTypeModel;
use App\Models\Common\UrlModel;
use App\Models\Common\BusinessKeyDetailsModel;
use App\Models\Common\Streams\StreamsModel;
use App\Models\Common\GalleryModel;
use App\Models\Common\Courses\CategoryModel;
use App\Models\Common\Courses\CoursesModel;
use App\Models\Common\CountriesModel;
use App\Models\Common\StatesModel;
use App\Models\Common\CitiesModel;


//Utilities
use App\Classes\Utilities;
use App\Classes\MessageUtilities;
use App\Classes\DBUtilities;
use App\Classes\FileUploadUtilities;
use App\Classes\AuditUtilities;
use App\Classes\ModelUtilities;

//Controllers
use App\Http\Controllers\Common\CommonController;

class UniversityController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $this->commonControllerObj  =   new CommonController();


    }
    public function showAddUniversity(Request $request){

        $role   =   1;
        $idRole =   1;


        $idUser             =   Session::get('users.idUser')[0];
        $userData           =   DBUtilities::getUserInformation($idUser);
        $ed                 =   BusinessKeyDetailsModel::where('business_key','=','ED')->select('id','key_value')->pluck('key_value')->toArray();
        $coursesData        =   CoursesModel::select('id','course_name')->where('status','=','Enable')->pluck('course_name','id')->toArray();
        $countries          =   CountriesModel::select('id','name')->pluck('name','id')->toArray();
        $states             =   StatesModel::select('id','name')->pluck('name','id')->toArray();
        $cities             =   CitiesModel::select('id','name')->pluck('name','id')->toArray();



        $universityData     =   "";
        $featuredImageData  =   "";
        $thumbImageData     =   "";
        $univeristyName     =   "";
        $pageHeading        =   "";
        $tagline            =   "";
        $desc1              =   "";
        $desc2              =   "";
        $featuredImage      =   "";
        $thumbImage         =   "";
        $featuredImgName    =   "";
        $featuredImgAlt     =   "";
        $featuredImgDesc    =   "";
        $thumbImgName       =   "";
        $thumbImgAlt        =   "";
        $thumbImgDesc       =   "";

       /* $coursesData[0] =   "Select a course name";
        ksort($coursesData);*/

        $countries[0] =   "Select a country";
        ksort($countries);

        $states[0] =   "Select a state";
        ksort($states);

        $cities[0] =   "Select a city";
        ksort($cities);


        if(isset($request->id)){

            $universityData         =   UniversityModel::where('id','=',$request->id)->first();
            $featuredImageData      =   GalleryModel::where('uid','=',$request->id)->where('category','=',12)->first();
            $thumbImageData         =   GalleryModel::where('uid','=',$request->id)->where('category','=',13)->first();

        }


        if(!empty($universityData)){

            if(!empty($featuredImageData)){

                $featuredImage      =   $featuredImageData->base_path.$featuredImageData->bucket_name.$featuredImageData->filename;
                $featuredImgName    =   explode(".",$featuredImageData->filename)[0];
                $featuredImgAlt     =   $featuredImageData->alternative;
                $featuredImgDesc    =   $featuredImageData->description;
            }
            if(!empty($thumbImageData)){
                $thumbImage      =   $thumbImageData->base_path.$thumbImageData->bucket_name.$thumbImageData->filename;
                $thumbImgName    =   explode(".",$thumbImageData->filename)[0];
                $thumbImgAlt     =   $thumbImageData->alternative;
                $thumbImgDesc    =   $thumbImageData->description;
            }

            /*if(!empty(json_decode($universityData->course_name))){
                $courses            =   json_decode($universityData->course_name);
                $coursesArray       =   [];
                $coursesResultArray =   [];

                for($i=0;$i<count($courses);$i++){
                    $coursesArray['id'] =   $courses[$i];
                    $coursesArray['name'] =   $courses[$i];
                    if(!empty($coursesArray['id']) && !empty($coursesArray['name'])){
                        array_push($coursesResultArray, $coursesArray);
                    }

                }


            }*/

           //dd($testArray);

            $paramData =   [
                'idUniversity'      =>  $request->id,
                'countries'         =>  $countries,
                'universityName'    =>  $universityData->university_name,
                //'courses'           =>  json_encode($coursesResultArray),
                //'courseTest'        =>  json_encode([['id'=>"btech - Aes","name"=>"btech - Aes"],["id"=>"btech - Aa","name"=>"btech - Aa"]]),
                'status'            =>  $universityData->status,
                'adminNotes'        =>  $universityData->admin_notes,
                'pageHeading'       =>  $universityData->page_heading,
                'tagline'           =>  $universityData->tagline,
                'desc1'             =>  $universityData->description1,
                'desc2'             =>  $universityData->description2,

                'address'           =>  $universityData->address,
                'country'           =>  $universityData->country,
                'state'             =>  $universityData->state,
                'city'              =>  $universityData->city,
                'region'            =>  $universityData->region,
                'pincode'           =>  $universityData->pincode,
                'landline'          =>  $universityData->land_phone,
                'altLandline'       =>  $universityData->alt_land_phone,
                'mobile'            =>  $universityData->mobile,
                'altMobile'         =>  $universityData->alt_mobile,
                'email'             =>  $universityData->email,
                'altEmail'          =>  $universityData->alt_email,


                'title'             =>  $universityData->meta_title,
                'keywords'          =>  $universityData->meta_keywords,
                'description'       =>  $universityData->meta_description,
                'url'               =>  $universityData->url,

                'featuredImage'     =>  $featuredImage,
                'featuredImgName'   =>  $featuredImgName,
                'featuredImgAlt'    =>  $featuredImgAlt,
                'featuredImgDesc'   =>  $featuredImgDesc,
                'thumbImage'        =>  $thumbImage,
                'thumbImgName'      =>  $thumbImgName,
                'thumbImgAlt'       =>  $thumbImgAlt,
                'thumbImgDesc'      =>  $thumbImgDesc
            ];
        }
        else{
            $paramData =   [
                'idUniversity'      =>  "",
                'universityName'    =>  "",
                //'courses'           =>  "",
                'status'            =>  0,
                'adminNotes'        =>  "",
                'countries'         =>  $countries,
                'pageHeading'       =>  "",
                'tagline'           =>  "",
                'desc1'             =>  "",
                'desc2'             =>  "",

                'address'           =>  "",
                'country'           =>  "",
                'state'             =>  "",
                'city'              =>  "",
                'region'            =>  "",
                'pincode'           =>  "",
                'landline'          =>  "",
                'altLandline'       =>  "",
                'mobile'            =>  "",
                'altMobile'         =>  "",
                'email'             =>  "",
                'altEmail'          =>  "",

                'title'             =>  "",
                'keywords'          =>  "",
                'description'       =>  "",
                'url'               =>  "",

                'logoImgName'       =>  "",
                'logoImgAlt'        =>  "",
                'logoImgDesc'       =>  "",
                'featuredImage'     =>  "",
                'featuredImgName'   =>  "",
                'featuredImgAlt'    =>  "",
                'featuredImgDesc'   =>  "",
                'thumbImage'        =>  "",
                'thumbImgName'      =>  "",
                'thumbImgAlt'       =>  "",
                'thumbImgDesc'      =>  ""
            ];
        }




        $paramArray         =   [
            'pageBase'     =>  'Home',
            'pageTitle'    =>  'Add University',
            'browserTitle' =>   'University Management',
            'role'         =>   'ad',
            'idRole'       =>   1,
            'urlData'      =>   "admin/university",
            'ed'           =>   $ed,
            'data'         =>   $paramData,
            'userData'     =>   $userData,
            'idScreen'     =>   10
        ];



        return view('admin.university.add',$paramArray);

    }
    public function handleAddUniversity(Request $request){

        $idUser                 =   Session::get('users.idUser')[0];
        $ipaddress              =   $_SERVER['SERVER_ADDR'];
        $imageUploadStatus      =   "";
        $featuredCategory       =   12;
        $thumbCategory          =   13;
        $featuredBucketName     =   "university/featuredimage/";
        $thumbBucketName        =   "university/thumbimage/";


        //Contents
        $universityName =   ucwords($request->university_name);
        //!empty($request->courses_name)?$courses =   $request->courses_name:$courses =   [""];

        $status         =   $request->status;
        $adminNotes     =   $request->admin_notes;
        $pageHeading    =   $request->page_heading;
        $tagline        =   $request->tagline;
        $desc1          =   $request->input('desc1');
        $desc2          =   $request->input('desc2');

        //Contact Details
        $address        =   $request->address;
        $country        =   $request->country;
        $state          =   $request->state;
        $city           =   $request->city;
        $region         =   $request->region;
        $pincode        =   $request->pincode;
        $landPhone      =   $request->land_phone;
        $altLandPhone   =   $request->alt_land_phone;
        $mobile         =   $request->mobile;
        $altMobile      =   $request->alt_mobile;
        $email          =   $request->email;
        $altEmail       =   $request->alt_email;


        //SEO
        $title          =   $request->title;
        $keywords       =   $request->keywords;
        $url            =   $request->url;
        $desc           =   $request->desc;

        //Images
        $featuredNewImgName     =   $request->featured_image_name;
        $featuredImgAlt         =   $request->featured_image_alt;
        $featuredImgDesc        =   $request->featured_image_desc;
        $thumbNewImgName        =   $request->thumb_image_name;
        $thumbImgAlt            =   $request->thumb_image_alt;
        $thumbImgDesc           =   $request->thumb_image_desc;

        $_FILES['featured_image']['image_new_name']     =   $featuredNewImgName;
        $_FILES['featured_image']['alt']                =   $request->featured_image_alt;
        $_FILES['featured_image']['desc']               =   $request->featured_image_desc;
        $_FILES['thumb_image']['image_new_name']        =   $thumbNewImgName;
        $_FILES['thumb_image']['alt']                   =   $request->thumb_image_alt;
        $_FILES['thumb_image']['desc']                  =   $request->thumb_image_desc;





        //Message Section
        $saveSuccessMsg         =   MessageUtilities::dataSaveSuccessMessage();
        $saveFailedMsg          =   MessageUtilities::dataSaveFailedMessage();
        $updateSuccessMsg       =   MessageUtilities::dataUpdateSuccessMessage();
        $updateFailedMsg        =   MessageUtilities::dataUpdateFailedMessage();
        $invalidMediaCategory   =   MessageUtilities::invalidMediaCategory();


        if(!empty($universityName)){

            //assigning stream name to these param if they are empty
            if(empty($pageHeading)){
                $pageHeading    =   $universityName;
            }
            if(empty($title)){
                $title  =   $universityName;
            }
            if(empty($url)){
                $url    =   $universityName;
            }



            if(isset($request->id)){

                $dataArray  =   [
                    'university_name'       =>  ucwords($universityName),
                    //'course_name'           => json_encode($courses),
                    'status'                =>  $status,
                    'admin_notes'           =>  $adminNotes,
                    'address'               =>  $address,
                    'country'               =>  $country,
                    'state'                 =>  $state,
                    'city'                  =>  $city,
                    'region'                =>  ucwords($region),
                    'pincode'               =>  $pincode,
                    'land_phone'            =>  $landPhone,
                    'alt_land_phone'        =>  $altLandPhone,
                    'mobile'                =>  $mobile,
                    'alt_mobile'            =>  $altMobile,
                    'email'                 =>  $email,
                    'alt_email'             =>  $altEmail,
                    'page_heading'          =>  $pageHeading,
                    'tagline'               =>  $tagline,
                    'description1'          =>  $desc1,
                    'description2'          =>  $desc2,
                    'meta_title'            =>  $title,
                    'meta_keywords'         =>  $keywords,
                    'url'                   =>  $url,
                    'meta_description'      =>  $desc,
                    'edited_by'             =>  $idUser,
                    'edited_date'           =>  date('Y-m-d h:i:s'),
                ];

                $data =   UniversityModel::where('id','=',$request->id)->update($dataArray);

                if(!empty($data)){

                    $id =   $request->id;



                    $_FILES['featured_image']['extra_name'] =   "university_".$featuredCategory."_".$id;
                    $_FILES['thumb_image']['extra_name']    =   "university_".$thumbCategory."_".$id;

                    $featuredBucketStatus =   $this->commonControllerObj->createBucketForMediaStorage($featuredCategory, $featuredBucketName);
                    $thumbBucketStatus    =   $this->commonControllerObj->createBucketForMediaStorage($thumbCategory, $thumbBucketName);

                    if($featuredBucketStatus['response']=="success")
                    {
                        $this->commonControllerObj->featuredImageUpload($featuredBucketStatus['bucket_name'], $featuredCategory, $id, $_FILES['featured_image']);
                    }
                    if($thumbBucketStatus['response']=="success")
                    {

                        $this->commonControllerObj->thumbImageUpload($thumbBucketStatus['bucket_name'], $thumbCategory, $id, $_FILES['thumb_image']);
                    }



                    //Audit Entry
                    //------------------------------------------------------------------
                    $paramArray =   [
                        'id_user'       =>  $idUser,
                        'audit_event'   =>  'EDIT UNIVERSITY',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('showAddUniversity')->with($updateSuccessMsg);
                }
                else{
                    return Redirect::route('showAddUniversity')->with($updateFailedMsg);
                }
            }
            else{

                $dataArray  =   [
                    'university_name'       =>  ucwords($universityName),
                    //'course_name'           => json_encode($courses),
                    'status'                =>  $status,
                    'admin_notes'           =>  $adminNotes,
                    'address'               =>  $address,
                    'country'               =>  $country,
                    'state'                 =>  $state,
                    'city'                  =>  $city,
                    'region'                =>  ucwords($region),
                    'pincode'               =>  $pincode,
                    'land_phone'            =>  $landPhone,
                    'alt_land_phone'        =>  $altLandPhone,
                    'mobile'                =>  $mobile,
                    'alt_mobile'            =>  $altMobile,
                    'email'                 =>  $email,
                    'alt_email'             =>  $altEmail,
                    'page_heading'          =>  $pageHeading,
                    'tagline'               =>  $tagline,
                    'description1'          =>  $desc1,
                    'description2'          =>  $desc2,
                    'meta_title'            =>  $title,
                    'meta_keywords'         =>  $keywords,
                    'url'                   =>  $url,
                    'meta_description'      =>  $desc,
                    'created_by'            =>  $idUser,
                    'created_date'          =>  date('Y-m-d h:i:s'),

                ];

                $data =   UniversityModel::updateOrCreate($dataArray);

                if(!empty($data->id)){

                    $id =   $data->id;

                    $_FILES['featured_image']['extra_name'] =   "university_".$featuredCategory."_".$id;
                    $_FILES['thumb_image']['extra_name']    =   "university_".$thumbCategory."_".$id;

                    $featuredBucketStatus =   $this->commonControllerObj->createBucketForMediaStorage($featuredCategory, $featuredBucketName);
                    $thumbBucketStatus    =   $this->commonControllerObj->createBucketForMediaStorage($thumbCategory, $thumbBucketName);

                    if($featuredBucketStatus['response']=="success")
                    {
                        $this->commonControllerObj->featuredImageUpload($featuredBucketStatus['bucket_name'], $featuredCategory, $id, $_FILES['featured_image']);
                    }
                    if($thumbBucketStatus['response']=="success")
                    {

                        $this->commonControllerObj->thumbImageUpload($thumbBucketStatus['bucket_name'], $thumbCategory, $id, $_FILES['thumb_image']);
                    }







                    //Audit Entry
                    //------------------------------------------------------------------
                    $paramArray =   [
                        'id_user'       =>  $idUser,
                        'audit_event'   =>  'ADD UNIVERSITY',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('showAddUniversity')->with($saveSuccessMsg);
                }
                else{
                    return Redirect::route('showAddUniversity')->with($saveFailedMsg);
                }
            }
        }
        else{
            $emptyFiledsMsg =   MessageUtilities::emptyFiledsMessage('University Name');
            return Redirect::route('showAddUniversity')->with($emptyFiledsMsg);
        }



    }
    public function universityDescriptionImageUpload(){
        $bucketName     =   "university/description/";
        $category       =   15;
        $uploadStatus   =   $this->commonControllerObj->descriptionImageUpload($bucketName, $category, $_FILES['file'], 'jscript');
        return $uploadStatus;
    }
    public function showManageUniversity(){
        $role   =   1;
        $idRole =   1;


        $idUser             =   Session::get('users.idUser')[0];
        $userData           =   DBUtilities::getUserInformation($idUser);
        $ed                 =   BusinessKeyDetailsModel::where('business_key','=','ED')->select('id','key_value')->pluck('key_value','id')->toArray();
        $universityFull     =   UniversityModel::all();
        $universityActive   =   UniversityModel::where('status','=',0)->get();
        $universityInactive =   UniversityModel::where('status','=',1)->get();

        //dd($universityInactive);


        $paramArray         =   [
            'pageBase'          =>  'Home',
            'pageTitle'         =>  'Manage University',
            'browserTitle'      =>   'University Management',
            'role'              =>   'ad',
            'idRole'            =>   1,
            'urlData'           =>   "admin/manage_university",
            'ed'                =>   $ed,
            'userData'          =>   $userData,
            'full'              =>   $universityFull,
            'active'            =>   $universityActive,
            'inactive'          =>   $universityInactive,
            'idScreen'          =>   11
        ];

        return view('admin.university.manage',$paramArray);

    }
    public function handleUniversityStatusChange(Request $request){

        $idUser     =   Session::get('users.idUser')[0];
        $id         =   $request->id;
        $status     =   $request->status;
        $ipaddress  =   $_SERVER['SERVER_ADDR'];

        if(isset($id)){
            switch($status){
                case 0:
                    $dataArray  =   ['status'=>1];
                    UniversityModel::where('id','=',$id)->update($dataArray);

                    break;
                case 1:
                    $dataArray  =   ['status'=>0];
                    UniversityModel::where('id','=',$id)->update($dataArray);

                    break;

            }

            return json_encode("success");
        }
        else{
            return json_encode("invalid_user");
        }
    }
    public function showMedia(Request $request){

        $role   =   1;
        $idRole =   1;


        $idUser             =   Session::get('users.idUser')[0];
        $userData           =   DBUtilities::getUserInformation($idUser);
        $ed                 =   BusinessKeyDetailsModel::where('business_key','=','ED')->select('id','key_value')->pluck('key_value', 'id')->toArray();
        $universityData     =   UniversityModel::select('id','university_name')->where('status','=',0)->pluck('university_name','id')->toArray();
        $logoImageData      =   "";
        $featuredImageData  =   "";
        $thumbImageData     =   "";
        $univeristyName     =   "";
        $pageHeading        =   "";
        $tagline            =   "";
        $desc1              =   "";
        $desc2              =   "";
        $featuredImage      =   "";
        $thumbImage         =   "";
        $featuredImgName    =   "";
        $featuredImgAlt     =   "";
        $featuredImgDesc    =   "";
        $thumbImgName       =   "";
        $thumbImgAlt        =   "";
        $thumbImgDesc       =   "";

        //dd($universityData);

        $universityData[0] = "Select a university";
        ksort($universityData);




        if(isset($request->id_university)){

            //$universityData         =   UniversityModel::where('id','=',$request->id_university)->first();
            $logoImageData          =   GalleryModel::where('uid','=',$request->id_university)->where('category','=',11)->first();
            $featuredImageData      =   GalleryModel::where('uid','=',$request->id_university)->where('category','=',12)->first();
            $thumbImageData         =   GalleryModel::where('uid','=',$request->id_university)->where('category','=',13)->first();

        }





        $paramArray         =   [
            'pageBase'          =>  'Home',
            'pageTitle'         =>  'Media Uploads',
            'browserTitle'      =>   'Media Management',
            'role'              =>   'ad',
            'idRole'            =>   1,
            'urlData'           =>   "admin/media_university",
            'ed'                =>   $ed,
            'idUniversity'      =>  $request->id_university,
            'universityData'    =>  $universityData,
            'userData'          =>   $userData,
            'idScreen'          =>   12
        ];



        return view('admin.university.media',$paramArray);

    }
    public function handleLogoUploads(Request $request){
        $idUser         =   Session::get('users.idUser')[0];
        $userData       =   DBUtilities::getUserInformation($idUser);
        $ipaddress      =   $_SERVER['SERVER_ADDR'];
        $idUniversity   =   $request->university;
        $imageName      =   $request->logo_image_name;
        $imageAlt       =   $request->logo_image_alt;
        $imageDesc      =   $request->logo_image_desc;
        $basePath       =   "";
        $targetPath     =   "";

        $_FILES['file']['image_new_name']     =   $imageName;

        if(isset($idUniversity)){

            $bucketName     =   "university/logo/";
            $category       =   11;

            $_FILES['file']['extra_name'] =   "ulogo_".$category."_".$idUniversity;


            $status =   $this->commonControllerObj->createBucketForMediaStorage($category, $bucketName);




            if($status['response']=="success")
            {
                $uploadStatus   =   $this->commonControllerObj->logoImageUploads($status['base_path'], $bucketName, $category, $_FILES['file'], 'pscript');
            }


            //Message Section
            $uploadFailedMsg        =   MessageUtilities::uploadFailed();
            $saveSuccessMsg         =   MessageUtilities::dataSaveSuccessMessage();
            $saveFailedMsg          =   MessageUtilities::dataSaveFailedMessage();
            $invalidMediaCategory   =   MessageUtilities::invalidMediaCategory();

            if($uploadStatus['status'] == "upload_success"){
                $dataArray  =   [
                    'base_path'     =>  $uploadStatus['base_path'],
                    'bucket_name'   =>  $bucketName,
                    'uid'           =>  $idUniversity,
                    'filename'      =>  $uploadStatus['filename'],
                    'category'      =>  $category,
                    'alternative'   =>  $imageAlt,
                    'description'   =>  $imageDesc,
                    'created_date'  =>  date('Y-m-d h:i:s')
                ];

                $data   =   GalleryModel::insert($dataArray);

                if($data){
                    //Audit Entry
                    //------------------------------------------------------------------
                    $paramArray =   [
                        'id_user'       =>  $idUser,
                        'audit_event'   =>  'UPLOADED UNIVERSITY LOGO',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('showMedia')->with($saveSuccessMsg);
                }
                else{
                    return Redirect::route('showMedia')->with($saveFailedMsg);
                }
            }
            else{

                return Redirect::route('showMedia')->with($uploadFailedMsg);
            }

        }
        else{
            $emptyFiledsMsg =   MessageUtilities::invalidMessages('University');
            return Redirect::route('showMedia')->with($emptyFiledsMsg);
        }



    }
    public function handleUniversityImagesUploads(Request $request){

        $idUser         =   Session::get('users.idUser')[0];
        $userData       =   DBUtilities::getUserInformation($idUser);
        $ipaddress      =   $_SERVER['SERVER_ADDR'];
        $bucketName     =   "university/gallery/";
        $category       =   14;

        $divCount       =   $request->media_div_count_hidden;
        $university     =   $request->university;
        $dataArray      =   [];
        $paramArray     =   [];




        //Message Section
        $uploadFailedMsg        =   MessageUtilities::uploadFailed();
        $saveSuccessMsg         =   MessageUtilities::dataSaveSuccessMessage();
        $saveFailedMsg          =   MessageUtilities::dataSaveFailedMessage();
        $invalidMediaCategory   =   MessageUtilities::invalidMediaCategory();

        if(!empty($university)){
            for($i=1;$i<=$divCount;$i++){
                $imageName  =   $request['image_name'.$i];
                $imageAlt   =   $request['image_alt'.$i];
                $imageDesc  =   $request['image_desc'.$i];

                if(isset($imageName)){
                    $_FILES['file'.$i]['image_new_name'] = $imageName;

                }

                $_FILES['file'.$i]['extra_name']     = "ugallery_".$category."_".$university;

                $status =   $this->commonControllerObj->createBucketForMediaStorage($category, $bucketName);

                if($status['response']=="success")
                {
                    $uploadStatus   =   $this->commonControllerObj->galleryImageUploads($status['base_path'], $bucketName, $category, $_FILES['file'.$i], 'pscript');
                }

                if($uploadStatus['status'] == "upload_success"){
                    $dataArray  =   [
                        'base_path'     =>  $uploadStatus['base_path'],
                        'bucket_name'   =>  $bucketName,
                        'uid'           =>  $university,
                        'filename'      =>  $uploadStatus['filename'],
                        'category'      =>  $category,
                        'alternative'   =>  $imageAlt,
                        'description'   =>  $imageDesc,
                        'created_date'  =>  date('Y-m-d h:i:s')
                    ];

                    array_push($paramArray, $dataArray);
                }
                else{

                    return Redirect::route('showMedia')->with($uploadFailedMsg);
                }

            }



            $data   =   GalleryModel::insert($paramArray);
            if($data){
                //Audit Entry
                //------------------------------------------------------------------
                $paramArray =   [
                    'id_user'       =>  $idUser,
                    'audit_event'   =>  'UPLOAD UNIVERSITY GALLERY',
                    'ip_address'    =>  $ipaddress,
                    'id_audit'      =>  NULL,
                    'created_date'  =>  date('Y-m-d h:i:s'),
                    'edited_date'   =>  NULL

                ];
                $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                //--------------------------------------------------------------------

                return Redirect::route('showMedia')->with($saveSuccessMsg);
            }
            else{
                return Redirect::route('showMedia')->with($saveFailedMsg);
            }
        }
        else{
            $emptyFiledsMsg =   MessageUtilities::invalidMessages('University');
            return Redirect::route('showMedia')->with($emptyFiledsMsg);
        }


    }
    public function handleUniversityBroucherUploads(Request $request){
        $idUser         =   Session::get('users.idUser')[0];
        $userData       =   DBUtilities::getUserInformation($idUser);
        $ipaddress      =   $_SERVER['SERVER_ADDR'];
        $category       =   16;
        $bucketName     =   "university/";

        $university     =   $request->university;
        $name           =   $request->name;
        $description    =   $request->description;

        //Message Section
        $uploadFailedMsg    =   MessageUtilities::uploadFailed();
        $saveSuccessMsg     =   MessageUtilities::dataSaveSuccessMessage();
        $saveFailedMsg      =   MessageUtilities::dataSaveFailedMessage();

        $_FILES['file']['doc_new_name'] =   $name;
        $_FILES['file']['extra_name']   =   "ubroucher_".$category."_".$university;


        $status =   $this->commonControllerObj->createBucketForMediaStorage($category, $bucketName);

        if($status['response']=="success")
        {
            $uploadStatus   =   $this->commonControllerObj->documentUploads($status['base_path'], $bucketName, $category, $_FILES['file'], 'pscript');
        }



        if($uploadStatus['status'] == "upload_success"){
            $dataArray  =   [
                'base_path'     =>  $uploadStatus['base_path'],
                'bucket_name'   =>  $bucketName,
                'uid'           =>  $university,
                'filename'      =>  $uploadStatus['filename'],
                'category'      =>  $category,
                'alternative'   =>  NULL,
                'description'   =>  $description,
                'created_date'  =>  date('Y-m-d H:i:s')
            ];

            $data   =   GalleryModel::insert($dataArray);
            if($data){
                //Audit Entry
                //------------------------------------------------------------------
                $paramArray =   [
                    'id_user'       =>  $idUser,
                    'audit_event'   =>  'UPLOAD UNIVERSITY BROUCHER',
                    'ip_address'    =>  $ipaddress,
                    'id_audit'      =>  NULL,
                    'created_date'  =>  date('Y-m-d H:i:s'),
                    'edited_date'   =>  NULL

                ];
                $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                //--------------------------------------------------------------------

                return Redirect::route('showMedia')->with($saveSuccessMsg);
            }
            else{
                return Redirect::route('showMedia')->with($saveFailedMsg);
            }

        }
        else{

            return Redirect::route('showMedia')->with($uploadFailedMsg);
        }


    }
   /* public function showUniversityCourseMapping(Request $request){
        $role           =   1;
        $idRole         =   1;
        $idUser         =   Session::get('users.idUser')[0];
        $userData       =   DBUtilities::getUserInformation($idUser);
        $idUniversity   =   $request->id_map_courses;

        $universityData =   UniversityModel::select('id','university_name')->where('status','=',0)->pluck('university_name','id')->toArray();
        $coursesData    =   CoursesModel::select('id','course_name')->where('status','=',0)->pluck('course_name','id')->toArray();

        $action =   Session::get('action');

        if(isset($action) && $action == "courses_map"){
            $idUniversity   =   Session::get('id');
            $redirectRoute  =   "showUniversityCourseMapping" ;
            $error          =   Session::get('error');
        }
        else{

            $redirectRoute  =   "showManageUniversity" ;
            $error          =   "";
        }

        //Session::forget('id');
        //Session::forget('action');




        $universityData[0] =   "Select an University";
        ksort($universityData);

        $coursesData[0] =   "Select a Course";
        ksort($coursesData);

        if(!empty($idUniversity)){
            $universityExistCheck   =   UniversityModel::find($idUniversity);

            if(isset($universityExistCheck)){

                $paramArray         =   [
                    'pageBase'          =>  'Home',
                    'pageTitle'         =>  'Map Course',
                    'browserTitle'      =>   'University Management',
                    'role'              =>   'ad',
                    'idRole'            =>   1,
                    'urlData'           =>   "admin/courses_university",
                    'idUniversity'      =>   $idUniversity,
                    'universityData'    =>   $universityData,
                    'coursesData'       =>   $coursesData,
                    'userData'          =>   $userData,
                    'idScreen'          =>   14
                ];
                return view('admin.university.mapcourses',$paramArray);
            }
            else{

                $invalidMsgs    =   MessageUtilities::invalidMessages('University');
                return Redirect::route('showUniversityCourseMapping')->with($invalidMsgs);
            }

        }
        else{
            $invalidMsgs    =   MessageUtilities::invalidMessages('University');
            return Redirect::route('showUniversityCourseMapping')->with($invalidMsgs);
        }





    }*/

    public function showUniversityCourseMapping(Request $request){
        $role           =   1;
        $idRole         =   1;
        $idUser         =   Session::get('users.idUser')[0];
        $userData       =   DBUtilities::getUserInformation($idUser);
        $idUniversity   =   $request->id_mapping;
        $mappingData    =   "";
        $courses        =   [];

        $universityData =   UniversityModel::select('id','university_name')->where('status','=',0)->pluck('university_name','id')->toArray();
        $courseDuration =   BusinessKeyDetailsModel::where('business_key','=','COURSE DURATION')->select('id','key_value')->pluck('key_value','key_value')->toArray();
        $coursesData    =   CoursesModel::leftJoin('courses_categories As cc','cc.id','=','courses.id_courses_category')->where('cc.status','=',0)->where('courses.status','=',0) ->select('cc.category_name','courses.course_name','courses.id')->get();

        if(!empty($coursesData)){
            foreach($coursesData as $key=>$val){
                $courseName =   $val['category_name']." - ".$val['course_name'];
                $courses[$courseName]   =   $courseName;
            }
        }

        $courses['-'] =   "Select a Course";
        ksort($courses);

        $idMapping    =   Session::get('id_mapping');


        if(isset($idMapping) ){
            $mappingData =   UniversityCourseMappingModel::where('id','=',$idMapping) ->first();
            Session::forget('id_mapping');
        }


        if(!empty($mappingData)){
            $idUniversity   =   $mappingData['id_university'];
            $paramData =   [
                'idUniversity'  =>  $mappingData['id_university'],
                'courseName'    =>  $mappingData['course_name'],
                'duration'      =>  $mappingData['duration'],
                'fees'          =>  $mappingData['fees'],
                'overview'      =>  $mappingData['overview'],
                'eligibility'   =>  $mappingData['eligibility'],
                'remarks'       =>  $mappingData['remarks']
            ];
        }
        else{
            $paramData =   [
                'idUniversity'  =>  "",
                'courseName'    =>  "",
                'duration'      =>  "",
                'fees'          =>  "",
                'overview'      =>  "",
                'eligibility'   =>  "",
                'remarks'       =>  ""
            ];
        }




        $paramArray         =   [
            'pageBase'          =>  'Home',
            'pageTitle'         =>  'Map Course',
            'browserTitle'      =>   'University Management',
            'role'              =>   'ad',
            'idRole'            =>   1,
            'urlData'           =>   "admin/courses_university",
            'courseDuration'    =>   $courseDuration,
            'data'              =>   $paramData,
            'idUniversity'      =>   $idUniversity,
            'universityData'    =>   $universityData,
            'coursesData'       =>   $courses,
            'userData'          =>   $userData,
            'idScreen'          =>   14
        ];



        return view('admin.university.mapcourses',$paramArray);







        //Seperate

        /*$universityData =   UniversityModel::select('id','university_name')->where('status','=',0)->pluck('university_name','id')->toArray();
        $courseDuration =   BusinessKeyDetailsModel::where('business_key','=','COURSE DURATION')
                                    ->select('id','key_value')->pluck('key_value','key_value')->toArray();

        $coursesData    =   CoursesModel::leftJoin('courses_categories As cc','cc.id','=','courses.id_courses_category')
            ->where('cc.status','=',0)
            ->where('courses.status','=',0)
            ->select('cc.category_name','courses.course_name','courses.id')->get();

        $courses        =   [];

        if(!empty($coursesData)){
            foreach($coursesData as $key=>$val){
                $courseName =   $val['category_name']." - ".$val['course_name'];
                $courses[$courseName]   =   $courseName;
            }
        }

        $courses['-'] =   "Select a Course";
        ksort($courses);




        $idMapping    =   Session::get('id_mapping');


       if(isset($idMapping) ){
           $mappingData =   UniversityCourseMappingModel::where('id','=',$idMapping) ->first();

           Session::forget('id_mapping');

       }

        $universityData[0] =   "Select an University";
        ksort($universityData);



        if(!empty($mappingData)){
            $paramData =   [
                'idUniversity'  =>  $mappingData['id_university'],
                'courseName'    =>  $mappingData['course_name'],
                'duration'      =>  $mappingData['duration'],
                'fees'          =>  $mappingData['fees'],
                'overview'      =>  $mappingData['overview'],
                'eligibility'   =>  $mappingData['eligibility'],
                'remarks'       =>  $mappingData['remarks']
            ];
        }
        else{
            $paramData =   [
                'idUniversity'  =>  "",
                'courseName'      =>  "",
                'duration'      =>  "",
                'fees'          =>  "",
                'overview'      =>  "",
                'eligibility'   =>  "",
                'remarks'       =>  ""
            ];
        }



                $paramArray         =   [
                    'pageBase'          =>  'Home',
                    'pageTitle'         =>  'Map Course',
                    'browserTitle'      =>   'University Management',
                    'role'              =>   'ad',
                    'idRole'            =>   1,
                    'urlData'           =>   "admin/courses_university",
                    'courseDuration'    =>   $courseDuration,
                    'data'              =>   $paramData,
                    'idUniversity'      =>   $idUniversity,
                    'universityData'    =>   $universityData,
                    'coursesData'       =>   $courses,
                    'userData'          =>   $userData,
                    'idScreen'          =>   14
                ];
                return view('admin.university.mapcourses',$paramArray);

*/

        //Seperate Ends







    }



    public function handleUniversityCoursesMapping(Request $request){
    $idUser         =   Session::get('users.idUser')[0];
    $userData       =   DBUtilities::getUserInformation($idUser);
    $ipaddress      =   $_SERVER['SERVER_ADDR'];

    $university         =   $request->university;
    $courses            =   $request->courses;
    $coursesDuration    =   $request->courses_duration;
    $fees               =   $request->fees;
    $overview           =   $request->overview;
    $eligibility        =   $request->eligibility;
    $remarks            =   $request->remarks;

    //Message Section
    $uploadFailedMsg    =   MessageUtilities::uploadFailed();
    $saveSuccessMsg     =   MessageUtilities::dataSaveSuccessMessage();
    $saveFailedMsg      =   MessageUtilities::dataSaveFailedMessage();
    $updateSuccessMsg   =   MessageUtilities::dataUpdateSuccessMessage();


        if(!empty($university) && !empty($courses)){
            $mappingExist   =   UniversityCourseMappingModel::where('course_name','=',$courses)->where('id_university','=',$university)->first();

            //dd($mappingExist);

            if(isset($mappingExist)){
                $dataArray  =   [
                    'course_duration'   =>  $coursesDuration,
                    'fees'              =>  $fees,
                    'overview'          =>  $overview,
                    'eligibility'       =>  $eligibility,
                    'remarks'           =>  $remarks,
                    'edited_by'         =>  $idUser,
                    'edited_date'       =>  date('Y-m-d H:i:s')

                ];

                            UniversityCourseMappingModel::where('id_university','=',$university)->where('course_name','=',$courses)->update($dataArray);
                $data   =   UniversityCourseMappingModel::where('id_university','=',$university)->where('course_name','=',$courses)->select('id')->first();

                if(isset($data['id'])){
                    $updateSuccessMsg['id_mapping']      =   $data['id'];
                    return Redirect::route('showUniversityCourseMapping')->with($updateSuccessMsg);
                }

            }
            else{
                $dataArray  =   [
                    'id_university'     =>  $university,
                    'course_name'       =>  $courses,
                    'course_duration'   =>  $coursesDuration,
                    'fees'              =>  $fees,
                    'overview'          =>  $overview,
                    'eligibility'       =>  $eligibility,
                    'remarks'           =>  $remarks,
                    'created_by'        =>  $idUser,
                    'created_date'      =>  date('Y-m-d H:i:s')

                ];

                $data   =   UniversityCourseMappingModel::insertGetId($dataArray);

                if($data){
                    $saveSuccessMsg['id_mapping']   =   $data;
                    return Redirect::route('showUniversityCourseMapping')->with($saveSuccessMsg);
                }
            }


        }
        else{
            $invalidMsg =   MessageUtilities::invalidMessages('University Or Course');
            return Redirect::route('showUniversityCourseMapping')->withInput()->with($invalidMsg);
        }

    }


    //Ajax Request Management Sections
    public function loadMediaForUniversity(Request $request){
        $idUniversity   =   $request->id;

        if(!empty($idUniversity)){
            $universityLogoData     =   GalleryModel::where('uid','=',$idUniversity)->where('category','=',11)->orderBy('id','desc')->first();
            $galleryData            =   GalleryModel::where('uid','=',$idUniversity)->where('category','=',14)->get();
            $broucherData           =   GalleryModel::where('uid','=',$idUniversity)->where('category','=',16)->get();


            $param  =   [
                'logoData'      =>  $universityLogoData,
                'galleryData'   =>  $galleryData,
                'broucherData'  =>  $broucherData,
            ];



            return json_encode($param);


        }
        else{
            $param  =   ['error' => 'Invalid_university'];
            return json_encode($param);
        }
    }
    public function handleUniversityMediaDelete(Request $request){
        $idUniversity   =   $request->id_university;
        $idMedia        =   $request->id_logo;
        $targetPath     =   "";


        if(!empty($idLogo)){
            $logoData   =   GalleryModel::find($idLogo);

            if(!empty($logoData)){
                $category       =   $logoData->category;
                $basePath       =   $logoData->base_path;
                $bucketName     =   $logoData->bucket_name;
                $filename       =   $logoData->filename;
                $bucketExist    =   $this->commonControllerObj->createBucketForMediaStorage($category, $bucketName);

                if($bucketExist['response'] == "success"){
                    $targetPath =   $basePath.$bucketName.$filename;

                    if(!empty($targetPath)){
                        $data = GalleryModel::where('id','=',$idLogo)->delete();
                        if($data){
                            unlink($targetPath);
                        }

                    }

                }
            }
            else{
                $status =   ['status'=>'invalid_file'];
                return json_encode($status);
            }
        }





    }

}
