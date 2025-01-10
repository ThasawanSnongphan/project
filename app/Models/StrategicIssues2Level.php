<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrategicIssues2Level extends Model
{
    public function strategic()
    {
        return $this->belongsTo(Strategic2Level::class, 'stra2LVID','stra2LVID');
    }
}
