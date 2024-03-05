<?php

use App\Http\Controllers\AdminController;
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
})->name('Home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware('isAdmin')->group(function(){
    Route::get('/addAdm',[AdminController::class,'AltaAdmin'])->name('AltaAdmin');
    Route::post('/storeAdm',[AdminController::class,'StoreAdmin'])->name('StoreAdmin');
    Route::get('/getProv',[AdminController::class,'ListarProvedores'])->name('ListarProvedores');
    Route::put('/setDisc',[AdminController::class,'AddDiscount'])->name('ModificarDescuento');
    Route::get('/loadCSV',[AdminController::class,'LoadCSV'])->name('CargarCSV');
});

require __DIR__.'/auth.php';
