<?php

namespace App\Services\Weather;

use Illuminate\Support\Facades\Cache;
use PhpWeather\Common\WeatherQuery;
use PhpWeather\Provider\OpenMeteo\OpenMeteo;

readonly class WeatherService
{
    public function __construct(private OpenMeteo $meteoApi)
    {
    }

    public function getTemperature(float $lat, float $long): ?float
    {
        return Cache::remember("temperature-{$lat}-{$long}", now()->addHour(), function () use ($lat, $long) {
            $currentWeatherQuery = WeatherQuery::create($lat, $long);

            return $this->meteoApi->getCurrentWeather($currentWeatherQuery)->getTemperature();
        });
    }
}
