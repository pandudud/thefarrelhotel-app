@extends('layouts.master')

@section('title', $title)

@push('styles')
<link href="{{ assets('global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet') }}" type="text/css" />
@endpush

@section('content')
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{url('home')}}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Pengaturan Level</span>
        </li>
    </ul>
</div>

{{-- <h1 class="page-title"> Level
    <small>Manajemen level pada aplikasi</small>
</h1> --}}

<div class="row">
    <div class="col-md-12">
        <div class="portlet box portlet-theme">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-grid"></i>Data Level </div>
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
                                <a class="btn green-jungle col-md-12" href="{{url('pengaturan/level/tambah')}}">
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
                                            <th>Nama Level</th>
                                            <th>Deskripsi</th>
                                            <th>Dibuat Tanggal</th>
                                            <th class="text-center" width="100">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="form-group form-md-line-input">Nama Level</th>
                                            <th class="form-group form-md-line-input">Deskripsi</th>
                                            <th class="form-group form-md-line-input">Dibuat Tanggal</th>
                                            <th>Aksi</th>
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

@push('scripts')
<script src="{{assets('global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#table1").DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! url('pengaturan/level') !!}',
            columns: [
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at',
                    render: function (data) {
                        return moment(data,'YYYY/MM/DD').format('D MMMM YYYY')
                    }
                },
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    var colCount = this.columns().nodes().length - 1;
                    if(index !== colCount){
                        var input = document.createElement("input");
                        $(input).addClass('form-control');
                        if(index == 2)
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