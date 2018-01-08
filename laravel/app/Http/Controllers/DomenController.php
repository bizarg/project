<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Domen;
use App\Project;
use \Auth;
use Session;
use DB;
use App\Log;

class DomenController extends Controller
{
    public function create()
    {
        return view('domen.create');
    }

    public function store(Request $request)
    {
    	$rules = [
            'name' => 'required|max:32|min:2|unique:domens'
        ];

        $this->validate($request, $rules);
    	
    	$user = Auth::user();

        if($request->has('marker')){
            $marker = $request->marker;
        } else {
            $marker = "Без маркера";
        }

    	$domen = new Domen([
            'name' => $request->name,
            'marker' => $marker
        ]);

    	$domen = $user->domens()->save($domen);

        $log = new Log([
            'text' => 'Домен создан : '.$domen->name,
            'user_id' => $user->id
        ]);

        $domen->logs()->save($log);

    	Session::flash('successfully', ' Домен успешно создан!');
    	return redirect()->route('managment');
    }

    public function edit($id)
    {
    	$domen = Domen::findOrFail($id);

    	return view('domen.edit', ['domen' => $domen]);
    }

    public function update(Request $request, $id)
    {
    	$user = Auth::user();

    	$rules = [
            'name' => 'required|max:32|min:4|unique:domens,name,'.$id
        ];

		$this->validate($request, $rules);

		$domen = Domen::findOrFail($id);

        $log = new Log([
            'text' => 'Домен обновлен : '.$domen->name,
            'user_id' => $user->id
        ]);

        $domen->logs()->save($log);

        if($request->has('marker')){
            $marker = $request->marker;
        } else {
            $marker = "Без маркера";
        }

        $domen->name = $request->name;
		$domen->marker = $marker;
        $domen->priority = $request->priority;

		$domen->save();

	    Session::flash('successfully', 'Домен обновлен успешно!');
		return redirect()->route('managment');
    }

    public function destroy(Request $request, $id)
    {
    	$user = Auth::user();
        $domen = Domen::find($id);

        if($domen->user_id != $user->id){
            Session::flash('error', 'Недостаточно прав!');
            return redirect()->route('managment');
        }

        $cause = '';
        if($request->has('comment')) $cause = ' | Комментарий : '.$request->comment;

    	$projects = $domen->projects;

        if($projects){
            foreach($projects as $project){
                $project->domens()->detach($domen->id);
                    $log = new Log(['text' => 'Домен '.$domen->name.'удален из проекта '.$project->name, 'user_id' => $user->id]);
                    $project->logs()->save($log);
            }
        }

        $log = new Log(['text' => 'Домен удален : '.$domen->name.$cause, 'user_id' => $user->id]);
        $domen->logs()->save($log);

    	Domen::destroy($id);

    	Session::flash('successfully', ' Домен успешно удален!');
    	return redirect()->route('managment');
    }

    public function editPriority($domen_id, $project_id) 
    {
        $project = Project::find($project_id);
        $domen = Domen::find($domen_id);

        $marker = $domen->marker;
        $name = $domen->name;

        foreach($project->domens as $domen){
            if($domen->id == $domen_id){
               $pivot = $domen->pivot;
            }
        }

        return view('domen.priority', [
            'pivot' => $pivot,
            'domen_id' => $domen_id,
            'project_id' => $project_id,
            'marker' => $marker,
            'name' => $name
        ]);
    }

    public function updatePriority(Request $request, $domen_id, $project_id)
    {

        $rules = [
            'priority' => 'integer'
        ];

        $this->validate($request, $rules);

        $domen = Domen::find($domen_id)
            ->projects()
            ->updateExistingPivot($project_id, ['priority' => $request->priority]);

        if($request->has('marker')){
            $marker = $request->marker;
        } else {
            $marker = "Без маркера";
        }

        $domen = Domen::find($domen_id);
        $domen->marker = $marker;
        $domen->save();

        Session::flash('successfully', 'Домен обновлен успешно!');
        return redirect()->action(
            'ProjectController@show', ['id' => $project_id]
        );
    }

    public function show($id)
    {
        $domen = Domen::findOrFail($id);
        $comments = $domen->comments()->latest()->limit(5)->get();
        $logs = $domen->logs()->latest()->limit(5)->get();
        $tasks = $domen->tasks()->orderBy('created_at','desc')->paginate(3);

        return view('domen.domen', [
            'domen' => $domen,
            'comments' => $comments,
            'logs' => $logs,
            'tasks' => $tasks,
        ]);
    }

    public function showDeleteForm($id)
    {
        return view('domen.delete', ['id' => $id]);
}
}
