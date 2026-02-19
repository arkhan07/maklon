<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->isVerified()) {
            return response()->json([
                'message' => 'Akun Anda belum terverifikasi. Silakan lengkapi verifikasi legalitas.',
                'verification_status' => $request->user()->verification_status,
            ], 403);
        }

        return $next($request);
    }
}
