<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ElectionsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\ZonesController;
use App\Http\Controllers\LgasController;
use App\Http\Controllers\WardsController;
use App\Http\Controllers\PusController;
use App\Http\Controllers\SupervisorsController;
use App\Http\Controllers\RatechsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\ResultsController;

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

//Home
Route::get('/', [HomeController::class, 'index']);

//Login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'auth']);
Route::post('/logout', [LoginController::class, 'logout']);

//User Profile Update
Route::get('/profile', [UsersController::class, 'profile']);
Route::put('/update/{user}', [UsersController::class, 'updatePassword']);
Route::put('/profile/{user}', [UsersController::class, 'updateProfile']);

//for ajax request
Route::post('/admin/ajax', [AdminController::class, 'ajax']);
Route::get('/admin', [AdminController::class, 'index']);

//User
Route::get('/admin/users/create', [UsersController::class, 'create']);
Route::get('/admin/users', [UsersController::class, 'index']);
Route::get('/admin/users/{user}', [UsersController::class, 'show']);
Route::post('/admin/users/create', [UsersController::class, 'store']);
Route::get('/admin/users/{user}/edit', [UsersController::class, 'edit']);
Route::put('/admin/users/{user}', [UsersController::class, 'update']);
Route::delete('/admin/users/{user}', [UsersController::class, 'destroy']);

//Supervisors
Route::get('/admin/supervisors/create', [SupervisorsController::class, 'create']);
Route::get('/admin/supervisors', [SupervisorsController::class, 'index']);
Route::get('/admin/supervisors/{user}', [SupervisorsController::class, 'show']);
Route::post('/admin/supervisors/create', [SupervisorsController::class, 'store']);
Route::get('/admin/supervisors/{user}/edit', [SupervisorsController::class, 'edit']);
Route::put('/admin/supervisors/{user}', [SupervisorsController::class, 'update']);
Route::delete('/admin/supervisors/{user}', [SupervisorsController::class, 'destroy']);

//Ratechs
Route::get('/admin/ratechs/create', [RatechsController::class, 'create']);
Route::get('/admin/ratechs', [RatechsController::class, 'index']);
Route::get('/admin/ratechs/{user}', [RatechsController::class, 'show']);
Route::post('/admin/ratechs/create', [RatechsController::class, 'store']);
Route::get('/admin/ratechs/{user}/edit', [RatechsController::class, 'edit']);
Route::put('/admin/ratechs/{user}', [RatechsController::class, 'update']);
Route::delete('/admin/ratechs/{user}', [RatechsController::class, 'destroy']);

//State
Route::get('/admin/states/create', [StatesController::class, 'create']);
Route::get('/admin/states/{state}', [StatesController::class, 'show']);
Route::post('/admin/states/create', [StatesController::class, 'store']);
Route::get('/admin/states/{state}/edit', [StatesController::class, 'edit']);
Route::put('/admin/states/{state}', [StatesController::class, 'update']);
Route::delete('/admin/states/{state}', [StatesController::class, 'destroy']);
Route::get('/states/{state}/info', [StatesController::class, 'info']);
// Route::get('/states/{zone}/info', [StatesController::class, 'info']);
Route::get('/states/{state}/zones', [StatesController::class, 'zones']);
Route::get('/admin/states', [StatesController::class, 'index']);

//Zone
Route::get('/admin/zones/create', [ZonesController::class, 'create']);
Route::get('/admin/zones/{zone}', [ZonesController::class, 'show']);
Route::post('/admin/zones/create', [ZonesController::class, 'store']);
Route::get('/admin/zones/{zone}/edit', [ZonesController::class, 'edit']);
Route::put('/admin/zones/{zone}', [ZonesController::class, 'update']);
Route::delete('/admin/zones/{zone}', [ZonesController::class, 'destroy']);
Route::get('/zones/{zone}/info', [ZonesController::class, 'info']);
Route::get('/zones/{zone}/lgas', [ZonesController::class, 'lgas']);
Route::get('/admin/zones', [ZonesController::class, 'index']);

//LGA
Route::get('/admin/lgas/create', [LgasController::class, 'create']);
Route::get('/admin/lgas/{lga}', [LgasController::class, 'show']);
Route::post('/admin/lgas/create', [LgasController::class, 'store']);
Route::get('/admin/lgas/{lga}/edit', [LgasController::class, 'edit']);
Route::put('/admin/lgas/{lga}', [LgasController::class, 'update']);
Route::delete('/admin/lgas/{lga}', [LgasController::class, 'destroy']);
Route::get('/lgas/{lga}/info', [LgasController::class, 'info']);
// Route::get('/lgas/{lga}/info', [LgasController::class, 'info']);
Route::get('/admin/lgas', [LgasController::class, 'index']);

//Ward
Route::get('/admin/wards/create', [WardsController::class, 'create']);
Route::get('/admin/wards/{ward}', [WardsController::class, 'show']);
Route::post('/admin/wards/create', [WardsController::class, 'store']);
Route::get('/admin/wards/{ward}/edit', [WardsController::class, 'edit']);
Route::put('/admin/wards/{ward}', [WardsController::class, 'update']);
Route::delete('/admin/wards/{ward}', [WardsController::class, 'destroy']);
Route::get('/wards/{ward}/info', [WardsController::class, 'info']);
Route::get('/admin/wards', [WardsController::class, 'index']);
Route::put('/wards/{ward}/accreditations', [WardsController::class, 'accreditations']);
Route::put('/wards/{ward}/registrations', [WardsController::class, 'registrations']);

//PU
Route::get('/admin/pus/create', [PusController::class, 'create']);
Route::get('/admin/pus/{pu}', [PusController::class, 'show']);
Route::post('/admin/pus/create', [PusController::class, 'store']);
Route::get('/admin/pus/{pu}/edit', [PusController::class, 'edit']);
Route::put('/admin/pus/{pu}', [PusController::class, 'update']);
Route::delete('/admin/pus/{pu}', [PusController::class, 'destroy']);
Route::get('/pus/info', [PusController::class, 'info']);
Route::put('/pus/{pu}/registrations', [PusController::class, 'registrations']);
Route::put('/pus/{pu}/accreditations', [PusController::class, 'accreditations']);
Route::get('/admin/pus', [PusController::class, 'index']);

//Election
Route::get('/admin/elections/create', [ElectionsController::class, 'create']);
Route::get('/admin/elections/{election}', [ElectionsController::class, 'show']);
Route::get('/admin/elections/{election}/edit', [ElectionsController::class, 'edit']);
Route::post('/admin/elections/create', [ElectionsController::class, 'store']);
Route::put('/admin/elections/{election}', [ElectionsController::class, 'update']);
Route::delete('/admin/elections/{election}', [ElectionsController::class, 'destroy']);
Route::get('/admin/elections', [ElectionsController::class, 'index']);

//Message
Route::get('/admin/messages/create', [MessagesController::class, 'create']);
Route::get('/admin/messages/{message}', [MessagesController::class, 'show']);
Route::get('/admin/messages/{message}/edit', [MessagesController::class, 'edit']);
Route::post('/admin/messages/create', [MessagesController::class, 'store']);
Route::put('/admin/messages/{message}', [MessagesController::class, 'update']);
Route::delete('/admin/messages/{message}', [MessagesController::class, 'destroy']);
Route::get('/admin/messages', [MessagesController::class, 'index']);

//Result
Route::get('/admin/results/create', [ResultsController::class, 'create']);
Route::get('/admin/results/{result}/edit', [ResultsController::class, 'edit']);
Route::post('/admin/results/create', [ResultsController::class, 'store']);
Route::put('/admin/results/{result}', [ResultsController::class, 'update']);
Route::delete('/admin/results/{result}', [ResultsController::class, 'destroy']);
Route::get('/admin/results', [ResultsController::class, 'index']);
Route::get('/results/{result}', [ResultsController::class, 'show']);