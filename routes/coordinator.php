<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Coordinator\CoordinatorCvrController;
use App\Http\Controllers\Coordinator\CoordinatorLgaController;
use App\Http\Controllers\Coordinator\CoordinatorPuController;
use App\Http\Controllers\Coordinator\CoordinatorRoleController;
use App\Http\Controllers\Coordinator\CoordinatorStateController;
use App\Http\Controllers\Coordinator\CoordinatorWardController;
use App\Http\Controllers\Coordinator\CoordinatorZoneController;

Route::middleware(
    'auth',
    'role:state_coordinator,zonal_coordinator,lga_coordinator,ward_coordinator'
)->group(function () {

    Route::get('/coordinator', [DashboardController::class, 'coordinator'])->name('coordinator.dashboard');

    /* Profile */
    Route::get('/coordinator/profile', [UsersController::class, 'profile']);
    Route::put('/coordinator/profile/{user}', [UsersController::class, 'updatePassword']);
    Route::patch('/coordinator/profile/{user}', [UsersController::class, 'updateProfile']);

    /* Roles */
    Route::get('/coordinator/roles', [CoordinatorRoleController::class, 'index']);

    /* States */
    Route::get('/coordinator/states', [CoordinatorStateController::class, 'index']);
    Route::get('/coordinator/states/{state}', [CoordinatorStateController::class, 'show']);

    /* Zones */
    Route::get('/coordinator/zones', [CoordinatorZoneController::class, 'index']);
    Route::get('/coordinator/zones/{zone}', [CoordinatorZoneController::class, 'show']);

    /* LGAs */
    Route::get('/coordinator/lgas', [CoordinatorLgaController::class, 'index']);
    Route::get('/coordinator/lgas/{lga}', [CoordinatorLgaController::class, 'show']);

    /* Wards */
    Route::get('/coordinator/wards', [CoordinatorWardController::class, 'index']);
    Route::get('/coordinator/wards/{ward}', [CoordinatorWardController::class, 'show']);

    /* PUs */
    Route::get('/coordinator/pus', [CoordinatorPuController::class, 'index']);
    Route::get('/coordinator/pus/{pu}', [CoordinatorPuController::class, 'show']);

    /* CVR */
    Route::get('/coordinator/cvr/records', [CoordinatorCvrController::class, 'index']);
    Route::post('/coordinator/cvrs', [CoordinatorCvrController::class, 'store']);
    Route::post('/coordinator/cvrs/update', [CoordinatorCvrController::class, 'updateWardCvr']);
    Route::post('/coordinator/cvrs/update-pu', [CoordinatorCvrController::class, 'updatePuCvr']);
    Route::get('/coordinator/cvr/states', [CoordinatorCvrController::class, 'states']);
    Route::get('/coordinator/cvr/voters', [CoordinatorCvrController::class, 'voters']);
    Route::get('/coordinator/cvr/logins', [CoordinatorCvrController::class, 'logins'])
        ->middleware('role:state_coordinator,zonal_coordinator,lga_coordinator');
    Route::post('/coordinator/cvr/logins', [CoordinatorCvrController::class, 'storeLogin'])
        ->middleware('role:state_coordinator,zonal_coordinator,lga_coordinator');

    Route::get('/coordinator/states/{state}/cvr', [CoordinatorCvrController::class, 'zones']);
    Route::get('/coordinator/states/{state}/zones/{zone}/cvr', [CoordinatorCvrController::class, 'lgas']);
    Route::get('/coordinator/states/{state}/zones/{zone}/lgas/{lga}/cvr', [CoordinatorCvrController::class, 'wards']);
    Route::get('/coordinator/states/{state}/zones/{zone}/lgas/{lga}/wards/{ward}/cvr', [CoordinatorCvrController::class, 'pus']);
});
