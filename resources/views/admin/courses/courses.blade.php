
@extends('layouts.master')

@section('custom_css')
    {{--<link href="public/assets/plugins/html5-editor/bootstrap-wysihtml5.css" rel="stylesheet">--}}

    <link href="../public/assets/plugins/dropify/dist/css/dropify.min.css" rel="stylesheet">

    <style>
        .error{
            color:red;
        }
    </style>

@endsection

@section('content')
    <div class="page-wrapper">
        @include('layouts.header.breadcrumps')

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            @include('includes.alert_message.alert_message',['error' => Session::get('error'), 'success' => Session::get('success')])

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#contents" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Contents</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#seo" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">SEO Elements</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#info" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Info</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#images" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Images</span></a> </li>

                            </ul>

                            {{ Form::open(array('url' => 'admin/handleAddCourses','class'=>'floating-labels','id'=>'addCoursesForm','enctype'=>'multipart/form-data'))  }}
                                {!! Form::hidden('id_courses', $coursesData['idCourses'], ['class' => 'form-control','id'=>'id_courses']) !!}

                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane  p-20 active" id="contents" role="tabpanel">
                                        <div class="form-group m-b-40 m-t-40">
                                            {{ Form::select('id_category', $categoryData, $coursesData['idCategory'], ['id' => 'id_category','class'=>'form-control p-0 id_category']) }}
                                            <span class="bar"></span>
                                            <label for="id_stream">Courses Category <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-group m-b-40 m-t-40">
                                            {!! Form::text('courses_name', $coursesData['coursesName'], ['class' => 'form-control','id'=>'courses_name']) !!}
                                            <span class="bar"></span>
                                            <label for="courses_name">Courses Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('page_heading',$coursesData['pageHeading'], ['class' => 'form-control','id'=>'page_heading']) !!}
                                            <span class="bar"></span>
                                            <label for="page_heading">Page Heading</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('tagline', $coursesData['tagline'], ['class' => 'form-control','id'=>'tagline']) !!}
                                            <span class="bar"></span>
                                            <label for="tagline">Tagline</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('desc1', $coursesData['desc1'], ['class' => 'form-control','rows'=>10,'id'=>'desc1']) !!}
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('desc2', $coursesData['desc2'], ['class' => 'form-control','rows'=>10,'id'=>'desc2']) !!}
                                        </div>
                                    </div>
                                    <div class="tab-pane  p-20" id="seo" role="tabpanel">
                                        <div class="form-group m-b-40 m-t-40">
                                            {!! Form::text('title', $coursesData['title'], ['class' => 'form-control','id'=>'title']) !!}
                                            <span class="bar"></span>
                                            <label for="title">Title</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('keywords', $coursesData['keywords'], ['class' => 'form-control','id'=>'keywords']) !!}
                                            <span class="bar"></span>
                                            <label for="keywords">Keywords</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('url', $coursesData['url'], ['class' => 'form-control','id'=>'url']) !!}
                                            <span class="bar"></span>
                                            <label for="url">Url</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('desc', $coursesData['description'], ['class' => 'form-control','rows'=>4,'id'=>'desc']) !!}
                                            <span class="bar"></span>
                                            <label for="desc">Description</label>
                                        </div>
                                    </div>
                                    <div class="tab-pane  p-20" id="info" role="tabpanel">

                                        <div class="form-group m-b-40 m-t-40">
                                            {{ Form::select('active_status', ['Enable'=>'Enable','Disable'=>'Disable'], $coursesData['status'], ['id' => 'active_status','class'=>'form-control p-0']) }}
                                            <span class="bar"></span>
                                            <label for="active_status">Active Status</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('admin_notes', $coursesData['adminNotes'], ['class' => 'form-control','rows'=>4,'id'=>'admin_notes']) !!}
                                            <span class="bar"></span>
                                            <label for="admin_notes">Admin Notes</label>
                                        </div>


                                    </div>
                                    <div class="tab-pane p-20" id="images" role="tabpanel">
                                        <div class="form-group m-b-40 m-t-40">
                                            <h3 class="card-title">Featured Image Upload </h3>
                                        </div>
                                        @if(!empty($coursesData['featuredImage']))
                                            <div class="form-group m-b-40 m-t-40">
                                                <img src="../{{$coursesData['featuredImage']}}" height="250" width="auto" class="feature_preview">
                                            </div>
                                        @endif

                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_name', $coursesData['featuredImgName'], ['class' => 'form-control ','id'=>'featured_image_name']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_name">Image Name</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_alt', $coursesData['featuredImgAlt'], ['class' => 'form-control ','id'=>'featured_image_alt']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_alt">Alternative</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_desc', $coursesData['featuredImgDesc'], ['class' => 'form-control ','id'=>'featured_image_desc']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_desc">Description</label>
                                        </div>
                                        <div class="form-group m-b-40 m-t-40">
                                            <input type="file" name="featured_image" id="featured_image" class="dropify"  data-max-file-size="2M" />
                                        </div>

                                        <span class="p-20"></span>

                                        <div class="form-group m-b-40 m-t-40">
                                            <h3 class="card-title">Thumb Image Upload </h3>
                                        </div>
                                        @if(!empty($coursesData['thumbImage']))
                                            <div class="form-group m-b-40 m-t-40">
                                                <img src="../{{$coursesData['thumbImage']}}" height="250" width="auto" class="thumb_preview">
                                            </div>
                                        @endif

                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_name', $coursesData['thumbImgName'], ['class' => 'form-control ','id'=>'thumb_image_name']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_name">Image Name</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_alt',  $coursesData['thumbImgAlt'], ['class' => 'form-control ','id'=>'thumb_image_alt']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_alt">Alternative</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_desc',  $coursesData['thumbImgDesc'], ['class' => 'form-control ','id'=>'thumb_image_desc']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_desc">Description</label>
                                        </div>
                                        <div class="form-group m-b-40 m-t-40">
                                            <input type="file" name="thumb_image" id="thumb_image" class="dropify"  data-max-file-size="2M" />

                                        </div>
                                    </div>

                                    <div class="form-group m-b-1 col-sm-4 mx-auto">
                                        <div class=" btn-div">
                                            <input type="submit" class="btn btn-block btn-outline-success save_btn" value="Save"></input>
                                        </div>
                                    </div>

                                </div>
                            {{ Form::close()}}



                        </div>
                    </div>
                </div>
            </div>
        </div>




@include('layouts.footer.footer_text')

</div>




@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@5.0.0/tinymce.min.js"></script>
<script src="../public/assets/plugins/dropify/dist/js/dropify.min.js"></script>
<script src="../public/assets/js/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>


{{--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js"></script>--}}
<script src="../public/assets/js/admin/courses/courses-add.js"></script>

@endsection
