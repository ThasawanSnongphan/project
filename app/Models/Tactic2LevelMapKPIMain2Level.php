<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tactic2LevelMapKPIMain2Level extends Model
{
    public function tactics()
    {
        return $this->belongsToMany(Tactic2Level::class, 'tactic2_level_map_k_p_i_main2_levels', 'KPIMain2LVID', 'tac2LVID');
    }
}
