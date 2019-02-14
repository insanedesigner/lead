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

class StreamsController extends Controller
{

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $this->commonControllerObj  =   new CommonController();
    }
    public function showAddStreams(Request $request){

        $role   =   1;
        $idRole =   1;


        $idUser             =   Session::get('users.idUser')[0];
        $userData           =   DBUtilities::getUserInformation($idUser);
        $ed                 =   BusinessKeyDetailsModel::where('key_description','=','ED')->select('id','key_value')->get()->toArray();
        $streamData         =   "";
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

        if(isset($request->id_stream)){
            //$streamFullData =   StreamsModel::join('gallery As g','streams.id','=','g.uid')->get();
            $streamData         =   StreamsModel::where('streams.id','=',$request->id_stream)->first();
            $featuredImageData      =   GalleryModel::where('uid','=',$request->id_stream)->where('category','=',2)->first();
            $thumbImageData         =   GalleryModel::where('uid','=',$request->id_stream)->where('category','=',3)->first();

        }

        //dd($featuredImageData);
        if(!empty($streamData)){
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


            $streamData =   [
                'idStream'          =>  $request->id_stream,
                'streamName'        =>  $streamData->stream_name,
                'pageHeading'       =>  $streamData->page_heading,
                'tagline'           =>  $streamData->tagline,
                'desc1'             =>  $streamData->description1,
                'desc2'             =>  $streamData->description2,
                'title'             =>  $streamData->meta_title,
                'keywords'          =>  $streamData->meta_keywords,
                'description'       =>  $streamData->meta_description,
                'url'               =>  $streamData->url,
                'status'            =>  $streamData->active_status,
                'adminNotes'        =>  $streamData->admin_notes,
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
            $streamData =   [
                'idStream'          =>  "",
                'streamName'        =>  "",
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




        $paramArray         =   [
            'pageBase'     =>  'Home',
            'pageTitle'    =>  'Add Stream',
            'browserTitle' =>   'Stream Management',
            'role'         =>   'ad',
            'idRole'       =>   1,
            'urlData'      =>   "admin/streams",
            'ed'           =>   $ed,
            'userData'     =>   $userData,
            'streamData'   =>   $streamData,
            'idScreen'     =>   3
        ];



        return view('admin.streams.add',$paramArray);

    }
    public function handleAddStreamContents(Request $request){

        $idUser                 =   Session::get('users.idUser')[0];
        $ipaddress              =   $_SERVER['SERVER_ADDR'];
        $imageUploadStatus      =   "";
        $featuredBucketName     =   "streams/featuredimage/";
        $thumbBucketName        =   "streams/thumbimage/";
        $featuredCategory       =   2;
        $thumbCategory          =   3;

        //Contents
        $streamName     =   ucwords($request->stream_name);
        $pageHeading    =   $request->page_heading;
        $tagline        =   $request->tagline;
        $desc1          =   $request->input('desc1');
        $desc2          =   $request->input('desc2');

        //SEO
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





        //Message Section
        $saveSuccessMsg     =   MessageUtilities::dataSaveSuccessMessage();
        $saveFailedMsg      =   MessageUtilities::dataSaveFailedMessage();
        $updateSuccessMsg   =   MessageUtilities::dataUpdateSuccessMessage();
        $updateFailedMsg    =   MessageUtilities::dataUpdateFailedMessage();


        if(!empty($streamName)){

            //assigning stream name to these param if they are empty
            if(empty($pageHeading)){
                $pageHeading    =   $streamName;
            }
            if(empty($title)){
                $title  =   $streamName;
            }
            if(empty($url)){
                $url    =   $streamName;
            }



            if(isset($request->id_stream)){

                $dataArray  =   [
                    'stream_name'        =>  $streamName,
                    'page_heading'       =>  $pageHeading,
                    'tagline'            =>  $tagline,
                    'description1'       =>  $desc1,
                    'description2'       =>  $desc2,
                    'meta_title'         =>  $title,
                    'meta_keywords'      =>  $keywords,
                    'url'                =>  $url,
                    'meta_description'   =>  $desc,
                    'active_status'      =>  $status,
                    'modified_by'        =>  $idUser,
                    'admin_notes'        =>  $adminNotes,
                    'modified_date'      =>  date('Y-m-d h:i"s')
                ];

                $streamData =   StreamsModel::where('id','=',$request->id_stream)->update($dataArray);

                if(!empty($streamData)){

                    $featuredImageUploadStatus  =   $this->commonControllerObj->featuredImageUpload($featuredBucketName, $featuredCategory, $request->id_stream, $_FILES['featured_image']);
                    $thumbImageUploadStatus     =   $this->commonControllerObj->thumbImageUpload($thumbBucketName, $thumbCategory, $request->id_stream, $_FILES['thumb_image']);


                    //Audit Entry
                    //------------------------------------------------------------------
                    $paramArray =   [
                        'id_user'       =>  $idUser,
                        'audit_event'   =>  'EDIT STREAM',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('showAddStreams')->with($updateSuccessMsg);
                }
                else{
                    return Redirect::route('showAddStreams')->with($updateFailedMsg);
                }
            }
            else{

                $dataArray  =   [
                    'stream_name'        =>  ucwords($streamName),
                    'page_heading'       =>  $pageHeading,
                    'tagline'            =>  $tagline,
                    'description1'       =>  $desc1,
                    'description2'       =>  $desc2,
                    'meta_title'         =>  $title,
                    'meta_keywords'      =>  $keywords,
                    'url'                =>  $url,
                    'meta_description'   =>  $desc,
                    'active_status'      =>  $status,
                    'posted_by'          =>  $idUser,
                    'admin_notes'        =>  $adminNotes,
                    'posted_date'        =>  date('Y-m-d h:i"s'),
                    'created_date'       =>  date('Y-m-d h:i"s')
                ];

                $streamData =   StreamsModel::updateOrCreate($dataArray);

                if(!empty($streamData->id)){

                    $featuredImageUploadStatus  =   $this->commonControllerObj->featuredImageUpload($featuredBucketName, $featuredCategory, $streamData->id, $_FILES['featured_image']);
                    $thumbImageUploadStatus     =   $this->commonControllerObj->thumbImageUpload($thumbBucketName, $thumbCategory, $streamData->id, $_FILES['thumb_image']);

                    //Audit Entry
                    //------------------------------------------------------------------
                    $paramArray =   [
                        'id_user'       =>  $idUser,
                        'audit_event'   =>  'ADD STREAM',
                        'ip_address'    =>  $ipaddress,
                        'id_audit'      =>  NULL,
                        'created_date'  =>  date('Y-m-d h:i:s'),
                        'edited_date'   =>  NULL

                    ];
                    $auditEntry =   AuditUtilities::putAuditInformation($paramArray);
                    //--------------------------------------------------------------------

                    return Redirect::route('showAddStreams')->with($saveSuccessMsg);
                }
                else{
                    return Redirect::route('showAddStreams')->with($saveFailedMsg);
                }
            }
        }
        else{
            $emptyFiledsMsg =   MessageUtilities::emptyFiledsMessage('Stream Name');
            return Redirect::route('showAddStreams')->with($emptyFiledsMsg);
        }



    }
    public function streamDescriptionImageUpload(){
        $bucketName     =   "streams/description/";
        $category       =   7;
        //$uploadStatus   =   $this->descriptionImageUpload($bucketName, $category, $_FILES['file'], 'jscript');
        $uploadStatus   =   $this->commonControllerObj->descriptionImageUpload($bucketName, $category, $_FILES['file'], 'jscript');

        return $uploadStatus;
    }
    public function showViewStreams(){
        $role   =   1;
        $idRole =   1;


        $idUser         =   Session::get('users.idUser')[0];
        $userData       =   DBUtilities::getUserInformation($idUser);
        $ed             =   BusinessKeyDetailsModel::where('key_description','=','ED')->select('id','key_value')->get()->toArray();
        $streamFullData =   StreamsModel::get();
        $streamActive   =   StreamsModel::where('active_status','=','Enable')->get();
        $streamInactive =   StreamsModel::where('active_status','=','Disable')->get();


        $paramArray         =   [
            'pageBase'          =>  'Home',
            'pageTitle'         =>  'View Streams',
            'browserTitle'      =>   'Stream Management',
            'role'              =>   'ad',
            'idRole'            =>   1,
            'urlData'           =>   "admin/viewstreams",
            'ed'                =>   $ed,
            'userData'          =>   $userData,
            'streamFullData'    =>   $streamFullData,
            'streamActive'      =>   $streamActive,
            'streamInactive'    =>   $streamInactive,
            'idScreen'          =>   5
        ];

        return view('admin.streams.view',$paramArray);

    }
    public function handleStreamStatusChange(Request $request){
        $idUser         =   Session::get('users.idUser')[0];
        $idStream       =   $request->id_stream;
        $status         =   $request->status;
        $ipaddress      =   $_SERVER['SERVER_ADDR'];

        if(isset($idStream)){
            switch($status){
                case 'Enable':
                    $dataArray  =   ['active_status'=>'Disable'];
                    StreamsModel::where('id','=',$idStream)->update($dataArray);

                    break;
                case 'Disable':
                    $dataArray  =   ['active_status'=>'Enable'];
                    StreamsModel::where('id','=',$idStream)->update($dataArray);
                    break;

            }
            return json_encode("success");
        }
        else{
            return json_encode("invalid_user");
        }
    }

}