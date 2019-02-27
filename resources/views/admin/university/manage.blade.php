
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
                        <div class="card-body p-b-0">
                            @include('includes.alert_message.alert_message',['error' => Session::get('error'), 'success' => Session::get('success')])

                            {{--<div class="form-group text-right">
                                {{ Form::open(array('url'=>'admin/courses_university','class'=>'floating-labels','id'=>'mapCoursesAddForm'))  }}
                                    <a href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-primary map_courses_btn" title="Map Course"><span style="font-size:12px">Map Course to university</span> </a>
                                {{ Form::close() }}
                            </div>--}}

                        </div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#all" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">ALL</span></a> </li>
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#active" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">ACTIVE</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inactive" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">INACTIVE</span></a> </li>
                        </ul>
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane" id="all" role="tabpanel">
                                <div class="p-20">
                                    <table id="full_table" class="display nowrap" style="width:100%">
                                        <thead>
                                        <tr class="text-center">
                                            <th>Sl.No</th>
                                            <th>University Name</th>
                                            {{--<th >Courses Name</th>--}}
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($full as $index=>$val)
                                            <tr class="text-center">
                                                <td>{{$index+1}}</td>
                                                <td>{{$val->university_name}}</td>
                                                {{--<td>
                                                    <a  class="btn waves-effect waves-light btn-rounded btn-xs btn-info btn-outline-info" data-toggle="modal" data-target="#courses_view_modal_full{{$index}}">View</a>
                                                    <div id="courses_view_modal_full{{$index}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Courses</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form>
                                                                        <div class="form-group">
                                                                            <ul class="text-left">
                                                                                @foreach(json_decode($val->course_name) as $index=>$courses)
                                                                                    <li> {{$courses}}</li>
                                                                                @endforeach
                                                                            </ul>

                                                                        </div>

                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>--}}
                                                <td>
                                                    @if($val->status==0)
                                                        <a data-value="{{$val->id}}" data-text="0" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                    @else
                                                        <a data-value="{{$val->id}}" data-text="1" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ Form::open(array('url'=>'admin/university','class'=>'floating-labels','id'=>'universityEditForm'))  }}
                                                    {!! Form::hidden('id', '', ['class' => 'form-control','id'=>'id']) !!}

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
                                        <tr class="text-center">
                                            <th>Sl.No</th>
                                            <th>University Name</th>
                                            {{--<th>Courses Name</th>--}}
                                            <th>Status</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($active as $index=>$val)
                                            <tr class="text-center">
                                                <td>{{$index+1}}</td>
                                                <td>{{$val->university_name}}</td>
                                                {{--<td>
                                                    <a  class="btn waves-effect waves-light btn-rounded btn-xs btn-info btn-outline-info" data-toggle="modal" data-target="#courses_view_modal_active{{$index}}">View</a>
                                                    <div id="courses_view_modal_active{{$index}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Courses</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form>
                                                                        <div class="form-group">
                                                                            <ul class="text-left">
                                                                                @foreach(json_decode($val->course_name) as $index=>$courses)
                                                                                    <li> {{$courses}}</li>
                                                                                @endforeach
                                                                            </ul>

                                                                        </div>

                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>--}}
                                                <td>
                                                    @if($val->status==0)
                                                        <a data-value="{{$val->id}}" data-text="0" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                    @else
                                                        <a data-value="{{$val->id}}" data-text="1" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ Form::open(array('url'=>'admin/university','class'=>'floating-labels','id'=>'universityEditForm'))  }}
                                                        {!! Form::hidden('id', '', ['class' => 'form-control id','id'=>'id']) !!}
                                                        <a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger edit_btn" title="Edit"><span style="font-size:12px"><i class="fa fa-edit"></i> </span> </a>
                                                        <a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-info media_upload_btn" title="Media Uploads"><span style="font-size:12px"><i class="fa fa-image"></i></span> </a>
                                                        {{--<a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-warning map_courses_btn"><span style="font-size:12px"><i class="fa fa-paperclip"></i></span> </a>--}}

                                                    {{ Form::close() }}

                                                    {{ Form::open(array('url'=>'admin/media_university','class'=>'floating-labels','id'=>'mediaAddForm'))  }}
                                                        {!! Form::hidden('id_university', '', ['class' => 'form-control id_university','id'=>'id_university']) !!}
                                                    {{ Form::close() }}

                                                </td>
                                                <td>
                                                    {{ Form::open(array('url'=>'admin/courses_university','class'=>'floating-labels','id'=>'mapCoursesAddForm'))  }}
                                                        {!! Form::hidden('id_mapping', '', ['class' => 'form-control id_mapping','id'=>'id_mapping']) !!}
                                                        <a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-primary map_courses_btn" title="Map Course"><span style="font-size:12px">Map Course </span> </a>
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
                                        <tr class="text-center">
                                            <th>Sl.No</th>
                                            <th>University Name</th>
                                            {{-- <th>Courses Name</th>--}}
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($inactive as $index=>$val)
                                            <tr class="text-center">
                                                <td>{{$index+1}}</td>
                                                <td>{{$val->university_name}}</td>
                                                {{--<td>
                                                    <a  class="btn waves-effect waves-light btn-rounded btn-xs btn-info btn-outline-info" data-toggle="modal" data-target="#courses_view_modal_inactive{{$index}}">View</a>
                                                    <div id="courses_view_modal_inactive{{$index}}" class="modal fade text-left" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Courses</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form>
                                                                        <div class="form-group">
                                                                            <ul>
                                                                                @foreach(json_decode($val->course_name) as $index=>$courses)
                                                                                    <li> {{$courses}}</li>
                                                                                @endforeach
                                                                            </ul>

                                                                        </div>

                                                                    </form>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>--}}
                                                <td>
                                                    @if($val->status==0)
                                                        <a data-value="{{$val->id}}" data-text="0" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                    @else
                                                        <a data-value="{{$val->id}}" data-text="1" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ Form::open(array('url'=>'admin/university','class'=>'floating-labels','id'=>'universityEditForm'))  }}
                                                    {!! Form::hidden('id', '', ['class' => 'form-control','id'=>'id']) !!}

                                                    <a data-value="{{$val->id}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-warning edit_btn"><span style="font-size:12px">Edit</span> </a>
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



        @include('layouts.footer.footer_text')


    </div>
@endsection

@section('scripts')

    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/plug-ins/1.10.19/api/fnReloadAjax.js') !!}"></script>

    <script type="text/javascript" src="{!! asset('public/assets/js/admin/university/university-manage.js') !!}"></script>


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
