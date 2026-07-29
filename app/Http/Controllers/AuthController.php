<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private const LOGIN_MAX_ATTEMPTS = 5;

    private const LOGIN_DECAY_SECONDS = 60;

    private const RESET_MAX_ATTEMPTS = 3;

    private const RESET_DECAY_SECONDS = 900;

    /**
     * Display the administrator login page.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Display the password reset request form.
     */
    public function showForgotPassword()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.forgot-password');
    }

    /**
     * Display the password reset form.
     */
    public function showResetPassword(Request $request, string $token)
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->string('email')->toString(),
        ]);
    }

    /**
     * Handle administrator login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $this->ensureIsNotRateLimited($request, 'login', self::LOGIN_MAX_ATTEMPTS);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $this->clearRateLimit($request, 'login');

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back!');
        }

        $this->hitRateLimiter($request, 'login', self::LOGIN_DECAY_SECONDS);

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'Invalid email or password.');
    }

    /**
     * Send a password reset link to the administrator.
     */
    public function sendResetLink(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $this->ensureIsNotRateLimited($request, 'reset', self::RESET_MAX_ATTEMPTS);
        $this->hitRateLimiter($request, 'reset', self::RESET_DECAY_SECONDS);

        $status = Password::sendResetLink($validated);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        throw ValidationException::withMessages([
            'email' => __($status),
        ]);
    }

    /**
     * Reset the administrator password.
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $status = Password::reset(
            $validated,
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()
                ->route('login')
                ->with('status', 'Your password has been reset. You can sign in now.');
        }

        throw ValidationException::withMessages([
            'email' => __($status),
        ]);
    }

    /**
     * Logout the administrator and return to the homepage.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function ensureIsNotRateLimited(Request $request, string $scope, int $maxAttempts): void
    {
        $key = $this->throttleKey($request, $scope);

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => "Too many attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    private function hitRateLimiter(Request $request, string $scope, int $decaySeconds): void
    {
        RateLimiter::hit($this->throttleKey($request, $scope), $decaySeconds);
    }

    private function clearRateLimit(Request $request, string $scope): void
    {
        RateLimiter::clear($this->throttleKey($request, $scope));
    }

    private function throttleKey(Request $request, string $scope): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip() . '|' . $scope;
    }
}
