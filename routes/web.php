<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('frontend.index');
});

//Route::get('/home', [DashboardController::class, 'index'])->name('home');

// Route to fetch states by country
Route::post('/get-states', [LocationController::class, 'getStatesByCountry'])->name('get.states');

// Route to fetch cities by state
Route::post('/get-cities', [LocationController::class, 'getCitiesByState'])->name('get.cities');

/** Show Pages */
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
