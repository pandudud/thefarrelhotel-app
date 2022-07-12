@extends('layouts.master')

@section('title', $title)

@push('styles')
<link href="{{ assets('global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{assets('global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{assets('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet')}}" type="text/css" />
@endpush

@section('content')
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{url('home')}}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Pengaturan User</span>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box portlet-theme">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-grid"></i>Data User </div>
                <div class="tools">
                    <a href="" class="fullscreen"> </a>
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-2 col-md-offset-10 text-right">
                                <a class="btn green-jungle col-md-12" href="user/tambah">
                                    <i class="fa fa-plus"></i>
                                    Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table1" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Nama</th>
                                            <th>Level</th>
                                            <th>Dibuat Tanggal</th>
                                            <th>Status</th>
                                            <th class="text-center" width="150">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="form-group form-md-line-input">Username</th>
                                            <th class="form-group form-md-line-input">Email</th>
                                            <th class="form-group form-md-line-input">Nama</th>
                                            <th class="form-group form-md-line-input">Level</th>
                                            <th class="form-group form-md-line-input">Dibuat Tanggal</th>
                                            <th>Status</th>
                                            <th class="text-center" width="150">Aksi</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugins')
<script src="{{assets('global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{assets('global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{assets('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
@endpush

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $("#table1").DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url('pengaturan/user') !!}',
            columns: [
                {data: 'username', name: 'users.username'},
                {data: 'email', name: 'users.email'},
                {data: 'name', name: 'users.name'},
                {data: 'level.name', name: 'level.name'},
                {data: 'created_at', name: 'users.created_at'},
                {data: 'is_active', name: 'users.is_active', sClass: 'text-center'},
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    var colCount = this.columns().nodes().length - 1;
                    if(index !== colCount && index !== 5){
                        var input = document.createElement("input");
                        $(input).addClass('form-control');
                        if(index == 4)
                        {
                            $(input).attr('type', 'date');
                        }
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
                    }
                });
                $(".dataTables_length select").select2();
            }
        });
    });
</script>
<script src="{{ assets('pages/scripts/sweetalert2-scripts.js') }}" type="text/javascript"></script>
@endpush