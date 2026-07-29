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

    private const LOGIN_IP_MAX_ATTEMPTS = 20;

    private const LOGIN_IP_DECAY_SECONDS = 300;

    private const RESET_MAX_ATTEMPTS = 3;

    private const RESET_DECAY_SECONDS = 900;

    private const RESET_IP_MAX_ATTEMPTS = 8;

    private const RESET_IP_DECAY_SECONDS = 900;

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

        $this->ensureLoginIsNotRateLimited($request);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $this->clearRateLimit($this->loginAccountKey($credentials['email']));
            $this->clearRateLimit($this->loginIpKey($request));

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', 'Welcome back!');
        }

        $this->hitRateLimiter($this->loginAccountKey($credentials['email']), self::LOGIN_DECAY_SECONDS);
        $this->hitRateLimiter($this->loginIpKey($request), self::LOGIN_IP_DECAY_SECONDS);

        return back()
            ->withInput($request->only('email'))
            ->with('error', 'The account does not exist, or the email and password are invalid.');
    }

    /**
     * Send a password reset link to the administrator.
     */
    public function sendResetLink(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $this->ensureIsNotRateLimited($request, $this->resetAccountKey($validated['email']), self::RESET_MAX_ATTEMPTS);
        $this->ensureIsNotRateLimited($request, $this->resetIpKey($request), self::RESET_IP_MAX_ATTEMPTS);
        $this->hitRateLimiter($this->resetAccountKey($validated['email']), self::RESET_DECAY_SECONDS);
        $this->hitRateLimiter($this->resetIpKey($request), self::RESET_IP_DECAY_SECONDS);

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

    private function ensureLoginIsNotRateLimited(Request $request): void
    {
        $this->ensureIsNotRateLimited($request, $this->loginAccountKey($request->input('email')), self::LOGIN_MAX_ATTEMPTS);
        $this->ensureIsNotRateLimited($request, $this->loginIpKey($request), self::LOGIN_IP_MAX_ATTEMPTS);
    }

    private function ensureIsNotRateLimited(Request $request, string $key, int $maxAttempts): void
    {
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);

            throw ValidationException::withMessages([
                'email' => "Too many attempts. Please try again in {$seconds} seconds.",
            ]);
        }
    }

    private function hitRateLimiter(string $key, int $decaySeconds): void
    {
        RateLimiter::hit($key, $decaySeconds);
    }

    private function clearRateLimit(string $key): void
    {
        RateLimiter::clear($key);
    }

    private function loginAccountKey(string $email): string
    {
        return 'login:account:' . Str::lower($email);
    }

    private function loginIpKey(Request $request): string
    {
        return 'login:ip:' . $request->ip();
    }

    private function resetAccountKey(string $email): string
    {
        return 'reset:account:' . Str::lower($email);
    }

    private function resetIpKey(Request $request): string
    {
        return 'reset:ip:' . $request->ip();
    }
}
