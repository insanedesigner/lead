
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
                        <div class="card-body p-b-0">
                             </div>
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#logo" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Logo</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#images" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Images</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#brouchers" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Brouchers</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#gallery" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Gallery</span></a> </li>

                        </ul>
                        <!-- Tab panes -->
                        {{ Form::open(array('url' => 'admin/handleAddCourses','class'=>'floating-labels m-t-40','id'=>'addUniversityForm','enctype'=>'multipart/form-data'))  }}
                            {!! Form::hidden('id_university', '', ['class' => 'form-control','id'=>'id_university']) !!}
                            <div class="tab-content">


                                <div class="tab-pane active" id="logo" role="tabpanel">
                                    <div class="p-20">
                                        <div class="form-group m-b-40">
                                            <h3 class="card-title">Logo Image</h3>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('logo_image_name', '', ['class' => 'form-control ','id'=>'logo_image_name']) !!}
                                            <span class="bar"></span>
                                            <label for="logo_image_name">Image Name</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('logo_image_alt', '', ['class' => 'form-control ','id'=>'logo_image_alt']) !!}
                                            <span class="bar"></span>
                                            <label for="logo_image_alt">Alternative</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('logo_image_desc', '', ['class' => 'form-control ','id'=>'logo_image_desc']) !!}
                                            <span class="bar"></span>
                                            <label for="logo_image_desc">Description</label>
                                        </div>

                                        <div class="form-group m-b-40 m-t-40">
                                            <input type="file" name="featured_image" id="featured_image" class="dropify"  data-max-file-size="2M" />
                                        </div>
                                        <span class="p-20"></span>

                                        <div class="form-group m-b-40">
                                            <h3 class="card-title">Featured Image</h3>
                                        </div>
                                        @if(!empty($coursesData['featuredImage']))
                                            <div class="form-group m-b-40 m-t-40">
                                                <img src="../{{$coursesData['featuredImage']}}" height="250" width="auto" class="feature_preview">
                                            </div>
                                        @endif

                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_name', '', ['class' => 'form-control ','id'=>'featured_image_name']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_name">Image Name</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_alt', '', ['class' => 'form-control ','id'=>'featured_image_alt']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_alt">Alternative</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_desc', '', ['class' => 'form-control ','id'=>'featured_image_desc']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_desc">Description</label>
                                        </div>
                                        <div class="form-group m-b-40 m-t-40">
                                            <input type="file" name="featured_image" id="featured_image" class="dropify"  data-max-file-size="2M" />
                                        </div>

                                        <span class="p-20"></span>

                                        <div class="form-group m-b-40">
                                            <h3 class="card-title">Thumb Image</h3>
                                        </div>
                                         @if(!empty($coursesData['thumbImage']))
                                             <div class="form-group m-b-40 m-t-40">
                                                 <img src="../{{$coursesData['thumbImage']}}" height="250" width="auto" class="thumb_preview">
                                             </div>
                                         @endif

                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_name', '', ['class' => 'form-control ','id'=>'thumb_image_name']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_name">Image Name</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_alt',  '', ['class' => 'form-control ','id'=>'thumb_image_alt']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_alt">Alternative</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_desc',  '', ['class' => 'form-control ','id'=>'thumb_image_desc']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_desc">Description</label>
                                        </div>
                                        <div class="form-group m-b-40 m-t-40">
                                            <input type="file" name="thumb_image" id="thumb_image" class="dropify"  data-max-file-size="2M" />

                                        </div>
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
