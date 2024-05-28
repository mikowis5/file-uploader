<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use PhpWeather\Provider\OpenMeteo\OpenMeteo;

class OpenMeteoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(OpenMeteo::class, function () {
            $httpClient = new Client;

            return new OpenMeteo($httpClient);
        });
    }

    public function boot(): void
    {
    }
}
