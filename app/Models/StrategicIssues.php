<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrategicIssues extends Model
{
    protected $primaryKey = 'SFA3LVID';
    use HasFactory;
    public function strategic()
    {
        return $this->belongsTo(Strategic3Level::class, 'stra3LVID','stra3LVID');
    }

    public function Goal() {
        return $this->hasMany(Goals::class, 'SFA3LVID');
    }
}
