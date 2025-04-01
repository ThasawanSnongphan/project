<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportQuarters extends Model
{
    protected $primaryKey = 'reportID';
    public function project(){
        return $this->belongsTo(Projects::class,'proID','proID');
    }
    public function user(){
        return $this->belongsTo(User::class,'userID','userID');
    }
}
