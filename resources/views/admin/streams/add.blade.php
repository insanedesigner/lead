
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

                        <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#contents" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Contents</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#seo" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">SEO Elements</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#info" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Info</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#images" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Images</span></a> </li>

                            </ul>
                            <!-- Tab panes -->
                            {{ Form::open(array('url' => 'admin/handleAddStreamContents','class'=>'floating-labels','id'=>'addStreamForm','enctype'=>'multipart/form-data'))  }}
                                {!! Form::hidden('id_stream', $streamData['idStream'], ['class' => 'form-control','id'=>'id_stream']) !!}

                                <div class="tab-content tabcontent-border">

                                    <div class="tab-pane  active" id="contents" role="tabpanel">
                                        <div class="p-20">

                                            <div class="form-group m-b-40 m-t-40">


                                                {!! Form::text('stream_name', $streamData["streamName"], ['class' => 'form-control','id'=>'stream_name']) !!}

                                                {{--<input type="text" class="form-control" id="stream_name" name="stream_name">--}}
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
                                                {{ Form::select('active_status', ['Enable'=>'Enable','Disable'=>'Disable'], $streamData["status"], ['id' => 'active_status','class'=>'form-control p-0']) }}
                                                <span class="bar"></span>
                                                <label for="active_status">Active Status</label>
                                            </div>
                                            <div class="form-group m-b-40">
                                                {!! Form::textarea('admin_notes', $streamData["adminNotes"], ['class' => 'form-control','rows'=>4,'id'=>'admin_notes']) !!}

                                                {{--<textarea class="form-control" rows="4" id="desc1"></textarea>--}}
                                                <span class="bar"></span>
                                                <label for="admin_notes">Admin Notes</label>
                                            </div>


                                    </div>
                                    <div class="tab-pane p-20" id="images" role="tabpanel">
                                        <div class="form-group m-b-40 m-t-40">
                                            <h3 class="card-title">Featured Image Upload </h3>
                                            {{--<label for="input-file-max-fs">You can add a max file size</label>--}}
                                            {{--<input type="file" name="featured_image" id="featured_image" class="dropify"  data-max-file-size="2M" />--}}

                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_name', '', ['class' => 'form-control ','id'=>'featured_image_name']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_name">Image Name</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_alt', '', ['class' => 'form-control ','id'=>'featured_image_alt']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_alt">Alternate</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('featured_image_desc', '', ['class' => 'form-control ','id'=>'featured_image_desc']) !!}
                                            <span class="bar"></span>
                                            <label for="featured_image_desc">Description</label>
                                        </div>
                                        <div class="form-group m-b-40 m-t-40">
                                            <input type="file" name="featured_image" id="featured_image" class="dropify"  data-max-file-size="2M" value="<img src='../public/assets/images/users/2.jpg'></img>" />

                                        </div>

                                        <span class="p-20"></span>

                                        <div class="form-group m-b-40 m-t-40">
                                            <h3 class="card-title">Thumb Image Upload </h3>
                                            {{--<label for="input-file-max-fs">You can add a max file size</label>--}}
                                            {{--<input type="file" name="featured_image" id="featured_image" class="dropify"  data-max-file-size="2M" />--}}

                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_name', '', ['class' => 'form-control ','id'=>'thumb_image_name']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_name">Image Name</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_alt', '', ['class' => 'form-control ','id'=>'thumb_image_alt']) !!}
                                            <span class="bar"></span>
                                            <label for="thumb_image_alt">Alternate</label>
                                        </div>
                                        <div class="form-group m-b-40">
                                            {!! Form::text('thumb_image_desc', '', ['class' => 'form-control ','id'=>'thumb_image_desc']) !!}
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
                            {{Form::close()}}
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <footer class="footer"> © 2017 Admin Press Admin by themedesigner.in </footer>

    </div>




@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5.0.0/tinymce.min.js"></script>
    <script src="../public/assets/plugins/dropify/dist/js/dropify.min.js"></script>
    <script src="../public/assets/js/jquery.validate.min.js"></script>
    <script src="http://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js"></script>


    {{--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js"></script>--}}
    <script src="../public/assets/js/admin/streams-add.js"></script>

@endsection
