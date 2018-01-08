<?php

namespace App\Http\Controllers;

use App\Http\Requests\FtpSettingsRequest;
use Auth;
use Storage;
use App\FtpSettings;

class FtpSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author Ruslan Ivanov
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ftps = FtpSettings::where('user_id', Auth::user()->id)->get();
        
        return view('ftp-settings.index', compact('ftps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @author Ruslan Ivanov
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ftp-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @author Ruslan Ivanov
     * @param  FtpSettingsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FtpSettingsRequest $request)
    {
        config(['filesystems.disks.ftp' => [
            'driver'   => 'ftp',
            'host'     => $request->address,
            'username' => $request->login,
            'password' => $request->password,
            'port' => empty($request->port) ? '21' : $request->port,
        ]]);

        $storage = Storage::disk('ftp');

        try {
            $request->flash();
            // get directories list
            $storage->directories();
            // check exist upload directory
            if(!empty($request->dir)) {
                if(!$storage->exists($request->dir)) {
                    return redirect()->back()->withErrors([
                        'dir' => 'Enter exist directory path',
                    ])->with('fail', 'No exists directory - ' . $request->dir);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'login' => 'Check login',
                'password' => 'Check password',
                'address' => 'Check host IP',
            ])->with('fail', $e->getMessage());
        }
        // end;

        $ftps = new FtpSettings;
        $ftps->name = $request->name;
        $ftps->adr = $request->address;
        $ftps->port = empty($request->port) ? null : $request->port;
        $ftps->dir = empty($request->dir) ? null : $request->dir;
        $ftps->login = $request->login;
        $ftps->password = encrypt($request->password);
        $ftps->user_id = Auth::user()->id;

        if($ftps->save()) {
            return redirect()->route('ftp-settings.index')->with('success', 'Account added.');
        } else {
            return redirect()->back()->with('fail', 'An error occurred while adding ftp account.');
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
     * @author Ruslan Ivanov
     * @param  object  $ftps
     * @return \Illuminate\Http\Response
     */
    public function edit($ftps)
    {
        return view('ftp-settings.edit', ['acc' => $ftps]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @author Ruslan Ivanov
     * @param  FtpSettingsRequest  $request
     * @param  object $ftps
     * @return \Illuminate\Http\Response
     */
    public function update(FtpSettingsRequest $request, $ftps)
    {
        config(['filesystems.disks.ftp' => [
            'driver'   => 'ftp',
            'host'     => $request->address,
            'username' => $request->login,
            'password' => $request->password,
            'port' => empty($request->port) ? '21' : $request->port,
        ]]);

        $storage = Storage::disk('ftp');

        try {
            $request->flash();
            // get directories list
            $storage->directories();
            // check exist upload directory
            if(!empty($request->dir)) {
                if(!$storage->exists($request->dir)) {
                    return redirect()->back()->withErrors([
                        'dir' => 'Enter exist directory path',
                    ])->with('fail', 'No exists directory - ' . $request->dir);
                }
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'login' => 'Check login',
                'password' => 'Check password',
                'address' => 'Check host IP',
            ])->with('fail', $e->getMessage());
        }
        // end;

        $ftps->name = $request->name;
        $ftps->adr = $request->address;
        $ftps->port = empty($request->port) ? null : $request->port;
        $ftps->dir = empty($request->dir) ? null : $request->dir;
        $ftps->login = $request->login;
        $ftps->password = $request->password != '******' ? encrypt($request->password) : $ftps->password;

        if($ftps->save()) {
            return redirect()->route('ftp-settings.index')->with('success', 'Account updated.');
        } else {
            return redirect()->back()->with('fail', 'An error occurred while updating ftp account.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author Ruslan Ivanov
     * @param  object $ftps
     * @return \Illuminate\Http\Response
     */
    public function destroy($ftps)
    {
        if($ftps->delete()) {
            return redirect()->route('ftp-settings.index')->with('success', 'Account deleted.');
        } else {
            return redirect()->back()->with('fail', 'An error occurred while deleting ftp account.');
        }
    }
}
