<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        \Illuminate\Support\Facades\RateLimiter::for('borrowing-requests', function (\Illuminate\Http\Request $request) {
            $key = fn (string $field) => hash('sha256', mb_strtolower(trim(is_string($request->input($field)) ? $request->input($field) : 'invalid')));
            $response = function ($request, array $headers) {
                $message = 'Too many borrowing requests. Please wait a few minutes before trying again.';
                return $request->expectsJson()
                    ? response()->json(['message' => $message], 429, $headers)
                    : redirect()->route('more.borrow-books')->withErrors(['request' => $message])->withHeaders($headers);
            };
            return [
                \Illuminate\Cache\RateLimiting\Limit::perMinute(30)->by('borrow-ip:'.$request->ip())->response($response),
                \Illuminate\Cache\RateLimiting\Limit::perHour(100)->by('borrow-ip-hour:'.$request->ip())->response($response),
                \Illuminate\Cache\RateLimiting\Limit::perMinute(6)->by('borrow-id:'.$key('id_number'))->response($response),
                \Illuminate\Cache\RateLimiting\Limit::perHour(20)->by('borrow-email:'.$key('email'))->response($response),
            ];
        });
    }
}
