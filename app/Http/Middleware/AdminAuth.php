<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( auth()->check() ) {
            $email      = auth()->user()->email;
            $password   = auth()->user()->password;
            $credentials = [
                'email' => $email,
                'password' => $password
            ];
            
            $user_info = DB::table('users')
                            ->where('email', $email)
                            ->get();
            if ( $user_info[0]->admin == 1 ) {
                return $next($request);
            }
            
        }
        throw new \Exception('You are not logged in as admin');
    }
}
