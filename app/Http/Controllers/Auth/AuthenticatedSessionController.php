<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse; // Zid hadi

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        // Ila kant l-requête jaya mn Flutter (API)
        if ($request->wantsJson()) {
            $user = Auth::user();
            $token = $user->createToken('flutter-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'token' => $token,
                'user' => $user
            ]);
        }

        // Ila kant l-requête jaya mn l-Browser (Normal Web)
        $request->session()->regenerate();
        return redirect()->intended('/admin/livres');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        // Ila kan logout mn Flutter (API)
        if ($request->wantsJson()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        }

        // Logout l-3adi dyal Web
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}