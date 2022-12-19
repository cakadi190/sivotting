<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Proses Autentikasi - Memproses aksi autentikasi para administrator
     *
     * @see https://laravel.com/docs/8.x/authentication#authenticating-users Autentikasi dengan laravel
     * @see https://laravel.com/docs/8.x/validation#quick-writing-the-validation-logic Validasi inputan
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        # Check the request
        $request->validate([
            'email'    => ['required', 'email', 'min:5'],
            'password' => ['required', 'min:8'],
        ]);

        # If Passed
        $input    = collect($request->only('email', 'password'))->put('role', 'admin');
        $remember = filter_var($request->remember, FILTER_VALIDATE_BOOLEAN);
        $auth     = auth()->attempt($input->toArray(), $remember);

        if($auth) {
            return redirect()->route('admin.home');
        } else {
            return back()->with('danger', 'Maaf, pengguna tidak dapat ditemukan!');
        }
    }

    /**
     * Proses Keluar Sesi - Mengeluarkan pengguna secara langsung.
     *
     * @see https://laravel.com/docs/8.x/authentication#logging-out
     * @return void
     */
    public function logout()
    {
        if(auth()->id()) {
            Auth::logout();
            return redirect()->route('login.home')->with('success', 'Anda berhasil keluar!');
        } else {
            return redirect()->route('login.home')->with('danger', 'Maaf, anda belum terautentikasi!');
        }
    }
}
