<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Author_Catalogue_Entry;
use App\Models\Book_Copy;
use App\Models\Catalogue_Entry;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class LoanController extends Controller
{
    public function index(Request $request)
    {
        $books = Book_copy::orderBy('year_published')
            ->select(['*', 'book_copy.id as book_id', 'genre.name as genre', 'publisher.name as publisher'])
            ->join('publisher', 'publisher.id', '=', 'book_copy.publisher_id')
            ->join('catalogue_entry', 'catalogue_entry.id', '=', 'book_copy.catalogue_entry_id')
            ->join('genre', 'genre.id', '=', 'catalogue_entry.genre_id')
            ->join('author_catalogue_entry', 'author_catalogue_entry.catalogue_entry_id', '=', 'catalogue_entry.id')
            ->join('author', 'author.id', '=', 'author_catalogue_entry.author_id')
            ->where('archived', '=', '0')->get();

        return view('loan.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $genres = Genre::all(); // Fetch all genres
        $publishers = Publisher::all(); // Fetch all genres
        return view('loan.create', compact('authors', 'genres', 'publishers'));
    }


    public function show($id)
    {
        return Genre::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'author' => 'required',
            'genre' => 'required',
            'publisher' => 'required',
            'year' => 'required'
        ]);

        // Create book
        $catalogue_entry = new Catalogue_Entry();
        $catalogue_entry->title = $request->input('title');
        $catalogue_entry->genre_id =  $request->input('genre');
        $catalogue_entry->save();

        $author_catalogue_entry = new Author_Catalogue_Entry();
        $author_catalogue_entry->catalogue_entry_id =  $catalogue_entry->id;
        $author_catalogue_entry->author_id =  $request->input('author');
        $author_catalogue_entry->save();

        $book_copy = new Book_Copy();
        $book_copy->year_published = $request->input('year');
        $book_copy->catalogue_entry_id =  $catalogue_entry->id;
        $book_copy->publisher = $request->input('publisher');
        $book_copy->save();

        return redirect('/book')->with('flashMessage', 'Book added successfully!');
    }

    public function edit($id) {

        $book = Book_Copy::find($id);
        //dd($book);

        $test = Book_Copy::
        select(['*', 'book_copy.id as book_id', 'genre.name as genre', 'publisher.name as publisher'])
            ->join('publisher', 'publisher.id', '=', 'book_copy.publisher_id')
            ->join('catalogue_entry', 'catalogue_entry.id', '=', 'book_copy.catalogue_entry_id')
            ->join('genre', 'genre.id', '=', 'catalogue_entry.genre_id')
            ->join('author_catalogue_entry', 'author_catalogue_entry.catalogue_entry_id', '=', 'catalogue_entry.id')
            ->join('author', 'author.id', '=', 'author_catalogue_entry.author_id')
            ->where('book_copy.id', '=', $id)->get();

        //dd( $test );



        $authors = Author::all();
        $genres = Genre::all(); // Fetch all genres
        $publishers = Publisher::all(); // Fetch all genres

        return view('book.edit', compact('book', 'test', 'authors', 'genres', 'publishers'));
    }

    public function update(Request $request, $id) {

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

        $book->archived=1;
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
            ->where('archived', '=', '1')->get()

        ;

        return view('book.archived', compact('books'));


    }

    public function unarchive(Request $request, $id)
    {


        $book = Book_Copy::find($id);

        $book->archived=0;
        $book->save();


        return redirect('/book')->with('flashMessage', 'Book unarchived successfully!');

    }





}



