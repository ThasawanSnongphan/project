<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEvaluation extends Model
{
    public function operating(){
        return $this->belongsTo(OperatingResults::class,'operID','operID');
    }
}
