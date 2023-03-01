<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/', [RouteController::class, 'index']);
Route::get('/home', [RouteController::class, 'index']);

Route::get('fetch-routes', [RouteController::class, 'fecthroute']);
Route::get('get-route/{id}', [RouteController::class, 'getRoute']);

Route::get('get-station/{id}', [StationController::class, 'getStation']);
Route::get('get-tooltips', [StationController::class, 'getTooltips']);

Route::get('booking', [BookingController::class, 'index']);
Route::get('checking', [BookingController::class, 'checking']);
Route::get('fetch-booking', [BookingController::class, 'fetchbooking']);
Route::post('bookings',[BookingController::class, 'store']);
Route::get('get-bookings/{sdt}', [BookingController::class, 'getbooking']);

