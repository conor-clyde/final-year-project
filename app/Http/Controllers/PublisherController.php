<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\BookCopy;
use App\Models\CatalogueEntry;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;


class PublisherController extends Controller
{
    /**
     * Display a listing of active publishers.
     */
    public function index()
    {
        $publishers = Publisher::orderBy('name')->where('archived', 0)->get();
        return view('publisher.index', compact('publishers'));
    }

    /**
     * Unarchive all publishers.
     */
    public function unarchiveAll()
    {
        Publisher::where('archived', 1)->update(['archived' => 0]);
        return $this->redirectWithSuccess('publisher.archived', 'All publishers unarchived successfully!');
    }

    /**
     * Unarchive a specific publisher.
     */
    public function unarchive(int $id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->archived = 0;
        $publisher->save();
        return $this->redirectWithSuccess('publisher.archived', 'Publisher unarchived successfully!');
    }

    /**
     * Show the form to create a new publisher.
     */
    public function create()
    {
        return view('publisher.create');
    }

    /**
     * Display a specific publisher.
     */
    public function show(Publisher $publisher)
    {
        $publisher->load('bookCopies.catalogueEntry.authors');
        return view('publisher.show', compact('publisher'));
    }

    /**
     * Store a new publisher in the database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255|unique:publishers',
        ], [
            'name.max' => 'The publisher\'s name must not exceed 255 characters',
        ]);
        $publisher = new Publisher(['name' => $validatedData['name']]);
        $publisher->save();
        return $this->redirectWithSuccess('publisher.index', 'Publisher added successfully!');
    }

    /**
     * Show the form to edit a publisher.
     */
    public function edit(int $id)
    {
        $publisher = Publisher::findOrFail($id);
        return view('publisher.edit', compact('publisher'));
    }

    /**
     * Update a publisher in the database.
     */
    public function update(Request $request, int $id)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('publishers')->ignore($id),
            ]
        ], [
            'name.max' => 'The publisher\'s name must not exceed 255 characters',
        ]);
        $publisher = Publisher::findOrFail($id);
        $publisher->fill($validatedData);
        $publisher->save();
        return $this->redirectWithSuccess('publisher.index', 'Publisher updated successfully!');
    }

    /**
     * Archive a publisher.
     */
    public function archive(int $id)
    {
        $publisher = Publisher::findOrFail($id);
        $publisher->archived = 1;
        $publisher->save();
        return $this->redirectWithSuccess('publisher.index', 'Publisher archived successfully!');
    }

    /**
     * Show a list of archived publishers.
     */
    public function archived()
    {
        $publishers = Publisher::where('archived', 1)->orderBy('name')->get();
        return view('publisher.archived', compact('publishers'));
    }

    /**
     * Show a list of soft-deleted publishers.
     */
    public function deleted()
    {
        $publishers = Publisher::onlyTrashed()->get();
        return view('publisher.deleted', compact('publishers'));
    }

    /**
     * Restore a soft-deleted publisher.
     */
    public function restore(Publisher $publisher)
    {
        $publisher->restore();
        return $this->redirectWithSuccess('publisher.deleted', 'Publisher restored successfully!');
    }

    /**
     * Restore all soft-deleted publishers.
     */
    public function restoreAll()
    {
        Publisher::onlyTrashed()->restore();
        return $this->redirectWithSuccess('publisher.deleted', 'All publishers restored successfully!');
    }

    /**
     * Permanently delete a soft-deleted publisher.
     */
    public function permanentDelete(Publisher $publisher)
    {
        $publisher->forceDelete();
        return $this->redirectWithSuccess('publisher.deleted', 'Publisher permanently deleted!');
    }

    /**
     * Delete a publisher (soft delete).
     */
    public function destroy(Request $request)
    {
        $publisherId = $request->id;
        $publisher = Publisher::findOrFail($publisherId);
        if ($publisher->archived == 1) {
            $publisher->archived = 0;
            $publisher->save();
            $publisher->delete();
            return $this->redirectWithSuccess('publisher.archived', 'Publisher deleted successfully!');
        } else {
            if (BookCopy::where('publisher_id', $publisherId)->exists()) {
                return $this->redirectWithError('publisher.index', 'Delete unsuccessful. Books are currently using this publisher.');
            }
            $publisher->delete();
            return $this->redirectWithSuccess('publisher.index', 'Publisher deleted successfully!');
        }
    }

    /**
     * Check if a publisher can be deleted.
     */
    public function checkDeletionStatus(int $id)
    {
        $publisher = Publisher::findOrFail($id);
        $canBeDeleted = !BookCopy::where('publisher_id', $id)->exists();
        if ($canBeDeleted) {
            return response()->json(['message' => "Are you sure that you want to delete {$publisher->name}?", 'deletable' => true], 200);
        } else {
            return response()->json(['message' => "{$publisher->name} can not be deleted because books are published by this publisher", 'deletable' => false], 200);
        }
    }

    /**
     * Check if a publisher can be archived.
     */
    public function checkArchiveStatus(int $id)
    {
        $publisher = Publisher::findOrFail($id);
        return response()->json(['message' => "Are you sure that you want to archive {$publisher->name}?"], 200);
    }

    /**
     * Helper for redirecting with a success message.
     */
    private function redirectWithSuccess($route, $message)
    {
        return redirect()->route($route)->with('success', $message);
    }

    /**
     * Helper for redirecting with an error message.
     */
    private function redirectWithError($route, $message)
    {
        return redirect()->route($route)->with('error', $message);
    }
}



