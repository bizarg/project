<?php

namespace App\Http\Controllers\Admin;

use App\UserSite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Site;
use App\Contact;
use DB;

class SiteResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::paginate(10);

        return  view('admin.sites.index', ['sites' => $sites]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();

        return view('admin.sites.create', ['users' => $users]);
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
            'domain'    => 'required|min:3',
            'main_url'    => 'required|min:9',
            'userSites'    => 'required',
        ]);

        $result = Site::create([
            'domain'    => $request->domain,
            'main_url'    => $request->main_url,
        ]);


        UserSite::create([
            'user_id'   => $request->userSites,
            'site_id'   => $result->id,
        ]);


        if($result) return redirect()->route('sites.index')->with('success', 'Site was create');

        return redirect()->back()->with('fail', 'Site was not create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $site = Site::findOrFail($id);
        $site->load('mainInfo');

        $userSite = UserSite::where('site_id', $id)->first();

        if(empty($userSite) || $userSite == null || $userSite->user_id == 0) {
            $user['name'] = 'Null';
        } else {
            $user = User::find($userSite->user_id);
        }

        $yandex = $site->yandex()->orderBy('id', 'desc')->first();

        $screenshot = $site->screenshots()->orderBy('id', 'desc')->first();

        return view('admin.sites.show', [
            'site'      => $site,
            'userSite'  => $userSite,
            'user'      => $user,
            'yandex'    => $yandex,
            'screenshot' => $screenshot
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $site = Site::findOrFail($id);

        $userSite = UserSite::where('site_id', $id)->first();
        if(empty($userSite)){
            $userSite['user_id'] = null;
        }
        $users = User::all();

        return view('admin.sites.edit', ['site' => $site, 'users' => $users, 'userSite' => $userSite]);
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
            'domain'    => 'required',
            'main_url'    => 'required',
            'userSites'    => 'required',
        ]);

        $site = Site::findOrFail($id);

        $result = $site->update([
            'domain'    => $request->domain,
            'main_url'    => $request->main_url
        ]);

        $userSite = UserSite::where('site_id', $id)->first();

        if($userSite == null){
            UserSite::create([
                'user_id'   => $request->userSites,
                'site_id'   => $id,
            ]);
        } else {
            $userSite->update([
                'user_id'   => $request->userSites,
                'site_id'   => $id,
            ]);
        }


        if($result) return redirect()->route('sites.index')->with('success', 'Site was update');

        return redirect()->back()->with('fail', 'Site was not update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $site = Site::findOrFail($id);

        $userSite = UserSite::where('site_id', $id)->first();

        if(count($userSite)){
            $userSite->delete();
        }

        if($site->delete()) return redirect()->route('sites.index')->with('success', 'Site was deleted');

        return redirect()->back()->with('fail', 'Site was not deleted');
    }
}
