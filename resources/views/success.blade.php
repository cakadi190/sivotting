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
        <div class="col-md-6">
            <div class="login-logo">
                <a href="{{ route('home') }}" class="d-flex align-items-center justify-content-center">
                    <img src="{{ asset('assets/osis.png') }}" alt="OSIS SMP Negeri 1 Turi" height="96" />
                    <img src="{{ asset('assets/2turi.png') }}" alt="SMP Negeri 1 Turi" height="96" />
                </a>
            </div>
            <!-- /.login-logo -->
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h3>Terima Kasih!</h3>
                </div>
                <div class="card-body login-card-body">
                    <p>Terima Kasih Telah Berpartisipasi Dalam Pemilihan Calon Ketua Osis Periode {{ $period }}. Silahkan klik dibawah ini untuk keluar dari sesi.</p>

                    <a href="{{ route('home') }}" class="btn btn-primary d-block"><i class="fas fa-home fa-fw mr-2"></i>Ke Beranda</a>
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
</body>
</html>
