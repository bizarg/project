<?php

namespace App\Http\Controllers;

use App\Info;
use App\Node;
use App\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

/**
 * Class MonitorController
 * @package App\Http\Controllers
 */
class MonitorController extends Controller
{
    /**
     * Show all sites
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $sites = $user->sites;
        return view('monitoring.sites', compact('sites'));
    }

    /**
     * Form to add new site to monitor
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add()
    {
        $nodes = Node::where('status', 'active')->orderBy('country')->orderBy('city')->orderBy('dc')->get();
        return view('monitoring.add', compact('nodes'));
    }

    /**
     * Store site
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'url' => 'required|url',
            'node_id' => 'required|exists:nodes,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $parsed_url = parse_url($request->url);
        $domain = $parsed_url['host'];

        $request->request->add(['domain' => $domain]);
        $request->request->add(['user_id' => $user->id]);

        if ($request->has('id')) {
            $site = Site::findOrfail($request->id);
            $site->update($request->all());
        } else {
            Site::create($request->all());
        }
        return redirect()->to('/monitoring');
    }

    /**
     * View site history
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id)
    {
        $user = Auth::user();
        $site = Site::where('user_id', $user->id)->where('id', $id)->firstOrFail();
        $nodes = Node::where('status', 'active')->orderBy('country')->orderBy('city')->orderBy('dc')->get();
        $infos = Info::where('site_id', $site->id)->newest()->get();

        $location = geoip(gethostbyname($site->url));
        $siteNode = Node::where('aiso', 'like', '%' . $location->iso_code . '%')->first();


//        $infos2 = Info::where('site_id', 4)->newest()->get();

        return view('monitoring.view', compact('site', 'nodes', 'infos', 'siteNode'));
    }

    /**
     * Delete site
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $user = Auth::user();
        Site::where('user_id', $user->id)->where('id', $id)->delete();
        return redirect()->back();
    }

    public function compare(Request $request)
    {

        $rules = [
            'from_id' => 'required|exists:nodes,id',
            'to_id' => 'required|exists:nodes,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 500);
        }

        //$nodeFrom = Node::find($request->from_id);
        //$nodeTo = Node::find($request->to_id);
        $fomDate = Carbon::now()->subWeek();

        $data = DB::connection('pgsql')
            ->select(
                'SELECT speed, created_at   FROM  data WHERE agent_id = :fromId and rel = :toId and created_at > :fomDate  ORDER BY id ASC  ',
                [
                    'fromId' => $request->from_id,
                    'toId' => $request->to_id,
                    'fomDate' => $fomDate
                ]

            );
        //$infos = Info::select('time', 'created_at', 'error')->where('site_id', $request->from_id)->newest()->get();

        return response()->json($data);


    }
}
