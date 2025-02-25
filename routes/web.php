<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\FieldController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {return Inertia::render('Dashboard');})->name('dashboard');
    Route::resource('builder', TableController::class);
    Route::post('/builder/{id}/duplicate', [TableController::class, 'duplicate'])->name('builder.duplicate');
    Route::post('/builder/{id}/savecontent', [TableController::class, 'savecontent'])->name('builder.savecontent');
    Route::resource('fields', Fieldcontroller::class);
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups/create', [BackupController::class, 'create'])->name('backups.create');
    Route::post('/backups/restore', [BackupController::class, 'restore'])->name('backups.restore');
});

Route::resource('products', ProductController::class);