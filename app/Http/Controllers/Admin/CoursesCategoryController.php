<?php

namespace App\Http\Controllers\Admin;

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

//Controllers
use App\Http\Controllers\Common\CommonController;

class CoursesCategoryController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $this->commonControllerObj  =   new CommonController();
    }

    public function showCoursesCategory(Request $request){


        $role   =   1;
        $idRole =   1;



        $idUser             =   Session::get('users.idUser')[0];
        $userData           =   DBUtilities::getUserInformation($idUser);
        $ed                 =   BusinessKeyDetailsModel::where('business_key','=','ED')->select('id','key_value')->pluck('key_value')->toArray();
        //$streamData         =   StreamsModel::select('id', 'stream_name')->where('status','=',0)->pluck('stream_name','id')->toArray();;
        $categoryData       =   "";
        $idStream           =   "";
        $featuredImageData  =   "";
        $thumbImageData     =   "";
        $streamName         =   "";
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



        if(isset($request->id_courses)){
            //$streamFullData =   StreamsModel::join('gallery As g','streams.id','=','g.uid')->get();
            $categoryData           =   CategoryModel::where('id','=',$request->id_courses)->first();
            $featuredImageData      =   GalleryModel::where('uid','=',$request->id_courses)->where('category','=',4)->first();
            $thumbImageData         =   GalleryModel::where('uid','=',$request->id_courses)->where('category','=',5)->first();

        }

        if(!empty($categoryData)){
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

            $coursesCategoryData    =   [
                'idStream'          =>  $categoryData->id_stream,
                'idCategory'        =>  $request->id_courses,
                'coursesName'       =>  $categoryData->category_name,
                'pageHeading'       =>  $categoryData->page_heading,
                'tagline'           =>  $categoryData->tagline,
                'desc1'             =>  $categoryData->description1,
                'desc2'             =>  $categoryData->description2,
                'title'             =>  $categoryData->meta_title,
                'keywords'          =>  $categoryData->meta_keywords,
                'description'       =>  $categoryData->meta_description,
                'url'               =>  $categoryData->url,
                'status'            =>  $categoryData->status,
                'adminNotes'        =>  $categoryData->admin_notes,
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
            $coursesCategoryData    =   [
                /*'idStream'          =>  "",*/
                'idCategory'        =>  "",
                'coursesName'       =>  "",
                'pageHeading'       =>  "",
                'tagline'           =>  "",
                'desc1'             =>  "",
                'desc2'             =>  "",
                'title'             =>  "",
                'keywords'          =>  "",
                'description'       =>  "",
                'url'               =>  "",
                'status'            =>  "",
                'adminNotes'        =>  "",
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

        //dd($coursesCategoryData);



        $paramArray         =   [
            'pageBase'     =>  'Home',
            'pageTitle'    =>  'Add Courses Category',
            'browserTitle' =>   'Courses Category Management',
            'role'         =>   'ad',
            'idRole'       =>   1,
            'urlData'      =>   "admin/coursescategory",
            'ed'           =>   $ed,
            'userData'     =>   $userData,
            /*'streamData'   =>   $streamData,*/
            'coursesData'  =>   $coursesCategoryData,
            'idScreen'     =>   6
        ];



        return view('admin.courses.coursescategory',$paramArray);









    }
    public function handleAddCoursesCategory(Request $request){

        $idUser                 =   Session::get('users.idUser')[0];
        $ipaddress              =   $_SERVER['SERVER_ADDR'];
        $imageUploadStatus      =   "";
        $featuredBucketName     =   "courses/category/featuredimage/";
        $thumbBucketName        =   "courses/category/thumbimage/";
        $featuredCategory       =   4;
        $thumbCategory          =   5;

        //$idStream       =   $request->id_stream;
        $courses        =   $request->courses_name;
        $pageHeading    =   $request->page_heading;
        $tagline        =   $request->tagline;
        $desc1          =   $request->input('desc1');
        $desc2          =   $request->input('desc2');

        //SEO Elements
        $title          =   $request->title;
        $keywords       =   $request->keywords;
        $url            =   $request->url;
        $desc           =   $request->desc;

        //Info
        $status         =   $request->status;
        $adminNotes     =   $request->admin_notes;

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

        $imageUploadStatus      =   "";



        //Message Section
        $saveSuccessMsg     =   MessageUtilities::dataSaveSuccessMessage();
        $saveFailedMsg      =   MessageUtilities::dataSaveFailedMessage();
        $updateSuccessMsg   =   MessageUtilities::dataUpdateSuccessMessage();
        $updateFailedMsg    =   MessageUtilities::dataUpdateFailedMessage();


        if(!empty($courses)){

            //assigning stream name to these param if they are empty
            if(empty($pageHeading)){ $pageHeading    =   $courses; }
            if(empty($title)){ $title  =   $courses; }
            if(empty($url)){ $url    =   $courses; }


            if(isset($request->id_courses)){
                $id =   $request->id_courses;
                $dataArray  =   [
                    /*'id_stream'          =>  $idStream,*/
                    'category_name'      =>  $courses,
                    'page_heading'       =>  $pageHeading,
                    'tagline'            =>  $tagline,
                    'description1'       =>  $desc1,
                    'description2'       =>  $desc2,
                    'meta_title'         =>  $title,
                    'meta_keywords'      =>  $keywords,
                    'url'                =>  $url,
                    'meta_description'   =>  $desc,
                    'status'             =>  $status,
                    'edited_by'          =>  $idUser,
                    'admin_notes'        =>  $adminNotes,
                    'edited_date'        =>  date('Y-m-d h:i"s')
                ];

                $data =   CategoryModel::where('id','=',$id)->update($dataArray);

                if(!empty($data)){
                    $featuredImageUploadStatus  =   $this->commonControllerObj->featuredImageUpload($featuredBucketName, $featuredCategory, $id, $_FILES['featured_image']);
                    $thumbImageUploadStatus     =   $this->commonControllerObj->thumbImageUpload($thumbBucketName, $thumbCategory, $id, $_FILES['thumb_image']);


                    //Audit Entry
                    //------------------------------------------------------------------
                    $paramArray =   [
                        'id_user'       =>  $idUser,
                        'audit_event'   =>  'EDIT COURSES CATEGORY',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('showCoursesCategory')->with($updateSuccessMsg);
                }
                else{
                    return Redirect::route('showCoursesCategory')->with($updateFailedMsg);
                }
            }
            else{

                $dataArray  =   [
                    /*'id_stream'          =>  $idStream,*/
                    'category_name'      =>  $courses,
                    'page_heading'       =>  $pageHeading,
                    'tagline'            =>  $tagline,
                    'description1'       =>  $desc1,
                    'description2'       =>  $desc2,
                    'meta_title'         =>  $title,
                    'meta_keywords'      =>  $keywords,
                    'url'                =>  $url,
                    'meta_description'   =>  $desc,
                    'status'             =>  $status,
                    'created_by'         =>  $idUser,
                    'admin_notes'        =>  $adminNotes,
                    'created_date'       =>  date('Y-m-d H:i:s')
                ];

                $categoryModel  =   CategoryModel::updateOrCreate($dataArray);


                if(!empty($categoryModel->id)){
                    $id =   $categoryModel->id;

                    $_FILES['featured_image']['extra_name'] =   "courses_category_".$featuredCategory."_".$id;
                    $_FILES['thumb_image']['extra_name']    =   "courses_category_".$thumbCategory."_".$id;

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
                        'audit_event'   =>  'ADD COURSES CATEGORY',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('showCoursesCategory')->with($saveSuccessMsg);
                }
                else{
                    return Redirect::route('showCoursesCategory')->with($saveFailedMsg);
                }
            }
        }
        else{
            $emptyFiledsMsg =   MessageUtilities::emptyFiledsMessage('Courses Category Name');
            return Redirect::route('showCoursesCategory')->with($emptyFiledsMsg);
        }



    }
    public function coursesCategoryDescriptionImageUpload(){
        $bucketName     =   "courses/category/description/";
        $category       =   6;
        $uploadStatus   =   $this->commonControllerObj->descriptionImageUpload($bucketName, $category, $_FILES['file'], 'jscript');
        return $uploadStatus;
    }
    public function showViewCoursesCategory(){
        $role   =   1;
        $idRole =   1;


        $idUser         =   Session::get('users.idUser')[0];
        $userData       =   DBUtilities::getUserInformation($idUser);
        $ed             =   BusinessKeyDetailsModel::where('key_description','=','ED')->select('id','key_value')->get()->toArray();
        $courseFullData =   CategoryModel::get();
        $courseActive   =   CategoryModel::where('status','=',0)->get();
        $courseInactive =   CategoryModel::where('status','=',1)->get();



        $paramArray         =   [
            'pageBase'          =>  'Home',
            'pageTitle'         =>  'View Course Categories',
            'browserTitle'      =>   'Courses Categories Management',
            'role'              =>   'ad',
            'idRole'            =>   1,
            'urlData'           =>   "admin/viewcoursescategory",
            'ed'                =>   $ed,
            'userData'          =>   $userData,
            'courseFullData'    =>   $courseFullData,
            'courseActiveData'  =>   $courseActive,
            'courseInactiveData'=>   $courseInactive,
            'idScreen'          =>   7
        ];

        return view('admin.courses.viewcoursescategory',$paramArray);

    }
    public function handleCoursesCategoryStatusChange(Request $request){

        $idUser         =   Session::get('users.idUser')[0];
        $idCourses      =   $request->id_courses;
        $status         =   $request->status;
        $ipaddress      =   $_SERVER['SERVER_ADDR'];

        if(isset($idCourses)){
            switch($status){
                case 0:
                    $dataArray  =   ['status'=>1];
                    CategoryModel::where('id','=',$idCourses)->update($dataArray);

                    break;
                case 1:
                    $dataArray  =   ['status'=>0];
                    CategoryModel::where('id','=',$idCourses)->update($dataArray);

                    break;

            }

            return json_encode("success");
        }
        else{
            return json_encode("invalid_user");
        }
    }


}
