
@extends('layouts.master')

@section('custom_css')
    {{--<link href="public/assets/plugins/html5-editor/bootstrap-wysihtml5.css" rel="stylesheet">--}}

    <link href="../public/assets/plugins/dropify/dist/css/dropify.min.css" rel="stylesheet">

    <style>
        .error{
            color:red;
        }
        .dropify-wrapper{
            margin-top:16px;
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
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#contents" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Contents</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#info" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Info</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#images" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Images</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#seo" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">SEO Elements</span></a> </li>
                        </ul>

                        {{ Form::open(array('url' => 'admin/handleAddStreamContents','class'=>'floating-labels','id'=>'addStreamForm','enctype'=>'multipart/form-data'))  }}
                        {!! Form::hidden('id_stream', $streamData['idStream'], ['class' => 'form-control','id'=>'id_stream']) !!}
                            <div class="tab-content tabcontent-border">
                                <div class="tab-pane  active" id="contents" role="tabpanel">
                                    <div class="p-20">
                                        <div class="form-group m-b-40 m-t-40">
                                            {!! Form::text('stream_name', $streamData["streamName"], ['class' => 'form-control','id'=>'stream_name']) !!}
                                            <span class="bar"></span>
                                            <label for="stream_name">Stream Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('page_heading', $streamData["pageHeading"], ['class' => 'form-control','id'=>'page_heading']) !!}

                                            {{--<input type="text" class="form-control" id="page_heading">--}}
                                            <span class="bar"></span>
                                            <label for="page_heading">Page Heading</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('tagline', $streamData["tagline"], ['class' => 'form-control','id'=>'tagline']) !!}
                                            <span class="bar"></span>
                                            <label for="tagline">Tagline</label>
                                        </div>

                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('desc1', $streamData["desc1"], ['class' => 'form-control','rows'=>10,'id'=>'desc1']) !!}
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::textarea('desc2', $streamData["desc2"], ['class' => 'form-control','rows'=>10,'id'=>'desc2']) !!}
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane  p-20" id="seo" role="tabpanel">
                                    {{--{{ Form::open(array('url' => 'admin/handleAddStreamSeo','class'=>'floating-labels m-t-40'))  }}--}}

                                    {{--<form class="floating-labels m-t-40">--}}
                                    <div class="form-group m-b-40 m-t-40">
                                        {!! Form::text('title', $streamData["title"], ['class' => 'form-control','id'=>'title']) !!}

                                        {{--<input type="text" class="form-control" id="title" name="title">--}}
                                        <span class="bar"></span>
                                        <label for="title">Title</label>
                                    </div>
                                    <div class="form-group m-b-40">
                                        {!! Form::text('keywords', $streamData["keywords"], ['class' => 'form-control','id'=>'keywords']) !!}

                                        {{--<input type="text" class="form-control" id="page_heading">--}}
                                        <span class="bar"></span>
                                        <label for="keywords">Keywords</label>
                                    </div>
                                    <div class="form-group m-b-40">
                                        {!! Form::text('url', $streamData["url"], ['class' => 'form-control','id'=>'url']) !!}

                                        {{--<input type="text" class="form-control" id="tagline">--}}
                                        <span class="bar"></span>
                                        <label for="url">Url</label>
                                    </div>

                                    <div class="form-group m-b-40">
                                        {!! Form::textarea('desc', $streamData["description"], ['class' => 'form-control','rows'=>4,'id'=>'desc']) !!}

                                        {{--<textarea class="form-control" rows="4" id="desc1"></textarea>--}}
                                        <span class="bar"></span>
                                        <label for="desc">Description</label>
                                    </div>


                                </div>
                                <div class="tab-pane  p-20" id="info" role="tabpanel">

                                    <div class="form-group m-b-40 m-t-40">
                                        {{ Form::select('status', $ed, $streamData["status"], ['id' => 'status','class'=>'form-control p-0']) }}
                                        <span class="bar"></span>
                                        <label for="status">Active Status</label>
                                    </div>
                                    <div class="form-group m-b-40">
                                        {!! Form::textarea('admin_notes', $streamData["adminNotes"], ['class' => 'form-control','rows'=>4,'id'=>'admin_notes']) !!}

                                        {{--<textarea class="form-control" rows="4" id="desc1"></textarea>--}}
                                        <span class="bar"></span>
                                        <label for="admin_notes">Admin Notes</label>
                                    </div>


                                </div>
                                <div class="tab-pane" id="images" role="tabpanel">
                                    <div class="p-20">
                                        {{--Starts: Featured Image--}}
                                        <div class="row m-t-40">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <h3>Featured Image</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="p-20"></span>
                                        @if(!empty($streamData['featuredImage']))
                                            <div class="form-group m-b-40 ">
                                                <img src="../{{$streamData['featuredImage']}}" height="250" width="auto" class="feature_preview">
                                            </div>
                                            <span class="p-20"></span>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="file" name="featured_image" id="featured_image" class="dropify"  data-max-file-size="2M" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group m-b-40">
                                                    {!! Form::text('featured_image_name', $streamData['featuredImgName'], ['class' => 'form-control ','id'=>'featured_image_name']) !!}
                                                    <span class="bar"></span>
                                                    <label for="featured_image_name">Image Name</label>
                                                </div>
                                                <div class="form-group m-b-40">
                                                    {!! Form::text('featured_image_alt', $streamData['featuredImgAlt'], ['class' => 'form-control ','id'=>'featured_image_alt']) !!}
                                                    <span class="bar"></span>
                                                    <label for="featured_image_alt">Alternative</label>
                                                </div>
                                                <div class="form-group m-b-40">
                                                    {!! Form::text('featured_image_desc', $streamData['featuredImgDesc'], ['class' => 'form-control ','id'=>'featured_image_desc']) !!}
                                                    <span class="bar"></span>
                                                    <label for="featured_image_desc">Description</label>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="p-20"></span>
                                        {{--Ends: Thumb image--}}

                                        {{--Starts: Thumb image section --}}
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <h3>Thumb Image</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="p-20"></span>

                                        @if(!empty($streamData['thumbImage']))
                                            <div class="form-group m-b-40 m-t-40">
                                                <img src="../{{$streamData['thumbImage']}}" height="250" width="auto" class="thumb_preview">
                                            </div>
                                        @endif

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="file" name="thumb_image" id="thumb_image" class="dropify"  data-max-file-size="2M" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group m-b-40">
                                                    {!! Form::text('thumb_image_name', $streamData['thumbImgName'], ['class' => 'form-control ','id'=>'thumb_image_name']) !!}
                                                    <span class="bar"></span>
                                                    <label for="thumb_image_name">Image Name</label>
                                                </div>
                                                <div class="form-group m-b-40">
                                                    {!! Form::text('thumb_image_alt',  $streamData['thumbImgAlt'], ['class' => 'form-control ','id'=>'thumb_image_alt']) !!}
                                                    <span class="bar"></span>
                                                    <label for="thumb_image_alt">Alternative</label>
                                                </div>
                                                <div class="form-group m-b-40">
                                                    {!! Form::text('thumb_image_desc',  $streamData['thumbImgDesc'], ['class' => 'form-control ','id'=>'thumb_image_desc']) !!}
                                                    <span class="bar"></span>
                                                    <label for="thumb_image_desc">Description</label>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="p-20"></span>

                                        {{--Ends: Thumb image section--}}

                                    </div>
                                </div>

                                <div class="form-group m-b-1 col-sm-4 mx-auto">
                                    <div class=" btn-div">
                                        <input type="submit" class="btn btn-block btn-outline-success logo_save_btn" value="Save"></input>
                                    </div>
                                </div>
                        </div>

                        {{ Form::close() }}

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
    <script src="../public/assets/js/admin/streams/streams-add.js"></script>

@endsection
