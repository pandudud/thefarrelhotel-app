@extends('layouts.master')

@section('title', $title)

@push('styles')
<link href="{{ assets('global/plugins/lightbox2/css/lightbox.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ assets('global/plugins/gridly/css/jquery.gridly.css') }}" rel="stylesheet" type="text/css" />
{{-- <link href="{{ assets('pages/css/portfolio.css') }}" rel="stylesheet" type="text/css" /> --}}
<style>
.cbp-popup-wrap {
    z-index: 9995;
}
.c_lightbox {
    position: relative;
    display: inline-block;
}
.c_lightbox .btn-del {
    display: none;
    position: absolute;
    right: 20px;
    bottom: 20px;
}
.c_lightbox:hover img {
    cursor: move;
}
.c_lightbox:hover .btn-del {
    display: unset;
}
</style>

@endpush

@section('content')
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{url('home')}}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Banner</span>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box portlet-theme">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-grid"></i>Banner</div>
                <div class="tools">
                    <a href="" class="fullscreen"> </a>
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-2">
                                <a class="btn blue-sharp col-md-12" id="simpanUrutan">
                                    <i class="fa fa-tasks"></i>
                                    Simpan Urutan Banner
                                </a>
                            </div>
                            <div class="col-md-2 col-md-offset-8 text-right">
                                <a class="btn green-jungle col-md-12" href="banner/tambah">
                                    <i class="fa fa-plus"></i>
                                    Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="Ibody" class="portlet-body" style="padding: 5px 5px;">
                <div class="gridly" style="position: relative;">
                    @foreach ($data as $item)
                    <span class="c_lightbox" data-id="{{$item->id}}">
                        <a href="{{ asset('application/public/storage') . '/' . $item->banner_path }}" data-lightbox="gallery" data-title="{{$item->gallery_title}}">
                            <img src="{{ asset('application/public/storage') . '/' . $item->banner_path_thumb }}" style="max-height: 400px; max-width: 400px; height: auto; width: auto;" />
                        </a>
                        <a class="btn btn-circle btn-icon-only red btn-del" data-id="{{$item->id}}" data-path="{{$item->banner_path}}">
                            <i class="glyphicon glyphicon-trash"></i>
                        </a>
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugins')
<script src="{{ assets('global/plugins/lightbox2/js/lightbox.js') }}" type="text/javascript"></script>
<script src="{{ assets('global/plugins/gridly/js/jquery.gridly.js') }}" type="text/javascript"></script>
@endpush

@push('scripts')
<script type="text/javascript">
const gridlyBase = 400;
let bodyWidth = $("#Ibody").width();
let gridlyColumn = bodyWidth/gridlyBase;
let gridlyElements = [];
let reordered = function($elements) {
    let arr = [];
    $elements.each(function() {
        arr.push($(this).data("id"));
    });
    gridlyElements = arr;
}
$(document).ready(function() {
    $(".btn-del").on("click", function() {
        let id = $(this).data("id");
        let path = $(this).data("path");
        swal({
            title: "Anda yakin?",
            text: "Hapus data banner ini",
            type: "warning",
            showCancelButton: true
        }).then(function(){
            App.blockUI();
            $.ajax({
                type: "POST",
                url: "{{ url('pengaturan/banner/deleteGambar') }}",
                headers: {
                    'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content"),
                },
                data: {
                    'id': id,
                    'path': path,
                },
                success: function(data){
                    window.location.href = data;
                },
                error: function(){
                    swal("Error!", "Silahkan hubungi administrator", "error")
                    App.unblockUI();
                }
            });
        }).catch(swal.noop);
    });

    $("#simpanUrutan").on("click", function() {
        if(gridlyElements.length > 0) {
            swal({
                title: "Anda yakin?",
                text: "Mengubah urutan banner ini",
                type: "warning",
                showCancelButton: true
            }).then(function() {
                App.blockUI();
                $.ajax({
                    type: "POST",
                    url: "{{ url('pengaturan/banner/simpanUrutan') }}",
                    headers: {
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content"),
                    },
                    data: {
                        'urutan': gridlyElements
                    },
                    success: function(data) {
                        window.location.href = data;
                    },
                    error: function() {
                        swal("Error!", "Silahkan hubungi administrator", "error");
                        App.unblockUI();
                    }
                });
            }).catch(swal.noop);
        }
        else {
            swal("Oops..", "Harap ubah urutan banner dulu ya..", "warning");
        }
    });

    $(".gridly").gridly({
        columns: gridlyColumn,
        gutter: 5,
        base: gridlyBase,
        callbacks: {reordered}
    });
});
$(window).on('resize', function(){
    bodyWidth = $("#Ibody").width();
    gridlyColumn = bodyWidth/gridlyBase;

    $(".gridly").gridly({
        columns: gridlyColumn,
        gutter: 5,
        base: gridlyBase,
        callbacks: {reordered}
    });
});
</script>
<script src="{{ assets('pages/scripts/sweetalert2-scripts.js') }}" type="text/javascript"></script>
@endpush