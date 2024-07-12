<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\Creator;
use App\Models\Option;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\View\View as ViewView;

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

        View::composer(['pages.*',], function (ViewView $view) {
            if (! Option::getOption('show_top_ad', false)) {
                return;
            }

            $topAd = Ad::type('top')->inRandomOrder()->first();

            $view->with('topAd', $topAd);
        });

        DB::listen(fn($sql) => $GLOBALS['sql'][] = $sql);
    }
}
