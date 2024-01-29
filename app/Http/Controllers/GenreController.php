<?php

namespace App\Http\Controllers;

use App\Models\Book_Copy;
use App\Models\Catalogue_Entry;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;


class GenreController extends Controller
{
    public function index(Request $request)
    {
        $genres = Genre::orderBy('name')->where('archived', '=', '0')->get();

        return view('genre.index', compact('genres'));



    }

    // In your GenreController.php

    public function bulkDelete(Request $request)
    {
        // Retrieve the selected genre IDs
        $selectedGenreIds = $request->input('selected_genres', []);




        // Perform the bulk action (e.g., delete genres)
        foreach ($selectedGenreIds as $genreId) {
            $genre = Genre::find($genreId);

            // Check if the genre has associated books
            if ($genre->catalogueEntries()->count() > 0) {
                return redirect()->back()->with('flashMessage', 'Cannot delete genre. Associated books found.');
            }

            if ($genre) {
                $genre->delete();
            }
        }

        // Redirect back with a success message
        return redirect()->back()->with('flashMessage', 'genres deleted successfully!');
    }




    public function bulkArchive(Request $request)
    {
        $selectedGenres = $request->input('selected_genres');

        // Check if there are selected genres
        if (!empty($selectedGenres)) {
            try {
                // Update the status column to mark genres as archived
                Genre::whereIn('id', $selectedGenres)->update(['archived' => '1']);

                return response()->json(['success' => true, 'message' => 'Genres archived successfully']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Error archiving genres']);
            }
        }

        return response()->json(['success' => false, 'message' => 'No genres selected for archiving']);
    }




    public function create()
    {
        return view('genre.create');
    }

    public function show(Genre $genre)
    {
        // Load associated catalogue entries and any other relevant details
        $genre->load('catalogueEntries');

        // Pass the genre and its associated data to the view
        return view('genre.show', compact('genre'));
    }



    public function store(Request $request)
    {




        $this->validate($request, [
            'name' => 'required|max:255|unique:genre'



        ]);

        // Create genre
        $genre = new Genre;
        $genre->name = $request->input('name');
        $genre->save();

        return redirect('/genre')->with('flashMessage', 'Genre added successfully!');
    }

    public function edit($id) {
        $genre = Genre::find($id);

        return view('genre.edit')->with('genre', $genre);



    }

    public function update(Request $request, $id) {

        $this->validate($request, [
            'name' => 'required|max:255',
            Rule::unique('genres')->ignore($request->id)
        ]);

        $genre = Genre::find($request->input('id'));
        $genre->name = $request->input('name');
        $genre->save();

        return redirect('/genre')->with('flashMessage', 'Genre updated successfully!');
    }

    public function destroy(Request $request)
    {
        $test = \App\Models\Catalogue_Entry::where('genre_id', '=', $request->genre_id)->first();

        if($test!=null)
        {
            return redirect('/genre')->with('flashMessage', 'Delete unsuccessful. Books are currently set to this genre.');
        }



        //$genre = Genre::find($id);
        $genre = Genre::find($request->genre_id);
        //dd( $genre );
        $genre->delete();

        return redirect('/genre')->with('flashMessage', 'Genre deleted successfully!');
    }

    public function permanentDelete(Request $request, $id)
    {
        $genre = Genre::withTrashed()->find($id);

        // Permanently delete the genre
        $genre->forceDelete();

        return redirect('/genre/deleted')->with('flashMessage', 'Genre permanently deleted!');

    }





    public function check(Request $request)
    {

        $test = \App\Models\Catalogue_Entry::where('genre_id', '=', $request->category_delete_id)->first();

        if($test!=null)
        {
            return true;
        }

        return false;


    }

    public function checkDeletionStatus($id)
    {
        $genre = Genre::find($id);


        // Your logic to check if the category can be deleted
        $test = \App\Models\Catalogue_Entry::where('genre_id', '=', $id)->first();

        if($test==null)
        {
            $canBeDeleted = true;
        }
        else {
            $canBeDeleted = false;
        }

        if ($canBeDeleted) {
            return response()->json(['message' => 'Are you sure that you want to delete ' .  $genre->name . "?", 'deletable' => true], 200);
        } else {
            return response()->json(['message' => $genre->name . ' can not be deleted because books are assigned to this genre', 'deletable' => false], 200);
        }
    }

    public function archive(Request $request, $id)
    {


        $genre = Genre::find($id);

        $genre->archived=1;
        $genre->save();


        return redirect('/genre')->with('flashMessage', 'Genre archived successfully!');

    }

    public function archived(Request $request)
    {

        $genres = Genre::orderBy('name')
            ->where('archived', '=', '1')->get();

        return view('genre.archived', compact('genres'));


    }

    public function deleted(Request $request)
    {

        $genres = Genre::onlyTrashed()->get();



        return view('genre.deleted', compact('genres'));


    }

    public function restore(Request $request, $id)
    {
        $genre = Genre::withTrashed()->find($id);

        if ($genre) {
            $genre->restore();
            return redirect('genre/deleted')->with('flashMessage', 'Genre restored successfully!');
        } else {
            return redirect('genre/deleted')->with('flashMessage', 'Error: Genre not found');
        }

    }

    public function unarchive(Request $request, $id)
    {
        $genre = Genre::find($id);

        $genre->archived=0;
        $genre->save();

        return redirect('genre/archived')->with('flashMessage', 'Genre unarchived successfully!');
    }
}
