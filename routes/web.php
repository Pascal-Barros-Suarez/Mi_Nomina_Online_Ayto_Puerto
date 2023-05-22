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


/* Route::get('/dashboard', function () {
    $lastPayroll = User::where('id', Auth::id())
        ->with(['payroll' => function ($query) {
            $query->orderBy('year', 'desc') // Ordenar las nóminas por año de forma descendente
                ->orderBy('month', 'desc'); // Luego ordenar las nóminas por mes de forma descendente
        }])
        ->firstOrFail() //Obtener el usuario o lanzar una excepción si no se encuentra
        ->payroll //accedemos a la variable
        ->first();
        $array = $lastPayroll->getAttributes();

    return Inertia::render('Dashboard',  ['payroll' => $array]);
})->middleware(['auth', 'verified'])->name('dashboard'); */

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//payrolls
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/generate-pdf', [PayrollController::class, 'generatePdf'])->name('nomina.pdf');
    Route::get('/userPayrolls', [PayrollController::class, 'userPayrolls'])->name('nomina.user.todas');
    Route::get('/userLastPayroll', [PayrollController::class, 'lastPayroll']);
});



/* Route::get('/adminPanel', function () {
 return Inertia::render('Dashboard');
};) */
require __DIR__ . '/auth.php';
