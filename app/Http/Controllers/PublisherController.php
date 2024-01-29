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

    public function show($id)
    {
        return Genre::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        // Create publisher
        $publisher= new Publisher;
        $publisher->name = $request->input('name');
        $publisher->save();

        return redirect('/publisher')->with('flashMessage', 'Publisher added successfully!');
    }

    public function edit($id) {
        $publisher = Publisher::find($id);

        return view('publisher.edit')->with('publisher', $publisher);

    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $publisher = Publisher::find($request->input('id'));
        $publisher->name = $request->input('name');
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





}



