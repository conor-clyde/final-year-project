<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
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

// Library Management Routes - Admin and Librarian access
Route::middleware(['auth', 'is_librarian'])->group(function () {
    // Books
    Route::get('/book', [BookController::class, 'index'])->name('book.index');
    Route::get('/book/create', [BookController::class, 'create'])->name('book.create');
    Route::post('/book', [BookController::class, 'store'])->name('book.store');
    Route::get('/book/{book}', [BookController::class, 'show'])->name('book.show');
    Route::get('/book/{book}/edit', [BookController::class, 'edit'])->name('book.edit');
    Route::put('/book/{book}', [BookController::class, 'update'])->name('book.update');
    Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('book.destroy');
    Route::get('/book/archived', [BookController::class, 'archived'])->name('book.archived');
    Route::get('/book/deleted', [BookController::class, 'deleted'])->name('book.deleted');
    Route::post('/book/archive', [BookController::class, 'archive'])->name('book.archive');
    Route::post('/book/restore', [BookController::class, 'restore'])->name('book.restore');
    Route::post('/book/force-delete', [BookController::class, 'forceDelete'])->name('book.force-delete');
    Route::get('/book/check-delete/{id}', [BookController::class, 'checkDelete'])->name('book.check-delete');
    Route::get('/book/check-archive/{id}', [BookController::class, 'checkArchive'])->name('book.check-archive');
    Route::post('/book/unarchive-all', [BookController::class, 'unarchiveAll'])->name('book.unarchive-all');
    Route::post('/book/restore-all', [BookController::class, 'restoreAll'])->name('book.restore-all');

    // Authors
    Route::get('/author', [AuthorController::class, 'index'])->name('author.index');
    Route::get('/author/create', [AuthorController::class, 'create'])->name('author.create');
    Route::post('/author', [AuthorController::class, 'store'])->name('author.store');
    Route::get('/author/{author}', [AuthorController::class, 'show'])->name('author.show');
    Route::get('/author/{author}/edit', [AuthorController::class, 'edit'])->name('author.edit');
    Route::put('/author/{author}', [AuthorController::class, 'update'])->name('author.update');
    Route::delete('/author/{author}', [AuthorController::class, 'destroy'])->name('author.destroy');
    Route::get('/author/archived', [AuthorController::class, 'archived'])->name('author.archived');
    Route::get('/author/deleted', [AuthorController::class, 'deleted'])->name('author.deleted');
    Route::post('/author/archive', [AuthorController::class, 'archive'])->name('author.archive');
    Route::post('/author/restore', [AuthorController::class, 'restore'])->name('author.restore');
    Route::post('/author/force-delete', [AuthorController::class, 'forceDelete'])->name('author.force-delete');
    Route::get('/author/check-delete/{id}', [AuthorController::class, 'checkDelete'])->name('author.check-delete');
    Route::get('/author/check-archive/{id}', [AuthorController::class, 'checkArchive'])->name('author.check-archive');
    Route::post('/author/unarchive-all', [AuthorController::class, 'unarchiveAll'])->name('author.unarchive-all');
    Route::post('/author/restore-all', [AuthorController::class, 'restoreAll'])->name('author.restore-all');

    // Publishers
    Route::get('/publisher', [PublisherController::class, 'index'])->name('publisher.index');
    Route::get('/publisher/create', [PublisherController::class, 'create'])->name('publisher.create');
    Route::post('/publisher', [PublisherController::class, 'store'])->name('publisher.store');
    Route::get('/publisher/{publisher}', [PublisherController::class, 'show'])->name('publisher.show');
    Route::get('/publisher/{publisher}/edit', [PublisherController::class, 'edit'])->name('publisher.edit');
    Route::put('/publisher/{publisher}', [PublisherController::class, 'update'])->name('publisher.update');
    Route::delete('/publisher/{publisher}', [PublisherController::class, 'destroy'])->name('publisher.destroy');
    Route::get('/publisher/archived', [PublisherController::class, 'archived'])->name('publisher.archived');
    Route::get('/publisher/deleted', [PublisherController::class, 'deleted'])->name('publisher.deleted');
    Route::post('/publisher/archive', [PublisherController::class, 'archive'])->name('publisher.archive');
    Route::post('/publisher/restore', [PublisherController::class, 'restore'])->name('publisher.restore');
    Route::post('/publisher/force-delete', [PublisherController::class, 'forceDelete'])->name('publisher.force-delete');
    Route::get('/publisher/check-delete/{id}', [PublisherController::class, 'checkDelete'])->name('publisher.check-delete');
    Route::get('/publisher/check-archive/{id}', [PublisherController::class, 'checkArchive'])->name('publisher.check-archive');
    Route::post('/publisher/unarchive-all', [PublisherController::class, 'unarchiveAll'])->name('publisher.unarchive-all');
    Route::post('/publisher/restore-all', [PublisherController::class, 'restoreAll'])->name('publisher.restore-all');

    // Genres
    Route::get('/genre', [GenreController::class, 'index'])->name('genre.index');
    Route::get('/genre/create', [GenreController::class, 'create'])->name('genre.create');
    Route::post('/genre', [GenreController::class, 'store'])->name('genre.store');
    Route::get('/genre/{genre}', [GenreController::class, 'show'])->name('genre.show');
    Route::get('/genre/{genre}/edit', [GenreController::class, 'edit'])->name('genre.edit');
    Route::put('/genre/{genre}', [GenreController::class, 'update'])->name('genre.update');
    Route::delete('/genre/{genre}', [GenreController::class, 'destroy'])->name('genre.destroy');
    Route::get('/genre/archived', [GenreController::class, 'archived'])->name('genre.archived');
    Route::get('/genre/deleted', [GenreController::class, 'deleted'])->name('genre.deleted');
    Route::post('/genre/archive', [GenreController::class, 'archive'])->name('genre.archive');
    Route::post('/genre/restore', [GenreController::class, 'restore'])->name('genre.restore');
    Route::post('/genre/force-delete', [GenreController::class, 'forceDelete'])->name('genre.force-delete');
    Route::get('/genre/check-delete/{id}', [GenreController::class, 'checkDelete'])->name('genre.check-delete');
    Route::get('/genre/check-archive/{id}', [GenreController::class, 'checkArchive'])->name('genre.check-archive');
    Route::post('/genre/unarchive-all', [GenreController::class, 'unarchiveAll'])->name('genre.unarchive-all');
    Route::post('/genre/restore-all', [GenreController::class, 'restoreAll'])->name('genre.restore-all');

    // Loans
    Route::get('/loan', [LoanController::class, 'index'])->name('loan.index');
    Route::get('/loan/create', [LoanController::class, 'create'])->name('loan.create');
    Route::post('/loan', [LoanController::class, 'store'])->name('loan.store');
    Route::get('/loan/{loan}/edit', [LoanController::class, 'edit'])->name('loan.edit');
    Route::put('/loan/{loan}', [LoanController::class, 'update'])->name('loan.update');
    Route::delete('/loan/{loan}', [LoanController::class, 'destroy'])->name('loan.destroy');
    Route::get('/loan/deleted', [LoanController::class, 'deleted'])->name('loan.deleted');
    Route::post('/loan/restore', [LoanController::class, 'restore'])->name('loan.restore');
    Route::post('/loan/force-delete', [LoanController::class, 'forceDelete'])->name('loan.force-delete');
    Route::post('/loan/restore-all', [LoanController::class, 'restoreAll'])->name('loan.restore-all');
});

// Admin-only routes
Route::middleware(['auth', 'is_admin'])->group(function () {
    // Users
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/test', function () {
    return view('test');
})->middleware(['auth', 'is_librarian'])->name('test');
