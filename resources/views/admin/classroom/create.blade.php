@extends('layouts.app')

@push('title', 'Tambah Data Kelas')

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Tambah Data Kelas</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.classroom.index') }}">Data Kelas</a></li>
            <li class="breadcrumb-item active">Tambah Data Kelas</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.classroom.store') }}" type="POST" class="card shadow-sm">
    @csrf

    <div class="card-header d-flex align-items-center">
        <a href="{{ route('admin.user.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        <h3 class="card-title ml-1 mb-0">Tambah Data Baru</h3>
    </div>
    <div class="card-body">
        @include('global.error')

        <div class="form-group row">
            <label for="classname" class="col-md-3">Nama Kelas</label>
            <div class="col-md">
                <input type="text" id="classname" value="{{ old('classname') }}" name="classname" class="form-control" placeholder="IX atau XII Akuntansi" />
            </div>
        </div>
        <div class="form-group row">
            <label for="enable" class="col-md-3">Aktifkan</label>
            <div class="col-md">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="enable" @if(old('enable')) checked @endif name="enable" value="1" />
                    <label class="custom-control-label" for="enable">Aktifkan Kelas Ini</label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Kirim dan Tambahkan</button>
    </div>
</form>
@endsection
