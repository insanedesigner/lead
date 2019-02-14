
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
                                                <th>Category Name</th>
                                                <th>Stream Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($courseFullData as $index=>$val)
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$val->category_name}}</td>
                                                    <td>{{$val->stream_name}}</td>
                                                    <td>
                                                        @if($val->status=='Enable')
                                                            <a data-value="{{$val->id}}" data-text="Enable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                        @else
                                                            <a data-value="{{$val->id}}" data-text="Disable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::open(array('url'=>'admin/coursescategory','class'=>'floating-labels','id'=>'coursesEditForm'))  }}
                                                        {!! Form::hidden('id_courses', '', ['class' => 'form-control','id'=>'id_courses']) !!}

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
                                                <th>Category Name</th>
                                                <th>Stream Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($courseActiveData as $index=>$val)
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$val->category_name}}</td>
                                                    <td>{{$val->stream_name}}</td>
                                                    <td>
                                                        @if($val->status=='Enable')
                                                            <a data-value="{{$val->id}}" data-text="Enable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                        @else
                                                            <a data-value="{{$val->id}}" data-text="Disable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::open(array('url'=>'admin/coursescategory','class'=>'floating-labels','id'=>'coursesCategoryEditForm'))  }}
                                                        {!! Form::hidden('id_courses', '', ['class' => 'form-control','id'=>'id_category']) !!}

                                                        <a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-warning edit_btn"><span style="font-size:12px">Edit</span> </a>

                                                        {{ Form::close() }}
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane" id="inactive" role="tabpanel">
                                    <div class="p-20">
                                        <table id="inactive_table" class="display nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Category Name</th>
                                                <th>Stream Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($courseInactiveData as $index=>$val)
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$val->category_name}}</td>
                                                    <td>{{$val->stream_name}}</td>
                                                    <td>
                                                        @if($val->status=='Enable')
                                                            <a data-value="{{$val->id}}" data-text="Enable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                        @else
                                                            <a data-value="{{$val->id}}" data-text="Disable" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::open(array('url'=>'admin/coursescategory','class'=>'floating-labels','id'=>'coursesEditForm'))  }}
                                                        {!! Form::hidden('id_courses', '', ['class' => 'form-control','id'=>'id_courses']) !!}

                                                        <a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-warning edit_btn"><span style="font-size:12px">Edit</span> </a>

                                                        {{ Form::close() }}
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>

                                    {{--  <div class="p-20">
                                        <table id="employee-grid" class="display nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Category Name</th>
                                                <th>Stream Name</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>--}}
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

    <script type="text/javascript" src="{!! asset('public/assets/js/admin/courses/category-view.js') !!}"></script>


    <script>
        /*$(document).ready(function() {


                var dataTable = $('#employee-grid').DataTable( {
                    "processing": true,
                    "serverSide": true,
                    "responsive":true,
                    "ajax":{
                        url :"../api/loadCoursesCategory", // json datasource
                        type: "post",  // method  , by default get

                        error: function(){  // error handling
                            $(".employee-grid-error").html("");
                            $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                            $("#employee-grid_processing").css("display","none");

                        }
                    },
                    "aoColumns": [
                        {'mData': 'id'},
                        {'mData': 'category_name'},
                        {'mData': 'stream_name'},
                        {'mData': 'status', "render": function ( data, type, row ) {
                                if(row.status == 'Enable'){
                                    return '<a href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success"><span style="font-size:12px">Active</span></a>';
                                }
                                else{
                                    return '<a href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger"><span style="font-size:12px">Inactive</span></a>';

                                }

                            },
                        },
                        {'mData': 'category_name', "render": function ( data, type, row ) {
                                return 'Edit';

                            },
                        },
                        /!*{'mData': 'stream_name', "render": function ( data, type, row ) {
                               console.log(row.id);

                           },
                       },*!/

                    ]

                } );

        } );*/
    </script>


@endsection
