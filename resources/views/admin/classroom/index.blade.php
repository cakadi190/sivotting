@extends('layouts.app')

@push('title', 'Kelola Kelas')

@push('link')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" />
@endpush

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Kelola Kelas</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Kelola Kelas</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header d-flex align-items-center justify-content-center justify-content-md-between">
        <h3 class="mb-0 card-title">Data Kelas</h3>

        <div class="btn-group btn-group-sm ml-auto">
            <button class="btn btn-danger" onclick="truncateClasses()"><i class="fas fa-fw fa-times mr-2"></i><span>Reset Semua Data</span></button>
            <a href="{{ route('admin.classroom.create') }}" class="btn btn-primary"><i class="fas fa-fw fa-plus mr-2"></i><span>Tambah Data</span></a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive border">
            <table class="w-100 table table-striped mb-0 table-hover">
                <thead>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </thead>
                <tbody>
                    @foreach($query as $data)
                    <tr>
                        <td>{{ $data->classname }}</td>
                        <td>
                            @if ($data->enable == true)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-warning">Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.classroom.destroy', $data->id) }}" id="class-{{ $data->id }}" method="post">@method('delete') @csrf</form>
                            <div class="btn-group btn-group-sm">
                                <button onclick="removeClass('#class-{{ $data->id }}')" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                <a href="{{ route('admin.classroom.edit', $data->id) }}" class="btn btn-success"><i class="fas fa-pencil-alt"></i></a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
        function truncateClasses() {
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: 'Apakah kamu yakin akan menghapus semua kelas ini? Data yang dihapus tidak dapat dikembalikan lagi.',
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
                    window.location.href = "{{ route('admin.classroom.truncate') }}"
                }
            })
        }
    </script>

    <script>
        function removeClass($id) {
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: 'Apakah kamu yakin akan menghapus kelas? Data yang dihapus tidak dapat dikembalikan lagi.',
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
        $('table').DataTable({
			dom:        "<'dt--top-section px-3 pt-3 pb-2'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" + "<'table-responsive w-100'tr>" + "<'dt--bottom-section px-3 pt-3 pb-2 d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
        });
    </script>
@endpush
