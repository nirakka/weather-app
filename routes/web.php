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
    $location = 'Toronto';
    $apiKey      = config('services.openweather.key');
    
    $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$apiKey}&units=metric");
    $responseFuture = Http::get("api.openweathermap.org/data/2.5/forecast?appid={$apiKey}&units=metric&q={$location}");


    return view('welcome', [
        'currentWeather' => $response->json(),
        'futureWeather'  => $responseFuture->json(),
    ]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
