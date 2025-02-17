<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategic1LevelMapProject extends Model
{
    public function stra1LV()
    {
        return $this->belongsTo(Strategic1Level::class, 'stra1LVID','stra1LVID');
    }
    public function tar1LV()
    {
        return $this->belongsTo(Target1Level::class,'tar1LVID','tar1LVID');
    }
}
