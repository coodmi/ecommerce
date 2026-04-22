<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Share header/footer config globally — cached for 10 minutes to avoid repeated DB hits
        view()->composer('*', function ($view) {
            static $headerConfig = null;
            static $footerConfig = null;

            if ($headerConfig === null) {
                $headerConfig = cache()->remember('global_header_config', 600, function () {
                    $page = \App\Models\Page::where('slug', 'header')->with('sections')->first();
                    return $page ? $page->sections->pluck('content', 'key') : collect();
                });
            }

            if ($footerConfig === null) {
                $footerConfig = cache()->remember('global_footer_config', 600, function () {
                    $page = \App\Models\Page::where('slug', 'footer')->with('sections')->first();
                    return $page ? $page->sections->pluck('content', 'key') : collect();
                });
            }

            $view->with([
                'globalHeaderConfig' => $headerConfig,
                'globalFooterConfig' => $footerConfig,
            ]);
        });
    }
}
