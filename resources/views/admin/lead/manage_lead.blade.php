
@extends('layouts.master')

@section('custom_css')
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">

    <link href="../public/assets/plugins/magicsuggest/magicsuggest.css" rel="stylesheet">

    <style>
        .ms-ctn .ms-sel-ctn {
            margin-left: 10px;
        }
        input[readonly]{
            background-color:transparent;
            border: 0;
            font-size: 1em;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: transparent;
            opacity: 1;
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


                            <div class=" p-20 ">
                                <div class="form-group">
                                    <table id="full_table" class="display nowrap" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th>Sl.No</th>
                                            <th>Lead Name</th>
                                            <th>Lead Type</th>
                                            <th>Sub Lead Type</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($fullData as $index=>$val)
                                            <tr>
                                                <td>{{$index+1}}</td>
                                                <td>{{$val->lead_name}}</td>
                                                <td>{{$val->lead_type_name}}</td>
                                                <td>{{$val->sub_lead_type}}</td>
                                                <td>
                                                    {{ Form::open(array('url'=>'admin/add_lead','class'=>'floating-labels','id'=>'editLeadForm'))  }}
                                                    {!! Form::hidden('id_lead_hidden', '', ['class' => 'form-control','id'=>'id_lead_hidden']) !!}

                                                    <a data-value="{{$val->id_lead}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-danger edit_btn" title="Edit"><span style="font-size:12px"><i class="fa fa-edit"></i></span> </a>

                                                    {{ Form::close() }}
                                                </td>
                                                <td>
                                                    <a data-value="{{$val->id_lead}}" href="" class="btn waves-effect waves-light btn-rounded btn-xs btn-danger btn-outline-primary map_lead_btn" title="Map Course"><span style="font-size:12px">Map Lead to Agency </span> </a>

                                                    <div id="map_lead{{$val->id_lead}}" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myLargeModalLabel">Map Lead to Agency</h4>
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
                                                                                <div class="col-md-6 focused">
                                                                                    <div class="form-group m-b-40">
                                                                                        {!! Form::text('lead',$val->lead_name, ['class' => 'form-control lead','id'=>'lead','readonly'=>'readonly','data-value'=>$val->id_lead]) !!}
                                                                                        {!! Form::hidden('lead_hidden','', ['class' => 'form-control ','id'=>'lead_hidden']) !!}

                                                                                        <span class="bar"></span>
                                                                                        <label for="lead">Lead</label>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6 focused">
                                                                                    <div class="form-group m-b-40 ">
                                                                                        {!! Form::text('agency','', ['class' => 'form-control agency','id'=>'agency']) !!}
                                                                                        <span class="bar"></span>
                                                                                        <label for="lead">Agency</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <span class="p-20"></span>

                                                                    <div class="lead_agency_map_main">
                                                                       {{-- <div class="sub">
                                                                            <table id="table{{$val->id_lead}}" class="display nowrap lead_agency_list" style="width:100%">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th>Sl.No</th>
                                                                                    <th>Agency Name</th>

                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>

                                                                                </tbody>
                                                                            </table>
                                                                        </div>--}}
                                                                    </div>





                                                                </div>
                                                                <div class="modal-footer">
                                                                    <a data-value="{{$val->id_lead}}" href="" class="btn btn-block btn-outline-success save_btn col-sm-2">Save</a>
                                                                    <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>



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


    <script type="text/javascript" src="{!! asset('public/assets/js/admin/lead/lead-manage.js') !!}"></script>

    <script src="../public/assets/plugins/magicsuggest/magicsuggest.js"></script>


    <script type="text/javascript">





    </script>

@endsection
