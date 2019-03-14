
@extends('layouts.master')

@section('custom_css')
    {{--<link href="public/assets/plugins/html5-editor/bootstrap-wysihtml5.css" rel="stylesheet">--}}

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

                        {{ Form::open(array('url' => 'admin/handleAddUser','class'=>'floating-labels m-t-40','id'=>'addUserForm','enctype'=>'multipart/form-data'))  }}
                            {!! Form::hidden('id_user_info', $data['id_user_info'], ['class' => 'form-control id','id'=>'id']) !!}



                        <div class="p-20">
                                {{--<div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group ">
                                            <div class="m-b-40 focused">
                                                {!! Form::text('agency','', ['class' => 'form-control agency','id'=>'agency','multiselect'=>'multiselect']) !!}
                                                <span class="bar"></span>
                                                <label for="lead">Agency</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('first_name', $data['first_name'], ['id' => 'first_name','class'=>'form-control p-0 first_name']) }}
                                                <span class="bar"></span>
                                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('last_name', $data['last_name'], ['id' => 'last_name','class'=>'form-control p-0 last_name']) }}
                                                <span class="bar"></span>
                                                <label for="last_name">Last Name</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                <input type="password" name="password" id="password" class="form-control p-0 password" autocomplete="off">
                                                <span class="bar"></span>
                                                <label for="password">Password <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                <input type="password" name="cpassword" id="cpassword" class="form-control p-0 cpassword" autocomplete="off">
                                                <span class="bar"></span>
                                                <label for="cpassword">Confirm Password <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::select('gender', $gender,   $data['gender'], ['id' => 'gender','class'=>'form-control p-0 gender']) }}
                                                <span class="bar"></span>
                                                <label for="gender">Gender </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::select('status', $status,  $data['status'], ['id' => 'status','class'=>'form-control p-0 status']) }}
                                                <span class="bar"></span>
                                                <label for="status">Status </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::select('user_type', $userType,  $data['user_type'], ['id' => 'user_type','class'=>'form-control p-0 user_type']) }}
                                                <span class="bar"></span>
                                                <label for="user_type">User Type </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <span class="p-20"></span>

                                <div class="row m-t-40">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('email', $data['email'], ['id' => 'email','class'=>'form-control p-0 email']) }}
                                                <span class="bar"></span>
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="m-b-40">
                                                {{ Form::text('phone', $data['phone'], ['id' => 'last_name','class'=>'form-control p-0 phone']) }}
                                                <span class="bar"></span>
                                                <label for="phone">Phone <span class="text-danger">*</span></label>
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
    <script src="../public/assets/plugins/magicsuggest/magicsuggest.js"></script>

    <script src="../public/assets/js/admin/user/user-add.js"></script>

@endsection
