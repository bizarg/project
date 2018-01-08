<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\UserSite;
use DB;
use App\Site;

class SiteController extends Controller
{
    public function edit($id)
    {
        $site = DB::table('sites')
            ->join('user_sites', 'sites.id', '=', 'user_sites.site_id')
            ->join('users', 'user_sites.user_id', '=', 'users.id')
            ->select('sites.id', 'domain', 'main_url')
            ->where('sites.id', $id)
            ->first();

        return view('user.sites.edit', ['site' => $site]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'domain'    => 'required',
            'main_url'    => 'required',
        ]);

        $site = Site::findOrFail($id);

        $result = $site->update([
            'domain'    => $request->domain,
            'main_url'    => $request->main_url
        ]);

        if($result) return redirect()->action('User\UserController@index')->with('success', 'Site was update');

        return redirect()->back()->with('fail', 'Site was not update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $site = Site::findOrFail($id);

        $userSite = UserSite::where('site_id', $id)->first();

        if(count($userSite)){
            $userSite->delete();
        }

        if($site->delete()) return redirect()->action('User\UserController@index')->with('success', 'Site was deleted');

        return redirect()->back()->with('fail', 'Site was not deleted');
    }

    public function edit_main_url(Request $request, $id)
    {
        $this->validate($request, [
            'url' => 'max:40'
        ]);

        $site = Site::findOrFail($id);

        if(preg_match("/http:\/\//", $site->main_url)){
            $site->main_url = 'http://' . $site->domain . $request->url;
        } else if(preg_match("/https:\/\//", $site->main_url)){
            $site->main_url = 'https://' . $site->domain . $request->url;
        }
        $res = $site->main_url;
        $site->save();

        return $res;
    }
}
