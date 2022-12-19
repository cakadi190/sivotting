<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <title>@stack('title') &mdash; E-Voting</title>

    <!-- Core Styling -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css?v=3.2.0') }}" />

    @stack('link')
    @stack('style')
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">

    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <!-- Left Sided Menu -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right Sided Menu -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="javascript:void(0)" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:signOut()" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            <a href="{{ route('home') }}" class="brand-link">
                <span class="brand-text font-weight-light">E-Voting</span>
            </a>

            <div class="sidebar">

                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ Gravatar::get(auth()->user()->email) }}" alt="{{ auth()->user()->name }}" class="img-circle elevation-2" />
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <div class="form-group">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu disini..." aria-label="Cari menu disini..." />
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-header">Dasbor</li>
                        <li class="nav-item">
                            <a href="{{ route('admin.home') }}" class="{{ Route::is('admin.home') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dasbor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.election-result') }}" class="{{ Route::is('admin.election-result') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-chart-pie"></i>
                                <p>Hasil Perolehan</p>
                            </a>
                        </li>

                        <li class="nav-header">Manajemen</li>
                        <li class="{{ Route::is('admin.user.*') ? 'nav-item menu-open' : 'nav-item' }}">
                            <a href="#" class="{{ Route::is('admin.user.*') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Data Pengguna
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.user.index') }}" class="{{ Route::is('admin.user.index') ? 'nav-link active' : 'nav-link' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lihat Semua</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.user.create') }}" class="{{ Route::is('admin.user.create') ? 'nav-link active' : 'nav-link' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Data Baru</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ Route::is('admin.candidate.*') ? 'nav-item menu-open' : 'nav-item' }}">
                            <a href="#" class="{{ Route::is('admin.candidate.*') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-thumbtack"></i>
                                <p>
                                    Data Kandidat
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.candidate.index') }}" class="{{ Route::is('admin.candidate.index') ? 'nav-link active' : 'nav-link' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lihat Semua</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.candidate.create') }}" class="{{ Route::is('admin.candidate.create') ? 'nav-link active' : 'nav-link' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Data Baru</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="{{ Route::is('admin.classroom.*') ? 'nav-item menu-open' : 'nav-item' }}">
                            <a href="#" class="{{ Route::is('admin.classroom.*') ? 'nav-link active' : 'nav-link' }}">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    Data Kelas
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.classroom.index') }}" class="{{ Route::is('admin.classroom.index') ? 'nav-link active' : 'nav-link' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Lihat Semua</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.classroom.create') }}" class="{{ Route::is('admin.classroom.create') ? 'nav-link active' : 'nav-link' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Tambah Data Baru</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">

            <section class="content-header">
                <div class="container-fluid">
                    @yield('header-content')
                </div>
            </section>

            <section class="content">
                @yield('content')
            </section>

        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Versi</b> 1.0.0
            </div>
            <div class="text-center text-md-left">Hak Cipta <script>document.write(new Date().getFullYear())</script> E-Voting by Dasa Kreativa Studio.</div>
        </footer>
    </div>

    <!-- Core Javascript -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js?v=3.2.0') }}"></script>

    <!-- Addons -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
    @stack('script')

    <script>
        function signOut() {
            Swal.fire({
                title: 'Apakah Kamu Yakin?',
                text: 'Apakah kamu yakin akan keluar dari sesi ini sekarang? Jika iya, simpan dulu pekerjaan kamu terus ulangi ke tombol "keluar" dan klik "keluar" sekarang juga.',
                icon: 'question',

                reverseButtons: true,
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Keluar',

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
                    window.location.href = '{{ route("login.logout") }}';
                }
            })
        }
    </script>
</body>
</html>
