
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


                        {{ Form::open(array('url' => 'admin/handleAddLeadType','class'=>'floating-labels m-t-40','id'=>'addLeadType','enctype'=>'multipart/form-data'))  }}
                        {{ Form::hidden('id_lead_hidden', '', ['id' => 'id_lead_hidden','class'=>'form-control p-0 id_lead_hidden']) }}

                        <div class="p-20">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('name', $data['leadTypeName'], ['id' => 'name','class'=>'form-control p-0 name']) }}
                                                <span class="bar"></span>
                                                <label for="agency_name">Lead Type Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('cost_per_lead',$data['costPerLead'], ['id' => 'cost_per_lead','class'=>'form-control p-0 cost_per_lead']) }}
                                                <span class="bar"></span>
                                                <label for="cost_per_lead">Cost / Lead </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group m-b-1 col-sm-4 mx-auto">
                                        <div class="btn-div">
                                            <input type="submit" class="btn btn-block btn-outline-success save_btn" value="Save"></input>
                                        </div>
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
    <script src="../public/assets/js/admin/lead/lead-type-add.js"></script>

@endsection
