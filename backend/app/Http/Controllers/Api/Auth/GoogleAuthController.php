<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): JsonResponse
    {
        $url = Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();

        return response()->json(['url' => $url]);
    }

    public function callback(Request $request): JsonResponse
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Autentikasi Google gagal'], 422);
        }

        $user = User::updateOrCreate(
            ['google_id' => $googleUser->getId()],
            [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
            ]
        );

        if (!$user->profile) {
            UserProfile::create(['user_id' => $user->id]);
        }

        if (!$user->is_active) {
            return response()->json(['message' => 'Akun Anda telah dinonaktifkan'], 403);
        }

        $user->update(['last_login_at' => now()]);
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login dengan Google berhasil',
            'user' => new UserResource($user->load('profile')),
            'token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
