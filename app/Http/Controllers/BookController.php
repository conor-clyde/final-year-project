<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Author_CatalogueEntry;
use App\Models\BookCopy;
use App\Models\CatalogueEntry;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = BookCopy::orderBy('year_published')
            ->select(['*', 'book_copies.id as book_id', 'genres.name as genre', 'publishers.name as publisher'])
            ->join('publishers', 'publishers.id', '=', 'book_copies.publisher_id')
            ->join('catalogue_entries', 'catalogue_entries.id', '=', 'book_copies.catalogue_entry_id')
            ->join('genres', 'genres.id', '=', 'catalogue_entries.genre_id')
            ->join('author_catalogue_entries', 'author_catalogue_entries.catalogue_entry_id', '=', 'catalogue_entries.id')
            ->join('authors', 'authors.id', '=', 'author_catalogue_entries.author_id')
            ->where('book_copies.archived', '=', '0')->get();

        return view('book.index', compact('books'));
    }

    public function show(BookCopy $book)
    {
        //dd($book);
        $book->load('loans');
        $book->load('catalogueEntry');
        return view('book.show', compact('book'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all(); // Fetch all genres
        $publishers = Publisher::all(); // Fetch all genres
        $catalogue_entries = CatalogueEntry::all(); // Fetch all genres
        return view('book.create', compact('authors', 'genres', 'publishers', 'catalogue_entries'));
    }

    public function deleted(Request $request)
    {
        $books = BookCopy::onlyTrashed()->get();
        return view('book.deleted', compact('books'));
    }



    public function store(Request $request)
    {
        $this->validate($request, [
        ]);

        // Create book
        if( $request->input('catalogue_entry') == null) {

            $catalogue_entry = new CatalogueEntry();

            $catalogue_entry->title = $request->input('new_catalogue_entry');
            $catalogue_entry->genre_id = $request->input('genre');
            $catalogue_entry->save();

            $author_catalogue_entry = new Author_CatalogueEntry();
            $author_catalogue_entry->catalogue_entry_id = $catalogue_entry->id;
            $author_catalogue_entry->author_id = $request->input('author');
            $author_catalogue_entry->save();
        }

        $book_copy = new BookCopy();
        $book_copy->year_published = $request->input('publish_year');
        if( $request->input('catalogue_entry') == null) {

            $book_copy->catalogue_entry_id = $catalogue_entry->id;
        }
        else {
            $book_copy->catalogue_entry_id = $request->input('catalogue_entry');
        }
        $book_copy->publisher_id = $request->input('publisher');
        $book_copy->save();

        return redirect('/book')->with('flashMessage', 'Book added successfully!');
    }

    public function edit($id) {
        $book = BookCopy::find($id);

        $test = BookCopy::
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

    public function update(Request $request, $id) {

        $this->validate($request, [
            'title' => 'required'
        ]);

        $book = BookCopy::find($request->input('id'));
        $book->publisher_id = $request->input('publisher');
        $book->save();

        return redirect('/genre')->with('success', 'Genre updated');
    }

    public function destroy(Request $request, $id)
    {
        $book = BookCopy::find($id);
        $book->delete();

        return redirect('/book')->with('flashMessage', 'Book deleted successfully!');

    }

    public function archive(Request $request, $id)
    {
        $book = BookCopy::find($id);
        $book->archived=1;
        $book->save();

        return redirect('/book')->with('flashMessage', 'Book archived successfully!');
    }


    public function archived(Request $request)
    {
        $books = BookCopy::orderBy('year_published')
            ->select(['*', 'book_copies.id as book_id', 'genres.name as genre', 'publishers.name as publisher'])
            ->join('publishers', 'publishers.id', '=', 'book_copies.publisher_id')
            ->join('catalogue_entries', 'catalogue_entries.id', '=', 'book_copies.catalogue_entry_id')
            ->join('genres', 'genres.id', '=', 'catalogue_entries.genre_id')
            ->join('author_catalogue_entries', 'author_catalogue_entries.catalogue_entry_id', '=', 'catalogue_entries.id')
            ->join('authors', 'authors.id', '=', 'author_catalogue_entries.author_id')
            ->where('book_copies.archived', '=', '1')->get();

        return view('book.archived', compact('books'));
    }

    public function unarchive(Request $request, $id)
    {


        $book = BookCopy::find($id);

        $book->archived=0;
        $book->save();


        return redirect('/book')->with('flashMessage', 'Book unarchived successfully!');

    }





}



