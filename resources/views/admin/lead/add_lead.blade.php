
@extends('layouts.master')

@section('custom_css')
    {{--<link href="public/assets/plugins/html5-editor/bootstrap-wysihtml5.css" rel="stylesheet">--}}



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


                        {{ Form::open(array('url' => 'admin/handleAddLead','class'=>'floating-labels','id'=>'addLeadForm','enctype'=>'multipart/form-data'))  }}
                        {{ Form::hidden('id_lead_hidden', '', ['id' => 'id_lead_hidden','class'=>'form-control p-0 id_lead_hidden']) }}

                            <div class="p-20">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('name', $data['leadName'], ['id' => 'name','class'=>'form-control p-0 name']) }}
                                                <span class="bar"></span>
                                                <label for="name">Lead Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('email',$data['email'], ['id' => 'email','class'=>'form-control p-0 email']) }}
                                                <span class="bar"></span>
                                                <label for="email">Email </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('phone', $data['phone'], ['id' => 'name','class'=>'form-control p-0 phone']) }}
                                                <span class="bar"></span>
                                                <label for="phone">Phone </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::select('lead_type',$leadTypeData, $data['leadType'], ['id' => 'lead_type','class'=>'form-control p-0 lead_type']) }}
                                                <span class="bar"></span>
                                                <label for="lead_type">Lead Type </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('lead_type_sub', $data['subLeadType'], ['id' => 'lead_type_sub','class'=>'form-control p-0 lead_type_sub']) }}
                                                <span class="bar"></span>
                                                <label for="lead_type_sub">Sub Lead Type </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="focused m-b-40">
                                                {{ Form::select('country',$countries, $data['country'], ['id' => 'country','class'=>'form-control p-0 country']) }}
                                                <span class="bar"></span>
                                                <label for="lead_type">Country </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="focused m-b-40">
                                                @if(isset($data['state']))  {!! Form::hidden('state_hidden', $data['state'], ['class' => 'form-control','id'=>'state_hidden']) !!}    @endif

                                                {{ Form::select('state',[], $data['state'], ['id' => 'state','class'=>'form-control p-0 state']) }}
                                                <span class="bar"></span>
                                                <label for="state">State </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="focused m-b-40">
                                                @if(isset($data['city']))  {!! Form::hidden('city_hidden', $data['city'], ['class' => 'form-control','id'=>'city_hidden']) !!}    @endif

                                                {{ Form::select('city',[], $data['city'], ['id' => 'city','class'=>'form-control p-0 city']) }}
                                                <span class="bar"></span>
                                                <label for="city">City </label>
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


    {{--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.min.js"></script>--}}
    <script src="../public/assets/js/admin/lead/lead-add.js"></script>

@endsection
