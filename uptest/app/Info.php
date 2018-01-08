<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    public function getTimeAttribute($value)
    {
        return round(($value / 1000000000), 3);
    }

    public function color()
    {

        if ($this->time <= 1) {
            return 'rgb(0, 255, 0)';
        } elseif ($this->time > 1 && $this->time <= 2) {

            return 'rgb(255, 255, 0)';
        } elseif ($this->time > 2 && $this->time <= 3) {
            return 'rgb(255, 0, 0)';
        } else {
            return 'rgb(0, 0, 0)';
        }

    }

    public function scopeNewest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}
