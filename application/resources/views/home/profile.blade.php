@extends('layouts.master')

@section('title', $title)

@push('styles')
<link href="{{assets('global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
<link href="{{assets('pages/css/profile.css')}}" rel="stylesheet" type="text/css" />
@endpush

@section('content')
<div class="page-bar margin-bottom-20">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('home') }}">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Profile</span>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="profile-sidebar">
            <div class="portlet light profile-sidebar-portlet ">
                <div class="profile-userpic">
                    <img src="{{Avatar::create($user->name)->toBase64()}}" class="img-responsive" alt="">
                </div>
                <div class="profile-usertitle" style="padding-bottom: 20px;">
                    <div class="profile-usertitle-name"> {{$user->name}} </div>
                    <div class="profile-usertitle-job"> {{$user->level->name}} </div>
                </div>
            </div>
        </div>
        <!-- BEGIN PROFILE CONTENT -->
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light ">
                        <div class="portlet-title tabbable-line">
                            <div class="caption caption-md">
                                <i class="icon-globe theme-font hide"></i>
                                <span class="caption-subject font-blue-madison bold uppercase"></span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab">Data Pengguna</a>
                                </li>
                                <li>
                                    <a href="#tab_1_2" data-toggle="tab">Ubah Password</a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1_1">
                                    {!! Form::model($user, [
                                        'url' => 'home/change-profile'
                                    ]) !!}
                                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('name') ? 'has-error' : ''}}">
                                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                                            <label for="name">Nama Lengkap</label>
                                            <span class="help-block">{{ $errors->has('name') ? $errors->first('name') : 'Masukkan Nama Lengkap' }}</span>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('email') ? 'has-error' : ''}}">
                                            {!! Form::text('email', null, ['class' => 'form-control', 'id' => 'email']) !!}
                                            <label for="email">Email</label>
                                            <span class="help-block">{{ $errors->has('email') ? $errors->first('email') : 'Masukkan Email' }}</span>
                                        </div>
                                        <div class="margin-top-10">
                                            {!! Form::button('Simpan', ['class' => 'btn blue-sharp simpan', 'type' => 'submit', 'data-swa-text' => 'Menyimpan data']) !!}
                                            <a href="{{url('home')}}" class="btn default"> Batal </a>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                                <div class="tab-pane" id="tab_1_2">
                                    {!! Form::open(['url' => 'home/change-password']) !!}
                                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('old_password') ? 'has-error' : ''}}">
                                            {!! Form::password('old_password', ['class' => 'form-control', 'id' => 'old_password']) !!}
                                            <label for="old_password">Password Lama</label>
                                            <span class="help-block">{{ $errors->has('old_password') ? $errors->first('old_password') : 'Masukkan Password Lama' }}</span>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('password') ? 'has-error' : ''}}">
                                            {!! Form::password('password', ['class' => 'form-control', 'id' => 'password']) !!}
                                            <label for="password">Password Baru</label>
                                            <span class="help-block">{{ $errors->has('password') ? $errors->first('password') : 'Masukkan Password Baru' }}</span>
                                        </div>
                                        <div class="form-group form-md-line-input form-md-floating-label {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                                            {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation']) !!}
                                            <label for="password_confirmation">Ulangi Password</label>
                                            <span class="help-block">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : 'Ulangi Password' }}</span>
                                        </div>
                                        <div class="margin-top-10">
                                            {!! Form::button('Ubah Password', ['class' => 'btn blue-sharp simpan', 'type' => 'submit', 'data-swa-text' => 'Mengubah password']) !!}
                                            <a href="{{url('home')}}" class="btn default"> Batal </a>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
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
<script src="{{assets('global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
<script src="{{assets('global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
@endpush

@push('scripts')
<script src="{{ assets('pages/scripts/sweetalert2-scripts.js') }}" type="text/javascript"></script>
<script src="{{assets('pages/scripts/profile.js')}}" type="text/javascript"></script>
@endpush