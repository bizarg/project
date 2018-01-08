<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Task;
use App\Domen;
use App\Project;
use Gate;

class AdminController extends Controller
{

    public function index()
    {
    	return view('admin.index');
    }

    public function showUsers()
    {
    	$users = User::all();

    	return view('admin.users', ['users' => $users]);
    }

    public function statusUser($id)
    {
    	$user = User::findOrFail($id);

        $user->status = !$user->status;
             
        $user->save();

        return redirect()->route('users');
    }
}
