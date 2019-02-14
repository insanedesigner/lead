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

class CoursesController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $this->commonControllerObj  =   new CommonController();
    }
    public function showCourses(Request $request){
        $role   =   1;
        $idRole =   1;



        $idUser             =   Session::get('users.idUser')[0];
        $userData           =   DBUtilities::getUserInformation($idUser);
        $ed                 =   BusinessKeyDetailsModel::where('key_description','=','ED')->select('id','key_value')->get()->toArray();
        $categoryData       =   CategoryModel::select('id', 'category_name')->where('status','=','Enable')->pluck('category_name','id')->toArray();;
        $coursesData        =   "";
        $idCategory         =   "";
        $idCourses          =   "";
        $featuredImageData  =   "";
        $thumbImageData     =   "";
        $coursesName        =   "";
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

        array_unshift($categoryData, "Select a Course Category");



        if(isset($request->id_courses)){
            //$streamFullData =   StreamsModel::join('gallery As g','streams.id','=','g.uid')->get();
            $coursesData            =   CoursesModel::where('id','=',$request->id_courses)->first();
            $featuredImageData      =   GalleryModel::where('uid','=',$request->id_courses)->where('category','=',4)->first();
            $thumbImageData         =   GalleryModel::where('uid','=',$request->id_courses)->where('category','=',5)->first();

        }


        if(!empty($coursesData)){
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

            $coursesData    =   [
                'idCourses'         =>  $request->id_courses,
                'idCategory'        =>  $coursesData->id_courses_category,
                'coursesName'       =>  $coursesData->course_name,
                'pageHeading'       =>  $coursesData->page_heading,
                'tagline'           =>  $coursesData->tagline,
                'desc1'             =>  $coursesData->description1,
                'desc2'             =>  $coursesData->description2,
                'title'             =>  $coursesData->meta_title,
                'keywords'          =>  $coursesData->meta_keywords,
                'description'       =>  $coursesData->meta_description,
                'url'               =>  $coursesData->url,
                'status'            =>  $coursesData->status,
                'adminNotes'        =>  $coursesData->admin_notes,
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
            $coursesData    =   [
                'idCourses'         =>  "",
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
            'pageTitle'    =>  'Add Courses',
            'browserTitle' =>   'Courses Management',
            'role'         =>   'ad',
            'idRole'       =>   1,
            'urlData'      =>   "admin/courses",
            'ed'           =>   $ed,
            'userData'     =>   $userData,
            'categoryData' =>   $categoryData,
            'coursesData'  =>   $coursesData,
            'idScreen'     =>   8
        ];



        return view('admin.courses.courses',$paramArray);









    }
    public function handleAddCourses(Request $request){

        $idUser                 =   Session::get('users.idUser')[0];
        $ipaddress              =   $_SERVER['SERVER_ADDR'];
        $imageUploadStatus      =   "";
        $featuredBucketName     =   "courses/featuredimage/";
        $thumbBucketName        =   "courses/thumbimage/";
        $featuredCategory       =   8;
        $thumbCategory          =   9;

        $idCategory     =   $request->id_category;
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
        $status         =   $request->active_status;
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
                    'id_courses_category'   =>  $idCategory,
                    'course_name'           =>   ucwords($courses),
                    'page_heading'          =>  $pageHeading,
                    'tagline'               =>  $tagline,
                    'description1'          =>  $desc1,
                    'description2'          =>  $desc2,
                    'meta_title'            =>  $title,
                    'meta_keywords'         =>  $keywords,
                    'url'                   =>  $url,
                    'meta_description'      =>  $desc,
                    'status'                =>  $status,
                    'edited_by'             =>  $idUser,
                    'admin_notes'           =>  $adminNotes,
                    'edited_date'           =>  date('Y-m-d h:i"s')
                ];

                $data =   CoursesModel::where('id','=',$id)->update($dataArray);

                if(!empty($data)){
                    $featuredImageUploadStatus  =   $this->commonControllerObj->featuredImageUpload($featuredBucketName, $featuredCategory, $id, $_FILES['featured_image']);
                    $thumbImageUploadStatus     =   $this->commonControllerObj->thumbImageUpload($thumbBucketName, $thumbCategory, $id, $_FILES['thumb_image']);


                    //Audit Entry
                    //------------------------------------------------------------------
                    $paramArray =   [
                        'id_user'       =>  $idUser,
                        'audit_event'   =>  'EDIT COURSES',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('showCourses')->with($updateSuccessMsg);
                }
                else{
                    return Redirect::route('showCourses')->with($updateFailedMsg);
                }
            }
            else{

                $dataArray  =   [
                    'id_courses_category'   =>  $idCategory,
                    'course_name'           =>   ucwords($courses),
                    'page_heading'          =>  $pageHeading,
                    'tagline'               =>  $tagline,
                    'description1'          =>  $desc1,
                    'description2'          =>  $desc2,
                    'meta_title'            =>  $title,
                    'meta_keywords'         =>  $keywords,
                    'url'                   =>  $url,
                    'meta_description'      =>  $desc,
                    'status'                =>  $status,
                    'created_by'            =>  $idUser,
                    'admin_notes'           =>  $adminNotes,
                    'created_date'          =>  date('Y-m-d h:i:s')
                ];

                $data  =   CoursesModel::updateOrCreate($dataArray);

                //$streamData =   StreamsModel::updateOrCreate($dataArray);

                if(!empty($data->id)){
                    $id =   $data->id;
                    $featuredImageUploadStatus  =   $this->commonControllerObj->featuredImageUpload($featuredBucketName, $featuredCategory, $id, $_FILES['featured_image']);
                    $thumbImageUploadStatus     =   $this->commonControllerObj->thumbImageUpload($thumbBucketName, $thumbCategory, $id, $_FILES['thumb_image']);

                    //Audit Entry
                    //------------------------------------------------------------------
                    $paramArray =   [
                        'id_user'       =>  $idUser,
                        'audit_event'   =>  'ADD COURSES',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('showCourses')->with($saveSuccessMsg);
                }
                else{
                    return Redirect::route('showCourses')->with($saveFailedMsg);
                }
            }
        }
        else{
            $emptyFiledsMsg =   MessageUtilities::emptyFiledsMessage('Courses Name');
            return Redirect::route('showCourses')->with($emptyFiledsMsg);
        }



    }
    public function coursesDescriptionImageUpload(){
        $bucketName     =   "courses/description/";
        $category       =   10;
        $uploadStatus   =   $this->commonControllerObj->descriptionImageUpload($bucketName, $category, $_FILES['file'], 'jscript');
        return $uploadStatus;
    }
    public function showViewCourses(){
        $role   =   1;
        $idRole =   1;


        $idUser         =   Session::get('users.idUser')[0];
        $userData       =   DBUtilities::getUserInformation($idUser);
        $ed             =   BusinessKeyDetailsModel::where('key_description','=','ED')->select('id','key_value')->get()->toArray();
        $courseFullData =   CoursesModel::join('courses_categories As c','c.id','=','courses.id_courses_category')
            ->select('c.category_name','courses.*')
            ->get();
        $courseActive   =   CoursesModel::join('courses_categories As c','c.id','=','courses.id_courses_category')
            ->select('c.category_name','courses.*')
            ->where('courses.status','=','Enable')->get();
        $courseInactive =   CoursesModel::join('courses_categories As c','c.id','=','courses.id_courses_category')
            ->select('c.category_name','courses.*')
            ->where('courses.status','=','Disable')->get();


        $paramArray         =   [
            'pageBase'          =>  'Home',
            'pageTitle'         =>  'View Courses',
            'browserTitle'      =>   'Courses Management',
            'role'              =>   'ad',
            'idRole'            =>   1,
            'urlData'           =>   "admin/viewcourses",
            'ed'                =>   $ed,
            'userData'          =>   $userData,
            'courseFullData'    =>   $courseFullData,
            'courseActiveData'  =>   $courseActive,
            'courseInactiveData'=>   $courseInactive,
            'idScreen'          =>   9
        ];

        return view('admin.courses.viewcourses',$paramArray);

    }
    public function handleCoursesStatusChange(Request $request){

        $idUser         =   Session::get('users.idUser')[0];
        $idCourses      =   $request->id_courses;
        $status         =   $request->status;
        $ipaddress      =   $_SERVER['SERVER_ADDR'];

        if(isset($idCourses)){
            switch($status){
                case 'Enable':
                    $dataArray  =   ['status'=>'Disable'];
                    CoursesModel::where('id','=',$idCourses)->update($dataArray);

                    break;
                case 'Disable':
                    $dataArray  =   ['status'=>'Enable'];
                    CoursesModel::where('id','=',$idCourses)->update($dataArray);

                    break;

            }

            return json_encode("success");
        }
        else{
            return json_encode("invalid_user");
        }
    }


}
