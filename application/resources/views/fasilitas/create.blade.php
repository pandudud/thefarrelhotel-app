@extends('layouts.master')

@section('title', $title)

@push('styles')
<link href="{{assets('global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{assets('global/plugins/dropzone/dropzone.min.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{url('home')}}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{url('fasilitas')}}">Fasilitas</a>
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
                    <i class="icon-grid"></i>Tambah Fasilitas 
                </div>
                <div class="tools">
                    <a href="" class="fullscreen"> </a>
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">

                    {!! Form::open(['route' => 'fasilitas.store', 'class' => 'form-horizontal']) !!}

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
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('facility_name') ? 'has-error' : ''}}">
                                    {!! Form::label('facility_name', 'Facility Name ID', ['class' => 'control-label col-md-2'] ) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('facility_name', null, ['class' => 'form-control', 'id' => 'facility_name', 'autofocus'] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('facility_name') ? $errors->first('facility_name') : 'Masukkan Nama Fasilitas Bahasa Indonesia' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('facility_name_eng') ? 'has-error' : ''}}">
                                    {!! Form::label('facility_name_eng', 'Facility Name English', ['class' => 'control-label col-md-2'] ) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('facility_name_eng', null, ['class' => 'form-control', 'id' => 'facility_name_eng', 'autofocus'] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('facility_name_eng') ? $errors->first('facility_name_eng') : 'Masukkan Nama Fasilitas Bahasa Inggris' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('facility_description') ? 'has-error' : ''}}">
                                    {!! Form::label('facility_description', 'Facility Description ID', ['class' => 'control-label col-md-2'] ) !!}
                                    <div class="col-md-10">
                                        {!! Form::textarea('facility_description', null, ['class' => 'form-control', 'id' => 'facility_description', 'autofocus'] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('facility_description') ? $errors->first('facility_description') : 'Masukkan Deskripsi Fasilitas Bahasa Inggris' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('facility_description_eng') ? 'has-error' : ''}}">
                                    {!! Form::label('facility_description_eng', 'Facility Description English', ['class' => 'control-label col-md-2'] ) !!}
                                    <div class="col-md-10">
                                        {!! Form::textarea('facility_description_eng', null, ['class' => 'form-control', 'id' => 'facility_description_eng', 'autofocus'] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('facility_description_eng') ? $errors->first('facility_description_eng') : 'Masukkan Deskripsi Fasilitas Bahasa Inggris' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('path') ? 'has-error' : ''}}">
                                {!! Form::label('path', 'Picture', ['class' => 'control-label col-md-2'] ) !!}
                                </div>
                            </div>
                        </div>
                        <div class="dropzone dropzone-file-area" id="my-dropzone" >
                            <div class="dz-default dz-message">
                                <h3 class="sbold">Drop files here or click to upload</h3>
                            </div>
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>
                        </div>
                            
                    </div>

                    <div class="form-actions bottom">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3"></div>
                                {!! Form::button('<i class="fa fa-check"></i> Simpan', ['class' => 'btn blue-sharp col-md-3 simpan', 'type' => 'submit', 'id' => 'submit', 'data-swa-text' => 'Menambahkan Data Fasilitas']) !!}
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
<script src="{{assets('global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
<script src="{{assets('global/plugins/dropzone/dropzone.min.js')}}" type="text/javascript"></script>
@endpush

@push('scripts')
<script src="{{ assets('pages/scripts/sweetalert2-scripts.js') }}" type="text/javascript"></script>
<script src="{{ assets('pages/scripts/form-dropzone-fasilitas.js') }}" type="text/javascript"></script>
@endpush


