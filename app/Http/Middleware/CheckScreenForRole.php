<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckScreenForRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*if (Auth::guard($guard)->check()) {
            return redirect('/home');
        }*/

        /*if ($request->session()->has('users.role') && $request->session()->has('users.idUser')) {
            return $next($request);
        }
        else{
            return Redirect::route('login');
        }*/
        //dd($request->session()->has('users.idUser'));

        if ($request->session()->has('users.idRole')) {
            return $next($request);
        }
        else{
            return Redirect::route('login');
        }




        //dd($request->session()->has('role'));



    }
}
