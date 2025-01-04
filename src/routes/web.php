<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileForm\FormViewController;
use App\Http\Controllers\FileUpload\FileUploadController;
use App\Http\Controllers\FileForm\FormApiController;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [FormViewController::class, 'userForm'])->name('form.userForm');
Route::get('/user/form', [FormViewController::class, 'userForm'])->name('form.userForm');
Route::post('/', [FormViewController::class, 'store'])->name('form.store');;
Route::post('/form/create', [FormApiController::class, 'store'])->name('form.create');;
Route::post('/files/upload', [FileUploadController::class, 'upload'])->name('files.index');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/admin/entries', [FormViewController::class, 'adminEntries'])->middleware('can:admin')->name('form.adminEntries');
});

require __DIR__.'/auth.php';
