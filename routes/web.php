<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('/getWeather', 'WeatherController@getWeatherForPlace')->name('weather.getWeatherForPlace');

Route::get('/test', 'HomeController@testOpen')->name('home.testZbiorczy');
