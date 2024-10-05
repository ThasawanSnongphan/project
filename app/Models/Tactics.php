<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tactics extends Model
{
    use HasFactory;
    public function goal()
    {
        return $this->belongsTo(Goals::class, 'goalID','goalID');
    }
}
