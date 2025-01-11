<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tactics extends Model
{
    use HasFactory;
    protected $primaryKey = 'tacID';
    public function goal()
    {
        return $this->belongsTo(Goals::class, 'goalID','goalID');
    }
    public function KPIMain()
    {
        return $this->belongsToMany(KPIMains::class, 'k_p_i_main_map_tactics', 'tacID', 'KPIMainID');
    }
    
    
}
