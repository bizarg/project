<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Session;

class UserController extends Controller
{

	public function index()
	{
		return view('profile.profile');
	}

    public function editUser()
    {
    	$user = Auth::user();

    	return view('profile.user', ['user' => $user]);
    }

    public function editAccount()
    {
    	$user = Auth::user();

    	return view('profile.account', ['user' => $user]);
    }

    public function updateUser(Request $request)
    {
    	$user = Auth::user();

    	$user->name = $request->name;
    	$user->email = $request->email;

    	$user->save();

    	Session::flash('successfully', 'данные успешно обновлены');
    	return redirect()->route('profile');

    }

    public function updateAccount(Request $request)
    {
    	$user = Auth::user();

    	$rules = [
    		'old_password' => 'required|min:6',
    		'password' => 'required|confirmed|min:6'
    	];

    	$this->validate($request, $rules);

    	if (Auth::attempt(['email' => $user->email, 'password' => $request->old_password]))
        {
        	$user->forceFill([
            	'password' => bcrypt($request->password),
	            'remember_token' => Str::random(60),
	        ])->save();

	        Session::flash('successfully', 'пароль успешно обновлен');
	        return redirect()->route('profile');
        } else {
        	Session::flash('error', 'Пароль указан не верно');
        	return redirect()->back();
        }

    }

}
