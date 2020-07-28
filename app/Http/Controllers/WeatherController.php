<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Place;

class WeatherController extends Controller
{
    const PLACE = 'place';
    const NEAREST = 'nearest';
    const ALL = 'all';

    public function getWeatherForPlace(Request $request)
    {
        $place = new Place($request['coordinatesLat'], $request['coordinatesLng'], $request['action']);

        switch (true) {
            case $request['scope'] == self::ALL:
                $clickedWeather = $place->getWeather();
                $nearestWeather = $place->getNearest();
                break;
            case $request['scope'] == self::NEAREST:
                $nearestWeather = $place->getNearest();
                break;
            case $request['scope'] == self::PLACE:
                $clickedWeather = $place->getWeather();
                break;
            default:
                throw new \Exception("Niepoprawny zakres danych.");
        }

        $responseWeather = ['clicked' => $clickedWeather ?? [], 'nearest' => $nearestWeather ?? []];

        return json_encode($responseWeather);
    }
}
