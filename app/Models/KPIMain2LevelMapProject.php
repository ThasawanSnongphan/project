<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KPIMain2LevelMapProject extends Model
{
    public function KPI()
    {
        return $this->belongsTo(KPIMain2Level::class, 'KPIMain2LVID','KPIMain2LVID');
    }
}
