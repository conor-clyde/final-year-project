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
        // Validation error messages
        $customMessages = [
            'genre' => 'Please select the book\'s genre.',
            'title.required_without' => 'Please select the book\'s title or enter a new book title.',
            'new_title.max' => 'The book\'s title must not exceed 255 characters',
            'description.max' => 'The book\'s description must not exceed 1500 characters',
            'publisher.required_without' => 'Please select the book\'s publisher or enter a new publisher.',
            'new_publisher.max' => 'The publisher\'s name must not exceed 255 characters',
            'author_surname.*' => 'Please select the :attribute or enter their surname and forename.',
            'author_surname.*.max' => 'The :attribute\'s surname must not exceed 255 characters.',
            'author_forename.*.max' => 'The :attribute\'s forename must not exceed 255 characters.'
        ];

        // Validation of user input
        $validator = Validator::make($request->all(), [
            'genre' => [
                'required_with:new_title'
            ],
            'title' => [
                'required_without:new_title'
            ],
            'new_title' => [
                'max:255'
            ],
            'publisher' => [
                'required_without:new_publisher',
            ],
            'new_publisher' => [
                'max:255',
            ],
            'description' => [
                'max:1500',
            ],
            'author_surname.*' => ['max:255', function ($attribute, $value, $fail) use ($request) {
                if ($request->filled('new_title') && !$request->filled('author')) {
                    $authorIndex = (int)substr($attribute, strrpos($attribute, '.') + 1);
                    $forename = $request->input("author_forename.$authorIndex");
                    if (!$value && !$forename) {
                        $fail("The $attribute field is required when there is a new title but no author.");
                    }
                }
            }],
            'author_forename.*' => [
                'max:255',
            ],
        ],
            $customMessages
        );

        $validator->setAttributeNames([
            'author_surname.0' => 'first author',
            'author_surname.1' => 'second author',
            'author_surname.2' => 'third author',
            'author_forename.0' => 'first author',
            'author_forename.1' => 'second author',
            'author_forename.2' => 'third author',
        ]);


        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if the new title already exists with the same authors
        if ($request->filled('new_title')) {
            $existingTitle = CatalogueEntry::where('title', $request->input('new_title'))->first();
            if ($existingTitle) {
                // Get the IDs of authors associated with the existing title
                $existingAuthors = $existingTitle->authors->pluck('id')->toArray();
                // Get the IDs of authors submitted with the new title
                $selectedAuthors = $request->input('author');
                // Check if any selected author is already associated with the existing title
                foreach ($selectedAuthors as $authorId) {
                    if (in_array($authorId, $existingAuthors)) {
                        return redirect()->back()->withInput()->withErrors(['author' => 'One or more selected author(s) already exist for the provided title.']);
                    }
                }
            }
        }





        // Check if the new authors already exist
        $authorSurnames = $request->input('author_surname');
        $authorForenames = $request->input('author_forename');
        $existingCombinations = [];

        foreach ($authorSurnames as $index => $surname) {
            if (!empty($surname) && !empty($authorForenames[$index])) {
                $combination = $surname . '|' . $authorForenames[$index];

                if (in_array($combination, $existingCombinations)) {
                    return redirect()->back()->withInput()->withErrors(['author_surname' => 'Duplicate author entries are not allowed.']);
                }

                $existingCombinations[] = $combination;

                $existingAuthor = Author::where('surname', $surname)
                    ->where('forename', $authorForenames[$index])
                    ->first();

                if ($existingAuthor) {
                    return redirect()->back()->withInput()->withErrors(['author_surname' => 'An author with the same surname and forename already exists.']);
                }
            }
        }



        // Check if any of the selected authors are the same
        if ($request->filled('author')) {
            $selectedAuthors = $request->input('author');

            // Convert to array to ensure unique values
            $uniqueAuthors = array_unique($selectedAuthors);

            // If the count of unique authors is less than the count of selected authors,
            // it means there are duplicate authors
            if (count($uniqueAuthors) < count($selectedAuthors)) {
                return redirect()->back()->withInput()->withErrors(['author' => 'You cannot select the same author multiple times.']);
            }
        }




        // Check if the new title already exists
        if ($request->filled('new_title')) {
            $existingTitle = CatalogueEntry::where('title', $request->input('new_title'))->first();


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

            // Loop through 1-3 authors
            $test = 0;
            for ($i = 0; $i < 3; $i++) {

                // Check if new author details are provided
                if ($request->filled("author_surname.$i") && $request->filled("author_forename.$i")
                    && !is_null($request->input("author_surname.$i")) && !is_null($request->input("author_forename.$i"))) {
                    // Create a new author
                    $author = new Author();
                    $author->surname = $request->input("author_surname.$i");
                    $author->forename = $request->input("author_forename.$i");
                    $author->save();

                    // Create a new entry linking the author to the catalogue entry
                    $authorCatalogueEntry = new Author_CatalogueEntry();
                    $authorCatalogueEntry->author_id = $author->id;
                    $authorCatalogueEntry->catalogue_entry_id = $catalogueEntry->id;
                    $authorCatalogueEntry->save();

                } elseif ($request->filled("author.$test")) {

                    // If existing author is selected
                    $authorCatalogueEntry = new Author_CatalogueEntry();
                    $authorCatalogueEntry->author_id = $request->input("author.$test");
                    $authorCatalogueEntry->catalogue_entry_id = $catalogueEntry->id;
                    $authorCatalogueEntry->save();
                    $test++;
                }


            }


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

    public function conor($catalogueEntryId, $authorId)
    {
        dd('hi');
        // Count the number of authors associated with the same book
        $authorCount = Author_CatalogueEntry::where('catalogue_entry_id', $catalogueEntryId)
            ->count();

        // If there's only one author associated with the book, don't delete
        if ($authorCount <= 1) {
            return back()->with('flashMessage', 'Cannot remove the last author for this book!');
        }

        // Otherwise, delete the author from the Author_CatalogueEntry table
        Author_CatalogueEntry::where('author_id', $authorId)
            ->where('catalogue_entry_id', $catalogueEntryId)
            ->delete();

        return back()->with('flashMessage', 'Author removed successfully!');
    }

    public function deleteAuthorCatalogEntry($authorId, $catalogueEntryId)
    {
        // Find the author catalogue entry by authorId and catalogueEntryId
        $authorCatalogueEntry = AuthorCatalogueEntry::where('author_id', $authorId)
            ->where('catalogue_entry_id', $catalogueEntryId)
            ->first();

        if ($authorCatalogueEntry) {
            // Delete the author catalogue entry
            $authorCatalogueEntry->delete();

            // Optionally, you may return a response indicating success
            return response()->json(['message' => 'Author catalogue entry deleted successfully'], 200);
        } else {
            // If the author catalogue entry is not found, return a 404 Not Found response
            return response()->json(['error' => 'Author catalogue entry not found'], 404);
        }
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

        $book->pages = $request->input('pages');

        $book->save();





        return redirect()->route('book')->with('flashMessage', 'Book updated successfully!');
    }

    public function titleUpdate(Request $request, $id)
    {
        $customMessages = [
            'title.max' => 'The book\'s title must not exceed 255 characters',
            'description.max' => 'The book\'s description must not exceed 1500 characters',
            'author.*.surname.max' => 'The surname of the author with the ID :position must not exceed 255 characters',
            'author.*.forename.max' => 'The forename of the author with the ID :position must not exceed 255 characters',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'max:255',
            'description' => 'max:1500',
            'author.*.surname' => 'max:255',
            'author.*.forename' => 'max:255',
        ],
            $customMessages);

        $validator->setAttributeNames([
        ]);


        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $title = CatalogueEntry::find($id);

        $title->title = $request->input('title');

        $title->description = $request->input('description');

        $title->genre_id = $request->input('genre');

//        // Update author names
//        $authorsData = $request->input('author');
//
//        foreach ($authorsData as $authorId => $authorInfo) {
//            $author = Author::find($authorId);
//            if ($author) {
//                $author->surname = $authorInfo['surname'];
//                $author->forename = $authorInfo['forename'];
//                $author->save();
//            }
//        }


        $title->authors()->sync($request->input('author_ids'));



        $title->save();

        return redirect()->route('book')->with('flashMessage', 'Title updated successfully!');
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



