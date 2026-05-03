<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateMember
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('member')->check()) {
            return redirect()->route('member.login')
                ->with('error', 'Please log in to access your member portal.');
        }

        return $next($request);
    }
}
