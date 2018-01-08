<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use Auth;
use DB;
use App\Setting;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::where('user_id', Auth::user()->id)->get();

        return view('template.index', ['templates' => $templates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $res = Template::create([
            'user_id'   => Auth::user()->id,
            'code'      => $request->code
        ]);

        if($res) return redirect()->route('templates.index')->with('success', 'Code was insert to database');

        return redirect()->back()->with('fail', 'Template was not insert to database');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $template = Template::findOrFail($id);

        return view('template.edit', ['template' => $template]);
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
        $this->validate($request, [
            'code' => 'required'
        ]);

        $template = Template::find($id);

        $res = $template->update([
            'user_id'   => Auth::user()->id,
            'code'      => $request->code
        ]);

        if($res) return redirect()->route('templates.index')->with('success', 'Template was updated');

        return redirect()->back()->with('fail', 'Template was not update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $template = Template::findOrFail($id);

        if($template->delete()) return redirect()->route('templates.index')->with('success', 'Template was deleted');

        return redirect()->back()->with('fail', 'Template was not deleted');
    }

    public function active($id)
    {

        $template = Template::findOrFail($id);

        $templates = Template::where('user_id', Auth::user()->id)->get();

        foreach($templates as $temp){
            $temp->active = 0;
            $temp->save();
        }

        $template->active = !$template->active;
        $template->save();

        return redirect()->route('templates.index')->with('success', 'Status edited');
    }

    public function generate(Request $request)
    {
//        $file = DB::table('convert_files')->where('id', $request->id)->first();
        $file = DB::table('files')
            ->join('convert_files', 'files.id', '=', 'convert_files.file_id')
            ->where('convert_files.id', '=', $request->id)
            ->first();

//        dd($file);
        $subject = Template::where('user_id', Auth::user()->id)->where('active', 1)->first();

        if(empty($subject)) $subject['code'] = 'FILE';

        $domain = [];
        $result = preg_match('/DOMAIN_\d*/', $subject['code'], $domain);
        if($result) $domainName = Setting::where('shortname', $domain[0])->first();

        $patterns = array();
        $replacements = array();

        $patterns[0] = '/FILE/';
        $replacements[0] = $file->name . '.' . $file->format;

        if(!empty($domainName)){
            $patterns[1] = '/DOMAIN_\d*/';
            $replacements[1] = $domainName->link_format;
        }

        $res = preg_replace($patterns, $replacements, $subject['code']);



        return json_encode($res);
    }
}
