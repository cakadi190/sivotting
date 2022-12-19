@extends('layouts.app')

@push('title', 'Tambah Data Pengguna')

@push('link')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
@endpush

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Tambah Data Pengguna</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Data Pengguna</a></li>
            <li class="breadcrumb-item active">Tambah Data Pengguna</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<form method="POST" action="{{ route('admin.user.store') }}" type="POST" class="card shadow-sm">
    @csrf

    <div class="card-header d-flex align-items-center">
        <a href="{{ route('admin.user.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i></a>
        <h3 class="card-title ml-1 mb-0">Tambah Data Baru</h3>
    </div>
    <div class="card-body">
        @include('global.error')

        <div class="form-group row">
            <label for="role" class="col-md-3">Hak Akses</label>
            <div class="col-md">
                <select name="role" id="role" required class="form-control">
                    <option disabled selected>Pilih Hak Akses</option>
                    <option @if(old('role') == 'admin') selected @endif value="admin">Administrator</option>
                    <option @if(old('role') == 'voter') selected @endif value="voter">Pemilih</option>
                </select>
            </div>
        </div>
        <div class="form-group row @if(old('role') == 'admin') d-none @endif">
            <label for="id" class="col-md-3">NISN / ID</label>
            <div class="col-md">
                <input type="number" class="form-control" value="{{ old('id') }}" id="id" name="id" placeholder="123456789" />
            </div>
        </div>

        <div class="form-group row">
            <label for="name" class="col-md-3">Nama Lengkap</label>
            <div class="col-md">
                <input type="text" class="form-control" value="{{ old('name') }}" id="name" name="name" placeholder="Bagas Purwanto" />
            </div>
        </div>

        <div class="form-group row @if(!old('role') OR old('role') == 'voter') d-none @endif">
            <label for="email" class="col-md-3">Surel</label>
            <div class="col-md">
                <input type="email" class="form-control" value="{{ old('email') }}" id="email" name="email" placeholder="surel@gmail.com" />
            </div>
        </div>

        <div class="form-group row @if(!old('role') OR old('role') == 'voter') d-none @endif">
            <label for="password" class="col-md-3">Kata Sandi</label>
            <div class="col-md">
                <input type="password" class="form-control" value="{{ old('password') }}" id="password" name="password" placeholder="Sandi yang kamu inginkan" />
            </div>
        </div>

        <div class="form-group row @if(old('role') == 'admin') d-none @endif">
            <label for="classroom" class="col-md-3">Kelas</label>
            <div class="col-md">
                <select name="classroom" id="classroom" class="form-control">
                    <option disabled selected>Pilih Kelas</option>
                    @foreach ($class as $kelas)
                    <option @if(old('classroom') == $kelas->id) selected @endif value="{{ $kelas->id }}">{{ $kelas->classname }}</option>
                    @endforeach
                </select>
                <div class="form-text">Tidak ada daftar kelas yang dicari? Buat dulu <a href="{{ route('admin.classroom.create') }}">di sini</a>.</div>
            </div>
        </div>
        <div class="form-group row @if(old('role') == 'admin') d-none @endif">
            <label for="gender" class="col-md-3">Jenis Kelamin</label>
            <div class="col-md">
                <div class="d-flex">
                    <div class="custom-control custom-radio">
                        <input type="radio" id="man" name="gender" @if(old('gender') == 'l') checked @endif class="custom-control-input" value="l" />
                        <label class="custom-control-label" for="man">Laki-Laki</label>
                    </div>
                    <div class="custom-control ml-2 custom-radio">
                        <input type="radio" id="woman" name="gender" @if(old('gender') == 'p') checked @endif class="custom-control-input" value="p" />
                        <label class="custom-control-label" for="woman">Perempuan</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Kirim dan Tambahkan</button>
    </div>
</form>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

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
            language:		'id'
        }).on('select2:select', function (e) {
            var data = e.params.data;

            if(data.id == 'admin') {
                $('input#id,select#classroom,.custom-control').removeAttr('required');
                $('input#id,select#classroom,.custom-control').parents('.form-group').addClass('d-none');
                $('input#email,input#password').parents('.form-group').removeClass('d-none');
            } else if(data.id == 'voter') {
                $('input#id,select#classroom,.custom-control').prop('required', true);
                $('input#id,select#classroom,.custom-control').parents('.form-group').removeClass('d-none');
                $('input#email,input#password').parents('.form-group').addClass('d-none');
            }
        });
    </script>
@endpush
