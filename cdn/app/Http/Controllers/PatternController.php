<?php

//namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Template;
use Auth;
//use App\File;
use DB;


class PatternController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);

        $res = Template::create([
            'user_id'   => Auth::user()->id,
            'code'      => $request->code
        ]);

        if($res) return redirect()->back()->with('success', 'Code was insert to database');
    }

    public function generate(Request $request)
    {
        $file = DB::table('convert_files')->where('id', $request->id)->first();

        $pattern = Template::where('user_id', Auth::user()->id)->first();

        if(empty($pattern)) $pattern['code'] = 'FILE';

        $patterns = array();
        $patterns[0] = '/FILE/';
//        $patterns[1] = '/DOMAIN_\d*/';
        $replacements = array();
        $replacements[0] = $file->path_hash;

        $res = preg_replace($patterns, $replacements, $pattern['code']);



        return json_encode($res);
    }
}
