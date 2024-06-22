<?php

namespace App\Providers;

use App\Models\Creator;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Vite;


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
        ResetPassword::createUrlUsing(function (User|Creator $model, string $token) {
            if ($model instanceof User) {
                return route('admin-panel', [
                    'any' => 'reset',
                    'token' => $token,
                    'email' => $model->email,
                ]);
            }

            if ($model instanceof Creator) {
                return route('web.password.reset.page', [
                    'token' => $token,
                    'email' => $model->email,
                ]);
            }
        });

        Vite::useScriptTagAttributes([
            'defer' => true,
        ]);
    }
}
