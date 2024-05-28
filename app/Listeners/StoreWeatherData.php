<?php

namespace App\Listeners;

use App\Events\FileUploaded;
use App\Services\Weather\WeatherService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreWeatherData
{
    // Coordinates pointing to Katowice city
    const float LAT = 50.2584;
    const float LONG = 19.0275;

    public function __construct(readonly private WeatherService $weatherService)
    {
    }

    public function handle(FileUploaded $event): void
    {
        $event->file->update([
            'temperature' => $this->weatherService->getTemperature(self::LAT, self::LONG),
        ]);
    }
}
