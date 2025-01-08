<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Strategics extends Model
{
    use HasFactory;
    public function year()
    {
        return $this->belongsTo(Year::class, 'yearID','yearID');
    }

    // public function projects()
    // {
    //     return $this->belongsToMany(Projects::class, 'strategic_maps', 'straID', 'proID');
    // }


}
