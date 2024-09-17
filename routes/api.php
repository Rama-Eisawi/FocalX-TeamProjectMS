<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function () {
        Route::post('register', 'register')->name('auth.register');
        Route::post('login', 'login')->name('auth.login');
        Route::post('logout', 'logout')->name('auth.logout')->middleware('auth:api'); //This middleware ensures that the user is authenticated via a JWT token
    });

Route::middleware(['auth:api'])->group(function () {
    //assigned the task to a user
    Route::post('/projects/{project}/tasks/{task}/assign/{user}', [TaskController::class, 'assignRole']);

    //create a task by the manager of the project
    Route::post('/projects/{project}/tasks', [TaskController::class, 'store']); //done

    //create a project by admin
    Route::post('/projects', [ProjectController::class, 'store']); //done
    //assigned a manager role for a user
    Route::post('/projects/{project}/{user}', [ProjectController::class, 'assignManager']); //done

});
