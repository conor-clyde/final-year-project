<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublisherController;
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

Route::get('/catalogue', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('catalogue');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// genre
//Route::get('/genre', function () {
  //  return view('genre.index');
//})->middleware(['auth', 'verified'])->name('genre');
//
Route::get('/genre/all',  [GenreController::class, 'unarchiveAll'])->name('genre.all');
Route::get('/genre/restore-all',  [GenreController::class, 'restoreAll'])->name('genre.restore-all');




Route::get('/genre/archived', [GenreController::class, 'archived'])->name('genre.archived');
Route::get('/genre/deleted', [GenreController::class, 'deleted'])->name('genre.deleted');
Route::delete('/genre/permanent-delete/{id}', [GenreController::class, 'permanentDelete'])->name('genre.permanent-delete');


Route::get('/genre/restore/{genre}',  [GenreController::class, 'restore'])->name('genre.restore');
Route::get('/genre/create',  [GenreController::class, 'create'])->name('genre.create');
Route::get('/genre/{genre}',  [GenreController::class, 'show']);
Route::post('/genre/created', [GenreController::class, 'store'])->name('genre.store');;
Route::get('/genre/{genre}/edit',  [GenreController::class, 'edit']);
Route::put('/genre/update/{genre}', [GenreController::class, 'update'])->name('genre.update');;
Route::post('/genre/delete', [GenreController::class, 'destroy']);
Route::get('/genre/check-deletion/{id}', [GenreController::class, 'checkDeletionStatus'])->name('genre.check-deletion');
Route::get('/genre/check-archive/{id}', [GenreController::class, 'checkArchiveStatus'])->name('genre.check-archive');
Route::post('/genre/check-bulk-archive', [GenreController::class, 'checkBulkArchive'])->name('genre.check-bulk-archive');
Route::post('/genre/check-bulk-delete', [GenreController::class, 'checkBulkDelete'])->name('genre.check-bulk-delete');
Route::get('/genre/archive/{genre}', [GenreController::class, 'archive'])->name('genre.archive');
Route::delete('/genre/permanent-delete/{id}', [GenreController::class, 'permanentDelete'])->name('genre.permanent-delete');
Route::delete('/delete-author/{authorId}/{catalogueEntryId}', [BookController::class, 'deleteAuthorCatalogEntry'])->name('delete.author');

//Route::post('/genre/archive/{genre}', [GenreController::class, 'archive'])->name('genre.archive');

Route::get('/genre/unarchive/{genre}',  [GenreController::class, 'unarchive'])->name('genre.unarchive');

Route::get('/genre/{genre}', [GenreController::class, 'show']);

// In routes/web.php

Route::post('/genre/bulk-delete', [GenreController::class, 'bulkDelete'])->name('genre.bulk-delete');
Route::post('/genre/bulk-archive', [GenreController::class, 'bulkArchive'])->name('genre.bulk-archive');


Route::get('/genre', [GenreController::class, 'index'])->middleware(['auth', 'verified'])->middleware(['auth', 'is_librarian'])->name('genre');;



//
//Route::resource('genres', 'GenreController');

//publisher
Route::get('/publisher', [PublisherController::class, 'index'])->middleware(['auth', 'verified'])->middleware(['auth', 'is_librarian'])->name('publisher');;
Route::get('/publisher/create',  [PublisherController::class, 'create'])->name('publisher.create');
Route::post('/publisher/created', [PublisherController::class, 'store'])->name('publisher.store');;
Route::get('/publisher/{publisher}/edit',  [PublisherController::class, 'edit']);
Route::put('/publisher/update/{publisher}', [PublisherController::class, 'update'])->name('publisher.update');;
Route::delete('/publisher/delete/{publisher}', [PublisherController::class, 'destroy'])->name('publisher.delete');;
Route::get('/publisher/archived',  [PublisherController::class, 'archived'])->name('publisher.archived');
Route::get('/publisher/deleted', [PublisherController::class, 'deleted'])->name('publisher.deleted');
Route::get('/publisher/{publisher}', [PublisherController::class, 'show'])->name('publisher.show');

Route::post('/author/delete', [AuthorController::class, 'destroy'])->name('author.delete');

//author
Route::get('/author/unarchive-all',  [AuthorController::class, 'unarchiveAll'])->name('author.unarchive-all');
Route::get('/author/restore-all',  [AuthorController::class, 'restoreAll'])->name('author.restore-all');
Route::get('/author', [AuthorController::class, 'index'])->middleware(['auth', 'verified'])->middleware(['auth', 'is_librarian'])->name('author');;
Route::get('/author/create',  [AuthorController::class, 'create'])->name('author.create');
Route::post('/author/created', [AuthorController::class, 'store'])->name('author.store');;
Route::get('/author/{author}/edit',  [AuthorController::class, 'edit']);
Route::put('/author/update/{author}', [AuthorController::class, 'update'])->name('author.update');;
Route::get('/author/archived',  [AuthorController::class, 'archived'])->name('author.archived');
Route::get('/author/deleted', [AuthorController::class, 'deleted'])->name('author.deleted');
Route::get('/author/check-deletion/{id}', [AuthorController::class, 'checkDeletionStatus'])->name('author.check-deletion');
Route::get('/author/check-archive/{id}', [AuthorController::class, 'checkArchiveStatus'])->name('author.check-archive');
Route::get('/author/archive/{author}', [AuthorController::class, 'archive'])->name('author.archive');
Route::get('/author/{author}', [AuthorController::class, 'show']);
Route::get('/author/unarchive/{author}',  [AuthorController::class, 'unarchive'])->name('author.unarchive');
Route::get('/author/restore/{author}',  [AuthorController::class, 'restore'])->name('author.restore');



//book
Route::get('/get-book-details/{book}', [BookController::class, 'getDetails']);
Route::get('/book/unarchive-all',  [BookController::class, 'unarchiveAll'])->name('book.unarchive-all');
Route::get('/book/restore-all',  [BookController::class, 'restoreAll'])->name('book.restore-all');
Route::get('/book/check-archive/{id}', [BookController::class, 'checkArchiveStatus'])->name('book.check-archive');
Route::get('/book/check-delete/{id}', [BookController::class, 'checkDeleteStatus'])->name('book.check-delete');
Route::get('/book/archived',  [BookController::class, 'archived'])->name('book.archived');
Route::get('/book/deleted', [BookController::class, 'deleted'])->name('book.deleted');
Route::get('/book', [BookController::class, 'index'])->middleware(['auth', 'verified'])->middleware(['auth', 'is_librarian'])->name('book');;
Route::get('/book/create',  [BookController::class, 'create'])->name('book.create');
Route::post('/book/created', [BookController::class, 'store'])->name('book.store');;
Route::get('/book/{book}/edit',  [BookController::class, 'edit']);
Route::put('/book/title-update/{book}', [BookController::class, 'titleUpdate'])->name('book.title-update');;
Route::put('/book/update/{book}', [BookController::class, 'update'])->name('book.update');;
Route::post('/book/delete', [BookController::class, 'destroy'])->name('book.delete');;
Route::get('/book/archive/{book}',  [BookController::class, 'archive'])->name('book.archive');
Route::get('/book/unarchive/{book}',  [BookController::class, 'unarchive'])->name('book.unarchive');
Route::get('/book/{book}',  [BookController::class, 'show'])->name('book.show');
Route::get('/book/restore/{book}',  [BookController::class, 'restore'])->name('book.restore');
Route::delete('/book/permanent-delete/{id}', [BookController::class, 'permanentDelete'])->name('book.permanent-delete');

//loan
Route::get('/loan', [LoanController::class, 'index'])->middleware(['auth', 'verified'])->middleware(['auth', 'is_librarian'])->name('loan');;
Route::get('/loan/create',  [LoanController::class, 'create'])->name('loan.create');
Route::post('/loan/created', [LoanController::class, 'store'])->name('loan.store');;





Route::get('/user', function () {
    return view('user.index');
})->middleware(['auth', 'verified'])->middleware(['auth', 'is_admin'])->name('user');



require __DIR__.'/auth.php';
