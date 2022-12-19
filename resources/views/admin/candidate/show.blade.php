@extends('layouts.app')

@push('title', "Kandidat \"{$data->name}\"")

@push('link')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
@endpush

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Kandidat "{{ $data->name }}"</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.candidate.index') }}">Kelola Kandidat</a></li>
            <li class="breadcrumb-item active">Kandidat "{{ $data->name }}"</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.candidate.index') }}" class="btn btn-primary mr-2"><i class="fas fa-arrow-left fa-fw"></i></a>
            <h3 class="card-title mb-0">Detail Kandidat</h3>
        </div>

        <div class="btn-group btn-group-sm ml-auto">
            <a href="{{ route('admin.candidate.edit', $data->id) }}" class="btn btn-warning"><i class="fas fa-pencil-alt fa-fw mr-2"></i><span>Edit</span></a>
            <button class="btn btn-danger" onclick="removeCandidate()"><i class="fas fa-trash fa-fw mr-1"></i><span>Hapus Kandidat</span></button>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.candidate.destroy', $data['id']) }}" method="post" id="remove-candidate">@method('delete') @csrf</form>
        <div class="row">
            <div class="col-md-4">
                <img src="{{ asset("image/{$data->photo}") }}" alt="{{ $data->name }}" class="card-img-top" />
            </div>
            <div class="col-md-8">
                <table class="table-striped table">
                    <tbody>
                        <tr>
                            <th>Nama Kandidat</th>
                            <td>{{ $data->name }}</td>
                        </tr>
                        <tr>
                            <th>Periode</th>
                            <td>{{ $data->period }}</td>
                        </tr>
                        <tr>
                            <th>Visi</th>
                            <td>{!! $data->vision !!}</td>
                        </tr>
                        <tr>
                            <th>Misi</th>
                            <td>{!! $data->mission !!}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Suara</th>
                            <td>{{ $data->getVotes->count() }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
