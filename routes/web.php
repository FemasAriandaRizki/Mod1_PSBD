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

Route::get('trash', [AdminController::class, 'trash'])->name('admin.trash');

Route::post('restore/{id}', [AdminController::class, 'restore'])->name('admin.restore');

Route::post('force-delete/{id}', [AdminController::class, 'forceDelete'])->name('admin.forceDelete');

Route::post('restore-all', [AdminController::class, 'restoreAll'])->name('admin.restoreAll');
