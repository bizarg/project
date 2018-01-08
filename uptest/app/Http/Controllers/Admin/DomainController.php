<?php

namespace App\Http\Controllers\Admin;

use App\Domain;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DomainController extends Controller
{
    public function domain_all()
    {

        $domains = Domain::orderBy('id', 'desc')->paginate(20);
        return view('admin.detail', ['domains' => $domains]);

    }
}
