<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIProjects extends Model
{
    use HasFactory;
    protected $primaryKey = 'KPIProID';
    public function count()
    {
        return $this->belongsTo(CountKPIProjects::class, 'countKPIProID','countKPIProID');
    }
}
