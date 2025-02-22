<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AdminController::class, 'index'])->name('admin.index');

Route::get('add', [AdminController::class, 'create'])->name('admin.create');

Route::post('store', [AdminController::class, 'store'])->name('admin.store');

Route::get('edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');

Route::post('update/{id}', [AdminController::class, 'update'])->name('admin.update');

Route::post('delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
