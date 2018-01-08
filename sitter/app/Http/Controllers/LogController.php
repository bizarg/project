<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domen;
use App\Project;

class LogController extends Controller
{
	public function index($id, $model)
	{
		if($model == 'domen'){
			$obj = Domen::findOrFail($id);
		} 
			
		if($model == 'project'){
			$obj = Project::findOrFail($id);
		} 

		$logs = $obj->logs()->orderBy('created_at' ,'desc')->paginate(20);

		return view('logs', ['obj' => $obj, 'logs' => $logs]);
	}
}
