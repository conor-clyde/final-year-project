<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use App\Models\CatalogueEntry;
use Illuminate\Validation\Rule;

class GenreController extends Controller
{
    // Genre.index
    public function index(Request $request)
    {
        $genres = Genre::orderBy('name')->where('archived', 0)->get();
        return view('genre.index', compact('genres'));
    }

    // Show genre details
    public function show(Genre $genre)
    {
        $genre->load('catalogueEntries.authors');
        return view('genre.show', compact('genre'));
    }

    // Create genre
    public function create()
    {
        return view('genre.create');
    }

    // Save new genre
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:genres',
            'description' => 'max:255',
        ]);

        $genre = new Genre([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
        ]);

        $genre->save();

        return redirect()->route('genre')->with('flashMessage', 'Genre added successfully!');
    }

    // Edit genre
    public function edit($id)
    {
        $genre = Genre::find($id);
        //dd($id);
        return view('genre.edit')->with('genre', $genre);
    }

    // Save genre update
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('genres')->ignore($id),
            ],
            'description' => 'max:255',
        ]);

        $genre = Genre::findOrFail($id);
        $genre->fill($validatedData);
        $genre->save();

        return redirect()->route('genre')->with('flashMessage', 'Genre updated successfully!');
    }

    // Create confirm delete message
    public function checkDeletionStatus($id)
    {
        $genre = Genre::find($id);
        $test = CatalogueEntry::where('genre_id', $id)->first();

        $canBeDeleted = !$test;

        if ($canBeDeleted) {
            return response()->json(['message' => "Are you sure that you want to delete {$genre->name}?", 'deletable' => true], 200);
        } else {
            return response()->json(['message' => "{$genre->name} can not be deleted because books are assigned to this genre", 'deletable' => false], 200);
        }
    }

    // Create confirm archive message
    public function checkArchiveStatus($id)
    {
        $genre = Genre::find($id);
        return response()->json(['message' => "Are you sure that you want to archive {$genre->name}?", 'deletable' => true], 200);
    }

    // Archive genre
    public function archive($id)
    {
        $genre = Genre::find($id);
        $genre->archived = 1;
        $genre->save();

        return redirect()->route('genre')->with('flashMessage', 'Genre archived successfully!');
    }

    // Soft delete genre
    public function destroy(Request $request)
    {
        $genreId = $request->id;

        $genre = Genre::find($genreId);

        if ($genre && $genre->archived == 1) {
            $genre->archived = 0;
            $genre->save();

            Genre::findOrFail($genreId)->delete();;
            return redirect()->route('genre.archived')->with('flashMessage', 'Genre deleted successfully!');
        }
        else
        {
        if (CatalogueEntry::where('genre_id', $genreId)->exists())
            return redirect()->route('genre')->with('flashMessage', 'Delete unsuccessful. Books are currently using this genre.');

        Genre::findOrFail($genreId)->delete();;
        return redirect()->route('genre')->with('flashMessage', 'Genre deleted successfully!');
        }
    }



    // View archived genres
    public function archived(Request $request)
    {
        $genres = Genre::where('archived', 1)->orderBy('name')->get();
        return view('genre.archived', compact('genres'));
    }

    // View soft deleted genres
    public function deleted(Request $request)
    {
        $genres = Genre::onlyTrashed()->get();
        return view('genre.deleted', compact('genres'));
    }

    // Reverse archive genre
    public function unarchive(Request $request, $id)
    {
        $genre = Genre::find($id);
        $genre->archived = 0;
        $genre->save();

        return redirect()->route('genre.archived')->with('flashMessage', 'Genre unarchived successfully!');
    }

    // Reverse archive every genre
    public function unarchiveAll()
    {
        Genre::where('archived', 1)->update(['archived' => 0]);
        return redirect()->route('genre.archived')->with('flashMessage', 'All genres unarchived successfully!');
    }

    // Reverse soft delete genre
    public function restore(Request $request, $id)
    {
        $genre = Genre::withTrashed()->find($id);

        if ($genre) {
            $genre->restore();
            return redirect()->route('genre.deleted')->with('flashMessage', 'Genre restored successfully!');
        } else {
            return redirect()->route('genre.deleted')->with('flashMessage', 'Error: Genre not found');
        }
    }

    // Reverse soft delete every genre
    public function restoreAll()
    {
        Genre::onlyTrashed()->restore();
        return redirect()->route('genre.deleted')->with('flashMessage', 'All genres restored successfully!');
    }

    // Hard delete genre
    public function permanentDelete($id)
    {
        $genre = Genre::withTrashed()->find($id);

        if (!$genre) {
            return abort(404);
        }

        $genre->forceDelete();
        return redirect()->route('genre.deleted')->with('flashMessage', 'Genre permanently deleted!');
    }

    // Create bulk archive confirm message
    public function checkBulkArchive(Request $request)
    {
        $selectedGenres = $request->input('selected_genres', []);

        $genreIds = Genre::whereIn('id', $selectedGenres)->pluck('id')->toArray();
        $genres = Genre::whereIn('id', $selectedGenres)->pluck('name')->toArray();

        $genreNames = implode(', ', $genres);
        $lastIndex = strrpos($genreNames, ', ');
        if ($lastIndex !== false) {
            $genreNames = substr_replace($genreNames, ' and ', $lastIndex, 2);
        }

        return response()->json([
            'message' => 'Are you sure you want to archive ' . $genreNames . '?',
            'genre_ids' => $genreIds ]);
    }

    // Create bulk delete confirm message
    public function checkBulkDelete(Request $request)
    {
        $deletable = false;
        $selectedGenres = $request->input('selected_genres', []);

        $genreIds = Genre::whereIn('id', $selectedGenres)->pluck('id')->toArray();
        $genres = Genre::whereIn('id', $selectedGenres)->get();

        $deletableGenres = [];
        $undeletableGenres = [];

        $message = '';

        foreach ($genres as $genre) {
            $test = CatalogueEntry::where('genre_id', $genre->id)->first();
            $canBeDeleted = !$test;

            if ($canBeDeleted) {
                $deletableGenres[] = $genre->name;
            } else {
                $undeletableGenres[] = $genre->name;
            }
        }

        if (!empty($deletableGenres)) {
            $message .= 'Are you sure you want to delete ' . implode(', ', $deletableGenres);
            $deletable=true;
        }

        if (!empty($undeletableGenres)) {
            if ($message !== '') {
                $message .= ' and ';
            }
            $message .= 'Cannot delete ' . implode(', ', $undeletableGenres) . ' as they are associated with some data.';
        }

        return response()->json([
            'message' => $message,
            'genre_ids' => $genreIds,
            'deletable' => $deletable
        ]);
    }

    // Bulk soft delete genres
    public function bulkDelete(Request $request)
    {
        $selectedGenreIds = $request->input('selected_genres', []);

        foreach ($selectedGenreIds as $genreId) {
            $genre = Genre::with('catalogueEntries')->findOrFail($genreId);

            if ($genre->catalogueEntries->count() > 0)
                continue;

            $genre->delete();
        }

        redirect()->route('genre')->with('flashMessage', 'Genre(s) deleted successfully!');
    }

    // Bulk archive genres
    public function bulkArchive(Request $request)
    {
        redirect()->route('genre')->with('flashMessage', 'Genre(s) deleted successfully!');

        $selectedGenres = $request->input('selected_genres', []);
        foreach ($selectedGenres as $selectedGenre) {
            $genre = Genre::find($selectedGenre);
            $genre->archived = 1;
        }

        //return view('genre')->with('flashMessage', 'Genre(s) archived successfully!');
        //Genre::whereIn('id', $selectedGenres)->update(['archived' => 1]);
       return redirect()->route('genre')->with('flashMessage', 'Genre(s) archived successfully!');
    }

}
