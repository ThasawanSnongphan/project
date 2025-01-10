<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KPIMainMapTactics extends Model
{
    //
    public function tactics()
    {
        return $this->belongsToMany(Tactics::class, 'k_p_i_main_map_tactics', 'KPIMainID', 'tacID');
    }
}
