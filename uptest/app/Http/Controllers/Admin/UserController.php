<?php

namespace App\Http\Controllers\Admin;

use App\Domain;
use App\IpAddress;
use App\Task;
use App\User;
use App\UserIp;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    function all_users()
    {
        $users = User::paginate(20);
        return view('admin.users', ['users' => $users]);
    }

    function edit_user($id)
    {
        return view('admin.profile', ['user' => User::findOrFail($id)]);
    }

    function detail_user($id)
    {
        $domains = Domain::where('user_id', $id)->paginate(20);
        return view('admin.detail', ['domains' => $domains]);
    }

    function user_edit(Request $request, $id)
    {
        $user = User::findOrFail($id);

        Validator::extend('password_check', function ($attribute, $value) {
            if (isset($value) && strlen($value) > 0 && strlen($value) < 6) {
                return false;
            } else {
                return true;
            }

        }, 'password short');

        $rules = [
            'new_password' => 'required|password_check',
            'role' => 'required'
        ];

        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            return redirect()->back()->withInput()->withErrors($v->errors());
        }

        if(strlen($request->input('new_password')) > 0) {
            $user->password = bcrypt($request->input('new_password'));
        }
        $user->role = $request->input('role');
        $user->save();
        return redirect()->to('admin/users');
    }

    function suspend_user($id)
    {
        $user = User::findOrFail($id);
        if ($user->status == 'active') {
            $user->status = 'inactive';
        } else {
            $user->status = 'active';
        }
        $user->save();
        return redirect()->to('admin/users');
    }


}
