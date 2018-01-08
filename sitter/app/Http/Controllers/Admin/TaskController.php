<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Task;
use App\Domen;
use App\Project;
use App\Log;
use App\Comment;
use Auth;
use Gate;
use Session;


class TaskController extends Controller
{
	public function show($id)
	{
		$task = Task::findOrFail($id);
		$comments = Comment::where('commentable_id', $id)->orderBy('created_at', 'desc')->paginate(5);

		return view('task.task', ['task' => $task, 'comments' => $comments]);
	}

    public function showTasks()
    { 
        $tasks = Task::select()->orderBy('id', 'desc')->get();

        return view('admin.tasks', ['tasks' => $tasks]);
    }

    public function create()
    {
        $domens = Domen::all();
        $projects = Project::all();

        return view('admin.create_task', ['domens' => $domens, 'projects' => $projects]);
    }

    public function store(Request $request)
    {
            $rules = [
            'name' => 'required',
            'description' => 'required',
            'project' => 'required_without:domen',
            'domen' => 'required_without:project',
            'date' => 'date|required'
        ];

        $this->validate($request, $rules);

        $user = Auth::user();

        if($request->has('domen')){
            $object = Domen::find($request->domen);
        }

        if($request->has('project')){
            $object = Project::find($request->project);
        }

        $task = new Task([
        	'name' => $request->name,
        	'description' => $request->description,
        	'date' => strtotime($request->date)
        ]);

        $task = $object->tasks()->save($task);

		$log = new Log([
			'text' => 'Новая задача '. "<a href='" . url("task/task/" . $task->id) . "'>" . $task->name . '</a> для  '.$object->name,
			'user_id' => $user->id
		]);

        $object->logs()->save($log);
        Session::flash('successfully', 'Задача создана!');
        return redirect()->route('tasks');
    }
        
    public function statusTask($id)
    {
        $task = Task::findOrFail($id);

        $task->status = !$task->status;
                    
        $task->save();
        return redirect()->route('tasks');
    }

    public function edit($id)
    {
    	$task = Task::findOrFail($id);

    	return view('admin.edit_task', ['task' => $task]);
    }

    public function update(Request $request, $id)
    {
    	$rules = [
            'name' => 'required',
            'description' => 'required',
            'date' => 'date'
        ];

        $this->validate($request, $rules);

        $user = Auth::user();
        $task = Task::findOrFail($id);

        $task->name = $request->name;
        $task->description = $request->description;
        $task->date = strtotime($request->date);

        $obj = $task->taskable;

        $log = new Log([
        	'text' => 'Задача ' . "<a href='" . url("task/task/" . $task->id) . "'>" . $task->name . '</a>'. ' обновлена',
        	'user_id' => $user->id
        ]);

        $obj->logs()->save($log);

        $task->save();

        Session::flash('successfully', 'Задача обновлена!');
        return redirect()->route('tasks');
    }

    public function destroy($id)
    {
    	$user = Auth::user();
    	$task = Task::findOrFail($id);

    	$obj = $task->taskable;

    	$log = new Log([
			'text' => 'Задача '.$task->name.' удалена',
			'user_id' => $user->id
		]);

    	$obj->logs()->save($log);

    	Task::destroy($id);

    	Session::flash('successfully', 'Задача удалена!');
    	return redirect()->route('tasks');
    }
}
