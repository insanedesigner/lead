
@extends('layouts.master')

@section('custom_css')
    <link href="../public/assets/plugins/dropify/dist/css/dropify.min.css" rel="stylesheet">

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
                        {{ Form::open(array('url' => 'admin/handleUniversityCoursesMapping','class'=>'floating-labels m-t-40','id'=>'addCoursesToUniversity','enctype'=>'multipart/form-data'))  }}
                            <div class="p-20">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="focused m-b-40">
                                                {{ Form::select('university', $universityData, $idUniversity, ['id' => 'university','class'=>'form-control p-0 university']) }}
                                                <span class="bar"></span>
                                                <label for="university">University <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-b-10">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::select('courses', $coursesData, $data['courseName'], ['id' => 'courses','class'=>'form-control p-0 courses']) }}
                                            <span class="bar"></span>
                                            <label for="courses">Courses <span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::select('courses_duration', $courseDuration, $data['duration'], ['id' => 'courses_duration','class'=>'form-control p-0 courses_duration']) }}
                                            <span class="bar"></span>
                                            <label for="courses_duration">Course Duration </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::text('fees', $data['fees'], ['id' => 'fees','class'=>'form-control p-0 fees']) }}
                                            <span class="bar"></span>
                                            <label for="fees">Fees </label>
                                        </div>
                                    </div>

                                </div>
                                <span class="p-20"></span>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="p-b-5">Overview</div>
                                            {!! Form::textarea('overview', $data['overview'], ['class' => 'form-control overview','rows'=>10,'id'=>'overview']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="p-b-5">Eligibility</div>
                                            {!! Form::textarea('eligibility', $data['eligibility'], ['class' => 'form-control eligibility','rows'=>10,'id'=>'eligibility']) !!}
                                        </div>
                                    </div>
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
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tinymce@5.0.0/tinymce.min.js"></script>
    <script src="../public/assets/plugins/dropify/dist/js/dropify.min.js"></script>
    <script src="../public/assets/js/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>--}}
    <script src="../public/assets/plugins/magicsuggest/magicsuggest.js"></script>

    <script src="../public/assets/js/admin/university/university-mapcourses.js"></script>
@endsection
