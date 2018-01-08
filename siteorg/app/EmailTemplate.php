<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EmailTemplate extends Model
{
    protected $table = 'email_templates';

    public function type()
    {
        return $this->hasOne('App\EmailType', 'id', 'type_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeOk($query)
    {
        return $query->where('type', 'ok');
    }

    public function scopeProblem($query)
    {
        return $query->where('type', 'problem');
    }

    public function parseText($data)
    {
        $parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;

            if (isset($data[$index])) {
                return $data[$index];
            } else {
                Log::warning("Shortcode {$shortCode} not found in template id {$this->id}");
                return "";

                //throw new Exception("Shortcode {$shortCode} not found in template id {$this->id}", 1);
            }

        }, $this->text);

        return $parsed;
    }

    public function parseHtml($data)
    {
        $parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;

            if (isset($data[$index])) {
                return $data[$index];
            } else {
                Log::warning("Shortcode {$shortCode} not found in template id {$this->id}");
                return "";

                //throw new Exception("Shortcode {$shortCode} not found in template id {$this->id}", 1);
            }

        }, $this->html);

        return $parsed;
    }
}
