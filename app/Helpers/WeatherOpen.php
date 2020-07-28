<?php

namespace App\Helpers;

use DateTimeZone;
use Exception;

class WeatherOpen implements iWeather
{
    private $apiKey;
    private $lat = null;
    private $lng = null;

    public function __construct()
    {
        $this->apiKey = "1700368536a8bfd5d01187b818b09bda";
    }

    public function setCoordinations(float $lat, float $lng): void
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function getWeatherFromApi(): array
    {
        if (empty($this->lat) || empty($this->lng)) {
            throw new Exception("Bed coordinates.");
        }

        $url = "https://api.openweathermap.org/data/2.5/onecall?lat=$this->lat&lon=$this->lng&%20exclude=hourly&units=metric&lang=pl&appid=$this->apiKey";

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
            $data = json_decode($response, true);

            $dataFromApi = [];
            $dataFromApi['current'] = $this->parseDataFromApi($data['current']);
            $dataFromApi['current']['lat'] = $data['lat'];
            $dataFromApi['current']['lng'] = $data['lon'];

            $dataFromApi['hourly'] = [];

            foreach ($data['hourly'] as $hourWeather) {
                $dataFromApi['hourly'][] = $this->parseDataFromApi($hourWeather);
            }
            return $dataFromApi;
        }
    }

    private function parseDataFromApi(array $data): array
    {
        $dataAll = [];
        foreach ($data as $key => $value) {
            if ($key == 'weather') {
                foreach ($value[0] as $keyWeather => $valueWeather) {
                    $dataAll[$keyWeather] = $valueWeather;
                }
            } else if ($key == 'rain') {
                foreach ($value as $valueRain) {
                    $dataAll['rain'] = $valueRain;
                }
            } else if ($key == 'dt') {
                $dateTimeObj = \DateTime::createFromFormat("U", $value);
                $dateTimeObj->setTimezone(new DateTimeZone("Europe/Warsaw"));
                $dataAll['dt'] = $dateTimeObj->format("H");
            } else {
                $dataAll[$key] = $value;
            }
        }

        if (!isset($dataAll['rain'])) {
            $dataAll['rain'] = 0;
        }
        $result = [];
        $result['city_name'] = '';
        $result['temperature'] = round($dataAll['temp']);
        $result['clouds'] = $dataAll['clouds'];
        $result['pres'] = $dataAll['pressure'];
        $result['wind_spd'] = $dataAll['wind_speed'];
        $result['app_temp'] = round($dataAll['feels_like']);
        $result['precip'] = round($dataAll['rain']);
        $result['description'] = $dataAll['description'];
        $result['icon'] = $this->getIcon($dataAll['icon']);
        $result['dt'] = $dataAll['dt'];

        return $result;
    }

    public function getIcon(string $icon): string
    {
        switch ($icon) {
            case '01d':
                return '../images/icons/c01d.png';
            case '02d':
                return '../images/icons/c02d.png';
            case '03d':
                return '../images/icons/c02d.png';
            case '04d':
                return '../images/icons/c03d.png';
            case '09d':
                return '../images/icons/r05d.png';
            case '10d':
                return '../images/icons/r02d.png';
            case '11d':
                return '../images/icons/t01d.png';
            case '13d':
                return '../images/icons/s02d.png';
            case '50d':
                return '../images/icons/a01d.png';
            case '01n':
                return '../images/icons/c01n.png';
            case '02n':
                return '../images/icons/c02n.png';
            case '03n':
                return '../images/icons/c02n.png';
            case '04n':
                return '../images/icons/c03n.png';
            case '09n':
                return '../images/icons/r05n.png';
            case '10n':
                return '../images/icons/r02n.png';
            case '11n':
                return '../images/icons/t01n.png';
            case '13n':
                return '../images/icons/s02n.png';
            case '50n':
                return '../images/icons/a01n.png';
        }

        return '../images/icons/u00d.png';
    }
}
