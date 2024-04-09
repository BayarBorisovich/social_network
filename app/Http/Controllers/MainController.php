<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\WeatherForecastServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;


class MainController extends Controller
{
    private WeatherForecastServices $weatherForecastServices;

    public function __construct(WeatherForecastServices $weatherForecastServices)
    {
        $this->weatherForecastServices = $weatherForecastServices;
    }

    public function getMain(): View|Factory|Application|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();

        return view('index.main', compact('user'));
    }

    public function getJsonMain(): JsonResponse
    {
        $myPosts = Post::all()->where('user_id', Auth::id());
        $weather = $this->weatherForecastServices->getWeatherForecast('Chita');


        return response()->json([
            'posts' => $myPosts,
            'weather' => $weather,
        ]);
    }

    public function showTheWeather()
    {
        $data = $this->weatherForecastServices->getWeatherForecast('Chita');

        return $data;//['weather'][0]['main'];

    }

}
