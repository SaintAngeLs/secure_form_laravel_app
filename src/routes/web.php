<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileForm\FormViewController;
use App\Http\Controllers\FileUpload\FileUploadController;
use App\Http\Controllers\FileForm\FormApiController;


Route::get('/', [FormViewController::class, 'userForm'])->name('form.userForm');
Route::post('/form/create', [FormApiController::class, 'store'])->name('form.create');;
Route::post('/files/upload', [FileUploadController::class, 'upload'])->name('files.index');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', action: [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/entry/{id}', [DashboardController::class, 'show'])->name('dashboard.show');
});


// Default laravel breeze routes
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
