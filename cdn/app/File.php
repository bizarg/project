<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Get the user for the file.
     * @author Ruslan Ivanov
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the convert files for the file.
     * @author Ruslan Ivanov
     */
    public function convertFiles()
    {
        return $this->hasMany('App\Convert');
    }
}
