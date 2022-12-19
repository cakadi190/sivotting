@extends('layouts.app')

@push('title', "Ubah Data \"{$user->name}\"")

@push('link')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
@endpush

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Ubah Data "{{ $user->name }}"</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Data Pengguna</a></li>
            <li class="breadcrumb-item active">Ubah Data "{{ $user->name }}"</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.user.update', $user->id) }}" type="POST" class="card shadow-sm">
    @csrf
    @method('put')

    <div class="card-header d-flex align-items-center">
        <a href="{{ route('admin.user.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        <h3 class="card-title ml-1 mb-0">Ubah Data</h3>
    </div>
    <div class="card-body">
        @include('global.error')

        @if($user->role == 'voter')
        <div class="form-group row">
            <label for="role" class="col-md-3">Hak Akses</label>
            <div class="col-md">
                <select name="role" id="role" required class="form-control">
                    <option disabled selected>Pilih Hak Akses</option>
                    <option @if(old('role') == 'admin' OR $user->role == 'admin') selected @endif value="admin">Administrator</option>
                    <option @if(old('role') == 'voter' OR $user->role == 'voter') selected @endif value="voter">Pemilih</option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="id" class="col-md-3">NISN / ID</label>
            <div class="col-md">
                <input type="number" disabled class="form-control" value="{{ old('id', $user->id) }}" id="id" name="id" placeholder="123456789" />
            </div>
        </div>
        @endif

        <div class="form-group row">
            <label for="name" class="col-md-3">Nama Lengkap</label>
            <div class="col-md">
                <input type="text" class="form-control" value="{{ old('name', $user->name) }}" id="name" name="name" placeholder="Bagas Purwanto" />
            </div>
        </div>

        @if($user->role == 'voter')
        <div class="form-group row">
            <label for="classroom" class="col-md-3">Kelas</label>
            <div class="col-md">
                <select name="classroom" id="classroom" class="form-control">
                    <option disabled selected>Pilih Kelas</option>
                    @foreach ($class as $kelas)
                    <option @if(old('classroom') == $kelas->id OR $user->classroom == $kelas->id) selected @endif value="{{ $kelas->id }}">{{ $kelas->classname }}</option>
                    @endforeach
                </select>
                <div class="form-text">Tidak ada daftar kelas yang dicari? Buat dulu <a href="{{ route('admin.classroom.create') }}">di sini</a>.</div>
            </div>
        </div>

        <div class="form-group row">
            <label for="gender" class="col-md-3">Jenis Kelamin</label>
            <div class="col-md">
                <div class="d-flex">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="man" name="gender" @if(old('gender') == 'l' OR $user->gender == 'l') checked @endif class="custom-control-input" value="l" />
                        <label class="custom-control-label" for="man">Laki-Laki</label>
                    </div>
                    <div class="custom-control ml-2 custom-radio">
                        <input type="radio" id="woman" name="gender" @if(old('gender') == 'p' OR $user->gender == 'p') checked @endif class="custom-control-input" value="p" />
                        <label class="custom-control-label" for="woman">Perempuan</label>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($user->role == 'admin')
        <div class="form-group row">
            <label for="email" class="col-md-3">Surel</label>
            <div class="col-md">
                <input type="email" class="form-control" value="{{ old('email', $user->email) }}" id="email" name="email" placeholder="surel@gmail.com" />
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-3">Kata Sandi</label>
            <div class="col-md">
                <input type="password" class="form-control" id="password" name="password" placeholder="Sandi yang kamu inginkan" />
            </div>
        </div>
        @endif
    </div>
    <div class="card-footer d-flex justify-content-end">
        <div class="btn-group">
            <button type="button" @if(auth()->id() !== ((int) $id)) onclick="removeUser()" @else disabled @endif class="btn btn-danger"><i class="fas fa-trash fa-fw mr-1"></i><span>Hapus Pengguna</span></button>
            <button type="submit" class="btn btn-primary">Kirim dan Ubah</button>
        </div>
    </div>
</form>
<form action="{{ route('admin.user.destroy', $user->id) }}" id="hapus" method="post">@method('delete') @csrf</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@if(auth()->id() !== ((int) $id))
    @push('script')
        <script>
            function removeUser() {
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
                        $('#hapus').submit();
                    }
                })
            }
        </script>
    @endpush
@endif

@push('script')
    <script>
        $('select#classroom').select2({
            dropdownParent:	$('select#classroom').parent(),
            placeholder:	'Pilih Salah Satu',
            width:			'100%',
            theme:			'bootstrap4',
            language:		'id'
        });
    </script>
    <script>
        $('select#role').select2({
            dropdownParent:	$('select#role').parent(),
            placeholder:	'Pilih Salah Satu',
            width:			'100%',
            theme:			'bootstrap4',
            language:		'id',
            disabled:       true
        }).on('select2:select', function (e) {
            var data = e.params.data;

            if(data.id == 'admin') {
                $('input#id').removeAttr('required')
                $('input#id').parents('.form-group').addClass('d-none');
            } else if(data.id == 'voter') {
                $('input#id').prop('required', true)
                $('input#id').parents('.form-group').removeClass('d-none');
            }
        });
    </script>
@endpush
