<?php

namespace App\Providers;

use App\Contracts\OlxPriceParser;
use App\Services\Parser\HtmlOlxPriceParser;
use App\Services\SubscriptionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OlxPriceParser::class, function () {
            return new HtmlOlxPriceParser();
        });

        $this->app->bind(SubscriptionService::class, function (Application $app) {
            return new SubscriptionService($app->make(OlxPriceParser::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
