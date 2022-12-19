@extends('layouts.app')

@push('title', "Ubah Data \"{$data->name}\"")

@push('link')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
@endpush

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Ubah Data "{{ $data->name }}"</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.candidate.index') }}">Data Kandidat</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.candidate.show', $data->id) }}">{{ $data->name }}</a></li>
            <li class="breadcrumb-item active">Ubah Data</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<form action="{{ route('admin.candidate.destroy', $data['id']) }}" method="post" id="remove-candidate">@method('delete') @csrf</form>
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.candidate.update', $data->id) }}" type="POST" class="card shadow-sm">
    @csrf
    @method('put')

    <div class="card-header d-flex align-items-center">
        <a href="{{ route('admin.user.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        <h3 class="card-title ml-1 mb-0">Tambah Data Baru</h3>
    </div>
    <div class="card-body">
        @include('global.error')

        <div class="form-group row">
            <label for="name" class="col-md-3">Nama Kandidat</label>
            <div class="col-md">
                <input type="text" id="name" value="{{ old('name', $data->name) }}" name="name" class="form-control" placeholder="Agus Budi Cahyono" />
            </div>
        </div>

        <div class="form-group row">
            <label for="photo" class="col-md-3">Foto Kandidat</label>
            <div class="col-md">
                <img src="{{ asset("image/{$data->photo}") }}" alt="{{ $data->name }}" class="w-50 mb-3 rounded" />
                <input type="file" id="photo" accept=".jpg,.png,.jpeg" name="photo" class="form-control" />
            </div>
        </div>

        <div class="form-group row">
            <label for="vision" class="col-md-3">Visi</label>
            <div class="col-md">
                <textarea name="vision" id="vision" cols="30" placeholder="Masukkan visi disini" rows="5" class="form-control">{{ old('vision', $data->vision) }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label for="mission" class="col-md-3">Misi</label>
            <div class="col-md">
                <textarea name="mission" id="mission" cols="30" placeholder="Masukkan misi disini" rows="5" class="form-control">{{ old('mission', $data->mission) }}</textarea>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <div class="btn-group btn-group-sm">
            <button type="button" onclick="removeCandidate()" class="btn btn-danger"><i class="fas fa-trash fa-fw mr-1"></i><span>Hapus Kandidat</span></button>
            <button type="submit" class="btn btn-primary">Kirim dan Ubah</button>
        </div>
    </div>
</form>
@endsection

@push('script')
<script>
    function removeCandidate() {
        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: 'Apakah kamu yakin akan menghapus kandidat ini? Data yang dihapus tidak dapat dikembalikan lagi.',
            icon: 'question',

            reverseButtons: true,
            showCancelButton: true,
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hapus',

            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton:  'btn btn-light',
            },
            buttonsStyling: false,
        }).then(res => {
            if(res.isConfirmed) {
                Swal.fire({
                    icon:				'info',
                    title:				'Tunggu sebentar',
                    text:				'Tunggu sebentar, kami sedang memproses permintaan anda.',
                    didOpen: 			() => {
                        Swal.showLoading();
                    },
                    allowEscapeKey:		false,
                    allowOutsideClick:	false,
                    backdrop: 			true,
                })
                $('#remove-candidate').submit();
            }
        })
    }
</script>
@endpush
