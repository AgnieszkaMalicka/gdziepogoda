<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Place;

class HomeController extends Controller
{
    public function getWeather(Request $request)
    {
        //to w pętelce dla każdego miejsca przy czym kliknięte osobno
        $weather = new WeatherController();
        $clickedWeather = $weather->getClickedWeather($request['coordinatesLat'], $request['coordinatesLng']);

        if (!isset($clickedWeather['lat_' . $request['coordinatesLat'] . '_lng_' . $request['coordinatesLng']]['current']['rain'])) {
            $clickedWeather['lat_' . $request['coordinatesLat'] . '_lng_' . $request['coordinatesLng']]['current']['rain'] = 0;
        }

        return response()->json([
            'coordinatesLat' => $request['coordinatesLat'],
            'coordinatesLng' => $request['coordinatesLng'],
            'temp'   => $clickedWeather['lat_' . $request['coordinatesLat'] . '_lng_' . $request['coordinatesLng']]['current']['temp'],
            'icon'   => $clickedWeather['lat_' . $request['coordinatesLat'] . '_lng_' . $request['coordinatesLng']]['current']['icon'],
            'description' => $clickedWeather['lat_' . $request['coordinatesLat'] . '_lng_' . $request['coordinatesLng']]['current']['description'],
            'feels_like'    => $clickedWeather['lat_' . $request['coordinatesLat'] . '_lng_' . $request['coordinatesLng']]['current']['feels_like'],
            'wind_speed'    => $clickedWeather['lat_' . $request['coordinatesLat'] . '_lng_' . $request['coordinatesLng']]['current']['wind_speed'],
            'rain'  => $clickedWeather['lat_' . $request['coordinatesLat'] . '_lng_' . $request['coordinatesLng']]['current']['rain']
        ]);
    }

    public function test()
    {
        $lat = 51.23564752618708;
        $lng = 19.456787109375;
        $action = "map";
        // $coordinates = new CoordinateController($lat, $lng);

        // $weather = new WeatherController();
        // $test = $weather->getWeatherForPlace($lat, $lng, 'map');

        $place = new Place($lat, $lng, $action);
        // $clickedWeather = $place->getWeather();

        $grid = $place->getNearest();
        // var_dump($clickedWeather);        

        dd($grid);
    }

    public function testBit()
    {
        $place = new Place(49.9876, 19.098764, "bit");
        $clickedWeather = $place->getWeather();
        // dd($clickedWeather);
        // $nearest = $place->getNearest();

        dd($clickedWeather);
    }

    public function testOpen()
    {

        $place = new Place(49.9876, 19.098764, "open");
        $clickedWeather = $place->getWeather();
        // $nearest = $place->getNearest();

        dd($clickedWeather);

        // $this->lat = 49.8225;
        // $this->lng = 19.044444;
        // $this->apiKey = "1700368536a8bfd5d01187b818b09bda";

        // $url = "https://api.openweathermap.org/data/2.5/onecall?lat=$this->lat&lon=$this->lng&%20exclude=hourly&units=metric&lang=pl&appid=$this->apiKey";

        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => $url,
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 30,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        // ));
        // $response = curl_exec($curl);
        // $err = curl_error($curl);
        // curl_close($curl);
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     // echo $response;
        //     $data = json_decode($response, true);
        //     dd($data);

        //     $dataFromApi = [];
        //     $dataFromApi['current'] = [];
        //     foreach ($data['current'] as $key => $value) {
        //         if ($key == 'weather') {
        //             foreach ($value[0] as $keyWeather => $valueWeather) {
        //                 $dataFromApi['current'][$keyWeather] = $valueWeather;
        //             }
        //         } else if ($key == 'rain') {
        //             foreach ($value as $valueRain) {
        //                 $dataFromApi['current']['rain'] = $valueRain;
        //             }
        //         }
        //         else if ($key == 'dt') {
        //             $dateTimeObj = \DateTime::createFromFormat("U", $value);
        //             $dateTimeObj->setTimezone(new DateTimeZone("Europe/Warsaw"));
        //             $dataFromApi['current']['dt'] = $dateTimeObj->format("H");
        //         }
        //         else {
        //             $dataFromApi['current'][$key] = $value;
        //         }
        //     }
        //     $dataFromApi['current']['lat'] = $data['lat'];
        //     $dataFromApi['current']['lng'] = $data['lon'];
        //     // dd($responseData);

        //     if (!isset($dataFromApi['current']['rain'])) {
        //         $dataFromApi['current']['rain'] = 0;
        //     }

        //     $dataFromApi['hourly'] = [];
        //     foreach ($data['hourly'] as $hourlyWeather) {
        //         foreach ($hourlyWeather as $key => $value) {
        //             if ($key == 'weather') {
        //                 foreach ($value[0] as $keyWeather => $valueWeather) {
        //                     $dataFromApi['hourly'][$hourlyWeather['dt']][$keyWeather] = $valueWeather;
        //                 }
        //             } else if ($key == 'rain') {
        //                 foreach ($value as $valueRain) {
        //                     $dataFromApi['hourly'][$hourlyWeather['dt']]['rain'] = $valueRain;
        //                 }
        //             }
        //             else if ($key == 'dt') {
        //                 $dateTimeObj = \DateTime::createFromFormat("U", $value);
        //                 $dateTimeObj->setTimezone(new DateTimeZone("Europe/Warsaw"));
        //                 $dataFromApi['hourly'][$hourlyWeather['dt']]['dt'] = $dateTimeObj->format("H");
        //             }
        //             else {
        //                 $dataFromApi['hourly'][$hourlyWeather['dt']][$key] = $value;
        //             }
        //         }

        //         if (!isset($dataFromApi['hourly'][$hourlyWeather['dt']]['rain'])) {
        //             $dataFromApi['hourly'][$hourlyWeather['dt']]['rain'] = 0;
        //         }
        //     }

        //     return $dataFromApi;
        // }
    }
}
