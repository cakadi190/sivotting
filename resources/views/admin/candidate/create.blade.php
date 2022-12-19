@extends('layouts.app')

@push('title', 'Tambah Data Kandidat')

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Tambah Data Kandidat</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.candidate.index') }}">Data Kandidat</a></li>
            <li class="breadcrumb-item active">Tambah Data Kandidat</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.candidate.store') }}" type="POST" class="card shadow-sm">
    @csrf

    <div class="card-header d-flex align-items-center">
        <a href="{{ route('admin.user.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        <h3 class="card-title ml-1 mb-0">Tambah Data Baru</h3>
    </div>
    <div class="card-body">
        @include('global.error')

        <div class="form-group row">
            <label for="name" class="col-md-3">Nama Kandidat</label>
            <div class="col-md">
                <input type="text" id="name" value="{{ old('name') }}" name="name" class="form-control" placeholder="Agus Budi Cahyono" />
            </div>
        </div>

        <div class="form-group row">
            <label for="photo" class="col-md-3">Foto Kandidat</label>
            <div class="col-md">
                <input type="file" id="photo" accept=".jpg,.png,.jpeg" name="photo" class="form-control" />
            </div>
        </div>

        <div class="form-group row">
            <label for="vision" class="col-md-3">Visi</label>
            <div class="col-md">
                <textarea name="vision" id="vision" cols="30" placeholder="Masukkan visi disini" rows="5" class="form-control">{{ old('vision') }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="mission" class="col-md-3">Misi</label>
            <div class="col-md">
                <textarea name="mission" id="mission" cols="30" placeholder="Masukkan misi disini" rows="5" class="form-control">{{ old('mission') }}</textarea>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Kirim dan Tambahkan</button>
    </div>
</form>
@endsection
