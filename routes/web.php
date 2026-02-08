<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookListController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RackController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('racks', RackController::class)->except('show')->middleware('role:admin,staff');
    Route::resource('categories', CategoryController::class)->except('show')->middleware('role:admin,staff');
    Route::resource('collections', CollectionController::class)->except('create', 'edit', 'update', 'show');
    Route::resource('books', BookController::class)->middleware('role:admin,staff');
    Route::get('bookList', [BookListController::class, 'index'])->name('bookList.index');
    Route::get('bookList/{id}', [BookListController::class, 'show'])->name('bookList.show');

    // Loan - cart & checkout (visitor, staff, admin bisa akses)
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::get('/loans/cart', [LoanController::class, 'cart'])->name('loans.cart');
    Route::post('/loans/cart/add/{book}', [LoanController::class, 'addToCart'])->name('loans.cart.add');
    Route::delete('/loans/cart/remove/{book}', [LoanController::class, 'removeFromCart'])->name('loans.cart.remove');
    Route::post('/loans/checkout', [LoanController::class, 'checkout'])->name('loans.checkout');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
