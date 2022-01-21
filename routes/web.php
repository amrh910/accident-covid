<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DefaultController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;

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

//default
Route::get('/', [DefaultController::class, 'index']);
//register get
Route::get('/register', function () {
    return view('pages.register');
});
//register post
Route::post('/register', [LoginController::class, 'register']);
//login
Route::post('/login', [LoginController::class, 'authenticate']);
//logouts
Route::post('/logout', [LoginController::class, 'logout']);
//dashboard
Route::get('/dashboard', [DefaultController::class, 'index']);
//get specific country's covid innfo
Route::post('/get-data', [ApiController::class, 'getCountry']);
//remove pref
Route::post('/remove', [UserController::class, 'removePreference']);