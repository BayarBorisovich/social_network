<?php

namespace App\Http\Controllers;

use App\Services\WeatherForecastServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    private WeatherForecastServices $weatherForecastServices;

    public function __construct(WeatherForecastServices $weatherForecastServices)
    {
        $this->weatherForecastServices = $weatherForecastServices;
    }

    public function showMainPaigeForm(): View|Factory|Application|RedirectResponse
    {
        return view('index.main', ['user' => Auth::user()]);
    }

    public function getWeather(): JsonResponse
    {
        try {
            $city = Auth::user()->information->city;
            $weather = $this->weatherForecastServices->getWeatherForecast($city);

            return response()->json(['message' => 'success', 'weather' => $weather]);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }
}
