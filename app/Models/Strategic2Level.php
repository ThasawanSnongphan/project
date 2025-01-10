<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategic2Level extends Model
{
    public function year()
    {
        return $this->belongsTo(Year::class, 'yearID','yearID');
    }
}
