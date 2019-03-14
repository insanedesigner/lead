
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
                        </div>

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#all" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">ALL</span></a> </li>
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#active" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">ACTIVE</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#inactive" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">INACTIVE</span></a> </li>
                        </ul>

                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane" id="all" role="tabpanel">
                                <div class=" p-20 ">
                                    <div class="form-group">
                                        <table id="full_table" class="display nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Agency Name</th>
                                                <th>Points</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                @if(isset($screenDataArray))
                                                    @if(in_array(5, $screenDataArray))
                                                        <th></th>
                                                    @endif
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($fullData as $index=>$val)
                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$val->agency_name}}</td>
                                                    <td>{{$val->points}}</td>
                                                    <td>{{$val->phone}}</td>
                                                    <td>
                                                        @if($val->status==0)
                                                            <a data-value="{{$val->id_agency}}" data-text="0" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                        @else
                                                            <a data-value="{{$val->id_agency}}" data-text="1" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::open(array('url'=>'admin/add_agency','class'=>'floating-labels','id'=>'editAgencyForm'))  }}
                                                        {!! Form::hidden('id_agency', '', ['class' => 'form-control','id'=>'id_agency']) !!}

                                                        <a data-value="{{$val->id_agency}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger edit_btn" title="Edit"><span style="font-size:12px"><i class="fa fa-edit"></i></span> </a>

                                                        {{ Form::close() }}
                                                    </td>
                                                    @if(isset($screenDataArray))
                                                        @if(in_array(5, $screenDataArray))
                                                            <td>
                                                                <a data-value="{{$val->id_agency}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-info btn-outline-info add_user_btn"><span style="font-size:12px">Add User</span> </a>
                                                            </td>
                                                        @endif
                                                    @endif
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane active" id="active" role="tabpanel">
                                <div class=" p-20 ">
                                    <div class="form-group">
                                        <table id="active_table" class="display nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>Agency Name</th>
                                                <th>Points</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                @if(isset($screenDataArray))
                                                    @if(in_array(5, $screenDataArray))
                                                        <th></th>
                                                    @endif
                                                @endif
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($activeData as $index=>$val)

                                                <tr>
                                                    <td>{{$index+1}}</td>
                                                    <td>{{$val->agency_name}}</td>
                                                    <td>{{$val->points}}</td>
                                                    <td>{{$val->phone}}</td>
                                                    <td>
                                                        @if($val->status==0)
                                                            <a data-value="{{$val->id_agency}}" data-text="0" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                        @else
                                                            <a data-value="{{$val->id_agency}}" data-text="1" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::open(array('url'=>'admin/add_agency','class'=>'floating-labels','id'=>'editAgencyForm'))  }}
                                                        {!! Form::hidden('id_agency', '', ['class' => 'form-control','id'=>'id_agency']) !!}

                                                        <a data-value="{{$val->id_agency}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger edit_btn"><span style="font-size:12px"><i class="fa fa-edit"></i></span> </a>

                                                        {{ Form::close() }}
                                                    </td>

                                                    @if(isset($screenDataArray))
                                                        @if(in_array(5, $screenDataArray))
                                                            <td>
                                                                <a data-value="{{$val->id_agency}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-info btn-outline-info add_user_btn"><span style="font-size:12px">Add User</span> </a>

                                                                <div id="add_user{{$val->id_agency}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h4 class="modal-title">Map User</h4>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="p-20">
                                                                                    <form class="floating-labels">
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div class="msg_div"></div>
                                                                                                <span class="p-20"></span>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group m-b-40">
                                                                                                    {!! Form::text('email','', ['class' => 'form-control email','id'=>'email'.$val->id_agency,'data-value'=>$val->id_agency]) !!}
                                                                                                    {!! Form::hidden('id_agency','', ['class' => 'form-control id_agency','id'=>'id_agency','data-value'=>$val->id_agency]) !!}

                                                                                                    <span class="bar"></span>
                                                                                                    <label for="email">Email</label>
                                                                                                </div>
                                                                                                <div class="add_user_main_div" style="display: none">
                                                                                                    <div class="form-group m-b-40">
                                                                                                        <input type="password" name="password" class="form-control" id="password">
                                                                                                        <span class="bar"></span>
                                                                                                        <label for="name">Name</label>
                                                                                                    </div>

                                                                                                    <div class="form-group m-b-40">
                                                                                                        {!! Form::text('name','', ['class' => 'form-control name','id'=>'name'.$val->id_agency,'data-value'=>$val->id_agency]) !!}

                                                                                                        <span class="bar"></span>
                                                                                                        <label for="name">Name</label>
                                                                                                    </div>
                                                                                                    <div class="form-group m-b-40">
                                                                                                        {!! Form::text('phone','', ['class' => 'form-control phone','id'=>'phone'.$val->id_agency,'data-value'=>$val->id_agency]) !!}

                                                                                                        <span class="bar"></span>
                                                                                                        <label for="phone">Phone</label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <a data-value="{{$val->id_agency}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-info btn-outline-info check_email"><span style="font-size:12px">Check</span> </a>
                                                                                            </div>
                                                                                        </div>

                                                                                </div>
                                                                            </div>

                                                                            <div class="modal-footer">
                                                                                <div class="main_btn_div">

                                                                                </div>


                                                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </td>
                                                        @endif
                                                    @endif


                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="inactive" role="tabpanel">
                                <div class="p-20">
                                    <table id="inactive_table" class="display nowrap" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Sl.No</th>
                                            <th>Agency Name</th>
                                            <th>Points</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            @if(isset($screenDataArray))
                                                @if(in_array(5, $screenDataArray))
                                                    <th></th>
                                                @endif
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($inactiveData as $index=>$val)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$val->agency_name}}</td>
                                                <td>{{$val->points}}</td>
                                                <td>{{$val->phone}}</td>
                                                <td>
                                                    @if($val->status==0)
                                                        <a data-value="{{$val->id_agency}}" data-text="0" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                    @else
                                                        <a data-value="{{$val->id_agency}}" data-text="1" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ Form::open(array('url'=>'admin/add_agency','class'=>'floating-labels','id'=>'editAgencyForm'))  }}
                                                    {!! Form::hidden('id_agency', '', ['class' => 'form-control','id'=>'id_agency']) !!}

                                                    <a data-value="{{$val->id_agency}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger edit_btn"><span style="font-size:12px"><i class="fa fa-edit"></i></span> </a>

                                                    {{ Form::close() }}
                                                </td>
                                                @if(isset($screenDataArray))
                                                    @if(in_array(5, $screenDataArray))
                                                        <td>
                                                            <a data-value="{{$val->id_agency}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-info btn-outline-info add_user_btn"><span style="font-size:12px">Add User</span> </a>

                                                        </td>
                                                    @endif
                                                @endif
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

    <script type="text/javascript" src="{!! asset('public/assets/js/admin/agency/agency-manage.js') !!}"></script>




@endsection
