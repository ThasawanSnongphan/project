<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostQuarters extends Model
{
    use HasFactory;
    public function exp()
    {
        return $this->belongsTo(ExpenseBadgets::class, 'expID','expID');
    }
    public function cost()
    {
        return $this->belongsTo(CostTypes::class, 'costID','costID');
    }
}
