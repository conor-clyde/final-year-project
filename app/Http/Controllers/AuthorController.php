<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;


class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::orderBy('surname')->orderBy('forename')->get();

        return view('author.index', compact('authors'));


    }

    public function create()
    {
        return view('author.create');
    }

    public function show($id)
    {
        return Author::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'surname' => 'required',
            'forename' => 'required',
        ]);

        // Create author
        $author = new Author;
        $author->surname = $request->input('surname');
        $author->forename = $request->input('forename');

        $author->save();



        return redirect('/author')->with('flashMessage', 'Author added successfully!');
    }

    public function edit($id) {
        $author = Author::find($id);

        return view('author.edit')->with('author', $author);



    }

    public function update(Request $request, $id) {

        $this->validate($request, [
            'surname' => 'required',
            'forename' => 'required'


        ]);

        $author = Author::find($request->input('id'));
        $author->surname = $request->input('surname');
        $author->forename = $request->input('forename');
        $author->save();

        return redirect('/author')->with('flashMessage', 'Author updated successfully!');
    }

    public function destroy(Request $request, $id)
    {
        if (DB::table('author_catalogue_entry')->where('author_id', $id)->exists()) {
            return redirect('/author')->with('flashMessage', 'error!!');
        }


        $author = Author::find($id);
        $author->delete();

        return redirect('/author')->with('flashMessage', 'Author deleted successfully!');

    }





}



