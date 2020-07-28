<?php

namespace App\Helpers;

interface iWeather
{
    public function __construct();
    public function setCoordinations(float $lat, float $lng): void;
    public function getWeatherFromApi(): array;
    public function getIcon(string $icon): string;
}
