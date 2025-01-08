<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrategicIssues extends Model
{
    use HasFactory;
    public function strategic()
    {
        return $this->belongsTo(Strategics::class, 'straID','straID');
    }
}
