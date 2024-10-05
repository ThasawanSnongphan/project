<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KPIMains extends Model
{
    use HasFactory;
    public function tactics()
    {
        return $this->belongsTo(Tactics::class, 'tacID','tacID');
    }
}
