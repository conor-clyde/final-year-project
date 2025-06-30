<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GenreController extends Controller {
    /**
     * Display a list of active (non-archived) genres.
     */
    public function index() {
        $genres = Genre::orderBy('name')->where('archived', false)->get();
        return view('genre.index', compact('genres'));
    }

    /**
     * Show details for a single genre.
     */
    public function show(int $id) {
        $genre = Genre::withTrashed()->findOrFail($id);
        $genre->load('catalogueEntries.authors');
        return view('genre.show', compact('genre'));
    }

    /**
     * Show the form to create a new genre.
     */
    public function create() {
        return view('genre.create');
    }

    /**
     * Store a new genre in the database.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:genres',
            'description' => 'nullable|max:255',
        ]);
        Genre::create($validated);
        return $this->redirectWithSuccess('genre.index', 'Genre added successfully!');
    }

    /**
     * Show the form to edit an existing genre.
     */
    public function edit(Genre $genre) {
        return view('genre.edit', compact('genre'));
    }

    /**
     * Update an existing genre in the database.
     */
    public function update(Request $request, Genre $genre) {
        $validated = $request->validate([
            'name' => ['required', 'max:255', Rule::unique('genres')->ignore($genre->id)],
            'description' => 'nullable|max:255',
        ]);
        $genre->update($validated);
        return $this->redirectWithSuccess('genre.index', 'Genre updated successfully!');
    }

    /**
     * Return a JSON message for delete confirmation.
     */
    public function checkDelete(int $id) {
        $genre = Genre::withTrashed()->findOrFail($id);
        $canBeDeleted = !$genre->catalogueEntries()->exists();
        $message = $canBeDeleted
            ? "Are you sure you want to delete the genre '{$genre->name}'?"
            : "The genre '{$genre->name}' cannot be deleted because it is assigned to one or more books.";
        return response()->json(['message' => $message, 'deletable' => $canBeDeleted]);
    }

    /**
     * Return a JSON message for archive confirmation.
     */
    public function checkArchive(int $id) {
        $genre = Genre::findOrFail($id);
        $message = "Are you sure you want to archive the genre '{$genre->name}'?";
        return response()->json(['message' => $message]);
    }

    /**
     * Archive a genre (set archived=true).
     */
    public function archive(Genre $genre) {
        $genre->update(['archived' => true]);
        return $this->redirectWithSuccess('genre.index', 'Genre archived successfully!');
    }

    /**
     * Unarchive a genre (set archived=false).
     */
    public function unarchive(Genre $genre) {
        $genre->update(['archived' => false]);
        return $this->redirectWithSuccess('genre.archived', 'Genre unarchived successfully!');
    }

    /**
     * Soft-delete a genre (only if not in use).
     */
    public function destroy(Genre $genre) {
        if ($genre->catalogueEntries()->exists()) {
            return $this->redirectWithError('genre.index', 'Delete unsuccessful. Books are currently using this genre.');
        }
        $genre->delete();
        return $this->redirectWithSuccess('genre.index', 'Genre deleted successfully!');
    }

    /**
     * Show a list of archived genres.
     */
    public function archived() {
        $genres = Genre::where('archived', true)->orderBy('name')->get();
        return view('genre.archived', compact('genres'));
    }

    /**
     * Show a list of soft-deleted genres.
     */
    public function deleted() {
        $genres = Genre::onlyTrashed()->get();
        return view('genre.deleted', compact('genres'));
    }

    /**
     * Restore a soft-deleted genre.
     */
    public function restore(Genre $genre) {
        $genre->restore();
        return $this->redirectWithSuccess('genre.deleted', 'Genre restored successfully!');
    }

    /**
     * Permanently delete a soft-deleted genre.
     */
    public function forceDelete(Genre $genre) {
        $genre->forceDelete();
        return $this->redirectWithSuccess('genre.deleted', 'Genre permanently deleted!');
    }

    /**
     * Helper for redirecting with a success message.
     */
    private function redirectWithSuccess($route, $message) {
        return redirect()->route($route)->with('success', $message);
    }

    /**
     * Helper for redirecting with an error message.
     */
    private function redirectWithError($route, $message) {
        return redirect()->route($route)->with('error', $message);
    }
}
