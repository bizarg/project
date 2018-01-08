<?php

namespace App\Http\Controllers;

use App\FtpSettings;
use App\File;
use App\Convert;
use App\Resolution;
use App\Bitrate;
use Auth;


class PanelController extends Controller
{
    /**
     * Display converter home panel.
     *
     * @author Ruslan Ivanov
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = null;
        $convert_files = null;
        $ftps = [];

        $resolutions = Resolution::orderBy('weight')->get();
        $bitrates = Bitrate::all();

        if(Auth::check()) {

            $files = File::where('user_id', Auth::user()->id)->get();
            $convert_files = Convert::where('user_id', Auth::user()->id)->with('file')->get();

            if(!$convert_files->isEmpty()) {
                $ctrl = new ConvertController();
                foreach ($convert_files as $file) {
                    $ctrl->show($file->id);
                }
            }

            $ftps = FtpSettings::where('user_id', Auth::user()->id)->get();

        }

        return view('index', compact('files', 'convert_files', 'ftps', 'resolutions', 'bitrates'));
    }
}
