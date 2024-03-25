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
use App\Models\Publisher;
use App\Rules\GenreRequiredIfNewTitleProvided;
use Database\Seeders\ConditionSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = BookCopy::orderBy('publish_date')
            ->where('book_copies.archived', '=', '0')->get();

        return view('book.index', compact('books'));
    }

    public function show($id)
    {
        $book = BookCopy::withTrashed()->find($id);
        $book->load('loans');
        $book->load('catalogueEntry');
        $book->load('catalogueEntry.genre');

        return view('book.show', compact('book'));
    }

    public function create()
    {
        $authors = Author::all()->where('archived', '=', '0')->sortBy(function ($entry) {
            return strtolower($entry->surname);
        });
        $genres = Genre::all()->where('archived', '=', '0')->sortBy(function ($entry) {
            return strtolower($entry->name);
        });
        $publishers = Publisher::all()->where('archived', '=', '0')->sortBy(function ($entry) {
            return strtolower($entry->name);
        });
        $catalogue_entries = CatalogueEntry::all()->sortBy(function ($entry) {
            return strtolower($entry->title);
        });
        $conditions = Condition::all(); // Fetch all genres
        $languages = Language::all();
        $formats = Format::all();
        return view('book.create', compact('authors', 'genres', 'publishers', 'catalogue_entries', 'conditions', 'languages', 'formats'));
    }

    public function deleted(Request $request)
    {
        $books = BookCopy::onlyTrashed()->get();
        return view('book.deleted', compact('books'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_genre' =>
                function ($attribute, $value, $fail) use ($request) {

                    $newTitleProvided = $request->filled('new_title');
                    $newGenreProvided = $request->filled('new_genre');
                    $genreProvided = $request->filled('genre');

                    if ($newTitleProvided && !$newGenreProvided && !$genreProvided) {
                        $fail('Please provide the book\'s genre');
                    }
                },
            'new_author_surname' =>
                function ($attribute, $value, $fail) use ($request) {

                    $newTitleProvided = $request->filled('new_title');
                    $newSurnameProvided = $request->filled('new_author_surname');
                    $newForenameProvided = $request->filled('new_author_forename');
                    $authorProvided = $request->filled('author');

                    if ($newTitleProvided && !($newSurnameProvided && $newForenameProvided) && !$authorProvided) {
                        $fail('Please provide the book\'s author');
                    }
                },
            'condition' => [
                'required'
            ],
            'language' => [
                'required'
            ],
            'format' => [
                'required'
            ],
            'title' => [
                'required_without:new_title'
            ],
            'new_title', 'max:255',
            'publisher' => [
                'required_without:new_publisher'
            ],
            'new_publisher', 'max:255',
            'new_author_surname', 'max:255',
            'new_author_forename', 'max:255',
            'new_genre', 'max:255',
            'description', 'max:1500',
            'isbn', 'max:20',
            'pages', 'integer'
        ], [
            'title.required_without' => 'Please select a title or enter a new title.',
            'publisher.required_without' => 'Please select a publisher or enter a new publisher.',
        ]);
        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


//        // Check if the book with the same title, publisher, and publish date already exists
//        $existingBook = BookCopy::whereHas('catalogueEntry', function ($query) use ($request) {
//            $query->where('title', $request->input('title'))
//                ->where('publisher_id', $request->input('new_publisher'))
//                ->where('publish_date', $this->getPublishDate($request));
//        })->first();
//
//        if ($existingBook) {
//            return redirect()->back()->withInput()->withErrors(['new_title' => 'Book with the same title, publisher, and publish date already exists.']);
//        }

        //START HERE

        // check if new title already exists

        // Check if the new title already exists
        if ($request->filled('new_title')) {
            $existingTitle = CatalogueEntry::where('title', $request->input('new_title'))->first();

            if ($existingTitle) {


                return redirect()->back()->withInput()->withErrors(['new_title' => 'The title already exists. Please choose a different title.']);
            }
        }

        if ($request->filled('new_author_surname') && $request->filled('new_author_forename')) {
            $existingAuthor = Author::where('surname', $request->input('new_author_surname'))
                ->where('forename', $request->input('new_author_forename'))->first();

            if ($existingAuthor) {
                return redirect()->back()->withInput()->withErrors(['new_author_surname' => 'The Author already exists. Please choose a different Author.']);
            }
        }

        if ($request->filled('new_genre')) {
            $existingGenre = Genre::where('genre', $request->input('new_genre'))->first();

            if ($existingGenre) {


                return redirect()->back()->withInput()->withErrors(['new_genre' => 'The given Genre already exists. Please select it from the genre list']);
            }
        }

        if ($request->filled('new_publisher')) {
            $existingPublisher = Publisher::where('name', $request->input('new_publisher'))->first();

            if ($existingPublisher) {


                return redirect()->back()->withInput()->withErrors(['new_publisher' => 'The given Publisher already exists. Please select it from the Publisher list']);
            }
        }


        // $book = BookCopy::find($id);

        // Create a new book copy
        $book_copy = new BookCopy();

        // Set Condition
        $book_copy->condition_id = $request->input('condition');

        // Set Publisher
        if ($request->filled('new_publisher')) {
            $publisher = new Publisher();
            $publisher->name = $request->input('new_publisher');
            $publisher->save();

            $book_copy->publisher_id = $publisher->id;
        } else
            $book_copy->publisher_id = $request->input('publisher');

        // Set Publish Date
        $book_copy->publish_date = $this->getPublishDate($request);

        // Set Language
        $book_copy->language_id = $request->input('language');

        // Set Format
        $book_copy->format_id = $request->input('format');

        // Optional - Set ISBN
        if ($request->filled('isbn'))
            $book_copy->isbn = $request->input('isbn');

        // Optional - Set Pages
        if ($request->filled('pages'))
            $book_copy->pages = $request->input('pages');

        // If new title
        if ($request->filled('new_title')) {
            if (!isset($catalogueEntry))
                $catalogueEntry = new CatalogueEntry();

            $catalogueEntry->title = $request->input('new_title');

            // Set Genre
            if ($request->filled('new_genre')) {
                $genre = new Genre();
                $genre->name = $request->input('new_genre');
                $genre->save();

                $catalogueEntry->genre_id = $genre->id;
            } else
                $catalogueEntry->genre_id = $request->input('genre');

            // set Description
            if ($request->filled('description'))
                $catalogueEntry->description = $request->input('description');

            // Save new title and set catalogue id
            $catalogueEntry->save();
            $book_copy->catalogue_entry_id = $catalogueEntry->id;

            // Set Author
            $authorCatalogueEntry = new Author_CatalogueEntry();

            if ($request->filled('new_author_surname') && $request->filled('new_author_forename')) {
                $author = new Author();
                $author->surname = $request->input('new_author_surname');
                $author->forename = $request->input('new_author_forename');
                $author->save();

                $authorCatalogueEntry->author_id = $author->id;
            } else
                $authorCatalogueEntry->author_id = $request->input('author');

            $authorCatalogueEntry->catalogue_entry_id = $catalogueEntry->id;

            $authorCatalogueEntry->save();
        } else
            $book_copy->catalogue_entry_id = $request->input('title');

        // Save book
        $book_copy->save();

        // Redirect with a success message
        return redirect('/book')->with('flashMessage', 'Book added successfully!');
    }

    private function getPublishDate($request)
    {
        $day = $request->input('publish_day');
        $month = $request->input('publish_month');
        $year = $request->input('publish_year');

        // Use sprintf to format with leading zeros
        $formattedDate = sprintf("%04d-%02d-%02d", $year, $month, $day);

        return $formattedDate;
    }


    public function edit($id)
    {
        $book = BookCopy::find($id);
        //dd( $book);

        $authors = Author::all()->sortBy(function ($entry) {
            return strtolower($entry->surname);
        });
        $genres = Genre::all()->sortBy(function ($entry) {
            return strtolower($entry->name);
        });
        //dd($genres);
        $publishers = Publisher::all()->sortBy(function ($entry) {
            return strtolower($entry->name);
        });
        $catalogue_entries = CatalogueEntry::all()->sortBy(function ($entry) {
            return strtolower($entry->title);
        });

        $conditions = Condition::all();
        $languages = Language::all();
        $formats = Format::all();

        //dd(date('m', strtotime($book->publish_date)));

        return view('book.edit', compact('book', 'authors', 'genres', 'publishers', 'catalogue_entries', 'conditions', 'languages', 'formats'));
    }

    public function getDetails($book)
    {
        $bookDetails = BookCopy::where('title', $book)->first();


        return response()->json($bookDetails);
    }

    public function update(Request $request, $id)
    {
       // dd($request);


        $book = BookCopy::find($id);
        $book->format_id = $request->input('format');
        $book->language_id = $request->input('language');
        $book->condition_id = $request->input('condition');
        $book->publisher_id = $request->input('publisher');

        $book->publish_date = $this->getPublishDate($request);

        $book->isbn = $request->input('isbn');
        $book->pages = $request->input('pages');



        $book->save();

        return redirect()->route('book')->with('flashMessage', 'Book updated successfully!');
    }

    public function permanentDelete($id)
    {
        $book = BookCopy::withTrashed()->find($id);

        if (!$book) {
            return abort(404);
        }

        $book->forceDelete();
        return redirect()->route('book.deleted')->with('flashMessage', 'Book permanently deleted!');
    }


    public function destroy(Request $request)
    {
        $bookId = $request->id;
        $book = BookCopy::find($bookId);

        if ($book && $book->archived == 1) {
            $book->archived = 0;
            $book->save();

            $book->delete();

            return redirect()->route('book.archived')->with('flashMessage', 'Book deleted successfully!');
        } else {

            $book->delete();

            return redirect()->route('book')->with('flashMessage', 'Book deleted successfully!');
        }

    }

    public function archive(Request $request, $id)
    {
        $book = BookCopy::find($id);
        $book->archived = 1;
        $book->save();

        return redirect('/book')->with('flashMessage', 'Book archived successfully!');
    }


    public function archived(Request $request)
    {
        $books = BookCopy::orderBy('publish_date')
            ->where('book_copies.archived', '=', '1')->get();

        return view('book.archived', compact('books'));
    }

    public function unarchive(Request $request, $id)
    {
        $book = BookCopy::find($id);

        $book->archived = 0;
        $book->save();

        return redirect()->route('book.archived')->with('flashMessage', 'Book unarchived successfully!');
    }

    // Create confirm archive message
    public function checkArchiveStatus($id)
    {

        $book = BookCopy::find($id);
        return response()->json(['message' => "Are you sure that you want to archive {$book->catalogueEntry->title}?", 'deletable' => true], 200);
    }

    public function checkDeleteStatus($id)
    {
        $book = BookCopy::find($id);
        $test = Loan::where('book_copy_id', $id)->first();

        $canBeDeleted = !$test;

        if ($canBeDeleted) {
            return response()->json(['message' => "Are you sure that you want to delete {$book->catalogueEntry->title}?", 'deletable' => true], 200);
        } else {
            return response()->json(['message' => "{$book->catalogueEntry->title} can not be deleted because loans are assigned to this book", 'deletable' => false], 200);
        }
    }

    public function restore(Request $request, $id)
    {
        $book = BookCopy::withTrashed()->find($id);

        if ($book) {
            $book->restore();
            return redirect()->route('book.deleted')->with('flashMessage', 'Book restored successfully!');
        } else {
            return redirect()->route('book.deleted')->with('flashMessage', 'Error: Book not found');
        }
    }

    // Reverse archive every genre
    public function unarchiveAll()
    {
        BookCopy::where('archived', 1)->update(['archived' => 0]);
        return redirect()->route('book.archived')->with('flashMessage', 'All books unarchived successfully!');
    }

    public function restoreAll()
    {
        BookCopy::onlyTrashed()->restore();
        return redirect()->route('book.deleted')->with('flashMessage', 'All books restored successfully!');
    }


}



