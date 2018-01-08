<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Illuminate\Support\Facades\Storage;
use Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class FilesController extends Controller
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
        $user = Auth::user();

        $count_files = count($user->files); //кол-во уже загруженых файлов
        $count_downloaded = $user->quantity; //ограничение кол-ва файлов для загрузки

        $files = $request->file('file');
		Log::error($request->all());

        $mimeType = ["audio/mp3", "audio/mp4", "video/x-msvideo", "video/x-matroska", "video/x-flv",
            "video/webm","audio/mpeg", "video/mp4", "video/x-msvideo", "video/msvideo", "video/avi"];
        $arr = [];

        foreach($files as $file){

            if(!in_array($file->getClientMimeType(), $mimeType)){
                $arr[] = ['error' => 'text'];
                return $arr;
            } 

            if($count_downloaded <= $count_files){
                $arr[] = ['error' => 'text'];
                return $arr;
            }

            $fileExist = File::where(function ($query) use ($file) {
                $query->where('user_id', Auth::user()->id)
                    ->where('name', $file->getClientOriginalName());
            })->orWhere(function ($query) use ($file) {
                $query->where('user_id', Auth::user()->id)
                    ->where('size', $file->getClientSize());
            })->get();

            if(!$fileExist->isEmpty()) {
                return response(['file' => 'file already exist'], 422);
            }

            $saveFile = new File;

            $saveFile->name = preg_replace('/\.(.){2,4}$/ui', '', $file->getClientOriginalName());
            $saveFile->local_name = md5('salt'.$file->getClientOriginalName().date("-Y-m-d-H-i-s"));
            $saveFile->size = $file->getClientSize();
            $saveFile->format = $file->getClientOriginalExtension();
            $saveFile->user_id = Auth::user()->id;
            $path = $file->storeAs('files', $saveFile->local_name . '.' . $saveFile->format);
            $saveFile->path = $path;

            if($saveFile->save()){
                $arr[] = ['id' => $saveFile->id, 'name' => $saveFile->name];
            }else {
                return 'error';
            }

            $count_files++;
        }


        return $arr;
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
        //todo удаление и сконвертированных файлов и папок при удалении файла
        $file = File::where('user_id', Auth::user()->id)->findOrFail($id);
        Storage::delete('files/' . $file->local_name . '.' . $file->format);

        if($file->delete()) {
            return back()->with('success', 'File deleted');
        } else {
            return back()->with('fail', 'Error deleting file');
        }
    }

    /**
     * Mass delete files.
     *
     * @author Ruslan Ivanov
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function massDestroy(Request $request)
    {
        $this->validate($request, [
            'uploaded_files.*' => [
                'integer',
                Rule::exists('files', 'id')->where(function ($query) {
                    $query->where('user_id', Auth::user()->id);
                })
            ],
        ]);

        if(empty($request->uploaded_files)) {
            return back()->with('fail', 'No selected files for deleting');
        }

        $files = File::where('user_id', Auth::user()->id)->whereIn('id', $request->uploaded_files)->get();

        foreach ($files as $file) {
            Storage::delete('files/' . $file->local_name . '.' . $file->format);
        }

        $query = File::where('user_id', Auth::user()->id)->whereIn('id', $request->uploaded_files);

        if($query->delete()) {
            return back()->with('success', 'Selected files deleted');
        } else {
            return back()->with('fail', 'Error deleting selected files');
        }
    }
}
