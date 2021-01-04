<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role_name)
    {
        $user = Auth::user();
        if ($user->role->role_name == $role_name) {
            return $next($request);
        }

        switch ($user->role->role_name) {
            case 'admin':
                return redirect('/admin');
                break;
            case 'employee':
                return redirect('/dashboard');
                break;
            default:
                return redirect('/');
                break;
        }
    }
}
