<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Kordy\Ticketit\Models\Ticket;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('admin.user.index', ['users' => $users]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $user->load('domains', 'domains.status', 'domains.tariff' );

//        $tickets = Ticket::userTickets($user->id)->active()->get();

        return view('admin.user.show', ['user' => $user]);
    }
}
