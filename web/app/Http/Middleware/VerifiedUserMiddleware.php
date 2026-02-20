<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifiedUserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admins bypass verification
        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!$user->isVerified()) {
            return redirect()->route('verification.index')
                ->with('warning', 'Anda perlu menyelesaikan verifikasi legalitas sebelum mengakses fitur ini.');
        }

        return $next($request);
    }
}
