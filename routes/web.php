<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::redirect('/', '/dashboard');
Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::resource('categories',App\Http\Controllers\CategoryController::class);
Route::resource('items',App\Http\Controllers\ItemController::class);
Route::resource('transactions',App\Http\Controllers\TransactionController::class);
Route::resource('departments', App\Http\Controllers\DepartmentController::class);
Route::resource('buildings', App\Http\Controllers\BuildingController::class);
Route::resource('rooms', App\Http\Controllers\RoomController::class);
Route::resource('setting',App\Http\Controllers\SettingController::class);
Route::resource('employees',App\Http\Controllers\EmployeeController::class);
Route::resource('status',App\Http\Controllers\StatusController::class);
Route::resource('sponsor',App\Http\Controllers\SponsorController::class);
Route::get('generate-pdf-item', [App\Http\Controllers\ItemController::class,'createPDF'])->name('download');
Route::get('generate-pdf-transaction', [App\Http\Controllers\TransactionController::class,'createPDF'])->name('download-pdf');
Route::put('returned/{id}', [App\Http\Controllers\ReturnController::class,'returned'])->name('returned');
Route::post('/search', [App\Http\Controllers\ReturnController::class,'search'])->name('returned');
