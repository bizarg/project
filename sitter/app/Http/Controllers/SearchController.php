<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $user = Auth::user();

        $projects = [];
        $projects1 = [];

        $projects = $user->projects()->whereHas('domens', function($query) use ($request) {
            $query->where('domens.name', 'like', '%'.$request->text.'%')
                ->orWhere('projects.name', 'like', '%'.$request->text.'%')
                ->orWhere('projects.description', 'like', '%'.$request->text.'%');
        })->get();

        return view('search', ['projects' => $projects, 'projects1' => $projects1]);
    }
}
