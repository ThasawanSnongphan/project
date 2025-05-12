<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategic2Level extends Model
{
    protected $primaryKey = 'stra2LVID';
    public function year()
    {
        return $this->belongsTo(Year::class, 'yearID','yearID');
    }

    public function SFA() {
        return $this->hasMany(StrategicIssues2Level::class, 'stra2LVID');
    }
}
