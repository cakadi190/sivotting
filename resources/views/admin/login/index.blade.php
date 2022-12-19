@extends('layouts.auth')

@push('title', 'Masuk Dahulu')

@section('content')
    @include('global.error')

    <p class="login-box-msg">Silahkan Autentikasikan Diri Anda</p>

    <form action="{{ route('login.auth') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Surel" />
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>
        <div class="input-group mb-3">
            <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Kata Sandi" />
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" value="true" name="remember" />
                    <label for="remember">
                        Ingatkan Saya
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Masuk</button>
            </div>
            <!-- /.col -->
        </div>

        <!-- .forgot-password -->
        <a class="forot-password text-center d-block mt-3" href="">Lupa Kata Sandi?</a>
        <!-- /.forgot-password -->
    </form>
@endsection
