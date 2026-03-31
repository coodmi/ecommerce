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
        // Share header and footer data globally for components like sidebar, header, footer
        view()->composer('*', function ($view) {
            $headerPage = \App\Models\Page::where('slug', 'header')->with('sections')->first();
            $headerConfig = $headerPage ? $headerPage->sections->pluck('content', 'key') : collect();
            
            $footerPage = \App\Models\Page::where('slug', 'footer')->with('sections')->first();
            $footerConfig = $footerPage ? $footerPage->sections->pluck('content', 'key') : collect();

            $view->with([
                'globalHeaderConfig' => $headerConfig,
                'globalFooterConfig' => $footerConfig,
            ]);
        });
    }
}
