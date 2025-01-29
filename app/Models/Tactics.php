<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tactics extends Model
{
    use HasFactory;
    protected $primaryKey = 'tac3LVID';
    public function goal()
    {
        return $this->belongsTo(Goals::class, 'goal3LVID','goal3LVID');
    }
    public function KPIMain()
    {
        return $this->belongsToMany(KPIMains::class, 'k_p_i_main_map_tactics', 'tac3LVID', 'KPIMain3LVID');
    }
    
    
}
