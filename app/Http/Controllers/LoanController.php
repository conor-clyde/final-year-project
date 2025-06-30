<?php

namespace App\Http\Controllers;

use App\Models\Author;
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
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    /**
     * Display a listing of loans.
     */
    public function index()
    {
        $loans = Loan::orderBy('loan_date')->get();
        return view('loan.index', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        $authors = Author::all()->sortBy(fn($entry) => strtolower($entry->surname));
        $genres = Genre::all()->sortBy(fn($entry) => strtolower($entry->name));
        $publishers = Publisher::all()->sortBy(fn($entry) => strtolower($entry->name));
        $catalogue_entries = CatalogueEntry::all()->sortBy(fn($entry) => strtolower($entry->title));
        $books = BookCopy::all()->where('archived', '==', null)->where('deleted_at', '==', null);
        $booksByTitle = $books->groupBy('catalogue_entry.title');
        $patrons = Patron::all()->sortBy(fn($entry) => strtolower($entry->surname));
        $conditions = Condition::all();
        $languages = Language::all();
        $formats = Format::all();
        return view('loan.create', compact('booksByTitle', 'authors', 'books', 'genres', 'publishers', 'catalogue_entries', 'conditions', 'languages', 'formats', 'patrons'));
    }

    /**
     * Show a specific genre (likely a placeholder).
     */
    public function show(int $id)
    {
        return Genre::find($id);
    }

    /**
     * AJAX: Get books by title (for search/autocomplete).
     */
    public function conortest(string $id)
    {
        if ($id == '') {
            $books = BookCopy::with(['catalogueEntry', 'catalogueEntry.authors', 'condition', 'format', 'publisher'])
                ->where('archived', 0)->where('deleted_at', null)
                ->get();
            return response()->json(['books' => $books], 200);
        }
        $books = BookCopy::with(['catalogueEntry', 'catalogueEntry.authors', 'condition', 'format', 'publisher'])
            ->where('archived', 0)->where('deleted_at', null)
            ->whereHas('catalogueEntry', function ($query) use ($id) {
                $query->where('title', 'like', "%$id%");
            })
            ->whereDoesntHave('loans', function ($query) {
                $query->where('is_returned', 0);
            })
            ->get();
        return response()->json(['books' => $books], 200);
    }

    /**
     * AJAX: Get all available books.
     */
    public function conortest2(string $id)
    {
        $books = BookCopy::with(['catalogueEntry', 'catalogueEntry.authors', 'condition', 'format', 'publisher'])
            ->where('archived', 0)->where('deleted_at', null)
            ->whereDoesntHave('loans', function ($query) {
                $query->where('is_returned', 0);
            })
            ->get();
        return response()->json(['books' => $books], 200);
    }

    /**
     * AJAX: Check if a loan can be deleted.
     */
    public function checkDeletionStatus(int $id)
    {
        $loan = Loan::find($id);
        if ($loan) {
            return response()->json([
                'message' => "Are you sure that you want to remove this loan for {$loan->bookCopy->catalogueEntry->title} for {$loan->patron->id}: {$loan->patron->forename} {$loan->patron->surname} ?",
                'deletable' => true
            ], 200);
        } else {
            return response()->json([
                'message' => "Loan not found or cannot be deleted.",
                'deletable' => false
            ], 200);
        }
    }

    /**
     * AJAX: Get all available books (duplicate of conortest2, consider refactoring).
     */
    public function conortestAll()
    {
        $books = BookCopy::with(['catalogueEntry', 'catalogueEntry.authors', 'condition', 'format', 'publisher'])
            ->where('archived', 0)->where('deleted_at', null)
            ->get();
        return response()->json(['books' => $books], 200);
    }

    /**
     * Store a new loan in the database.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required'],
            'patron' => ['required']
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $loan = new Loan();
        $loan->book_copy_id = $request->input('title');
        $loan->patron_id = $request->input('patron');
        $loan->is_returned = 0;
        $loanDuration = $request->input('loan_duration');
        $loan->loan_date = now();
        $loan->due_date = $loanDuration === '2_weeks' ? now()->addWeeks(2) : now()->addMonth();
        $user = Auth::user();
        $loan->staff_id = $user->staff->id;
        $loan->save();
        return $this->redirectWithSuccess('loan.index', 'Loan added successfully!');
    }

    /**
     * Show the form for editing a loan.
     */
    public function edit(int $id)
    {
        $loan = Loan::findOrFail($id);
        $book = BookCopy::find($id);
        $patrons = Patron::all()->sortBy(fn($entry) => strtolower($entry->surname));
        $books = BookCopy::all()->where('archived', '==', null)->where('deleted_at', '==', null);
        return view('loan.edit', compact('loan', 'book', 'patrons', 'books'));
    }

    /**
     * Update a loan in the database.
     */
    public function update(Request $request, int $id)
    {
        $loan = Loan::findOrFail($id);
        // Add validation and update logic as needed
        // ...
        return $this->redirectWithSuccess('loan.index', 'Loan updated successfully!');
    }

    /**
     * Mark a loan as returned.
     */
    public function return(int $id)
    {
        $loan = Loan::findOrFail($id);
        $loan->is_returned = 1;
        $loan->save();
        return $this->redirectWithSuccess('loan.index', 'Book returned successfully!');
    }

    /**
     * Delete a loan.
     */
    public function destroy(Request $request)
    {
        $loanId = $request->id;
        $loan = Loan::findOrFail($loanId);
        $loan->delete();
        return $this->redirectWithSuccess('loan.index', 'Loan deleted successfully!');
    }

    /**
     * Show a list of soft-deleted loans.
     */
    public function deleted()
    {
        $loans = Loan::onlyTrashed()->get();
        return view('loan.deleted', compact('loans'));
    }

    /**
     * Helper for redirecting with a success message.
     */
    private function redirectWithSuccess($route, $message)
    {
        return redirect()->route($route)->with('success', $message);
    }
}
