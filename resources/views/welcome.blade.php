@extends('layouts.auth')

@push('title', 'Selamat Datang!')

@section('content')
<h3 class="text-center">Selamat Datang di E-Votting!</h3>
<p class="text-center">Silahkan tekan tombol dibawah ini untuk melanjutkan pemilihan ketua osis masa bakti {{ $period }}.</p>

<a href="{{ route('vote') }}" class="btn btn-block btn-primary"><span>Mulai Memilih</span><i class="fas fa-arrow-right fa-fw ml-1"></i></a>
@endsection
