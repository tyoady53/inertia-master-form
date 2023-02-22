<?php

use App\Http\Controllers\Apps\ExtendController;
use App\Http\Controllers\Apps\Master\FormController;
use App\Http\Controllers\Apps\Master\ReportController;
use App\Http\Controllers\Apps\Master\TicketsController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

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

//route home
Route::get('/', function () {
    return \Inertia\Inertia::render('Auth/Login');
})->middleware('guest');

//prefix "apps"
Route::prefix('apps')->group(function() {

    //middleware "auth"
    Route::group(['middleware' => ['auth']], function () {

        //route dashboard
        Route::get('dashboard', \App\Http\Controllers\Apps\DashboardController::class)->name('apps.dashboard');

        Route::resource('/roles', \App\Http\Controllers\Apps\RoleController::class, ['as' => 'apps']);
            // ->middleware('permission:roles.index|roles.create|roles.show|roles.edit|roles.delete');

        Route::resource('/users', \App\Http\Controllers\Apps\UserController::class, ['as' => 'apps'])
            ->middleware('permission:users.index|users.create|users.edit|roles.delete');

        Route::prefix('master')->group( function() {
            Route::prefix('forms')->group( function() {
                Route::get('', [FormController::class, 'index'])->name('apps.master.forms.index');

                Route::get('/create', [FormController::class, 'create'])->name('apps.master.forms.create');

                Route::post('/new_form', [FormController::class, 'create_form'])->name('apps.master.forms.new_form');

                Route::get('/{form:slug}/manage', [FormController::class, 'show'])->name('apps.master.forms.manage');

                Route::post('/add_column', [FormController::class, 'add_column'])->name('apps.master.forms.add_column');

                Route::post('/set_parent', [FormController::class, 'set_parent'])->name('forms.master.forms.set_parent');

                Route::post('/add_relation', [FormController::class, 'set_relation'])->name('forms.master.forms.add_relation');

                Route::get('/{form:slug}/show', [FormController::class, 'show'])->name('apps.master.forms.show');

                Route::post('/new_data', [FormController::class, 'create_data'])->name('apps.master.forms.new_data');

                Route::post('/update_data', [FormController::class, 'update_data'])->name('apps.master.forms.update_data');

                Route::delete('/{form:slug}/delete_data/{id}', [FormController::class, 'delete_data']);

                Route::get('/{form:slug}/extend/{id}', [ExtendController::class, 'index'])->name('apps.master.forms.extend_index');

                Route::post('/{form:slug}/add_extend/{id}', [ExtendController::class, 'store'])->name('apps.master.forms.extend_store');
            });
            Route::prefix('reports')->group( function() {
                Route::get('', [ReportController::class, 'index'])->name('apps.master.reports.index');

                Route::get('/{form:slug}/show', [ReportController::class, 'show'])->name('apps.master.reports.show');

                Route::get('/{form:slug}/filter', [ReportController::class, 'generate_report'])->name('apps.master.reports.filter');

                Route::get('/{form:slug}/export', [ReportController::class, 'export'])->name('apps.master.reports.export');
            });
            Route::prefix('tickets')->group( function() {
                Route::get('/', [TicketsController::class, 'index'])->name('apps.master.tickets.index');
                Route::get('/create', [TicketsController::class, 'create'])->name('apps.master.tickets.create');
                Route::post('/store', [TicketsController::class, 'store'])->name('apps.master.tickets.store');
                Route::get('/{ticket:thread_id}/thread', [TicketsController::class, 'show'])->name('apps.master.tickets.show');
                Route::post('/thread', [TicketsController::class, 'thread'])->name('apps.master.ticket.thread');
            });
        });
    });
});