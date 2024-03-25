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
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;


class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::orderBy('surname')->orderBy('forename')->where('archived', '=', '0')->get();

        return view('author.index', compact('authors'));
    }

    public function create()
    {
        return view('author.create');
    }

    public function show(Author $author)
    {
        $author->load('catalogueEntries');
        return view('author.show', compact('author'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'surname' => 'required|max:255',
            'forename' => [
                'required',
                'max:255',
                Rule::unique('authors')->where(function ($query) use ($request) {
                    return $query->where('surname', $request->input('surname'));
                }),
            ],
        ], [
            'forename.unique' => 'The given author\'s full name already exists',
        ]);

        $author = new Author;
        $author->surname = $request->input('surname');
        $author->forename = $request->input('forename');

        $author->save();

        return redirect('/author')->with('flashMessage', 'Author added successfully!');
    }

    public function edit($id)
    {
        $author = Author::find($id);

        return view('author.edit')->with('author', $author);


    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'surname' => 'required|max:255',
            'forename' => [
                'required',
                'max:255',
                Rule::unique('authors')->where(function ($query) use ($request) {
                    return $query->where('surname', $request->input('surname'));
                })->ignore($id),
            ],
        ], [
            'forename.unique' => 'The given author\'s full name already exists',
        ]);

        $author = Author::find($id);
        $author->surname = $request->input('surname');
        $author->forename = $request->input('forename');
        $author->save();

        return redirect('/author')->with('flashMessage', 'Author updated successfully!');
    }

    public function destroy(Request $request)
    {
        $authorId = $request->id;
        $author = Author::find($authorId);

        if ($author && $author->archived == 1) {
            $author->archived = 0;
            $author->save();

            $author->delete();

            return redirect()->route('author.archived')->with('flashMessage', 'Author deleted successfully!');
        } else {
            $author->delete();

            return redirect()->route('author')->with('flashMessage', 'Author deleted successfully!');
        }
    }


    public function checkArchiveStatus($id)
    {
        $author = Author::find($id);
        return response()->json(['message' => "Are you sure that you want to archive $author->surname,  $author->forename?", 'deletable' => true], 200);
    }

    // Archive genre
    public function archive($id)
    {
        //dd($id);
        $author = Author::find($id);
        // dd($author);
        $author->archived = 1;
        $author->save();

        return redirect()->route('author')->with('flashMessage', 'Author archived successfully!');
    }

    public function checkDeletionStatus($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found', 'deletable' => false], 404);
        }

        $formAction = url('author/delete');


        $catalogueEntriesCount = $author->catalogueEntries()->count();
        $canBeDeleted = $catalogueEntriesCount === 0;

        if ($canBeDeleted) {
            return response()->json([
                'message' => "Are you sure that you want to delete {$author->surname}, {$author->forename}?",
                'deletable' => true
            ], 200);
        } else {
            return response()->json([
                'message' => "{$author->surname}, {$author->forename} cannot be deleted because books are assigned to this author",
                'deletable' => false,
                'formAction' => $formAction
            ], 200);
        }
    }

    public function archived(Request $request)
    {
        $authors = Author::where('archived', 1)->orderBy('surname')->get();
        return view('author.archived', compact('authors'));
    }

    public function unarchive(Request $request, $id)
    {
        $author = Author::find($id);
        $author->archived = 0;
        $author->save();

        return redirect()->route('author.archived')->with('flashMessage', 'Author unarchived successfully!');
    }

    public function deleted(Request $request)
    {
        $authors = Author::onlyTrashed()->get();
        return view('author.deleted', compact('authors'));
    }

    public function restore(Request $request, $id)
    {
        $author = Author::withTrashed()->find($id);

        if ($author) {
            $author->restore();
            return redirect()->route('author.deleted')->with('flashMessage', 'Author restored successfully!');
        } else {
            return redirect()->route('author.deleted')->with('flashMessage', 'Error: Author not found');
        }
    }

    public function unarchiveAll()
    {
        Author::where('archived', 1)->update(['archived' => 0]);
        return redirect()->route('author.archived')->with('flashMessage', 'All authors unarchived successfully!');
    }

    public function restoreAll()
    {
        Author::onlyTrashed()->restore();
        return redirect()->route('author.deleted')->with('flashMessage', 'All authors restored successfully!');
    }


}



