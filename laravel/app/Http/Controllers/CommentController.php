<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Task;
use App\Comment;
use App\Domen;

class CommentController extends Controller
{
	public function index($id, $model)
	{
		if($model == 'domen'){
			$obj = Domen::findOrFail($id);
		} 
			
		if($model == 'task'){
			$obj = Task::findOrFail($id);
		} 

		$comments = $obj->comments()->orderBy('created_at' ,'desc')->paginate(20);

		return view('comments', ['obj' => $obj, 'comments' => $comments, 'model' => $model]);
	}

	public function addComment(Request $request, $id)
	{
		$rules = [
			'text' => 'required'
		];

		$this->validate($request, $rules);

		$user = Auth::user();
		$comment = new Comment([
			'text' => $request->text,
			'user_id' => $user->id,
			'user_name' => $user->name
		]);

		if($request->object == 'domen'){
			$domen = Domen::find($id);
			$domen->comments()->save($comment);

			return back();
		} else {
			$task = Task::find($id);	
			$task->comments()->save($comment);

			return back();
		}
	}    
}
