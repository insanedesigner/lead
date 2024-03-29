
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
                            @include('includes.alert_message.alert_message',['error' => Session::get('error'), 'success' => Session::get('success')])
                        </div>

                        {{ Form::open(array('url' => 'admin/handleAddAgency','class'=>'floating-labels m-t-40','id'=>'addAgencyForm','enctype'=>'multipart/form-data'))  }}
                        {{ Form::hidden('id_agency_hidden', $data['idAgency'], ['id' => 'id_agency_hidden','class'=>'form-control p-0 id_agency_hidden']) }}

                        <div class="p-20">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="m-b-40">
                                            {{ Form::text('name', $data['agencyName'], ['id' => 'name','class'=>'form-control p-0 name']) }}
                                            <span class="bar"></span>
                                            <label for="agency_name">Agency Name <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="m-b-40">
                                            {{ Form::text('points', $data['points'], ['id' => 'points','class'=>'form-control p-0 points']) }}
                                            <span class="bar"></span>
                                            <label for="points">Current Points </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="m-b-40">
                                            {{ Form::text('contact_person', $data['contactPerson'], ['id' => 'contact_person','class'=>'form-control p-0 contact_person']) }}
                                            <span class="bar"></span>
                                            <label for="contact_person">Contact Person (Name)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="m-b-40">
                                            {{ Form::text('email', $data['email'], ['id' => 'email','class'=>'form-control p-0 email']) }}
                                            <span class="bar"></span>
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="m-b-40">
                                            {{ Form::text('phone', $data['phone'], ['id' => 'phone','class'=>'form-control p-0 phone']) }}
                                            <span class="bar"></span>
                                            <label for="phone">Phone</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <div class="m-b-40">
                                            {{ Form::text('website', $data['website'], ['id' => 'website','class'=>'form-control p-0 website']) }}
                                            <span class="bar"></span>
                                            <label for="website">Website</label>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="p-b-5">Remarks</div>
                                        {!! Form::textarea('remarks', $data['remarks'], ['class' => 'form-control remarks','rows'=>10,'id'=>'remarks']) !!}
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
    <script src="../public/assets/js/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

    <script src="../public/assets/js/admin/agency/agency-add.js"></script>
@endsection
