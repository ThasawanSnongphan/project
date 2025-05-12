<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Strategic1Level extends Model
{
    protected $primaryKey = 'stra1LVID';
    public function year()
    {
        return $this->belongsTo(Year::class, 'yearID','yearID');
    }

    public function Target() {
        return $this->hasMany(Target1Level::class, 'stra1LVID');
    }
}
