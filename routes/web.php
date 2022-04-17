<?php

use App\Http\Controllers\FilterController;
use App\Http\Controllers\StudentsController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('students', App\Http\Controllers\StudentsController::class);
Route::resource('vactinations', App\Http\Controllers\VactinationsController::class);

Route::get('/export', [StudentsController::class, 'export'])->name('export');
Route::get('/exportVac', [\App\Http\Controllers\VactinationsController::class, 'exportVac'])->name('exportVac');
Route::get('/exportTest', [StudentsController::class, 'exportTest'])->name('exportTest');
Route::get('/exportQuery', [StudentsController::class, 'exportQuery'])->name('exportQuery');

Route::get('/generate-docx', [StudentsController::class, 'generateDocx'])->name('generateDocx');
