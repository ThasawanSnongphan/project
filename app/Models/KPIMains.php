<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIMains extends Model
{
    use HasFactory;
    protected $primaryKey = 'KPIMainID';
    public function goal()
    {
        return $this->belongsTo(Goals::class, 'goalID','goalID');
    }
}
