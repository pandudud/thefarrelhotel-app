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
            <span>Kontak</span>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box portlet-theme">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-grid"></i>Data Kontak </div>
                <div class="tools">
                    <a href="" class="fullscreen"> </a>
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table1" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Contact Name</th>
                                            <th>Contact Phone</th>
                                            <th>Contact Phone 2</th>
                                            <th>Contact Email</th>
                                            <th>Contact Address</th>
                                            <th>Contact Website</th>
                                            <th class="text-center" width="150">Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="form-group form-md-line-input">Contact Name</th>
                                            <th class="form-group form-md-line-input">Contact Phone</th>
                                            <th class="form-group form-md-line-input">Contact Phone 2</th>
                                            <th class="form-group form-md-line-input">Contact Email</th>
                                            <th class="form-group form-md-line-input">Contact Address</th>
                                            <th class="form-group form-md-line-input">Contact Website</th>
                                            <th class="text-center" width="150">Action</th>
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
            ajax: '{!! url('pengaturan/kontak') !!}',
            columns: [
                {data: 'contact_name', name: 'contact_name'},
                {data: 'contact_phone', name: 'contact_phone'},
                {data: 'contact_phone_2', name: 'contact_phone_2'},
                {data: 'contact_email', name: 'contact_email'},
                {data: 'contact_address', name: 'contact_address'},
                {data: 'contact_website', name: 'contact_website'},
                {data: 'action', name: 'action', sClass: 'text-center', orderable: false, searchable: false}
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    if(index !== 6){
                        var input = document.createElement("input");
                        $(input).addClass('form-control');
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