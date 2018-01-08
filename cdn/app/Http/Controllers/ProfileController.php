<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\FtpSettings;
use App\Setting;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author Ruslan Ivanov
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ftps = FtpSettings::where('user_id', Auth::user()->id)->get();
        $domains = Setting::where('user_id', Auth::user()->id)->get(); 

        return view('profile', ['ftps' => $ftps, 'domains' => $domains]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @author Ruslan Ivanov
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|min:5|max:255'. ( $user->email != $request->email ? '|unique:users' : '' ),
            'password' => 'min:6',
            'password_confirm' => 'required_with:password|same:password',
        ]);

        if($user->name != $request->name and !empty($request->name)) $user->name = $request->name;
        if($user->email != $request->email and !empty($request->email)) $user->email = $request->email;
        if (!Hash::check($request->password, $user->password) and !empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        if($user->save()) {
            return redirect()->back()->with('success', 'Success');
        } else {
            return redirect()->back()->with('fail', 'Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
