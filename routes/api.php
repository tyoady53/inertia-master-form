<?php

use App\Http\Controllers\Apps\Master\FormController;
use App\Http\Controllers\Apps\Master\ReportController;
use App\Http\Controllers\Apps\Master\TicketsController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/deparments', [TicketsController::class, 'getDepartments']);
Route::post('/sla', [TicketsController::class, 'sla']);
Route::post('/user', [TicketsController::class, 'getUser']);
Route::post('/branch', [TicketsController::class, 'getBranch']);
Route::get('/users', [TicketsController::class, 'getUsers']);
Route::post('/upload', [TicketsController::class, 'upload']);
Route::get('/{form:slug}/dynamic_table/{id}', [FormController::class, 'getDataTable_API']);
Route::get('/{form:slug}/generate_report/{id}', [ReportController::class, 'generate_report']);