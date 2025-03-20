<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\TestController;
use Inertia\Inertia;

use App\Http\Controllers\ChangeLanguageController;
use App\Http\Middleware\SetLocale;

Route::get('lang/{locale}', ChangeLanguageController::class)->name('change-locale');

Route::group(['prefix' => '{locale}', 'middleware' => SetLocale::class, 'where' => ['locale' => '[a-z]{2}']], function () {
    Route::get('/', [TestController::class, 'home'])->name('tester.home');
});
/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {return Inertia::render('Dashboard');})->name('dashboard');
    Route::resource('builder', TableController::class);
    Route::post('/builder/{id}/duplicate', [TableController::class, 'duplicate'])->name('builder.duplicate');
    Route::post('/builder/{recordId}/savecontent', [TableController::class, 'savecontent'])->name('builder.savecontent');
    Route::post('/builder/{id}/createrecord', [RecordController::class, 'createrecord'])->name('builder.createrecord');
    Route::post('/builder/{id}/uploadfile', [RecordController::class, 'uploadfile'])->name('builder.uploadfile');
    Route::resource('fields', Fieldcontroller::class);
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups/create', [BackupController::class, 'create'])->name('backups.create');
    Route::post('/backups/restore', [BackupController::class, 'restore'])->name('backups.restore');
});

/*Route::resource('products', ProductController::class);*/