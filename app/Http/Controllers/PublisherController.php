<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\BookCopy;
use App\Models\CatalogueEntry;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $publishers = Publisher::orderBy('name')->where('archived', 0)->get();

        return view('publisher.index', compact('publishers'));


    }

    public function unarchiveAll()
    {
        Publisher::where('archived', 1)->update(['archived' => 0]);
        return redirect()->route('publisher.archived')->with('flashMessage', 'All publisher unarchived successfully!');
    }

    public function unarchive(Request $request, $id)
    {
        $publisher = Publisher::find($id);
        $publisher->archived = 0;
        $publisher->save();

        return redirect()->route('publisher.archived')->with('flashMessage', 'Publisher unarchived successfully!');
    }

    public function create()
    {
        return view('publisher.create');
    }

    public function show(Publisher $publisher)
    {
        $publisher->load('bookCopies.catalogueEntry.authors');
        return view('publisher.show', compact('publisher'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'publisher' => 'required|max:255'
        ]);

        // Create publisher
        $publisher = new Publisher;
        $publisher->name = $request->input('publisher');
        $publisher->save();

        return redirect('/publisher')->with('flashMessage', 'Publisher added successfully!');
    }

    public function edit($id) {
        $publisher = Publisher::find($id);

        return view('publisher.edit')->with('publisher', $publisher);
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'publisher' => 'required|max:255'
        ]);

        $publisher = Publisher::find($id);
        $publisher->name = $request->input('publisher');
        $publisher->save();

        return redirect('/publisher')->with('flashMessage', 'Publisher updated successfully!');
    }

    public function destroy(Request $request)
    {

        $publisherId = $request->id;

        $publisher = Publisher::find($publisherId);

        if ($publisher && $publisher->archived == 1) {
            $publisher->archived = 0;
            $publisher->save();

            Publisher::findOrFail($publisherId)->delete();;

            return redirect()->route('publisher.archived')->with('flashMessage', 'Publisher deleted successfully!');
        } else {
            if (BookCopy::where('publisher_id', $publisherId)->exists())
                return redirect()->route('publisher')->with('flashMessage', 'Delete unsuccessful. Books are currently using this publisher.');

            Publisher::findOrFail($publisherId)->delete();;
            return redirect()->route('publisher')->with('flashMessage', 'Publisher deleted successfully!');
        }

    }

    // Reverse soft delete genre
    public function restore(Request $request, $id)
    {
        $publisher = Publisher::withTrashed()->find($id);

        if ($publisher) {
            $publisher->restore();
            return redirect()->route('publisher.deleted')->with('flashMessage', 'Publisher restored successfully!');
        } else {
            return redirect()->route('publisher.deleted')->with('flashMessage', 'Error: Publisher not found');
        }
    }

    // View archived genres
    public function archived(Request $request)
    {
        $publishers = Publisher::where('archived', 1)->orderBy('name')->get();
        return view('publisher.archived', compact('publishers'));
    }

    // View soft deleted genres
    public function deleted(Request $request)
    {
        $publishers = Publisher::onlyTrashed()->get();
        return view('publisher.deleted', compact('publishers'));
    }

    public function archive($id)
    {
        $publisher = Publisher::find($id);
        $publisher->archived = 1;
        $publisher->save();

        return redirect()->route('publisher')->with('flashMessage', 'Publisher archived successfully!');
    }

    public function checkDeletionStatus($id)
    {
        $publisher = Publisher::find($id);
        $test = BookCopy::where('publisher_id', $id)->first();

        $canBeDeleted = !$test;

        if ($canBeDeleted) {
            return response()->json(['message' => "Are you sure that you want to delete {$publisher->name}?", 'deletable' => true], 200);
        } else {
            return response()->json(['message' => "{$publisher->name} can not be deleted because books are published by this publisher", 'deletable' => false], 200);
        }
    }

    public function restoreAll()
    {
        Publisher::onlyTrashed()->restore();
        return redirect()->route('publisher.deleted')->with('flashMessage', 'All Publishers restored successfully!');
    }

    // Create confirm archive message
    public function checkArchiveStatus($id)
    {
        $publisher = Publisher::find($id);
        return response()->json(['message' => "Are you sure that you want to archive {$publisher->name}?", 'deletable' => true], 200);
    }

    public function permanentDelete($id)
    {
        $publisher = Publisher::withTrashed()->find($id);

        if (!$publisher) {
            return abort(404);
        }

        $publisher->forceDelete();
        return redirect()->route('publisher.deleted')->with('flashMessage', 'Publisher permanently deleted!');
    }






}



