@extends('layouts.app')

@push('title', 'Hasil Pemilu')

@push('link')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css" />
@endpush

@section('header-content')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Hasil Pemilu</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Beranda</a></li>
            <li class="breadcrumb-item active">Hasil Pemilu</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header row align-items-center justify-content-between">
        <div class="col-md">
            <h3 class="mb-0 card-title mr-auto">Hasil Pemilu</h3>
        </div>
        <div class="col-md-2">
            <select name="row" id="row" class="form-control w-25 ml-auto">
                <option selected disabled>Pilih Periode</option>
                @foreach ($candidate->toArray() as $index => $data)
                <option @if($index == $period) selected @endif value="{{ str_replace('/', '', $index) }}">{{ $index }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <ul class="nav nav-tabs d-none">
        @foreach ($candidate->toArray() as $index => $data)
        <li class="nav-item">
            <button class="@if($index == $period) nav-link active @else nav-link @endif" id="row-{{ str_replace('/', '', $index) }}-tab" data-toggle="tab" data-target="#row-{{ str_replace('/', '', $index) }}" type="button" role="tab" aria-controls="row-{{ str_replace('/', '', $index) }}" aria-selected="true">{{ $index }}</button>
        </li>
        @endforeach
    </ul>
    <div class="card-body">
        <div class="tab-content">
            @php $i = 0; @endphp
            @forelse ($candidate as $index => $data)
                <div class="tab-pane fade @if($index == $period) show active @elseif($i == 0 && $index == $period) show active @endif" id="row-{{ str_replace('/', '', $index) }}">
                    @php $i++; @endphp

                    <div class="table-responsive rounded">
                        <table class="table table-striped border table-hovered">
                            <thead>
                                <th>Kandidat</th>
                                <th>Jumlah Suara</th>
                            </thead>
                            <tbody>
                                @foreach ($data as $data)
                                <tr>
                                    <th>{{ $data->name }}</th>
                                    <td>{{ $data->getVotes->count() }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <canvas id="grafik-tahun-{{ str_replace('/', '', $index) }}" class="d-none"></canvas>
                    <img src="" id="grafik-gambar-{{ str_replace('/', '', $index) }}" alt="" class="w-100 rounded" />
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('script')
    @foreach ($candidate as $index => $data)

    @php
        $candidates = [];
        $votes = [];

        for($i = 0;$i < $data->count();$i++) {
            $candidates[$i] = $data[$i]->name;
            $votes[$i] = $data[$i]->getVotes->count();
        }
    @endphp

    <script>
        const ctx = document.getElementById('grafik-tahun-{{ str_replace('/', '', $index) }}');

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($candidates) !!},
                datasets: [{
                label: '# of Votes',
                data: {!! json_encode($votes) !!},
                borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                animation: {
                    onComplete: function () {
                        $('#grafik-gambar-{{ str_replace('/', '', $index) }}').attr('src', chart.toBase64Image());
                    },
                },
            }
        });
    </script>
    @endforeach
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
@endpush
