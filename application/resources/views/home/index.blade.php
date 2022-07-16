@extends('layouts.master')

@section('title', $title)

@push('styles')
<link href="{{ assets('global/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/jqvmap/jqvmap/jqvmap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/lightbox2/css/lightbox.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('home') }}">Home</a>
        </li>
    </ul>
    <div class="page-toolbar">
        <div id="dashboard-report-range" class="pull-right tooltips btn btn-sm" data-container="body" data-placement="bottom" data-original-title="Change dashboard date range">
            <i class="icon-calendar"></i>&nbsp;
            <span class="thin uppercase hidden-xs"></span>&nbsp;
            <i class="fa fa-angle-down"></i>
        </div>
    </div>
</div>
<!-- END PAGE BAR -->

<!-- BEGIN PAGE TITLE-->
<h1 class="page-title"> The Farrel Hotel
    {{-- <small>statistics, charts, recent events and reports</small> --}}
</h1>
<!-- END PAGE TITLE-->

<!-- BEGIN DASHBOARD STATS 1-->
<div class="row">
   
</div>
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->

<div class="row">
    <div class="col-md-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <span class="caption-subject bold uppercase font-dark">Gallery</span>
                    <span class="caption-helper">The Farrel Hotel</span>
                </div>
            </div>
            <div class="portlet-body">
                @foreach ($data as $item)
                <a href="{{ asset('application/public/storage') . '/' . $item->gallery_path }}" data-lightbox="gallery" data-title="{{$item->gallery_title}}">
                    <img src="{{ asset('application/public/storage') . '/' . $item->gallery_path_thumb }}" style="max-height: 300px; max-width: 300px; height: auto; width: auto;" />
                </a>
                @endforeach
        </div>
    </div>
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject font-dark bold uppercase">Room</span>
                    <span class="caption-helper">The Farrel Hotel</span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table1" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Room Name</th>
                            <th>Room Price</th>
                            <th>Room Description</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="form-group form-md-line-input">Room Name</th>
                            <th class="form-group form-md-line-input">Room Price</th>
                            <th class="form-group form-md-line-input">Room Description</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xs-12 col-sm-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption ">
                    <span class="caption-subject font-dark bold uppercase">Promotion</span>
                    <span class="caption-helper">The Farrel Hotel</span>
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="table2" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Promotion Name</th>
                            <th>Promotion Description</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th class="form-group form-md-line-input">Promotion Name</th>
                            <th class="form-group form-md-line-input">Promotion Description</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugins')
<script src="{{ assets('global/plugins/bootstrap-daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/amcharts/amcharts/amcharts.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/amcharts/amcharts/serial.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/amcharts/amcharts/radar.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/amcharts/amcharts/themes/light.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/amcharts/amcharts/themes/patterns.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/amcharts/amcharts/themes/chalk.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/fullcalendar/fullcalendar.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/lightbox2/js/lightbox.js') }}" type="text/javascript"></script>
<script src="{{assets('global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{assets('global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{assets('global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
@endpush

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        // lightbox.option({
        //     'maxWidth': 400,
        //     'maxHeight': 400
        // });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#table1").DataTable({
           processing: true,
            serverSide: true,
            pageLength: 3,
            ajax: '{!! url('kamar/kamar-hotel') !!}',
            columns: [
                {data: 'room_name', name: 'room_name'},
                {data: 'room_price', name: 'room_price'},
                {data: 'room_description', name: 'room_description'},
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    if(index !== 3){
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
<script type="text/javascript">
    $(document).ready(function(){
        $("#table2").DataTable({
           processing: true,
            serverSide: true,
            pageLength: 3,
            ajax: '{!! url('promosi') !!}',
            columns: [
                {data: 'promotion_name', name: 'promotion_name'},
                {data: 'promotion_description', name: 'promotion_description'},
            ],
            initComplete: function () {
                this.api().columns().every(function (index) {
                    var column = this;
                    if(index !== 3){
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
<script src="{{ assets('pages/scripts/dashboard.js') }}" type="text/javascript"></script>
@endpush