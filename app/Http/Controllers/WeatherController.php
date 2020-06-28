<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    private $apiKey = null;

    public function __construct()
    {
        $this->apiKey = "1700368536a8bfd5d01187b818b09bda";
    }

    public function getWeather($lat, $lng)
    {
        $url = "https://api.openweathermap.org/data/2.5/onecall?lat=$lat&lon=$lng&%20exclude=hourly,daily&units=metric&lang=pl&appid=$this->apiKey";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            // echo $response;
            $data = json_decode($response, true);
            $icon = $data['current']['weather'][0]['icon'];
            $temperature = $data['current']['temp'];
            $description = $data['current']['weather'][0]['description'];

            return ["icon" => $icon, "temperature" => $temperature, "description" => $description];
        }
    }
}
