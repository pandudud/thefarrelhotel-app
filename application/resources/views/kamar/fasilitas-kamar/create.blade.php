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
            <a href="{{url('kamar/fasilitas-kamar')}}">Fasilitas Kamar</a>
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
                    <i class="icon-grid"></i>Tambah Fasilitas Kamar 
                </div>
                <div class="tools">
                    <a href="" class="fullscreen"> </a>
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">

                    {!! Form::open(['route' => 'fasilitas-kamar.store', 'class' => 'form-horizontal']) !!}

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
                                    {!! Form::label('facility_name', 'Room Facility Name', ['class' => 'control-label col-md-2'] ) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('facility_name', null, ['class' => 'form-control', 'id' => 'facility_name', 'autofocus'] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('facility_name') ? $errors->first('facility_name') : 'Masukkan Nama Fasilitas Kamar' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('icon_fa') ? 'has-error' : ''}}">
                                    {!! Form::label('icon_fa', 'Icon Fa', ['class' => 'control-label col-md-2'] ) !!}
                                    <div class="col-md-10">
                                        {!! Form::text('icon_fa', null, ['class' => 'form-control', 'id' => 'icon_fa', 'autofocus'] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('icon_fa') ? $errors->first('icon_fa') : 'Masukkan Icon Fa' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                            
                    </div>

                    <div class="form-actions bottom">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3"></div>
                                {!! Form::button('<i class="fa fa-check"></i> Simpan', ['class' => 'btn blue-sharp col-md-3 simpan', 'type' => 'submit', 'data-swa-text' => 'Menyimpan Fasilitas Kamar']) !!}
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
<script src="{{ assets('pages/scripts/form-dropzone-around.js') }}" type="text/javascript"></script>
@endpush


