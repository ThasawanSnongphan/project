<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target1Level extends Model
{
    public function strategic()
    {
        return $this->belongsTo(Strategic1Level::class, 'stra1LVID','stra1LVID');
    }
}
