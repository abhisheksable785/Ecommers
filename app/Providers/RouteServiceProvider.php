<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The default path users will be redirected to after login.
     *
     * @var string
     */
    public const HOME = '/redirect-after-login';

    /**
     * Dynamic redirect based on role
     */
    public static function redirectTo(): string
    {
        $user = auth()->user();

        if (!$user) {
            return route('login'); // This will return string, not redirect
        }

        return match ($user->role) {
            'restaurant' => route('restaurant.dashboard'),
            'employee'   => route('employee.dashboard'),
            'admin'      => route('admin.dashboard'),
            default      => route('dashboard'),
        };
    }

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure rate limiting.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });
    }
}
