<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller {
    public function index() {
        $authors = Author::orderBy('surname')->orderBy('forename')->where('archived', false)->get();
        return view('author.index', compact('authors'));
    }

    public function create() {
        return view('author.create');
    }

    public function show(Author $author) {
        $author->load('catalogueEntries');
        return view('author.show', compact('author'));
    }

    public function store(StoreAuthorRequest $request) {
        Author::create($request->validated());
        return $this->redirectWithSuccess('author.index', 'Author added successfully.');
    }

    public function edit(Author $author) {
        return view('author.edit', compact('author'));
    }

    public function update(UpdateAuthorRequest $request, Author $author) {
        $author->update($request->validated());
        return $this->redirectWithSuccess('author.index', 'Author updated successfully.');
    }

    public function destroy(Request $request, Author $author) {
        $author->delete();
        return back()->with('success', 'Author deleted successfully!');
    }

    public function permanentDelete(int $id) {
        $author = Author::withTrashed()->findOrFail($id);
        $author->forceDelete();
        return $this->redirectWithSuccess('author.deleted', 'Author permanently deleted!');
    }

    public function checkArchiveStatus(Author $author) {
        return response()->json([
            'message' => "Are you sure you want to archive {$author->full_name}?",
        ]);
    }

    public function archive(Author $author) {
        $author->update(['archived' => true]);
        return $this->redirectWithSuccess('author.index', 'Author archived successfully!');
    }

    public function checkDeletionStatus(Author $author) {
        $canBeDeleted = !$author->catalogueEntries()->exists();

        return response()->json([
            'message' => $canBeDeleted
                ? "Are you sure you want to delete {$author->full_name}?"
                : "{$author->full_name} cannot be deleted because they are assigned to existing books.",
            'deletable' => $canBeDeleted
        ]);
    }

    public function archived() {
        $authors = Author::where('archived', true)->orderBy('surname')->get();
        return view('author.archived', compact('authors'));
    }

    public function unarchive(Author $author) {
        $author->update(['archived' => false]);
        return $this->redirectWithSuccess('author.archived', 'Author unarchived successfully!');
    }

    public function deleted() {
        $authors = Author::onlyTrashed()->orderBy('surname')->get();
        return view('author.deleted', compact('authors'));
    }

    public function restore(int $id) {
        $author = Author::withTrashed()->findOrFail($id);
        $author->restore();
        return $this->redirectWithSuccess('author.deleted', 'Author restored successfully!');
    }

    public function unarchiveAll() {
        Author::where('archived', true)->update(['archived' => false]);
        return $this->redirectWithSuccess('author.archived', 'All authors unarchived successfully!');
    }

    public function restoreAll() {
        Author::onlyTrashed()->restore();
        return $this->redirectWithSuccess('author.deleted', 'All authors restored successfully!');
    }

    private function redirectWithSuccess($route, $message) {
        return redirect()->route($route)->with('success', $message);
    }
}
