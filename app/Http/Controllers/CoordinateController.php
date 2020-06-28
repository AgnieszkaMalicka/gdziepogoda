<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoordinateController extends Controller
{
    private $lat = null;
    private $lng = null;

    public function __construct(string $lat, float $lng)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->convertCoordinatesToDMS();
    }

    private function convertCoordinatesToDMS()
    {
        var_dump($this->lat);
        $latDegrees = substr($this->lat, 0, 2);

        $latMinutes = (int) substr($this->lat, 3, 2);
        $latMinutes = (int) ceil(($latMinutes / 100) * 60);

        $latSeconds = (int) substr($this->lat, 4);
        $latSeconds = ($latMinutes / 10000) * 3600;

        dd($latDegrees . ' ' . $latMinutes . ' ' . $latSeconds);
    }

    private function convertCoordinatesToDD()
    {
    }

    private function createCoordinateGrid()
    {
    }
}
