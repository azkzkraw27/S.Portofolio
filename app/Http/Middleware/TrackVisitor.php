<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->is('admin*') && !$request->is('api*') && !$request->expectsJson()) {
            $ip = $request->ip();
            $userAgent = $request->userAgent() ?? 'Unknown Browser';
            $today = now()->toDateString();

            // Pengecekan aman via Eloquent (Mencegah Duplicate Error)
            $alreadyVisited = Visitor::where('ip_address', $ip)
                ->where('user_agent', $userAgent)
                ->where('visit_date', $today)
                ->exists();

            if (!$alreadyVisited) {
                Visitor::create([
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'visit_date' => $today,
                ]);
            }
        }

        return $next($request);
    }
}
