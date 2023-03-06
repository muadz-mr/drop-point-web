<?php

use App\Http\Controllers\DeliveryCompanyController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/delivery-companies', [DeliveryCompanyController::class, 'index'])->name('delivery-companies.index');
    Route::get('/delivery-companies/{delivery_company}', [DeliveryCompanyController::class, 'edit'])->name('delivery-companies.edit');
    Route::post('/delivery-companies', [DeliveryCompanyController::class, 'store'])->name('delivery-companies.store');
    Route::patch('/delivery-companies/{delivery_company}', [DeliveryCompanyController::class, 'update'])->name('delivery-companies.update');
    Route::delete('/delivery-companies/{delivery_company}', [DeliveryCompanyController::class, 'destroy'])->name('delivery-companies.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
