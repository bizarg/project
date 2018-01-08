<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Site;
use App\Contact;
use DB;

class SearchController extends Controller
{
    public function search_sites(Request $request)
    {
        $sites = Auth::user()->sites()->where('domain', 'like', '%'.$request->text.'%')->paginate(20);

        return  view('user.index', ['sites' => $sites]);
    }
}
