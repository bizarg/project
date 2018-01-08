<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Node;
use App\site;
use App\User;
use Illuminate\Http\Request;
use Validator;

class SiteController extends Controller
{
    function sites()
    {
        $sites = Site::paginate(20);
        return view('admin.site.sites', ['sites' => $sites]);
    }

    function edit($id)
    {
        $site = Site::findOrFail($id);
        $users = User::lists('name', 'id');
        $nodes = Node::lists('country', 'id');

        return view('admin.site.edit', ['site' => $site, 'users' => $users, 'nodes' => $nodes]);
    }

    function status($id)
    {
        $site = Site::findOrFail($id);
        if ($site->status == 'active') {
            $site->status = 'inactive';
        } else {
            $site->status = 'active';
        }
        $site->save();
        return redirect()->to('admin/sites');
    }

    function create()
    {
        $users = User::lists('name', 'id');
        $nodes = Node::lists('country', 'id');
        return view('admin.site.edit', ['users' => $users, 'nodes' => $nodes]);
    }

    function store(Request $request)
    {
        $rules = [
            'url' => 'required|url',
            'user_id' => 'required|exists:users,id',
            'node_id' => 'required|exists:nodes,id',
            'status' => 'required|in:active,inactive',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $parsed_url = parse_url($request->url);
        $domain = $parsed_url['host'];

        $request->request->add(['domain' => $domain]);
        if ($request->has('id')) {
            $site = Site::findOrfail($request->id);
            $site->update($request->all());
        } else {
            Site::create($request->all());
        }


        return redirect()->to('admin/sites');
    }

}
