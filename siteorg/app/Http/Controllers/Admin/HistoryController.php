<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use App\Http\Requests\HistoryRequest;

class HistoryController extends Controller
{
    public function yandex_history($id)
    {
        $yandex = $this->getInTheLast30Day('App\Yandex', $id);

        return view('admin.history.yandex', ['yandex' => $yandex, 'site_id' => $id]);
    }

    public function yandex_search(HistoryRequest $request, $id)
    {
        $yandex = $this->getForPeriod('App\Yandex', $request, $id);

        return view('admin.history.yandex', ['yandex' => $yandex, 'site_id' => $id]);
    }

    public function screenshots_history($id)
    {
        $screenshots = $this->getInTheLast30Day('App\Screenshot', $id);

        return view('admin.history.screenshots', ['screenshots' => $screenshots, 'site_id' => $id]);
    }

    public function screenshots_search(HistoryRequest $request, $id)
    {
        $screenshots = $this->getForPeriod('App\Screenshot', $request, $id);

        return view('admin.history.screenshots', ['screenshots' => $screenshots, 'site_id' => $id]);
    }

    public function getInTheLast30Day($model, $id){
        return $model::where('site_id', $id)
            ->where('created_at', '>', Carbon::now()->subDay(30))
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getForPeriod($model, $request, $id){
        if(!$request->has('to')) $request->to = Carbon::now();

        return $model::where('site_id', $id)
            ->where('created_at', '>', $request->from)
            ->where('created_at', '<', date('Y-m-d 23:59:59',strtotime($request->to)))
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
