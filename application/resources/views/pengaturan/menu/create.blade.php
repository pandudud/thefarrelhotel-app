@extends('layouts.master')

@section('title', $title)

@push('styles')
<link href="{{ assets('global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('home') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{ url('pengaturan/menu') }}">Pengaturan Menu</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Tambah</span>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="portlet box portlet-theme">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-grid"></i>Tambah Menu 
                </div>
                <div class="tools">
                    <a href="" class="fullscreen"> </a>
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">

                    {!! Form::open(['url' => 'pengaturan/menu', 'class' => 'form-horizontal']) !!}

                    <div class="form-body">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                <p>Terdapat beberapa kesalahan. Silahkan diperbaiki.</p><br>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('is_heading') ? 'has-error' : ''}}">
                                    {!! Html::decode(Form::label('is_heading', 'Heading', ['class' => 'control-label col-md-4'])) !!}
                                    <div class="col-md-8">
                                        <div class="md-checkbox" style="margin-top: 5px;">
                                            <input type="checkbox" id="is_heading" name="is_heading" class="md-check" value="1" {{ $errors->any() ? old("is_heading") ? "checked" : "" : "" }}>
                                            <label for="is_heading">
                                                <span></span>
                                                <span class="check"></span>
                                                <span class="box"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('name') ? 'has-error' : ''}}">
                                    {!! Html::decode(Form::label('name', 'Nama Menu <span class="required">*</span>', ['class' => 'control-label col-md-4'])) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name'] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('name') ? $errors->first('name') : 'Masukkan Nama Menu' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('link') ? 'has-error' : ''}}">
                                    {!! Html::decode(Form::label('link', 'Nama Link <span class="required">*</span>', ['class' => 'control-label col-md-4'])) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('link', null, ['class' => 'form-control', 'id' => 'link', old("is_heading") ? 'disabled' : ''] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('link') ? $errors->first('link') : 'Masukkan Nama Link' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('icon') ? 'has-error' : ''}}">
                                    {!! Html::decode(Form::label('icon', 'Nama Icon', ['class' => 'control-label col-md-4'])) !!}
                                    <div class="col-md-8">
                                        {!! Form::text('icon', null, ['class' => 'form-control', 'id' => 'icon', old("is_heading") ? 'disabled' : ''] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('icon') ? $errors->first('icon') : 'Masukkan Nama Icon' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('parent_id') ? 'has-error' : ''}}">
                                    {!! Html::decode(Form::label('parent_id', 'Nama Parent <span class="required">*</span>', ['class' => 'control-label col-md-4'])) !!}
                                    <div class="col-md-8">
                                        {!! Form::select('parent_id', $parent_id, 0, ['class' => 'form-control select2', 'id' => 'parent_id', old("is_heading") ? 'disabled' : ''] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('parent_id') ? $errors->first('parent_id') : 'Masukkan Parent' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-actions bottom">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3"></div>
                                {!! Form::button('<i class="fa fa-check"></i> Simpan', ['class' => 'btn blue-sharp col-md-3 simpan', 'type' => 'submit', 'data-swa-text' => 'Menyimpan menu']) !!}
                                <a href="{{ url()->previous() }}" type="button" class="col-md-3 btn red-haze"><i class="fa fa-close"></i> Batal</a>
                                <div class="col-md-3"></div>
                            </div>
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugins')
<script src="{{ assets('global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@endpush

@push('scripts')
<script src="{{ assets('pages/scripts/sweetalert2-scripts.js') }}" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    $(".md-checkbox input[type=checkbox]").on("change", function(){
        $("#link, #icon, #parent_id").prop("disabled", $(this).prop("checked"));
    });
});
</script>
@endpush