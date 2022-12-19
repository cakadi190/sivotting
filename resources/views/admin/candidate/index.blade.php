@extends('layouts.app')

@push('title', 'Kelola Kandidat')

@push('link')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
@endpush

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Kelola Kandidat</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Kelola Kandidat</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header row align-items-center justify-content-between">
        <div class="col-md-3">
            <select name="row" id="row" class="form-control w-25">
                <option selected disabled>Pilih Periode</option>
                @foreach ($query->toArray() as $index => $data)
                <option @if($index == $period) selected @endif value="{{ str_replace('/', '', $index) }}">{{ $index }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 ml-auto">
            <div class="btn-group btn-group-sm ml-auto w-100">
                <a href="{{ route('admin.candidate.create') }}" class="btn btn-primary"><i class="fas fa-fw fa-plus mr-2"></i><span>Tambah Data</span></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs d-none">
            @foreach ($query->toArray() as $index => $data)
            <li class="nav-item">
                <button class="@if($index == $period) nav-link active @else nav-link @endif" id="row-{{ str_replace('/', '', $index) }}-tab" data-toggle="tab" data-target="#row-{{ str_replace('/', '', $index) }}" type="button" role="tab" aria-controls="row-{{ str_replace('/', '', $index) }}" aria-selected="true">{{ $index }}</button>
            </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @php $i = 0; @endphp
            @forelse ($query->toArray() as $index => $data)
                <div class="tab-pane fade @if($index == $period) show active @elseif($i == 0 && $index == $period) show active @endif" id="row-{{ str_replace('/', '', $index) }}">
                    @php $i++; @endphp
                    <div class="row">
                        @forelse ($data as $data)
                        <div class="col-md-3">
                            <div class="card shadow-sm">
                                <img src="{{ asset("image/{$data['photo']}") }}" alt="{{ $data['name'] }}" class="card-img-top" />
                                <div class="card-body">
                                    <h3 class="card-title text-center d-block w-100">{{ $data['name'] }}</h3>

                                    <div class="btn-group mt-2 justify-content-center w-100">
                                        <a href="{{ route('admin.candidate.edit', $data['id']) }}" class="btn btn-warning"><i class="fas fa-pencil-alt"></i></a>
                                        <a href="{{ route('admin.candidate.show', $data['id']) }}" class="btn btn-success"><i class="fas fa-eye"></i></a>
                                        <button class="btn btn-danger" onclick="removeCandidate('#candidate-{{ $data['id'] }}')" type="button"><i class="fas fa-trash"></i></button>
                                    </div>

                                    <form action="{{ route('admin.candidate.destroy', $data['id']) }}" method="post" id="candidate-{{ $data['id'] }}">@method('delete') @csrf</form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                            <div class="text-center">Maaf data tidak ada.</div>
                        </div>
                        @endforelse
                    </div>
                </div>
            @empty
            <div class="col-md-12">
                <div class="text-center">Maaf data tidak ada.</div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('script')
    <script>
        $('select#row').select2({
            dropdownParent:	$('select#row').parent(),
            placeholder:	'Pilih Periode',
            width:			'100%',
            containerCssClass: 'w-25',
            theme:			'bootstrap4',
            language:		'id',
        }).on('select2:select', function (e) {
            var data = e.params.data;
            $(`#row-${data.id}-tab`).tab('show')
        });
    </script>

    <script>
        function removeCandidate($id) {
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
                    $($id).submit();
                }
            })
        }
    </script>
@endpush
