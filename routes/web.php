<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return view('welcome');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Library Management Routes - Admin and Librarian access
Route::middleware(['auth', 'is_librarian'])->group(function () {
    // Books
    Route::resource('book', BookController::class)->except(['destroy']);
    Route::delete('/book/{book}', [BookController::class, 'destroy'])->name('book.destroy');
    Route::get('/book/archived', [BookController::class, 'archived'])->name('book.archived');
    Route::get('/book/deleted', [BookController::class, 'deleted'])->name('book.deleted');
    Route::post('/book/archive/{id}', [BookController::class, 'archive'])->name('book.archive');
    Route::post('/book/restore', [BookController::class, 'restore'])->name('book.restore');
    Route::post('/book/force-delete', [BookController::class, 'forceDelete'])->name('book.force-delete');
    Route::get('/book/check-delete/{id}', [BookController::class, 'checkDelete'])->name('book.check-delete');
    Route::get('/book/check-archive/{id}', [BookController::class, 'checkArchive'])->name('book.check-archive');
    Route::post('/book/unarchive-all', [BookController::class, 'unarchiveAll'])->name('book.unarchive-all');
    Route::post('/book/restore-all', [BookController::class, 'restoreAll'])->name('book.restore-all');

    // Authors
    Route::resource('author', AuthorController::class)->except(['destroy']);
    Route::delete('/author/{author}', [AuthorController::class, 'destroy'])->name('author.destroy');
    Route::get('/author/archived', [AuthorController::class, 'archived'])->name('author.archived');
    Route::get('/author/deleted', [AuthorController::class, 'deleted'])->name('author.deleted');
    Route::post('/author/archive/{author}', [AuthorController::class, 'archive'])->name('author.archive');
    Route::post('/author/restore', [AuthorController::class, 'restore'])->name('author.restore');
    Route::post('/author/force-delete', [AuthorController::class, 'forceDelete'])->name('author.force-delete');
    Route::get('/author/check-delete/{author}', [AuthorController::class, 'checkDeletionStatus'])->name('author.check-delete');
    Route::get('/author/check-archive/{author}', [AuthorController::class, 'checkArchiveStatus'])->name('author.check-archive');
    Route::post('/author/unarchive-all', [AuthorController::class, 'unarchiveAll'])->name('author.unarchive-all');
    Route::post('/author/restore-all', [AuthorController::class, 'restoreAll'])->name('author.restore-all');

    // Publishers
    Route::resource('publisher', PublisherController::class)->except(['destroy']);
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
    Route::resource('genre', GenreController::class)->except(['destroy']);
    Route::delete('/genre/{genre}', [GenreController::class, 'destroy'])->name('genre.destroy');
    Route::get('/genre/archived', [GenreController::class, 'archived'])->name('genre.archived');
    Route::get('/genre/deleted', [GenreController::class, 'deleted'])->name('genre.deleted');
    Route::post('/genre/archive/{genre}', [GenreController::class, 'archive'])->name('genre.archive');
    Route::post('/genre/restore/{id}', [GenreController::class, 'restore'])->name('genre.restore');
    Route::post('/genre/force-delete', [GenreController::class, 'forceDelete'])->name('genre.force-delete');
    Route::get('/genre/check-delete/{id}', [GenreController::class, 'checkDelete'])->name('genre.check-delete');
    Route::get('/genre/check-archive/{id}', [GenreController::class, 'checkArchive'])->name('genre.check-archive');
    Route::post('/genre/unarchive-all', [GenreController::class, 'unarchiveAll'])->name('genre.restore-all');
    Route::post('/genre/unarchive/{genre}', [GenreController::class, 'unarchive'])->name('genre.unarchive');
    Route::delete('/genre/force-delete/{id}', [GenreController::class, 'forceDelete'])->name('genre.forceDelete');

    // Loans
    Route::get('/loan', [LoanController::class, 'index'])->name('loan.index');
});

// Admin-only routes
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
});
