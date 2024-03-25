<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Author_CatalogueEntry;
use App\Models\BookCopy;
use App\Models\CatalogueEntry;
use App\Models\Condition;
use App\Models\Format;
use App\Models\Genre;
use App\Models\Language;
use App\Models\Loan;
use App\Models\Patron;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class LoanController extends Controller
{
    public function index(Request $request)
    {
        $loans = Loan::orderBy('start_time')
            ->get();

        return view('loan.index', compact('loans'));
    }

    public function create()
    {
        $authors = Author::all()->sortBy(function ($entry) {
            return strtolower($entry->surname);
        });
        $genres = Genre::all()->sortBy(function ($entry) {
            return strtolower($entry->name);
        });
        $publishers = Publisher::all()->sortBy(function ($entry) {
            return strtolower($entry->name);
        });
        $catalogue_entries = CatalogueEntry::all()->sortBy(function ($entry) {
            return strtolower($entry->title);
        });
        $patrons = Patron::all()->sortBy(function ($entry) {
            return strtolower($entry->surname);
        });
        $conditions = Condition::all(); // Fetch all genres
        $languages = Language::all();
        $formats = Format::all();
        return view('loan.create', compact('authors', 'genres', 'publishers', 'catalogue_entries', 'conditions', 'languages', 'formats', 'patrons'));
    }


    public function show($id)
    {
        return Genre::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'patron' => 'required'
        ]);

        // Create book
        $loan = new Loan();
        $loan->book_copy_id = $request->input('title');
        $loan->patron_id = $request->input('patron');
        $loan->is_returned = 0;

        $loan->start_time = now();
        $loan->end_time = now()->addMonth();

        $user = Auth::user();

        $loan->staff_id = $user->staff->id;

        $loan->save();

        return redirect('/book')->with('flashMessage', 'Book added successfully!');
    }

    public function edit($id)
    {
        $book = Book_Copy::find($id);

        $test = Book_Copy::
        select(['*', 'book_copy.id as book_id', 'genre.name as genre', 'publisher.name as publisher'])
            ->join('publisher', 'publisher.id', '=', 'book_copy.publisher_id')
            ->join('catalogue_entry', 'catalogue_entry.id', '=', 'book_copy.catalogue_entry_id')
            ->join('genre', 'genre.id', '=', 'catalogue_entry.genre_id')
            ->join('author_catalogue_entry', 'author_catalogue_entry.catalogue_entry_id', '=', 'catalogue_entry.id')
            ->join('author', 'author.id', '=', 'author_catalogue_entry.author_id')
            ->where('book_copy.id', '=', $id)->get();

        $authors = Author::all();
        $genres = Genre::all(); // Fetch all genres
        $publishers = Publisher::all(); // Fetch all genres

        return view('book.edit', compact('book', 'test', 'authors', 'genres', 'publishers'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required'
        ]);

        $update =

        $book = Book_Copy::find($request->input('id'));
        $book->publisher_id = $request->input('publisher');
        $book->save();

        return redirect('/genre')->with('success', 'Genre updated');
    }

    public function destroy(Request $request, $id)
    {
        $book = Book_Copy::find($id);
        $book->delete();

        return redirect('/book')->with('flashMessage', 'Book deleted successfully!');

    }

    public function archive(Request $request, $id)
    {
        $book = Book_Copy::find($id);

        $book->archived = 1;
        $book->save();

        return redirect('/book')->with('flashMessage', 'Book archived successfully!');
    }

    public function archived(Request $request)
    {
        $books = Book_copy::orderBy('year_published')
            ->select(['*', 'book_copy.id as book_id', 'genre.name as genre', 'publisher.name as publisher'])
            ->join('publisher', 'publisher.id', '=', 'book_copy.publisher_id')
            ->join('catalogue_entry', 'catalogue_entry.id', '=', 'book_copy.catalogue_entry_id')
            ->join('genre', 'genre.id', '=', 'catalogue_entry.genre_id')
            ->join('author_catalogue_entry', 'author_catalogue_entry.catalogue_entry_id', '=', 'catalogue_entry.id')
            ->join('author', 'author.id', '=', 'author_catalogue_entry.author_id')
            ->where('archived', '=', '1')->get();

        return view('book.archived', compact('books'));
    }

    public function unarchive(Request $request, $id)
    {
        $book = Book_Copy::find($id);

        $book->archived = 0;
        $book->save();

        return redirect('/book')->with('flashMessage', 'Book unarchived successfully!');
    }
}
