<?php

use App\Http\Controllers\CollectorController;
use App\Http\Controllers\DeliveryCompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorageLocationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('delivery-companies')->name('delivery-companies.')->group(function () {
        Route::get('/', [DeliveryCompanyController::class, 'index'])->name('index');
        Route::post('/', [DeliveryCompanyController::class, 'store'])->name('store');
        Route::patch('/{delivery_company}', [DeliveryCompanyController::class, 'update'])->name('update');
        Route::delete('/{delivery_company}', [DeliveryCompanyController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('collectors')->name('collectors.')->group(function () {
        Route::get('/', [CollectorController::class, 'index'])->name('index');
        Route::post('/', [CollectorController::class, 'store'])->name('store');
        Route::patch('/{collector}', [CollectorController::class, 'update'])->name('update');
        Route::delete('/{collector}', [CollectorController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('storage-locations')->name('storage-locations.')->group(function () {
        Route::get('/', [StorageLocationController::class, 'index'])->name('index');
        Route::post('/', [StorageLocationController::class, 'store'])->name('store');
        Route::patch('/{storage_location}', [StorageLocationController::class, 'update'])->name('update');
        Route::delete('/{storage_location}', [StorageLocationController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
