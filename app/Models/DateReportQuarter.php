<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateReportQuarter extends Model
{
    protected $primaryKey = 'drqID';
    // protected $casts = [
    //     'startDate' => 'date',
    //     'endDate' => 'date'
    // ];
    public function year(){
        return $this->belongsTo(Year::class,'yearID','yearID');
    }

    public function quarter(){
        return $this->belongsTo(Quarters::class,'quarID','quarID');
    }
}
