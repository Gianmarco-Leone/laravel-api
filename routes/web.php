<?php

use App\Http\Controllers\ProfileController;

// * Guest
use App\Http\Controllers\Guest\HomeController as GuestHomeController;

// * Admin
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\TechnologyController;
use App\Http\Controllers\Admin\TypeController;

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

// * Rotte statiche Guest
Route::get('/', [GuestHomeController::class, 'index']);
Route::get('/projects/{index}', [GuestHomeController::class, 'showDetail'])->name('card_detail');

// * Rotte statiche Admin
Route::get('/home', [AdminHomeController::class, 'index'])->middleware('auth')->name('home');

// * Rotte risorse e softDelete
Route::middleware('auth')
    ->prefix('/admin')
    ->name('admin.')
    ->group(function () {
        // * Rotte softDelete
        Route::get('projects/trash', [ProjectController::class, 'trash'])->name('projects.trash');
        Route::put('projects/{project}/restore', [ProjectController::class, 'restore'])->name('projects.restore');
        Route::delete('projects/{project}/forcedelete', [ProjectController::class, 'forcedelete'])->name('projects.forcedelete');
        
        // * Risorsa Project
        Route::resource('projects', ProjectController::class)
        ->parameters(['projects' => 'project:slug']);

        // * Risorsa Type
        Route::resource('types', TypeController::class)->except(['show']);

        // * Risorsa Technology
        Route::resource('technologies', TechnologyController::class)->except(['show']);
    });

// * Rotte profilo
Route::middleware('auth')
    ->prefix('/profile')
    ->name('profile.')
    ->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/auth.php';