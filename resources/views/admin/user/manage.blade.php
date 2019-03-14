
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



                                <div class=" p-20 ">
                                    <div class="form-group">
                                        <table id="full_table" class="display nowrap" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>Sl.No</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($fullData as $index=>$val)
                                                <tr>
                                                    <td>{{$index = $index+1}}</td>
                                                    <td>{{$val['first_name']." ".$val['last_name']}}</td>
                                                    <td>{{$val['email']}}</td>
                                                    <td>{{$val['phone']}}</td>
                                                    <td>
                                                        @if($val->status==0)
                                                            <a data-value="{{$val->id_user_info}}" data-text="0" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-success btn-outline-success active_btn"><span style="font-size:12px">Active</span></a>
                                                        @else
                                                            <a data-value="{{$val->id_user_info}}" data-text="1" href="#" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger inactive_btn"><span style="font-size:12px">Inactive</span> </a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ Form::open(array('url'=>'admin/add_user','class'=>'floating-labels','id'=>'editUserForm'))  }}
                                                        {!! Form::hidden('id_user', '', ['class' => 'form-control id','id'=>'id']) !!}

                                                        <a data-value="{{$val->id_user_info}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger edit_btn" title="Edit"><span style="font-size:12px"><i class="fa fa-edit"></i></span> </a>

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

        @include('layouts.footer.footer_text')


    </div>
@endsection

@section('scripts')

    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js') !!}"></script>
    <script type="text/javascript" src="{!! asset('https://cdn.datatables.net/plug-ins/1.10.19/api/fnReloadAjax.js') !!}"></script>

    <script type="text/javascript" src="{!! asset('public/assets/js/admin/user/user-manage.js') !!}"></script>




@endsection
