<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Domen;
use App\Log;
use Auth;
use Session;
use Gate;
use Mail;

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user->load('projects', 'domens');

        return view('project.managment', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $users = User::where('id', '!=', $user->id)->get();

        $domens = $user->domens;

        return view('project.create', ['users' => $users, 'domens'=> $domens]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|max:32|min:6|unique:projects',
            'description' => 'required|min:6',
        ];

        $this->validate($request, $rules);
        
        $user = Auth::user();

        $project = new Project([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $user->id
        ]);

        $project->save();

        $user->projects()->attach($project->id);

        $log = new Log([
            'text' => 'Проект создан : '.$project->name,
            'user_id' => $user->id
        ]);

        $project->logs()->save($log);

        if($request->has('domens')){
            foreach($request->domens as $domen_id){
                $domen = Domen::find($domen_id);
                $project->domens()->attach($domen_id);

                $log = new Log([
                    'text' => 'Домен '.$domen->name.' привязан к : '.$project->name,
                    'user_id' => $user->id
                ]);

                $domen->logs()->save($log);
            }
        }

        if($request->has('users')){
            foreach($request->users as $assist){

                $name = User::find($assist);

                $project->assistants()->attach($assist);

                Mail::queue('emails.mail', array('project' => $project), function($message) use($name)
                {
                    $message->from('admin@mail.ru');
                    $message->to($name->email, $name->name)->subject('Added project');
                });

                $log = new Log([
                    'text' => 'К проекту '.$project->name.' привязан пользователь : '.$name->name,
                    'user_id' => $user->id
                ]);

                $project->logs()->save($log);
            }
        }
        Session::flash('successfully', ' Проект успешно создан!');
        return redirect()->route('managment');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        $project->load('domens', 'assistants');

        $tasks = $project->tasks()->orderBy('created_at','desc')->paginate(20);
        $logs = $project->logs()->latest()->limit(5)->get();

        return view('project.project', [
            'project' => $project,
            'tasks' => $tasks,
            'logs' => $logs
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        $project = Project::findOrFail($id);

        if($user->id != $project->user->id){
            Session::flash('error', ' Недостаточно прав для редактирования!');
            return redirect()->route('managment');
        }

        $project->load('assistants', 'domens');
        $assistants = User::all();

        return view('project.edit', [
            'user' => $user,
            'project' => $project,
            'assistants' => $assistants,
        ]);       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $rules = [
            'name' => 'required|max:32|min:6|unique:projects,name,'.$id,
            'description' => 'required|min:6'
        ];

        $this->validate($request, $rules);

        $user = Auth::user();
        $project = Project::find($id);

        if($request->has('domens_delete')){
            $domen_id = $request->input('domens_delete');

            $domen_del = $user->domens()->whereNotIn('id', $domen_id)->get();

            $arr_domen_id = [];

            foreach($domen_id as $id){
                $domen = Domen::find($id);

                if( !count( $domen->projects()->where('project_id', $project->id)->get() ) ){
                    $log = new Log([
                        'text' => 'Домен : '.$domen->name.' добавлен в проект : '.$project->name,
                        'user_id' => $user->id
                    ]);

                    $domen->logs()->save($log);
                    $project->logs()->save($log);

                    $arr_domen_id[] = $id; 
                }
            }

            if(!empty($arr_domen_id)){
                $project->domens()->attach($arr_domen_id);                
            }

            $arr_domen_id_del = [];

            foreach($domen_del as $domen){

                if( count( $domen->projects()->where('project_id', $project->id)->get() ) ){
                    $log = new Log([
                        'text' => 'Домен : '.$domen->name.' удален из проекта : '.$project->name,
                        'user_id' => $user->id
                    ]);
                    $domen->logs()->save($log);
                    $project->logs()->save($log);

                    $arr_domen_id_del[] = $domen->id;
                }
            }

            if(!empty($arr_domen_id_del)){
                $project->domens()->detach($arr_domen_id_del); 
            }

        } else {
            $domens = $user->domens;
            $arr_domen_id_del = [];

            foreach($domens as $domen){
                if( count( $domen->projects()->where('project_id', $project->id)->get() ) ){

                    $arr_domen_id_del[] = $domen->id;

                    $log = new Log([
                        'text' => 'Домен : '.$domen->name.' удален из проекта : '.$project->name,
                        'user_id' => $user->id
                    ]);

                    $domen->logs()->save($log);
                    $project->logs()->save($log);
                }
            }

            if(!empty($arr_domen_id_del)){
                $project->domens()->detach($arr_domen_id_del);
            }
        }

        if($request->has('users_delete')){

            $assistants = $request->input('users_delete');

            $assist_del = $project->assistants()->whereNotIn('user_id', $assistants)->get();

            $assistants_id = [];
            
            foreach($assistants as $id){
                $assistant = User::find($id);
                if( !count( $assistant->projects()->where('project_id', $project->id)->get() ) ){

                    Mail::queue('emails.mail', array('project' => $project), function($message) use($assistant)
                    {
                        $message->to($assistant->email, $assistant->name)->subject('Added project');
                    });

                    $log = new Log([
                        'text' => 'Ассистент : '.$assistant->name.' добавлен в проект : '.$project->name,
                        'user_id' => $user->id
                    ]);

                    $project->logs()->save($log);

                    $assistants_id[] = $id;
                }

            }
            if(!empty($assistants_id)){
                $project->assistants()->attach($assistants_id);
            }
            
            $assistants_id_del = [];

            foreach($assist_del as $assistant){
                if($assistant->id == $user->id){
                    continue;
                }

                $log = new Log([
                    'text' => 'Ассистент : '.$assistant->name.' удален из  проекта : '.$project->name,
                    'user_id' => $user->id
                ]);

                $project->logs()->save($log);

                $assistants_id_del[] = $assistant->id;
            }

            if(!empty($assistants_id_del)){
                $project->assistants()->detach($assistants_id_del);              
            }

        } else {
            $assistants = $project->assistants()->where('user_id', '!=', $user->id)->get();

            $assistants_id_del = [];

            if(count($assistants)){
                foreach($assistants as $assistant){
                    $log = new Log([
                        'text' => 'Ассистент : '.$assistant->name.' удален из  проекта : '.$project->name,
                        'user_id' => $user->id
                    ]);

                    $project->logs()->save($log);

                    $assistants_id_del[] = $assistant->id;
                }  
            }

            if(!empty($assistants_id_del)){
                $project->assistants()->detach($assistants_id_del);
            }
        }

        $project->name = $request->name;
        $project->description = $request->description;

        $project->save();

        Session::flash('successfully', 'Проект успешно отредактирован!');
        return redirect()->route('managment');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $project = Project::find($id);

        if($user->id != $project->user->id){
            Session::flash('error', ' Недостаточно прав для удаления!');

            return redirect()->route('managment');
        }
        
        $assistants = $project->assistants;
        $domens = $project->domens;

        if(count($assistants)){
            foreach($assistants as $assistant){
                $log = new Log([
                    'text' => 'Ассистент : '.$assistant->name.' удален из  проекта : '.$project->name,
                    'user_id' => $user->id
                ]);

                $project->logs()->save($log);

                $project->assistants()->detach($assistant->id);
            }
        }

        if(count($domens)){
            foreach($domens as $domen){
                $log = new Log([
                    'text' => 'Домен : '.$domen->name.' удален из проекта : '.$project->name,
                    'user_id' => $user->id
                ]);

                $domen->logs()->save($log);
                $project->logs()->save($log);

                $project->domens()->detach($domen->id);
            }
        }

        $log = new Log([
            'text' => 'Проект : '.$project->name.' удален',
            'user_id' => $user->id
        ]);

        $project->logs()->save($log);

        Project::destroy($id);

        Session::flash('successfully', ' Проект удален!');
        return redirect()->route('managment');
    }
}
