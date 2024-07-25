<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\View\Components\SelectInput;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

use App\Models\Notification;
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
        Blade::component('select-input', SelectInput::class);
        View::composer('*', function ($view) {
            $sumUnread = Notification::where('reading', false)->count();
            $view->with('sumUnread', $sumUnread);
        });
        Paginator::useBootstrapFive();
    }
}
