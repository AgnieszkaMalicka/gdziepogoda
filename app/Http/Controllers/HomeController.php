<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getWeather(Request $request)
    {
        //to w pętelce dla każdego miejsca przy czym kliknięte osobno
        $weather = new WeatherController();
        $currentWeather = $weather->getWeather($request['coordinatesLat'], $request['coordinatesLng']);

        return response()->json([
            'coordinatesLat' => $request['coordinatesLat'],
            'coordinatesLng' => $request['coordinatesLng'],
            'temperature'   => $currentWeather['temperature'],
            'icon'   => $currentWeather['icon'],
            'description' => $currentWeather['description']
        ]);
    }

    public function test()
    {
        $lat = 51.23564752618708;
        $lng = 19.456787109375;
        // $coordinates = new CoordinateController($lat, $lng);

        $weather = new WeatherController();
        $weather->getWeather($lat, $lng);
    }
}
