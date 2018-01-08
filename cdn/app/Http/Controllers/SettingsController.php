<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\User;
use Auth;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author Ruslan Ivanov
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Setting::where( 'user_id', Auth::user()->id)->get();

        return view('settings.index', ['domains' => $domains]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @author Ruslan Ivanov
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'domain' => 'required|min:3|max:255|unique:settings',
            'link_format' => 'required|min:3|max:255',
        ]);

        // $settings = Setting::find(1);

        // if($settings->domain != $request->domain and !empty($request->domain)) $settings->domain = $request->domain;
        // if($settings->link_format != $request->link_format and !empty($request->link_format)) $settings->link_format = $request->link_format;

        $settings = new Setting([
                'domain' => $request->domain,
                'link_format' => $request->link_format,
                'user_id' => Auth::user()->id
            ]);
        $settings->save();

        $settings->shortname = 'DOMAIN_' . $settings->id;

        if($settings->save()) {
            return redirect()->route('settings.index')->with('success', 'Domain created');
        } else {
            return redirect()->back()->with('fail', 'Error');
        }
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
        $domain = Setting::findOrFail($id);

        return view('settings.edit', ['domain' => $domain]);
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
            'domain' => 'required|min:3|max:255|unique:settings,domain,'.$id,
            'link_format' => 'required|min:3|max:255',
        ]);

        $domain = Setting::findOrFail($id);

        $domain->domain =  $request->domain;
        $domain->link_format = $request->link_format;

        if($domain->save()) {
            return redirect()->route('settings.index')->with('success', 'Domain updated');
        } else {
            return redirect()->back()->with('fail', 'An error occurred while updating domain.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $domain = Setting::findOrFail($id);
        if($domain->delete() ) {
            return redirect()->back()->with('success', 'Domain deleted.');
        } else {
            return redirect()->back()->with('fail', 'An error occurred while deleting domain.');
        }
    }
}
