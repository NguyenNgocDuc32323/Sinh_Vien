<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\User;
use Illuminate\Contracts\Session\Session;

class RememberToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
{
    // If the user is logged in
    if (Auth::check()) {
        $user = Auth::user();

        // If the user is an admin and accessing admin routes
        if ($user->is_admin && $request->routeIs('admin.*')) {
            // Clear session and require re-login
            Auth::logout();
            Cookie::queue(Cookie::forget('remember_token'));
            return redirect()->route('login')->with('message', 'Please log in again.');
        }

        return $next($request);
    }

    // Handle remember token for non-admin routes
    $rememberToken = Cookie::get('remember_token');
    if ($rememberToken) {
        $user = User::where('remember_token', hash('sha256', $rememberToken))->first();
        if ($user) {
            Auth::login($user);
            return $next($request);
        }
    }

    return redirect()->route('login');
}


}
