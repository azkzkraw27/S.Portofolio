<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        // Jika bukan admin, arahkan ke dashboard user biasa
        return redirect()->route('user.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');
    }
}
