<?php

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PayrollController;
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


//////////////////////////////////// DASHBOARD Y HOME ////////////////////////////////////
Route::get('/dashboard', [PayrollController::class, 'lastPayroll'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


//////////////////////////////////// USER ////////////////////////////////////
Route::middleware(['auth','password.confirm'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//////////////////////////////////// PAYROLLS ////////////////////////////////////
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/generate-pdf', [PayrollController::class, 'generatePdf'])->name('nomina.pdf');
    Route::get('/userPayrolls', [PayrollController::class, 'userPayrolls'])->name('nomina.user.todas');
    //Route::get('/userLastPayroll', [PayrollController::class, 'lastPayroll']);
});

require __DIR__ . '/auth.php';
