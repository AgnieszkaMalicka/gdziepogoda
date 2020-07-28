<?php

namespace App\Helpers;

use App\Helpers\WeatherOpen;
use App\Helpers\WeatherBit;
use Exception;
use App\Dicts\weatherApis;

class Place
{
    private $lat;
    private $lng;

    private $api = null;
    private const LAT20KM = 0.179806;
    private const LNG20KM = 0.279313;

    public function __construct(float $lat, float $lng, string $action)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->setApiClass($action);
    }

    private function setApiClass(string $action)
    {
        if (!in_array($action, [weatherApis::BIT, weatherApis::OPEN])) {
            throw new Exception("API not found.");
        }

        switch ($action) {
            case 'bit':
                $this->api = new WeatherBit();
                break;
            case 'open':
                $this->api = new WeatherOpen();
                break;
        }
    }

    public function getWeather()
    {
        $this->api->setCoordinations($this->lat, $this->lng);
        $weatherForPlace = $this->api->getWeatherFromApi();
        return $weatherForPlace;
    }

    public function getNearest()
    {
        $grid = [];

        $latStart = $this->lat - (2 * self::LAT20KM);
        $latEnd = $this->lat + (2 * self::LAT20KM);
        $lngStart = $this->lng - (2 * self::LNG20KM);
        $lngEnd = $this->lng + (2 * self::LNG20KM);


        for ($lat = $latStart; $lat <= $latEnd; $lat += self::LAT20KM) {
            for ($lng = $lngStart; $lng <= $lngEnd; $lng += self::LNG20KM) {
                $this->api->setCoordinations($lat, $lng);
                $grid[] = $this->api->getWeatherFromApi();
            }
        }

        return $grid;
    }
}
