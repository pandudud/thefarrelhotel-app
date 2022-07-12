@extends('layouts.master')

@section('title', $title)

@section('content')
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{url('home')}}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="{{url('pengaturan/level')}}">Pengaturan Level</a>
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
                    <i class="icon-grid"></i>Tambah Level 
                </div>
                <div class="tools">
                    <a href="" class="fullscreen"> </a>
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-horizontal">

                    {!! Form::open(['route' => 'level.store', 'class' => 'form-horizontal']) !!}

                    <div class="form-body">

                        @if($errors->any())
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
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('name') ? 'has-error' : ''}}">
                                    {!! Form::label('name', 'Nama Level', ['class' => 'control-label col-md-3'] ) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name'] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('name') ? $errors->first('name') : 'Masukkan Nama Level' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('description') ? 'has-error' : ''}}">
                                    {!! Form::label('description', 'Deskripsi', ['class' => 'control-label col-md-3'] ) !!}
                                    <div class="col-md-9">
                                        {!! Form::text('description', null, ['class' => 'form-control', 'id' => 'description'] ) !!}
                                        <div class="form-control-focus"> </div>
                                        <span class="help-block">{{ $errors->has('description') ? $errors->first('description') : 'Masukkan Deskripsi' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="form-actions bottom">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-3"></div>
                                {!! Form::button('<i class="fa fa-check"></i> Simpan', ['class' => 'btn blue-sharp col-md-3 simpan', 'type' => 'submit', 'data-swa-text' => 'Menyimpan level']) !!}
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

@push('scripts')
<script src="{{ assets('pages/scripts/sweetalert2-scripts.js') }}" type="text/javascript"></script>
@endpush