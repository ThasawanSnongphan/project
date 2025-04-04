<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectEvaluation extends Model
{
    public function operating(){
        return $this->belongsTo(OperatingResults::class,'operID','operID');
    }

    public function project(){
        return $this->belongsTo(Projects::class,'proID','proID');
    }

    public function user(){
        return $this->belongsTo(User::class,'userID','userID');
    }
}
