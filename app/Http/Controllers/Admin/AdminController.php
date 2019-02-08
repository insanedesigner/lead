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


//Utilities
use App\Classes\MessageUtilities;
use App\Classes\DBUtilities;
use App\Classes\FileUploadUtilities;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    /*public function showAddRole(){
        $role   =   Session::get('users.role')[0];
        $idRole =   Session::get('users.idRole')[0];

        $paramArray         =   [
            'pageBase'     =>  'Home',
            'pageTitle'    =>  'Add Role',
            'role'         =>   $role,
            'idRole'       =>   $idRole
        ];

        return view('admin.roles.add',$paramArray);

    }*/

    public function showDashboard(Request $request){
       /* $role       =   Session::get('users.role')[0];
        $idRole     =   Session::get('users.idRole')[0];
        $idUser     =   Session::get('users.idUser')[0];
        $urlData    =   DBUtilities::getActiveUrl($idRole, 1);
        $userData   =   DBUtilities::getUserInformation($idUser);


        $paramArray         =   [
            'pageBase'     =>  'Home',
            'pageTitle'    =>  'Dashboard',
            'role'         =>   $role,
            'idRole'       =>   $idRole,
            'urlData'      =>   $urlData,
            'userData'     =>   $userData
        ];

        return view('admin.dashboard',$paramArray);*/

        $idUser     =   Session::get('users.idUser')[0];
        $userData   =   DBUtilities::getUserInformation($idUser);

        $paramArray         =   [
            'pageBase'     =>  'Home',
            'pageTitle'    =>  'Dashboard',
            'browserTitle' =>   'Dashboard',
            'role'         =>   'ad',
            'idRole'       =>   1,
            'urlData'      =>   "admin/dashboard",
            'userData'     =>   $userData,
            'idScreen'     =>   1
        ];

        return view('admin.dashboard',$paramArray);




    }

    public function showAddStreams(Request $request){
        /*$role   =   Session::get('users.role')[0];
        $idRole =   Session::get('users.idRole')[0];

        $paramArray         =   [
            'pageBase'     =>  'Home',
            'pageTitle'    =>  'Add Role',
            'role'         =>   $role,
            'idRole'       =>   $idRole
        ];

        return view('admin.roles.add',$paramArray);*/


        $role   =   1;
        $idRole =   1;


        $idUser         =   Session::get('users.idUser')[0];
        $userData       =   DBUtilities::getUserInformation($idUser);
        $ed             =   BusinessKeyDetailsModel::where('key_description','=','ED')->select('id','key_value')->get()->toArray();
        $streamData     =   "";
        $streamName     =   "";
        $pageHeading    =   "";
        $tagline        =   "";
        $desc1          =   "";
        $desc2          =   "";


        if(isset($request->id_stream)){
            $streamData =   StreamsModel::where('id','=',$request->id_stream)->first();
        }
        if(!empty($streamData)){
            $streamData =   [
                'idStream'      =>  $request->id_stream,
                'streamName'    =>  $streamData->stream_name,
                'pageHeading'   =>  $streamData->page_heading,
                'tagline'       =>  $streamData->tagline,
                'desc1'         =>  $streamData->description1,
                'desc2'         =>  $streamData->description2,
                'title'         =>  $streamData->meta_title,
                'keywords'      =>  $streamData->meta_keywords,
                'description'   =>  $streamData->meta_description,
                'url'           =>  $streamData->url,
                'status'        =>  $streamData->active_status,
                'adminNotes'    =>  $streamData->admin_notes
            ];
        }
        else{
            $streamData =   [
                'idStream'      =>  "",
                'streamName'    =>  "",
                'pageHeading'   =>  "",
                'tagline'       =>  "",
                'desc1'         =>  "",
                'desc2'         =>  "",
                'title'         =>  "",
                'keywords'      =>  "",
                'description'   =>  "",
                'url'           =>  "",
                'status'        =>  "",
                'adminNotes'    =>  ""
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

    public function streamDescriptionImageUpload(){
        $basePath       =   "public/assets/images/";
        $bucketName     =   "streams/description/";
        $targetDir      =   $basePath.$bucketName;
        $uploadStatus   =   FileUploadUtilities::imageUploader($targetDir, $_FILES['file'],'jscript');

        return $uploadStatus;

//        echo json_encode(array('location' => $filetowrite));
    }

    public function streamFeatureThumbImageUpload(Request $request){

        $basePath       =   $request->base_path;
        $bucketName     =   $request->bucket_name;
        $targetDir      =   $basePath.$bucketName;
        $inputImageName =   $request->image_name;

        $_FILES['file']['input_image_name'] =   $inputImageName;


        $uploadStatus   =   FileUploadUtilities::imageUploader($targetDir, $_FILES);



        return $uploadStatus;
    }

    public function handleAddStreamContents(Request $request){

        $idUser         =   Session::get('users.idUser')[0];

        $streamName     =   ucwords($request->stream_name);
        $pageHeading    =   $request->page_heading;
        $tagline        =   $request->tagline;
        $desc1          =   $request->input('desc1');
        $desc2          =   $request->input('desc2');

        $title          =   $request->title;
        $keywords       =   $request->keywords;
        $url            =   $request->url;
        $desc           =   $request->desc;

        $status         =   $request->active_status;
        $adminNotes     =   $request->admin_notes;

        $featuredNewImgName     =   $request->featured_image_name;
        $featuredImgAlt         =   $request->featured_image_alt;
        $featuredImgDesc        =   $request->featured_image_desc;
        $thumbNewImgName        =   $request->thumb_image_name;
        $thumbImgAlt            =   $request->thumb_image_alt;
        $thumbImgDesc           =   $request->thumb_image_desc;

        $_FILES['featured_image']['image_new_name']   =   $featuredNewImgName;
        $_FILES['thumb_image']['image_new_name']      =   $thumbNewImgName;

        $imageUploadStatus      =   "";



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

                $streamData =   StreamsModel::where('id','=',$request->id_stream)->updateOrCreate($dataArray);

                if(!empty($streamData->id)){
                    //$featuredImageUploadStatus  =   $this->streamFeaturedImageUpload($streamData->id, $_FILES['featured_image']);
                    //$thumbImageUploadStatus     =   $this->streamThumbImageUpload($streamData->id, $_FILES['thumb_image']);


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
                    $featuredImageUploadStatus  =   $this->streamFeaturedImageUpload($streamData->id, $_FILES['featured_image']);
                    $thumbImageUploadStatus     =   $this->streamThumbImageUpload($streamData->id, $_FILES['thumb_image']);

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
        $idStream   =   $request->id_stream;
        $status     =   $request->status;

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


    public function streamFeaturedImageUpload($idStream, $image)
    {
        $basePath = "public/assets/images/";
        $bucketName = "streams/featuredimage/";
        $targetPath = $basePath . $bucketName;

        $uploadStatus = FileUploadUtilities::imageUploader($targetPath, $image, 'pscript');

        if ($uploadStatus['status'] == 'upload_success') {
            $dataArray = [
                'base_path' => $basePath,
                'bucket_name' => $bucketName,
                'filename' => $uploadStatus['filename'],
                'uid' => $idStream,
                'created_date' => date('Y-m-d h:i:s')
            ];

            GalleryModel::insert($dataArray);
        }
    }
    public function streamThumbImageUpload($idStream, $image)
    {
        $basePath   =   "public/assets/images/";
        $bucketName =   "streams/thumbimage/";
        $targetPath =   $basePath.$bucketName;


        $uploadStatus   =   FileUploadUtilities::imageUploader($targetPath, $image, 'pscript');

        if ($uploadStatus['status'] == 'upload_success') {
            $dataArray = [
                'base_path'     =>  $basePath,
                'bucket_name'   =>  $bucketName,
                'filename'      =>  $uploadStatus['filename'],
                'uid'           =>  $idStream,
                'created_date'  =>  date('Y-m-d h:i:s')
            ];

            GalleryModel::insert($dataArray);
        }
    }









}
