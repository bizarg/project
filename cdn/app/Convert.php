<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Convert extends Model
{
    protected $table = 'convert_files';

    /**
     * Get the file for the convert file.
     * @author Ruslan Ivanov
     */
    public function file()
    {
        return $this->belongsTo('App\File');
    }

    /**
     * Get the upload ftp settings for the convert file.
     * @author Ruslan Ivanov
     */
    public function ftp()
    {
        return $this->belongsTo('App\FtpSettings', 'ftp_setting_id');
    }
}
