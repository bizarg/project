<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\UserSite;
use App\Site;
use App\Contact;

class UserController extends Controller
{
    public function index()
    {
        $sites = Auth::user()->sites()->paginate(20);

        return view('user.index', ['sites' => $sites]);
    }

    public function show_site($id)
    {
        $site = Auth::user()->sites()->where('sites.id', $id)->firstOrFail();

        $site->load('mainInfo');

        $userSite = UserSite::where('site_id', $id)->first();

        $yandex = $site->yandex()->orderBy('id', 'desc')->first();

        $screenshot = $site->screenshots()->orderBy('id', 'desc')->first();

        return view('user.show_info', [
            'site'      => $site,
            'userSite'  => $userSite,
            'yandex'    => $yandex,
            'screenshot' => $screenshot
        ]);
    }

    public function show_users()
    {
        $users = User::where('parent_id', Auth::user()->id)->paginate(20);

        return view('user.users', ['users' => $users]);
    }

    public function show_user_sites($id){

        $user = User::where('id', $id)->where('parent_id', Auth::user()->id)->firstOrFail();
        $sites = $user->sites()->paginate(20);

        return view('user.user_sites', ['user' => $user, 'sites' => $sites]);
    }

    public function show_user_site_info($user_id, $site_id)
    {
        $site = Site::findOrFail($site_id);
        $site->load('mainInfo');

        $userSite = UserSite::where('site_id', $site_id)->first();

        if(empty($userSite) || $userSite == null || $userSite->user_id == 0) {
            $user['name'] = 'Null';
        } else {
            $user = User::find($userSite->user_id);
        }

        $yandex = $site->yandex()->orderBy('id', 'desc')->first();

        $screenshot = $site->screenshots()->orderBy('id', 'desc')->first();

        return view('user.show_info', [
            'site'      => $site,
            'userSite'  => $userSite,
            'user'      => $user,
            'yandex'    => $yandex,
            'screenshot' => $screenshot
        ]);
    }

    public function notify($id)
    {
        $contact = Auth::user()->contacts()->where('id', $id)->firstOrFail();
        $res = $contact->notify;
        $contact->notify = !$contact->notify;
        $contact->save();

        return $res;
    }

    public function change_notify(Request $request)
    {
        $site = UserSite::where('site_id', $request->site_id)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        $site->notify_level = $request->notify;

        if($site->save()) return " Updated {$site->notify_level}";
    }
}
