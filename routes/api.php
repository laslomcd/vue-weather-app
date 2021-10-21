<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weather', function () {
    $apiKey = config('services.darksky.key');
    $lat = request('lat');
    $lng = request('lng');

    $response = Http::get("https://api.darksky.net/forecast/$apiKey/$lat,$lng");
   // $response = Http::get("https://api.darksky.net/forecast/$apiKey/37.8267,-122.4233");

    return $response->json();
});
