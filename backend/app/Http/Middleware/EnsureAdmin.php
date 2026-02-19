<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user->isAdmin()) {
            return response()->json(['message' => 'Akses ditolak. Hanya admin yang diizinkan.'], 403);
        }

        if (!empty($roles) && !in_array($user->role, $roles)) {
            return response()->json(['message' => 'Akses ditolak. Role tidak sesuai.'], 403);
        }

        return $next($request);
    }
}
