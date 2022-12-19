@extends('layouts.app')

@push('title', 'Halaman Administrator')

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Beranda Dasbor</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Beranda Dasbor</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header">
        <h3 class="card-title">Selamat Datang!</h3>
    </div>
    <div class="card-body">
        Selamat datang di panel E-Voting, aplikasi pengambilan suara secara elektronik. Anda sekarang masuk menjadi Administrator, silahkan pilih menu dibawah ini untuk mengelola hingga mengatur sistem disini.
    </div>
</div>

<section id="summary-page" class="row">
    <div class="col-md-3">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-warning"><i class="fas fa-thumbtack"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Data Kandidat</span>
                <a href="{{ route('admin.candidate.index') }}" class="info-box-number">Klik Disini</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-danger"><i class="fas fa-layer-group"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Data Kelas</span>
                <a href="{{ route('admin.classroom.index') }}" class="info-box-number">Klik Disini</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Data Pengguna</span>
                <a href="{{ route('admin.user.index') }}" class="info-box-number">Klik Disini</a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="info-box shadow-sm">
            <span class="info-box-icon bg-success"><i class="fas fa-chart-pie"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Hasil Pemilihan</span>
                <a href="{{ route('admin.election-result') }}" class="info-box-number">Klik Disini</a>
            </div>
        </div>
    </div>
</section>
@endsection
