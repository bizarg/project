<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Ticket;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('client.index', ['user' => $user]);
    }

    public function create()
    {
        return view('client.create_ticket');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:32|min:2',
            'description' => 'required|max:32|min:2'
        ];

        $this->validate($request, $rules);

        $user = Auth::user();

        $ticket = new Ticket([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user->id,
        ]);

        $ticket->save();

        return redirect()->route('home')->with('successfully', 'Ticket send!');
    }

    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);

        return view('client.ticket', ['ticket' => $ticket]);
    }
}
