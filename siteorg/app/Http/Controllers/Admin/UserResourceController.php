<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Site;
use App\Contact;
use DB;
use App\UserSite;

class UserResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(20);
        $users->load('contacts');

        return  view('admin.users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
            'api_key'  => 'required',
            'sex'  => 'required|in:male,female',
        ]);

        $result = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'api_key'  => $request->api_key,
            'sex'  => $request->sex,
        ]);

        if($result) return redirect()->route('users.index')->with('success', 'User was created');

        return redirect()->back()->with('fail', 'User was not created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Responsew
     */
    public function show($id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->load('contacts');

        $sites = $user->sites()->paginate(20);

        $referals = User::where('parent_id', $user->id)->get();

        return view('admin.users.show', ['user' => $user, 'sites' => $sites, 'referals' => $referals]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', ['user' => $user]);
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
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'password' => 'min:6',
            'api_key'  => 'required',
            'sex'  => 'required|in:male,female',
        ]);

        $user = User::findOrFail($id);

        $result = $user->update([
            'name' => $request->name,
            'email' => $request->email,
//            'password' => bcrypt($request->password),
            'api_key'  => $request->api_key,
            'sex'  => $request->sex,
        ]);

        if($request->has('password')) $user->password = $request->password;

        if($result) return redirect()->route('users.index')->with('success', 'User was update');

        return redirect()->back()->with('fail', 'User was not update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::findOrFail($id);

        $userSites = UserSite::where('user_id', $id)->get();

        if(count($userSites)){
            foreach($userSites as $site){
                $site->delete();
            }
        }

        $user->contacts()->delete();
    
        if($user->delete()) return redirect()->route('users.index')->with('success', 'User was deleted');

        return redirect()->back()->with('fail', 'User was not deleted');
    }
}
