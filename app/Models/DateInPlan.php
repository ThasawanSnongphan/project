<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateInPlan extends Model
{
    public function year(){
        return $this->belongsTo(Year::class,'yearID','yearID');
    }
}
