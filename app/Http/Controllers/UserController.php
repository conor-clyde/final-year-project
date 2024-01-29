<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index() {

        if (request()->ajax()) {
            return datatables()->of(User::select('*'))
                ->addColumn('action', 'employee-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }



        return view ('user.index');
    }
}
