<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Site;
use App\Contact;
use DB;

class SearchController extends Controller
{
    public function search_sites(Request $request)
    {
        $sites = Site::where('domain', 'like', '%'.$request->text.'%')->paginate(20);

        return  view('admin.sites.index', ['sites' => $sites]);
    }

    public function search_users(Request $request)
    {
        $users = User::where('users.email', 'like', '%'.$request->text.'%')
            ->orWhere('users.api_key', 'like', '%'.$request->text.'%')
            ->orWhere('users.name', 'like', '%'.$request->text.'%')
            ->orWhereHas('contacts', function($query) use ($request) {
                $query->where('contacts.contact', 'like', '%'.$request->text.'%')
                    ->orWhere('contacts.type', 'like', '%'.$request->text.'%');
            })->paginate(20);

        $users->load('contacts');

        return  view('admin.users.index', ['users' => $users]);
    }
}
