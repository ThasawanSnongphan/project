<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KPIMainMapProjects extends Model
{
    protected $fillable = ['KPIMain3LVID', 'proID'];
    public function projects()
    {
        return $this->belongsToMany(Projects::class, 'k_p_i_main_map_projects', 'KPIMain3LVID', 'proID');
    }
    public function KPI()
    {
        return $this->belongsTo(KPIMains::class, 'KPIMain3LVID','KPIMain3LVID');
    }
}
