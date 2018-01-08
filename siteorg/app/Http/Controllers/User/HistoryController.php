<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use App\Http\Requests\HistoryRequest;

class HistoryController extends Controller
{
    public function yandex_history($id)
    {
        $yandex = $this->getInTheLast30Day('App\Yandex', 'yandex', $id);

        return view('user.history.yandex', ['yandex' => $yandex, 'site_id' => $id]);
    }

    public function yandex_search(HistoryRequest $request, $id)
    {
        $yandex = $this->getForPeriod('App\Yandex', 'yandex', $request, $id);

        return view('user.history.yandex', ['yandex' => $yandex, 'site_id' => $id]);
    }

    public function screenshots_history($id)
    {
        $screenshots = $this->getInTheLast30Day('App\Screenshot', 'screenshots', $id);

        return view('user.history.screenshots', ['screenshots' => $screenshots, 'site_id' => $id]);
    }

    public function screenshots_search(HistoryRequest $request, $id)
    {
        $screenshots = $this->getForPeriod('App\Screenshots', 'screenshots', $request, $id);

        return view('user.history.screenshots', ['screenshots' => $screenshots, 'site_id' => $id]);
    }

    public function getInTheLast30Day($model, $table, $id){
        return $model::join('user_sites', $table.'.site_id', '=', 'user_sites.site_id')
            ->join('users', 'user_sites.user_id', '=', 'users.id')
            ->where($table.'.site_id', '=', $id)
            ->where('users.id', '=', Auth::user()->id)
            ->select($table.'.*')
            ->get();
    }

    public function getForPeriod($model, $table, $request, $id){
        if(!$request->has('to')) $request->to = Carbon::now();

        return $model::join('user_sites', $table.'.site_id', '=', 'user_sites.site_id')
            ->join('users', 'user_sites.user_id', '=', 'users.id')
            ->where($table.'.site_id', '=', $id)
            ->where('users.id', '=', Auth::user()->id)
            ->where($table.'.created_at', '>', $request->from)
            ->where($table.'.created_at', '<', date('Y-m-d 23:59:59',strtotime($request->to)))
            ->orderBy($table.'.created_at', 'desc')
            ->select($table.'.*')
            ->get();
    }
}
