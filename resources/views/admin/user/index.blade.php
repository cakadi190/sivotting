@extends('layouts.app')

@push('title', 'Kelola Pemilih')

@push('link')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
@endpush

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Kelola Pemilih</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Kelola Pemilih</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <button class="nav-link active" id="voter-tab" data-toggle="tab" data-target="#voter" type="button" role="tab" aria-controls="voter" aria-selected="true">Pemilih</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="admin-tab" data-toggle="tab" data-target="#admin" type="button" role="tab" aria-controls="admin" aria-selected="true">Pengelola</button>
            </li>
        </ul>

        <div class="btn-group btn-group-sm ml-auto">
            <button class="btn btn-danger" onclick="truncateVoter()"><i class="fas fa-fw fa-times mr-2"></i><span>Reset Semua Data</span></button>
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary"><i class="fas fa-fw fa-plus mr-2"></i><span>Tambah Data</span></a>
        </div>
    </div>
    <div class="tab-content card-body" id="myTabContent">
        <div class="tab-pane fade show active" id="voter" role="tabpanel" aria-labelledby="voter-tab">
            <div class="table-responsive border">
                <table id="voter" class="w-100 table table-striped mb-0 table-hover">
                    <thead>
                        <th>ID / NISN</th>
                        <th>Nama Lengkap</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @isset($query['voter'])
                        @foreach($query['voter'] as $data)
                        <tr>
                            @php
                                $gender['l'] = 'Laki-Laki';
                                $gender['p'] = 'Perempuan';
                            @endphp
                            <td>{{ $data->id }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->getClass->classname }}</td>
                            <td>{{ $gender[$data->gender] }}</td>
                            <td>
                                <form action="{{ route('admin.user.destroy', $data->id) }}" id="voter-{{ $data->id }}" method="post">@method('delete') @csrf</form>
                                <div class="btn-group btn-group-sm">
                                    <button onclick="removeUser('#voter-{{ $data->id }}')" class="btn btn-danger"@if(auth()->id() == $data->id) disabled @endif><i class="fas fa-trash"></i></button>
                                    <a href="{{ route('admin.user.edit', $data->id) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="admin-tab">
            <div class="table-responsive border">
                <table id="admin" class="w-100 table table-striped mb-0 table-hover">
                    <thead>
                        <th>Nama Lengkap</th>
                        <th>Surel</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach($query['admin'] as $data)
                        <tr>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>
                                <form action="{{ route('admin.user.destroy', $data->id) }}" id="admin-{{ $data->id }}" method="post">@method('delete') @csrf</form>
                                <div class="btn-group btn-group-sm">
                                    <button onclick="removeUser('#admin-{{ $data->id }}')" class="btn btn-danger"@if(auth()->id() == $data->id) disabled @endif><i class="fas fa-trash"></i></button>
                                    <a href="{{ route('admin.user.edit', $data->id) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@push('script')
    <script>
        function truncateVoter() {
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: 'Apakah kamu yakin akan menghapus semua pemilih? Data yang dihapus tidak dapat dikembalikan lagi.',
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
                    window.location.href = "{{ route('admin.user.truncate') }}"
                }
            })
        }
    </script>

    <script>
        function removeUser($id) {
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: 'Apakah kamu yakin akan menghapus pengguna ini? Data yang dihapus tidak dapat dikembalikan lagi.',
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
                    $($id).submit();
                }
            })
        }
    </script>

    <script>
        $('table#voter, table#admin').DataTable({
			dom:        "<'dt--top-section px-3 pt-3 pb-2'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + "<'table-responsive w-100'tr>" + "<'dt--bottom-section px-3 pt-3 pb-2 d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
        });
    </script>
@endpush
