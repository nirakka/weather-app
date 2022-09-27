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
    $location = request()->location ? request()->location : 'Tokyo, Japan';
    $apiKey      = config('services.openweather.key');
    $apiKeyPlace = config('services.foursquare.key');
    $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$apiKey}&units=metric");
    $responseFuture = Http::get("api.openweathermap.org/data/2.5/forecast?appid={$apiKey}&units=metric&q={$location}");
    $responsePlace = Http::withHeaders([
        'Authorization' => $apiKeyPlace,
        'accept' => 'application/json',
    ])
    ->get("https://api.foursquare.com/v3/places/search?near={$location}&limit=5");

    return view('welcome', [
        'currentWeather' => $response->json(),
        'futureWeather'  => $responseFuture->json(),
        'location' => $location,
        'places' => $responsePlace->json(),
    ]);
});

Route::get('/weather', function () {
    $location = request()->location ? request()->location : 'Tokyo, Japan';
    $apiKey      = config('services.openweather.key');
    $response = Http::get("https://api.openweathermap.org/data/2.5/weather?q={$location}&appid={$apiKey}&units=metric");
 
    return response()->json($response->json(), 200);
});

Route::get('/future-weather', function () {
    $location = request()->location ? request()->location : 'Tokyo, Japan';
    $apiKey      = config('services.openweather.key');
    
    $responseFuture = Http::get("api.openweathermap.org/data/2.5/forecast?appid={$apiKey}&units=metric&q={$location}");

    return response()->json($responseFuture->json(), 200);
});

Route::get('/places', function () {
    $location = request()->location ? request()->location : 'Tokyo, Japan';
    $apiKeyPlace = config('services.foursquare.key');

    $responsePlace = Http::withHeaders([
        'Authorization' => $apiKeyPlace,
        'accept' => 'application/json',
    ])
    ->get("https://api.foursquare.com/v3/places/search?near={$location}&limit=5");
    return response()->json($responsePlace->json(), 200);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
