<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Node;
use Illuminate\Http\Request;
use Validator;

class NodeController extends Controller
{
    function nodes()
    {
        $nodes = Node::paginate(20);
        return view('admin.node.nodes', ['nodes' => $nodes]);
    }

    function edit($id)
    {
        $node = Node::findOrFail($id);
        return view('admin.node.edit', ['node' => $node]);
    }

    function status($id)
    {
        $node = Node::findOrFail($id);
        if ($node->status == 'active') {
            $node->status = 'inactive';
        } else {
            $node->status = 'active';
        }
        $node->save();
        return redirect()->to('admin/nodes');
    }

    function create()
    {
        return view('admin.node.edit');
    }

    function store(Request $request)
    {

//        'name',
//        'ip',
//        'port',
//        'country',
//        'flag',
//        'status'
        $rules = [
            'name' => 'required',
            'ip' => 'required|ip',
            'port' => 'required|integer',
            'country' => 'required',
            'flag' => 'required',
            'status' => 'required|in:active,inactive',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($request->has('id')) {
            $node = Node::findOrfail($request->id);
            $node->update($request->all());
        } else {
            Node::create($request->all());
        }


        return redirect()->to('admin/nodes');
    }

}
