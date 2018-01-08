<?php

namespace App\Http\Controllers\Admin;

use App\Domain;
use App\Report;
use App\Task;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{

    public function all_tasks()
    {
        $tasks = Task::orderBy('id', 'desk')->paginate(20);
        foreach ($tasks as &$task) {
            $task->res_urls = json_decode($task->res_urls);
        }
        return view('admin.tasks', ['tasks' => $tasks]);
    }

    /**
     * список задачь для домена
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function domain_tasks($id)
    {
        $domain = Domain::findOrFail($id);
        $tasks = Task::where('domain_id', $domain->id)->orderBy('id', 'desc')->paginate(20);
        foreach ($tasks as &$task) {
            $task->res_urls = json_decode($task->res_urls);
        }
        return view('admin.tasks', ['tasks' => $tasks]);
    }


    /**
     * меняет стус задачи на нью и удаляет репорты
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset_task($id)
    {
        $task = Task::findOrFail($id);
        $task->status = 'new';
        $task->save();
        Report::where('task_id', $task->id)->delete();
        return redirect()->to('/admin/tasks');
    }

    /**
     * удаляет задачу и ее репорты
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete_task($id)
    {
        $task = Task::findOrFail($id);
        Report::where('task_id', $task->id)->delete();
        $task->delete();
        return redirect()->to('/admin/tasks');
    }


    /**
     *
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail_task($id)
    {
        $task = Task::findOrFail($id);
        $reports = Report::where('task_id', $task->id)->get();
        foreach ($reports as &$report) {
            $report->codes_requests = json_decode($report->codes_requests);
        }
        return view('admin.task_detail', ['task' => $task, 'reports' => $reports]);
    }
}
