<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CvrController;
use App\Http\Controllers\PusController;
use App\Http\Controllers\LgasController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WardsController;
use App\Http\Controllers\ZonesController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\ResultsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ElectionsController;

Route::middleware('auth', 'role:admin,super')->group(function () {

    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');

    /* Profile */
    Route::get('/profile', [UsersController::class, 'profile']);
    Route::put('/profile/{user}', [UsersController::class, 'updatePassword']);
    Route::patch('/profile/{user}', [UsersController::class, 'updateProfile']);

    /* Admin */
    // Route::get('/admin', [AdminController::class, 'index']);
    // Route::post('/admin/ajax', [AdminController::class, 'ajax']);

    /* Roles */
    Route::get('/admin/roles', [RolesController::class, 'index']);

    /* Users */
    Route::get('/admin/users', [UsersController::class, 'index']);
    Route::get('/admin/users/create', [UsersController::class, 'create']);
    Route::post('/admin/users', [UsersController::class, 'store']);
    Route::get('/admin/users/{user}', [UsersController::class, 'show']);
    Route::get('/admin/users/{user}/edit', [UsersController::class, 'edit']);
    Route::put('/admin/users/{user}', [UsersController::class, 'update']);
    Route::delete('/admin/users/{user}', [UsersController::class, 'destroy']);

    /* States */
    Route::get('/admin/states', [StatesController::class, 'index']);
    Route::get('/admin/states/create', [StatesController::class, 'create']);
    Route::post('/admin/states/create', [StatesController::class, 'store']);
    Route::get('/admin/states/{state}', [StatesController::class, 'show']);
    Route::get('/admin/states/{state}/edit', [StatesController::class, 'edit']);
    Route::put('/admin/states/{state}', [StatesController::class, 'update']);
    Route::delete('/admin/states/{state}', [StatesController::class, 'destroy']);
    Route::get('/admin/state/list', [StatesController::class, 'list']);
    Route::get('/states/{state}/info', [StatesController::class, 'info']);
    Route::get('/states/{state}/zones', [StatesController::class, 'zones']);

    /* Zones */
    Route::get('/admin/zones', [ZonesController::class, 'index']);
    Route::get('/admin/zones/create', [ZonesController::class, 'create']);
    Route::post('/admin/zones/create', [ZonesController::class, 'store']);
    Route::get('/admin/zones/{zone}', [ZonesController::class, 'show']);
    Route::get('/admin/zones/{zone}/edit', [ZonesController::class, 'edit']);
    Route::put('/admin/zones/{zone}', [ZonesController::class, 'update']);
    Route::delete('/admin/zones/{zone}', [ZonesController::class, 'destroy']);
    Route::get('/zones/{zone}/info', [ZonesController::class, 'info']);
    Route::get('/zones/{zone}/lgas', [ZonesController::class, 'lgas']);

    /* LGAs */
    Route::get('/admin/lgas', [LgasController::class, 'index']);
    Route::get('/admin/lgas/create', [LgasController::class, 'create']);
    Route::post('/admin/lgas/create', [LgasController::class, 'store']);
    Route::get('/admin/lgas/{lga}', [LgasController::class, 'show']);
    Route::get('/admin/lgas/{lga}/edit', [LgasController::class, 'edit']);
    Route::put('/admin/lgas/{lga}', [LgasController::class, 'update']);
    Route::delete('/admin/lgas/{lga}', [LgasController::class, 'destroy']);
    Route::get('/lgas/{lga}/info', [LgasController::class, 'info']);

    /* Wards */
    Route::get('/admin/wards', [WardsController::class, 'index']);
    Route::get('/admin/wards/create', [WardsController::class, 'create']);
    Route::post('/admin/wards/create', [WardsController::class, 'store']);
    Route::get('/admin/wards/{ward}', [WardsController::class, 'show']);
    Route::get('/admin/wards/{ward}/edit', [WardsController::class, 'edit']);
    Route::put('/admin/wards/{ward}', [WardsController::class, 'update']);
    Route::delete('/admin/wards/{ward}', [WardsController::class, 'destroy']);
    Route::get('/wards/{ward}/info', [WardsController::class, 'info']);
    Route::put('/wards/{ward}/registrations', [WardsController::class, 'registrations']);
    Route::put('/wards/{ward}/accreditations', [WardsController::class, 'accreditations']);

    /* PUs */
    Route::get('/admin/pus', [PusController::class, 'index']);
    Route::get('/admin/pus/create', [PusController::class, 'create']);
    Route::post('/admin/pus/create', [PusController::class, 'store']);
    Route::get('/admin/pus/{pu}', [PusController::class, 'show']);
    Route::get('/admin/pus/{pu}/edit', [PusController::class, 'edit']);
    Route::put('/admin/pus/{pu}', [PusController::class, 'update']);
    Route::delete('/admin/pus/{pu}', [PusController::class, 'destroy']);
    Route::get('/pus/info', [PusController::class, 'info']);
    Route::put('/pus/{pu}/registrations', [PusController::class, 'registrations']);
    Route::put('/pus/{pu}/accreditations', [PusController::class, 'accreditations']);

    /* Elections */
    Route::get('/admin/elections', [ElectionsController::class, 'index']);
    Route::get('/admin/elections/create', [ElectionsController::class, 'create']);
    Route::post('/admin/elections/create', [ElectionsController::class, 'store']);
    Route::get('/admin/elections/{election}', [ElectionsController::class, 'show']);
    Route::get('/admin/elections/{election}/edit', [ElectionsController::class, 'edit']);
    Route::put('/admin/elections/{election}', [ElectionsController::class, 'update']);
    Route::delete('/admin/elections/{election}', [ElectionsController::class, 'destroy']);

    /* Messages */
    Route::get('/admin/messages', [MessagesController::class, 'index']);
    Route::get('/admin/messages/create', [MessagesController::class, 'create']);
    Route::post('/admin/messages/create', [MessagesController::class, 'store']);
    Route::get('/admin/messages/{message}', [MessagesController::class, 'show']);
    Route::get('/admin/messages/{message}/edit', [MessagesController::class, 'edit']);
    Route::put('/admin/messages/{message}', [MessagesController::class, 'update']);
    Route::delete('/admin/messages/{message}', [MessagesController::class, 'destroy']);

    /* Results */
    Route::get('/admin/results', [ResultsController::class, 'index']);
    Route::get('/admin/results/create', [ResultsController::class, 'create']);
    Route::post('/admin/results/create', [ResultsController::class, 'store']);
    Route::get('/admin/results/{result}', [ResultsController::class, 'show']);
    Route::get('/admin/results/{result}/edit', [ResultsController::class, 'edit']);
    Route::put('/admin/results/{result}', [ResultsController::class, 'update']);
    Route::delete('/admin/results/{result}', [ResultsController::class, 'destroy']);

    /* CVR */
    Route::get('/admin/cvr/records', [CvrController::class, 'index']);
    Route::post('/admin/cvrs', [CvrController::class, 'store']);
    Route::post('/admin/cvrs/update', [CvrController::class, 'updateWardCvr']);
    Route::post('/admin/cvrs/update-pu', [CvrController::class, 'updatePuCvr']);
    Route::get('/admin/cvr/states', [CvrController::class, 'states']);
    Route::get('/admin/cvr/voters', [CvrController::class, 'voters']);
    Route::post('/admin/cvr/update-figure', [CvrController::class, 'updateFigure']);
    Route::get('/admin/cvr/logins', [CvrController::class, 'logins']);
    Route::post('/admin/cvr/logins', [CvrController::class, 'storeLogin']);
    Route::post('/admin/cvr/logins/{user}', [CvrController::class, 'updateLogin']);
    Route::post('/admin/cvr/logins/{user}', [CvrController::class, 'deleteLogin']);

    Route::get('/admin/states/{state}/cvr', [CvrController::class, 'zones']);
    Route::get('/admin/states/{state}/zones/{zone}/cvr', [CvrController::class, 'lgas']);
    Route::get('/admin/states/{state}/zones/{zone}/lgas/{lga}/cvr', [CvrController::class, 'wards']);
    Route::get('/admin/states/{state}/zones/{zone}/lgas/{lga}/wards/{ward}/cvr', [CvrController::class, 'pus']);
});
