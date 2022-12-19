<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Pilih Kandidatmu! &mdash; E-Votting</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}" />
</head>

<body class="container bg-light">
    <div class="row min-vh-100 align-items-center justify-content-center">
        <div class="col-md-10">
            <div class="login-logo">
                <a href="{{ route('home') }}" class="d-flex align-items-center justify-content-center">
                    <img src="{{ asset('assets/osis.png') }}" alt="OSIS SMP Negeri 1 Turi" height="96" />
                    <img src="{{ asset('assets/2turi.png') }}" alt="SMP Negeri 1 Turi" height="96" />
                </a>
            </div>
            <!-- /.login-logo -->
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h3>Daftar Calon Ketua Osis Periode {{ $period }}</h3>
                </div>
                <div class="card-body login-card-body">

                    @include('global.error')
                    <div class="row">
                        @forelse ($candidate[$period]->toArray() as $index => $data)
                        <div class="col-md-3">
                            <div class="mb-4">
                                <img src="{{ asset("image/{$data['photo']}") }}" alt="{{ $data['name'] }}" class="rounded w-100" />
                                <h3 class="card-title font-weight-bold text-center mt-1 w-100 d-block">{{ $data['name'] }}</h3>
                            </div>

                            <div class="pt-2">
                                <a href="#" type="button" data-toggle="modal" data-target="#modalCalon-{{ $data['id'] }}" class="btn btn-block btn-warning"><i class="fas fa-info-circle fa-fw mr-2"></i><span>Detail Calon</span></a>
                                <a href="{{ route('votting', $data['id']) }}" class="btn-vote btn btn-block btn-success"><i class="fas fa-check-circle fa-fw mr-2"></i><span>Beri Suara</span></a>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="modalCalon-{{ $data['id'] }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalCalon-{{ $data['id'] }}Label" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalCalon-{{ $data['id'] }}Label">Informasi Calon "{{ $data['name'] }}"</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img src="{{ asset("image/{$data['photo']}") }}" alt="{{ $data['name'] }}" class="rounded w-100" />
                                            </div>
                                            <div class="col-md-8">
                                                <table class="table-striped table">
                                                    <tbody>
                                                        <tr>
                                                            <th>Nama Kandidat</th>
                                                            <td>{{ $data['name'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Periode</th>
                                                            <td>{{ $data['period'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Visi</th>
                                                            <td>{!! $data['vision'] !!}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Misi</th>
                                                            <td>{!! $data['mission'] !!}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Kembali</button>
                                        <a href="{{ route('votting', $data['id']) }}" class="btn-vote btn btn-primary">Berikan Suaramu!</a>
                                    </div>
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
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.btn-vote').click(function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: 'Apakah kamu yakin akan memilih calon ketua OSIS ini? Lebih teliti lagi ya untuk memilih, karena ketua OSISmu ini adalah masa depan sekolahmu juga.',
                icon: 'warning',

                reverseButtons: true,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Pilih Sekarang!',

                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton:  'btn btn-light',
                },
                buttonsStyling: false,
            }).then(e => {
                if(e.isConfirmed) {
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
                    window.location.href = `${$(this).attr("href")}`;
                }
            })
        })
    </script>
</body>
</html>
