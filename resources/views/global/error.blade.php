@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('warning'))
<div class="alert alert-warning">
    <h3>Peringatan!</h3>
    <div>{{ session('warning') }}</div>
</div>
@endif

@if(session('danger'))
<div class="alert alert-danger">
    <h3>Kesalahan!</h3>
    <div>{{ session('danger') }}</div>
</div>
@endif

@if(session('info'))
<div class="alert alert-info">
    <h3>Informasi!</h3>
    <div>{{ session('info') }}</div>
</div>
@endif

@if(session('success'))
<div class="alert alert-success">
    <h3>Berhasil!</h3>
    <div>{{ session('success') }}</div>
</div>
@endif
