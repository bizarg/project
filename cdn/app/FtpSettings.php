<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FtpSettings extends Model
{
    public $timestamps = false;

    /**
     * Get the convert files for the file.
     * @author Ruslan Ivanov
     */
    public function convertFiles()
    {
        return $this->hasMany('App\Convert', 'ftp_setting_id');
    }
}
