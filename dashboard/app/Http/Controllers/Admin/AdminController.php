<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $users = User::paginate(20);

        return view('admin.index', ['users' => $users]);
    }

    public function generate_token($id)
    {
        $user = User::find($id);
        $user->login_token = str_random(50);
        $user->login_token_expires = Carbon::now();
        $user->save();

        return response()->json(['token' => $user->login_token, 'id' => $id]);
    }

    public function search_user(Request $request)
    {
        $users = User::where('users.email', 'like', '%'.$request->search.'%')
            ->orWhere('users.amhost_login', 'like', '%'.$request->search.'%')
            ->orWhere('users.amhost_id', 'like', '%'.$request->search.'%')
            ->orWhere('users.login_token', 'like', '%'.$request->search.'%')
            ->paginate(20);

        return  view('admin.index', ['users' => $users]);
    }
}
