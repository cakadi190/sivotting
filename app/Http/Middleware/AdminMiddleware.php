<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @see https://laravel.com/docs/8.x/authentication#logging-out Kode mengeluarkan sesi
     * @see https://afiefafian95.medium.com/apa-itu-middleware-cc8c9e27707f Mengenal konsep middleware
     * @see https://laravel.com/docs/8.x/middleware#defining-middleware Mendefinisikan middleware
     * @see https://laravel.com/docs/8.x/eloquent#retrieving-single-models Eloquent laravel model
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        # Check if is not loggedin
        if(!auth()->id()) {
            return redirect()->route('login.home')->with('danger', 'Maaf, anda belum terautentikasi!');
        }

        # Check if is user isn't exists at the user table
        if(!User::find(auth()->id())) {
            Auth::logout();
            return redirect()->route('login.home')->with('danger', 'Maaf, anda belum terautentikasi!');
        }

        return $next($request);
    }
}
