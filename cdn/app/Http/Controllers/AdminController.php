<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
	/**
	* Display a listing of the resource.
	*
	* @author 
	* @return \Illuminate\Http\Response
	*/
    public function index()
    {
        $users = User::all();

        return view('settings', ['users' => $users]);
    }

    /**
	* Display a listing of the resource.
	*
	* @author
	* @param int $id
	* @return \Illuminate\Http\Response
	*/
    public function statusUser($id)
    {
        $user = User::findOrFail($id);

        $user->status = !$user->status;
             
        $user->save();

        return redirect()->back()->with('status', 'Status changed!');
    }

    public function statusUpload(Request $request, $id)
    {

        $user = User::findOrFail($id);

        if(!preg_match("|^[\d]+$|", $request->num)){
            return ['res' => 'error'];
        }

        if($request->num < 0){
            return ['res' => 'error'];
        }

        $user->quantity = $request->num;

        if($user->save()){
            return ['res' => $request->num];
        }
    }
}
