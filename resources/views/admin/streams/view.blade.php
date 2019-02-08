
@extends('layouts.master')

@section('custom_css')
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

@endsection

@section('content')
    <div class="page-wrapper">
        @include('layouts.header.breadcrumps')

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#all" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">ALL</span></a> </li>
                                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#active" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">ACTIVE</span></a> </li>
                                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inactive" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">INACTIVE</span></a> </li>

                            </ul>
                            <div class="tab-content tabcontent-border">
                                <div class="tab-pane" id="all" role="tabpanel">
                                    <div class="p-20">
                                        <table id="full_table" class="display nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Stream Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($streamFullData as $index=>$val)
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$val->stream_name}}</td>
                                                    <td>
                                                        @if($val->active_status=='Enable')
                                                            <a data-value="{{$val->id}}" data-text="Enable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                        @else
                                                            <a data-value="{{$val->id}}" data-text="Disable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::open(array('url'=>'admin/streams','class'=>'floating-labels','id'=>'streamEditForm'))  }}
                                                        {!! Form::hidden('id_stream', '', ['class' => 'form-control','id'=>'id_stream']) !!}

                                                        <a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-warning edit_btn"><span style="font-size:12px">Edit</span> </a>

                                                        {{ Form::close() }}
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane active" id="active" role="tabpanel">
                                    <div class="p-20">
                                        <table id="active_table" class="display nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Stream Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($streamActive as $index=>$val)
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$val->stream_name}}</td>
                                                    <td>
                                                        @if($val->active_status=='Enable')
                                                            <a data-value="{{$val->id}}" data-text="Enable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                        @else
                                                            <a href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger"><span style="font-size:12px">Inactive</span> </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::open(array('url'=>'admin/streams','class'=>'floating-labels','id'=>'streamEditForm'))  }}
                                                        {!! Form::hidden('id_stream', '', ['class' => 'form-control','id'=>'id_stream']) !!}

                                                        {{--<a href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger edit_btn">Edit </a>--}}
                                                        <a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-warning edit_btn"><span style="font-size:12px">Edit</span> </a>

                                                        {{--<input type="submit" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-warning" value="Edit"></input>--}}
                                                        {{ Form::close() }}
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane  " id="inactive" role="tabpanel">
                                    <div class="p-20">
                                        <table id="inactive_table" class="display nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Stream Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($streamInactive as $index=>$val)
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$val->stream_name}}</td>
                                                    <td>
                                                        @if($val->active_status=='Enable')
                                                            <a href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success"><span style="font-size:12px">Active</span></a>
                                                        @else
                                                            <a data-value="{{$val->id}}" data-text="Disable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::open(array('url'=>'admin/streams','class'=>'floating-labels','id'=>'streamEditForm'))  }}
                                                        {!! Form::hidden('id_stream', '', ['class' => 'form-control','id'=>'id_stream']) !!}

                                                        {{--<a href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger edit_btn">Edit </a>--}}
                                                        <a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-warning edit_btn"><span style="font-size:12px">Edit</span> </a>

                                                        {{--<input type="submit" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-warning" value="Edit"></input>--}}
                                                        {{ Form::close() }}
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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

    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/plug-ins/1.10.19/api/fnReloadAjax.js') !!}"></script>

    <script type="text/javascript" src="{!! asset('public/assets/js/admin/streams-view.js') !!}"></script>
    <script src="https://cdn.ckeditor.com/4.11.2/standard/ckeditor.js"></script>




@endsection
