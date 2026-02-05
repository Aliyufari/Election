<?php

use App\Http\Controllers\Coordinators\CoordinatorCvrController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CvrController;
use App\Http\Controllers\PusController;
use App\Http\Controllers\LgasController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WardsController;
use App\Http\Controllers\ZonesController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\DashboardController;

Route::middleware(
    'auth',
    'role:state_coordinator,zonal_coordinator,lga_coordinator,ward_coordinator'
)->group(function () {

    Route::get('/coordinator', [DashboardController::class, 'coordinator'])->name('coordinator.dashboard');

    /* Profile */
    Route::get('/coordinator/profile', [UsersController::class, 'profile']);
    Route::put('/coordinator/profile/{user}', [UsersController::class, 'updatePassword']);
    Route::patch('/coordinator/profile/{user}', [UsersController::class, 'updateProfile']);

    Route::get('/coordinator/state/list', [StatesController::class, 'list']);
    Route::get('/coordinator/states/{state}/info', [StatesController::class, 'info']);
    Route::get('/coordinator/states/{state}/zones', [StatesController::class, 'zones']);

    Route::get('/coordinator/zones/{zone}/lgas', [ZonesController::class, 'lgas']);

    Route::get('/coordinator/lgas/{lga}/info', [LgasController::class, 'info']);

    Route::get('/coordinator/wards/{ward}/info', [WardsController::class, 'info']);
    Route::put('/coordinator/wards/{ward}/registrations', [WardsController::class, 'registrations']);
    Route::put('/coordinator/wards/{ward}/accreditations', [WardsController::class, 'accreditations']);

    Route::get('/coordinator/pus/info', [PusController::class, 'info']);
    Route::put('/coordinator/pus/{pu}/registrations', [PusController::class, 'registrations']);
    Route::put('/coordinator/pus/{pu}/accreditations', [PusController::class, 'accreditations']);

    /* CVR */
    Route::get('/coordinator/cvr/records', [CoordinatorCvrController::class, 'index']);
    Route::post('/coordinator/cvrs', [CoordinatorCvrController::class, 'store']);
    Route::post('/coordinator/cvrs/update', [CoordinatorCvrController::class, 'updateWardCvr']);
    Route::post('/coordinator/cvrs/update-pu', [CoordinatorCvrController::class, 'updatePuCvr']);
    Route::get('/coordinator/cvr/states', [CoordinatorCvrController::class, 'states']);
    Route::get('/coordinator/cvr/voters', [CoordinatorCvrController::class, 'voters']);
    Route::get('/coordinator/cvr/logins', [CoordinatorCvrController::class, 'logins']);
    Route::post('/coordinator/cvr/logins', [CoordinatorCvrController::class, 'storeLogin']);

    Route::get('/coordinator/states/{state}/cvr', [CoordinatorCvrController::class, 'zones']);
    Route::get('/coordinator/states/{state}/zones/{zone}/cvr', [CoordinatorCvrController::class, 'lgas']);
    Route::get('/coordinator/states/{state}/zones/{zone}/lgas/{lga}/cvr', [CoordinatorCvrController::class, 'wards']);
    Route::get('/coordinator/states/{state}/zones/{zone}/lgas/{lga}/wards/{ward}/cvr', [CoordinatorCvrController::class, 'pus']);
});
