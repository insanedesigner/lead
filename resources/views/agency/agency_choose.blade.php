@extends('layouts.master')

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
                        <div class="p-20">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="m-b-40">
                                            <label for="agency_name">Agency Name <span class="text-danger">*</span></label>
                                            {{ Form::select('agency', [], '', ['id' => 'agency','class'=>'form-control p-0 agency']) }}
                                        </div>
                                    </div>
                                    <div class="form-group m-b-1 col-sm-4 mx-auto">
                                        <div class="btn-div">
                                            <input type="submit" class="btn btn-block btn-outline-success save_btn" value="Save"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src="../public/assets/js/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/additional-methods.min.js"></script>

    <script src="../public/assets/js/user/agency-select.js"></script>
@endsection
