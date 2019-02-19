
@extends('layouts.master')

@section('custom_css')
    {{--<link href="public/assets/plugins/html5-editor/bootstrap-wysihtml5.css" rel="stylesheet">--}}

    <link href="../public/assets/plugins/dropify/dist/css/dropify.min.css" rel="stylesheet">
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" rel="stylesheet">--}}


    <link href="../public/assets/plugins/magicsuggest/magicsuggest.css" rel="stylesheet">




    <style>
        .error{
            color:red;
        }

        .ms-ctn .ms-sel-ctn {
            margin-left: 10px;

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
                            @include('includes.alert_message.alert_message',['error' => Session::get('error'), 'success' => Session::get('success')])

                        </div>

                    <!-- Nav tabs -->
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#info" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Information</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#contact" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Contact Details</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#images" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Images</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#seo" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">SEO Elements</span></a> </li>

                        </ul>
                        <!-- Tab panes -->
                        {{ Form::open(array('url' => 'admin/handleAddUniversity','class'=>'floating-labels m-t-40','id'=>'addUniversityForm','enctype'=>'multipart/form-data'))  }}
                            {!! Form::hidden('id', $data['idUniversity'], ['class' => 'form-control','id'=>'id']) !!}
                            <div class="tab-content">
                                <div class="tab-pane active" id="info" role="tabpanel">
                                    <div class="p-20">

                                        <div class="form-group m-b-40">
                                            {!! Form::text('university_name',$data['universityName'], ['class' => 'form-control university_name','id'=>'university_name']) !!}
                                            <span class="bar"></span>
                                            <label for="university_name">University Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-group m-b-40">

                                            @if(!empty($data['courses']))
                                                {!! Form::text('courses_name', $data['courses'], ['class' => 'form-control courses_name','id'=>'courses_name']) !!}
                                            @else
                                                {!! Form::text('courses_name', "", ['class' => 'form-control courses_name','id'=>'courses_name']) !!}

                                            @endif
                                        </div>
                                        <div class="form-group m-b-40">
                                            {{ Form::select('status', $ed, $data['status'], ['id' => 'status','class'=>'form-control p-0']) }}
                                            <span class="bar"></span>
                                            <label for="status">Status</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('admin_notes', $data['adminNotes'], ['class' => 'form-control','rows'=>4,'id'=>'admin_notes']) !!}
                                            <span class="bar"></span>
                                            <label for="admin_notes">Admin Notes</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('page_heading',$data['pageHeading'], ['class' => 'form-control','id'=>'page_heading']) !!}
                                            <span class="bar"></span>
                                            <label for="page_heading">Page Heading</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('tagline', $data['tagline'], ['class' => 'form-control','id'=>'tagline']) !!}
                                            <span class="bar"></span>
                                            <label for="tagline">Tagline</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('desc1', $data['desc1'], ['class' => 'form-control','rows'=>10,'id'=>'desc1']) !!}
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('desc2', $data['desc2'], ['class' => 'form-control','rows'=>10,'id'=>'desc2']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="contact" role="tabpanel">
                                    <div class="p-20">
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('address', $data['address'], ['class' => 'form-control','rows'=>4,'id'=>'address']) !!}
                                            <span class="bar"></span>
                                            <label for="address">Address</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {{ Form::select('country', $data['countries'], $data['country'], ['id' => 'country','class'=>'form-control p-0 country']) }}
                                            <span class="bar"></span>
                                            <label for="country">Country </label>
                                        </div>
                                        <div class="form-group m-b-40 state_div">
                                            @if(isset($data['state']))  {!! Form::hidden('state_hidden', $data['state'], ['class' => 'form-control','id'=>'state_hidden']) !!}    @endif
                                            {{ Form::select('state', [],19, ['id' => 'state','class'=>'form-control p-0 state']) }}
                                            <span class="bar"></span>
                                            <label for="state">State </label>
                                        </div>
                                        <div class="form-group m-b-40 city_div">
                                            @if(isset($data['city']))  {!! Form::hidden('city_hidden', $data['city'], ['class' => 'form-control','id'=>'city_hidden']) !!}    @endif

                                            {{ Form::select('city', [], $data['city'], ['id' => 'city','class'=>'form-control p-0 city']) }}
                                            <span class="bar"></span>
                                            <label for="city">City </label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('land_phone', $data['landline'], ['class' => 'form-control','id'=>'land_phone']) !!}
                                            <span class="bar"></span>
                                            <label for="land_phone">Landline</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('alt_land_phone', $data['altLandline'], ['class' => 'form-control','id'=>'alt_land_phone']) !!}
                                            <span class="bar"></span>
                                            <label for="alt_land_phone">Landline (Alternate)</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('mobile', $data['mobile'], ['class' => 'form-control','id'=>'mobile']) !!}
                                            <span class="bar"></span>
                                            <label for="mobile">Mobile</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('alt_mobile', $data['altMobile'], ['class' => 'form-control','id'=>'alt_mobile']) !!}
                                            <span class="bar"></span>
                                            <label for="alt_mobile">Mobile (Alternate)</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('email', $data['email'], ['class' => 'form-control','id'=>'email']) !!}
                                            <span class="bar"></span>
                                            <label for="email">Email</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('alt_email', $data['altEmail'], ['class' => 'form-control','id'=>'alt_email']) !!}
                                            <span class="bar"></span>
                                            <label for="alt_email">Email (Alternate)</label>
                                        </div>


                                    </div>
                                </div>
                                <div class="tab-pane" id="images" role="tabpanel">
                                    <div class="p-20">
                                        <div class="form-group m-b-40">
                                            <h3 class="card-title">Featured Image</h3>
                                        </div>
                                        @if(!empty($data['featuredImage']))
                                            <div class="form-group m-b-40 m-t-40">
                                                <img src="../{{$data['featuredImage']}}" height="250" width="auto" class="feature_preview">
                                            </div>
                                        @endif

                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_name', $data['featuredImgName'], ['class' => 'form-control ','id'=>'featured_image_name']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_name">Image Name</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_alt', $data['featuredImgAlt'], ['class' => 'form-control ','id'=>'featured_image_alt']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_alt">Alternative</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_desc', $data['featuredImgDesc'], ['class' => 'form-control ','id'=>'featured_image_desc']) !!}
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
                                         @if(!empty($data['thumbImage']))
                                             <div class="form-group m-b-40 m-t-40">
                                                 <img src="../{{$data['thumbImage']}}" height="250" width="auto" class="thumb_preview">
                                             </div>
                                         @endif

                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_name', $data['thumbImgName'], ['class' => 'form-control ','id'=>'thumb_image_name']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_name">Image Name</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_alt',  $data['thumbImgAlt'], ['class' => 'form-control ','id'=>'thumb_image_alt']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_alt">Alternative</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_desc',  $data['thumbImgDesc'], ['class' => 'form-control ','id'=>'thumb_image_desc']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_desc">Description</label>
                                        </div>
                                        <div class="form-group m-b-40 m-t-40">
                                            <input type="file" name="thumb_image" id="thumb_image" class="dropify"  data-max-file-size="2M" />

                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="seo" role="tabpanel">
                                    <div class="p-20">
                                        <div class="form-group m-b-40">
                                            {!! Form::text('title', $data['title'], ['class' => 'form-control','id'=>'title']) !!}
                                            <span class="bar"></span>
                                            <label for="title">Title</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('keywords', $data['keywords'], ['class' => 'form-control','id'=>'keywords']) !!}
                                            <span class="bar"></span>
                                            <label for="keywords">Keywords</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('url', $data['url'], ['class' => 'form-control','id'=>'url']) !!}
                                            <span class="bar"></span>
                                            <label for="url">Url</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('desc',$data['description'], ['class' => 'form-control','rows'=>4,'id'=>'desc']) !!}
                                            <span class="bar"></span>
                                            <label for="desc">Description</label>
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

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>--}}

<script src="../public/assets/plugins/magicsuggest/magicsuggest.js"></script>



<script src="../public/assets/js/admin/university/university-add.js"></script>

<script>

    /* $('#framework').multiselect({
         nonSelectedText: 'Select Framework',
         enableFiltering: false,
         enableCaseInsensitiveFiltering: true,
         buttonWidth:'400px'
     });*/
</script>

@endsection
