<?php

namespace App\Helpers;

use DateTimeZone;

class WeatherBit implements iWeather
{
    private $apiKey = "";
    private $lat = null;
    private $lng = null;

    public function __construct()
    {
        $this->apiKey = "160c6c158a6b4fb9ad70831e030c4137";
    }

    public function setCoordinations(float $lat, float $lng): void
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function getWeatherFromApi(): array
    {
        $url = "https://api.weatherbit.io/v2.0/current?&lat=$this->lat&lon=$this->lng&lang=pl&key=$this->apiKey";

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
            $data = $data['data'][0] ?? [];

            $dataFromApi = [];
            $dataFromApi['current'] = [];
            $all = [];
            foreach ($data as $key => $value) {
                if ($key == 'weather') {
                    foreach ($value as $keyWeather => $valueWeather) {
                        $all[$keyWeather] = $valueWeather;
                    }
                } else if ($key == 'dt') {
                    $dateTimeObj = \DateTime::createFromFormat("U", $value);
                    $dateTimeObj->setTimezone(new DateTimeZone("Europe/Warsaw"));
                    $all['dt'] = $dateTimeObj->format("H");
                } else {
                    $all[$key] = $value;
                }
            }

            $dataFromApi['current']['lat'] = $data['lat'];
            $dataFromApi['current']['lng'] = $data['lon'];
            $dataFromApi['current']['temperature'] = round($data['temp']);
            $dataFromApi['current']['description'] = $data['weather']['description'];
            $dataFromApi['current']['icon'] = $this->getIcon($data['weather']['icon']);
            $dataFromApi['current']['city_name'] = $all['city_name'];
            $dataFromApi['current']['clouds'] = $all['clouds'];
            $dataFromApi['current']['pres'] = round($all['pres']);
            $dataFromApi['current']['wind_spd'] = round($all['wind_spd'], 2);
            $dataFromApi['current']['app_temp'] = round($data['app_temp']);
            $dataFromApi['current']['precip'] = round($data['precip']);

            return $dataFromApi;
        }
    }

    public function getIcon(string $icon): string
    {
        switch ($icon) {
            case 'a01d':
                return '../images/icons/a01d.png';
            case 'a01n':
                return '../images/icons/a01n.png';
            case 'a02d':
                return '../images/icons/a02d.png';
            case 'a02n':
                return '../images/icons/a02n.png';
            case 'a03d':
                return '../images/icons/a03d.png';
            case 'a03n':
                return '../images/icons/a03n.png';
            case 'a04d':
                return '../images/icons/a04d.png';
            case 'a04n':
                return '../images/icons/a04n.png';
            case 'a05d':
                return '../images/icons/a05d.png';
            case 'a05n':
                return '../images/icons/a05n.png';
            case 'a06d':
                return '../images/icons/a06d.png';
            case 'a06n':
                return '../images/icons/a06n.png';
            case 'c01d':
                return '../images/icons/c01d.png';
            case 'c01n':
                return '../images/icons/c01n.png';
            case 'c02d':
                return '../images/icons/c02d.png';
            case 'c02n':
                return '../images/icons/c02n.png';
            case 'c03d':
                return '../images/icons/c03d.png';
            case 'c03n':
                return '../images/icons/c03n.png';
            case 'c04d':
                return '../images/icons/c04d.png';
            case 'c04n':
                return '../images/icons/c04n.png';
            case 'd01d':
                return '../images/icons/d01d.png';
            case 'd01n':
                return '../images/icons/d01n.png';
            case 'd02d':
                return '../images/icons/d02d.png';
            case 'd02n':
                return '../images/icons/d02n.png';
            case 'd03d':
                return '../images/icons/d03d.png';
            case 'd03n':
                return '../images/icons/d03n.png';
            case 'f03d':
                return '../images/icons/f03d.png';
            case 'f03n':
                return '../images/icons/f03n.png';
            case 'r01d':
                return '../images/icons/r01d.png';
            case 'r01n':
                return '../images/icons/r01n.png';
            case 'r02d':
                return '../images/icons/r02d.png';
            case 'r02n':
                return '../images/icons/r02n.png';
            case 'r03d':
                return '../images/icons/r03d.png';
            case 'r03n':
                return '../images/icons/r03n.png';
            case 'r04d':
                return '../images/icons/r04d.png';
            case 'r04n':
                return '../images/icons/r04n.png';
            case 'r05d':
                return '../images/icons/r05d.png';
            case 'r05n':
                return '../images/icons/r05n.png';
            case 'r06d':
                return '../images/icons/r06d.png';
            case 'r06n':
                return '../images/icons/r06n.png';
            case 's01d':
                return '../images/icons/s01d.png';
            case 's01n':
                return '../images/icons/s01n.png';
            case 's02d':
                return '../images/icons/s02d.png';
            case 's02n':
                return '../images/icons/s02n.png';
            case 's03d':
                return '../images/icons/s03d.png';
            case 's03n':
                return '../images/icons/s03n.png';
            case 's04d':
                return '../images/icons/s04d.png';
            case 's04n':
                return '../images/icons/s04n.png';
            case 's05d':
                return '../images/icons/s05d.png';
            case 's05n':
                return '../images/icons/s05n.png';
            case 's06d':
                return '../images/icons/s06d.png';
            case 's06n':
                return '../images/icons/s06n.png';
            case 't01d':
                return '../images/icons/t01d.png';
            case 't01n':
                return '../images/icons/t01n.png';
            case 't02d':
                return '../images/icons/t02d.png';
            case 't02n':
                return '../images/icons/t02n.png';
            case 't03d':
                return '../images/icons/t03d.png';
            case 't03n':
                return '../images/icons/t03n.png';
            case 't04d':
                return '../images/icons/t04d.png';
            case 't04n':
                return '../images/icons/t04n.png';
            case 't05d':
                return '../images/icons/t05d.png';
            case 't05n':
                return '../images/icons/t05n.png';
            case 'u00d':
                return '../images/icons/u00d.png';
            case 'u00n':
                return '../images/icons/u00n.png';
        }

        return '../images/icons/u00d.png';
    }
}
