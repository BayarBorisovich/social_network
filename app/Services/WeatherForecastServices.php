<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class WeatherForecastServices
{
    private string $uri = 'https://api.openweathermap.org/data/2.5/weather?';
    private string $api = 'a9d550ca6c33429948cf08c8aee54585';
    private string $units = 'metric';
    private string $lang = 'ru';

    public function getWeatherForecast(string $city): array|null
    {
        $response = Http::get($this->uri, [
            'q' => $city,
            'units' => $this->units,
            'lang' => $this->lang,
            'appid' => $this->api,
        ]);

        $icon = 'https://openweathermap.org/img/wn/' . $response['weather'][0]['icon'] . '@2x.png';

        try {
            return [
                'name' => $response['name'],
                'weather' => $response['weather'][0]['description'],
                'icon' => $icon,
                'temp' => $response['main']['temp'],
                'wind' => $response['wind']['speed'],
            ];
        } catch (Throwable $exception) {
            Log::channel('daily')->error('error when choosing the weather ' . $exception->getMessage()); // в лог
            return null;
        }
    }
}
