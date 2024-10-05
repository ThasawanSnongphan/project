<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
    use HasFactory;
    public function SFA()
    {
        return $this->belongsTo(StrategicIssues::class, 'SFAID','SFAID');
    }
}
