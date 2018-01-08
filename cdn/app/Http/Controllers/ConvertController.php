<?php

namespace App\Http\Controllers;

use App\Jobs\UploadConvertedFileToFTP;
use Illuminate\Http\Request;
use App\File;
use App\Convert;
use GuzzleHttp\Client;
use Auth;
use Illuminate\Validation\Rule;
use FTP;
use Storage;

class ConvertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'output_format'       => 'required|in:mp4,flv,m3u8',
            'bitrate'             => 'required_if:output_format,m3u8,mp4|in:240k,320k,480k,640k,1200k',
            'output_resolution.*' => 'required_if:output_format,m3u8|in:360p,480p,720p,1080p',
            'resolution'          => 'required_if:output_format,mp4,flv|in:640x360,720x480,854x480,1280x720,1920x1080',
            'audio_bitrate'       => 'in:32,128,160,192',
            'frame_rate'          => 'in:10,29,40,60',
            'file_id'             => 'required|integer|exists:files,id',
            'ftp'                 => [
                'integer',
                Rule::exists('ftp_settings', 'id')->where(function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
            ],
        ]);

        $file = File::where('user_id', Auth::user()->id)->find($request->file_id);
        if(is_null($file)) {
           return response('This file is not your or not found', 422);
        }

        $path_hash = md5(mt_rand(0, 99) . 'salt' . $file->name . date("-Y-m-d-H-i-s"));

        $params = [
            'user'          => Auth::user()->id, // 'max',
            'file'          => $file->local_name . '.' . $file->format, // 'test3.mp4',
            'audio_bitrate' => $request->audio_bitrate,
            'frame_rate'    => $request->frame_rate,
            'output_format' => $request->output_format,
            'path_hash'     => $path_hash,
        ];
        $request->output_format == 'm3u8' ? $params['output_resolutions'] = implode(';', $request->output_resolution) : $params['resolution'] = $request->resolution;

        if($request->bitrate) $params['video_bitrate'] = $request->bitrate;

        $response = null;

        try {
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => config('converter.uri'),
                // You can set any number of default request options.
                //'timeout'  => 3.0,
                'verify'   => false,
            ]);

            $response = $client->post(
                '/v2/convert',
                [
                    'form_params' => $params
                ]
            );
        } catch (\Exception $e) {
            // connection problem, send email
            return response([
                'name' => $file->name,
                'msg'  => 'Error! No sended to convert, error in converter server'
            ], 422);
        }

        if($response->getStatusCode() == 200) {
            $body = json_decode($response->getBody());

            $convert_file = new Convert();
            $convert_file->user_id = Auth::user()->id;
            $convert_file->uuid = $body->job_id;
            $convert_file->file_id = $request->file_id;
            $convert_file->output_format = $request->output_format;
            $convert_file->status = 1; // worked
            $convert_file->ftp_status = 0;
            if(isset($request->ftp)) {
                $convert_file->ftp_setting_id = $request->ftp;
            }
            $convert_file->path_hash = $path_hash;
            $convert_file->save();

            return response([
                'name' => $file->name,
                'msg'  => 'Success! Sended to convert.',
                'output_format' => $request->output_format,
                'id' => $convert_file->id
            ]);
        }

        return response([
            'name' => $file->name,
            'output_format' => $request->output_format,
            'msg'  => 'Error! No sended to convert, error in converter server'
        ], 422);
    }

    /**
     * Display the specified resource.
     *
     * @author Ruslan Ivanov
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $convert_file = Convert::where('user_id', Auth::user()->id)->with('file')->findOrFail($id);

        if(is_null($convert_file)) {
            return response('not find file', 422);
        }

        if($convert_file->status == 3 or $convert_file->status == 2) {
            return [
                'progress' => 100,
                'status'   => $convert_file->status,
                'name'     => $convert_file->file->name,
                'uuid'     => $convert_file->uuid,
                'id'       => $convert_file->id
            ]; //$convert_file->toArray();
        }

        try {
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => config('converter.uri'),
                // You can set any number of default request options.
                //'timeout'  => 3.0,
                'verify' => false,
            ]);

            $response = $client->get(
                '/v2/job',
                [
                    'form_params' => [
                        'job_id' => $convert_file->uuid
                    ]
                ]
            );
        } catch (\Exception $e) {
            // connection problem, send email
            return response('Error! I can not connect to the server', 422);
        }

        if($response->getStatusCode() == 200) {
            $body = json_decode($response->getBody());
            // $body->status queued

            $convert_file = Convert::with('file')->findOrFail($id);

            if ($body->status == 'failed') {
                $convert_file->status = 3;
            } else if($body->status == 'working') {
                $convert_file->output_format = isset($body->output_format) ? $body->output_format : null;
                $convert_file->output_file_name = isset($body->output_file_name ) ? $body->output_file_name : null;
                $convert_file->progress = isset($body->progress) ? $body->progress * 100 : null;
                $convert_file->status = 1;
                // $convert_file->time = date('Y-m-d h:i:s',$body->time);
                $convert_file->output_format = isset($body->output_format) ? $body->output_format : null;
            } else if($body->status == 'completed') {
                $convert_file->status = 2;
                $convert_file->output_format = isset($body->output_format) ? $body->output_format : null;
                $convert_file->output_file_name = isset($body->output_file_name ) ? $body->output_file_name : null;
                $convert_file->progress = isset($body->progress) ? 100 : null;
                $convert_file->output_format = isset($body->output_format) ? $body->output_format : null;
                if((int)$convert_file->ftp_setting_id > 0) {
                    dispatch(new UploadConvertedFileToFTP($convert_file));
                    $convert_file->ftp_status = 1; // uploading to ftp
                }
            }

            $convert_file->save();
        }

        if($convert_file->status == 1) {
            return [
                'progress' => round($convert_file->progress, 1),
                'status'   => $convert_file->status
            ];
        } else {
            return [
                'progress'      => 100,
                'status'        => $convert_file->status,
                'ftp_status'    => $convert_file->ftp_status,
                'name'          => $convert_file->file->name,
                'output_format' => $convert_file->output_format,
                'uuid'          => $convert_file->uuid,
                'id'            => $convert_file->id
            ]; //$convert_file->toArray();
        }
        //return $convert_file->toArray();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @author Ruslan Ivanov
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author Ruslan Ivanov
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $file = Convert::where('user_id', Auth::user()->id)->with('file')->findOrFail($id);
        Storage::deleteDirectory('files/' . $file->path_hash);

        if($file->delete()) {
            return back()->with('success', 'Converted file deleted');
        } else {
            return back()->with('fail', 'Error deleting converted file');
        }
    }

    /**
     * Download converted file.
     *
     * @author Ruslan Ivanov
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $file = Convert::where('user_id', Auth::user()->id)->where('status', 2)->with('file')->findOrFail($id);

        if($file->output_format == 'm3u8') {
            $zipname = storage_path('app/files/') . $file->path_hash . '/' . $file->uuid . '.zip';

            if(!file_exists($zipname)) {
                $files = Storage::files('files/' . $file->path_hash);

                $zip = new \ZipArchive;
                if($zip->open($zipname, \ZipArchive::CREATE)) {
                    foreach ($files as $file) {
                        $zip->addFile(storage_path('app/' . $file), preg_replace('/^.*\//ui', '', $file));
                    }
                    $zip->close();
                }
            }

            if(file_exists($zipname)) {
                return response()->download($zipname, $file->file->name . '.' . $file->output_format . '.zip');
            } else {
                return back()->with('fail', 'File not found!');
            }
        }

        if(file_exists(storage_path('app/files/' . $file->path_hash . '/' . $file->output_file_name)) and !is_null($file->output_file_name)) {
            return response()->download(storage_path('app/files/' . $file->path_hash . '/' . $file->output_file_name), $file->file->name . '.' . $file->output_format);
        } else {
            return back()->with('fail', 'File not found!');
        }
    }

    /**
     * Mass delete converted files.
     *
     * @author Ruslan Ivanov
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function massDestroy(Request $request)
    {
        $this->validate($request, [
            'converted_files.*' => [
                'integer',
                Rule::exists('convert_files', 'id')->where(function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
            ],
        ]);

        if(empty($request->converted_files)) {
            return back()->with('fail', 'No selected converted files for deleting');
        }

        $files = Convert::where('user_id', Auth::user()->id)->whereIn('id', $request->converted_files)->where('status', 2)->get();

        foreach ($files as $file) {
            Storage::deleteDirectory('files/' . $file->path_hash);
        }

        $query = Convert::where('user_id', Auth::user()->id)->whereIn('id', $request->converted_files);

        if($query->delete()) {
            return back()->with('success', 'Selected converted files deleted');
        } else {
            return back()->with('fail', 'Error deleting selected converted files');
        }
    }
}
