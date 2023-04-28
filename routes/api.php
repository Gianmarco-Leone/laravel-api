<?php

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ProjectController;

use Illuminate\Http\Request;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// * ProjectController
Route::apiResource('projects', ProjectController::class)->except('store', 'update', 'destroy');
Route::get('/type/{type_id}/projects', [ProjectController::class, 'getProjectsByType']);

// * MessageController
Route::post('messages', [MessageController::class, 'store']);