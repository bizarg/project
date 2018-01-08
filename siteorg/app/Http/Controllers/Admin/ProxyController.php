<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Managers\ProxiesManager;
use App\Proxy;
use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function index()
    {

        $groups =   Proxy::groupBy('type')->pluck('type');
        $pm = new ProxiesManager();
        $activeProxy = [];
        foreach ($groups  as $group){
            
            $activeProxy[$group] = $pm->checkCount($group);
        }
        if (request()->has('order')) {
            $proxies = Proxy::orderBy(request()->input('order'))->paginate(20);
        } else {
            $proxies = Proxy::paginate(20);
        }


        return view('admin.proxy.index', compact('proxies', 'activeProxy' ));
    }

    public function create()
    {
        return view('admin.proxy.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'ip' => 'required|ipv4',
            'port' => 'required|integer',
            'type' => 'required',
            'status' => 'required|in:enabled,disabled',
            'banned' => 'required|in:1,0',
        ]);
        if ($request->has('id')) {
            $proxy = Proxy::findOrfail($request->id);
            $proxy->update($request->all());

        } else {
            Proxy::create($request->all());
        }
        return redirect('admin/proxies');
    }


    public function edit($id)
    {
        $proxy = Proxy::findOrFail($id);
        return view('admin.proxy.create', compact('proxy'));
    }

    public function destroy($id)
    {
        $proxy = Proxy::findOrFail($id);
        $proxy->delete();
        return redirect('admin/proxies');
    }

    public function ban($id)
    {
        $proxy = Proxy::findOrFail($id);
        $proxy->banned = !$proxy->banned;
        $proxy->save();
        return redirect()->back();
    }

    public function status($id)
    {
        $proxy = Proxy::findOrFail($id);
        if ($proxy->status == 'enabled') {
            $proxy->status = 'disabled';
        } else {
            $proxy->status = 'enabled';
        }
        $proxy->save();
        return redirect()->back();
    }

}
