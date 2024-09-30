<?php

namespace App\Providers;

use App\Models\Ad;
use App\Models\Creator;
use App\Models\Option;
use App\Models\User;
use App\Models\Warning;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Blade;
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
                return route('home.index', [
                    'token' => $token,
                    'email' => $model->email,
                ]);
            }
        });

        Vite::useScriptTagAttributes([
            'defer' => true,
        ]);

        View::composer(['pages.*', 'errors.*',], function (ViewView $view) {
            $settings = Option::getSettings();

            if (! $settings['show_top_warning']) {
                return;
            }

            $warning = Warning::inRandomOrder()->first();

            $view->with('warning', $warning);
        });

        Blade::directive('embedstyles', function ($expression) {
            return "<style><?php echo minify_css(file_get_contents({$expression})); ?></style>";
        });

        // DB::listen(fn($sql) => $GLOBALS['sql'][] = $sql);
    }
}
