<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funds extends Model
{
    use HasFactory;
    public function uniplan()
    {
        return $this->belongsTo(UniPlan::class, 'planID','planID');
    }
}
