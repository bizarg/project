<?php

namespace App\Http\Controllers\Admin;

use App\UserSite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Site;
use App\Contact;
use DB;
use Artisan;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function notify($id)
    {
        $contact = Contact::findOrFail($id);
        $res = $contact->notify;
        $contact->notify = !$contact->notify;
        $contact->save();

        return $res;
    }

    public function change_notify(Request $request)
    {
        $site = UserSite::where('site_id', $request->site_id)->firstOrFail();
        $site->notify_level = $request->notify;

        if($site->save()) return " Updated {$site->notify_level}";
    }

    public function edit_main_url(Request $request, $id)
    {
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

    public function show_jobs()
    {
        $jobs = DB::select('SELECT queue, COUNT(queue) AS queue_count FROM jobs GROUP BY queue');

        return view('admin.jobs.index', ['jobs' => $jobs]);
    }

    public function show_failed_jobs()
    {
        $failed_jobs = DB::table('failed_jobs')->paginate(20);

        return view('admin.jobs.failed_jobs', ['failed_jobs' => $failed_jobs]);
    }

    public function retryAll()
    {
        Artisan::call('queue:retry', ['id' => ['all'] ]);

        return redirect()->back()->with('success', 'The failed jobs is returned to the job table');

    }

    public function retry($id)
    {
        Artisan::call('queue:retry', ['id' => [$id]]);

        return redirect()->back()->with('success', 'The failed job is returned to the job table');
    }
}
