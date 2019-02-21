
@extends('layouts.master')

@section('custom_css')
    <link href="../public/assets/plugins/dropify/dist/css/dropify.min.css" rel="stylesheet">
    <link href="../public/assets/plugins/Magnific-Popup-master/dist/magnific-popup.css" rel="stylesheet">

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
                        <ul class="nav nav-tabs customtab m-t-30 m-b-30" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#logo" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Logo</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#images" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Images</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#brouchers" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Brouchers</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#gallery" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Gallery</span></a> </li>

                        </ul>
                        <!-- Tab panes -->

                        <div class="tab-content br-n pn">
                            <div class="tab-pane active" id="logo" role="tabpanel">
                                {{ Form::open(array('url' => 'admin/handleLogoUploads','class'=>'floating-labels m-t-40','id'=>'addLogoForm','enctype'=>'multipart/form-data'))  }}
                                    <div class="p-20">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="focused m-b-40">
                                                        {{ Form::select('university', $universityData, '', ['id' => 'university','class'=>'form-control p-0 university']) }}
                                                        <span class="bar"></span>
                                                        <label for="university">University <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="p-20"></span>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="file" name="file" id="logo_image" class="dropify"  data-max-file-size="2M" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
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
                                                    {!! Form::text('image_name1', '', ['class' => 'form-control image_name','id'=>'image_name1']) !!}
                                                    <span class="bar"></span>
                                                    <label for="logo_image_name">Image Name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-1 col-sm-4 mx-auto">
                                            <div class=" btn-div">
                                                <input type="submit" class="btn btn-block btn-outline-success logo_save_btn" value="Save"></input>
                                            </div>
                                        </div>
                                    </div>
                                {{ Form::close()}}
                            </div>
                            <div class="tab-pane" id="images" role="tabpanel">
                                {{ Form::open(array('url' => 'admin/handleUniversityImagesUploads','class'=>'floating-labels m-t-40','id'=>'addUniversityImages','enctype'=>'multipart/form-data'))  }}
                                    {!! Form::hidden('media_div_count_hidden', 1 , ['class' => 'media_div_count_hidden','id'=>'media_div_count_hidden']) !!}

                                    <div class="p-20">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="focused m-b-40">
                                                        {{ Form::select('university', $universityData, '', ['id' => 'university','class'=>'form-control p-0 university']) }}
                                                        <span class="bar"></span>
                                                        <label for="university">University <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="p-20"></span>

                                        <div class="media_main_div">
                                            <div class="media_sub_div" id="media_sub_div1">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="file" name="file1" id="image1" class="dropify"  data-max-file-size="2M" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group m-b-40">
                                                            {!! Form::text('image_name1', '', ['class' => 'form-control image_name','id'=>'image_name1']) !!}
                                                            <span class="bar"></span>
                                                            <label for="logo_image_name">Image Name</label>
                                                        </div>
                                                        <div class="form-group m-b-40">
                                                            {!! Form::text('image_alt1', '', ['class' => 'form-control image_alt','id'=>'image_alt1']) !!}
                                                            <span class="bar"></span>
                                                            <label for="logo_image_alt">Alternative</label>
                                                        </div>
                                                        <div class="form-group m-b-40">
                                                            {!! Form::text('image_desc1', '', ['class' => 'form-control ','id'=>'image_desc1']) !!}
                                                            <span class="bar"></span>
                                                            <label for="image_desc1">Description</label>
                                                        </div>
                                                        <div class="form-group text-right add_btn_div">
                                                            <a href="" class="btn btn-blue waves-effect waves-light btn-rounded btn-outline-warning add_new" id="add_new"><i class="fa fa-plus"> Add New </i></a>
                                                            {{--<input  type="button" class="btn btn-blue waves-effect waves-light btn-rounded btn-outline-warning add_new" id="add_new" style="border-color:none" value="Add New"/>--}}
                                                        </div>
                                                    </div>
                                                    <span class="p-20"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group m-b-1 col-sm-4 mx-auto">
                                            <div class=" btn-div">
                                                <input type="submit" class="btn btn-block btn-outline-success image_save_btn" value="Save"></input>
                                            </div>
                                        </div>
                                    </div>
                                {{ Form::close()}}
                            </div>
                            <div class="tab-pane" id="brouchers" role="tabpanel">
                                {{ Form::open(array('url' => 'admin/handleUniversityBroucherUploads','class'=>'floating-labels m-t-40','id'=>'addUniversityBroucher','enctype'=>'multipart/form-data'))  }}
                                    <div class="p-20">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="focused m-b-40">
                                                        {{ Form::select('university', $universityData, '', ['id' => 'university','class'=>'form-control p-0 university']) }}
                                                        <span class="bar"></span>
                                                        <label for="university">University <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="p-20"></span>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="file" name="file" id="broucher" class="dropify"  data-max-file-size="35M"  data-allowed-file-extensions="pdf doc docx" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group m-b-40">
                                                    {!! Form::text('name', '', ['class' => 'form-control name','id'=>'name']) !!}
                                                    <span class="bar"></span>
                                                    <label for="logo_image_name">Broucher Name</label>
                                                </div>
                                                <div class="form-group m-b-40">
                                                    {!! Form::text('description', '', ['class' => 'form-control description','id'=>'description']) !!}
                                                    <span class="bar"></span>
                                                    <label for="logo_image_alt">Description</label>
                                                </div>
                                            </div>
                                            <span class="p-20"></span>
                                        </div>
                                        <div class="form-group m-b-1 col-sm-4 mx-auto">
                                            <div class=" btn-div">
                                                <input type="submit" class="btn btn-block btn-outline-success broucher_save_btn" value="Save"></input>
                                            </div>
                                        </div>
                                    </div>


                                {{ Form::close() }}
                            </div>
                            <div class="tab-pane" id="gallery" role="tabpanel">
                                <form class="floating-labels m-t-40">
                                    <div class="p-20">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <div class="focused m-b-40">
                                                        {{ Form::select('university', $universityData, '', ['id' => 'university','class'=>'form-control p-0 university']) }}
                                                        <span class="bar"></span>
                                                        <label for="university">University <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span class="p-20"></span>

                                        <div class="logo_main_div"></div>
                                        <div class="gallery_main_div"></div>
                                        <div class="broucher_main_div"></div>

                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        @include('layouts.footer.footer_text')
    </div>
@endsection

@section('scripts')

<script src="../public/assets/plugins/dropify/dist/js/dropify.min.js"></script>
<script src="../public/assets/js/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

<script src="../public/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
<script src="../public/assets/plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

<script src="../public/assets/js/admin/university/university-media.js"></script>
<script src="../public/assets/js/utilities/utilities.js"></script>




@endsection
