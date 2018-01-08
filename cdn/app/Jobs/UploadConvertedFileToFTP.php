<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Storage;

class UploadConvertedFileToFTP implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $file;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //load to ftp;
        config(['filesystems.disks.ftp' => [
            'driver' => 'ftp',
            'host' => $this->file->ftp->adr,
            'username' => $this->file->ftp->login,
            'password' => decrypt($this->file->ftp->password),
            'port' => is_null($this->file->ftp->port) ? '21' : $this->file->ftp->port,
        ]]);

        $date = date("Y-m-d-H-i-s");

        $storage = Storage::disk('ftp');
        Log::error($this->file->file->name);

        if ($this->file->output_format == 'm3u8') {
            $files = Storage::files('files/' . $this->file->path_hash);
            $path = $this->file->ftp->dir . $this->file->file->name . '.' . $this->file->output_format . '[' . $date . ']';
            $storage->makeDirectory($path);
            if ($storage->exists($path)) {
                foreach ($files as $file) {
                    $storage->put($path . '/' . preg_replace('/^.*\//ui', '', $file), Storage::get($file));
                }
                $this->file->ftp_status = 2; // uploaded to ftp
                $this->file->save();
            } else {
                $this->file->ftp_status = 3; // uploading to ftp failed
                $this->file->save();
            }
        } else {
            //$path = $this->file->ftp->dir . $this->file->file->name  . '[' . $date . ']' . '.' . $this->file->output_format;
            $path = $this->file->ftp->dir . $this->file->file->name . '_' . time() . '.' . $this->file->output_format;
            Log::error($path);
            $file = Storage::get('files/' . $this->file->path_hash . '/' . $this->file->output_file_name);
            $status = $storage->put($path, $file);

            if ($status) {
                if ($storage->exists($path)) {
                    $this->file->ftp_status = 2; // uploaded to ftp
                    $this->file->save();
                } else {
                    $this->file->ftp_status = 3; // uploading to ftp failed
                    $this->file->save();
                }
            }
        }
    }
}
