<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIMains extends Model
{
    use HasFactory;
    protected $primaryKey = 'KPIMain3LVID';
    public function goal()
    {
        return $this->belongsTo(Goals::class, 'goal3LVID','goal3LVID');
    }

    public function director()
    {
        return $this->belongsTo(Users::class, 'directorID','userID');
    }

    public function recorder()
    {
        return $this->belongsTo(Users::class, 'recorderID','userID');
    }

    public function MapTactics() {
        return $this->hasMany(KPIMainMapTactics::class, 'KPIMain3LVID');
    }
}
