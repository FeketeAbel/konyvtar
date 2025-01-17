<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::middleware('auth')->post('/books/{id}/borrow', [BookController::class, 'borrow'])->name('books.borrow');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::post('/books/{id}/return', [BookController::class, 'returnBook'])->name('books.return');

Route::get('/dashboard', [BookController::class, 'create'])->name('dashboard');
Route::post('/dashboard', [BookController::class, 'back'])->name('books.back');
Route::delete('/books/{book}', [BookController::class, 'destroy'])->name('books.destroy');

require __DIR__.'/auth.php';
