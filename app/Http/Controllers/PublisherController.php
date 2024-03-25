<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $publishers= Publisher::orderBy('name')->get();

        return view('publisher.index', compact('publishers'));


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

    public function destroy(Request $request, $id)
    {
        if (DB::table('book_copy')->where('publisher_id', $id)->exists()) {
            return redirect('/publisher')->with('flashMessage', 'error!!');
        }

        $publisher = Publisher::find($id);
        $publisher->delete();

        return redirect('/publisher')->with('flashMessage', 'Publisher deleted successfully!');

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





}



