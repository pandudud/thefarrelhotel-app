@extends('layouts.master')

@section('title', $title)

@push('styles')
<link href="{{ assets('global/plugins/jquery-nestable/jquery.nestable.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
    .tooltip-inner {
        max-width: 500px;
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
            <span>Pengaturan Menu</span>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box portlet-theme">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-grid"></i>Struktur Menu </div>
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
                                <a class="btn green-jungle col-md-12" href="menu/tambah">
                                    <i class="fa fa-plus"></i>
                                    Tambah
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="dd" id="data_menu">
                                    <ol class="dd-list">
                                        @each('pengaturan.menu.data', $all_menus, 'all_menu')
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            {!! Form::button('<i class="fa fa-check"></i> Simpan', ['class' => 'btn blue-sharp col-md-4 col-md-offset-4 col-xs-4 col-xs-offset-4', 'id' => 'save']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugins')
<script src="{{ assets('global/plugins/jquery-nestable/jquery.nestable.js') }}" type="text/javascript"></script>
@endpush

@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){

        $('#data_menu').nestable({
            beforeDragStop: function(l, e, p){
                var is_heading = $(e).data('heading');
                var parent = $(p).parent().data('id');
                if(is_heading && parent != null)
                    return false;
            }
        });
        
        data_menu = $('#data_menu').nestable('serialize');

        $('#data_menu').on('change', function(){
            data_menu = $('#data_menu').nestable('serialize');
        });

        $("#save").on("click", function(){
            swal({
                title: "Anda yakin?",
                text: "Update menu",
                type: "warning",
                showCancelButton: true
            }).then(function(){
                App.blockUI();
                $.ajax({
                    type: "POST",
                    url: "{{ url('pengaturan/menu') }}",
                    headers: {
                        'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr("content"),
                    },
                    data: {'menus': data_menu},
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

        $(".btn-delete").on("click", function(e){
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: "Anda yakin?",
                text: "Delete menu " + $(this).data("swa-text"),
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak"
            }).then(function(){
                App.blockUI();
                form.submit();
            }).catch(swal.noop);
        });

    });
</script>
@endpush